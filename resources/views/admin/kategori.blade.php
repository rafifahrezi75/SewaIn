@extends('layouts.admin')

@section('title', 'Kategori')

@section('content')
<div x-data="{ modalOpen: false, editModalOpen: false, editData: { id: '', nama: '', icon: '' } }">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Kategori</h2>
        <button @click="modalOpen = true" class="flex items-center gap-2 rounded-xl bg-brand-500 px-4 py-2 text-sm font-medium text-white transition-all hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 shadow-sm">
            <i class='bx bx-plus text-lg'></i>
            <span>Tambah Kategori</span>
        </button>
    </div>

    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left text-sm text-gray-500 whitespace-nowrap">
                <thead class="bg-gray-50/50 text-xs uppercase text-gray-400 border-b border-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider text-center w-16">No</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Kategori</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700 border-b border-gray-100">
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 text-center">1</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg shadow-sm bg-indigo-50 text-indigo-600">
                                    <i class='bx bx-laptop text-xl'></i>
                                </div>
                                <span class="font-semibold text-gray-800">Elektronik</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" @click="editData = { id: '1', nama: 'Elektronik', icon: 'bx-laptop' }; editModalOpen = true" class="rounded-lg p-2 text-blue-500 bg-blue-50 hover:bg-blue-100 hover:text-blue-600 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1" title="Edit">
                                    <i class='bx bx-edit text-xl'></i>
                                </button>
                                <button type="button" class="rounded-lg p-2 text-red-500 bg-red-50 hover:bg-red-100 hover:text-red-600 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1" title="Hapus">
                                    <i class='bx bx-trash text-xl'></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 text-center">2</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg shadow-sm bg-orange-50 text-orange-600">
                                    <i class='bx bx-car text-xl'></i>
                                </div>
                                <span class="font-semibold text-gray-800">Kendaraan</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" @click="editData = { id: '2', nama: 'Kendaraan', icon: 'bx-car' }; editModalOpen = true" class="rounded-lg p-2 text-blue-500 bg-blue-50 hover:bg-blue-100 hover:text-blue-600 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1" title="Edit">
                                    <i class='bx bx-edit text-xl'></i>
                                </button>
                                <button type="button" class="rounded-lg p-2 text-red-500 bg-red-50 hover:bg-red-100 hover:text-red-600 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1" title="Hapus">
                                    <i class='bx bx-trash text-xl'></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="bg-gray-50/50 p-4 sm:flex sm:items-center sm:justify-between border-t border-gray-100 rounded-b-2xl">
            <p class="text-sm text-gray-500">
                Menampilkan <span class="font-medium text-gray-700">1</span> 
                sampai <span class="font-medium text-gray-700">2</span> 
                dari total <span class="font-medium text-gray-700">2</span> kategori
            </p>
            <div class="mt-4 sm:mt-0 flex gap-2">
                <button class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed focus:outline-none" disabled>Sebelumnya</button>
                <button class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed focus:outline-none" disabled>Selanjutnya</button>
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
            
            <form action="" method="POST">
                <div class="space-y-4 px-6 py-4">
                    
                    <div>
                        <label for="nama_kategori" class="mb-1 block text-sm font-medium text-gray-700">Nama Kategori</label>
                        <input type="text" id="nama_kategori" name="nama_kategori" class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors" placeholder="Masukkan nama kategori" required>
                    </div>

                    <div>
                        <label for="icon" class="mb-1 block text-sm font-medium text-gray-700">Icon Class (Boxicons)</label>
                        <input type="text" id="icon" name="icon" class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors" placeholder="Contoh: bx-laptop">
                        <p class="mt-1 text-xs text-gray-500">Gunakan class icon dari <a href="https://boxicons.com/icons?free=true" target="_blank" class="text-brand-500 hover:underline">Boxicons</a>.</p>
                    </div>

                </div>
                
                <div class="flex items-center gap-2 border-t border-gray-100 px-6 py-4 justify-end bg-gray-50/50 rounded-b-2xl">
                    <button type="button" @click="modalOpen = false" class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors">
                        Batal
                    </button>
                    <button type="submit" name="tambah_kategori" class="rounded-xl bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition-all shadow-sm">
                        Simpan Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Form Update Kategori -->
    <div 
        x-show="editModalOpen" 
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
            @click.outside="editModalOpen = false"
            class="w-full max-w-md rounded-2xl bg-white shadow-xl ring-1 ring-gray-200/50"
            x-show="editModalOpen" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                <h3 class="text-lg font-bold text-gray-800">Update Kategori</h3>
                <button type="button" @click="editModalOpen = false" class="rounded-lg p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition focus:outline-none">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>

            <form action="" method="POST">
                <input type="hidden" name="idkategori" x-model="editData.id">
                <div class="space-y-4 px-6 py-4">

                    <div>
                        <label for="edit_nama_kategori" class="mb-1 block text-sm font-medium text-gray-700">Nama Kategori</label>
                        <input type="text" id="edit_nama_kategori" name="edit_nama_kategori" x-model="editData.nama" class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors" placeholder="Masukkan nama kategori" required>
                    </div>

                    <div>
                        <label for="edit_icon" class="mb-1 block text-sm font-medium text-gray-700">Icon Class (Boxicons)</label>
                        <input type="text" id="edit_icon" name="edit_icon" x-model="editData.icon" class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors" placeholder="Contoh: bx-laptop">
                    </div>

                </div>

                <div class="flex items-center gap-2 border-t border-gray-100 px-6 py-4 justify-end bg-gray-50/50 rounded-b-2xl">
                    <button type="button" @click="editModalOpen = false" class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors">
                        Batal
                    </button>
                    <button type="submit" name="update_kategori" class="rounded-xl bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition-all shadow-sm">
                        Update Kategori
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
