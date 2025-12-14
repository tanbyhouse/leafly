<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        // DEFAULT (WAJIB ADA)
        $cartItems = collect();
        $subtotal = 0;
        $adminFee = 1000;

        // JIKA USER LOGIN
        if (Auth::check() && Auth::user()->pelanggan) {
            $pelanggan = Auth::user()->pelanggan;

            $cartItems = Keranjang::with(['product.images', 'product.category'])
                ->where('pelanggan_id', $pelanggan->id)
                ->get();

            $subtotal = $cartItems->sum(
                fn($item) =>
                $item->product->harga * $item->jumlah
            );
        }

        // PASTIKAN SEMUA VARIABEL TERKIRIM
        return view('customer.cart', compact(
            'cartItems',
            'subtotal',
            'adminFee'
        ));
    }
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        if (auth()->check()) {
            // USER LOGIN
            $cart = Cart::firstOrNew([
                'user_id'    => auth()->id(),
                'product_id' => $request->product_id,
            ]);

            $cart->quantity += $request->quantity;
            $cart->save();
        } else {
            // GUEST → SESSION
            $cart = session()->get('cart', []);

            $productId = $request->product_id;

            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += $request->quantity;
            } else {
                $product = Product::findOrFail($productId);
                $cart[$productId] = [
                    'product'  => $product,
                    'quantity' => $request->quantity,
                ];
            }

            session()->put('cart', $cart);
        }

        return back()->with('success', 'Produk ditambahkan ke keranjang');
    }

    public function count()
    {
        if (auth()->check()) {
            $count = Cart::where('user_id', auth()->id())->sum('quantity');
        } else {
            $cart = session('cart', []);
            $count = collect($cart)->sum('quantity');
        }

        return response()->json(['count' => $count]);
    }
}
