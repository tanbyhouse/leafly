<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured products from database
        $featuredProducts = Product::with(['category', 'fotoUtama'])
            ->where('is_active', true)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('welcome', compact('featuredProducts'));
    }
}
