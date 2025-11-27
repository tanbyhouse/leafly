<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = [
            [
                'name' => 'Benih Selada Hidroponik Premium',
                'price' => 15000,
                'quantity' => 2,
                'image' => 'fa-seedling',
            ],
            [
                'name' => 'Nutrisi AB Mix Sayuran Daun',
                'price' => 25000,
                'quantity' => 1,
                'image' => 'fa-bottle-droplet',
            ]
        ];

        $subtotal = 55000; 
        $adminFee = 1000;

        return view('customer.checkout', compact('cartItems', 'subtotal', 'adminFee'));
    }
}
