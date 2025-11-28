<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_sales' => 15000000,
            'total_orders' => 125,
            'total_products' => 45,
            'total_customers' => 320
        ];

        $recent_orders = [
            ['id' => 'ORD-001', 'user' => 'Budi Santoso', 'total' => 150000, 'status' => 'Menunggu'],
            ['id' => 'ORD-002', 'user' => 'Siti Aminah', 'total' => 75000, 'status' => 'Dikemas'],
            ['id' => 'ORD-003', 'user' => 'Rudi Hartono', 'total' => 250000, 'status' => 'Selesai'],
        ];

        return view('admin.dashboard.index', compact('stats', 'recent_orders'));
    }
}
