@extends('layouts.app')

@section('title', 'Keranjang Belanja - Leafly')

@section('content')
<div class="bg-leafly-cream min-h-screen pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <h1 class="text-3xl font-bold text-leafly-dark mb-8 flex items-center gap-3">
            <i class="fa-solid fa-cart-shopping"></i> Keranjang Belanja
        </h1>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- daftar items -->
            <div class="w-full lg:w-2/3">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    
                    <div class="hidden md:grid grid-cols-12 gap-4 p-4 bg-gray-50 border-b border-gray-200 text-sm font-bold text-gray-500 uppercase">
                        <div class="col-span-6">Produk</div>
                        <div class="col-span-2 text-center">Harga</div>
                        <div class="col-span-2 text-center">Jumlah</div>
                        <div class="col-span-2 text-center">Total</div>
                    </div>

                    <!-- loop items keranjang -->
                    <div class="divide-y divide-gray-100" id="cart-container">
                        @foreach($cartItems as $item)
                        <div class="p-4 grid grid-cols-1 md:grid-cols-12 gap-4 items-center cart-item" data-price="{{ $item['price'] }}">
                            
                            <!-- info produk -->
                            <div class="col-span-6 flex items-center gap-4">
                                
                                <button class="text-gray-400 hover:text-red-500 transition btn-delete">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                                
                                <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center shrink-0 text-leafly-green text-2xl">
                                    <i class="fa-solid {{ $item['image'] }}"></i>
                                </div>
                                
                                <div>
                                    <h3 class="font-bold text-leafly-dark text-sm md:text-base">{{ $item['name'] }}</h3>
                                    <p class="text-xs text-gray-500 md:hidden">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <!-- harga satuan -->
                            <div class="col-span-2 text-center text-gray-600 hidden md:block">
                                Rp {{ number_format($item['price'], 0, ',', '.') }}
                            </div>

                            <!-- input jumlah -->
                            <div class="col-span-2 flex justify-center">
                                <div class="flex items-center border border-gray-300 rounded-lg h-8 w-24">
                                    <button class="w-8 h-full bg-gray-50 hover:bg-gray-100 text-gray-600 rounded-l-lg btn-minus">-</button>
                                    <input type="number" value="{{ $item['quantity'] }}" min="1" class="w-8 h-full text-center border-none focus:ring-0 p-0 text-sm font-bold text-leafly-dark input-qty" readonly>
                                    <button class="w-8 h-full bg-gray-50 hover:bg-gray-100 text-gray-600 rounded-r-lg btn-plus">+</button>
                                </div>
                            </div>

                            <!-- subtotal -->
                            <div class="col-span-2 text-center font-bold text-leafly-dark subtotal-text">
                                Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <!-- keranjang kosong -->
                    <div id="empty-cart-msg" class="hidden p-8 text-center text-gray-500">
                        <i class="fa-solid fa-basket-shopping text-4xl mb-3 text-gray-300"></i>
                        <p>Keranjang belanja Anda kosong.</p>
                        <a href="{{ route('products.index') }}" class="text-leafly-dark font-bold hover:underline text-sm mt-2 inline-block">Mulai Belanja</a>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('products.index') }}" class="text-leafly-dark font-medium hover:text-leafly-gold transition flex items-center gap-2 text-sm">
                        <i class="fa-solid fa-arrow-left"></i> Lanjut Belanja
                    </a>
                </div>
            </div>

            <!-- ringkasan belanja -->
            <div class="w-full lg:w-1/3">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
                    <h2 class="text-lg font-bold text-leafly-dark mb-4">Ringkasan Pesanan</h2>
                    
                    <div class="space-y-3 mb-6 border-b border-gray-100 pb-6 text-sm text-gray-600">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span id="grand-total-display">Rp 0</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Biaya Layanan</span>
                            <span>Rp 1.000</span>
                        </div>
                        <div class="flex justify-between text-green-600">
                            <span>Diskon</span>
                            <span>-Rp 0</span>
                        </div>
                    </div>

                    <div class="flex justify-between items-center mb-6">
                        <span class="font-bold text-leafly-dark text-lg">Total Bayar</span>
                        <span class="font-bold text-leafly-dark text-xl" id="final-total-display">Rp 0</span>
                    </div>

                    <!-- checkout -->
                     <a href="{{ route('checkout.index') }}" class="block w-full bg-leafly-dark text-white font-bold text-center py-3 rounded-lg hover:bg-leafly-gold hover:text-leafly-dark transition duration-300 shadow-lg transform active:scale-95">
                        Checkout Sekarang
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- sticky footer mobile -->
<div class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 p-4 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.1)] md:hidden z-40">
    <div class="flex justify-between items-center gap-4">
        <div class="flex flex-col">
            <span class="text-xs text-gray-500">Total Pembayaran</span>
            <span class="text-lg font-bold text-leafly-dark" id="mobile-total-display">Rp 0</span>
        </div>
        <a href="#" class="bg-leafly-dark text-white font-bold py-2 px-6 rounded-lg hover:bg-leafly-gold hover:text-leafly-dark transition">
            Checkout
        </a>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Fungsi Update Total
        function updateTotals() {
            let subtotal = 0;
            
            $('.cart-item').each(function() {
                let price = $(this).data('price');
                let qty = parseInt($(this).find('.input-qty').val());
                let itemTotal = price * qty;
                
                // Update text subtotal per item
                $(this).find('.subtotal-text').text('Rp ' + itemTotal.toLocaleString('id-ID'));
                
                subtotal += itemTotal;
            });

            // Update Ringkasan
            let adminFee = 1000;
            let finalTotal = subtotal + adminFee;

            if ($('.cart-item').length === 0) {
                finalTotal = 0; // Kalau kosong, total 0
                $('#empty-cart-msg').removeClass('hidden');
            }

            $('#grand-total-display').text('Rp ' + subtotal.toLocaleString('id-ID'));
            $('#final-total-display').text('Rp ' + finalTotal.toLocaleString('id-ID'));
            $('#mobile-total-display').text('Rp ' + finalTotal.toLocaleString('id-ID'));
        }

        // Event: Tombol Plus
        $('.btn-plus').click(function() {
            let input = $(this).siblings('.input-qty');
            let val = parseInt(input.val());
            input.val(val + 1);
            updateTotals();
        });

        // Event: Tombol Minus
        $('.btn-minus').click(function() {
            let input = $(this).siblings('.input-qty');
            let val = parseInt(input.val());
            if (val > 1) {
                input.val(val - 1);
                updateTotals();
            }
        });

        // Event: Tombol Hapus
        $('.btn-delete').click(function() {
            let row = $(this).closest('.cart-item');
            
            Swal.fire({
                title: 'Hapus item ini?',
                text: "Item akan dihapus dari keranjangmu",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#225D2D', // Warna Leafly Dark
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Efek fade out sebelum menghapus
                    row.fadeOut(300, function() {
                        $(this).remove();
                        updateTotals();
                        
                        // Alert sukses kecil di pojok
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                        Toast.fire({
                            icon: 'success',
                            title: 'Item berhasil dihapus'
                        });
                    });
                }
            })
        });
        // Jalankan saat pertama kali load
        updateTotals();
    });
</script>
@endpush