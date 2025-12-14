<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductReview;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'images'])
            ->where('is_active', true);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_Product', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%')
                    ->orWhere('kode_Product', 'like', '%' . $search . '%');
            });
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by multiple categories (checkbox)
        if ($request->filled('category') && is_array($request->category)) {
            $query->whereIn('jenis_Product', $request->category);
        }

        // Filter by jenis Product
        if ($request->filled('jenis')) {
            $query->where('jenis_Product', $request->jenis);
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
        $categories = category::all();

        return view('products.index', compact('products', 'categories'));
    }

    public function show($id)
    {
        $product = Product::with([
            'category',
            'images',
            'caraPerawatan',
            'review.pelanggan.user',
            'review' => function ($query) {
                $query->orderBy('created_at', 'desc');
            }
        ])->findOrFail($id);

        // Calculate average rating
        $averageRating = $product->review->avg('rating') ?? 0;
        $totalReviews = $product->review->count();

        // Rating distribution
        $ratingDistribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $ratingDistribution[$i] = $product->review
                ->where('rating', $i)
                ->count();
        }

        // Related products
        $relatedProducts = Product::with(['category', 'images'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
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

        $products = Product::with(['category', 'images'])
            ->where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('nama_Product', 'like', '%' . $query . '%')
                    ->orWhere('kode_Product', 'like', '%' . $query . '%');
            })
            ->limit(10)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'nama' => $product->nama_Product,
                    'harga' => $product->harga,
                    'foto' => $product->images->first()->path_foto ?? null,
                    'category' => $product->category->nama_category ?? '',
                ];
            });

        return response()->json($products);
    }
}
