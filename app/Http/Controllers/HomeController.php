<?php
namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured products
        $featuredProducts = Produk::with(['kategori', 'fotoUtama'])
            ->where('is_aktif', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('welcome', compact('featuredProducts'));
    }
}



