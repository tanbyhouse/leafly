<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured products from database
        $featuredProducts = Produk::with(['kategori', 'fotoUtama'])
            ->where('is_aktif', true)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('welcome', compact('featuredProducts'));
    }
}
