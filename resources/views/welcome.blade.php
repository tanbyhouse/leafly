@extends('layouts.app')

@section('title', 'Leafly.id - Tanaman dan Perlengkapan Hidroponik')

@section('content')

    <!-- hero section -->
    <section id="home"
        class="relative min-h-[120vh] flex items-center justify-center text-center px-4 bg-cover bg-center bg-no-repeat bg-fixed"
        style="background-image: url('{{ asset('images/hero.png') }}');">

        <div class="absolute inset-0 bg-black/50 z-0"></div>

        <!-- content -->
        <div class="relative z-10 max-w-4xl mx-auto animate-fade-in-up">
            <h1 class="text-4xl md:text-6xl font-bold mb-6 text-white leading-tight drop-shadow-md">
                Keindahan Hijau Untuk <br> <span class="text-leafly-green">Setiap Ruang</span>
            </h1>
            <p class="text-lg md:text-xl mb-10 text-gray-100 leading-relaxed max-w-2xl mx-auto drop-shadow-sm">
                Temukan berbagai pilihan benih, bibit tanaman berkualitas, dan perlengkapan hidroponik untuk menciptakan
                taman impian Anda.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#products"
                    class="px-8 py-3 bg-leafly-green text-leafly-dark rounded-full font-bold hover:bg-leafly-gold transition duration-300 shadow-lg">
                    🌱 Lihat Katalog
                </a>
                <a href="#contact"
                    class="px-8 py-3 border-2 border-white text-white rounded-full font-bold hover:bg-white hover:text-leafly-dark transition duration-300 backdrop-blur-sm">
                    Hubungi Kami
                </a>
            </div>
        </div>
    </section>

    <!-- features section -->
    <section class="py-16 px-6 bg-leafly-cream -mt-20 relative z-20">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-6">

            <div class="bg-white p-8 rounded-2xl text-center shadow-lg border-b-4 border-leafly-gold">
                <div class="text-4xl mb-4 text-leafly-dark"><i class="fa-solid fa-medal"></i></div>
                <h3 class="text-lg font-bold text-leafly-dark mb-2">Kualitas Terbaik</h3>
            </div>
            <div class="bg-white p-8 rounded-2xl text-center shadow-lg border-b-4 border-leafly-gold">
                <div class="text-4xl mb-4 text-leafly-dark"><i class="fa-solid fa-truck-fast"></i></div>
                <h3 class="text-lg font-bold text-leafly-dark mb-2">Pengiriman Cepat</h3>
            </div>
            <div class="bg-white p-8 rounded-2xl text-center shadow-lg border-b-4 border-leafly-gold">
                <div class="text-4xl mb-4 text-leafly-dark"><i class="fa-solid fa-comments"></i></div>
                <h3 class="text-lg font-bold text-leafly-dark mb-2">Konsultasi Gratis</h3>
            </div>
            <div class="bg-white p-8 rounded-2xl text-center shadow-lg border-b-4 border-leafly-gold">
                <div class="text-4xl mb-4 text-leafly-dark"><i class="fa-solid fa-box-open"></i></div>
                <h3 class="text-lg font-bold text-leafly-dark mb-2">Paket Terlengkap</h3>
            </div>
        </div>
    </section>

    <!-- product section -->
    {{-- <section id="products" class="py-20 px-6 bg-white">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="text-3xl md:text-4xl font-bold text-leafly-dark mb-3">Product Terlaris</h2>
            <div class="w-24 h-1.5 bg-leafly-gold mx-auto rounded-full"></div>
            <p class="text-gray-600 mt-4 max-w-xl mx-auto">Pilihan favorit pelanggan kami untuk memulai kebun impian Anda di
                rumah.</p>
        </div>

        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            <div
                class="group bg-leafly-cream rounded-3xl overflow-hidden shadow-md hover:shadow-2xl transition duration-300">
                <div class="relative h-72 overflow-hidden">
                    <img src="images/hydrocabai.jpg" alt="Monstera Adansonii"
                        class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700 ease-in-out">

                    <div
                        class="absolute top-4 right-4 bg-leafly-gold text-leafly-dark text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">
                        Terlaris</div>
                </div>

                <div class="p-6 relative">
                    <span class="text-sm text-leafly-green font-medium mb-1 block">Tanaman Hias</span>
                    <h3 class="text-xl font-bold text-leafly-dark mb-2">Bibit Cabai</h3>
                    <!-- rating -->
                    <div class="flex items-center mb-3">
                        <span class="text-leafly-gold">★★★★★</span>
                        <span class="text-gray-500 text-sm ml-2">(5.0 / 45 Ulasan)</span>
                    </div>
                    <p class="text-gray-600 text-sm line-clamp-2 mb-6">Bibit tanaman cabai lebat.</p>

                    <div class="flex justify-between items-end pt-4 border-t border-gray-200/50">
                        <div>
                            <span class="text-xs text-gray-500 block line-through">Rp 95.000</span>
                            <span class="text-2xl font-bold text-leafly-dark">Rp 75.000</span>
                        </div>
                        <button
                            class="bg-leafly-dark text-white w-9 h-9 rounded-full hover:bg-leafly-gold hover:text-leafly-dark transition flex items-center justify-center">
                            <i class="fa-solid fa-cart-plus"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div
                class="group bg-leafly-cream rounded-3xl overflow-hidden shadow-md hover:shadow-2xl transition duration-300">
                <div class="relative h-72 overflow-hidden">
                    <img src="images/hydrokit.png" alt="Paket Starter Hidroponik"
                        class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700 ease-in-out">
                    <div
                        class="absolute top-4 right-4 bg-blue-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">
                        Paket Hemat</div>
                </div>
                <div class="p-6 relative">
                    <span class="text-sm text-leafly-green font-medium mb-1 block">Starter Kit</span>
                    <h3 class="text-xl font-bold text-leafly-dark mb-2">Starter Kit Hidroponik</h3>
                    <div class="flex items-center mb-3">
                        <span class="text-leafly-gold">★★★★☆</span>
                        <span class="text-gray-500 text-sm ml-2">(4.8 / 120 Ulasan)</span>
                    </div>
                    <p class="text-gray-600 text-sm line-clamp-2 mb-6">Paket lengkap siap tanam untuk pemula. Berisi bak,
                        netpot, rockwool, nutrisi AB Mix, dan benih selada.</p>
                    <div class="flex justify-between items-end pt-4 border-t border-gray-200/50">
                        <div>
                            <span class="text-2xl font-bold text-leafly-dark">Rp 125.000</span>
                        </div>
                        <button
                            class="bg-leafly-dark text-white w-9 h-9 rounded-full hover:bg-leafly-gold hover:text-leafly-dark transition flex items-center justify-center">
                            <i class="fa-solid fa-cart-plus"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div
                class="group bg-leafly-cream rounded-3xl overflow-hidden shadow-md hover:shadow-2xl transition duration-300">
                <div class="relative h-72 overflow-hidden">
                    <img src="images/bibit selada.jpg" alt="Benih Selada Premium"
                        class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700 ease-in-out">
                </div>
                <div class="p-6 relative">
                    <span class="text-sm text-leafly-green font-medium mb-1 block">Benih Unggul</span>
                    <h3 class="text-xl font-bold text-leafly-dark mb-2">Benih Selada Premium</h3>
                    <div class="flex items-center mb-3">
                        <span class="text-leafly-gold">★★★★★</span>
                        <span class="text-gray-500 text-sm ml-2">(5.0 / 215 Ulasan)</span>
                    </div>
                    <p class="text-gray-600 text-sm line-clamp-2 mb-6">Benih selada impor berkualitas tinggi dengan daya
                        tumbuh 98%. Cocok untuk hidroponik maupun konvensional.</p>
                    <div class="flex justify-between items-end pt-4 border-t border-gray-200/50">
                        <div>
                            <span class="text-xs text-gray-500 block line-through">Rp 20.000</span>
                            <span class="text-2xl font-bold text-leafly-dark">Rp 15.000</span>
                        </div>
                        <button
                            class="bg-leafly-dark text-white w-9 h-9 rounded-full hover:bg-leafly-gold hover:text-leafly-dark transition flex items-center justify-center">
                            <i class="fa-solid fa-cart-plus"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- product section -->
    <section id="products" class="py-20 px-6 bg-white">
        <div class="text-center mb-12 animate-on-scroll">
            <h2 class="text-3xl md:text-4xl font-bold text-leafly-dark mb-3">Product Terlaris</h2>
            <div class="w-24 h-1.5 bg-leafly-gold mx-auto rounded-full"></div>
            <p class="text-gray-600 mt-4 max-w-xl mx-auto">Pilihan favorit pelanggan kami untuk memulai kebun impian Anda di
                rumah.</p>
        </div>

        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8">
            @php
                $featuredProducts = \App\Models\Product::with(['category', 'images', 'reviews'])
                    ->where('is_active', true)
                    ->inRandomOrder()
                    ->limit(3)
                    ->get();
            @endphp

            @foreach($featuredProducts as $product)
                <div
                    class="group bg-leafly-cream rounded-3xl overflow-hidden shadow-md hover:shadow-2xl transition duration-300">
                    <div class="relative h-72 overflow-hidden">
                        @if($product->images->isNotEmpty())
                            <img src="{{ asset('storage/' . $product->images->first()->path_foto) }}"
                                alt="{{ $product->nama_Product }}"
                                class="w-full h-full object-cover transform group-hover:scale-110 transition duration-700 ease-in-out">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <i class="fa-solid fa-seedling text-6xl text-leafly-green"></i>
                            </div>
                        @endif

                        @if($product->reviews->count() > 5)
                            <div
                                class="absolute top-4 right-4 bg-leafly-gold text-leafly-dark text-xs font-bold px-3 py-1.5 rounded-full shadow-sm">
                                Terlaris</div>
                        @endif
                    </div>

                    <div class="p-6 relative">
                        <span
                            class="text-sm text-leafly-green font-medium mb-1 block">{{ $product->category->nama_category }}</span>
                        <h3 class="text-xl font-bold text-leafly-dark mb-2">{{ $product->nama_Product }}</h3>

                        <!-- rating -->
                        <div class="flex items-center mb-3">
                            @php
                                $avgRating = $product->reviews->avg('rating') ?? 0;
                                $reviewCount = $product->reviews->count();
                            @endphp
                            <span class="text-leafly-gold">
                                @for($i = 1; $i <= 5; $i++)
                                    {{ $i <= round($avgRating) ? '★' : '☆' }}
                                @endfor
                            </span>
                            <span class="text-gray-500 text-sm ml-2">({{ number_format($avgRating, 1) }} / {{ $reviewCount }}
                                Ulasan)</span>
                        </div>

                        <p class="text-gray-600 text-sm line-clamp-2 mb-6">{{ $product->deskripsi }}</p>

                        <div class="flex justify-between items-end pt-4 border-t border-gray-200/50">
                            <div>
                                <span class="text-2xl font-bold text-leafly-dark">Rp
                                    {{ number_format($product->harga, 0, ',', '.') }}</span>
                            </div>
                            <a href="{{ route('products.show', $product->id) }}"
                                class="bg-leafly-dark text-white w-9 h-9 rounded-full hover:bg-leafly-gold hover:text-leafly-dark transition flex items-center justify-center">
                                <i class="fa-solid fa-cart-plus"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('products.index') }}"
                class="inline-block px-8 py-3 bg-leafly-dark text-white rounded-full font-bold hover:bg-leafly-gold hover:text-leafly-dark transition duration-300 shadow-lg">
                Lihat Semua Product <i class="fa-solid fa-arrow-right ml-2"></i>
            </a>
        </div>
    </section>

    <!-- about -->
    <section id="about" class="py-20 px-6 bg-white">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
            <!-- left image -->
            <div class="">
                <img src="{{ asset('images/hero.png') }}" alt="About Leafly"
                    class="w-full h-80 md:h-96 object-cover rounded-2xl shadow-lg">
            </div>

            <!-- teks kanan -->
            <div class="">
                <h2 class="text-3xl font-bold text-leafly-dark mb-4">Tentang Leafly</h2>
                <p class="text-gray-700 mb-4">Leafly menghadirkan solusi berkebun modern untuk pemula sampai profesional.
                    Kami menyediakan benih, bibit berkualitas, dan perlengkapan hidroponik dengan layanan konsultasi untuk
                    membantu Anda dengan mudah menanam di rumah.</p>
                <ul class="list-disc list-inside text-gray-600 mb-6">
                    <li>Kualitas benih dan bibit terjamin</li>
                    <li>Perlengkapan hidroponik lengkap</li>
                    <li>Konsultasi dan panduan perawatan tanaman</li>
                </ul>
                <a href="{{ route('products.index') }}"
                    class="inline-block px-6 py-3 bg-leafly-green text-leafly-dark rounded-full font-bold hover:bg-leafly-gold transition duration-300">Lihat
                    Product Kami</a>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            // scroll nabvar
            $(window).scroll(function () {
                if ($(this).scrollTop() > 50) {
                    $('#navbar').addClass('py-2 shadow-md bg-opacity-95').removeClass('py-4');
                } else {
                    $('#navbar').addClass('py-4').removeClass('py-2 shadow-md bg-opacity-95');
                }
            });

            // toggle navbar
            $('#menuToggle').click(function () {
                $('#mobileMenu').slideToggle();
            });
        });
    </script>
@endpush
