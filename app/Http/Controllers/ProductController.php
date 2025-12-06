<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\PenilaianProduk;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Produk::with(['kategori', 'fotoProduks'])
            ->where('is_aktif', true);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_produk', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%')
                    ->orWhere('kode_produk', 'like', '%' . $search . '%');
            });
        }

        // Filter by category
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        // Filter by multiple categories (checkbox)
        if ($request->filled('category') && is_array($request->category)) {
            $query->whereIn('jenis_produk', $request->category);
        }

        // Filter by jenis produk
        if ($request->filled('jenis')) {
            $query->where('jenis_produk', $request->jenis);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('harga', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('harga', '<=', $request->max_price);
        }

        // Sort
        $sortBy = $request->get('sort', 'terbaru');
        switch ($sortBy) {
            case 'termurah':
                $query->orderBy('harga', 'asc');
                break;
            case 'termahal':
                $query->orderBy('harga', 'desc');
                break;
            case 'terlaris':
                $query->withCount('detailPesanans')
                    ->orderBy('detail_pesanans_count', 'desc');
                break;
            case 'terbaru':
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Kategori::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Produk::with([
            'kategori',
            'fotoProduks',
            'caraPerawatan',
            'penilaianProduks.pelanggan.user',
            'penilaianProduks' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }
        ])->findOrFail($id);

        // Calculate average rating
        $averageRating = $product->penilaianProduks->avg('rating') ?? 0;
        $totalReviews = $product->penilaianProduks->count();

        // Rating distribution
        $ratingDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $ratingDistribution[$i] = $product->penilaianProduks
                ->where('rating', $i)
                ->count();
        }

        // Related products
        $relatedProducts = Produk::with(['kategori', 'fotoProduks'])
            ->where('kategori_id', $product->kategori_id)
            ->where('id', '!=', $product->id)
            ->where('is_aktif', true)
            ->where('stok', '>', 0)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('products.show', compact(
            'product',
            'averageRating',
            'totalReviews',
            'ratingDistribution',
            'relatedProducts'
        ));
    }

    // API endpoint for product search (AJAX)
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        $products = Produk::with(['kategori', 'fotoProduks'])
            ->where('is_aktif', true)
            ->where(function ($q) use ($query) {
                $q->where('nama_produk', 'like', '%' . $query . '%')
                    ->orWhere('kode_produk', 'like', '%' . $query . '%');
            })
            ->limit(10)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'nama' => $product->nama_produk,
                    'harga' => $product->harga,
                    'foto' => $product->fotoProduks->first()->path_foto ?? null,
                    'kategori' => $product->kategori->nama_kategori ?? '',
                ];
            });

        return response()->json($products);
    }
}
