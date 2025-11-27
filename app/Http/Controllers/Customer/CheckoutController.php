<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Keranjang;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Pembayaran;
use App\Models\Pengiriman;
use App\Models\AlamatPelanggan;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pelanggan = Auth::user()->pelanggan;

        $cartItems = Keranjang::with('produk.fotoUtama')
            ->where('pelanggan_id', $pelanggan->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $subtotal = $cartItems->sum(function($item) {
            return $item->produk->harga * $item->jumlah;
        });

        $adminFee = 1000;

        // Get customer addresses
        $addresses = AlamatPelanggan::with(['provinsi', 'kota', 'kecamatan'])
            ->where('pelanggan_id', $pelanggan->id)
            ->get();

        // Get provinces for form
        $provinsis = Provinsi::with('kotas.kecamatans')->get();

        return view('customer.checkout', compact('cartItems', 'subtotal', 'adminFee', 'addresses', 'provinsis'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'alamat_id' => 'required|exists:alamat_pelanggans,id',
            'metode_pembayaran' => 'required|in:cod,transfer,payment_gateway',
            'courier' => 'required',
            'shipping_cost' => 'required|numeric',
        ]);
        $pelanggan = Auth::user()->pelanggan;

        $cartItems = Keranjang::with('produk')
            ->where('pelanggan_id', $pelanggan->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Keranjang kosong'], 400);
        }

        DB::beginTransaction();
        try {
            // Calculate totals
            $subtotal = $cartItems->sum(function($item) {
                return $item->produk->harga * $item->jumlah;
            });

            $adminFee = 1000;
            $shippingCost = $request->shipping_cost;
            $total = $subtotal + $adminFee + $shippingCost;
           // Create order
            $pesanan = Pesanan::create([
                'nomor_pesanan' => 'ORD-' . strtoupper(Str::random(8)),
                'pelanggan_id' => $pelanggan->id,
                'alamat_id' => $request->alamat_id,
                'subtotal' => $subtotal,
                'ongkos_kirim' => $shippingCost,
                'pajak' => 0,
                'diskon' => 0,
                'total' => $total,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status_pembayaran' => $request->metode_pembayaran === 'cod' ? 'pending' : 'pending',
                'status_pesanan' => 'pending',
            ]);

           // Create order details
            foreach ($cartItems as $item) {
                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'produk_id' => $item->produk_id,
                    'nama_produk' => $item->produk->nama_produk,
                    'kode_produk' => $item->produk->kode_produk,
                    'harga' => $item->produk->harga,
                    'jumlah' => $item->jumlah,
                    'subtotal' => $item->produk->harga * $item->jumlah,
                ]);

                // Update stock
                $item->produk->decrement('stok', $item->jumlah);
            }
        // Create payment record
            Pembayaran::create([
                'pesanan_id' => $pesanan->id,
                'jumlah' => $total,
                'status' => 'pending',
                'metode_pembayaran' => $request->metode_pembayaran,
            ]);

            // Create shipping record
            Pengiriman::create([
                'pesanan_id' => $pesanan->id,
                'kode_kurir' => $request->courier,
                'nama_kurir' => $request->courier === 'reguler' ? 'JNE/J&T' : 'Express',
                'tipe_layanan' => $request->courier,
                'biaya_ongkir' => $shippingCost,
                'status' => 'pending',
            ]);

            // Clear cart
            Keranjang::where('pelanggan_id', $pelanggan->id)->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat',
                'order_id' => $pesanan->id,
                'order_number' => $pesanan->nomor_pesanan,
            ]);
       } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }
}


