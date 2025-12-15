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
use App\Models\District;
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

        return view('customer.checkout', compact('cartItems', 'subtotal', 'adminFee'));
    }

    /* =========================
     | LOCATION (DB)
     ========================= */
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

    /* =========================
     | ONGKIR (LOCAL LOGIC)
     ========================= */
    public function ajaxOngkir(Request $request)
    {
        $request->validate([
            'city_id' => 'required|integer',
            'courier' => 'required|string',
        ]);

        $shippingCost = match ($request->courier) {
            'jne'  => 10000,
            'pos'  => 9000,
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

    /* =========================
     | PROCESS CHECKOUT
     ========================= */
    public function process(Request $request)
    {
        // Sesuai frontend kamu (district masih text), dan sesuai DB (address_detail wajib)
        $request->validate([
            'label'          => 'required|string|max:50',
            'name'           => 'required|string|max:100',
            'phone'          => 'required|string|max:20',
            'address'        => 'required|string',
            'province_id'    => 'required|exists:provinces,id',
            'city_id'        => 'required|exists:cities,id',
            'district'       => 'required|string|max:100',
            'postal_code'    => 'required|string|max:10',

            'shipping_cost'  => 'required|integer|min:0',
            'payment_method' => 'required|in:cod,transfer,gateway',

            // hidden input di form kamu ada, jadi kita validasi biar aman
            'courier'        => 'nullable|string|max:50',
            'service'        => 'nullable|string|max:50',
            'notes'          => 'nullable|string',
        ]);

        // ✅ Kunci: return dari DB::transaction supaya $order pasti kebawa keluar
        $order = DB::transaction(function () use ($request) {

            $user = Auth::user();

            $cartItems = Cart::with('product')
                ->where('user_id', $user->id)
                ->get();

            if ($cartItems->isEmpty()) {
                abort(400, 'Keranjang kosong');
            }

            $subtotal = $cartItems->sum(fn($i) => $i->product->price * $i->quantity);
            $adminFee = 1000; // masih dipakai di tampilan checkout
            $shipping = (int) $request->shipping_cost;
            $total = $subtotal + $adminFee + $shipping;

            // district input text -> cari/buat district_id
            $district = District::firstOrCreate(
                [
                    'city_id' => $request->city_id,
                    'name'    => trim($request->district),
                ]
            );

            $address = Address::create([
                'user_id'         => $user->id,
                'label'           => $request->label,
                'recipient_name'  => $request->name,
                'recipient_phone' => $request->phone,
                'address_detail'  => $request->address,
                'province_id'     => $request->province_id,
                'city_id'         => $request->city_id,
                'district_id'     => $district->id,
                'postal_code'     => $request->postal_code,
                'is_primary'      => false,
            ]);

            // order_number biar minim bentrok
            $orderNumber = 'ORD-' . now()->format('YmdHis') . '-' . random_int(100, 999);

            $order = Order::create([
                'order_number'   => $orderNumber,
                'user_id'        => $user->id,
                'address_id'     => $address->id,
                'subtotal'       => $subtotal,
                'shipping_cost'  => $shipping,
                'total'          => $total,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'order_status'   => 'pending',
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $item->product_id,
                    'price'      => $item->product->price,
                    'quantity'   => $item->quantity,
                    'subtotal'   => $item->product->price * $item->quantity,
                ]);
            }

            Shipment::create([
                'order_id' => $order->id,
                'courier'  => $request->courier ?? 'local',
                'status'   => 'pending',
            ]);

            Payment::create([
                'order_id' => $order->id,
                'amount'   => $total,
                'method'   => $request->payment_method,
                'status'   => 'pending',
            ]);

            Cart::where('user_id', $user->id)->delete();

            return $order;
        });

        // ✅ Redirect ke order yang baru dibuat
        return redirect()->route('orders.success', $order->id);
    }

    public function success($id)
    {
        $pesanan = Order::with([
            'items.product.images',
            'address.district',
            'address.city',
            'address.province',
            'payment',
            'shipment',
        ])->findOrFail($id);

        return view('customer.order-success', compact('pesanan'));
    }
}
