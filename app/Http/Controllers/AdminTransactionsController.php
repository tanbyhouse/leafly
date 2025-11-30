<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminTransactionsController extends Controller
{
    public function index()
    {
        $transactions = [
            [
                'id' => 'ORD-20251127-001',
                'customer' => 'Budi Santoso',
                'date' => '27 Nov 2025 14:30',
                'total' => 120000,
                'status' => 'Menunggu Pembayaran',
                'payment_method' => 'Transfer Bank'
            ],
            [
                'id' => 'ORD-20251120-098',
                'customer' => 'Siti Aminah',
                'date' => '20 Nov 2025 09:15',
                'total' => 45000,
                'status' => 'Dikemas',
                'payment_method' => 'COD'
            ],
            [
                'id' => 'ORD-20251115-055',
                'customer' => 'Rudi Hartono',
                'date' => '15 Nov 2025 10:00',
                'total' => 250000,
                'status' => 'Dikirim',
                'payment_method' => 'Transfer Bank'
            ],
            [
                'id' => 'ORD-20251110-012',
                'customer' => 'Dewi Persik',
                'date' => '10 Nov 2025 11:20',
                'total' => 15000,
                'status' => 'Selesai',
                'payment_method' => 'Transfer Bank'
            ]
        ];

        return view('admin.transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = (object) [
            'id' => $id,
            'customer_name' => 'Budi Santoso',
            'customer_email' => 'budi@gmail.com',
            'customer_phone' => '081234567890',
            'address' => 'Jl. Kalimantan No. 37, Jember, Jawa Timur',
            'date' => '27 Nov 2025 14:30',
            'status' => 'Menunggu Pembayaran',
            'courier' => 'JNE Reguler',
            'resi' => '-',
            'payment_method' => 'Transfer Bank BCA',
            'subtotal' => 110000,
            'shipping_cost' => 10000,
            'grand_total' => 120000,
            'items' => [
                ['name' => 'Benih Selada Premium', 'qty' => 2, 'price' => 15000],
                ['name' => 'Nutrisi AB Mix', 'qty' => 1, 'price' => 80000],
            ]
        ];

        return view('admin.transactions.show', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}