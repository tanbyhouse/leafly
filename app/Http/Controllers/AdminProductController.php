<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $query = Product::with(['category', 'images' => function($query) {
            $query->where('is_primary', true);
        }]);
        
        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }
        
        $products = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'weight' => 'nullable|numeric|min:0',
            'is_active' => 'nullable|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Debug: cek apakah file terupload
        Log::info('Product creation attempt:', [
            'hasFile' => $request->hasFile('image'),
            'fileValid' => $request->file('image') ? $request->file('image')->isValid() : false,
        ]);

        try {
            // Generate SKU otomatis
            $data['sku'] = 'PROD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(4));
            $data['type'] = 'default';
            $data['is_active'] = $request->has('is_active') ? 1 : 0;
            
            // Konversi weight ke decimal jika ada
            if (isset($data['weight'])) {
                $data['weight'] = (float) $data['weight'];
            }

            // Create product
            $product = Product::create($data);

            // Upload image jika ada
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                try {
                    // Pastikan folder ada
                    $storagePath = storage_path('app/public/product_images');
                    if (!file_exists($storagePath)) {
                        mkdir($storagePath, 0755, true);
                    }
                    
                    // Upload file
                    $path = $request->file('image')->store('product_images', 'public');
                    
                    // Simpan ke database
                    ProductImage::create([
                        'product_id' => $product->id,
                        'path' => $path,
                        'is_primary' => true,
                    ]);
                    
                    Log::info('Image uploaded successfully:', ['path' => $path]);
                } catch (\Exception $e) {
                    Log::error('Image upload failed:', [
                        'error' => $e->getMessage(),
                        'product_id' => $product->id
                    ]);
                    
                    // Lanjutkan tanpa gambar jika upload gagal
                }
            }

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk "' . $product->name . '" berhasil ditambahkan!');
                
        } catch (\Exception $e) {
            Log::error('Product creation failed:', [
                'error' => $e->getMessage(),
                'data' => $request->except(['image'])
            ]);
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $product = Product::with(['category', 'images'])->findOrFail($id);
        $categories = \App\Models\Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'weight' => 'nullable|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $data['is_active'] = $request->has('is_active') ? 1 : 0;
            
            // Konversi weight ke decimal jika ada
            if (isset($data['weight'])) {
                $data['weight'] = (float) $data['weight'];
            }

            $product->update($data);

            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                try {
                    // Hapus gambar lama jika ada
                    foreach ($product->images as $img) {
                        Storage::disk('public')->delete($img->path);
                        $img->delete();
                    }
                    
                    // Upload gambar baru
                    $path = $request->file('image')->store('product_images', 'public');
                    
                    ProductImage::create([
                        'product_id' => $product->id,
                        'path' => $path,
                        'is_primary' => true,
                    ]);
                    
                    Log::info('Image updated successfully:', ['path' => $path]);
                } catch (\Exception $e) {
                    Log::error('Image update failed:', [
                        'error' => $e->getMessage(),
                        'product_id' => $product->id
                    ]);
                }
            }

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil diperbarui!');
                
        } catch (\Exception $e) {
            Log::error('Product update failed:', [
                'error' => $e->getMessage(),
                'product_id' => $id
            ]);
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            
            foreach ($product->images as $img) {
                Storage::disk('public')->delete($img->path);
                $img->delete();
            }
            
            // Hapus produk
            $product->delete();

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk berhasil dihapus!');
                
        } catch (\Exception $e) {
            Log::error('Product deletion failed:', [
                'error' => $e->getMessage(),
                'product_id' => $id
            ]);
            
            return back()
                ->withErrors(['error' => 'Gagal menghapus produk: ' . $e->getMessage()]);
        }
    }
}