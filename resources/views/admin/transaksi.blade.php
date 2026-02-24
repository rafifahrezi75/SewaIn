@extends('layouts.admin')

@section('title', 'Transaksi')

@section('content')
<div>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Transaksi</h2>
        
        <div class="flex items-center gap-3">
            <div class="relative">
                <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg'></i>
                <input type="text" placeholder="Cari invoice atau UMKM..." class="pl-10 pr-4 py-2 w-full sm:w-64 rounded-xl border border-gray-200 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors">
            </div>
            
            <button class="flex shrink-0 items-center gap-2 rounded-xl bg-white border border-gray-200 px-4 py-2 text-sm font-medium text-gray-700 transition-all hover:bg-gray-50 focus:outline-none shadow-sm">
                <i class='bx bx-filter-alt text-lg'></i>
                <span class="hidden sm:inline">Filter</span>
            </button>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left text-sm text-gray-500">
                <thead class="bg-gray-50/50 text-xs uppercase text-gray-400 border-b border-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Invoice & UMKM</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Item Disewa</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Tgl Sewa</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Metode</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Total</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <!-- Data dummy 1 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="block font-medium text-gray-900 border-b border-gray-100 pb-1 mb-1">INV-0123</span>
                            <span class="text-xs text-gray-500">RM Salero Kita</span>
                        </td>
                        <td class="px-6 py-4 text-xs">
                            <div class="font-medium text-gray-700">2x Mesin Press Cup</div>
                            <div class="text-gray-400">+1 Item lainnya</div>
                        </td>
                        <td class="px-6 py-4 text-xs">
                            <span class="block"><i class='bx bx-calendar mr-1'></i>24 - 26 Feb 26</span>
                            <span class="block text-gray-400 mt-1">(3 Hari)</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 rounded bg-gray-100 px-2 py-1 text-[10px] font-semibold text-gray-600 uppercase">
                                <i class='bx bx-store'></i> Ambil Sendiri
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">
                            Rp 450.000
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 rounded-full bg-orange-100 px-2.5 py-1 text-xs font-semibold text-orange-600">
                                Menunggu Diambil
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button class="rounded-lg bg-brand-50 text-brand-600 px-3 py-1.5 text-xs font-medium hover:bg-brand-100 transition-colors focus:outline-none">
                                Verifikasi Serah Terima
                            </button>
                        </td>
                    </tr>
                    
                    <!-- Data dummy 2 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="block font-medium text-gray-900 border-b border-gray-100 pb-1 mb-1">INV-0124</span>
                            <span class="text-xs text-gray-500">Kafe Senja</span>
                        </td>
                        <td class="px-6 py-4 text-xs">
                            <div class="font-medium text-gray-700">1x Tenda 3x3m</div>
                            <div class="font-medium text-gray-700">5x Kursi Lipat</div>
                        </td>
                        <td class="px-6 py-4 text-xs">
                            <span class="block"><i class='bx bx-calendar mr-1'></i>25 - 28 Feb 26</span>
                            <span class="block text-gray-400 mt-1">(4 Hari)</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 rounded bg-blue-50 px-2 py-1 text-[10px] font-semibold text-blue-600 uppercase">
                                <i class='bx bx-truck'></i> Kirim via Kurir
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">
                            Rp 650.000 <span class="text-[10px] items-center text-gray-500 block font-normal">(inc. Ongkir)</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-600">
                                Sedang Disewa
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button class="rounded-lg bg-gray-50 text-gray-600 px-3 py-1.5 text-xs font-medium hover:bg-gray-100 transition-colors focus:outline-none border border-gray-200">
                                Detail
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="bg-gray-50/50 p-4 sm:flex sm:items-center sm:justify-between border-t border-gray-100 rounded-b-2xl">
            <p class="text-sm text-gray-500">Menampilkan <span class="font-medium text-gray-700">1</span> sampai <span class="font-medium text-gray-700">2</span> dari <span class="font-medium text-gray-700">45</span> transaksi</p>
            <div class="mt-4 sm:mt-0 flex gap-2">
                <button class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed focus:outline-none" disabled>Prev</button>
                <button class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">Next</button>
            </div>
        </div>
    </div>
</div>
@endsection
