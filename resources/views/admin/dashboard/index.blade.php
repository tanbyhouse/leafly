@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('header', 'Overview Dashboard')

@section('content')

<!-- statistik -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- penjualan -->
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-leafly-dark flex items-center justify-between">
        <div>
            <p class="text-gray-500 text-sm font-medium">Total Penjualan</p>
            <h3 class="text-2xl font-bold text-gray-800">Rp {{ number_format($stats['total_sales'], 0, ',', '.') }}</h3>
        </div>
        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-leafly-dark text-xl">
            <i class="fa-solid fa-money-bill-wave"></i>
        </div>
    </div>

    <!-- pesanan -->
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500 flex items-center justify-between">
        <div>
            <p class="text-gray-500 text-sm font-medium">Total Pesanan</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total_orders'] }}</h3>
        </div>
        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xl">
            <i class="fa-solid fa-cart-shopping"></i>
        </div>
    </div>

    <!-- produk -->
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-yellow-500 flex items-center justify-between">
        <div>
            <p class="text-gray-500 text-sm font-medium">Total Produk</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total_products'] }}</h3>
        </div>
        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600 text-xl">
            <i class="fa-solid fa-box-open"></i>
        </div>
    </div>

    <!-- pelanggan -->
    <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500 flex items-center justify-between">
        <div>
            <p class="text-gray-500 text-sm font-medium">Pelanggan</p>
            <h3 class="text-2xl font-bold text-gray-800">{{ $stats['total_customers'] }}</h3>
        </div>
        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 text-xl">
            <i class="fa-solid fa-users"></i>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- pesanan terbaru -->
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-lg text-gray-800">Pesanan Terbaru</h3>
            <a href="#" class="text-sm text-leafly-dark hover:underline">Lihat Semua</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 font-bold">
                    <tr>
                        <th class="px-4 py-3 rounded-l-lg">ID Pesanan</th>
                        <th class="px-4 py-3">Pelanggan</th>
                        <th class="px-4 py-3">Total</th>
                        <th class="px-4 py-3 text-center rounded-r-lg">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($recent_orders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 font-bold text-leafly-dark">#{{ $order['id'] }}</td>
                        <td class="px-4 py-3">{{ $order['user'] }}</td>
                        <td class="px-4 py-3">Rp {{ number_format($order['total'], 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($order['status'] == 'Selesai')
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-bold">Selesai</span>
                            @elseif($order['status'] == 'Dikemas')
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">Dikemas</span>
                            @else
                                <span class="bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-bold">Menunggu</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- quick actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-bold text-lg text-gray-800 mb-4">Quick Actions</h3>
        <div class="space-y-3">
            <a href="#" class="block w-full text-left px-4 py-3 bg-gray-50 hover:bg-leafly-dark hover:text-white rounded-lg transition duration-300 group">
                <i class="fa-solid fa-plus bg-white text-gray-600 group-hover:text-leafly-dark w-6 h-6 rounded-full inline-flex items-center justify-center mr-2 text-xs shadow-sm"></i>
                Tambah Produk Baru
            </a>
            <a href="#" class="block w-full text-left px-4 py-3 bg-gray-50 hover:bg-leafly-dark hover:text-white rounded-lg transition duration-300 group">
                <i class="fa-solid fa-user-plus bg-white text-gray-600 group-hover:text-leafly-dark w-6 h-6 rounded-full inline-flex items-center justify-center mr-2 text-xs shadow-sm"></i>
                Tambah Karyawan
            </a>
            <a href="#" class="block w-full text-left px-4 py-3 bg-gray-50 hover:bg-leafly-dark hover:text-white rounded-lg transition duration-300 group">
                <i class="fa-solid fa-file-export bg-white text-gray-600 group-hover:text-leafly-dark w-6 h-6 rounded-full inline-flex items-center justify-center mr-2 text-xs shadow-sm"></i>
                Export Laporan Bulanan
            </a>
        </div>
    </div>
</div>

@endsection