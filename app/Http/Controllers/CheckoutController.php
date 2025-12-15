<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use App\Models\Payment;
use App\Models\Shipment;
use App\Models\Province;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $cartItems = Cart::with('product.images')
            ->where('user_id', $user->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang masih kosong');
        }

        $subtotal = $cartItems->sum(fn($i) => $i->product->price * $i->quantity);
        $adminFee = 1000;

        return view('customer.checkout', compact(
            'cartItems',
            'subtotal',
            'adminFee'
        ));
    }

    /* ===============================
     | LOCATION (DATABASE)
     =============================== */

    public function provinces()
    {
        return response()->json(
            Province::orderBy('name')->get(['id', 'name'])
        );
    }

    public function getCities($provinceId)
    {
        return response()->json(
            City::where('province_id', $provinceId)
                ->orderBy('name')
                ->get(['id', 'name'])
        );
    }

    /* ===============================
     | ONGKIR (LOCAL LOGIC)
     =============================== */
    public function ajaxOngkir(Request $request)
    {
        $request->validate([
            'city_id' => 'required|integer',
            'courier' => 'required|string',
        ]);

        // 👉 LOGIC ONGKIR SEDERHANA (BISA KAMU UBAH)
        $shippingCost = match ($request->courier) {
            'jne' => 10000,
            'pos' => 9000,
            'tiki' => 11000,
            default => 10000
        };

        return response()->json([
            'success' => true,
            'data' => [
                'cost' => $shippingCost,
                'service' => strtoupper($request->courier),
                'etd' => '2-3'
            ]
        ]);
    }

    /* ===============================
     | PROCESS CHECKOUT
     =============================== */
    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'district' => 'required',
            'shipping_cost' => 'required|integer|min:0',
            'payment_method' => 'required|in:cod,transfer',
        ]);

        DB::transaction(function () use ($request) {

            $user = Auth::user();

            $cartItems = Cart::with('product')
                ->where('user_id', $user->id)
                ->get();

            $subtotal = $cartItems->sum(fn($i) => $i->product->price * $i->quantity);
            $adminFee = 1000;
            $total = $subtotal + $adminFee + $request->shipping_cost;

            $address = Address::create([
                'user_id' => $user->id,
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'province_id' => $request->province_id,
                'city_id' => $request->city_id,
                'district' => $request->district,
                'postal_code' => $request->postal_code,
                'notes' => $request->notes,
            ]);

            $order = Order::create([
                'order_number' => 'ORD-' . now()->format('YmdHis'),
                'user_id' => $user->id,
                'address_id' => $address->id,
                'subtotal' => $subtotal,
                'shipping_cost' => $request->shipping_cost,
                'admin_fee' => $adminFee,
                'total' => $total,
                'payment_method' => $request->payment_method,
                'status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->product->price * $item->quantity,
                ]);
            }

            Shipment::create([
                'order_id' => $order->id,
                'courier' => 'local',
                'shipping_cost' => $request->shipping_cost,
                'status' => 'pending',
            ]);

            Payment::create([
                'order_id' => $order->id,
                'amount' => $total,
                'method' => $request->payment_method,
                'status' => 'pending',
            ]);

            Cart::where('user_id', $user->id)->delete();
        });

        return redirect()->route('orders.success', 1);
    }

    public function success($id)
    {
        return view('customer.order-success');
    }
}
