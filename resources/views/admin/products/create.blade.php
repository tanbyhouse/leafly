@extends('layouts.admin')

@section('title', 'Tambah Produk')
@section('header', 'Tambah Produk Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <a href="{{ route('admin.products.index') }}" class="inline-flex items-center text-gray-500 hover:text-leafly-dark mb-6 transition">
        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar
    </a>

    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm">
            <p class="font-bold">Terjadi kesalahan!</p>
            <ul class="list-disc ml-4 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- left section -->
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Informasi Dasar</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Nama Produk</label>
                        <input type="text" name="name" value="{{ old('name') }}" 
                               class="w-full px-4 py-2 border {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-leafly-green focus:border-leafly-green" 
                               placeholder="Contoh: Benih Selada Premium" required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Produk</label>
                        <textarea name="description" rows="5" 
                                  class="w-full px-4 py-2 border {{ $errors->has('description') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-leafly-green focus:border-leafly-green" 
                                  placeholder="Jelaskan detail produk...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Harga (Rp)</label>
                            <input type="number" name="price" value="{{ old('price') }}" min="0" step="100"
                                   class="w-full px-4 py-2 border {{ $errors->has('price') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-leafly-green focus:border-leafly-green" 
                                   placeholder="15000" required>
                            @error('price')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Stok Awal</label>
                            <input type="number" name="stock" value="{{ old('stock') }}" min="0"
                                   class="w-full px-4 py-2 border {{ $errors->has('stock') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-leaf-500 focus:border-leaf-500" 
                                   placeholder="50" required>
                            @error('stock')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">Berat (gram)</label>
                            <input type="number" name="weight" value="{{ old('weight') }}" min="0"
                                   class="w-full px-4 py-2 border {{ $errors->has('weight') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-leafly-green focus:border-leafly-green" 
                                   placeholder="100">
                            @error('weight')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mt-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-leafly-green focus:ring-leafly-green">
                                <span class="ml-2 text-sm text-gray-700">Produk Aktif</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- right section -->
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Kategori</h3>
                    <select name="category_id" 
                            class="w-full px-4 py-2 border {{ $errors->has('category_id') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-leafly-green focus:border-leafly-green" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- upload image -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4 border-b pb-2">Foto Produk</h3>
                    
                    <div class="w-full">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upload Gambar Utama</label>
                        
                        <div class="mt-1 flex flex-col items-center justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:bg-gray-50 transition min-h-[200px]">
                            
                            <div id="uploadArea" class="space-y-1 text-center w-full">
                                <i class="fa-solid fa-image text-4xl text-gray-400 mb-3"></i>
                                <div class="flex text-sm text-gray-600 justify-center">
                                    <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-leafly-dark hover:text-leafly-green focus-within:outline-none">
                                        <span>Klik untuk upload gambar</span>
                                        <input id="image" name="image" type="file" class="sr-only" accept="image/png, image/jpeg, image/jpg" onchange="previewImage(event)">
                                    </label>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 2MB</p>
                            </div>

                            <div id="imagePreview" class="hidden w-full flex-col items-center">
                                <img id="preview" src="#" alt="Preview" class="max-h-64 w-auto object-contain rounded-lg mb-4 shadow-sm">
                                
                                <button type="button" onclick="removeImage()" class="px-4 py-2 bg-red-50 text-red-600 rounded-lg text-sm font-bold hover:bg-red-100 transition flex items-center gap-2">
                                    <i class="fa-solid fa-trash"></i> Hapus & Ganti
                                </button>
                            </div>

                        </div>
                        @error('image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="w-full bg-leafly-dark text-white font-bold py-3 rounded-lg hover:bg-leafly-gold hover:text-leafly-dark transition shadow-lg flex items-center justify-center group">
                    <i class="fa-solid fa-save mr-2 group-hover:rotate-12 transition-transform"></i> Simpan Produk
                </button>

@push('scripts')
<script>
    function previewImage(event) {
        const input = event.target;
        const uploadArea = document.getElementById('uploadArea');
        const imagePreview = document.getElementById('imagePreview');
        const preview = document.getElementById('preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                
                // Logic tukar tampilan
                uploadArea.classList.add('hidden');    
                imagePreview.classList.remove('hidden'); 
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    function removeImage() {
        const input = document.getElementById('image');
        const uploadArea = document.getElementById('uploadArea');
        const imagePreview = document.getElementById('imagePreview');

        input.value = ''; // Reset file input
        
        // Logic tukar tampilan balik
        imagePreview.classList.add('hidden');
        uploadArea.classList.remove('hidden'); 
    }
</script>
@endpush
@endsection