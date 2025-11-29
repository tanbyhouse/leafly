<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminProductBusukController extends Controller
{
    public function index()
    {
        $productsBusuk = [
            [
                'id' => 1,
                'product_name' => 'Benih Selada Hidroponik',
                'quantity' => 5,
                'date' => '2025-11-28',
                'note' => 'Layu karena telat siram',
                'reported_by' => 'Admin'
            ],
            [
                'id' => 2,
                'product_name' => 'Nutrisi AB Mix 1L',
                'quantity' => 1,
                'date' => '2025-11-25',
                'note' => 'Layu karena telat pupuk',
                'reported_by' => 'Gudang'
            ],
            [
                'id' => 3,
                'product_name' => 'Bibit Kangkung',
                'quantity' => 10,
                'date' => '2025-11-20',
                'note' => 'Layu karena telat siram',
                'reported_by' => 'Admin'
            ]
        ];

        return view('admin.busuk.index', compact('productsBusuk'));
    }

    public function create()
    {
        $products = [
            ['id' => 1, 'name' => 'Benih Selada Hidroponik'],
            ['id' => 2, 'name' => 'Nutrisi AB Mix 1L'],
            ['id' => 3, 'name' => 'Rockwool Cultilene'],
        ];

        return view('admin.busuk.create', compact('products'));
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.busuk.index')->with('success', 'Laporan produk busuk berhasil dicatat!');
    }

    public function destroy($id)
    {
        return redirect()->route('admin.busuk.index')->with('success', 'Laporan berhasil dihapus.');
    }
}