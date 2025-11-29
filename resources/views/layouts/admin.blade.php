<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - Leafly')</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        leafly: {
                            dark: '#225D2D',
                            green: '#BADD7F',
                            gold: '#E5BC5F',
                            cream: '#F7EFDA',
                        }
                    },
                    fontFamily: { sans: ['Poppins', 'sans-serif'] }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style> body { font-family: 'Onest', sans-serif; } </style>
</head>
<body class="bg-gray-100 text-gray-800">

    <div class="flex h-screen overflow-hidden">
        
        <!-- sidebar -->
        <aside class="w-64 bg-leafly-dark text-white flex flex-col shadow-xl fixed md:relative z-30 transition-all duration-300 transform -translate-x-full md:translate-x-0 h-full" id="sidebar">
            
            <div class="h-16 flex items-center justify-center border-b border-white/10 bg-leafly-dark/50">
                <a href="{{ url('/') }}" class="flex items-center gap-2 text-white no-underline group">
                    <div class="w-10 h-10 bg-leafly-green rounded-full flex items-center justify-center text-xl shadow-lg group-hover:scale-110 transition-transform text-leafly-dark">
                        <i class="fa-solid fa-leaf"></i>
                    </div>
                    <span class="text-2xl font-bold tracking-wide">Leafly<span class="text-leafly-green">.id</span></span>
                </a>
            </div>

            <!-- menu items -->
            <nav class="grow p-4 space-y-2 overflow-y-auto custom-scrollbar">
                
                <p class="px-4 text-xs font-bold text-gray-400 uppercase mt-2 mb-2">Utama</p>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition {{ request()->routeIs('admin.dashboard') ? 'bg-leafly-gold text-leafly-dark font-bold' : '' }}">
                    <i class="fa-solid fa-gauge w-5 text-center"></i> Dashboard
                </a>

                <p class="px-4 text-xs font-bold text-gray-400 uppercase mt-4 mb-2">Manajemen</p>

                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
                    <i class="fa-solid fa-users w-5 text-center"></i> Pengguna
                </a>

                <div class="relative">
                    <button class="w-full flex justify-between items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition text-left" onclick="$('#submenu-produk').slideToggle()">
                        <div class="flex items-center gap-3">
                            <i class="fa-solid fa-box-open w-5 text-center"></i> Produk
                        </div>
                        <i class="fa-solid fa-chevron-down text-xs"></i>
                    </button>
                    <div id="submenu-produk" class="hidden pl-4 mt-1 space-y-1">
                        <a href="{{ route('admin.products.index') }}" class="block px-4 py-2 text-sm hover:text-leafly-gold rounded-lg">Daftar Produk</a>
                        <a href="{{ route('admin.busuk.index') }}" class="block px-4 py-2 text-sm hover:text-red-400 rounded-lg text-red-200">Produk Busuk</a>
                    </div>
                </div>

                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
                    <i class="fa-solid fa-file-invoice-dollar w-5 text-center"></i> Transaksi
                </a>

                <p class="px-4 text-xs font-bold text-gray-400 uppercase mt-4 mb-2">Lainnya</p>

                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
                    <i class="fa-solid fa-chart-line w-5 text-center"></i> Laporan
                </a>
                <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 transition">
                    <i class="fa-solid fa-comments w-5 text-center"></i> Chat
                </a>
            </nav>

            <!-- footer sidebar -->
            <div class="p-4 border-t border-white/10">
                <a href="{{ url('/') }}" class="flex items-center gap-2 text-sm text-gray-300 hover:text-white transition">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i> Keluar / Ke Website
                </a>
            </div>
        </aside>

        <!-- content wrap -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden bg-gray-50">
            
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6 z-20">
                <button id="sidebarToggle" class="md:hidden text-gray-600 text-xl">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <h2 class="text-lg font-bold text-leafly-dark hidden md:block">@yield('header', 'Dashboard')</h2>

                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/avatar.jpg') }}" class="w-8 h-8 rounded-full border border-gray-200">
                        <span class="text-sm font-bold text-gray-700">Admin</span>
                    </div>
                </div>
            </header>

            <!-- content scrollable -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
                @yield('content')
            </main>
        </div>

        <!-- sidebar overlay -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-20 hidden md:hidden"></div>
    </div>

    <script>
        $(document).ready(function() {
            // Toggle Sidebar Mobile
            $('#sidebarToggle, #sidebarOverlay').click(function() {
                $('#sidebar').toggleClass('-translate-x-full');
                $('#sidebarOverlay').toggleClass('hidden');
            });
        });
    </script>
    @stack('scripts')
</body>
</html>