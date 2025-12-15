<nav id="navbar"
    class="fixed top-0 w-full z-50 transition-all duration-300 py-4 px-6 sm:px-12 bg-leafly-dark/90 backdrop-blur-md shadow-sm">
    <div class="max-w-7xl mx-auto flex justify-between items-center">

        <a href="{{ url('/') }}" class="flex items-center gap-2 text-white no-underline group">
            <div
                class="w-10 h-10 bg-leafly-green rounded-full flex items-center justify-center text-xl shadow-lg group-hover:scale-110 transition-transform text-leafly-dark">
                <i class="fa-solid fa-leaf"></i>
            </div>
            <span class="text-2xl font-bold tracking-wide">
                Leafly<span class="text-leafly-green">.id</span>
            </span>
        </a>

        <div class="hidden md:flex items-center space-x-8">
            <a href="{{ url('/') }}" class="text-white hover:text-leafly-green transition font-medium">Home</a>
            <a href="{{ request()->is('/') ? '#about' : url('/#about') }}"
                class="text-white hover:text-leafly-green transition font-medium">Tentang</a>
            <a href="{{ route('products.index') }}"
                class="text-white hover:text-leafly-green transition font-medium">Produk</a>

            <a href="{{ route('cart.index') }}" class="text-white hover:text-leafly-green transition mr-4 relative">
                <i class="fa-solid fa-cart-shopping text-xl"></i>
                <span id="cart-count"
                    class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-4 h-4 flex items-center justify-center hidden">
                </span>
            </a>

            @guest
                <a href="{{ route('register') }}"
                    class="bg-leafly-gold text-leafly-dark px-6 py-2 rounded-full font-bold hover:bg-leafly-green transition shadow-lg transform hover:-translate-y-1">
                    Daftar
                </a>
                <a href="{{ route('login') }}" class="rounded-full block text-xl text-white hover:text-leafly-green">
                    <i class="fa-solid fa-user mr-2"></i>
                </a>
            @else
                <!-- USER DROPDOWN -->
                <div class="relative group">

                    <!-- trigger -->
                    <button
                        class="flex items-center gap-2 text-white hover:text-leafly-gold font-medium focus:outline-none">
                        <i class="fa-regular fa-user-circle text-xl"></i>
                        <span>{{ Auth::user()->name }}</span>
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </button>

                    <!-- dropdown (FIXED) -->
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-xl py-2
                                               border border-gray-100 z-50
                                               opacity-0 invisible
                                               group-hover:opacity-100 group-hover:visible
                                               transition-all duration-200">

                        <a href="{{ route('profile.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-leafly-dark">
                            <i class="fa-solid fa-user mr-2"></i> Profil Saya
                        </a>

                        <a href="{{ route('orders.index') }}"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-green-50 hover:text-leafly-dark">
                            <i class="fa-solid fa-clock-rotate-left mr-2"></i> Riwayat Belanja
                        </a>

                        <div class="border-t border-gray-100 my-1"></div>

                        <!-- logout -->
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium">
                                <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>

        <!-- mobile toggle -->
        <button id="menuToggle" class="md:hidden text-white text-2xl focus:outline-none">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>
</nav>

@push('scripts')
    <script>
        $(document).ready(function () {
            $.get("{{ route('cart.count') }}", function (res) {
                if (res.count > 0) {
                    $('#cart-count')
                        .text(res.count)
                        .removeClass('hidden');
                } else {
                    $('#cart-count').addClass('hidden');
                }
            });
        });
    </script>
@endpush
