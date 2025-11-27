<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\Produk;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = Pesanan::count();
        $totalProducts = Produk::count();
        $totalUsers = User::where('tipe_user', 'pelanggan')->count();
        $totalRevenue = Pesanan::where('status_pembayaran', 'dibayar')->sum('total');

        $recentOrders = Pesanan::with('pelanggan.user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalProducts',
            'totalUsers',
            'totalRevenue',
            'recentOrders'
        ));
    }
}

