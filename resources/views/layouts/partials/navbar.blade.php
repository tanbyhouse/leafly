{{-- <nav id="navbar"
    class="fixed top-0 w-full z-50 transition-all duration-300 py-4 px-6 sm:px-12 bg-leafly-dark/90 backdrop-blur-md shadow-sm">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <a href="{{ url('/') }}" class="flex items-center gap-2 text-white no-underline group">
            <div
                class="w-10 h-10 bg-leafly-green rounded-full flex items-center justify-center text-xl shadow-lg group-hover:scale-110 transition-transform text-leafly-dark">
                <i class="fa-solid fa-leaf"></i>
            </div>
            <span class="text-2xl font-bold tracking-wide">Leafly<span class="text-leafly-green">.id</span></span>
        </a>

        <div class="hidden md:flex items-center space-x-8">
            <a href="{{ url('/') }}" class="text-white hover:text-leafly-green transition font-medium">Home</a>
            <a href="#about" class="text-white hover:text-leafly-green transition font-medium">Tentang</a>
            <a href="{{ route('products.index') }}"
                class="text-white hover:text-leafly-green transition font-medium">Produk</a>

            <a href="{{ route('cart.index') }}" class="text-white hover:text-leafly-green transition mr-4 relative">
                <i class="fa-solid fa-cart-shopping text-xl"></i>
                <span
                    class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-4 h-4 flex items-center justify-center">2</span>
            </a>
            @guest
                <a href="{{ route('login') }}" class="text-white hover:text-leafly-gold font-medium mr-2">Masuk</a>
                <a href="{{ route('register') }}" class="bg-leafly-gold text-leafly-dark px-6 py-2 rounded-full font-bold hover:bg-yellow-400 transition shadow-lg transform hover:-translate-y-1">
                    Daftar
                </a>
            @else
                <span class="text-white">Hi, {{ Auth::user()->name }}</span>
            @endguest
        </div>

        <!-- mobile navbar -->
        <button id="menuToggle" class="md:hidden text-white text-2xl focus:outline-none">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>

    <!-- dropdown responsif -->
    <div id="mobileMenu" class="absolute top-full left-0 w-full bg-leafly-dark border-t border-white/10 shadow-xl p-6 flex flex-col space-y-4 md:hidden text-center">
        <a href="{{ url('/') }}" class="block text-white hover:text-leafly-green">Home</a>
        <a href="#about" class="block text-white hover:text-leafly-green">Tentang</a>
        <a href="{{ route('products.index') }}" class="block text-white hover:text-leafly-green">Produk</a>
<<<<<<< Updated upstream
        <a href="{{ route('login') }}" class="block text-leafly-gold font-bold">Masuk / Daftar</a>
=======

        @guest
            <a href="{{ route('login') }}" class="block text-leafly-gold font-bold">Masuk / Daftar</a>
        @else
            <div class="border-t border-white/20 pt-4 mt-2">
                <span class="block text-gray-400 text-sm mb-2">Halo, {{ Auth::user()->name }}</span>
                <a href="{{ route('profile.index') }}" class="block text-white hover:text-leafly-green py-2">Profil Saya</a>
                <a href="{{ route('orders.index') }}" class="block text-white hover:text-leafly-green py-2">Riwayat Belanja</a>

                <!-- logout -->
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="block w-full text-red-400 font-bold py-2 hover:text-red-300">
                        Keluar
                    </button>
                </form>
            </div>
        @endguest
>>>>>>> Stashed changes
    </div>
</nav> --}}



