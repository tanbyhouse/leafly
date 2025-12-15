@extends('layouts.app')

@section('title', 'Keranjang Belanja - Leafly')

@section('content')
    <div class="bg-leafly-cream min-h-screen pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <h1 class="text-3xl font-bold text-leafly-dark mb-8 flex items-center gap-3">
                <i class="fa-solid fa-cart-shopping"></i> Keranjang Belanja
            </h1>

            <!-- FLEX WRAPPER -->
            <div class="flex flex-col lg:flex-row gap-8">

                <!-- ================= KIRI: DAFTAR ITEM ================= -->
                <div class="w-full lg:w-2/3">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

                        <!-- Header -->
                        <div
                            class="hidden md:grid grid-cols-12 gap-4 p-4 bg-gray-50 border-b border-gray-200 text-sm font-bold text-gray-500 uppercase">
                            <div class="col-span-6">Produk</div>
                            <div class="col-span-2 text-center">Harga</div>
                            <div class="col-span-2 text-center">Jumlah</div>
                            <div class="col-span-2 text-center">Total</div>
                        </div>

                        <!-- Items -->
                        <div class="divide-y divide-gray-100" id="cart-container">
                            @forelse($cartItems as $item)
                                <div class="p-4 grid grid-cols-1 md:grid-cols-12 gap-4 items-center cart-item">

                                    <!-- Info Produk -->
                                    <div class="col-span-6 flex items-center gap-4">
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-gray-400 hover:text-red-500">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>

                                        <div
                                            class="w-16 h-16 bg-gray-100 rounded-lg overflow-hidden flex items-center justify-center">
                                            @if($item->product->images->isNotEmpty())
                                                <img src="{{ asset('storage/' . $item->product->images->first()->path) }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <i class="fa-solid fa-seedling text-leafly-green text-xl"></i>
                                            @endif
                                        </div>

                                        <div>
                                            <h3 class="font-bold text-leafly-dark">{{ $item->product->name }}</h3>
                                            <p class="text-xs text-gray-500">{{ $item->product->category->name }}</p>
                                        </div>
                                    </div>

                                    <!-- Harga -->
                                    <div class="col-span-2 text-center hidden md:block">
                                        Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                    </div>

                                    <!-- Qty -->
                                    <div class="col-span-2 flex justify-center">
                                        <div class="flex items-center border rounded overflow-hidden">

                                            <!-- minus -->
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="quantity" value="{{ $item->quantity - 1 }}">
                                                <button {{ $item->quantity <= 1 ? 'disabled' : '' }}
                                                    class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 disabled:opacity-40">
                                                    −
                                                </button>
                                            </form>

                                            <!-- qty -->
                                            <input type="text" class="w-10 text-center border-0 focus:ring-0"
                                                value="{{ $item->quantity }}" readonly>

                                            <!-- plus -->
                                            <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="quantity" value="{{ $item->quantity + 1 }}">
                                                <button class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700">
                                                    +
                                                </button>
                                            </form>

                                        </div>
                                    </div>

                                    <!-- Subtotal -->
                                    <div class="col-span-2 text-center font-bold text-leafly-dark">
                                        Rp {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}
                                    </div>
                                </div>
                            @empty
                                <div class="p-8 text-center text-gray-500">
                                    Keranjang masih kosong
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- ================= KANAN: RINGKASAN ================= -->
                <div class="w-full lg:w-1/3">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">

                        <h2 class="text-lg font-bold text-leafly-dark mb-4">Ringkasan Pesanan</h2>

                        <div class="space-y-3 text-sm text-gray-600 mb-6">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Biaya Layanan</span>
                                <span>Rp {{ number_format($adminFee, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="flex justify-between font-bold text-lg mb-6">
                            <span>Total</span>
                            <span>
                                Rp {{ number_format($subtotal + $adminFee, 0, ',', '.') }}
                            </span>
                        </div>

                        <!-- CHECKOUT -->
                        @auth
                            <a href="{{ route('checkout.index') }}"
                                class="block w-full text-center bg-leafly-dark text-white py-3 rounded-lg font-bold hover:bg-leafly-gold hover:text-leafly-dark transition">
                                Checkout Sekarang
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                                class="block w-full text-center bg-leafly-dark text-white py-3 rounded-lg font-bold hover:bg-leafly-gold hover:text-leafly-dark transition">
                                Login untuk Checkout
                            </a>
                        @endauth
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
