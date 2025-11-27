<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cartItems = [
            [
                'id' => 1,
                'name' => 'Benih Selada Hidroponik Premium',
                'price' => 15000,
                'image' => 'fa-seedling',
                'quantity' => 2,
            ],
            [
                'id' => 2,
                'name' => 'Nutrisi AB Mix Sayuran Daun',
                'price' => 25000,
                'image' => 'fa-bottle-droplet',
                'quantity' => 1,
            ]
        ];

        return view('customer.cart', compact('cartItems'));
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
    public function show(string $id)
    {
        //
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
