@extends('layouts.app')

@section('title', 'Detail Transaksi - Leafly')

@section('content')
<div class="bg-leafly-cream min-h-screen pt-24 pb-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <a href="{{ route('orders.index') }}" class="inline-flex items-center text-gray-500 hover:text-leafly-dark mb-6 font-medium transition">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Riwayat
        </a>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden border-t-4 border-leafly-dark">
            
        <!-- header invoice -->
            <div class="p-8 border-b border-gray-100 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-leafly-dark">Detail Pesanan</h1>
                    <p class="text-gray-500 text-sm mt-1">ID Pesanan: <span class="font-mono font-bold text-gray-800">{{ $order['id'] }}</span></p>
                </div>
                <div class="text-right">
                    <span class="block text-xs text-gray-500 uppercase font-bold tracking-wider">Status Pesanan</span>
                    <span class="inline-block px-4 py-1 mt-1 rounded-full text-sm font-bold bg-orange-100 text-orange-600">
                        {{ $order['status'] }}
                    </span>
                </div>
            </div>

            <!-- timeline -->
            <div class="bg-gray-50 px-8 py-6 border-b border-gray-100">
                <div class="flex justify-between items-center relative">
                    <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-200 -z-10"></div>
                    
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full bg-leafly-dark text-white flex items-center justify-center text-xs z-10 border-4 border-gray-50"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                        <span class="text-xs font-bold mt-2 text-leafly-dark">Dipesan</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full bg-gray-300 text-white flex items-center justify-center text-xs z-10 border-4 border-gray-50"><i class="fa-solid fa-box"></i></div>
                        <span class="text-xs font-bold mt-2 text-gray-400">Dikemas</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full bg-gray-300 text-white flex items-center justify-center text-xs z-10 border-4 border-gray-50"><i class="fa-solid fa-truck"></i></div>
                        <span class="text-xs font-bold mt-2 text-gray-400">Dikirim</span>
                    </div>
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full bg-gray-300 text-white flex items-center justify-center text-xs z-10 border-4 border-gray-50"><i class="fa-solid fa-check"></i></div>
                        <span class="text-xs font-bold mt-2 text-gray-400">Selesai</span>
                    </div>
                </div>
            </div>

            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- info pengiriman -->
                <div>
                    <h3 class="font-bold text-gray-800 mb-3">Info Pengiriman</h3>
                    <div class="text-sm text-gray-600 space-y-2">
                        <p><span class="font-medium text-gray-800">Kurir:</span> {{ $order['courier'] }}</p>
                        <p><span class="font-medium text-gray-800">No. Resi:</span> {{ $order['resi'] }}</p>
                        <p><span class="font-medium text-gray-800">Alamat:</span><br>
                        Jl. Kalimantan No. 37, Kampus Tegalboto, Sumbersari, Jember, Jawa Timur (68121)</p>
                    </div>
                </div>

                <!-- info pembayaran -->
                <div>
                    <h3 class="font-bold text-gray-800 mb-3">Info Pembayaran</h3>
                    <div class="text-sm text-gray-600 space-y-2">
                        <p><span class="font-medium text-gray-800">Metode:</span> {{ $order['payment_method'] }}</p>
                        <p><span class="font-medium text-gray-800">Waktu:</span> {{ $order['date'] }} 14:30 WIB</p>
                    </div>
                </div>
            </div>

            <!-- daftar produk -->
            <div class="px-8 pb-8">
                <h3 class="font-bold text-gray-800 mb-4">Produk Dibeli</h3>
                <div class="border border-gray-200 rounded-lg overflow-hidden">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 text-gray-500 font-bold uppercase">
                            <tr>
                                <th class="px-4 py-3">Produk</th>
                                <th class="px-4 py-3 text-center">Qty</th>
                                <th class="px-4 py-3 text-right">Harga</th>
                                <th class="px-4 py-3 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($order['items'] as $item)
                            <tr>
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $item['name'] }}</td>
                                <td class="px-4 py-3 text-center text-gray-600">{{ $item['qty'] }}</td>
                                <td class="px-4 py-3 text-right text-gray-600">Rp {{ number_format($item['price'], 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-right font-bold text-gray-800">Rp {{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ringkasan biaya -->
            <div class="px-8 pb-8 flex justify-end">
                <div class="w-full md:w-1/2 space-y-2 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal Produk</span>
                        <span>Rp {{ number_format($order['subtotal'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Ongkos Kirim</span>
                        <span>Rp {{ number_format($order['shipping_cost'], 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between font-bold text-leafly-dark text-lg pt-4 border-t border-gray-200 mt-2">
                        <span>Total Bayar</span>
                        <span>Rp {{ number_format($order['grand_total'], 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <!-- ini buat kalau belum bayar -->
            @if($order['status'] == 'Menunggu Pembayaran')
            <div class="p-4 bg-orange-50 border-t border-orange-100 text-center">
                <p class="text-orange-800 text-sm mb-3">Segera lakukan pembayaran sebelum <b>28 Nov 2025 14:30</b></p>
                <button class="bg-leafly-dark text-white font-bold py-2 px-8 rounded-full hover:bg-leafly-gold hover:text-leafly-dark transition">
                    Bayar Sekarang
                </button>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection