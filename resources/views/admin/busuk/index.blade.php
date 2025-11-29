@extends('layouts.admin')

@section('title', 'Produk Busuk')
@section('header', 'Laporan Produk Busuk')

@section('content')

@if(session('success'))
<div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm relative">
    <p class="font-bold">Berhasil!</p>
    <p>{{ session('success') }}</p>
    <button onclick="this.parentElement.remove()" class="absolute top-0 right-0 mt-4 mr-4 text-green-700 font-bold">&times;</button>
</div>
@endif

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    
    <!-- toolbar -->
    <div class="p-6 flex flex-col md:flex-row justify-between items-center gap-4 border-b border-gray-100">
        <div class="relative w-full md:w-64">
            <input type="text" placeholder="Cari laporan..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-leafly-green">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400"></i>
        </div>

        <a href="{{ route('admin.busuk.create') }}" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition font-bold shadow-md flex items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation"></i> Catat Produk Busuk
        </a>
    </div>

    <!-- table data -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="bg-gray-50 text-gray-700 font-bold uppercase">
                <tr>
                    <th class="px-6 py-3">Tanggal</th>
                    <th class="px-6 py-3">Nama Produk</th>
                    <th class="px-6 py-3 text-center">Jumlah (Qty)</th>
                    <th class="px-6 py-3">Keterangan</th>
                    <th class="px-6 py-3">Pelapor</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($productsBusuk as $item)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-medium">{{ $item['date'] }}</td>
                    <td class="px-6 py-4">
                        <span class="font-bold text-gray-800">{{ $item['product_name'] }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full font-bold text-xs">
                            -{{ $item['quantity'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-500 italic">"{{ $item['note'] }}"</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <i class="fa-solid fa-user-shield text-gray-400"></i> {{ $item['reported_by'] }}
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <form action="{{ route('admin.busuk.destroy', $item['id']) }}" method="POST" onsubmit="return confirm('Hapus laporan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 transition" title="Hapus Laporan">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection