<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard with key stats.
     */
    public function index(): View
    {
        $ordersToday = Order::whereDate('created_at', today())->count();

        $revenueToday = Order::whereDate('created_at', today())
            ->where('payment_status', 'paid')
            ->sum('total');

        $revenueMonth = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('payment_status', 'paid')
            ->sum('total');

        $pendingOrders = Order::where('status', 'pending')->count();
        $confirmedOrders = Order::where('status', 'confirmed')->count();
        $preparingOrders = Order::where('status', 'preparing')->count();

        $totalProducts = Product::count();
        $lowStockProducts = Product::whereNotNull('stock')
            ->where('stock', '<=', 5)
            ->where('stock', '>', 0)
            ->count();
        $outOfStockProducts = Product::whereNotNull('stock')
            ->where('stock', 0)
            ->count();

        $totalCustomers = User::count();
        $newCustomersToday = User::whereDate('created_at', today())->count();

        $recentOrders = Order::with('items')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'ordersToday',
            'revenueToday',
            'revenueMonth',
            'pendingOrders',
            'confirmedOrders',
            'preparingOrders',
            'totalProducts',
            'lowStockProducts',
            'outOfStockProducts',
            'totalCustomers',
            'newCustomersToday',
            'recentOrders'
        ));
    }
}
