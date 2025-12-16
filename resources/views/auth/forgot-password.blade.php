@extends('layouts.app')

@section('title', 'Lupa Kata Sandi - Leafly')

@section('content')
    <div class="min-h-[85vh] mt-[3rem] flex flex-col justify-center py-12 sm:px-6 lg:px-8 bg-leafly-cream">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <h2 class="text-center text-3xl font-extrabold text-leafly-dark">
                Lupa Kata Sandi
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Masukkan email yang terdaftar untuk menerima link reset password.
            </p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="bg-white py-8 px-4 shadow-xl sm:rounded-lg sm:px-10 border-t-4 border-leafly-gold">

                @if(session('success'))
                    <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 text-sm text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 bg-red-50 border-l-4 border-red-500 p-4 text-sm text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" required
                            class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-leafly-dark focus:border-leafly-dark">
                    </div>

                    <button type="submit"
                        class="w-full py-2 px-4 rounded-md font-bold text-white bg-leafly-dark hover:bg-leafly-green hover:text-leafly-dark transition">
                        Kirim Link Reset
                    </button>
                </form>

                <p class="mt-4 text-center text-sm">
                    <a href="{{ route('login') }}" class="font-bold text-leafly-dark hover:text-leafly-gold">
                        Kembali ke Login
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
