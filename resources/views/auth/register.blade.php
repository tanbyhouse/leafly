@extends('layouts.app')

@section('title', 'Daftar Akun - Leafly')

@section('content')
    <div class="min-h-[85vh] mt-[3rem] flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-leafly-cream">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-2 text-center text-3xl font-extrabold text-leafly-dark">
                Bergabung Bersama Leafly
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="font-bold text-leafly-dark hover:text-leafly-gold transition">
                    Masuk di sini
                </a>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow-xl sm:rounded-lg sm:px-10 border-t-4 border-leafly-gold">

                {{-- ERROR --}}
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                        <ul class="text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="space-y-5" action="{{ route('register.post') }}" method="POST">
                    @csrf

                    {{-- NAMA --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-leafly-dark focus:border-leafly-dark">
                    </div>

                    {{-- EMAIL --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-leafly-dark focus:border-leafly-dark">
                    </div>

                    {{-- PASSWORD --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" required
                            class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-leafly-dark focus:border-leafly-dark">
                    </div>

                    {{-- KONFIRMASI --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ulangi Password</label>
                        <input type="password" name="password_confirmation" required
                            class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-leafly-dark focus:border-leafly-dark">
                    </div>

                    {{-- ALAMAT --}}
                    <div class="pt-2">
                        <h3 class="text-lg font-bold text-leafly-dark mb-3">
                            Alamat
                        </h3>

                        <div class="grid grid-cols-1 gap-5">
                            {{-- TELEPON --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">No. Telepon</label>
                                <input type="text" name="phone" value="{{ old('phone') }}" required
                                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-leafly-dark focus:border-leafly-dark">
                            </div>

                            {{-- ALAMAT --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                                <textarea name="address" rows="2" required
                                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-leafly-dark focus:border-leafly-dark">{{ old('address') }}</textarea>
                            </div>

                            {{-- PROVINSI --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Provinsi</label>
                                <select id="province_select"
                                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-leafly-dark focus:border-leafly-dark">
                                    <option value="">Pilih Provinsi</option>
                                </select>
                                <input type="hidden" name="province_id" id="province_id_input">
                            </div>

                            {{-- KOTA --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kota / Kabupaten</label>
                                <select id="city_select"
                                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-leafly-dark focus:border-leafly-dark">
                                    <option value="">Pilih Kota</option>
                                </select>
                                <input type="hidden" name="city_id" id="city_id_input">
                            </div>

                            {{-- KECAMATAN --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kecamatan</label>
                                <input type="text" name="district" value="{{ old('district') }}" required
                                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-leafly-dark focus:border-leafly-dark">
                            </div>

                            {{-- KODE POS --}}
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Kode Pos</label>
                                <input type="text" name="postal_code" value="{{ old('postal_code') }}"
                                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-leafly-dark focus:border-leafly-dark">
                            </div>
                        </div>
                    </div>

                    {{-- SUBMIT --}}
                    <button type="submit"
                        class="w-full py-2 px-4 rounded-md font-bold text-white bg-leafly-dark hover:bg-leafly-green hover:text-leafly-dark transition">
                        Daftar Sekarang
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {

            // LOAD PROVINCES
            $.get("{{ route('ajax.provinces') }}", function (res) {
                $('#province_select').html('<option value="">Pilih Provinsi</option>');
                res.forEach(p => {
                    $('#province_select').append(
                        `<option value="${p.id}">${p.name}</option>`
                    );
                });
            });

            // CHANGE PROVINCE → LOAD CITIES
            $('#province_select').on('change', function () {
                let provinceId = $(this).val();
                $('#province_id_input').val(provinceId);

                $('#city_select').html('<option value="">Pilih Kota</option>');
                $('#city_id_input').val('');

                if (!provinceId) return;

                $.get(
                    "{{ route('ajax.cities', ':id') }}".replace(':id', provinceId),
                    function (res) {
                        res.forEach(city => {
                            $('#city_select').append(
                                `<option value="${city.id}">${city.name}</option>`
                            );
                        });
                    }
                );
            });

            // CHANGE CITY
            $('#city_select').on('change', function () {
                $('#city_id_input').val($(this).val());
            });

        });
    </script>
@endpush
