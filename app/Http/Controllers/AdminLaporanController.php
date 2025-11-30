<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminLaporanController extends Controller
{
    public function index()
    {
        // laporan penjualan
        $salesSummary = [
            'income_month' => 4500000,
            'income_growth' => 18, 
            'orders_count' => 150,
            'products_sold' => 320
        ];

        $chartSales = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            'data' => [1200000, 1900000, 3000000, 5000000, 2000000, 4500000]
        ];

        // penjualan harian
        $salesHistory = [
            ['date' => '2025-11-28', 'id' => 'ORD-001', 'customer' => 'Budi', 'total' => 150000],
            ['date' => '2025-11-28', 'id' => 'ORD-002', 'customer' => 'Siti', 'total' => 75000],
            ['date' => '2025-11-27', 'id' => 'ORD-003', 'customer' => 'Rudi', 'total' => 250000],
        ];


        // laporan pembelian
        $purchaseSummary = [
            'expense_month' => 1200000,
            'items_restocked' => 50,
            'biggest_expense' => 'Alat Hidroponik' 
        ];

        $chartExpense = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            'data' => [500000, 300000, 800000, 200000, 1500000, 1200000]
        ];

        // riwayat pembelian
        $purchaseHistory = [
            [
                'date' => '2025-11-25',
                'item' => 'Restock Rockwool 1 Ball',
                'category' => 'Media Tanam',
                'supplier' => 'CV. Tani Jaya',
                'cost' => 500000
            ],
            [
                'date' => '2025-11-20',
                'item' => 'Benih Selada Import (10 Pack)',
                'category' => 'Benih',
                'supplier' => 'Importir Benih',
                'cost' => 350000
            ],
            [
                'date' => '2025-11-15',
                'item' => 'Netpot 5cm (1000 pcs)',
                'category' => 'Alat',
                'supplier' => 'Plastik Abadi',
                'cost' => 200000
            ],
            [
                'date' => '2025-11-10',
                'item' => 'Nutrisi AB Mix 5L',
                'category' => 'Nutrisi',
                'supplier' => 'Hidroponik Surabaya',
                'cost' => 150000
            ]
        ];

        return view('admin.laporan.index', compact(
            'salesSummary', 'chartSales', 'salesHistory',
            'purchaseSummary', 'chartExpense', 'purchaseHistory'
        ));
    }
}