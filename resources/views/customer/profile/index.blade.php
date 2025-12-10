@extends('layouts.app')

@section('title', 'Profil Saya - Leafly')

@section('content')
<div class="bg-leafly-cream min-h-screen pt-24 pb-12">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row gap-8">
            
            <!-- sidebar kiri -->
            <div class="w-full md:w-1/3 lg:w-1/4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden sticky top-24">
                    
                    <div class="p-6 text-center bg-leafly-dark text-white">
                        <div class="relative w-24 h-24 mx-auto mb-4 group">
                            
                            <div class="w-24 h-24 rounded-full bg-white p-1 overflow-hidden">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/'.$user->avatar) }}" class="w-full h-full object-cover rounded-full">
                                @else
                                    <img src="{{ asset('images/avatar.jpg') }}" alt="Avatar" class="w-full h-full object-cover rounded-full shadow-sm">
                                @endif
                            </div>
                            
                            <button class="absolute bottom-0 right-0 bg-leafly-gold text-leafly-dark w-8 h-8 rounded-full flex items-center justify-center shadow-lg hover:bg-leafly-green transition cursor-pointer">
                                <i class="fa-solid fa-camera text-xs"></i>
                            </button>
                        </div>
                        <h2 class="font-bold text-lg">{{ $user->name }}</h2>
                        <p class="text-xs text-green-100">Member Leafly</p>
                    </div>

                    <!-- menu navigasi -->
                    <div class="p-4">
                        <nav class="space-y-1">
                            <a href="#" class="flex items-center gap-3 px-4 py-3 bg-green-50 text-leafly-dark font-bold rounded-lg transition">
                                <i class="fa-regular fa-id-card w-5"></i> Biodata Diri
                            </a>
                            <a href="{{ route('orders.index') }}" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-leafly-dark font-medium rounded-lg transition">
                                <i class="fa-solid fa-box-open w-5"></i> Pesanan Saya
                            </a>
                            <a href="#" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-leafly-dark font-medium rounded-lg transition">
                                <i class="fa-solid fa-map-location-dot w-5"></i> Daftar Alamat
                            </a>
                            <a href="#ganti-pw" class="flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-gray-50 hover:text-leafly-dark font-medium rounded-lg transition">
                                <i class="fa-solid fa-lock w-5"></i> Ubah Password
                            </a>
                            <div class="border-t border-gray-100 my-2"></div>
                            <button class="w-full flex items-center gap-3 px-4 py-3 text-red-500 hover:bg-red-50 font-medium rounded-lg transition">
                                <i class="fa-solid fa-arrow-right-from-bracket w-5"></i> Keluar
                            </button>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- content kanan -->
            <div class="w-full md:w-2/3 lg:w-3/4">
                
                <!-- edit profile -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 mb-8">
                    <div class="p-6 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="font-bold text-leafly-dark text-lg">Ubah Biodata Diri</h3>
                        <button class="text-sm text-gray-500 hover:text-leafly-dark">
                            <i class="fa-solid fa-circle-info"></i> Info
                        </button>
                    </div>
                    <div class="p-6">
                        <form action="#" method="POST">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                
                                <div class="col-span-1 md:col-span-2">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                            <i class="fa-regular fa-user"></i>
                                        </span>
                                        <input type="text" name="name" value="{{ $user->name }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                            <i class="fa-regular fa-envelope"></i>
                                        </span>
                                        <input type="email" name="email" value="{{ $user->email }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green bg-gray-50" readonly>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">*Email tidak dapat diubah</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Nomor Telepon</label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                            <i class="fa-solid fa-phone"></i>
                                        </span>
                                        <input type="tel" name="phone" value="{{ $user->phone }}" class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Jenis Kelamin</label>
                                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green">
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" selected>Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Lahir</label>
                                    <input type="date" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green">
                                </div>
                            </div>

                            <div class="mt-8 flex justify-end">
                                <button type="button" class="btn-save px-6 py-2 bg-leafly-dark text-white font-bold rounded-lg hover:bg-leafly-gold hover:text-leafly-dark transition shadow-md">
                                    Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div id="ganti-pw" class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="font-bold text-leafly-dark text-lg">Keamanan Akun</h3>
                    </div>
                    <div class="p-6">
                        <form action="#">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="col-span-2 md:col-span-1">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Kata Sandi Baru</label>
                                    <input type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green" placeholder="Minimal 8 karakter">
                                </div>
                                <div class="col-span-2 md:col-span-1">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Ulangi Kata Sandi</label>
                                    <input type="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-leafly-green focus:border-leafly-green" placeholder="Konfirmasi sandi baru">
                                </div>
                            </div>
                            <div class="mt-6 flex justify-end">
                                <button type="button" class="btn-save px-6 py-2 border border-leafly-dark text-leafly-dark font-bold rounded-lg hover:bg-leafly-dark hover:text-white transition">
                                    Ganti Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('.btn-save').click(function() {
            // Simulasi Loading & Sukses
            let btn = $(this);
            let originalText = btn.text();
            
            btn.html('<i class="fa-solid fa-circle-notch fa-spin"></i> Menyimpan...').prop('disabled', true);

            setTimeout(function() {
                btn.html(originalText).prop('disabled', false);
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Disimpan!',
                    text: 'Data profilmu telah diperbarui.',
                    confirmButtonColor: '#225D2D',
                    timer: 2000
                });
            }, 1500);
        });
    });
</script>
@endpush