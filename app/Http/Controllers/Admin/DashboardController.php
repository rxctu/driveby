<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
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
            ->whereNotIn('status', ['cancelled'])
            ->sum('total');

        $revenueMonth = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->whereNotIn('status', ['cancelled'])
            ->sum('total');

        $revenuePaidMonth = Order::whereMonth('created_at', now()->month)
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

        $deliveredOrders = Order::where('status', 'delivered')->count();

        $stockAlerts = Product::whereNotNull('stock')
            ->where('stock', '<=', 5)
            ->where('is_active', true)
            ->orderBy('stock', 'asc')
            ->get(['id', 'name', 'stock', 'price']);

        return view('admin.dashboard', compact(
            'ordersToday',
            'revenueToday',
            'revenueMonth',
            'revenuePaidMonth',
            'pendingOrders',
            'confirmedOrders',
            'preparingOrders',
            'deliveredOrders',
            'totalProducts',
            'lowStockProducts',
            'outOfStockProducts',
            'totalCustomers',
            'newCustomersToday',
            'recentOrders',
            'stockAlerts'
        ));
    }

    /**
     * JSON endpoint for real-time stock alert polling.
     */
    public function stockAlerts(): JsonResponse
    {
        $products = Product::whereNotNull('stock')
            ->where('stock', '<=', 5)
            ->where('is_active', true)
            ->orderBy('stock', 'asc')
            ->get(['id', 'name', 'stock', 'price']);

        return response()->json([
            'products' => $products,
            'out_of_stock' => $products->where('stock', 0)->count(),
            'low_stock' => $products->where('stock', '>', 0)->count(),
        ]);
    }
}
