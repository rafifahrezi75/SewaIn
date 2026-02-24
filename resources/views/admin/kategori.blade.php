@extends('layouts.admin')

@section('title', 'Kategori')

@section('content')
<div x-data="{ modalOpen: false }">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Kategori</h2>
        <button @click="modalOpen = true" class="flex items-center gap-2 rounded-xl bg-brand-500 px-4 py-2 text-sm font-medium text-white transition-all hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 shadow-sm">
            <i class='bx bx-plus text-lg'></i>
            <span>Tambah Kategori</span>
        </button>
    </div>

    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left text-sm text-gray-500">
                <thead class="bg-gray-50/50 text-xs uppercase text-gray-400 border-b border-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">No</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Kategori</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Slug</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <!-- Data dummy 1 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 w-16">1</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600">
                                    <i class='bx bx-laptop text-xl'></i>
                                </div>
                                <span class="font-medium text-gray-700">Elektronik</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">elektronik</td>
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
                        <td class="px-6 py-4 font-medium text-gray-900 w-16">2</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-orange-50 text-orange-600">
                                    <i class='bx bx-car text-xl'></i>
                                </div>
                                <span class="font-medium text-gray-700">Kendaraan</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">kendaraan</td>
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

                    <!-- Data dummy 3 -->
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 w-16">3</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600">
                                    <i class='bx bx-camera text-xl'></i>
                                </div>
                                <span class="font-medium text-gray-700">Fotografi</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">fotografi</td>
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
            <p class="text-sm text-gray-500">Menampilkan <span class="font-medium text-gray-700">1</span> sampai <span class="font-medium text-gray-700">3</span> dari <span class="font-medium text-gray-700">9</span> kategori</p>
            <div class="mt-4 sm:mt-0 flex gap-2">
                <button class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed focus:outline-none" disabled>Sebelumnya</button>
                <button class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">Selanjutnya</button>
            </div>
        </div>
    </div>

    <!-- Modal Form Kategori -->
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
            class="w-full max-w-md rounded-2xl bg-white shadow-xl ring-1 ring-gray-200/50"
            x-show="modalOpen" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
            <!-- Modal Header -->
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                <h3 class="text-lg font-bold text-gray-800">Tambah Kategori</h3>
                <button @click="modalOpen = false" class="rounded-lg p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition focus:outline-none">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>

            <!-- Modal Body (Form) -->
            <form action="#" method="POST">
                <div class="space-y-4 px-6 py-4">
                    
                    <!-- Input Nama Kategori -->
                    <div>
                        <label for="nama_kategori" class="mb-1 block text-sm font-medium text-gray-700">Nama Kategori</label>
                        <input type="text" id="nama_kategori" name="nama_kategori" class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors" placeholder="Masukkan nama kategori" required>
                    </div>

                    <!-- Input Icon (Catatan/Optional) -->
                    <div>
                        <label for="icon" class="mb-1 block text-sm font-medium text-gray-700">Icon Class (Boxicons)</label>
                        <input type="text" id="icon" name="icon" class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors" placeholder="Contoh: bx-laptop">
                        <p class="mt-1 text-xs text-gray-500">Gunakan class icon dari <a href="https://boxicons.com/" target="_blank" class="text-brand-500 hover:underline">Boxicons</a>.</p>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="flex items-center gap-2 border-t border-gray-100 px-6 py-4 justify-end bg-gray-50/50 rounded-b-2xl">
                    <button type="button" @click="modalOpen = false" class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="rounded-xl bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition-all shadow-sm">
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
