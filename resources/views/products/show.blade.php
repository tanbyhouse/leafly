@extends('layouts.app')

@section('title', $product->nama_product . ' - Leafly')

@section('content')
    <div class="bg-leafly-cream min-h-screen pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- breadcrumbs -->
            <nav class="flex text-sm text-gray-500 mb-6">
                <a href="{{ route('home') }}" class="hover:text-leafly-dark">Home</a>
                <span class="mx-2">/</span>
                <a href="{{ route('products.index') }}" class="hover:text-leafly-dark">Product</a>
                <span class="mx-2">/</span>
                <span class="text-leafly-dark font-bold truncate">{{ $product->nama_product }}</span>
            </nav>

            {{-- Success/Error Messages --}}
            @if (session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded">
                    <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                    <p class="text-sm text-red-700 font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <div class="bg-white rounded-2xl shadow-md overflow-hidden">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">

                    <!-- Product Images -->
                    <div>
                        <div
                            class="bg-gray-100 rounded-lg aspect-square flex items-center justify-center mb-4 overflow-hidden">
                            @if($product->images->isNotEmpty())
                                <img src="{{ asset('storage/' . $product->images->first()->path_foto) }}"
                                    alt="{{ $product->nama_product }}" class="w-full h-full object-cover">
                            @else
                                <i class="fa-solid fa-seedling text-9xl text-leafly-green"></i>
                            @endif
                        </div>

                        @if($product->images->count() > 1)
                            <div class="grid grid-cols-4 gap-2">
                                @foreach($product->images as $foto)
                                    <div
                                        class="bg-gray-100 rounded aspect-square overflow-hidden cursor-pointer hover:ring-2 ring-leafly-gold">
                                        <img src="{{ asset('storage/' . $foto->path_foto) }}" alt="{{ $product->nama_product }}"
                                            class="w-full h-full object-cover">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div>
                        <span class="text-sm bg-leafly-green text-leafly-dark px-3 py-1 rounded-full font-medium">
                            {{ $product->category->nama_category }}
                        </span>

                        <h1 class="text-3xl font-bold text-leafly-dark mt-4 mb-2">
                            {{ $product->nama_product }}
                        </h1>

                        <div class="flex items-center gap-4 mb-4">
                            <div class="flex text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star {{ $i <= round($averageRating) ? '' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>
                            <span class="text-gray-600">{{ number_format($averageRating, 1) }} ({{ $totalReviews }}
                                ulasan)</span>
                        </div>

                        <div class="text-4xl font-bold text-leafly-dark mb-6">
                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                        </div>

                        <div class="border-t border-b border-gray-200 py-4 mb-6">
                            <p class="text-gray-700 leading-relaxed">
                                {{ $product->deskripsi }}
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                            <div>
                                <span class="text-gray-500">Stok:</span>
                                <span class="font-bold text-leafly-dark">{{ $product->stok }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Berat:</span>
                                <span class="font-bold">{{ $product->berat ?? '-' }} gram</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Jenis:</span>
                                <span class="font-bold">{{ ucfirst($product->jenis_product) }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500">Kode:</span>
                                <span class="font-bold">{{ $product->kode_product }}</span>
                            </div>
                        </div>

                        @auth
                            <form action="{{ route('cart.add') }}" method="POST" class="space-y-4">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <div class="flex items-center gap-4">
                                    <label class="text-gray-700 font-medium">Jumlah:</label>
                                    <div class="flex border rounded-lg overflow-hidden">
                                        <button type="button" onclick="changeQty(-1)"
                                            class="px-4 py-2 bg-gray-100 hover:bg-gray-200">-</button>
                                        <input type="number" name="jumlah" id="qty" value="1" min="1" max="{{ $product->stok }}"
                                            class="w-20 text-center border-none focus:ring-0" readonly>
                                        <button type="button" onclick="changeQty(1)"
                                            class="px-4 py-2 bg-gray-100 hover:bg-gray-200">+</button>
                                    </div>
                                </div>

                                <button type="submit"
                                    class="w-full bg-leafly-dark text-white font-bold py-3 rounded-lg hover:bg-leafly-gold hover:text-leafly-dark transition flex items-center justify-center gap-2"
                                    {{ $product->stok <= 0 ? 'disabled' : '' }}>
                                    <i class="fa-solid fa-cart-plus"></i>
                                    {{ $product->stok > 0 ? 'Tambah ke Keranjang' : 'Stok Habis' }}
                                </button>
                            </form>
                        @else
                            <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 rounded">
                                <p class="text-sm text-yellow-700">
                                    <i class="fa-solid fa-info-circle mr-2"></i>
                                    Silakan <a href="{{ route('login') }}" class="font-bold underline">login</a> untuk
                                    menambahkan product ke keranjang
                                </p>
                            </div>
                        @endauth
                    </div>
                </div>

                <!-- Reviews Section -->
                @if($totalReviews > 0)
                    <div class="border-t p-8">
                        <h3 class="text-2xl font-bold text-leafly-dark mb-6">Ulasan Pelanggan</h3>

                        <div class="space-y-4">
                            @foreach($product->reviews->take(5) as $review)
                                <div class="border-b pb-4">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="font-bold">{{ $review->pelanggan->nama }}</span>
                                        <div class="flex text-yellow-400 text-sm">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fa-solid fa-star {{ $i <= $review->rating ? '' : 'text-gray-300' }}"></i>
                                            @endfor
                                        </div>
                                        @if($review->is_verified_purchase)
                                            <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded">Verified</span>
                                        @endif
                                    </div>
                                    <p class="text-gray-600">{{ $review->ulasan }}</p>
                                    <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Related Products -->
            @if($relatedProducts->isNotEmpty())
                <div class="mt-12">
                    <h3 class="text-2xl font-bold text-leafly-dark mb-6">Product Terkait</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($relatedProducts as $related)
                            <a href="{{ route('products.show', $related->id) }}"
                                class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
                                <div
                                    class="bg-gray-100 rounded aspect-square mb-3 flex items-center justify-center overflow-hidden">
                                    @if($related->images->isNotEmpty())
                                        <img src="{{ asset('storage/' . $related->images->first()->path_foto) }}"
                                            alt="{{ $related->nama_product }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="fa-solid fa-seedling text-4xl text-leafly-green"></i>
                                    @endif
                                </div>
                                <h4 class="font-bold text-sm mb-1 line-clamp-2">{{ $related->nama_product }}</h4>
                                <p class="text-leafly-dark font-bold">Rp {{ number_format($related->harga, 0, ',', '.') }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
        <script>
            function changeQty(change) {
                let input = document.getElementById('qty');
                let newVal = parseInt(input.value) + change;
                let max = parseInt(input.max);

                if (newVal >= 1 && newVal <= max) {
                    input.value = newVal;
                }
            }
        </script>
    @endpush
@endsection


{{-- @extends('layouts.app')

@section('title', $product->nama_product . ' - Leafly')

@section('content')
<div class="bg-leafly-cream min-h-screen pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <nav class="flex text-sm text-gray-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-leafly-dark">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ route('products.index') }}" class="hover:text-leafly-dark">Product</a>
            <span class="mx-2">/</span>
            <span class="text-leafly-dark font-bold">{{ $product->nama_product }}</span>
        </nav>

        <div class="bg-white rounded-2xl shadow-md overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-8">

                <!-- Product Images -->
                <div>
                    <div
                        class="bg-gray-100 rounded-lg aspect-square flex items-center justify-center mb-4 overflow-hidden">
                        @if($product->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $product->images->first()->path_foto) }}"
                            alt="{{ $product->nama_product }}" class="w-full h-full object-cover">
                        @else
                        <i class="fa-solid fa-seedling text-9xl text-leafly-green"></i>
                        @endif
                    </div>

                    @if($product->images->count() > 1)
                    <div class="grid grid-cols-4 gap-2">
                        @foreach($product->images as $foto)
                        <div
                            class="bg-gray-100 rounded aspect-square overflow-hidden cursor-pointer hover:ring-2 ring-leafly-gold">
                            <img src="{{ asset('storage/' . $foto->path_foto) }}" alt="{{ $product->nama_product }}"
                                class="w-full h-full object-cover">
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div>
                    <span class="text-sm bg-leafly-green text-leafly-dark px-3 py-1 rounded-full font-medium">
                        {{ $product->category->nama_category }}
                    </span>

                    <h1 class="text-3xl font-bold text-leafly-dark mt-4 mb-2">
                        {{ $product->nama_product }}
                    </h1>

                    <div class="flex items-center gap-4 mb-4">
                        <div class="flex text-yellow-400">
                            @for($i = 1; $i <= 5; $i++) <i
                                class="fa-solid fa-star {{ $i <= round($averageRating) ? '' : 'text-gray-300' }}"></i>
                                @endfor
                        </div>
                        <span class="text-gray-600">{{ number_format($averageRating, 1) }} ({{ $totalReviews }}
                            ulasan)</span>
                    </div>

                    <div class="text-4xl font-bold text-leafly-dark mb-6">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </div>

                    <div class="border-t border-b border-gray-200 py-4 mb-6">
                        <p class="text-gray-700 leading-relaxed">
                            {{ $product->deskripsi }}
                        </p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
                        <div>
                            <span class="text-gray-500">Stok:</span>
                            <span class="font-bold text-leafly-dark">{{ $product->stok }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Berat:</span>
                            <span class="font-bold">{{ $product->berat ?? '-' }} gram</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Jenis:</span>
                            <span class="font-bold">{{ ucfirst($product->jenis_product) }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500">Kode:</span>
                            <span class="font-bold">{{ $product->kode_product }}</span>
                        </div>
                    </div>

                    <form action="{{ route('cart.add') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                        <div class="flex items-center gap-4">
                            <label class="text-gray-700 font-medium">Jumlah:</label>
                            <div class="flex border rounded-lg overflow-hidden">
                                <button type="button" onclick="changeQty(-1)"
                                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200">-</button>
                                <input type="number" name="jumlah" id="qty" value="1" min="1" max="{{ $product->stok }}"
                                    class="w-20 text-center border-none focus:ring-0" readonly>
                                <button type="button" onclick="changeQty(1)"
                                    class="px-4 py-2 bg-gray-100 hover:bg-gray-200">+</button>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full bg-leafly-dark text-white font-bold py-3 rounded-lg hover:bg-leafly-gold hover:text-leafly-dark transition flex items-center justify-center gap-2"
                            {{ $product->stok <= 0 ? 'disabled' : '' }}>
                                <i class="fa-solid fa-cart-plus"></i>
                                {{ $product->stok > 0 ? 'Tambah ke Keranjang' : 'Stok Habis' }}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Reviews Section -->
            @if($totalReviews > 0)
            <div class="border-t p-8">
                <h3 class="text-2xl font-bold text-leafly-dark mb-6">Ulasan Pelanggan</h3>

                <div class="space-y-4">
                    @foreach($product->reviews->take(5) as $review)
                    <div class="border-b pb-4">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="font-bold">{{ $review->pelanggan->nama }}</span>
                            <div class="flex text-yellow-400 text-sm">
                                @for($i = 1; $i <= 5; $i++) <i
                                    class="fa-solid fa-star {{ $i <= $review->rating ? '' : 'text-gray-300' }}"></i>
                                    @endfor
                            </div>
                        </div>
                        <p class="text-gray-600">{{ $review->ulasan }}</p>
                        <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Related Products -->
        @if($relatedProducts->isNotEmpty())
        <div class="mt-12">
            <h3 class="text-2xl font-bold text-leafly-dark mb-6">Product Terkait</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($relatedProducts as $related)
                <a href="{{ route('products.show', $related->id) }}"
                    class="bg-white rounded-lg shadow hover:shadow-lg transition p-4">
                    <div
                        class="bg-gray-100 rounded aspect-square mb-3 flex items-center justify-center overflow-hidden">
                        @if($related->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $related->images->first()->path_foto) }}"
                            alt="{{ $related->nama_product }}" class="w-full h-full object-cover">
                        @else
                        <i class="fa-solid fa-seedling text-4xl text-leafly-green"></i>
                        @endif
                    </div>
                    <h4 class="font-bold text-sm mb-1 line-clamp-2">{{ $related->nama_product }}</h4>
                    <p class="text-leafly-dark font-bold">Rp {{ number_format($related->harga, 0, ',', '.') }}</p>
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    function changeQty(change) {
        let input = document.getElementById('qty');
        let newVal = parseInt(input.value) + change;
        let max = parseInt(input.max);

        if (newVal >= 1 && newVal <= max) {
            input.value = newVal;
        }
    }
</script>
@endpush
@endsection --}}
