<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Keranjang;
use App\Models\AlamatPelanggan;
use App\Models\Pembayaran;
use App\Models\Pengiriman;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\Kecamatan;
use App\Services\OngkirService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    protected $ongkirService;

    public function __construct(OngkirService $ongkirService)
    {
        $this->ongkirService = $ongkirService;
    }

    public function index()
    {
        $pelanggan = Auth::user()->pelanggan;

        $cartItems = Keranjang::with(['produk.fotoProduks', 'produk.kategori'])
            ->where('pelanggan_id', $pelanggan->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Keranjang Anda kosong');
        }

        foreach ($cartItems as $item) {
            if ($item->produk->stok < $item->jumlah) {
                return redirect()->route('cart.index')
                    ->with('error', 'Stok ' . $item->produk->nama_produk . ' tidak mencukupi');
            }
        }

        $addresses = AlamatPelanggan::with(['provinsi', 'kota', 'kecamatan'])
            ->where('pelanggan_id', $pelanggan->id)
            ->get();

        $subtotal = $cartItems->sum(function ($item) {
            return $item->produk->harga * $item->jumlah;
        });

        $adminFee = 1000;

        $provinces = Provinsi::all();

        return view('customer.checkout', compact(
            'cartItems',
            'addresses',
            'subtotal',
            'adminFee',
            'provinces'
        ));
    }

    public function process(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string',
            'postal_code' => 'nullable|string|max:10',
            'courier' => 'required|in:reguler,express',
            'payment_method' => 'required|in:transfer,cod',
        ]);

        $pelanggan = Auth::user()->pelanggan;

        $cartItems = Keranjang::with('produk')
            ->where('pelanggan_id', $pelanggan->id)
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Keranjang Anda kosong');
        }

        DB::beginTransaction();
        try {
            $alamat = $this->createOrGetAddress($request, $pelanggan->id);

            $subtotal = $cartItems->sum(function ($item) {
                return $item->produk->harga * $item->jumlah;
            });

            $ongkosKirim = $request->courier === 'express' ? 20000 : 10000;
            $pajak = $subtotal * 0.11;
            $adminFee = 1000;
            $total = $subtotal + $ongkosKirim + $pajak + $adminFee;

            $nomorPesanan = 'ORD-' . date('Ymd') . '-' . str_pad(
                Pesanan::whereDate('created_at', today())->count() + 1,
                4,
                '0',
                STR_PAD_LEFT
            );

            $pesanan = Pesanan::create([
                'nomor_pesanan' => $nomorPesanan,
                'pelanggan_id' => $pelanggan->id,
                'alamat_id' => $alamat->id,
                'subtotal' => $subtotal,
                'ongkos_kirim' => $ongkosKirim,
                'pajak' => $pajak,
                'diskon' => 0,
                'total' => $total,
                'metode_pembayaran' => $request->payment_method === 'cod' ? 'cod' : 'transfer',
                'status_pembayaran' => 'pending',
                'status_pesanan' => 'pending',
                'catatan_pelanggan' => $request->notes ?? null,
            ]);

            foreach ($cartItems as $item) {
                if ($item->produk->stok < $item->jumlah) {
                    throw new \Exception('Stok ' . $item->produk->nama_produk . ' tidak mencukupi');
                }

                DetailPesanan::create([
                    'pesanan_id' => $pesanan->id,
                    'produk_id' => $item->produk_id,
                    'nama_produk' => $item->produk->nama_produk,
                    'kode_produk' => $item->produk->kode_produk,
                    'harga' => $item->produk->harga,
                    'jumlah' => $item->jumlah,
                    'subtotal' => $item->produk->harga * $item->jumlah,
                ]);

                $item->produk->decrement('stok', $item->jumlah);
            }

            $pembayaran = Pembayaran::create([
                'pesanan_id' => $pesanan->id,
                'jumlah' => $total,
                'status' => 'pending',
                'metode_pembayaran' => $request->payment_method,
            ]);

            // if ($request->payment_method === 'transfer' && config('services.midtrans.server_key')) {
            //     $this->createMidtransTransaction($pesanan, $pembayaran);
            // }

            $estimasiHari = $request->courier === 'express' ? 1 : 3;
            Pengiriman::create([
                'pesanan_id' => $pesanan->id,
                'kode_kurir' => $request->courier === 'express' ? 'express' : 'reguler',
                'nama_kurir' => $request->courier === 'express' ? 'Express (Next Day)' : 'Reguler (JNE/J&T)',
                'tipe_layanan' => $request->courier,
                'biaya_ongkir' => $ongkosKirim,
                'estimasi_hari' => $estimasiHari,
                'estimasi_tiba' => now()->addDays($estimasiHari),
                'status' => 'pending',
            ]);

            Keranjang::where('pelanggan_id', $pelanggan->id)->delete();

            DB::commit();

            return redirect()->route('order.success', $pesanan->id)
                ->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Checkout error: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    private function createOrGetAddress(Request $request, $pelangganId)
    {
        $provinsi = Provinsi::firstOrCreate(
            ['nama_provinsi' => 'Jawa Timur'],
            ['kode_provinsi' => 'JT']
        );

        $kota = Kota::firstOrCreate(
            ['nama_kota' => $request->city, 'provinsi_id' => $provinsi->id],
            ['kode_kota' => 'KT' . time(), 'tipe' => 'Kota']
        );

        $kecamatan = Kecamatan::firstOrCreate(
            ['nama_kecamatan' => 'Default', 'kota_id' => $kota->id],
            ['kode_kecamatan' => 'KC' . time()]
        );

        return AlamatPelanggan::create([
            'pelanggan_id' => $pelangganId,
            'label' => 'Alamat Checkout',
            'nama_penerima' => $request->name,
            'telepon' => $request->phone,
            'alamat_lengkap' => $request->address,
            'kecamatan_id' => $kecamatan->id,
            'kota_id' => $kota->id,
            'provinsi_id' => $provinsi->id,
            'kode_pos' => $request->postal_code ?? '00000',
            'alamat_utama' => false,
        ]);
    }

    // private function createMidtransTransaction($pesanan, $pembayaran)
    // {
    //     try {
    //         Config::$serverKey = config('services.midtrans.server_key');
    //         Config::$isProduction = config('services.midtrans.is_production', false);
    //         Config::$isSanitized = true;
    //         Config::$is3ds = true;

    //         $params = [
    //             'transaction_details' => [
    //                 'order_id' => $pesanan->nomor_pesanan,
    //                 'gross_amount' => (int) $pesanan->total,
    //             ],
    //             'customer_details' => [
    //                 'first_name' => $pesanan->pelanggan->nama,
    //                 'email' => $pesanan->pelanggan->user->email,
    //                 'phone' => $pesanan->alamat->telepon,
    //             ],
    //         ];

    //         $snapToken = Snap::getSnapToken($params);

    //         $pembayaran->update([
    //             'snap_token' => $snapToken,
    //             'nama_payment_gateway' => 'midtrans',
    //         ]);
    //     } catch (\Exception $e) {
    //         Log::error('Midtrans Error: ' . $e->getMessage());
    //     }
    // }

    public function success($id)
    {
        $pelanggan = Auth::user()->pelanggan;

        $pesanan = Pesanan::with([
            'detailPesanans.produk.fotoProduks',
            'alamat.provinsi',
            'alamat.kota',
            'alamat.kecamatan',
            'pembayaran',
            'pengiriman'
        ])
            ->where('pelanggan_id', $pelanggan->id)
            ->findOrFail($id);

        return view('customer.order-success', compact('pesanan'));
    }

    public function getCities($provinceId)
    {
        $cities = Kota::where('provinsi_id', $provinceId)->get();
        return response()->json($cities);
    }

    public function getDistricts($cityId)
    {
        $districts = Kecamatan::where('kota_id', $cityId)->get();
        return response()->json($districts);
    }

    public function calculateShipping(Request $request)
    {
        $request->validate([
            'kota_tujuan' => 'required|string',
            'berat' => 'required|numeric',
            'kurir' => 'required|in:reguler,express',
        ]);

        $result = $this->ongkirService->hitungOngkir(
            $request->kota_tujuan,
            $request->berat,
            $request->kurir
        );

        return response()->json([
            'success' => true,
            'data' => $result
        ]);
    }
}
