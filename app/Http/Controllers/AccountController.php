<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AccountController extends Controller
{
    /**
     * Show the user dashboard.
     */
    public function index(): View
    {
        $user = Auth::user();

        $recentOrders = Order::where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $totalOrders = Order::where('user_id', $user->id)->count();
        $totalSpent = Order::where('user_id', $user->id)
            ->where('payment_status', 'paid')
            ->sum('total');

        return view('account.index', compact('user', 'recentOrders', 'totalOrders', 'totalSpent'));
    }

    /**
     * List all orders for the authenticated user.
     */
    public function orders(): View
    {
        $user = Auth::user();

        $orders = Order::where('user_id', $user->id)
            ->latest()
            ->paginate(15);

        return view('account.orders', compact('user', 'orders'));
    }

    /**
     * Show a specific order detail.
     */
    public function orderDetail(string $orderNumber): View
    {
        $user = Auth::user();

        $order = Order::where('user_id', $user->id)
            ->where('order_number', $orderNumber)
            ->with('items')
            ->firstOrFail();

        return view('account.order-detail', compact('user', 'order'));
    }
}
