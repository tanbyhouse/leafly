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
        $totalSales = (float) Order::where('payment_status', 'paid')->sum('total');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalCustomers = User::whereHas('roles', function ($q) {
            $q->where('name', 'pelanggan');
        })->count();

        $stats = [
            'total_sales' => $totalSales,
            'total_orders' => $totalOrders,
            'total_products' => $totalProducts,
            'total_customers' => $totalCustomers,
        ];

        $recentOrdersModels = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recent_orders = $recentOrdersModels->map(function ($o) {
            $status = 'Menunggu';
            if (in_array($o->order_status, ['completed', 'delivered', 'finished'])) {
                $status = 'Selesai';
            } elseif (in_array($o->order_status, ['processed', 'shipped'])) {
                $status = 'Dikemas';
            }

            return [
                'id' => $o->order_number ?? $o->id,
                'user' => optional($o->user)->name ?? '—',
                'total' => $o->total ?? 0,
                'status' => $status,
            ];
        })->toArray();

        return view('admin.dashboard.index', compact('stats', 'recent_orders'));
    }
}
