<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = [
            [
                'id' => 'ORD-20251127-001',
                'date' => '27 Nov 2025',
                'status' => 'Menunggu Pembayaran',
                'total' => 120000,
                'items' => ['Benih Selada', 'Nutrisi AB Mix']
            ],
            [
                'id' => 'ORD-20251120-098',
                'date' => '20 Nov 2025',
                'status' => 'Dikemas',
                'total' => 45000,
                'items' => ['Rockwool']
            ],
            [
                'id' => 'ORD-20251115-055',
                'date' => '15 Nov 2025',
                'status' => 'Selesai',
                'total' => 250000,
                'items' => ['Paket Hidroponik Pemula']
            ],
        ];

        return view('customer.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = [
            'id' => $id,
            'date' => '27 Nov 2025',
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

        return view('customer.orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
