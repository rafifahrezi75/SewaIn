<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard')</title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            200: '#99f6e4', // Light teal for small text
                            400: '#2dd4bf', // Lighter teal
                            500: '#14b8a6', // Main teal (user requested)
                            600: '#0d9488', // Hover teal
                            700: '#0f766e', // Dark teal
                        }
                    }
                }
            }
        }
    </script>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body class="bg-[#f8f9fa] font-sans text-gray-800 antialiased" x-data="{ sidebarOpen: true }">

    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar -->
        <aside 
            class="fixed inset-y-0 left-0 z-50 flex flex-col bg-brand-500 text-white transition-all duration-300 ease-in-out md:static md:block shrink-0 shadow-xl"
            :class="sidebarOpen ? 'w-64 translate-x-0' : '-translate-x-full md:translate-x-0 md:w-20'">
            
            <!-- Sidebar Header -->
            <div class="flex h-[72px] items-center justify-center px-4 shrink-0 font-bold tracking-wider">
                <!-- Full Logo -->
                <h1 x-show="sidebarOpen" class="text-2xl w-full text-center" x-transition.opacity>Admin</h1>
                <!-- Mini Logo -->
                <h1 x-show="!sidebarOpen" class="text-2xl hidden md:block" x-cloak>A</h1>
            </div>

            <!-- Sidebar Nav -->
            <nav class="flex-1 space-y-2 overflow-y-auto px-3 py-4 scrollbar-hide">
                
                <!-- Sidebar Links -->
                <a href="{{ url('admin/dashboard') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 font-medium transition-all focus:outline-none {{ request()->is('admin/dashboard') ? 'bg-white text-brand-700 shadow-sm' : 'text-white hover:bg-brand-600 focus:bg-brand-600' }}" :class="sidebarOpen ? 'justify-start' : 'md:justify-center px-0'">
                    <i class="bx bx-grid-alt text-xl shrink-0 {{ request()->is('admin/dashboard') ? '' : 'opacity-80' }}"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Dashboard</span>
                    @if(request()->is('admin/dashboard'))
                    <div x-show="sidebarOpen" class="ml-auto flex h-2 w-2 shrink-0 rounded-full bg-brand-500"></div>
                    @endif
                </a>

                <a href="{{ url('admin/kategori') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 font-medium transition-all focus:outline-none {{ request()->is('admin/kategori') ? 'bg-white text-brand-700 shadow-sm' : 'text-white hover:bg-brand-600 focus:bg-brand-600' }}" :class="sidebarOpen ? 'justify-start' : 'md:justify-center px-0'">
                    <i class="bx bx-layer text-xl shrink-0 {{ request()->is('admin/kategori') ? '' : 'opacity-80' }}"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Kategori</span>
                    @if(request()->is('admin/kategori'))
                    <div x-show="sidebarOpen" class="ml-auto flex h-2 w-2 shrink-0 rounded-full bg-brand-500"></div>
                    @endif
                </a>

                <a href="{{ url('admin/alat') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 font-medium transition-all focus:outline-none {{ request()->is('admin/alat') ? 'bg-white text-brand-700 shadow-sm' : 'text-white hover:bg-brand-600 focus:bg-brand-600' }}" :class="sidebarOpen ? 'justify-start' : 'md:justify-center px-0'">
                    <i class="bx bx-wrench text-xl shrink-0 {{ request()->is('admin/alat') ? '' : 'opacity-80' }}"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Alat Produksi</span>
                    @if(request()->is('admin/alat'))
                    <div x-show="sidebarOpen" class="ml-auto flex h-2 w-2 shrink-0 rounded-full bg-brand-500"></div>
                    @endif
                </a>

                <a href="{{ url('admin/transaksi') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 font-medium transition-all focus:outline-none {{ request()->is('admin/transaksi') ? 'bg-white text-brand-700 shadow-sm' : 'text-white hover:bg-brand-600 focus:bg-brand-600' }}" :class="sidebarOpen ? 'justify-start' : 'md:justify-center px-0'">
                    <i class="bx bx-shopping-bag text-xl shrink-0 {{ request()->is('admin/transaksi') ? '' : 'opacity-80' }}"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Daftar Transaksi</span>
                    @if(request()->is('admin/transaksi'))
                    <div x-show="sidebarOpen" class="ml-auto flex h-2 w-2 shrink-0 rounded-full bg-brand-500"></div>
                    @endif
                </a>

                <a href="{{ url('admin/pengembalian') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 font-medium transition-all focus:outline-none {{ request()->is('admin/pengembalian') ? 'bg-white text-brand-700 shadow-sm' : 'text-white hover:bg-brand-600 focus:bg-brand-600' }}" :class="sidebarOpen ? 'justify-start' : 'md:justify-center px-0'">
                    <i class="bx bx-archive-in text-xl shrink-0 {{ request()->is('admin/pengembalian') ? '' : 'opacity-80' }}"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Pengembalian</span>
                    @if(request()->is('admin/pengembalian'))
                    <div x-show="sidebarOpen" class="ml-auto flex h-2 w-2 shrink-0 rounded-full bg-brand-500"></div>
                    @endif
                </a>

                <a href="{{ url('admin/pelanggan') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 font-medium transition-all focus:outline-none {{ request()->is('admin/pelanggan') ? 'bg-white text-brand-700 shadow-sm' : 'text-white hover:bg-brand-600 focus:bg-brand-600' }}" :class="sidebarOpen ? 'justify-start' : 'md:justify-center px-0'">
                    <i class="bx bx-group text-xl shrink-0 {{ request()->is('admin/pelanggan') ? '' : 'opacity-80' }}"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Pelanggan UMKM</span>
                    @if(request()->is('admin/pelanggan'))
                    <div x-show="sidebarOpen" class="ml-auto flex h-2 w-2 shrink-0 rounded-full bg-brand-500"></div>
                    @endif
                </a>

                <a href="{{ url('admin/pengaturan') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 font-medium transition-all focus:outline-none {{ request()->is('admin/pengaturan') ? 'bg-white text-brand-700 shadow-sm' : 'text-white hover:bg-brand-600 focus:bg-brand-600' }}" :class="sidebarOpen ? 'justify-start' : 'md:justify-center px-0'">
                    <i class="bx bx-cog text-xl shrink-0 {{ request()->is('admin/pengaturan') ? '' : 'opacity-80' }}"></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Pengaturan Sistem</span>
                    @if(request()->is('admin/pengaturan'))
                    <div x-show="sidebarOpen" class="ml-auto flex h-2 w-2 shrink-0 rounded-full bg-brand-500"></div>
                    @endif
                </a>
            </nav>

            <!-- Sidebar Footer -->
            <div class="p-4" :class="sidebarOpen ? '' : 'md:px-2'">
                <a href="#" class="flex items-center gap-3 rounded-xl px-4 py-3 font-medium text-white transition-all hover:bg-brand-600 focus:outline-none" :class="sidebarOpen ? 'justify-start' : 'md:justify-center px-0'">
                    <i class='bx bx-log-out text-xl shrink-0 opacity-80'></i>
                    <span x-show="sidebarOpen" class="whitespace-nowrap">Logout</span>
                </a>
            </div>
        </aside>

        <!-- Main Wrapper -->
        <div class="flex flex-1 flex-col overflow-hidden transition-all duration-300">
            
            <!-- Navbar -->
            <header class="flex h-[72px] items-center justify-between bg-brand-500 px-6 shrink-0 shadow-sm border-b border-brand-600/30">
                <div class="flex items-center gap-4">
                    <!-- Hamburger Toggle -->
                    <button @click="sidebarOpen = !sidebarOpen" class="text-white hover:bg-brand-600 rounded-lg p-2 transition focus:outline-none">
                        <i class='bx bx-menu text-2xl'></i>
                    </button>
                    <!-- Current Page Title -->
                    <span class="text-lg font-medium text-white hidden sm:block capitalize">
                        {{ request()->segment(2) ? str_replace('-', ' ', request()->segment(2)) : 'Dashboard' }}
                    </span>
                </div>

                <!-- Right Side Topbar -->
                <div class="flex items-center gap-3 sm:gap-5 text-white">
                    <button class="relative rounded-lg p-2 hover:bg-brand-600 transition focus:outline-none">
                        <i class='bx bx-bell text-xl'></i>
                        <span class="absolute right-1.5 top-1.5 flex h-2.5 w-2.5 items-center justify-center rounded-full bg-[#f9db72] border-2 border-brand-500"></span>
                    </button>
                    
                    <div class="flex items-center gap-3 pl-3 sm:pl-5 relative before:absolute before:left-0 before:top-1/2 before:-translate-y-1/2 before:h-8 before:w-px before:bg-brand-400">
                        <div class="hidden sm:flex flex-col text-right justify-center">
                            <span class="text-sm font-semibold leading-tight">Eriko</span>
                            <span class="text-[10px] text-brand-400 font-medium mt-0.5 uppercase tracking-wider">ADMIN</span>
                        </div>
                        <button class="h-9 w-9 overflow-hidden rounded-full bg-white/10 hover:bg-white/20 border border-white/20 transition flex items-center justify-center focus:outline-none">
                            <!-- Could be image -->
                            <i class='bx bx-user text-xl text-white'></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto w-full">
                <!-- Inner padding wrapper -->
                <div class="mx-auto w-full p-6">
                    @yield('content')
                </div>
            </main>

            <!-- Footer -->
            <footer class="bg-[#f8f9fa] px-6 py-4 text-center sm:text-right text-[13px] text-gray-400 font-medium shrink-0">
                &copy; {{ date('Y') }} Admin Dashboard. All rights reserved.
            </footer>
        </div>
        
        <!-- Overlay on mobile to close sidebar -->
        <div 
            x-show="sidebarOpen" 
            @click="sidebarOpen = false" 
            class="fixed inset-0 z-40 bg-brand-700/50 backdrop-blur-sm transition-opacity md:hidden" 
            x-transition.opacity>
        </div>

    </div>

</body>
</html>
