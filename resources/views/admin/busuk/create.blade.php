@extends('layouts.admin')

@section('title', 'Catat Produk Busuk')
@section('header', 'Catat Produk Busuk')

@section('content')
<div class="max-w-3xl mx-auto">
    
    <a href="{{ route('admin.busuk.index') }}" class="inline-flex items-center text-gray-500 hover:text-leafly-dark mb-6 transition">
        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Laporan
    </a>

    <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 border-t-4">
        
        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center text-red-600 text-xl">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <div>
                <h3 class="font-bold text-lg text-gray-800">Form Pengurangan Stok</h3>
                <p class="text-sm text-gray-500">Stok produk utama akan otomatis berkurang sesuai jumlah yang diinput.</p>
            </div>
        </div>

        <form action="{{ route('admin.busuk.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- pilih produk -->
                <div class="col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Produk</label>
                    <select name="product_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500" required>
                        <option value="">-- Cari Nama Produk --</option>
                        @foreach($products as $product)
                            <option value="{{ $product['id'] }}">{{ $product['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal</label>
                    <input type="date" name="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500" required>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Jumlah (Qty)</label>
                    <input type="number" name="quantity" min="1" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500" placeholder="Contoh: 5" required>
                </div>

                <div class="col-span-2">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Keterangan / Penyebab</label>
                    <textarea name="note" rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-red-500 focus:border-red-500" placeholder="Contoh: Layu karena suhu panas, Kemasan robek, dll..." required></textarea>
                </div>
            </div>

            <button type="submit" class="w-full bg-red-600 text-white font-bold py-3 rounded-lg hover:bg-red-700 transition shadow-lg">
                Simpan Laporan
            </button>
        </form>
    </div>
</div>
@endsection