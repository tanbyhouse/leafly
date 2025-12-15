@extends('layouts.app')

@section('title', 'Daftar Akun - Leafly')

@section('content')
<div class="min-h-[85vh] mt-12 flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-leafly-cream">
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
            <form class="space-y-5" action="#" method="POST">
                @csrf
                
                {{-- Nama Lengkap --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <div class="mt-1">
                        <input id="name" name="name" type="text" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-leafly-dark focus:border-leafly-dark sm:text-sm">
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-leafly-dark focus:border-leafly-dark sm:text-sm">
                    </div>
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-leafly-dark focus:border-leafly-dark sm:text-sm">
                    </div>
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Ulangi Kata Sandi</label>
                    <div class="mt-1">
                        <input id="password_confirmation" name="password_confirmation" type="password" required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-leafly-dark focus:border-leafly-dark sm:text-sm">
                    </div>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-leafly-dark hover:bg-leafly-green hover:text-leafly-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-leafly-dark transition duration-300 transform hover:-translate-y-1">
                        Daftar Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection