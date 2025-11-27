<nav id="navbar" class="fixed top-0 w-full z-50 transition-all duration-300 py-4 px-6 sm:px-12 bg-leafly-dark/90 backdrop-blur-md shadow-sm">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <a href="{{ url('/') }}" class="flex items-center gap-2 text-white no-underline group">
            <div class="w-10 h-10 bg-leafly-green rounded-full flex items-center justify-center text-xl shadow-lg group-hover:scale-110 transition-transform text-leafly-dark">
                <i class="fa-solid fa-leaf"></i>
            </div>
            <span class="text-2xl font-bold tracking-wide">Leafly<span class="text-leafly-green">.id</span></span>
        </a>
        
        <div class="hidden md:flex items-center space-x-8">
            <a href="{{ url('/') }}" class="text-white hover:text-leafly-green transition font-medium">Home</a>
            <a href="#about" class="text-white hover:text-leafly-green transition font-medium">Tentang</a>
            <a href="{{ route('products.index') }}" class="text-white hover:text-leafly-green transition font-medium">Produk</a>
                        
            <a href="{{ route('cart.index') }}" class="text-white hover:text-leafly-green transition mr-4 relative">
                <i class="fa-solid fa-cart-shopping text-xl"></i>
                <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-4 h-4 flex items-center justify-center">2</span>
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
        <a href="{{ route('login') }}" class="block text-leafly-gold font-bold">Masuk / Daftar</a>
    </div>
</nav>