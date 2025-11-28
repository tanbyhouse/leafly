@extends('layouts.admin')

@section('title', 'Edit Produk')
@section('header', 'Edit Produk')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-gray-500 hover:text-leafly-dark mb-6 transition">
        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar
    </a>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') 
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Informasi Dasar</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Produk</label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Produk</label>
                        <textarea name="description" rows="5" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Harga (Rp)</label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green" required>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Stok</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Pengaturan</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Status Produk</label>
                        <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green">
                            <option value="Aktif" {{ $product->status == 'Aktif' ? 'selected' : '' }}>Aktif (Dijual)</option>
                            <option value="Nonaktif" {{ $product->status == 'Nonaktif' ? 'selected' : '' }}>Nonaktif (Disembunyikan)</option>
                            <option value="Habis" {{ $product->status == 'Habis' ? 'selected' : '' }}>Stok Habis</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                        {{-- Logika selected: cek apakah category_id produk sama dengan value option --}}
                        <select name="category_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green">
                            <option value="1" {{ $product->category == 'Benih' ? 'selected' : '' }}>Benih Tanaman</option>
                            <option value="2" {{ $product->category == 'Pupuk' ? 'selected' : '' }}>Pupuk / Nutrisi</option>
                            <option value="3" {{ $product->category == 'Media Tanam' ? 'selected' : '' }}>Media Tanam</option>
                            <option value="4" {{ $product->category == 'Alat' ? 'selected' : '' }}>Alat Hidroponik</option>
                        </select>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Foto Produk</h3>
                    
                    <div class="mb-4 flex justify-center">
                        <img id="image-preview" 
                             src="{{ asset($product->image ?? 'images/default-product.png') }}" 
                             class="w-40 h-40 object-cover rounded-lg border border-gray-200 shadow-sm">
                    </div>

                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center hover:bg-gray-50 transition cursor-pointer relative">
                        <input type="file" name="image" id="image-input" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" onchange="previewImage(event)">
                        <div class="text-sm text-gray-500">
                            <span class="text-leafly-dark font-bold">Klik ganti foto</span> atau drag & drop
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Biarkan kosong jika tidak diganti</p>
                    </div>
                </div>

                <button type="submit" class="w-full bg-leafly-dark text-white font-bold py-3 rounded-lg hover:bg-leafly-gold hover:text-leafly-dark transition shadow-lg">
                    <i class="fa-solid fa-floppy-disk mr-2"></i> Perbarui Produk
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('image-preview');
            output.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endsection