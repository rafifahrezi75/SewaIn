@extends('layouts.admin')

@section('title', 'Alat Produksi')

@section('content')
<div x-data="{ modalOpen: false, editModalOpen: false, editData: { id: '', nama: '', kategori: '', stok: '', harga: '', deskripsi: '' } }">
    <div class="flex flex-col xl:flex-row xl:items-center justify-between mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800 shrink-0">Daftar Alat Produksi</h2>
        <form method="GET" action="#" class="flex flex-wrap items-center gap-3">
            <select name="idkategori_filter" class="w-full sm:w-auto rounded-xl border border-gray-200 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors">
                <option value="">Semua Kategori</option>
                <option value="1">Elektronik</option>
                <option value="2">Perlengkapan Stan</option>
            </select>
            
            <div class="relative w-full sm:w-auto">
                <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg'></i>
                <input type="text" name="search" placeholder="Cari alat..." class="pl-10 pr-4 py-2 w-full sm:w-48 xl:w-64 rounded-xl border border-gray-200 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors">
            </div>
            
            <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                <button type="button" class="rounded-xl bg-gray-100 text-gray-600 px-4 py-2 text-sm font-medium hover:bg-gray-200 transition-colors focus:outline-none">Cari</button>
                
                <button type="button" @click="modalOpen = true" class="flex shrink-0 items-center justify-center gap-2 rounded-xl bg-brand-500 px-4 py-2 text-sm font-medium text-white transition-all hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 shadow-sm">
                    <i class='bx bx-plus text-lg'></i>
                    <span class="hidden sm:inline">Tambah Alat</span>
                </button>
            </div>
        </form>
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
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider text-center w-36">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    <tr class="hover:bg-brand-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 shrink-0 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 overflow-hidden">
                                    <i class='bx bx-image text-xl'></i>
                                </div>
                                <div>
                                    <span class="block font-semibold text-gray-800 text-[15px]">Mesin Espresso Pro</span>
                                    <span class="text-xs font-medium text-gray-400 max-w-[12rem] truncate block" title="Spesifikasi...">Mesin pembuat kopi...</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-xs font-semibold bg-indigo-50 text-indigo-600">
                                <i class='bx bx-laptop text-sm'></i>
                                Elektronik
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-700">12 Unit</span>
                                <span class="mt-1 w-max rounded-md bg-emerald-100/80 px-2 py-0.5 text-[10px] font-bold tracking-wider text-emerald-700 uppercase">Tersedia</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-brand-600 font-bold whitespace-nowrap">Rp 150.000</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="rounded-lg p-2 text-emerald-500 bg-emerald-50 hover:bg-emerald-100 hover:text-emerald-600 transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1" title="Detail Alat">
                                    <i class='bx bx-info-circle text-xl'></i>
                                </a>
                                <button type="button" @click="editData = { id: '1', nama: 'Mesin Espresso Pro', kategori: '1', stok: '12', harga: '150000', deskripsi: 'Mesin pembuat kopi...' }; editModalOpen = true" class="rounded-lg p-2 text-blue-500 bg-blue-50 hover:bg-blue-100 hover:text-blue-600 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1" title="Edit">
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
                sampai <span class="font-medium text-gray-700">1</span> 
                dari <span class="font-medium text-gray-700">1</span> alat
            </p>
            <div class="mt-4 sm:mt-0 flex gap-2">
                <button class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed" disabled>Sebelumnya</button>
                <button class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed" disabled>Selanjutnya</button>
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

            <form action="#" method="POST" enctype="multipart/form-data" class="flex flex-col h-full" x-data="{ fileName: '' }">
                <div class="overflow-y-auto p-6 space-y-4 flex-1">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Nama Alat</label>
                            <input type="text" name="nama_alat" required class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500" placeholder="Misal: Mesin Press Cup">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Kategori</label>
                            <select name="idkategori" required class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500">
                                <option disabled selected value="">Pilih Kategori...</option>
                                <option value="1">Elektronik</option>
                                <option value="2">Perlengkapan Stan</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Total Stok</label>
                            <input type="number" name="stok" min="0" required class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500" placeholder="0">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Harga Sewa / Hari (Rp)</label>
                            <input type="number" name="harga_sewa" min="0" step="1000" required class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500" placeholder="50000">
                        </div>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                        <textarea rows="3" name="deskripsi" required class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500" placeholder="Spesifikasi atau catatan khusus terkait alat ini..."></textarea>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Foto Alat</label>
                        <div class="mt-1 flex justify-center rounded-xl border border-dashed border-gray-300 px-6 py-6 transition-colors hover:bg-gray-50 relative overflow-hidden group">
                            
                            <!-- File Name Display (Tampil saat fileName ADA isinya) -->
                            <template x-if="fileName">
                                <div class="absolute inset-0 z-10 bg-white flex flex-col items-center justify-center p-4">
                                    <div class="flex items-center gap-3 bg-brand-50 border border-brand-100 rounded-lg px-4 py-3 w-full max-w-sm">
                                        <i class='bx bxs-file-image text-3xl text-brand-500'></i>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-800 truncate" x-text="fileName"></p>
                                            <p class="text-[11px] text-gray-500 font-medium">Image selected</p>
                                        </div>
                                        <button type="button" @click="fileName = ''; document.getElementById('file-upload').value = '';" class="text-gray-400 hover:text-red-500 transition-colors focus:outline-none" title="Hapus foto">
                                            <i class='bx bx-trash text-xl'></i>
                                        </button>
                                    </div>
                                </div>
                            </template>

                            <!-- Form Upload Asli (Tampil saat KOSONG) -->
                            <div class="text-center" x-show="!fileName">
                                <i class='bx bx-image-add text-4xl text-gray-400'></i>
                                <div class="mt-4 flex text-sm leading-6 text-gray-600 justify-center">
                                    <label for="file-upload" class="relative cursor-pointer rounded-md bg-transparent font-semibold text-brand-500 hover:text-brand-600 focus-within:outline-none">
                                        <span>Upload file</span>
                                        <input id="file-upload" name="gambar" type="file" required accept="image/png, image/jpeg, image/jpg" class="sr-only" @change="fileName = $event.target.files.length ? $event.target.files[0].name : ''">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs leading-5 text-gray-500">PNG, JPG up to 2MB</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 border-t border-gray-100 px-6 py-4 justify-end bg-gray-50/50 rounded-b-2xl shrink-0">
                    <button type="button" @click="modalOpen = false" class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                        Batal
                    </button>
                    <button type="button" class="rounded-xl bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 shadow-sm">
                        Simpan Alat
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Form Edit Alat -->
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
            class="w-full max-w-2xl rounded-2xl bg-white shadow-xl ring-1 ring-gray-200/50 max-h-[90vh] flex flex-col"
            x-show="editModalOpen" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4 shrink-0">
                <h3 class="text-lg font-bold text-gray-800">Edit Alat Produksi</h3>
                <button type="button" @click="editModalOpen = false" class="rounded-lg p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition focus:outline-none">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>

            <form action="#" method="POST" enctype="multipart/form-data" class="flex flex-col h-full" x-data="{ fileNameEdit: '' }">
                <input type="hidden" name="idalat_edit" :value="editData.id">
                <div class="overflow-y-auto p-6 space-y-4 flex-1">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Nama Alat</label>
                            <input type="text" name="nama_alat" :value="editData.nama" required class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500" placeholder="Misal: Mesin Press Cup">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Kategori</label>
                            <select name="idkategori" :value="editData.kategori" required class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500">
                                <option disabled value="">Pilih Kategori...</option>
                                <option value="1">Elektronik</option>
                                <option value="2">Perlengkapan Stan</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Total Stok</label>
                            <input type="number" name="stok" :value="editData.stok" min="0" required class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500" placeholder="0">
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Harga Sewa / Hari (Rp)</label>
                            <input type="number" name="harga_sewa" :value="editData.harga" min="0" step="1000" required class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500" placeholder="50000">
                        </div>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                        <textarea rows="3" name="deskripsi" :value="editData.deskripsi" required class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500" placeholder="Spesifikasi..."></textarea>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Ganti Foto Alat (Kosongkan jika tidak diganti)</label>
                        <div class="mt-1 flex justify-center rounded-xl border border-dashed border-gray-300 px-6 py-6 transition-colors hover:bg-gray-50 relative overflow-hidden group">
                            
                            <!-- File Name Display -->
                            <template x-if="fileNameEdit">
                                <div class="absolute inset-0 z-10 bg-white flex flex-col items-center justify-center p-4">
                                    <div class="flex items-center gap-3 bg-brand-50 border border-brand-100 rounded-lg px-4 py-3 w-full max-w-sm">
                                        <i class='bx bxs-file-image text-3xl text-brand-500'></i>
                                        <div class="flex-1 min-w-0">
                                            <p class="text-sm font-semibold text-gray-800 truncate" x-text="fileNameEdit"></p>
                                        </div>
                                        <button type="button" @click="fileNameEdit = ''; document.getElementById('file-upload-edit').value = '';" class="text-gray-400 hover:text-red-500 transition-colors focus:outline-none">
                                            <i class='bx bx-trash text-xl'></i>
                                        </button>
                                    </div>
                                </div>
                            </template>

                            <!-- Base Upload Area -->
                            <div class="text-center" x-show="!fileNameEdit">
                                <i class='bx bx-image-add text-4xl text-gray-400'></i>
                                <div class="mt-4 flex text-sm leading-6 text-gray-600 justify-center">
                                    <label for="file-upload-edit" class="relative cursor-pointer rounded-md bg-transparent font-semibold text-brand-500 hover:text-brand-600 focus-within:outline-none">
                                        <span>Upload file baru</span>
                                        <input id="file-upload-edit" name="gambar" type="file" accept="image/png, image/jpeg, image/jpg" class="sr-only" @change="fileNameEdit = $event.target.files.length ? $event.target.files[0].name : ''">
                                    </label>
                                </div>
                                <p class="text-[11px] mt-2 font-medium text-orange-500 bg-orange-50 px-2 py-0.5 rounded">*Abaikan jika foto tidak diubah</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-2 border-t border-gray-100 px-6 py-4 justify-end bg-gray-50/50 rounded-b-2xl shrink-0">
                    <button type="button" @click="editModalOpen = false" class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                        Batal
                    </button>
                    <button type="button" name="update_alat" class="rounded-xl bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 shadow-sm">
                        Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