<nav id="navbar"
    class="fixed top-0 w-full z-50 transition-all duration-300 py-4 px-6 sm:px-12 bg-leafly-dark/90 backdrop-blur-md shadow-sm">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <a href="{{ url('/') }}" class="flex items-center gap-2 text-white no-underline group">
            <div
                class="w-10 h-10 bg-leafly-green rounded-full flex items-center justify-center text-xl shadow-lg group-hover:scale-110 transition-transform text-leafly-dark">
                <i class="fa-solid fa-leaf"></i>
            </div>
            <span class="text-2xl font-bold tracking-wide">Leafly<span class="text-leafly-green">.id</span></span>
        </a>

        <div class="hidden md:flex items-center space-x-8">
            <a href="{{ url('/') }}" class="text-white hover:text-leafly-green transition font-medium">Home</a>
            <a href="#about" class="text-white hover:text-leafly-green transition font-medium">Tentang</a>
            <a href="{{ route('products.index') }}"
                class="text-white hover:text-leafly-green transition font-medium">Produk</a>

            @auth
                <a href="{{ route('cart.index') }}" class="text-white hover:text-leafly-green transition mr-4 relative">
                    <i class="fa-solid fa-cart-shopping text-xl"></i>
                    <span id="cart-count"
                        class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center">0</span>
                </a>

                <!-- User Dropdown -->
                <div class="relative group">
                    <button class="text-white hover:text-leafly-green flex items-center gap-2 font-medium">
                        <i class="fa-solid fa-user-circle text-xl"></i>
                        <span>{{ Auth::user()->pelanggan->nama ?? Auth::user()->email }}</span>
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </button>

                    <div
                        class="hidden group-hover:block absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
                        @if(Auth::user()->tipe_user === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                <i class="fa-solid fa-dashboard mr-2"></i> Dashboard Admin
                            </a>
                        @elseif(Auth::user()->tipe_user === 'karyawan')
                            <a href="{{ route('karyawan.dashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                <i class="fa-solid fa-dashboard mr-2"></i> Dashboard Karyawan
                            </a>
                        @else
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                <i class="fa-solid fa-user mr-2"></i> Profile
                            </a>
                            <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                                <i class="fa-solid fa-box mr-2"></i> Pesanan Saya
                            </a>
                        @endif
                        <hr class="my-2">
                        <form action="{{ route('logout') }}" method="POST" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                <i class="fa-solid fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
            <a href="{{ route('cart.index') }}" class="text-white hover:text-leafly-green transition mr-4 relative">
                <i class="fa-solid fa-cart-shopping text-xl"></i>
            </a>
            <a href="{{ route('login') }}" class="text-white hover:text-leafly-gold font-medium mr-2">Masuk</a>
            <a href="{{ route('register') }}"
                class="bg-leafly-gold text-leafly-dark px-6 py-2 rounded-full font-bold hover:bg-yellow-400 transition shadow-lg transform hover:-translate-y-1">
                Daftar
            </a>
            @endguest
        </div>

        <!-- mobile navbar -->
        <button id="menuToggle" class="md:hidden text-white text-2xl focus:outline-none">
            <i class="fa-solid fa-bars"></i>
        </button>
    </div>

    <!-- dropdown responsif -->
    <div id="mobileMenu"
        class="hidden absolute top-full left-0 w-full bg-leafly-dark border-t border-white/10 shadow-xl p-6 flex-col space-y-4 md:hidden text-center">
        <a href="{{ url('/') }}" class="block text-white hover:text-leafly-green">Home</a>
        <a href="#about" class="block text-white hover:text-leafly-green">Tentang</a>
        <a href="{{ route('products.index') }}" class="block text-white hover:text-leafly-green">Produk</a>

        @auth
            <a href="{{ route('cart.index') }}" class="block text-white hover:text-leafly-green">
                <i class="fa-solid fa-cart-shopping mr-2"></i> Keranjang
            </a>

            @if(Auth::user()->tipe_user === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="block text-leafly-gold font-bold">Dashboard Admin</a>
            @elseif(Auth::user()->tipe_user === 'karyawan')
                <a href="{{ route('karyawan.dashboard') }}" class="block text-leafly-gold font-bold">Dashboard Karyawan</a>
            @else
                <a href="#" class="block text-white hover:text-leafly-green">Profile</a>
                <a href="#" class="block text-white hover:text-leafly-green">Pesanan Saya</a>
            @endif

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full text-center text-red-400 font-bold hover:text-red-300">Logout</button>
            </form>
        @else
        <a href="{{ route('login') }}" class="block text-leafly-gold font-bold">Masuk / Daftar</a>
        @endguest
    </div>
</nav>

@auth
    @push('scripts')
        <script>
            // Update cart count on page load
            function updateCartCount() {
                fetch('{{ route("cart.count") }}')
                    .then(res => res.json())
                    .then(data => {
                        const countElement = document.getElementById('cart-count');
                        if (countElement) {
                            countElement.textContent = data.count;
                            if (data.count > 0) {
                                countElement.classList.remove('hidden');
                            } else {
                                countElement.classList.add('hidden');
                            }
                        }
                    })
                    .catch(err => console.error('Error fetching cart count:', err));
            }

            // Mobile menu toggle
            document.getElementById('menuToggle').addEventListener('click', function () {
                const mobileMenu = document.getElementById('mobileMenu');
                mobileMenu.classList.toggle('hidden');
                mobileMenu.classList.toggle('flex');
            });

            // Call on page load
            updateCartCount();

            // Update every 30 seconds
            setInterval(updateCartCount, 30000);
        </script>
    @endpush
@endauth
