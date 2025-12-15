@extends('layouts.app')

@section('title', 'Katalog Product - Leafly')

@section('content')
<div class="bg-leafly-cream min-h-screen pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-leafly-dark">Katalog Product</h1>
                <p class="text-gray-600">Temukan bibit dan alat terbaik untuk kebunmu.</p>
            </div>

            <!-- searchbar -->
            <form action="{{ route('products.index') }}" method="GET" class="w-full md:w-96 relative">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari tanaman, bibit, atau alat..."
                       class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-leafly-green focus:border-transparent">
                <button type="submit" class="absolute left-3 top-2.5 text-gray-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">

            <!-- sidebar filter -->
            <div class="w-full lg:w-1/4">
                <form class="sticky top-24" action="{{ route('products.index') }}" method="GET">

                    <!-- Keep search term when filtering -->
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">

                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-bold text-lg text-leafly-dark">
                                <i class="fa-solid fa-filter mr-2"></i> Filter
                            </h3>
                            <a href="{{ route('products.index') }}" class="text-xs text-red-500 hover:underline font-medium">
                                Reset
                            </a>
                        </div>

                        <!-- category -->
                        <div class="mb-6">
                            <h4 class="font-bold text-leafly-dark text-sm mb-3 uppercase tracking-wider">Jenis Product</h4>
                            <div class="space-y-3">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox"
                                           name="category[]"
                                           value="benih"
                                           {{ in_array('benih', request('category', [])) ? 'checked' : '' }}
                                           class="w-4 h-4 rounded border-gray-300 text-leafly-dark focus:ring-leafly-green cursor-pointer">
                                    <span class="text-gray-600 text-sm group-hover:text-leafly-dark transition">Benih Tanaman</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox"
                                           name="category[]"
                                           value="bibit"
                                           {{ in_array('bibit', request('category', [])) ? 'checked' : '' }}
                                           class="w-4 h-4 rounded border-gray-300 text-leafly-dark focus:ring-leafly-green cursor-pointer">
                                    <span class="text-gray-600 text-sm group-hover:text-leafly-dark transition">Bibit Jadi</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox"
                                           name="category[]"
                                           value="alat"
                                           {{ in_array('alat', request('category', [])) ? 'checked' : '' }}
                                           class="w-4 h-4 rounded border-gray-300 text-leafly-dark focus:ring-leafly-green cursor-pointer">
                                    <span class="text-gray-600 text-sm group-hover:text-leafly-dark transition">Peralatan</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox"
                                           name="category[]"
                                           value="paket"
                                           {{ in_array('paket', request('category', [])) ? 'checked' : '' }}
                                           class="w-4 h-4 rounded border-gray-300 text-leafly-dark focus:ring-leafly-green cursor-pointer">
                                    <span class="text-gray-600 text-sm group-hover:text-leafly-dark transition">Paket Bundling</span>
                                </label>
                            </div>
                        </div>

                        <!-- filter price -->
                        <div class="mb-6">
                            <h4 class="font-bold text-leafly-dark text-sm mb-3 uppercase tracking-wider">price (Rp)</h4>
                            <div class="flex flex-col gap-2">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-400 text-xs">Rp</span>
                                    <input type="number"
                                           name="min_price"
                                           value="{{ request('min_price') }}"
                                           placeholder="Minimum"
                                           class="w-full pl-8 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-leafly-green focus:border-transparent">
                                </div>
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-400 text-xs">Rp</span>
                                    <input type="number"
                                           name="max_price"
                                           value="{{ request('max_price') }}"
                                           placeholder="Maksimum"
                                           class="w-full pl-8 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-leafly-green focus:border-transparent">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-leafly-dark text-white font-bold py-3 rounded-lg hover:bg-leafly-gold hover:text-leafly-dark transition duration-300 shadow-md flex justify-center items-center gap-2">
                            <i class="fa-solid fa-check"></i> Terapkan Filter
                        </button>

                    </div>
                </form>
            </div>

            <!-- grid product -->
            <div class="w-full lg:w-3/4">
                <!-- sorting -->
                <div class="flex justify-between items-center mb-4">
                    <span class="text-sm text-gray-500">Menampilkan {{ $products->count() }} dari {{ $products->total() }} product</span>
                    <form action="{{ route('products.index') }}" method="GET" class="inline">
                        @foreach(request()->except('sort') as $key => $value)
                            @if(is_array($value))
                                @foreach($value as $v)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endif
                        @endforeach
                        <select name="sort"
                                onchange="this.form.submit()"
                                class="text-sm border-gray-300 rounded-md focus:ring-leafly-green focus:border-leafly-green">
                            <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                            <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Termurah</option>
                            <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Termahal</option>
                            <option value="terlaris" {{ request('sort') == 'terlaris' ? 'selected' : '' }}>Terlaris</option>
                        </select>
                    </form>
                </div>

                @if($products->isEmpty())
                    <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                        <i class="fa-solid fa-box-open text-6xl text-gray-300 mb-4"></i>
                        <h2 class="text-2xl font-bold text-gray-700 mb-2">Product Tidak Ditemukan</h2>
                        <p class="text-gray-500 mb-4">Coba ubah filter atau kata kunci pencarian Anda</p>
                        <a href="{{ route('products.index') }}" class="inline-block bg-leafly-dark text-white px-6 py-3 rounded-lg hover:bg-leafly-green hover:text-leafly-dark transition font-bold">
                            Lihat Semua Product
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($products as $product)
                        <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition duration-300 group overflow-hidden border border-gray-100 flex flex-col h-full">

                            <a href="{{ route('products.show', $product->id) }}" class="relative h-48 bg-gray-100 flex items-center justify-center overflow-hidden cursor-pointer">
                                @if($product->images->isNotEmpty())
                                    <img src="{{ asset('storage/' . $product->images->first()->path_foto) }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                @else
                                    <i class="fa-solid fa-seedling text-6xl text-leafly-green/50 group-hover:scale-110 transition duration-500"></i>
                                @endif

                                @if($product->stock <= 0)
                                    <span class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">
                                        Habis
                                    </span>
                                @elseif($product->stock < 10)
                                    <span class="absolute top-2 right-2 bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded">
                                        stock Terbatas
                                    </span>
                                @endif
                            </a>

                            <div class="p-4 flex flex-col grow">
                                <div class="text-xs text-gray-500 mb-1">{{ $product->category->nama_category }}</div>

                                <a href="{{ route('products.show', $product->id) }}" class="hover:text-leafly-green transition">
                                    <h3 class="font-bold text-leafly-dark text-lg mb-1 leading-tight line-clamp-2">{{ $product->name }}</h3>
                                </a>

                                <p class="text-sm text-gray-500 line-clamp-2 mb-2">{{ Str::limit($product->deskripsi, 60) }}</p>

                                <div class="mt-auto flex flex-col gap-2">
                                    <div class="flex justify-between items-center">
                                        <span class="text-xl font-bold text-leafly-dark">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <span class="text-xs text-gray-500">stock: {{ $product->stock }}</span>
                                    </div>

                                    <a href="{{ route('products.show', $product->id) }}"
                                       class="w-full text-center bg-leafly-dark text-white py-2 rounded-lg hover:bg-leafly-green hover:text-leafly-dark transition font-bold text-sm">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- pagination -->
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection



