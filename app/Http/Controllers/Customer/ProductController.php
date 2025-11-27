<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::with(['kategori', 'fotoUtama', 'penilaianProduks'])
            ->where('is_aktif', true);

        // Filter by category
        if ($request->has('category') && !empty($request->category)) {
            $query->whereHas('kategori', function($q) use ($request) {
                $q->whereIn('nama_kategori', $request->category);
            });
        }

       // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('harga', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('harga', '<=', $request->max_price);
        }

        // Search
        if ($request->filled('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }
        // Sorting
        switch ($request->sort) {
            case 'termurah':
                $query->orderBy('harga', 'asc');
                break;
            case 'termahal':
                $query->orderBy('harga', 'desc');
                break;
            case 'terlaris':
                // You can add sales count logic here
                $query->orderBy('created_at', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(9);
        $categories = Kategori::all();

        return view('products.index', compact('products', 'categories'));
    }
   public function show($id)
    {
        $product = Produk::with([
            'kategori',
            'fotoProduks',
            'caraPerawatan',
            'penilaianProduks.pelanggan.user'
        ])->findOrFail($id);

        // Calculate average rating
        $avgRating = $product->penilaianProduks->avg('rating') ?? 0;
        $totalReviews = $product->penilaianProduks->count();

        return view('products.show', compact('product', 'avgRating', 'totalReviews'));
    }
}

