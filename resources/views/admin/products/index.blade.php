@extends('layouts.admin')

@section('title', 'Manajemen Produk')
@section('header', 'Daftar Produk')

@section('content')

<!-- alert session success -->
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
            <input type="text" placeholder="Cari nama produk..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-leafly-green">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400"></i>
        </div>

        <a href="{{ route('admin.products.create') }}" class="bg-leafly-dark text-white px-4 py-2 rounded-lg hover:bg-leafly-gold hover:text-leafly-dark transition font-bold shadow-md flex items-center gap-2">
            <i class="fa-solid fa-plus"></i> Tambah Produk
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-600">
            <thead class="bg-gray-50 text-gray-700 font-bold uppercase">
                <tr>
                    <th class="px-6 py-3">Info Produk</th>
                    <th class="px-6 py-3">Kategori</th>
                    <th class="px-6 py-3">Harga</th>
                    <th class="px-6 py-3">Stok</th>
                    <th class="px-6 py-3 text-center">Status</th>
                    <th class="px-6 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($products as $product)
                <tr class="hover:bg-gray-50 transition">
                    <!-- <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-gray-200 rounded-md flex items-center justify-center text-gray-400">
                                <i class="fa-solid fa-image"></i>
                            </div>
                            <div>
                                <div class="font-bold text-gray-800">{{ $product['name'] }}</div>
                                <div class="text-xs text-gray-500">ID: {{ $product['id'] }}</div>
                            </div>
                        </div>
                    </td> -->
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($product->images->count() > 0)
                                @php
                                    $primaryImage = $product->images->where('is_primary', true)->first();
                                    if(!$primaryImage) {
                                        $primaryImage = $product->images->first();
                                    }
                                @endphp
                                <img src="{{ asset('storage/' . $primaryImage->path) }}" 
                                     alt="{{ $product->name }}" 
                                     class="w-12 h-12 object-cover rounded-md">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded-md flex items-center justify-center text-gray-400">
                                    <i class="fa-solid fa-image"></i>
                                </div>
                            @endif
                            <div>
                                <div class="font-bold text-gray-800">{{ $product->name }}</div>
                                <div class="text-xs text-gray-500">ID: {{ $product->id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="bg-green-50 text-leafly-dark px-2 py-1 rounded text-xs font-bold border border-green-100">
                            {{ $product->category->name }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-800">
                        Rp {{ number_format($product['price'], 0, ',', '.') }}
                    </td>
                    <td class="px-6 py-4">
                        @if($product['stock'] > 0)
                            <span class="font-bold text-gray-700">{{ $product['stock'] }}</span>
                        @else
                            <span class="text-red-500 font-bold">0</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($product['stock'] > 0)
                            <span class="inline-block w-3 h-3 bg-green-500 rounded-full mr-1"></span> Aktif
                        @else
                            <span class="inline-block w-3 h-3 bg-red-500 rounded-full mr-1"></span> Habis
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.products.edit', $product['id']) }}" class="w-8 h-8 rounded bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product['id']) }}" method="POST" onsubmit="return confirm('Hapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-8 h-8 rounded bg-red-50 text-red-600 hover:bg-red-600 hover:text-white flex items-center justify-center transition" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="p-6 border-t border-gray-100 flex justify-between items-center">
        <span class="text-sm text-gray-500">Menampilkan 3 dari 45 data</span>
        <div class="flex gap-2">
            <button class="px-3 py-1 border rounded hover:bg-gray-50 disabled:opacity-50" disabled>Prev</button>
            <button class="px-3 py-1 bg-leafly-dark text-white rounded">1</button>
            <button class="px-3 py-1 border rounded hover:bg-gray-50">2</button>
            <button class="px-3 py-1 border rounded hover:bg-gray-50">Next</button>
        </div>
    </div>
</div>
@endsection