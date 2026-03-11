<?php

namespace App\Http\Controllers\Admin;

use App\Events\OrderStatusUpdated;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * List all orders with filters.
     */
    public function index(): View
    {
        $orders = Order::with('items', 'user')
            ->when(request('status'), function ($query, $status) {
                $query->where('status', $status);
            })
            ->when(request('payment_status'), function ($query, $paymentStatus) {
                $query->where('payment_status', $paymentStatus);
            })
            ->when(request('date_from'), function ($query, $dateFrom) {
                $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when(request('date_to'), function ($query, $dateTo) {
                $query->whereDate('created_at', '<=', $dateTo);
            })
            ->when(request('search'), function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('order_number', 'like', "%{$search}%")
                        ->orWhere('customer_name', 'like', "%{$search}%")
                        ->orWhere('customer_phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(25)
            ->withQueryString();

        $statuses = ['pending', 'confirmed', 'preparing', 'ready', 'delivering', 'delivered', 'cancelled'];
        $paymentStatuses = ['pending', 'paid', 'failed', 'refunded'];

        return view('admin.orders.index', compact('orders', 'statuses', 'paymentStatuses'));
    }

    /**
     * Show a specific order.
     */
    public function show(Order $order): View
    {
        $order->load('items', 'user');

        $statuses = ['pending', 'confirmed', 'preparing', 'ready', 'delivering', 'delivered', 'cancelled'];

        return view('admin.orders.show', compact('order', 'statuses'));
    }

    /**
     * Poll for new orders since a given timestamp (AJAX).
     */
    public function pollNewOrders(Request $request): JsonResponse
    {
        $since = $request->input('since');

        $query = Order::query();

        if ($since) {
            $sinceDate = Carbon::parse($since);
            $query->where('created_at', '>', $sinceDate);
        }

        $newOrders = $query->latest()->get();

        $latestOrder = Order::latest()->first();

        return response()->json([
            'new_count' => $newOrders->count(),
            'latest_id' => $latestOrder?->id,
            'orders' => $newOrders->map(function (Order $order) {
                return [
                    'order_number' => $order->order_number,
                    'customer_name' => $order->customer_name,
                    'total' => number_format($order->total, 2, ',', ' ').' €',
                    'status' => $order->status,
                    'created_at' => $order->created_at->format('d/m/Y H:i'),
                ];
            }),
        ]);
    }

    /**
     * Poll for order status changes (AJAX).
     */
    public function pollOrderStatus(Order $order): JsonResponse
    {
        return response()->json([
            'status' => $order->status,
            'payment_status' => $order->payment_status ?? 'pending',
            'updated_at' => $order->updated_at->toIso8601String(),
        ]);
    }

    /**
     * Geocode an address for the admin map (proxy to Nominatim).
     */
    public function geocode(Request $request): JsonResponse
    {
        $address = $request->input('address', '');

        $url = 'https://nominatim.openstreetmap.org/search?'.http_build_query([
            'q' => $address.', France',
            'format' => 'json',
            'limit' => 1,
            'countrycodes' => 'fr',
        ]);

        $context = stream_context_create([
            'http' => [
                'header' => "User-Agent: EpiDrive/1.0\r\n",
                'timeout' => 5,
            ],
        ]);

        $response = @file_get_contents($url, false, $context);

        if ($response === false) {
            return response()->json(['error' => 'Geocoding failed'], 500);
        }

        $data = json_decode($response, true);

        if (empty($data) || ! isset($data[0]['lat'], $data[0]['lon'])) {
            return response()->json(['error' => 'Address not found'], 404);
        }

        return response()->json([
            'lat' => (float) $data[0]['lat'],
            'lng' => (float) $data[0]['lon'],
            'store_lat' => (float) Setting::getValue('store_lat', '45.5495'),
            'store_lng' => (float) Setting::getValue('store_lng', '3.7428'),
        ]);
    }

    /**
     * Update the status of an order.
     */
    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,confirmed,preparing,ready,delivering,delivered,cancelled',
        ]);

        $oldStatus = $order->status;
        $updateData = ['status' => $validated['status']];

        // Auto-mark cash payments as paid when delivered
        if ($validated['status'] === 'delivered' && $order->payment_method === 'cash' && $order->payment_status === 'pending') {
            $updateData['payment_status'] = 'paid';
        }

        $order->update($updateData);

        // Broadcast status change for real-time updates
        event(new OrderStatusUpdated($order, $oldStatus));

        // If cancelled, restore stock
        if ($validated['status'] === 'cancelled' && $oldStatus !== 'cancelled') {
            foreach ($order->items as $item) {
                $product = \App\Models\Product::find($item->product_id);
                if ($product && $product->stock !== null) {
                    $product->increment('stock', $item->quantity);
                    $product->refresh();
                    event(new \App\Events\StockUpdated($product->id, $product->name, $product->stock));
                }
            }
        }

        return back()->with('success', 'Statut de la commande mis a jour : '.$validated['status']);
    }

    /**
     * Validate a pickup via QR/validation code.
     */
    public function validatePickup(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'validation_code' => 'required|string|size:8',
        ]);

        $code = strtoupper(trim($request->input('validation_code')));
        $order = Order::where('validation_code', $code)->first();

        if (! $order) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Code invalide. Aucune commande trouvee.'], 404);
            }

            return back()->with('error', 'Code invalide. Aucune commande trouvee.');
        }

        if ($order->isValidated()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cette commande a deja ete validee le '.$order->validated_at->format('d/m/Y a H:i').'.',
                    'order_number' => $order->order_number,
                ]);
            }

            return back()->with('error', 'Commande deja validee le '.$order->validated_at->format('d/m/Y a H:i').'.');
        }

        // Mark as validated
        $order->update(['validated_at' => now()]);

        // Auto-verify the customer and increase trust
        if ($order->user) {
            $user = $order->user;
            $updates = [];

            if (! $user->is_verified) {
                $updates['is_verified'] = true;
            }

            // Increase trust level (max 4, level 5 is VIP = manual only)
            if ($user->trust_level < 4) {
                $updates['trust_level'] = $user->trust_level + 1;
            }

            if (! empty($updates)) {
                \Illuminate\Support\Facades\DB::table('users')
                    ->where('id', $user->id)
                    ->update($updates);
            }
        }

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Commande #'.$order->order_number.' validee avec succes !',
                'order_number' => $order->order_number,
                'customer_name' => $order->customer_name,
                'total' => number_format($order->total, 2, ',', ' ').' EUR',
            ]);
        }

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Commande #'.$order->order_number.' validee avec succes ! Client verifie.');
    }
}
