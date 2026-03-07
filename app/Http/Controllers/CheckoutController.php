<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\DeliverySlot;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    /**
     * Show the checkout form with cart summary, delivery form, and slot selection.
     */
    public function index(): View|RedirectResponse
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $products = Product::whereIn('id', array_keys($cart))
            ->where('is_active', true)
            ->get()
            ->keyBy('id');

        $cartItems = [];
        $subtotal = 0;

        foreach ($cart as $productId => $quantity) {
            if ($products->has($productId)) {
                $product = $products->get($productId);
                $lineTotal = $product->price * $quantity;
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'subtotal' => $lineTotal,
                ];
                $subtotal += $lineTotal;
            }
        }

        $deliverySlots = DeliverySlot::where('is_active', true)
            ->orderBy('day_of_week')
            ->orderBy('start_time')
            ->get();

        $freeDeliveryThreshold = Setting::getValue('free_delivery_threshold', 50);
        $defaultDeliveryFee = Setting::getValue('default_delivery_fee', 4.99);
        $deliveryFee = $subtotal >= $freeDeliveryThreshold ? 0 : $defaultDeliveryFee;
        $total = $subtotal + $deliveryFee;

        $user = Auth::user();

        return view('checkout.index', compact(
            'cartItems',
            'subtotal',
            'deliveryFee',
            'total',
            'deliverySlots',
            'freeDeliveryThreshold',
            'user'
        ));
    }

    /**
     * Process the checkout: validate, create order, handle payment.
     */
    public function store(CheckoutRequest $request): RedirectResponse
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide.');
        }

        $validated = $request->validated();

        $products = Product::whereIn('id', array_keys($cart))
            ->where('is_active', true)
            ->get()
            ->keyBy('id');

        // Verify stock and calculate totals
        $subtotal = 0;
        $orderItems = [];

        foreach ($cart as $productId => $quantity) {
            if (!$products->has($productId)) {
                return back()->with('error', 'Un produit de votre panier n\'est plus disponible.');
            }

            $product = $products->get($productId);

            if ($product->stock !== null && $quantity > $product->stock) {
                return back()->with('error', 'Stock insuffisant pour ' . $product->name . '.');
            }

            $lineTotal = $product->price * $quantity;
            $subtotal += $lineTotal;

            $orderItems[] = [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'quantity' => $quantity,
                'unit_price' => $product->price,
                'total_price' => $lineTotal,
            ];
        }

        // Calculate delivery fee
        $freeDeliveryThreshold = Setting::getValue('free_delivery_threshold', 50);
        $defaultDeliveryFee = Setting::getValue('default_delivery_fee', 4.99);
        $deliveryFee = $subtotal >= $freeDeliveryThreshold ? 0 : $defaultDeliveryFee;
        $total = $subtotal + $deliveryFee;

        // Create order within a transaction
        $order = DB::transaction(function () use ($validated, $subtotal, $deliveryFee, $total, $orderItems) {
            // Map form fields to actual database columns
            $deliverySlot = null;
            if (!empty($validated['delivery_slot_id'])) {
                $slot = DeliverySlot::find($validated['delivery_slot_id']);
                if ($slot) {
                    $dayNames = [1 => 'Lundi', 2 => 'Mardi', 3 => 'Mercredi', 4 => 'Jeudi', 5 => 'Vendredi', 6 => 'Samedi', 7 => 'Dimanche'];
                    $dayLabel = $dayNames[$slot->day_of_week] ?? $slot->day_of_week;
                    $start = substr($slot->start_time, 0, 5);
                    $end = substr($slot->end_time, 0, 5);
                    $deliverySlot = $dayLabel . ' ' . $start . '-' . $end;
                }
            }

            $order = Order::create([
                'order_number' => 'EPI-' . strtoupper(Str::random(8)),
                'user_id' => Auth::id(),
                'status' => 'pending',
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
                'customer_name' => $validated['delivery_name'],
                'customer_phone' => $validated['delivery_phone'],
                'customer_address' => $validated['delivery_address'] . ', ' . $validated['delivery_postal_code'] . ' ' . $validated['delivery_city'],
                'delivery_instructions' => $validated['notes'] ?? null,
                'delivery_slot' => $deliverySlot,
            ]);

            foreach ($orderItems as $item) {
                $order->items()->create($item);

                // Decrement stock with pessimistic locking to prevent race conditions
                $product = Product::lockForUpdate()->find($item['product_id']);
                if ($product && $product->stock !== null) {
                    if ($product->stock < $item['quantity']) {
                        throw new \RuntimeException('Stock insuffisant pour ' . $product->name);
                    }
                    $product->decrement('stock', $item['quantity']);
                }
            }

            // Track delivery slot usage (no capacity column in current schema)
            // Future: decrement capacity if column exists

            return $order;
        });

        // Clear the cart
        session()->forget(['cart', 'cart_count']);

        return redirect()->route('checkout.success', $order->order_number)
            ->with('success', 'Votre commande a ete enregistree avec succes !');
    }

    /**
     * AJAX endpoint to calculate delivery price from address.
     */
    public function calculateDelivery(Request $request): JsonResponse
    {
        $request->validate([
            'postal_code' => 'required|string|size:5',
            'address' => 'nullable|string|max:255',
        ]);

        $postalCode = $request->input('postal_code');

        // Check if postal code is in delivery zone
        $allowedPrefixes = Setting::getValue('delivery_postal_prefixes', '75,92,93,94');
        $allowedList = array_map('trim', explode(',', $allowedPrefixes));
        $postalPrefix = substr($postalCode, 0, 2);

        if (!in_array($postalPrefix, $allowedList)) {
            return response()->json([
                'available' => false,
                'message' => 'Livraison non disponible dans votre zone.',
            ]);
        }

        $cart = session('cart', []);
        $subtotal = 0;

        if (!empty($cart)) {
            $products = Product::whereIn('id', array_keys($cart))->get()->keyBy('id');
            foreach ($cart as $productId => $quantity) {
                if ($products->has($productId)) {
                    $subtotal += $products->get($productId)->price * $quantity;
                }
            }
        }

        $freeDeliveryThreshold = Setting::getValue('free_delivery_threshold', 50);
        $defaultDeliveryFee = Setting::getValue('default_delivery_fee', 4.99);
        $deliveryFee = $subtotal >= $freeDeliveryThreshold ? 0 : $defaultDeliveryFee;

        return response()->json([
            'available' => true,
            'delivery_fee' => $deliveryFee,
            'free_delivery_threshold' => $freeDeliveryThreshold,
            'subtotal' => $subtotal,
            'total' => $subtotal + $deliveryFee,
            'message' => $deliveryFee === 0
                ? 'Livraison gratuite !'
                : 'Frais de livraison : ' . number_format($deliveryFee, 2, ',', '') . ' EUR',
        ]);
    }

    /**
     * Show the order confirmation page.
     */
    public function success(string $orderNumber): View
    {
        $order = Order::where('order_number', $orderNumber)
            ->with('items')
            ->firstOrFail();

        // Ensure the user can only see their own order (or guest order from session)
        if (Auth::check() && $order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('checkout.success', compact('order'));
    }
}
