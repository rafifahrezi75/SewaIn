@extends('layouts.owner')

@section('title', 'Daftar Transaksi')

@section('content')
<div x-data="{ statusModalOpen: false, statusData: { id: '', current: '' } }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Transaksi</h2>
        
        <form method="GET" action="#" class="flex items-center gap-3">
            <div class="relative">
                <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg'></i>
                <input type="text" name="search" placeholder="Cari invoice atau UMKM..." class="pl-10 pr-4 py-2 w-full sm:w-64 rounded-xl border border-gray-200 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors">
            </div>
            <button type="submit" class="bg-brand-500 text-white px-4 py-2 rounded-xl text-sm font-medium hover:bg-brand-600 transition-colors">Cari</button>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left text-sm text-gray-500 whitespace-nowrap">
                <thead class="bg-gray-50/50 text-xs uppercase text-gray-400 border-b border-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Invoice & UMKM</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Item Disewa</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Periode</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Metode</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Total</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    <!-- Dummy Data 1 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="block font-medium text-gray-900 border-b border-gray-100 pb-1 mb-1">#0001</span>
                            <span class="text-xs text-gray-500">UMKM Maju Jaya</span>
                        </td>
                        <td class="px-6 py-4 text-xs">
                            <div class="font-medium text-gray-700">2x Kamera DSLR</div>
                            <div class="text-gray-400">+1 Item lainnya</div>
                        </td>
                        <td class="px-6 py-4 text-xs">
                            <span class="block whitespace-nowrap"><i class='bx bx-calendar mr-1'></i>10 Mei 26 - 12 Mei 26</span>
                            <span class="block text-gray-400 mt-1">(2 Hari)</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 rounded bg-gray-100 px-2 py-1 text-[10px] font-semibold text-gray-600 uppercase">
                                <i class='bx bx-truck'></i> Diantar
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">
                            Rp 250.000
                            <span class="text-[10px] items-center text-gray-500 block font-normal">(inc. Ongkir)</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-600 capitalize">
                                disewa
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button @click="statusData = { id: '1', current: 'disewa' }; statusModalOpen = true" 
                                    class="rounded-lg bg-brand-50 text-brand-600 px-3 py-1.5 text-xs font-semibold hover:bg-brand-100 transition-colors focus:outline-none border border-brand-100">
                                    Ubah Status
                                </button>
                                <a href="#" class="rounded-lg bg-gray-50 text-gray-600 px-3 py-1.5 text-xs font-medium hover:bg-gray-100 transition-colors focus:outline-none border border-gray-200" title="Detail">
                                    <i class='bx bx-show'></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Dummy Data 2 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="block font-medium text-gray-900 border-b border-gray-100 pb-1 mb-1">#0002</span>
                            <span class="text-xs text-gray-500">Toko Berkah</span>
                        </td>
                        <td class="px-6 py-4 text-xs">
                            <div class="font-medium text-gray-700">1x Proyektor Mini</div>
                        </td>
                        <td class="px-6 py-4 text-xs">
                            <span class="block whitespace-nowrap"><i class='bx bx-calendar mr-1'></i>14 Mei 26 - 15 Mei 26</span>
                            <span class="block text-gray-400 mt-1">(1 Hari)</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 rounded bg-gray-100 px-2 py-1 text-[10px] font-semibold text-gray-600 uppercase">
                                <i class='bx bx-store'></i> Ambil Sendiri
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">
                            Rp 75.000
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 rounded-full bg-orange-100 px-2.5 py-1 text-xs font-semibold text-orange-600 capitalize">
                                pending
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button @click="statusData = { id: '2', current: 'pending' }; statusModalOpen = true" 
                                    class="rounded-lg bg-brand-50 text-brand-600 px-3 py-1.5 text-xs font-semibold hover:bg-brand-100 transition-colors focus:outline-none border border-brand-100">
                                    Ubah Status
                                </button>
                                <a href="#" class="rounded-lg bg-gray-50 text-gray-600 px-3 py-1.5 text-xs font-medium hover:bg-gray-100 transition-colors focus:outline-none border border-gray-200" title="Detail">
                                    <i class='bx bx-show'></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Dummy Data 3 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="block font-medium text-gray-900 border-b border-gray-100 pb-1 mb-1">#0003</span>
                            <span class="text-xs text-gray-500">Kedai Kopi</span>
                        </td>
                        <td class="px-6 py-4 text-xs">
                            <div class="font-medium text-gray-700">1x Mesin Kopi Espresso</div>
                        </td>
                        <td class="px-6 py-4 text-xs">
                            <span class="block whitespace-nowrap"><i class='bx bx-calendar mr-1'></i>01 Mei 26 - 05 Mei 26</span>
                            <span class="block text-gray-400 mt-1">(4 Hari)</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 rounded bg-gray-100 px-2 py-1 text-[10px] font-semibold text-gray-600 uppercase">
                                <i class='bx bx-truck'></i> Diantar
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">
                            Rp 400.000
                            <span class="text-[10px] items-center text-gray-500 block font-normal">(inc. Ongkir)</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-600 capitalize">
                                selesai
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button @click="statusData = { id: '3', current: 'selesai' }; statusModalOpen = true" 
                                    class="rounded-lg bg-brand-50 text-brand-600 px-3 py-1.5 text-xs font-semibold hover:bg-brand-100 transition-colors focus:outline-none border border-brand-100">
                                    Ubah Status
                                </button>
                                <a href="#" class="rounded-lg bg-gray-50 text-gray-600 px-3 py-1.5 text-xs font-medium hover:bg-gray-100 transition-colors focus:outline-none border border-gray-200" title="Detail">
                                    <i class='bx bx-show'></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="bg-gray-50/50 p-4 sm:flex sm:items-center sm:justify-between border-t border-gray-100 rounded-b-2xl">
            <p class="text-sm text-gray-500">Menampilkan <span class="font-medium text-gray-700">1</span> sampai <span class="font-medium text-gray-700">3</span> dari <span class="font-medium text-gray-700">15</span> transaksi</p>
            <div class="mt-4 sm:mt-0 flex gap-2">
                <button class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-300 cursor-not-allowed" disabled>Prev</button>
                <button class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors">Next</button>
            </div>
        </div>
    </div>

    <!-- Modal Ubah Status -->
    <div 
        x-show="statusModalOpen" 
        class="fixed inset-0 z-[60] flex items-center justify-center bg-gray-900/50 p-4 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        x-cloak
        style="display: none;"
    >
        <div 
            @click.outside="statusModalOpen = false"
            class="w-full max-w-sm rounded-2xl bg-white shadow-xl ring-1 ring-gray-200/50 overflow-hidden"
            x-show="statusModalOpen" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        >
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                <h3 class="text-lg font-bold text-gray-800">Update Status</h3>
                <button @click="statusModalOpen = false" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>

            <form action="#" method="POST" class="p-6 space-y-4">
                <input type="hidden" name="id_sewa" :value="statusData.id">
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Pesanan</label>
                    <div class="grid grid-cols-1 gap-2">
                        <label class="relative flex cursor-pointer items-center gap-3 rounded-xl border border-gray-200 p-3 transition hover:bg-gray-50 has-[:checked]:border-orange-500 has-[:checked]:bg-orange-50">
                            <input type="radio" name="status_baru" value="pending" :checked="statusData.current == 'pending'" class="accent-orange-500">
                            <span class="text-sm font-semibold text-orange-600">Pending</span>
                        </label>
                        <label class="relative flex cursor-pointer items-center gap-3 rounded-xl border border-gray-200 p-3 transition hover:bg-gray-50 has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                            <input type="radio" name="status_baru" value="disewa" :checked="statusData.current == 'disewa'" class="accent-blue-500">
                            <span class="text-sm font-semibold text-blue-600">Sedang Disewa</span>
                        </label>
                        <label class="relative flex cursor-pointer items-center gap-3 rounded-xl border border-gray-200 p-3 transition hover:bg-gray-50 has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                            <input type="radio" name="status_baru" value="selesai" :checked="statusData.current == 'selesai'" class="accent-green-500">
                            <span class="text-sm font-semibold text-green-600">Selesai</span>
                        </label>
                        <label class="relative flex cursor-pointer items-center gap-3 rounded-xl border border-gray-200 p-3 transition hover:bg-gray-50 has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                            <input type="radio" name="status_baru" value="dibatalkan" :checked="statusData.current == 'dibatalkan'" class="accent-red-500">
                            <span class="text-sm font-semibold text-red-600">Dibatalkan</span>
                        </label>
                    </div>
                </div>

                <div class="flex gap-2 pt-2">
                    <button type="button" @click="statusModalOpen = false" class="flex-1 rounded-xl border border-gray-300 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none">Batal</button>
                    <button type="submit" class="flex-1 rounded-xl bg-brand-500 py-2.5 text-sm font-semibold text-white hover:bg-brand-600 shadow-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
