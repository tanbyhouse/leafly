@extends('layouts.app')

@section('title', 'Masuk - Leafly')

@section('content')
<div class="min-h-[85vh] mt-12 flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-leafly-cream">
    <div class="min-h-[85vh] mt-[3rem] flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-leafly-cream">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="mt-2 text-center text-3xl font-extrabold text-leafly-dark">
                Selamat Datang Kembali
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="font-bold text-leafly-dark hover:text-leafly-gold transition">
                    Daftar gratis di sini
                </a>
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow-xl sm:rounded-lg sm:px-10 border-t-4 border-leafly-gold">

                {{-- Display Errors --}}
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-circle text-red-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-red-700 font-medium">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Success Message --}}
                @if (session('success'))
                    <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-check-circle text-green-500"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form class="space-y-6" action="{{ route('login') }}" method="POST">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700">Alamat Email</label>
                        <div class="mt-1">
                            <input id="email" name="email" type="email" autocomplete="email" value="{{ old('email') }}"
                                required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-leafly-dark focus:border-leafly-dark sm:text-sm @error('email') border-red-500 @enderror">
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                        <div class="mt-1">
                            <input id="password" name="password" type="password" required
                                class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-leafly-dark focus:border-leafly-dark sm:text-sm @error('password') border-red-500 @enderror">
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox"
                                class="h-4 w-4 text-leafly-dark focus:ring-leafly-dark border-gray-300 rounded">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-900">Ingat saya</label>
                        </div>
                        <div class="text-sm">
                            <a href="{{ route('password.request') }}"
                                class="font-medium text-leafly-dark hover:text-leafly-gold">
                                Lupa kata sandi?
                            </a>
                        </div>
                    </div>

                    <div>
                        <button type="submit"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-bold text-white bg-leafly-dark hover:bg-leafly-green hover:text-leafly-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-leafly-dark transition duration-300 transform hover:-translate-y-1">
                            Masuk
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
