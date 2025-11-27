<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('products.index');
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
        // dummy dolooo
        $product = [
            'id' => $id,
            'name' => 'Benih Selada Hidroponik Premium',
            'category' => 'Benih Tanaman',
            'price' => 15000,
            'description' => 'Benih selada pilihan dengan tingkat germinasi 98%. Sangat cocok untuk sistem hidroponik NFT, DFT, maupun Wick System. Hasil panen memiliki tekstur renyah, rasa manis, dan bebas rasa pahit. Dikemas dalam aluminium foil untuk menjaga kualitas benih.',
            'stock' => 50,
            'rating' => 4.8,
            'reviews_count' => 120,
            'images' => ['fa-seedling', 'fa-plant-wilt', 'fa-leaf']
        ];

        return view('products.show', compact('product'));
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
