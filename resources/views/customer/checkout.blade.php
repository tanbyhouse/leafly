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

                {{-- HIDDEN --}}
                <input type="hidden" name="shipping_cost" id="shipping_cost_input" value="0">
                <input type="hidden" name="courier" id="courier_input" value="jne">
                <input type="hidden" name="service" id="service_input" value="REG">
                <input type="hidden" name="province_id" id="province_id_input" value="">
                <input type="hidden" name="city_id" id="city_id_input" value="">

                <div class="flex flex-col lg:flex-row gap-8">

                    {{-- KOLOM KIRI --}}
                    <div class="w-full lg:w-2/3 space-y-6">

                        {{-- 1. Alamat Pengiriman --}}
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <h2 class="text-lg font-bold text-leafly-dark mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-map-location-dot text-leafly-green"></i> Alamat Pengiriman
                            </h2>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="col-span-1 md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penerima *</label>
                                    <input type="text" name="name" value="{{ old('name', Auth::user()->name ?? '') }}"
                                        class="w-full border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green"
                                        required>
                                </div>

                                <div class="col-span-1 md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon (WhatsApp)
                                        *</label>
                                    <input type="tel" name="phone" value="{{ old('phone') }}"
                                        class="w-full border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green"
                                        required>
                                </div>

                                <div class="col-span-1 md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat (Jalan) *</label>
                                    <textarea name="address" rows="2"
                                        class="w-full border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green"
                                        placeholder="Nama Jalan, No. Rumah, RT/RW, Patokan..."
                                        required>{{ old('address') }}</textarea>
                                </div>

                                {{-- PROVINSI --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi *</label>
                                    <select id="province_select"
                                        class="w-full border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green"
                                        required>
                                        <option value="">Pilih Provinsi</option>
                                    </select>
                                </div>

                                {{-- KOTA --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kota / Kabupaten *</label>
                                    <select id="city_select"
                                        class="w-full border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green"
                                        required>
                                        <option value="">Pilih Kota</option>
                                    </select>
                                </div>

                                {{-- KECAMATAN --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kecamatan *</label>
                                    <input type="text" name="district" value="{{ old('district') }}"
                                        class="w-full border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green"
                                        required>
                                </div>

                                {{-- KODE POS --}}
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Pos</label>
                                    <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                                        class="w-full border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green">
                                </div>

                                <div class="col-span-1 md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">
                                        Label Alamat *
                                    </label>
                                    <select name="label"
                                        class="w-full border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green"
                                        required>
                                        <option value="">Pilih Label</option>
                                        <option value="Rumah">Rumah</option>
                                        <option value="Kantor">Kantor</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
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
                                {{-- Reguler: JNE REG --}}
                                <label
                                    class="flex items-center justify-between p-4 border rounded-lg cursor-pointer hover:border-leafly-green hover:bg-green-50 transition bg-white"
                                    onclick="setCourier('jne','REG')">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="courier_radio"
                                            class="text-leafly-dark focus:ring-leafly-dark" checked>
                                        <div>
                                            <div class="font-bold text-gray-800">Reguler (JNE)</div>
                                            <div class="text-xs text-gray-500">Estimasi 2-3 Hari</div>
                                        </div>
                                    </div>
                                    <div class="font-bold text-leafly-dark" id="label_reg">-</div>
                                </label>

                                {{-- Express: JNE YES --}}
                                <label
                                    class="flex items-center justify-between p-4 border rounded-lg cursor-pointer hover:border-leafly-green hover:bg-green-50 transition bg-white"
                                    onclick="setCourier('jne','YES')">
                                    <div class="flex items-center gap-3">
                                        <input type="radio" name="courier_radio"
                                            class="text-leafly-dark focus:ring-leafly-dark">
                                        <div>
                                            <div class="font-bold text-gray-800">Express (Next Day)</div>
                                            <div class="text-xs text-gray-500">Estimasi 1 Hari</div>
                                        </div>
                                    </div>
                                    <div class="font-bold text-leafly-dark" id="label_yes">-</div>
                                </label>
                            </div>

                            <p class="text-xs text-gray-500 mt-3">
                                * Ongkir dihitung otomatis via RajaOngkir setelah Kota dipilih.
                            </p>
                        </div>

                        {{-- 3. Metode Pembayaran --}}
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <h2 class="text-lg font-bold text-leafly-dark mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-wallet text-leafly-green"></i> Metode Pembayaran
                            </h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <label
                                    class="relative flex flex-col p-4 bg-white border-2 rounded-xl cursor-pointer shadow-sm hover:shadow-md transition payment-option border-leafly-green bg-green-50">
                                    {{-- ✅ FIX: hapus checked agar JS yang mengontrol --}}
                                    <input type="radio" name="payment_method" value="transfer" class="absolute opacity-0">
                                    <div class="flex items-center justify-between mb-2">
                                        <i class="fa-solid fa-building-columns text-2xl text-blue-600"></i>
                                        <i class="fa-solid fa-circle-check text-leafly-dark text-xl check-icon"></i>
                                    </div>
                                    <span class="font-bold text-gray-800">Transfer Bank</span>
                                    <span class="text-xs text-gray-500 mt-1">BCA, Mandiri, BRI, BNI</span>
                                </label>

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

                    {{-- KOLOM KANAN --}}
                    <div class="w-full lg:w-1/3">
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 sticky top-24">
                            <h2 class="text-lg font-bold text-leafly-dark mb-4">Ringkasan Pesanan</h2>

                            <div class="space-y-3 mb-6 max-h-60 overflow-y-auto">
                                @foreach($cartItems as $item)
                                    <div class="flex gap-3 pb-3 border-b border-gray-100">
                                        <div
                                            class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center shrink-0 overflow-hidden">
                                            @if($item->product->images->isNotEmpty())
                                                <img src="{{ asset('storage/' . $item->product->images->first()->path) }}"
                                                    alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                            @else
                                                <i class="fa-solid fa-seedling text-leafly-green"></i>
                                            @endif
                                        </div>
                                        <div class="grow">
                                            <h4 class="text-sm font-bold text-gray-800 line-clamp-1">
                                                {{ $item->product->name }}
                                            </h4>
                                            <div class="flex justify-between text-xs text-gray-500 mt-1">
                                                <span>{{ $item->quantity }}x</span>
                                                <span>Rp
                                                    {{ number_format($item->product->price * $item->quantity, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

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
                                    <span id="shipping-cost-display">Rp 0</span>
                                </div>
                                <div class="flex justify-between text-xs text-gray-500">
                                    <span>Service</span>
                                    <span id="shipping-service-display">-</span>
                                </div>
                                <div class="flex justify-between text-xs text-gray-500">
                                    <span>ETD</span>
                                    <span id="shipping-etd-display">-</span>
                                </div>
                            </div>

                            <div class="flex justify-between items-center mb-6 pt-4 border-t border-dashed border-gray-300">
                                <span class="font-bold text-leafly-dark text-lg">Total Tagihan</span>
                                <span class="font-bold text-leafly-dark text-xl" id="grand-total-display">
                                    Rp {{ number_format($subtotal + $adminFee, 0, ',', '.') }}
                                </span>
                            </div>

                            <button type="button" id="btn-pay"
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let subtotal = {{ $subtotal }};
        let adminFee = {{ $adminFee }};
        let courier = 'jne';
        let service = 'REG';
        let shippingCost = 0;

        /* =========================
           TOTAL
        ========================= */
        function updateGrandTotal() {
            let total = subtotal + adminFee + shippingCost;
            $('#grand-total-display').text('Rp ' + total.toLocaleString('id-ID'));
            $('#shipping-cost-display').text('Rp ' + shippingCost.toLocaleString('id-ID'));
            $('#shipping_cost_input').val(shippingCost);
            $('#courier_input').val(courier);
            $('#service_input').val(service);
        }

        /* =========================
           PROVINCE
        ========================= */
        function fetchProvinces() {
            $.get("{{ route('ajax.provinces') }}", function (res) {
                $('#province_select').html('<option value="">Pilih Provinsi</option>');
                res.forEach(p => {
                    $('#province_select').append(`<option value="${p.id}">${p.name}</option>`);
                });
            });
        }

        /* =========================
           CITY
        ========================= */
        function fetchCities(provinceId) {
            $('#city_select').html('<option value="">Loading...</option>');
            $.get(`/ajax/cities/${provinceId}`, function (res) {
                $('#city_select').html('<option value="">Pilih Kota</option>');
                res.forEach(c => {
                    $('#city_select').append(`<option value="${c.id}">${c.name}</option>`);
                });
            });
        }

        /* =========================
           ONGKIR
        ========================= */
        function fetchOngkir() {
            let cityId = $('#city_select').val();
            if (!cityId) return;

            $.post("{{ route('ajax.ongkir') }}", {
                _token: "{{ csrf_token() }}",
                city_id: cityId,
                courier: courier
            }, function (res) {
                if (!res.success) {
                    Swal.fire('Error', res.message ?? 'Gagal hitung ongkir', 'error');
                    return;
                }

                shippingCost = parseInt(res.data.cost);

                // ✅ FIX: ringkasan service harus ikut pilihan (REG / YES)
                $('#shipping-service-display').text(courier.toUpperCase() + ' ' + service);

                $('#shipping-etd-display').text(res.data.etd + ' hari');

                updateGrandTotal();

                // (optional) tampilkan biaya di label kanan opsi pengiriman
                if (service === 'REG') $('#label_reg').text('Rp ' + shippingCost.toLocaleString('id-ID'));
                if (service === 'YES') $('#label_yes').text('Rp ' + shippingCost.toLocaleString('id-ID'));
            }).fail(() => {
                Swal.fire('Error', 'Gagal hitung ongkir', 'error');
            });
        }

        /* =========================
           SHIPPING OPTION
        ========================= */
        function setCourier(c, s) {
            courier = c;
            service = s;

            // ✅ FIX: sync radio yang dipilih (biar tidak selalu yg pertama)
            $('input[name="courier_radio"]').prop('checked', false);
            if (s === 'REG') $('input[name="courier_radio"]').eq(0).prop('checked', true);
            if (s === 'YES') $('input[name="courier_radio"]').eq(1).prop('checked', true);

            // ✅ FIX: update hidden input courier/service
            $('#courier_input').val(courier);
            $('#service_input').val(service);

            // ✅ FIX: ringkasan service langsung berubah walau ongkir belum balik
            $('#shipping-service-display').text(courier.toUpperCase() + ' ' + service);

            // hitung ulang kalau kota sudah dipilih
            fetchOngkir();
        }

        /* =========================
           PAYMENT METHOD
        ========================= */
        function setPayment(method) {
            // ✅ FIX: pastikan radio yang benar tercentang
            $('input[name="payment_method"]').prop('checked', false);
            $(`input[name="payment_method"][value="${method}"]`).prop('checked', true);

            // ✅ FIX: highlight card + ikon cek
            $('.payment-option')
                .removeClass('border-leafly-green bg-green-50')
                .addClass('border-gray-100');

            $('.payment-option .check-icon').addClass('hidden');

            const $card = $(`input[name="payment_method"][value="${method}"]`).closest('.payment-option');
            $card.removeClass('border-gray-100').addClass('border-leafly-green bg-green-50');
            $card.find('.check-icon').removeClass('hidden');
        }

        /* =========================
           INIT
        ========================= */
        $(document).ready(function () {

            fetchProvinces();

            // ✅ FIX: set default payment transfer via JS (karena checked sudah dihapus)
            setPayment('transfer');

            // ✅ FIX: set default courier/service ke ringkasan
            $('#shipping-service-display').text(courier.toUpperCase() + ' ' + service);
            updateGrandTotal();

            $('#province_select').on('change', function () {
                let id = $(this).val();
                $('#province_id_input').val(id);
                $('#city_id_input').val('');
                shippingCost = 0;

                // reset ringkasan ongkir
                $('#shipping-cost-display').text('Rp 0');
                $('#shipping-etd-display').text('-');

                updateGrandTotal();
                if (id) fetchCities(id);
            });

            $('#city_select').on('change', function () {
                $('#city_id_input').val($(this).val());
                shippingCost = 0;
                updateGrandTotal();
                fetchOngkir();
            });

            $('.payment-option').on('click', function () {
                let method = $(this).find('input[name="payment_method"]').val();
                setPayment(method);
            });

            $('#btn-pay').on('click', function () {

                if (!$('#province_id_input').val() || !$('#city_id_input').val()) {
                    Swal.fire('Alamat belum lengkap', 'Pilih provinsi dan kota', 'warning');
                    return;
                }

                if (shippingCost <= 0) {
                    Swal.fire('Ongkir belum dihitung', 'Pilih kota terlebih dahulu', 'warning');
                    return;
                }

                Swal.fire({
                    title: 'Konfirmasi Pesanan?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Bayar Sekarang'
                }).then(res => {
                    if (res.isConfirmed) {
                        $('#checkout-form').submit();
                    }
                });
            });
        });
    </script>
@endpush
