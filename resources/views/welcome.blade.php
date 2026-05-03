<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SewaIn - Beranda</title>
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (Vite) -->
    @vite('resources/css/app.css')
    
    <!-- Alpine.js untuk interaktivitas navbar mobile/dropdown -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm sticky top-0 z-50" x-data="{ mobileMenuOpen: false, profileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-2">
                        <div class="w-10 h-10 bg-brand-500 rounded-xl flex items-center justify-center shadow-lg">
                            <i data-lucide="layers" class="text-white w-5 h-5"></i>
                        </div>
                        <span class="text-2xl font-bold text-brand-700 tracking-tighter">SewaIn.</span>
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="text-slate-600 hover:text-brand-500 font-medium transition-colors">Beranda</a>
                    <a href="#" class="text-slate-600 hover:text-brand-500 font-medium transition-colors">Katalog Alat</a>
                    <a href="#" class="text-slate-600 hover:text-brand-500 font-medium transition-colors">Tentang Kami</a>
                    <a href="#" class="text-slate-600 hover:text-brand-500 font-medium transition-colors">Kontak</a>
                </div>

                <!-- Auth Buttons / Profile Dropdown -->
                <div class="hidden md:flex items-center space-x-4">
                    @guest
                        <a href="{{ route('login') }}" class="text-slate-600 hover:text-brand-600 font-bold transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-brand-500 hover:bg-brand-600 text-white px-5 py-2.5 rounded-xl font-bold transition-all shadow-lg shadow-brand-500/30">Daftar</a>
                    @endguest

                    @auth
                        <!-- Profile Dropdown -->
                        <div class="relative">
                            <button @click="profileMenuOpen = !profileMenuOpen" @click.outside="profileMenuOpen = false" class="flex items-center gap-3 focus:outline-none">
                                <div class="text-right">
                                    <p class="text-sm font-bold text-slate-800 leading-tight">{{ auth()->user()->nama }}</p>
                                    <p class="text-[10px] font-bold text-brand-500 uppercase tracking-wider">{{ auth()->user()->role }}</p>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold border border-brand-200">
                                    {{ substr(auth()->user()->nama, 0, 1) }}
                                </div>
                                <i data-lucide="chevron-down" class="w-4 h-4 text-slate-400" :class="{'rotate-180': profileMenuOpen}"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="profileMenuOpen" x-transition.opacity class="absolute right-0 mt-3 w-48 bg-white rounded-xl shadow-xl border border-slate-100 py-2 z-50" x-cloak>
                                @if(auth()->user()->role === 'admin')
                                    <a href="{{ url('/admin/dashboard') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-brand-500">Dashboard Admin</a>
                                @elseif(auth()->user()->role === 'owner')
                                    <a href="{{ url('/owner/dashboard') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-brand-500">Dashboard Owner</a>
                                @else
                                    <a href="#" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50 hover:text-brand-500">Profil Saya</a>
                                @endif
                                
                                <div class="border-t border-slate-100 my-1"></div>
                                
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="flex items-center md:hidden">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-slate-500 hover:text-brand-500 focus:outline-none">
                        <i data-lucide="menu" class="w-7 h-7" x-show="!mobileMenuOpen"></i>
                        <i data-lucide="x" class="w-7 h-7" x-show="mobileMenuOpen" x-cloak></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenuOpen" x-collapse class="md:hidden border-t border-slate-100 bg-white" x-cloak>
            <div class="px-4 pt-2 pb-4 space-y-1">
                <a href="#" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50 hover:text-brand-500">Beranda</a>
                <a href="#" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50 hover:text-brand-500">Katalog Alat</a>
                <a href="#" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50 hover:text-brand-500">Tentang Kami</a>
                <a href="#" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50 hover:text-brand-500">Kontak</a>
            </div>
            
            <div class="pt-4 pb-4 border-t border-slate-100">
                @guest
                    <div class="flex flex-col gap-3 px-5">
                        <a href="{{ route('login') }}" class="w-full text-center border-2 border-brand-500 text-brand-600 px-5 py-2.5 rounded-xl font-bold">Masuk</a>
                        <a href="{{ route('register') }}" class="w-full text-center bg-brand-500 text-white px-5 py-2.5 rounded-xl font-bold shadow-lg shadow-brand-500/30">Daftar</a>
                    </div>
                @endguest

                @auth
                    <div class="flex items-center px-5 mb-4">
                        <div class="w-10 h-10 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center font-bold border border-brand-200">
                            {{ substr(auth()->user()->nama, 0, 1) }}
                        </div>
                        <div class="ml-3">
                            <p class="text-base font-bold text-slate-800">{{ auth()->user()->nama }}</p>
                            <p class="text-xs font-bold text-brand-500 uppercase">{{ auth()->user()->role }}</p>
                        </div>
                    </div>
                    <div class="mt-3 px-2 space-y-1">
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ url('/admin/dashboard') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50 hover:text-brand-500">Dashboard Admin</a>
                        @elseif(auth()->user()->role === 'owner')
                            <a href="{{ url('/owner/dashboard') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50 hover:text-brand-500">Dashboard Owner</a>
                        @else
                            <a href="#" class="block px-3 py-2 rounded-lg text-base font-medium text-slate-700 hover:bg-slate-50 hover:text-brand-500">Profil Saya</a>
                        @endif
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-3 py-2 rounded-lg text-base font-medium text-red-600 hover:bg-red-50">Keluar</button>
                        </form>
                    </div>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="text-4xl md:text-6xl font-black text-slate-900 tracking-tight mb-6">
                Sewa Alat Produksi <br class="hidden md:block">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-500 to-[#14B8A6]">Lebih Mudah & Cepat</span>
            </h1>
            <p class="text-lg md:text-xl text-slate-500 max-w-2xl mx-auto mb-10 leading-relaxed">
                Platform terpercaya untuk menyewa berbagai alat produksi berkualitas. Kembangkan bisnismu tanpa harus membeli alat mahal.
            </p>
            @guest
                <a href="{{ route('register') }}" class="inline-block bg-brand-500 hover:bg-brand-600 text-white px-8 py-4 rounded-2xl font-bold text-lg transition-all shadow-xl shadow-brand-500/30 active:scale-95">
                    Mulai Sekarang
                </a>
            @endguest
            @auth
                <p class="text-lg font-medium text-slate-600">Selamat datang kembali, <span class="font-bold text-brand-600">{{ auth()->user()->nama }}</span>!</p>
            @endauth
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
