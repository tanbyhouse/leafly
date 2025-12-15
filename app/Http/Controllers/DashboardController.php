<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // live statistics
        $totalSales = (float) Pesanan::where('status_pembayaran', 'dibayar')->sum('total');
        $totalOrders = Pesanan::count();
        $totalProducts = Produk::count();
        $totalCustomers = User::where('tipe_user', 'pelanggan')->count();

        $stats = [
            'total_sales' => $totalSales,
            'total_orders' => $totalOrders,
            'total_products' => $totalProducts,
            'total_customers' => $totalCustomers,
        ];

        $recentOrdersModels = Pesanan::with('pelanggan.user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $recent_orders = $recentOrdersModels->map(function ($o) {
            return [
                'id' => $o->id,
                'user' => optional($o->pelanggan->user)->name ?? ($o->pelanggan_name ?? '—'),
                'total' => $o->total ?? 0,
                'status' => $o->status ?? ($o->status_pembayaran ?? 'Menunggu'),
            ];
        })->toArray();

        return view('admin.dashboard.index', compact('stats', 'recent_orders'));
    }
}
