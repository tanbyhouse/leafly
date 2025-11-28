<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use App\Models\CaraPerawatan;
use App\Models\FotoProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Produk::with(['kategori', 'fotoUtama'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.products.index', compact('products'));
    }
    public function create()
    {
        $categories = Kategori::all();
        $careInstructions = CaraPerawatan::all();

        return view('admin.products.create', compact('categories', 'careInstructions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_produk' => 'required|string|max:255',
            'kode_produk' => 'required|string|unique:produks,kode_produk',
            'jenis_produk' => 'required|in:benih,bibit,alat,paket',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'berat' => 'nullable|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $produk = Produk::create($validated);

            // Handle photo upload
            if ($request->hasFile('foto')) {
                $path = $request->file('foto')->store('produk', 'public');

                FotoProduk::create([
                    'produk_id' => $produk->id,
                    'path_foto' => $path,
                    'foto_utama' => true,
                ]);
            }

            DB::commit();
            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal menambahkan produk')->withInput();
        }
    }
   public function edit($id)
    {
        $product = Produk::findOrFail($id);
        $categories = Kategori::all();
        $careInstructions = CaraPerawatan::all();

        return view('admin.products.edit', compact('product', 'categories', 'careInstructions'));
    }

    public function update(Request $request, $id)
    {
        $product = Produk::findOrFail($id);

        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama_produk' => 'required|string|max:255',
            'jenis_produk' => 'required|in:benih,bibit,alat,paket',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'berat' => 'nullable|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'is_aktif' => 'boolean',
        ]);
        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy($id)
    {
        $product = Produk::findOrFail($id);
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus');
    }
}

