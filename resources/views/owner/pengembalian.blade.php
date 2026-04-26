@extends('layouts.owner')

@section('title', 'Pengembalian Alat')

@section('content')
<div x-data="{ 
    qcModalOpen: false, 
    denda_kerusakan: 0,
    selectedData: { id_sewa: '', id_sewa_label: '', dendaTelat: '', telat: '', wa: '', user: '' }
}">

    <!-- SECTION 1: ANTREAN -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Antrean Validasi</h2>
        <div class="flex items-center gap-3">
            <div class="relative">
                <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg'></i>
                <input type="text" placeholder="Cari invoice..." class="pl-10 pr-4 py-2 w-full sm:w-64 rounded-xl border border-gray-200 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden mb-10">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-500 whitespace-nowrap">
                <thead class="bg-gray-50/50 text-xs uppercase text-gray-400 border-b border-gray-100 font-semibold tracking-wider">
                    <tr>
                        <th scope="col" class="px-6 py-4">Invoice & UMKM</th>
                        <th scope="col" class="px-6 py-4">Tenggat Waktu</th>
                        <th scope="col" class="px-6 py-4">Status Waktu</th>
                        <th scope="col" class="px-6 py-4">Progres</th>
                        <th scope="col" class="px-6 py-4 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    <!-- Dummy Data 1 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="block font-medium text-gray-900 border-b border-gray-100 pb-1 mb-1">#0001</span>
                            <span class="text-xs text-gray-500">UMKM Maju Jaya</span>
                        </td>
                        <td class="px-6 py-4 text-xs font-medium text-gray-700">
                            12 Mei 2026
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 rounded bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600 ring-1 ring-inset ring-red-500/10">Telat 2 Hari</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 rounded bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                Sedang Disewa
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button @click="selectedData = {
                                    id_sewa: '1',
                                    id_sewa_label: '#0001',
                                    dendaTelat: '100.000',
                                    telat: '2 Hari',
                                    user: 'UMKM Maju Jaya',
                                    wa: '08123456789'
                                }; denda_kerusakan = 0; qcModalOpen = true"
                                class="bg-brand-500 text-white px-4 py-2 rounded-lg text-xs font-medium hover:bg-brand-600 transition-colors shadow-sm focus:outline-none">
                                Validasi Pengembalian
                            </button>
                        </td>
                    </tr>

                    <!-- Dummy Data 2 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="block font-medium text-gray-900 border-b border-gray-100 pb-1 mb-1">#0004</span>
                            <span class="text-xs text-gray-500">Toko Sumber Makmur</span>
                        </td>
                        <td class="px-6 py-4 text-xs font-medium text-gray-700">
                            14 Mei 2026
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 rounded bg-orange-50 px-2.5 py-1 text-xs font-medium text-orange-600 ring-1 ring-inset ring-orange-500/10">Hari Ini</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 rounded bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                                Sedang Disewa
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <button @click="selectedData = {
                                    id_sewa: '4',
                                    id_sewa_label: '#0004',
                                    dendaTelat: '0',
                                    telat: '0 Hari',
                                    user: 'Toko Sumber Makmur',
                                    wa: '08987654321'
                                }; denda_kerusakan = 0; qcModalOpen = true"
                                class="bg-brand-500 text-white px-4 py-2 rounded-lg text-xs font-medium hover:bg-brand-600 transition-colors shadow-sm focus:outline-none">
                                Validasi Pengembalian
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- SECTION 2: RIWAYAT SEWA -->
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-gray-800">Riwayat Pengembalian Selesai</h2>
    </div>

    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-500 whitespace-nowrap">
                <thead class="bg-gray-50/50 text-xs uppercase text-gray-400 border-b border-gray-100 font-semibold tracking-wider">
                    <tr>
                        <th scope="col" class="px-6 py-4">Invoice</th>
                        <th scope="col" class="px-6 py-4">Kondisi Alat</th>
                        <th scope="col" class="px-6 py-4">Keterlambatan</th>
                        <th scope="col" class="px-6 py-4">Total Denda</th>
                        <th scope="col" class="px-6 py-4 text-right">Tanggal Selesai</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    <!-- Dummy Riwayat 1 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="block font-medium text-gray-900 border-b border-gray-100 pb-1 mb-1">#0003</span>
                            <span class="text-xs text-gray-500 block">Kedai Kopi</span>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-700">
                            Aman
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 rounded bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-600 ring-1 ring-inset ring-emerald-500/10">Tepat Waktu</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs text-emerald-600 font-medium bg-emerald-50 px-2 py-1 rounded inline-block">Selesai / Tanpa Denda</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-xs text-gray-700 block">05 Mei 2026</span>
                            <span class="text-xs text-gray-400 block mt-1"><i class='bx bx-check'></i> QC Divalidasi</span>
                        </td>
                    </tr>

                    <!-- Dummy Riwayat 2 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="block font-medium text-gray-900 border-b border-gray-100 pb-1 mb-1">#0002</span>
                            <span class="text-xs text-gray-500 block">Warung Makan Sederhana</span>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-700">
                            Unit Kotor / Bau
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 rounded bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600 ring-1 ring-inset ring-red-500/10">Telat 1 Hari</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-medium text-red-600 block">Rp 75.000</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <span class="text-xs text-gray-700 block">03 Mei 2026</span>
                            <span class="text-xs text-gray-400 block mt-1"><i class='bx bx-check'></i> QC Divalidasi</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL VALIDASI PENGEMBALIAN -->
    <div x-show="qcModalOpen" class="fixed inset-0 z-[60] flex items-center justify-center bg-gray-900/50 p-4 backdrop-blur-sm" x-cloak style="display: none;">
        <div @click.outside="qcModalOpen = false" class="w-full max-w-lg rounded-3xl bg-white shadow-2xl overflow-hidden" x-show="qcModalOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 scale-95" x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 scale-100" x-transition:leave-end="opacity-0 translate-y-4 scale-95">
            
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-5 bg-gray-50/50">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800">Validasi Pengembalian</h3>
                    <p class="text-xs text-gray-500 mt-1" x-text="'Invoice ' + selectedData.id_sewa_label"></p>
                </div>
                <button type="button" @click="qcModalOpen = false" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>

            <form action="#" method="POST" class="p-6">
                <input type="hidden" name="id_sewa" :value="selectedData.id_sewa">

                <!-- Alert Denda Keterlambatan -->
                <div class="mb-6 rounded-xl border border-red-100 bg-red-50 p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                    <div>
                        <h4 class="text-sm font-semibold text-red-600 mb-0.5">Denda Keterlambatan</h4>
                        <p class="text-xs text-red-500" x-text="'Sistem: Terlambat ' + selectedData.telat"></p>
                    </div>
                    <div class="sm:text-right">
                        <p class="text-xl font-bold text-red-600 tracking-tight" x-text="'Rp ' + selectedData.dendaTelat"></p>
                    </div>
                </div>

                <div class="space-y-6 mb-8">
                    <div>
                        <h4 class="text-sm font-semibold text-gray-800 mb-3 block">Kondisi Alat (Hasil Inspeksi Gudang)</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors shadow-sm bg-white">
                                <input type="checkbox" name="kondisi[]" value="Unit Kotor/Bau" class="w-4 h-4 text-brand-500 border-gray-300 rounded focus:ring-brand-500">
                                <span class="text-sm font-medium text-gray-700">Unit Kotor / Bau</span>
                            </label>
                            <label class="flex items-center gap-3 p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors shadow-sm bg-white">
                                <input type="checkbox" name="kondisi[]" value="Kerusakan Fisik" class="w-4 h-4 text-brand-500 border-gray-300 rounded focus:ring-brand-500">
                                <span class="text-sm font-medium text-gray-700">Kerusakan Fisik</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-2">Nominal Denda Tambahan Jika Ada</label>
                        <div class="flex items-stretch rounded-xl shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-brand-500 overflow-hidden bg-white">
                            <span class="flex items-center justify-center px-4 bg-gray-50 text-gray-500 text-sm font-medium border-r border-gray-200">Rp</span>
                            <input type="number" name="denda_kerusakan" x-model.number="denda_kerusakan" placeholder="0" class="flex-1 w-full border-0 py-2.5 pl-4 px-3 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm font-medium outline-none">
                        </div>
                        <p class="mt-2 text-xs text-gray-500 block">Kosongkan (atau isi 0) jika alat utuh dan bersih.</p>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row-reverse gap-3 pt-2">
                    <button type="submit" name="simpan_pengembalian"
                        class="flex-1 bg-brand-500 text-white px-5 py-2.5 rounded-xl font-medium text-sm hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition-all flex items-center justify-center gap-2 shadow-sm">
                        <i class='bx bx-check-circle text-lg'></i>
                        Validasi & Selesaikan
                    </button>
                    <button type="button" @click="qcModalOpen = false" class="flex-none px-6 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
