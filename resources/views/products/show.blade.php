@extends('layouts.app')

@section('title', $product['name'] . ' - Leafly')

@section('content')
<div class="bg-leafly-cream min-h-screen pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- breadcrumbs -->
        <nav class="flex text-sm text-gray-500 mb-6 animate-fade-in-up">
            <a href="{{ route('products.index') }}" class="hover:text-leafly-dark transition">Katalog</a>
            <span class="mx-2">/</span>
            <span class="text-gray-400">{{ $product['category'] }}</span>
            <span class="mx-2">/</span>
            <span class="text-leafly-dark font-bold truncate">{{ $product['name'] }}</span>
        </nav>

        <!-- review succcess -->
        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm relative">
            <p class="font-bold">Terima Kasih!</p>
            <p>{{ session('success') }}</p>
        </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2">
                
                <!-- image product -->
                <div class="p-6 md:p-8 bg-gray-50 flex flex-col items-center justify-center relative">
                    
                    <div class="w-full aspect-square bg-white rounded-xl shadow-inner flex items-center justify-center mb-4 relative overflow-hidden group">
                        <i class="fa-solid fa-seedling text-9xl text-leafly-green group-hover:scale-110 transition duration-500"></i>
                        
                        <!-- stock -->
                        <span class="absolute top-4 left-4 bg-leafly-dark text-white text-xs font-bold px-3 py-1 rounded-full shadow-md">
                            Stok: {{ $product['stock'] }}
                        </span>
                    </div>

                    <!-- thumbnail galeri -->
                    <div class="flex gap-4 overflow-x-auto w-full justify-center">
                        @foreach($product['images'] as $img)
                        <button class="w-20 h-20 bg-white rounded-lg border-2 border-transparent hover:border-leafly-gold focus:border-leafly-gold flex items-center justify-center transition shadow-sm">
                            <i class="fa-solid {{ $img }} text-2xl text-leafly-dark/50"></i>
                        </button>
                        @endforeach
                    </div>
                </div>

                <!-- informasi product -->
                <div class="p-6 md:p-10 flex flex-col justify-center">
                    <div class="mb-2 text-leafly-gold text-sm font-bold uppercase tracking-wider">
                        {{ $product['category'] }}
                    </div>
                    
                    <h1 class="text-3xl md:text-4xl font-bold text-leafly-dark mb-4 leading-tight">
                        {{ $product['name'] }}
                    </h1>

                    <!-- rating & review -->
                    <div class="flex items-center mb-6">
                        <div class="flex text-yellow-400 text-sm">
                            @for($i=0; $i<5; $i++)
                                <i class="fa-solid {{ $i < floor($product['rating']) ? 'fa-star' : 'fa-star-half-stroke' }}"></i>
                            @endfor
                        </div>
                        <span class="text-gray-500 text-sm ml-2 font-medium">
                            {{ $product['rating'] }} ({{ $product['reviews_count'] }} Ulasan)
                        </span>
                    </div>

                    <!-- harga -->
                    <div class="mb-6 pb-6 border-b border-gray-100">
                        <div class="text-4xl font-bold text-leafly-dark">
                            Rp {{ number_format($product['price'], 0, ',', '.') }}
                        </div>
                    </div>

                    <!-- deskripsi -->
                    <p class="text-gray-600 mb-8 leading-relaxed text-lg">
                        {{ $product['description'] }}
                    </p>

                    <!-- form keranjang -->
                    <form action="#" method="POST" class="mt-auto">
                        @csrf
                        <div class="flex flex-col sm:flex-row gap-4">
                            <!-- input jumlah -->
                            <div class="w-full sm:w-1/3">
                                <label class="text-xs text-gray-500 font-bold mb-1 block uppercase">Jumlah</label>
                                <div class="flex items-center border-2 border-gray-200 rounded-lg overflow-hidden">
                                    <button type="button" onclick="updateQty(-1)" class="w-12 py-3 bg-gray-50 hover:bg-gray-100 text-gray-600 font-bold transition">-</button>
                                    <input type="number" id="qty" name="quantity" value="1" min="1" max="{{ $product['stock'] }}" class="w-full text-center border-none focus:ring-0 p-0 text-leafly-dark font-bold bg-white h-full" readonly>
                                    <button type="button" onclick="updateQty(1)" class="w-12 py-3 bg-gray-50 hover:bg-gray-100 text-gray-600 font-bold transition">+</button>
                                </div>
                            </div>
                            
                            <div class="w-full sm:w-2/3 pt-5">
                                <button type="button" class="w-full bg-leafly-dark text-white font-bold py-3.5 rounded-lg hover:bg-leafly-gold hover:text-leafly-dark transition duration-300 shadow-lg flex justify-center items-center gap-3 transform active:scale-95">
                                    <i class="fa-solid fa-cart-shopping"></i> Tambah Keranjang
                                </button>
                            </div>
                        </div>
                    </form>

                    <!--keterangan tambahan-->
                    <div class="grid grid-cols-2 gap-4 mt-8 pt-6 border-t border-gray-100">
                        <div class="flex items-center gap-3 text-sm text-gray-500">
                            <i class="fa-solid fa-truck-fast text-leafly-dark text-lg"></i> Pengiriman Cepat
                        </div>
                        <div class="flex items-center gap-3 text-sm text-gray-500">
                            <i class="fa-solid fa-shield-halved text-leafly-dark text-lg"></i> Garansi Tumbuh
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- deskripsi dan ulasan -->
            <div class="border-t border-gray-200 bg-gray-50/50">
                <div class="flex border-b border-gray-200">
                    <button type="button" class="tab-btn px-8 py-4 text-leafly-dark font-bold border-b-2 border-leafly-dark bg-white" data-target="#tab-detail">Detail Produk</button>
                    <button type="button" class="tab-btn px-8 py-4 text-gray-500 hover:text-leafly-dark font-medium transition" data-target="#tab-ulasan">Ulasan Pelanggan ({{ $product['reviews_count'] }})</button>
                </div>
                <div id="tab-detail" class="tab-content p-8 md:p-12 bg-white">
                    <h3 class="font-bold text-xl mb-4 text-leafly-dark">Spesifikasi Lengkap</h3>
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-y-2 gap-x-8 text-gray-600 mb-6 list-inside list-disc">
                        <li>Nama Latin: <i>Lactuca sativa</i></li>
                        <li>Daya Tumbuh: Min 85%</li>
                        <li>Kemurnian: 98%</li>
                        <li>Isi Bersih: 1 gram (± 800 butir)</li>
                        <li>Rekomendasi Dataran: Rendah - Tinggi</li>
                        <li>Umur Panen: 30 - 40 HST</li>
                    </ul>
                    <p class="text-gray-600 leading-relaxed">{{ $product['description'] }}</p>
                </div>

                <div id="tab-ulasan" class="tab-content hidden p-8 md:p-12 bg-white animate-fade-in-up">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                        
                        <!-- form input ulasan -->
                        <div class="lg:col-span-1">
                            <div class="bg-gray-50 p-6 rounded-xl border border-gray-100 sticky top-24">
                                <h3 class="font-bold text-lg text-leafly-dark mb-2">Tulis Ulasan</h3>
                                <p class="text-sm text-gray-500 mb-4">Bagikan pengalamanmu tentang produk ini.</p>

                                @guest
                                    <div class="text-center py-6">
                                        <i class="fa-solid fa-lock text-3xl text-gray-300 mb-3"></i>
                                        <p class="text-sm text-gray-600 mb-6">Silakan login untuk memberikan ulasan.</p>
                                        <a href="{{ route('login') }}" class="bg-leafly-gold text-leafly-dark px-6 py-2 rounded-full font-bold hover:bg-leafly-green transition shadow-lg transform hover:-translate-y-1">Masuk</a>
                                    </div>
                                @else
                                    <form action="{{ route('reviews.store') }}" method="POST">
                                        @csrf
                                        <!-- hidden input products id -->
                                        <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                                        
                                        <!-- input bintang -->
                                        <div class="mb-4">
                                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Berikan Rating</label>
                                            <div class="flex flex-row-reverse justify-end gap-1 group">
                                                <!-- flex reverse -->
                                                @for($i = 5; $i >= 1; $i--)
                                                    <input type="radio" id="star{{$i}}" name="rating" value="{{$i}}" class="peer hidden" required />
                                                    <label for="star{{$i}}" class="cursor-pointer text-2xl text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-400 peer-hover:text-yellow-400 transition-colors" title="{{$i}} Bintang">
                                                        <i class="fa-solid fa-star"></i>
                                                    </label>
                                                @endfor
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Komentar</label>
                                            <textarea name="comment" rows="4" class="w-full p-3 text-sm border border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green" placeholder="Produk sangat bagus, pengiriman cepat..." required></textarea>
                                        </div>

                                        <button type="submit" class="w-full bg-leafly-dark text-white font-bold py-2 rounded-lg hover:bg-leafly-gold hover:text-leafly-dark transition shadow-md">
                                            Kirim Ulasan
                                        </button>
                                    </form>
                                @endguest
                            </div>
                        </div>

                        <!-- daftar ulasan -->
                        <div class="lg:col-span-2 space-y-6">
                            @if(isset($product['reviews']) && count($product['reviews']) > 0)
                                @foreach($product['reviews'] as $review)
                                <div class="border-b border-gray-100 pb-6 last:border-0">
                                    <div class="flex justify-between items-start mb-2">
                                        <div class="flex items-center gap-3">
                                            <!-- avatar user -->
                                            <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center overflow-hidden">
                                                @if(isset($review['avatar']) && $review['avatar'])
                                                    <img src="{{ asset('storage/'.$review['avatar']) }}" class="w-full h-full object-cover">
                                                @else
                                                    <i class="fa-solid fa-user text-gray-400"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-gray-800 text-sm">{{ $review['user_name'] }}</h4>
                                                <div class="flex text-yellow-400 text-xs mt-0.5">
                                                    @for($j = 1; $j <= 5; $j++)
                                                        <i class="fa-solid {{ $j <= $review['rating'] ? 'fa-star' : 'fa-star text-gray-200' }}"></i>
                                                    @endfor
                                                </div>
                                            </div>
                                        </div>
                                        <span class="text-xs text-gray-400">{{ $review['date'] }}</span>
                                    </div>
                                    <p class="text-gray-600 text-sm leading-relaxed pl-14">
                                        {{ $review['comment'] }}
                                    </p>
                                </div>
                                @endforeach
                            @else
                                <div class="text-center py-12 text-gray-500 bg-gray-50 rounded-xl">
                                    <i class="fa-regular fa-comment-dots text-4xl mb-3 opacity-50"></i>
                                    <p>Belum ada ulasan untuk produk ini.</p>
                                    <p class="text-sm">Jadilah yang pertama memberikan ulasan!</p>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    function updateQty(change) {
        let input = document.getElementById('qty');
        let newValue = parseInt(input.value) + change;
        if (newValue >= 1 && newValue <= {{ $product['stock'] }}) {
            input.value = newValue;
        }
    }

    // Script Tab Switching (JQuery)
    $(document).ready(function() {
        $('.tab-btn').click(function() {
            // 1. Reset semua tombol tab
            $('.tab-btn').removeClass('border-leafly-dark bg-white text-leafly-dark')
                         .addClass('border-transparent text-gray-500 hover:text-leafly-dark hover:border-gray-300');
            
            // 2. Set tombol yang diklik jadi active
            $(this).removeClass('border-transparent text-gray-500 hover:text-leafly-dark hover:border-gray-300')
                   .addClass('border-leafly-dark bg-white text-leafly-dark');

            // 3. Sembunyikan semua konten tab
            $('.tab-content').addClass('hidden');

            // 4. Tampilkan konten tab yang dituju
            let target = $(this).data('target');
            $(target).removeClass('hidden');
        });
    });
</script>
@endsection
