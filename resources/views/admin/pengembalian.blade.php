@extends('layouts.admin')

@section('title', 'Pengembalian')

@section('content')
<div x-data="{ modalOpen: false, modalDendaOpen: false }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Manajemen Pengembalian</h2>
        
        <div class="flex items-center gap-3">
            <div class="relative">
                <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg'></i>
                <input type="text" placeholder="Cari invoice..." class="pl-10 pr-4 py-2 w-full sm:w-64 rounded-xl border border-gray-200 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors">
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left text-sm text-gray-500">
                <thead class="bg-gray-50/50 text-xs uppercase text-gray-400 border-b border-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Invoice / Penyewa</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Jadwal Kembali</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Keterlambatan</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Denda (Rp)</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <!-- Data dummy 1 (Terlambat) -->
                    <tr class="hover:bg-gray-50/50 transition-colors bg-red-50/30">
                        <td class="px-6 py-4">
                            <span class="block font-medium text-gray-900">INV-0119</span>
                            <span class="text-xs text-gray-500">Warteg Bahari</span>
                        </td>
                        <td class="px-6 py-4 text-xs font-medium text-gray-700">
                            <i class='bx bx-calendar text-gray-400'></i> 22 Feb 2026<br>
                            (pukul 12:00)
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 rounded bg-red-100 px-2 py-1 text-xs font-bold text-red-600">
                                2 Hari
                            </span>
                        </td>
                        <td class="px-6 py-4 font-bold text-red-600">
                            100.000 <span class="text-[10px] block font-normal text-gray-400">(Estimasi)</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-600">
                                Terlambat
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button @click="modalDendaOpen = true" class="rounded-lg bg-brand-500 text-white px-3 py-1.5 text-xs font-medium hover:bg-brand-600 transition-colors focus:outline-none shadow-sm">
                                Proses Kembali
                            </button>
                        </td>
                    </tr>
                    
                    <!-- Data dummy 2 (Selesai/Hari ini) -->
                    <tr class="hover:bg-gray-50/50 transition-colors bg-green-50/30">
                        <td class="px-6 py-4">
                            <span class="block font-medium text-gray-900">INV-0120</span>
                            <span class="text-xs text-gray-500">Ayam Geprek Ngeselin</span>
                        </td>
                        <td class="px-6 py-4 text-xs font-medium text-gray-700">
                            <i class='bx bx-calendar text-gray-400'></i> 24 Feb 2026<br>
                            (pukul 17:00)
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 rounded bg-green-100 px-2 py-1 text-xs font-semibold text-green-700">
                                Sesuai Jadwal
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-500">
                            0
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-600">
                                Return Hari Ini
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button @click="modalOpen = true" class="rounded-lg bg-brand-50 text-brand-600 px-3 py-1.5 text-xs font-medium hover:bg-brand-100 transition-colors focus:outline-none">
                                Konfirmasi
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div 
        x-show="modalOpen" 
        class="fixed inset-0 z-[60] flex items-center justify-center bg-gray-900/50 p-4 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="display: none;"
    >
        <div 
            @click.outside="modalOpen = false"
            class="w-full max-w-sm rounded-2xl bg-white shadow-xl ring-1 ring-gray-200/50 text-center p-6"
        >
            <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full bg-green-100 mb-4">
                <i class='bx bx-check text-4xl text-green-600'></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Konfirmasi Pengembalian</h3>
            <p class="text-sm text-gray-500 mb-6">Pastikan alat produksi kembali dalam keadaan utuh dan lengkap. Proses ini akan mengembalikan stok gudan secara realtime.</p>
            
            <div class="flex gap-3 w-full">
                <button @click="modalOpen = false" class="w-full rounded-xl border border-gray-300 bg-white py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors">
                    Batal
                </button>
                <button class="w-full rounded-xl bg-brand-500 py-2.5 text-sm font-medium text-white hover:bg-brand-600 transition-colors focus:outline-none shadow-sm">
                    Selesai
                </button>
            </div>
        </div>
    </div>

     <!-- Modal Proses Denda -->
     <div 
        x-show="modalDendaOpen" 
        class="fixed inset-0 z-[60] flex items-center justify-center bg-gray-900/50 p-4 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="display: none;"
    >
        <div 
            @click.outside="modalDendaOpen = false"
            class="w-full max-w-md rounded-2xl bg-white shadow-xl ring-1 ring-gray-200/50 p-6 object-left"
        >
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-gray-900">Proses Pengembalian Terlambat</h3>
                <button @click="modalDendaOpen = false" class="text-gray-400 hover:text-gray-600"><i class='bx bx-x text-2xl'></i></button>
            </div>
            
            <div class="bg-red-50 rounded-xl p-4 mb-4 border border-red-100">
                <p class="text-sm text-red-600 mb-1">Total Keterlambatan: <strong class="text-red-800">2 Hari</strong></p>
                <p class="text-sm text-red-600 mb-2">Estimasi Denda: <strong class="text-red-800">Rp 100.000</strong></p>
                <p class="text-xs text-red-400">*Pembayaran denda dilakukan secara offline saat pengambilan / pengembalian alat berdasarkan kesepakatan.</p>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Pengembalian (Opsional)</label>
                <textarea rows="2" class="w-full rounded-xl border border-gray-300 p-2 text-sm focus:border-brand-500" placeholder="Kondisi alat atau keterangan denda..."></textarea>
            </div>

            <label class="flex items-center gap-2 mb-6 cursor-pointer">
                <input type="checkbox" class="rounded border-gray-300 text-brand-600 focus:ring-brand-500">
                <span class="text-sm text-gray-700">Denda sudah dibayarkan secara offline / diselesaikan.</span>
            </label>
            
            <div class="flex gap-3 justify-end w-full">
                <button @click="modalDendaOpen = false" class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors">
                    Tutup
                </button>
                <button class="rounded-xl bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 transition-colors focus:outline-none shadow-sm flex items-center gap-1.5 inline-flex">
                    <i class='bx bx-check-circle'></i> Konfirmasi Selesai
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
