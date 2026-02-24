@extends('layouts.admin')

@section('title', 'Alat Produksi')

@section('content')
<div x-data="{ modalOpen: false }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Alat Produksi</h2>
        <div class="flex items-center gap-3">
            <!-- Search bar -->
            <div class="relative">
                <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg'></i>
                <input type="text" placeholder="Cari alat..." class="pl-10 pr-4 py-2 w-full sm:w-64 rounded-xl border border-gray-200 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors">
            </div>
            
            <button @click="modalOpen = true" class="flex shrink-0 items-center gap-2 rounded-xl bg-brand-500 px-4 py-2 text-sm font-medium text-white transition-all hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 shadow-sm">
                <i class='bx bx-plus text-lg'></i>
                <span class="hidden sm:inline">Tambah Alat</span>
            </button>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left text-sm text-gray-500">
                <thead class="bg-gray-50/50 text-xs uppercase text-gray-400 border-b border-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Alat Produksi</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Kategori</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Total Stok</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Harga/Hari</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <!-- Data dummy 1 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 shrink-0 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400">
                                    <i class='bx bx-image text-xl'></i>
                                </div>
                                <div>
                                    <span class="block font-medium text-gray-900">Mesin Espresso Pro</span>
                                    <span class="text-xs text-gray-400">PNS-001</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 rounded bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-600">
                                Elektronik
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-700">12 Unit</td>
                        <td class="px-6 py-4 text-green-600 font-medium">Rp 150.000</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button class="rounded-lg p-2 text-blue-500 hover:bg-blue-50 transition-colors focus:outline-none" title="Edit">
                                    <i class='bx bx-edit text-xl'></i>
                                </button>
                                <button class="rounded-lg p-2 text-red-500 hover:bg-red-50 transition-colors focus:outline-none" title="Hapus">
                                    <i class='bx bx-trash text-xl'></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Data dummy 2 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 shrink-0 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400">
                                    <i class='bx bx-image text-xl'></i>
                                </div>
                                <div>
                                    <span class="block font-medium text-gray-900">Tenda Stan 3x3m</span>
                                    <span class="text-xs text-gray-400">TND-012</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 rounded bg-orange-50 px-2 py-1 text-xs font-medium text-orange-600">
                                Perlengkapan Stan
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-700">20 Unit</td>
                        <td class="px-6 py-4 text-green-600 font-medium">Rp 75.000</td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button class="rounded-lg p-2 text-blue-500 hover:bg-blue-50 transition-colors focus:outline-none" title="Edit">
                                    <i class='bx bx-edit text-xl'></i>
                                </button>
                                <button class="rounded-lg p-2 text-red-500 hover:bg-red-50 transition-colors focus:outline-none" title="Hapus">
                                    <i class='bx bx-trash text-xl'></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination Placeholder -->
        <div class="bg-gray-50/50 p-4 sm:flex sm:items-center sm:justify-between border-t border-gray-100 rounded-b-2xl">
            <p class="text-sm text-gray-500">Menampilkan <span class="font-medium text-gray-700">1</span> sampai <span class="font-medium text-gray-700">2</span> dari <span class="font-medium text-gray-700">145</span> alat</p>
            <div class="mt-4 sm:mt-0 flex gap-2">
                <button class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed focus:outline-none" disabled>Sebelumnya</button>
                <button class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">Selanjutnya</button>
            </div>
        </div>
    </div>

    <!-- Modal Form Tambah Alat -->
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
            class="w-full max-w-2xl rounded-2xl bg-white shadow-xl ring-1 ring-gray-200/50 max-h-[90vh] flex flex-col"
            x-show="modalOpen" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4 shrink-0">
                <h3 class="text-lg font-bold text-gray-800">Tambah Alat Produksi Baru</h3>
                <button @click="modalOpen = false" class="rounded-lg p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition focus:outline-none">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>

            <div class="overflow-y-auto p-6 space-y-4 flex-1">
                <form id="formTambahAlat" action="#" method="POST" class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Nama Alat</label>
                            <input type="text" class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500" placeholder="Misal: Mesin Press Cup">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Kategori</label>
                            <select class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500">
                                <option>Pilih Kategori...</option>
                                <option>Elektronik</option>
                                <option>Perabotan</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Total Stok</label>
                            <input type="number" min="0" class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500" placeholder="0">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Harga Sewa / Hari (Rp)</label>
                            <input type="number" min="0" step="1000" class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500" placeholder="50000">
                        </div>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                        <textarea rows="3" class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500" placeholder="Spesifikasi atau catatan khusus terkait alat ini..."></textarea>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Foto Alat</label>
                        <div class="mt-1 flex justify-center rounded-xl border border-dashed border-gray-300 px-6 py-6 transition-colors hover:bg-gray-50">
                            <div class="text-center">
                                <i class='bx bx-image-add text-4xl text-gray-400'></i>
                                <div class="mt-4 flex text-sm leading-6 text-gray-600 justify-center">
                                    <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-brand-500 hover:text-brand-600 focus-within:outline-none">
                                        <span>Upload file</span>
                                        <input id="file-upload" name="file-upload" type="file" class="sr-only">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs leading-5 text-gray-500">PNG, JPG up to 2MB</p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            <div class="flex items-center gap-2 border-t border-gray-100 px-6 py-4 justify-end bg-gray-50/50 rounded-b-2xl shrink-0">
                <button type="button" @click="modalOpen = false" class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                    Batal
                </button>
                <button type="button" class="rounded-xl bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 shadow-sm">
                    Simpan Alat
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
