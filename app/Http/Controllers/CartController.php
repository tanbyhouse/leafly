<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CartController extends Controller
{
    public function index()
    {
        $pelanggan = Auth::user()->pelanggan;

        if (!$pelanggan) {
            return redirect()->route('home')->with('error', 'Profil pelanggan tidak ditemukan.');
        }

        $cartItems = Keranjang::with(['produk.fotoProduks', 'produk.kategori'])
            ->where('pelanggan_id', $pelanggan->id)
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->produk->harga * $item->jumlah;
        });

        $adminFee = 1000;

        return view('customer.cart', compact('cartItems', 'subtotal', 'adminFee'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $pelanggan = Auth::user()->pelanggan;

        if (!$pelanggan) {
            return back()->with('error', 'Profil pelanggan tidak ditemukan');
        }

        $produk = Produk::findOrFail($request->produk_id);

        if (!$produk->is_aktif) {
            return back()->with('error', 'Produk tidak tersedia');
        }

        if ($produk->stok < $request->jumlah) {
            return back()->with('error', 'Stok tidak mencukupi. Stok tersisa: ' . $produk->stok);
        }

        DB::beginTransaction();
        try {
            $cartItem = Keranjang::where('pelanggan_id', $pelanggan->id)
                ->where('produk_id', $request->produk_id)
                ->first();

            if ($cartItem) {
                $newQuantity = $cartItem->jumlah + $request->jumlah;

                if ($produk->stok < $newQuantity) {
                    DB::rollBack();
                    return back()->with('error', 'Stok tidak mencukupi. Stok tersisa: ' . $produk->stok);
                }

                $cartItem->update(['jumlah' => $newQuantity]);
                $message = 'Jumlah produk di keranjang berhasil diperbarui';
            } else {
                Keranjang::create([
                    'pelanggan_id' => $pelanggan->id,
                    'produk_id' => $request->produk_id,
                    'jumlah' => $request->jumlah,
                ]);
                $message = 'Produk berhasil ditambahkan ke keranjang';
            }

            DB::commit();
            return back()->with('success', $message);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Add to cart error: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat menambahkan produk');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $pelanggan = Auth::user()->pelanggan;

        $cartItem = Keranjang::where('pelanggan_id', $pelanggan->id)
            ->where('id', $id)
            ->with('produk')
            ->firstOrFail();

        if ($cartItem->produk->stok < $request->jumlah) {
            return response()->json([
                'success' => false,
                'error' => 'Stok tidak mencukupi. Stok tersisa: ' . $cartItem->produk->stok
            ], 400);
        }

        $cartItem->update(['jumlah' => $request->jumlah]);

        $newSubtotal = $cartItem->produk->harga * $request->jumlah;

        $cartTotal = Keranjang::where('pelanggan_id', $pelanggan->id)
            ->with('produk')
            ->get()
            ->sum(function ($item) {
                return $item->produk->harga * $item->jumlah;
            });

        return response()->json([
            'success' => true,
            'subtotal' => $newSubtotal,
            'cart_total' => $cartTotal,
            'message' => 'Keranjang berhasil diperbarui'
        ]);
    }

    public function remove($id)
    {
        $pelanggan = Auth::user()->pelanggan;

        $cartItem = Keranjang::where('pelanggan_id', $pelanggan->id)
            ->where('id', $id)
            ->firstOrFail();

        $cartItem->delete();

        return back()->with('success', 'Produk berhasil dihapus dari keranjang');
    }

    public function clear()
    {
        $pelanggan = Auth::user()->pelanggan;
        Keranjang::where('pelanggan_id', $pelanggan->id)->delete();

        return back()->with('success', 'Keranjang berhasil dikosongkan');
    }

    public function count()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        $pelanggan = Auth::user()->pelanggan;

        if (!$pelanggan) {
            return response()->json(['count' => 0]);
        }

        $count = Keranjang::where('pelanggan_id', $pelanggan->id)
            ->sum('jumlah');

        return response()->json(['count' => $count]);
    }
}
