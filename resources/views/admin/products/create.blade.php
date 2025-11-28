@extends('layouts.admin')

@section('title', 'Tambah Produk')
@section('header', 'Tambah Produk Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-gray-500 hover:text-leafly-dark mb-6 transition">
        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar
    </a>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- left section -->
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Informasi Dasar</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Produk</label>
                        <input type="text" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green" placeholder="Contoh: Benih Selada.." required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Produk</label>
                        <textarea name="description" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green" placeholder="Jelaskan detail produk..."></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Harga (Rp)</label>
                            <input type="number" name="price" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green" placeholder="0" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Stok Awal</label>
                            <input type="number" name="stock" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green" placeholder="0" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- right section -->
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Kategori</h3>
                    <select name="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green">
                        <option value="">Pilih Kategori</option>
                        <option value="1">Benih Tanaman</option>
                        <option value="2">Pupuk / Nutrisi</option>
                        <option value="3">Media Tanam</option>
                        <option value="4">Alat Hidroponik</option>
                    </select>
                </div>

                <!-- upload image -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Foto Produk</h3>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:bg-gray-50 transition cursor-pointer relative">
                        <input type="file" name="image" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 mb-2"></i>
                        <p class="text-sm text-gray-500 font-medium">Klik untuk upload gambar</p>
                        <p class="text-xs text-gray-400 mt-1">PNG, JPG max 2MB</p>
                    </div>
                </div>

                <button type="submit" class="w-full bg-leafly-dark text-white font-bold py-3 rounded-lg hover:bg-leafly-gold hover:text-leafly-dark transition shadow-lg">
                    <i class="fa-solid fa-save mr-2"></i> Simpan Produk
                </button>
            </div>
        </div>
    </form>
</div>
@endsection