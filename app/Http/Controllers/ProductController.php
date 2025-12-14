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
            'reviews_count' => 2,
            'images' => ['fa-seedling', 'fa-plant-wilt', 'fa-leaf'],
            'reviews' => [
                [
                    'user_name' => 'Budi Santoso',
                    'rating' => 5,
                    'comment' => 'Benihnya cepat tumbuh, mantap!',
                    'date' => '2025-11-20',
                    'avatar' => null
                ],
                [
                    'user_name' => 'Siti Aminah',
                    'rating' => 4,
                    'comment' => 'Pengiriman cepat, packing aman.',
                    'date' => '2025-11-22',
                    'avatar' => null
                ]
            ],
            'care' => [
                ['icon' => 'fa-sun', 'title' => 'Cahaya', 'desc' => 'Butuh sinar matahari penuh (min. 6 jam/hari).'],
                ['icon' => 'fa-droplet', 'title' => 'Penyiraman', 'desc' => 'Siram 2x sehari (pagi & sore) agar tanah lembab.'],
                ['icon' => 'fa-temperature-half', 'title' => 'Suhu', 'desc' => 'Optimal pada suhu sejuk 20-25°C.'],
                ['icon' => 'fa-seedling', 'title' => 'Pemupukan', 'desc' => 'Berikan NPK Daun setiap 1 minggu sekali.'],
            ]
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