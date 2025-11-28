<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pelanggan = Auth::user()->pelanggan;

        if (!$pelanggan) {
            return redirect()->route('home')->with('error', 'Anda harus login sebagai pelanggan.');
        }
        $cartItems = Keranjang::with('produk.fotoUtama')
            ->where('pelanggan_id', $pelanggan->id)
            ->get();

        $subtotal = $cartItems->sum(function($item) {
            return $item->produk->harga * $item->jumlah;
        });

        return view('customer.cart', compact('cartItems', 'subtotal'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $pelanggan = Auth::user()->pelanggan;

        // Check if product already in cart
        $cartItem = Keranjang::where('pelanggan_id', $pelanggan->id)
            ->where('produk_id', $request->produk_id)
            ->first();
        if ($cartItem) {
            // Update quantity
            $cartItem->jumlah += $request->jumlah;
            $cartItem->save();
        } else {
            // Create new cart item
            Keranjang::create([
                'pelanggan_id' => $pelanggan->id,
                'produk_id' => $request->produk_id,
                'jumlah' => $request->jumlah,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan ke keranjang'
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
        ]);

        $pelanggan = Auth::user()->pelanggan;

        $cartItem = Keranjang::where('pelanggan_id', $pelanggan->id)
            ->where('id', $id)
            ->firstOrFail();
            $cartItem->update([
            'jumlah' => $request->jumlah
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Jumlah produk berhasil diupdate'
        ]);
    }

    public function destroy($id)
    {
        $pelanggan = Auth::user()->pelanggan;

        $cartItem = Keranjang::where('pelanggan_id', $pelanggan->id)
            ->where('id', $id)
            ->firstOrFail();

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus dari keranjang'
        ]);
    }
}


