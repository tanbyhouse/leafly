@extends('layouts.app')

@section('title', 'Checkout - Leafly')

@section('content')
<div class="bg-leafly-cream min-h-screen pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Header --}}
        <div class="flex items-center gap-3 mb-8">
            <a href="{{ route('cart.index') }}" class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-leafly-dark shadow hover:bg-leafly-dark hover:text-white transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-leafly-dark">Pengiriman & Pembayaran</h1>
        </div>

        <form action="#" method="POST" id="checkout-form"> 
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
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penerima</label>
                                <input type="text" name="name" value="{{ Auth::check() ? Auth::user()->name : '' }}" class="w-full border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green" required>
                            </div>
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon (WhatsApp)</label>
                                <input type="tel" name="phone" class="w-full border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green" required>
                            </div>
                            <div class="col-span-1 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                                <textarea name="address" rows="2" class="w-full border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green" placeholder="Nama Jalan, No. Rumah, RT/RW, Patokan..." required></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kota / Kabupaten</label>
                                <select name="city" class="w-full border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green">
                                    <option value="Jember">Jember</option>
                                    <option value="Surabaya">Surabaya</option>
                                    <option value="Malang">Malang</option>
                                    <option value="Banyuwangi">Banyuwangi</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                                <input type="text" name="postal_code" class="w-full border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green">
                            </div>
                        </div>
                    </div>

                    {{-- 2. Opsi Pengiriman --}}
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                        <h2 class="text-lg font-bold text-leafly-dark mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-truck text-leafly-green"></i> Jasa Pengiriman
                        </h2>
                        <div class="space-y-3">
                            <label class="flex items-center justify-between p-4 border rounded-lg cursor-pointer hover:border-leafly-green hover:bg-green-50 transition bg-white" onclick="setShipping(10000)">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="courier" value="reguler" class="text-leafly-dark focus:ring-leafly-dark" checked>
                                    <div>
                                        <div class="font-bold text-gray-800">Reguler (JNE/J&T)</div>
                                        <div class="text-xs text-gray-500">Estimasi 2-3 Hari</div>
                                    </div>
                                </div>
                                <div class="font-bold text-leafly-dark">Rp 10.000</div>
                            </label>

                            <label class="flex items-center justify-between p-4 border rounded-lg cursor-pointer hover:border-leafly-green hover:bg-green-50 transition bg-white" onclick="setShipping(20000)">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="courier" value="express" class="text-leafly-dark focus:ring-leafly-dark">
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
                            <label class="relative flex flex-col p-4 bg-white border-2 border-transparent rounded-xl cursor-pointer shadow-sm hover:shadow-md transition payment-option ring-2 ring-gray-100">
                                <input type="radio" name="payment_method" value="transfer" class="absolute opacity-0" checked>
                                <div class="flex items-center justify-between mb-2">
                                    <i class="fa-solid fa-building-columns text-2xl text-blue-600"></i>
                                    <i class="fa-solid fa-circle-check text-leafly-dark text-xl check-icon hidden"></i>
                                </div>
                                <span class="font-bold text-gray-800">Transfer Bank</span>
                                <span class="text-xs text-gray-500 mt-1">BCA, Mandiri, BRI, BNI</span>
                            </label>

                            {{-- Pilihan COD --}}
                            <label class="relative flex flex-col p-4 bg-white border-2 border-transparent rounded-xl cursor-pointer shadow-sm hover:shadow-md transition payment-option ring-2 ring-gray-100">
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
                        <div class="space-y-4 mb-6 max-h-60 overflow-y-auto custom-scrollbar">
                            @foreach($cartItems as $item)
                            <div class="flex gap-3">
                                <div class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center shrink-0 text-leafly-green">
                                    <i class="fa-solid {{ $item['image'] }}"></i>
                                </div>
                                <div class="grow">
                                    <h4 class="text-sm font-bold text-gray-800 line-clamp-1">{{ $item['name'] }}</h4>
                                    <div class="flex justify-between text-xs text-gray-500 mt-1">
                                        <span>{{ $item['quantity'] }}x</span>
                                        <span>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        {{-- Rincian Biaya --}}
                        <div class="space-y-2 border-t border-gray-100 pt-4 text-sm text-gray-600 mb-6">
                            <div class="flex justify-between">
                                <span>Subtotal Produk</span>
                                <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
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
                        <button type="button" id="btn-pay" class="w-full bg-leafly-dark text-white font-bold py-3 rounded-lg hover:bg-leafly-gold hover:text-leafly-dark transition duration-300 shadow-lg flex justify-center items-center gap-2">
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Variabel Global untuk hitung-hitungan
    let subtotal = {{ $subtotal }};
    let adminFee = {{ $adminFee }};
    let shippingCost = 10000; // Default Reguler

    // Fungsi Update Ongkir
    function setShipping(cost) {
        shippingCost = cost;
        $('#shipping-cost-display').text('Rp ' + cost.toLocaleString('id-ID'));
        updateGrandTotal();
    }

    // update total ayar
    function updateGrandTotal() {
        let total = subtotal + adminFee + shippingCost;
        $('#grand-total-display').text('Rp ' + total.toLocaleString('id-ID'));
    }

    $(document).ready(function() {
        // highlight pilihan pembayaran
        $('input[name="payment_method"]').change(function() {
            // reset semua style
            $('.payment-option').removeClass('ring-leafly-green ring-2 bg-green-50').addClass('ring-gray-100 ring-2');
            $('.check-icon').addClass('hidden');

            // set style yg dipilih
            if ($(this).is(':checked')) {
                $(this).closest('label').removeClass('ring-gray-100').addClass('ring-leafly-green bg-green-50');
                $(this).closest('label').find('.check-icon').removeClass('hidden');
            }
        });

        // trigger change 
        $('input[name="payment_method"]:checked').trigger('change');

        // logic bayar
        $('#btn-pay').click(function() {
            Swal.fire({
                title: 'Konfirmasi Pesanan?',
                text: "Pastikan alamat dan pesanan sudah benar.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#225D2D',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Bayar!',
                cancelButtonText: 'Cek Lagi'
            }).then((result) => {
                if (result.isConfirmed) {
                    let timerInterval;
                    Swal.fire({
                        title: 'Memproses Pesanan...',
                        html: 'Mohon tunggu sebentar.',
                        timer: 2000,
                        timerProgressBar: true,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    }).then((result) => {
                        // redirect keranjang
                        Swal.fire({
                            icon: 'success',
                            title: 'Pesanan Berhasil Dibuat!',
                            text: 'Silakan cek riwayat transaksi Anda.',
                            confirmButtonColor: '#225D2D',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = "{{ route('cart.index') }}";
                        });
                    });
                }
            });
        });
    });
</script>
@endpush