<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    /**
     * List all orders with filters.
     */
    public function index(): View
    {
        $orders = Order::with('items')
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

        // If cancelled, restore stock
        if ($validated['status'] === 'cancelled' && $oldStatus !== 'cancelled') {
            foreach ($order->items as $item) {
                $product = \App\Models\Product::find($item->product_id);
                if ($product && $product->stock !== null) {
                    $product->increment('stock', $item->quantity);
                }
            }
        }

        return back()->with('success', 'Statut de la commande mis a jour : '.$validated['status']);
    }
}
