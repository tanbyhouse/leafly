<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminLaporanController extends Controller
{
    public function index()
    {
        $summary = [
            'income_this_month' => 4500000,
            'income_last_month' => 3800000,
            'orders_count' => 150,
            'products_sold' => 320
        ];

        $chartSales = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            'data' => [1200000, 1900000, 3000000, 5000000, 2000000, 4500000]
        ];

        $chartCategories = [
            'labels' => ['Benih', 'Nutrisi', 'Media Tanam', 'Alat'],
            'data' => [45, 25, 20, 10] // Dalam persen
        ];

        $dailyReports = [
            ['date' => '2025-11-28', 'orders' => 12, 'income' => 1500000, 'items' => 25],
            ['date' => '2025-11-27', 'orders' => 8, 'income' => 850000, 'items' => 14],
            ['date' => '2025-11-26', 'orders' => 15, 'income' => 2100000, 'items' => 30],
            ['date' => '2025-11-25', 'orders' => 5, 'income' => 450000, 'items' => 8],
        ];

        return view('admin.laporan.index', compact('summary', 'chartSales', 'chartCategories', 'dailyReports'));
    }
}