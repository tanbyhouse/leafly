<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik utama
        $totalSales = (float) Order::where('payment_status', 'paid')->sum('total');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCustomers = User::count(); // atau filter role jika mau

        $stats = [
            'total_sales' => $totalSales,
            'total_orders' => $totalOrders,
            'total_products' => $totalProducts,
            'total_customers' => $totalCustomers,
        ];

        // Pesanan terbaru
        $recentOrdersModels = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recent_orders = $recentOrdersModels->map(function ($o) {
            return [
                'id' => $o->id,
                'user' => optional($o->user)->name ?? '—',
                'total' => $o->total ?? 0,
                'status' => ucfirst($o->order_status),
            ];
        })->toArray();

        return view('admin.dashboard.index', compact('stats', 'recent_orders'));
    }
}
