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
        $cartItems = Cart::with('product.images', 'product.category')
            ->where(function ($q) {
                if (Auth::check()) {
                    $q->where('user_id', Auth::id());
                } else {
                    $q->where('session_id', session()->getId());
                }
            })
            ->get();

        $subtotal = $cartItems->sum(
            fn($item) => $item->product->price * $item->quantity
        );

        $adminFee = 1000;

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
            $cart = Cart::firstOrNew([
                'user_id'    => auth()->id(),
                'product_id' => $request->product_id,
            ]);

            $cart->quantity += $request->quantity;
            $cart->save();

            $count = Cart::where('user_id', auth()->id())->sum('quantity');
        } else {
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
            $count = collect($cart)->sum('quantity');
        }

        return response()->json([
            'success' => true,
            'count'   => $count
        ]);
    }

    public function count()
    {
        return response()->json([
            'count' => $this->countItems()
        ]);
    }

    private function countItems()
    {
        return Cart::where(function ($q) {
            if (Auth::check()) {
                $q->where('user_id', Auth::id());
            } else {
                $q->where('session_id', session()->getId());
            }
        })->sum('quantity');
    }

    public function remove($id)
    {
        if (auth()->check()) {
            Cart::where('id', $id)
                ->where('user_id', auth()->id())
                ->delete();
        } else {
            // GUEST → SESSION
            $cart = session()->get('cart', []);
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()
            ->route('cart.index')
            ->with('success', 'Produk berhasil dihapus dari keranjang');
    }
}
