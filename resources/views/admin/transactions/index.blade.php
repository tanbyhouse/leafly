@extends('layouts.admin')

@section('title', 'Manajemen Transaksi')
@section('header', 'Daftar Pesanan Masuk')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    
    <!-- filter tab -->
    <div class="flex overflow-x-auto border-b border-gray-100 bg-gray-50 px-4 pt-4 gap-2 custom-scrollbar">
        <button class="px-4 py-2 bg-white border-t border-x border-gray-200 rounded-t-lg font-bold text-leafly-dark shadow-sm">
            Semua
        </button>
        <button class="px-4 py-2 text-gray-500 hover:text-leafly-dark font-medium transition">
            Menunggu
        </button>
        <button class="px-4 py-2 text-gray-500 hover:text-leafly-dark font-medium transition">
            Dikemas
        </button>
        <button class="px-4 py-2 text-gray-500 hover:text-leafly-dark font-medium transition">
            Dikirim
        </button>
        <button class="px-4 py-2 text-gray-500 hover:text-leafly-dark font-medium transition">
            Selesai
        </button>
    </div>

    <!-- toolbar -->
    <div class="p-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="relative w-full md:w-64">
            <input type="text" placeholder="Cari ID / Nama Customer..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-leafly-green">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400"></i>
        </div>
        <button class="flex items-center gap-2 text-gray-500 hover:text-leafly-dark">
            <i class="fa-solid fa-filter"></i> Filter Tanggal
        </button>
    </div>

    <!-- table data -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="bg-gray-50 text-gray-700 font-bold uppercase">
                <tr>
                    <th class="px-6 py-3">ID Pesanan</th>
                    <th class="px-6 py-3">Pelanggan</th>
                    <th class="px-6 py-3">Total</th>
                    <th class="px-6 py-3 text-center">Metode</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($transactions as $trx)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-bold text-leafly-dark">{{ $trx['id'] }}</td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-800">{{ $trx['customer'] }}</div>
                        <div class="text-xs text-gray-500">{{ $trx['date'] }}</div>
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-800">
                        Rp {{ number_format($trx['total'], 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-xs font-bold px-2 py-1 rounded border {{ $trx['payment_method'] == 'COD' ? 'bg-orange-50 text-orange-600 border-orange-100' : 'bg-blue-50 text-blue-600 border-blue-100' }}">
                            {{ $trx['payment_method'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @php
                            $color = match($trx['status']) {
                                'Menunggu Pembayaran' => 'bg-yellow-100 text-yellow-700',
                                'Dikemas' => 'bg-blue-100 text-blue-700',
                                'Dikirim' => 'bg-purple-100 text-purple-700',
                                'Selesai' => 'bg-green-100 text-green-700',
                                default => 'bg-gray-100 text-gray-700'
                            };
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $color }}">
                            {{ $trx['status'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('admin.transactions.show', $trx['id']) }}" class="inline-flex items-center gap-2 px-3 py-1 bg-leafly-dark text-white rounded hover:bg-leafly-gold hover:text-leafly-dark transition font-medium text-xs">
                            Proses <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="p-6 border-t border-gray-100 flex justify-end">
        <div class="flex gap-2">
            <button class="px-3 py-1 border rounded hover:bg-gray-50 disabled:opacity-50" disabled>Prev</button>
            <button class="px-3 py-1 bg-leafly-dark text-white rounded">1</button>
            <button class="px-3 py-1 border rounded hover:bg-gray-50">Next</button>
        </div>
    </div>
</div>
@endsection