{{-- @extends('layouts.app')

@section('title', 'Katalog Product - Leafly')

@section('content')
<div class="bg-leafly-cream min-h-screen pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-bold text-leafly-dark">Katalog Product</h1>
                <p class="text-gray-600">Temukan bibit dan alat terbaik untuk kebunmu.</p>
            </div>

            <!-- searchbar -->
            <div class="w-full md:w-96 relative">
                <input type="text" placeholder="Cari tanaman, bibit, atau alat..." class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-leafly-green focus:border-transparent">
                <div class="absolute left-3 top-2.5 text-gray-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">

            <!-- sidebar filter -->
            <div class="w-full lg:w-1/4">
                <form class="sticky top-24" action="{{ route('products.index') }}" method="GET">

                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">

                        <div class="flex justify-between items-center mb-6">
                            <h3 class="font-bold text-lg text-leafly-dark">
                                <i class="fa-solid fa-filter mr-2"></i> Filter
                            </h3>

                            <a href="{{ route('products.index') }}" class="text-xs text-red-500 hover:underline font-medium">
                                Reset
                            </a>
                        </div>

                        <!-- category -->
                        <div class="mb-6">
                            <h4 class="font-bold text-leafly-dark text-sm mb-3 uppercase tracking-wider">category</h4>
                            <div class="space-y-3">

                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" name="category[]" value="benih" class="w-4 h-4 rounded border-gray-300 text-leafly-dark focus:ring-leafly-green cursor-pointer">
                                    <span class="text-gray-600 text-sm group-hover:text-leafly-dark transition">Benih Tanaman</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" name="category[]" value="bibit" class="w-4 h-4 rounded border-gray-300 text-leafly-dark focus:ring-leafly-green cursor-pointer">
                                    <span class="text-gray-600 text-sm group-hover:text-leafly-dark transition">Bibit Jadi</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" name="category[]" value="alat" class="w-4 h-4 rounded border-gray-300 text-leafly-dark focus:ring-leafly-green cursor-pointer">
                                    <span class="text-gray-600 text-sm group-hover:text-leafly-dark transition">Peralatan</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" name="category[]" value="paket" class="w-4 h-4 rounded border-gray-300 text-leafly-dark focus:ring-leafly-green cursor-pointer">
                                    <span class="text-gray-600 text-sm group-hover:text-leafly-dark transition">Paket Bundling</span>
                                </label>
                            </div>
                        </div>

                        <!-- filter price -->
                        <div class="mb-6">
                            <h4 class="font-bold text-leafly-dark text-sm mb-3 uppercase tracking-wider">price (Rp)</h4>
                            <div class="flex flex-col gap-2">
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-400 text-xs">Rp</span>
                                    <input type="number" name="min_price" placeholder="Minimum" class="w-full pl-8 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-leafly-green focus:border-transparent">
                                </div>
                                <div class="relative">
                                    <span class="absolute left-3 top-2 text-gray-400 text-xs">Rp</span>
                                    <input type="number" name="max_price" placeholder="Maksimum" class="w-full pl-8 pr-3 py-2 text-sm border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-leafly-green focus:border-transparent">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-leafly-dark text-white font-bold py-3 rounded-lg hover:bg-leafly-gold hover:text-leafly-dark transition duration-300 shadow-md flex justify-center items-center gap-2">
                            <i class="fa-solid fa-check"></i> Terapkan Filter
                        </button>

                    </div>
                </form>
            </div>

            <!-- grid product -->
            <div class="w-full lg:w-3/4">
                <!-- sorting -->
                <div class="flex justify-between items-center mb-4">
                    <span class="text-sm text-gray-500">Menampilkan 9 product</span>
                    <select class="text-sm border-gray-300 rounded-md focus:ring-leafly-green focus:border-leafly-green">
                        <option>Terbaru</option>
                        <option>Termurah</option>
                        <option>Termahal</option>
                        <option>Terlaris</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @php
                        $products = [
                            ['name' => 'Benih Selada Hidroponik', 'category' => 'Benih', 'price' => 'Rp 15.000', 'rating' => '4.5', 'badge' => 'Terlaris'],
                            ['name' => 'Monstera Adansonii', 'category' => 'Bibit Jadi', 'price' => 'Rp 75.000', 'rating' => '4.8', 'badge' => 'Favorit'],
                            ['name' => 'Paket Hidroponik Mini', 'category' => 'Peralatan', 'price' => 'Rp 55.000', 'rating' => '4.2', 'badge' => 'Hemat'],
                            ['name' => 'Benih Tomat Unggul', 'category' => 'Benih', 'price' => 'Rp 12.000', 'rating' => '4.1', 'badge' => null],
                            ['name' => 'Nutrisi Hidroponik 1L', 'category' => 'Perlengkapan', 'price' => 'Rp 45.000', 'rating' => '4.6', 'badge' => null],
                            ['name' => 'Paket Starter Sayuran', 'category' => 'Paket Bundling', 'price' => 'Rp 95.000', 'rating' => '4.7', 'badge' => 'Terlaris'],
                        ];
                    @endphp

                    @foreach ($products as $product)
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition duration-300 group overflow-hidden border border-gray-100 flex flex-col h-full">

                        <a href="{{ route('products.show', 1) }}" class="relative h-48 bg-gray-100 flex items-center justify-center overflow-hidden cursor-pointer">
                            <i class="fa-solid fa-seedling text-6xl text-leafly-green/50 group-hover:scale-110 transition duration-500"></i>

                            @if(!empty($product['badge']))
                                <span class="absolute top-2 left-2 bg-leafly-gold text-leafly-dark text-xs font-bold px-2 py-1 rounded">
                                    {{ $product['badge'] }}
                                </span>
                            @endif
                        </a>

                        <div class="p-4 flex flex-col grow">
                            <div class="text-xs text-gray-500 mb-1">{{ $product['category'] }}</div>

                            <a href="{{ route('products.show', 1) }}" class="hover:text-leafly-green transition">
                                <h3 class="font-bold text-leafly-dark text-lg mb-1 leading-tight">{{ $product['name'] }}</h3>
                            </a>

                            <div class="mt-auto flex justify-between items-center">
                                <span class="text-lg font-bold text-leafly-dark">{{ $product['price'] }}</span>

                                <a href="{{ route('products.show', 1) }}" class="w-8 h-8 rounded-full bg-gray-100 text-leafly-dark hover:bg-leafly-dark hover:text-white transition flex items-center justify-center">
                                    <i class="fa-solid fa-cart-plus"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- pagination -->
                <div class="mt-8 flex justify-center">
                    <nav class="flex gap-2">
                        <a href="#" class="px-3 py-1 rounded border hover:bg-white text-gray-500"><i class="fa-solid fa-chevron-left"></i></a>
                        <a href="#" class="px-3 py-1 rounded border bg-leafly-dark text-white">1</a>
                        <a href="#" class="px-3 py-1 rounded border hover:bg-white text-gray-500">2</a>
                        <a href="#" class="px-3 py-1 rounded border hover:bg-white text-gray-500">3</a>
                        <a href="#" class="px-3 py-1 rounded border hover:bg-white text-gray-500"><i class="fa-solid fa-chevron-right"></i></a>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
