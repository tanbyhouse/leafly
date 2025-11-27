@extends('layouts.app')

@section('title', 'Riwayat Transaksi - Leafly')

@section('content')
<div class="bg-leafly-cream min-h-screen pt-24 pb-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="text-3xl font-bold text-leafly-dark mb-6 flex items-center gap-3">
            <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Belanja
        </h1>

        <!-- filter status -->
        <div class="flex overflow-x-auto gap-2 pb-4 mb-6 custom-scrollbar">
            <button class="px-6 py-2 bg-leafly-dark text-white rounded-full text-sm font-bold whitespace-nowrap shadow-md">
                Semua
            </button>
            <button class="px-6 py-2 bg-white text-gray-600 hover:bg-gray-100 rounded-full text-sm font-bold whitespace-nowrap border border-gray-200">
                Menunggu Pembayaran
            </button>
            <button class="px-6 py-2 bg-white text-gray-600 hover:bg-gray-100 rounded-full text-sm font-bold whitespace-nowrap border border-gray-200">
                Dikemas
            </button>
            <button class="px-6 py-2 bg-white text-gray-600 hover:bg-gray-100 rounded-full text-sm font-bold whitespace-nowrap border border-gray-200">
                Dikirim
            </button>
            <button class="px-6 py-2 bg-white text-gray-600 hover:bg-gray-100 rounded-full text-sm font-bold whitespace-nowrap border border-gray-200">
                Selesai
            </button>
        </div>

        <!-- list pesanan -->
        <div class="space-y-6">
            @foreach($orders as $ord)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                    <div class="flex items-center gap-4 text-sm text-gray-600">
                        <span class="font-bold text-leafly-dark"><i class="fa-solid fa-receipt mr-1"></i> {{ $ord['id'] }}</span>
                        <span>|</span>
                        <span>{{ $ord['date'] }}</span>
                    </div>
                    
                    <!-- statsus -->
                    @php
                        $statusColor = match($ord['status']) {
                            'Menunggu Pembayaran' => 'bg-orange-100 text-orange-600 border-orange-200',
                            'Dikemas' => 'bg-blue-100 text-blue-600 border-blue-200',
                            'Dikirim' => 'bg-yellow-100 text-yellow-600 border-yellow-200',
                            'Selesai' => 'bg-green-100 text-green-600 border-green-200',
                            'Dibatalkan' => 'bg-red-100 text-red-600 border-red-200',
                            default => 'bg-gray-100 text-gray-600'
                        };
                    @endphp
                    <span class="px-3 py-1 rounded-full text-xs font-bold border {{ $statusColor }}">
                        {{ $ord['status'] }}
                    </span>
                </div>

                <div class="p-6">
                    <div class="flex flex-col md:flex-row justify-between gap-6">
                        <div class="flex items-start gap-4">
                            <div class="w-16 h-16 bg-leafly-cream rounded-lg flex items-center justify-center text-leafly-dark text-2xl">
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-sm md:text-base">{{ $ord['items'][0] }}</h3>
                                @if(count($ord['items']) > 1)
                                    <p class="text-xs text-gray-500 mt-1">+ {{ count($ord['items']) - 1 }} produk lainnya</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col items-end justify-center">
                            <span class="text-xs text-gray-500 mb-1">Total Belanja</span>
                            <span class="font-bold text-leafly-dark text-lg">Rp {{ number_format($ord['total'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- footer card -->
                <div class="px-6 py-4 border-t border-gray-100 flex justify-end gap-3">
                    <a href="{{ route('orders.show', $ord['id']) }}" class="px-4 py-2 text-sm font-bold text-leafly-dark border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Lihat Detail
                    </a>
                    
                    @if($ord['status'] == 'Menunggu Pembayaran')
                        <button class="px-4 py-2 text-sm font-bold text-white bg-leafly-dark rounded-lg hover:bg-leafly-gold hover:text-leafly-dark transition">
                            Bayar Sekarang
                        </button>
                    @elseif($ord['status'] == 'Dikirim')
                        <button class="px-4 py-2 text-sm font-bold text-white bg-leafly-dark rounded-lg hover:bg-leafly-gold hover:text-leafly-dark transition">
                            Pesanan Diterima
                        </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>
@endsection