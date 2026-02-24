@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Dashboard Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <!-- Stat Card 1 -->
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 transition-shadow hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Menunggu Diambil</p>
                    <h3 class="mt-2 text-3xl font-bold text-gray-800">12</h3>
                </div>
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-orange-50 text-2xl text-orange-500 shadow-inner">
                    <i class='bx bx-time-five'></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-sm">
                <span class="flex items-center text-orange-500 font-medium bg-orange-50 px-2 py-0.5 rounded-md">
                    <i class='bx bx-right-arrow-alt mr-1'></i>Hari Ini
                </span>
                <span class="text-gray-400">Pesanan pending</span>
            </div>
        </div>
        
        <!-- Stat Card 2 -->
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 transition-shadow hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Alat Sedang Disewa</p>
                    <h3 class="mt-2 text-3xl font-bold text-gray-800">45</h3>
                </div>
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-2xl text-brand-600 shadow-inner">
                    <i class='bx bx-shopping-bag'></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-sm">
                <span class="flex items-center text-green-500 font-medium bg-green-50 px-2 py-0.5 rounded-md">
                    <i class='bx bx-trending-up mr-1'></i>+5%
                </span>
                <span class="text-gray-400">Dari minggu lalu</span>
            </div>
        </div>

        <!-- Stat Card 3 -->
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 transition-shadow hover:shadow-md border-b-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Belum Dikembalikan</p>
                    <h3 class="mt-2 text-3xl font-bold text-red-600">3</h3>
                </div>
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-red-50 text-2xl text-red-500 shadow-md">
                    <i class='bx bx-error-circle'></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-sm">
                <span class="flex items-center text-red-500 font-medium bg-red-50 px-2 py-0.5 rounded-md">
                    Terlambat
                </span>
                <span class="text-gray-400">Segera tindak lanjuti</span>
            </div>
        </div>

        <!-- Stat Card 4 -->
        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 transition-shadow hover:shadow-md">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total UMKM</p>
                    <h3 class="mt-2 text-3xl font-bold text-gray-800">128</h3>
                </div>
                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-2xl text-blue-500 shadow-inner">
                    <i class='bx bx-group'></i>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2 text-sm">
                <span class="flex items-center text-blue-500 font-medium bg-blue-50 px-2 py-0.5 rounded-md">
                    <i class='bx bx-user-plus mr-1'></i>+12
                </span>
                <span class="text-gray-400">Bulan ini</span>
            </div>
        </div>

    </div>

    <!-- Analytics & Recent Transactions Section -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        
        <!-- Recent Transactions Table (Takes 2 columns) -->
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 shadow-sm ring-1 ring-gray-100">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">Penyewaan Terbaru</h2>
                <a href="#" class="text-sm font-medium text-brand-500 hover:text-brand-600 focus:outline-none">Lihat Semua</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500">
                    <thead class="bg-gray-50/50 text-xs uppercase text-gray-400 border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-4 py-3 font-semibold tracking-wider">ID / Penyewa</th>
                            <th scope="col" class="px-4 py-3 font-semibold tracking-wider">Tanggal Ambil</th>
                            <th scope="col" class="px-4 py-3 font-semibold tracking-wider">Metode</th>
                            <th scope="col" class="px-4 py-3 font-semibold tracking-wider text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900 border-b border-gray-100 pb-0.5 mb-0.5 inline-block">INV-0123</div>
                                <div class="text-xs">RM Salero Kita</div>
                            </td>
                            <td class="px-4 py-3"><i class='bx bx-calendar mr-1 text-gray-400'></i> 24 Feb 2026</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1 rounded bg-gray-100 px-2 py-1 text-xs font-semibold text-gray-600">
                                    <i class='bx bx-store'></i> Ambil Sendiri
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <span class="inline-block rounded-full bg-orange-100 px-2.5 py-0.5 text-xs font-medium text-orange-600">
                                    Menunggu Diambil
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900 border-b border-gray-100 pb-0.5 mb-0.5 inline-block">INV-0124</div>
                                <div class="text-xs">Kafe Senja</div>
                            </td>
                            <td class="px-4 py-3"><i class='bx bx-calendar mr-1 text-gray-400'></i> 25 Feb 2026</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1 rounded bg-blue-50 px-2 py-1 text-xs font-semibold text-blue-600">
                                    <i class='bx bx-truck'></i> Kirim via Kurir
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <span class="inline-block rounded-full bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-600">
                                    Disewa
                                </span>
                            </td>
                        </tr>
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-4 py-3">
                                <div class="font-medium text-gray-900 border-b border-gray-100 pb-0.5 mb-0.5 inline-block">INV-0119</div>
                                <div class="text-xs">Warteg Bahari</div>
                            </td>
                            <td class="px-4 py-3"><i class='bx bx-calendar mr-1 text-gray-400'></i> 18 Feb 2026</td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1 rounded bg-gray-100 px-2 py-1 text-xs font-semibold text-gray-600">
                                    <i class='bx bx-store'></i> Ambil Sendiri
                                </span>
                            </td>
                            <td class="px-4 py-3 text-right">
                                <span class="inline-block rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-600">
                                    Terlambat
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Stock Analytics (Takes 1 column) -->
        <div class="bg-brand-500 rounded-3xl p-6 shadow-sm ring-1 ring-brand-600 text-white flex flex-col justify-between relative overflow-hidden">
            <!-- Background element -->
            <i class='bx bx-archive-in absolute -right-6 -bottom-6 text-[150px] opacity-10'></i>
            
            <div class="relative z-10">
                <h2 class="text-xl font-bold mb-1">Status Alat Produksi</h2>
                <p class="text-brand-200 text-sm mb-6">Ringkasan kondisi inventaris</p>

                <div class="space-y-4">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-medium">Tersedia Digudang</span>
                            <span class="text-lg font-bold">120 <span class="text-xs font-normal">unit</span></span>
                        </div>
                        <div class="w-full bg-brand-600 rounded-full h-1.5 mt-2">
                            <div class="bg-white h-1.5 rounded-full" style="width: 70%"></div>
                        </div>
                    </div>

                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm font-medium">Sedang Disewa</span>
                            <span class="text-lg font-bold">45 <span class="text-xs font-normal">unit</span></span>
                        </div>
                        <div class="w-full bg-brand-600 rounded-full h-1.5 mt-2">
                            <div class="bg-[#f9db72] h-1.5 rounded-full" style="width: 25%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <button class="relative z-10 w-full mt-6 bg-white text-brand-600 rounded-xl py-3 font-semibold text-sm hover:bg-brand-50 transition-colors focus:outline-none shadow-sm">
                Lihat Detail Inventaris
            </button>
        </div>

    </div>
@endsection
