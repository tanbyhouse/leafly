<?php
namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $pelanggan = Auth::user()->pelanggan;

        $orders = Pesanan::with(['detailPesanans.produk', 'pembayaran', 'pengiriman'])
            ->where('pelanggan_id', $pelanggan->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $pelanggan = Auth::user()->pelanggan;

        $order = Pesanan::with([
            'detailPesanans.produk.fotoUtama',
            'pembayaran',
            'pengiriman',
            'alamat.provinsi',
            'alamat.kota',
            'alamat.kecamatan'
        ])
        ->where('pelanggan_id', $pelanggan->id)
        ->findOrFail($id);

        return view('customer.orders.show', compact('order'));
    }
}

