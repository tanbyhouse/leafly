@extends('layouts.app')

@section('title', 'Pesanan Berhasil - Leafly')

@section('content')
    <div class="bg-leafly-cream min-h-screen pt-24 pb-12">
        <div class="max-w-4xl mx-auto px-4">

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <!-- Success Header -->
                <div class="bg-gradient-to-r from-leafly-dark to-green-700 text-white p-8 text-center">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fa-solid fa-check text-4xl text-green-600"></i>
                    </div>
                    <h1 class="text-3xl font-bold mb-2">Pesanan Berhasil Dibuat!</h1>
                    <p class="text-green-100">Terima kasih telah berbelanja di Leafly</p>
                </div>

                <!-- Order Details -->
                <div class="p-8">
                    <div class="border-b pb-6 mb-6">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="text-gray-500">Nomor Pesanan:</span>
                                <p class="font-bold text-lg text-leafly-dark">
                                    {{ $pesanan->order_number }}
                                </p>
                            </div>
                            <div>
                                <span class="text-gray-500">Tanggal Pesanan:</span>
                                <p class="font-bold">
                                    {{ optional($pesanan->created_at)->format('d M Y, H:i') }}
                                </p>
                            </div>
                            <div>
                                <span class="text-gray-500">Status Pembayaran:</span>
                                <span class="px-3 py-1 rounded-full text-xs font-bold
                                                    {{ $pesanan->payment_status === 'paid'
        ? 'bg-green-100 text-green-700'
        : 'bg-yellow-100 text-yellow-700' }}">
                                    {{ ucfirst($pesanan->payment_status) }}
                                </span>
                            </div>
                            <div>
                                <span class="text-gray-500">Status Pesanan:</span>
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">
                                    {{ ucfirst($pesanan->order_status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Items -->
                    <h3 class="font-bold text-lg mb-4 text-leafly-dark">Product yang Dibeli</h3>
                    <div class="space-y-3 mb-6">
                        @foreach ($pesanan->items as $item)
                            <div class="flex items-center gap-4 p-3 bg-gray-50 rounded-lg">
                                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                    @if ($item->product && $item->product->images->isNotEmpty())
                                        <img src="{{ asset('storage/' . $item->product->images->first()->path) }}"
                                            alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded">
                                    @else
                                        <i class="fa-solid fa-seedling text-2xl text-leafly-green"></i>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold">
                                        {{ $item->product->name }}
                                    </h4>
                                    <p class="text-sm text-gray-500">
                                        {{ $item->quantity }}x @ Rp
                                        {{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <p class="font-bold text-leafly-dark">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <!-- Address -->
                    <div class="border-t pt-6 mb-6">
                        <h3 class="font-bold mb-3">Alamat Pengiriman</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="font-bold">{{ $pesanan->address->recipient_name }}</p>
                            <p class="text-sm text-gray-600">{{ $pesanan->address->recipient_phone }}</p>
                            <p class="text-sm text-gray-600 mt-2">
                                {{ $pesanan->address->address_detail }}
                            </p>
                            <p class="text-sm text-gray-600">
                                {{ $pesanan->address->district->name }},
                                {{ $pesanan->address->city->name }},
                                {{ $pesanan->address->province->name }}
                                {{ $pesanan->address->postal_code }}
                            </p>
                        </div>
                    </div>

                    <!-- Payment Summary -->
                    <div class="border-t pt-6">
                        <h3 class="font-bold mb-4">Rincian Pembayaran</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal Product</span>
                                <span class="font-medium">
                                    Rp {{ number_format($pesanan->subtotal, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Ongkos Kirim</span>
                                <span class="font-medium">
                                    Rp {{ number_format($pesanan->shipping_cost, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="flex justify-between text-lg font-bold text-leafly-dark pt-3 border-t">
                                <span>Total Pembayaran</span>
                                <span>
                                    Rp {{ number_format($pesanan->total, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="mt-6 p-4 bg-yellow-50 border-l-4 border-yellow-400 rounded">
                        <p class="font-bold text-yellow-800 mb-1">
                            Metode Pembayaran: {{ strtoupper($pesanan->payment_method) }}
                        </p>
                        @if ($pesanan->payment_method === 'transfer')
                            <p class="text-sm text-yellow-700">
                                Silakan lakukan transfer ke rekening yang akan dikirimkan via email/WhatsApp
                            </p>
                        @else
                            <p class="text-sm text-yellow-700">
                                Siapkan uang pas saat kurir datang mengantarkan pesanan Anda
                            </p>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 flex gap-4">
                        <a href="{{ route('home') }}"
                            class="flex-1 text-center bg-gray-200 text-gray-700 font-bold py-3 rounded-lg hover:bg-gray-300 transition">
                            Kembali ke Beranda
                        </a>
                        <a href="{{ route('products.index') }}"
                            class="flex-1 text-center bg-leafly-dark text-white font-bold py-3 rounded-lg hover:bg-leafly-gold hover:text-leafly-dark transition">
                            Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
