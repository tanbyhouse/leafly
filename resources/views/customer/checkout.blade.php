@extends('layouts.app')

@section('title', 'Checkout - Leafly')

@section('content')
    <div class="bg-leafly-cream min-h-screen pt-24 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="flex items-center gap-3 mb-8">
                <a href="{{ route('cart.index') }}"
                    class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-leafly-dark shadow hover:bg-leafly-dark hover:text-white transition">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>
                <h1 class="text-3xl font-bold text-leafly-dark">Pengiriman & Pembayaran</h1>
            </div>

            {{-- Error Messages --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                    <ul class="list-disc list-inside text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                @csrf
                <div class="flex flex-col lg:flex-row gap-8">

                    {{-- KOLOM KIRI: Form Input --}}
                    <div class="w-full lg:w-2/3 space-y-6">

                        {{-- 1. Alamat Pengiriman --}}
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <h2 class="text-lg font-bold text-leafly-dark mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-map-location-dot text-leafly-green"></i> Alamat Pengiriman
                            </h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="col-span-1 md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penerima *</label>
                                    <input type="text" name="name"
                                        value="{{ old('name', Auth::user()->pelanggan->nama ?? '') }}"
                                        class="w-full border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green"
                                        required>
                                </div>
                                <div class="col-span-1 md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon (WhatsApp)
                                        *</label>
                                    <input type="tel" name="phone"
                                        value="{{ old('phone', Auth::user()->pelanggan->telepon ?? '') }}"
                                        class="w-full border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green"
                                        required>
                                </div>
                                <div class="col-span-1 md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap *</label>
                                    <textarea name="address" rows="2"
                                        class="w-full border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green"
                                        placeholder="Nama Jalan, No. Rumah, RT/RW, Patokan..."
                                        required>{{ old('address') }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kota / Kabupaten *</label>
                                    <input type="text" name="city" value="{{ old('city', 'Jember') }}"
                                        class="w-full border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green"
                                        required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                                    <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                                        class="w-full border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green">
                                </div>
                                <div class="col-span-1 md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (Optional)</label>
                                    <textarea name="notes" rows="2"
                                        class="w-full border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green"
                                        placeholder="Catatan untuk kurir...">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>

                        {{-- 2. Opsi Pengiriman --}}
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <h2 class="text-lg font-bold text-leafly-dark mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-truck text-leafly-green"></i> Jasa Pengiriman
                            </h2>
                            <div class="space-y-3">
                                <label
                                    class="flex items-center justify-between p-4 border rounded-lg cursor-pointer hover:border-leafly-green hover:bg-green-50 transition bg-white">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="courier" value="reguler"
                                            class="text-leafly-dark focus:ring-leafly-dark" checked>
                                        <div>
                                            <div class="font-bold text-gray-800">Reguler (JNE/J&T)</div>
                                            <div class="text-xs text-gray-500">Estimasi 2-3 Hari</div>
                                        </div>
                                    </div>
                                    <div class="font-bold text-leafly-dark">Rp 10.000</div>
                                </label>

                                <label
                                    class="flex items-center justify-between p-4 border rounded-lg cursor-pointer hover:border-leafly-green hover:bg-green-50 transition bg-white">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="courier" value="express"
                                            class="text-leafly-dark focus:ring-leafly-dark">
                                        <div>
                                            <div class="font-bold text-gray-800">Express (Next Day)</div>
                                            <div class="text-xs text-gray-500">Estimasi 1 Hari</div>
                                        </div>
                                    </div>
                                    <div class="font-bold text-leafly-dark">Rp 20.000</div>
                                </label>
                            </div>
                        </div>

                        {{-- 3. Metode Pembayaran --}}
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <h2 class="text-lg font-bold text-leafly-dark mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-wallet text-leafly-green"></i> Metode Pembayaran
                            </h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                {{-- Pilihan Transfer --}}
                                <label
                                    class="relative flex flex-col p-4 bg-white border-2 rounded-xl cursor-pointer shadow-sm hover:shadow-md transition payment-option border-leafly-green bg-green-50">
                                    <input type="radio" name="payment_method" value="transfer" class="absolute opacity-0"
                                        checked>
                                    <div class="flex items-center justify-between mb-2">
                                        <i class="fa-solid fa-building-columns text-2xl text-blue-600"></i>
                                        <i class="fa-solid fa-circle-check text-leafly-dark text-xl check-icon"></i>
                                    </div>
                                    <span class="font-bold text-gray-800">Transfer Bank</span>
                                    <span class="text-xs text-gray-500 mt-1">BCA, Mandiri, BRI, BNI</span>
                                </label>

                                {{-- Pilihan COD --}}
                                <label
                                    class="relative flex flex-col p-4 bg-white border-2 border-gray-100 rounded-xl cursor-pointer shadow-sm hover:shadow-md transition payment-option">
                                    <input type="radio" name="payment_method" value="cod" class="absolute opacity-0">
                                    <div class="flex items-center justify-between mb-2">
                                        <i class="fa-solid fa-hand-holding-dollar text-2xl text-green-600"></i>
                                        <i class="fa-solid fa-circle-check text-leafly-dark text-xl check-icon hidden"></i>
                                    </div>
                                    <span class="font-bold text-gray-800">Bayar di Tempat (COD)</span>
                                    <span class="text-xs text-gray-500 mt-1">Bayar tunai ke kurir</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM KANAN: Ringkasan --}}
                    <div class="w-full lg:w-1/3">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
                            <h2 class="text-lg font-bold text-leafly-dark mb-4">Ringkasan Pesanan</h2>

                            {{-- List Barang --}}
                            <div class="space-y-3 mb-6 max-h-60 overflow-y-auto">
                                @foreach($cartItems as $item)
                                    <div class="flex gap-3 pb-3 border-b border-gray-100">
                                        <div
                                            class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center shrink-0 overflow-hidden">
                                            @if($item->product->images->isNotEmpty())
                                                <img src="{{ asset('storage/' . $item->product->images->first()->path_foto) }}"
                                                    alt="{{ $item->product->nama_product }}" class="w-full h-full object-cover">
                                            @else
                                                <i class="fa-solid fa-seedling text-leafly-green"></i>
                                            @endif
                                        </div>
                                        <div class="grow">
                                            <h4 class="text-sm font-bold text-gray-800 line-clamp-1">
                                                {{ $item->product->nama_product }}</h4>
                                            <div class="flex justify-between text-xs text-gray-500 mt-1">
                                                <span>{{ $item->jumlah }}x</span>
                                                <span>Rp
                                                    {{ number_format($item->product->harga * $item->jumlah, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- Rincian Biaya --}}
                            <div class="space-y-2 border-t border-gray-100 pt-4 text-sm text-gray-600 mb-6">
                                <div class="flex justify-between">
                                    <span>Subtotal product</span>
                                    <span id="subtotal-display">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Biaya Layanan</span>
                                    <span>Rp {{ number_format($adminFee, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between font-medium text-leafly-dark">
                                    <span>Ongkos Kirim</span>
                                    <span id="shipping-cost-display">Rp 10.000</span>
                                </div>
                            </div>

                            {{-- Total Akhir --}}
                            <div class="flex justify-between items-center mb-6 pt-4 border-t border-dashed border-gray-300">
                                <span class="font-bold text-leafly-dark text-lg">Total Tagihan</span>
                                <span class="font-bold text-leafly-dark text-xl" id="grand-total-display">
                                    Rp {{ number_format($subtotal + $adminFee + 10000, 0, ',', '.') }}
                                </span>
                            </div>

                            {{-- Tombol Bayar --}}
                            <button type="submit"
                                class="w-full bg-leafly-dark text-white font-bold py-3 rounded-lg hover:bg-leafly-gold hover:text-leafly-dark transition duration-300 shadow-lg flex justify-center items-center gap-2">
                                <i class="fa-solid fa-lock"></i> Bayar Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Variabel Global
        let subtotal = {{ $subtotal }};
        let adminFee = {{ $adminFee }};
        let shippingCost = 10000;

        // Update shipping cost on courier change
        $('input[name="courier"]').on('change', function () {
            shippingCost = $(this).val() === 'express' ? 20000 : 10000;
            updateTotal();
        });

        function updateTotal() {
            let total = subtotal + adminFee + shippingCost;
            $('#shipping-cost-display').text('Rp ' + shippingCost.toLocaleString('id-ID'));
            $('#grand-total-display').text('Rp ' + total.toLocaleString('id-ID'));
        }

        $(document).ready(function () {
            // Payment method selection
            $('input[name="payment_method"]').on('change', function () {
                $('.payment-option').removeClass('border-leafly-green bg-green-50').addClass('border-gray-100');
                $('.check-icon').addClass('hidden');

                if ($(this).is(':checked')) {
                    $(this).closest('.payment-option').removeClass('border-gray-100').addClass('border-leafly-green bg-green-50');
                    $(this).closest('.payment-option').find('.check-icon').removeClass('hidden');
                }
            });

            // Form submission
            $('#checkout-form').on('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Konfirmasi Pesanan?',
                    text: "Pastikan alamat dan pesanan sudah benar.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#225D2D',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Proses!',
                    cancelButtonText: 'Cek Lagi'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
@endpush
