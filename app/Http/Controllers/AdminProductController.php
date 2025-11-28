<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = [
            [
                'id' => 1,
                'name' => 'Benih Selada Hidroponik',
                'category' => 'Benih',
                'price' => 15000,
                'stock' => 50,
                'image' => 'images/product-1.jpg',
                'status' => 'Aktif'
            ],
            [
                'id' => 2,
                'name' => 'Nutrisi AB Mix 1L',
                'category' => 'Pupuk',
                'price' => 25000,
                'stock' => 20,
                'image' => 'images/product-2.jpg',
                'status' => 'Aktif'
            ],
            [
                'id' => 3,
                'name' => 'Rockwool Cultilene',
                'category' => 'Media Tanam',
                'price' => 5000,
                'stock' => 0,
                'image' => 'images/product-3.jpg',
                'status' => 'Habis'
            ]
        ];

        return view('admin.products.index', compact('products'));
    }

    // form create
    public function create()
    {
        return view('admin.products.create');
    }

    // save
    public function store(Request $request)
    {
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // edit
    public function edit($id)
    {
        $product = (object) [
            'id' => $id,
            'name' => 'Benih Selada Hidroponik',
            'category' => 'Benih',
            'price' => 15000,
            'stock' => 50,
            'description' => 'Deskripsi panjang produk...',
            'status' => 'Aktif'
        ];
        return view('admin.products.edit', compact('product'));
    }

    // update
    public function update(Request $request, $id)
    {
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // delete
    public function destroy($id)
    {
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}
