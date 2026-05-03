@extends('layouts.admin')

@section('title', 'Alat Produksi')

@section('content')
<div x-data="{ 
    modalOpen: {{ $errors->any() && !request()->has('idalat_edit') ? 'true' : 'false' }}, 
    hasErrors: {{ $errors->any() && !request()->has('idalat_edit') ? 'true' : 'false' }}, 
    editModalOpen: {{ $errors->any() && request()->has('idalat_edit') ? 'true' : 'false' }}, 
    hasEditErrors: {{ $errors->any() && request()->has('idalat_edit') ? 'true' : 'false' }}, 
    filterModalOpen: false, 
    editData: { 
        id: {{ json_encode(old('idalat_edit', '')) }}, 
        nama: {{ json_encode(old('nama_alat', '')) }}, 
        kategori: {{ json_encode(old('idkategori', '')) }}, 
        stok: {{ json_encode(old('stok', '')) }}, 
        harga: {{ json_encode(old('harga_sewa', '')) }}, 
        deskripsi: {{ json_encode(old('deskripsi', '')) }} 
    } 
}">
    
    <div class="flex flex-col xl:flex-row xl:items-center justify-between mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800 shrink-0">Daftar Alat Produksi</h2>
        <form method="GET" action="{{ route('admin.alat') }}" class="flex flex-wrap items-center gap-3">
            <!-- Hidden inputs to preserve filters when searching -->
            @if(request()->filled('idkategori_filter'))
                <input type="hidden" name="idkategori_filter" value="{{ request('idkategori_filter') }}">
            @endif
            @if(request()->filled('stok_tersedia'))
                <input type="hidden" name="stok_tersedia" value="{{ request('stok_tersedia') }}">
            @endif
            @if(request()->filled('stok_habis'))
                <input type="hidden" name="stok_habis" value="{{ request('stok_habis') }}">
            @endif
            @if(request()->filled('harga_min'))
                <input type="hidden" name="harga_min" value="{{ request('harga_min') }}">
            @endif
            @if(request()->filled('harga_max'))
                <input type="hidden" name="harga_max" value="{{ request('harga_max') }}">
            @endif

            <div class="relative w-full sm:w-auto flex-1 sm:flex-none">
                <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg'></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari alat..." class="pl-10 pr-4 py-2 w-full sm:w-48 xl:w-64 rounded-xl border border-gray-200 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors">
            </div>
            
            <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                @if(request()->filled('search') || request()->filled('idkategori_filter') || request()->filled('stok_tersedia') || request()->filled('stok_habis') || request()->filled('harga_min') || request()->filled('harga_max'))
                <a href="{{ route('admin.alat') }}" class="rounded-xl bg-red-50 text-red-600 px-4 py-2 text-sm font-medium hover:bg-red-100 transition-colors focus:outline-none border border-red-100 flex items-center justify-center">
                    Reset
                </a>
                @endif
                <button type="button" @click="filterModalOpen = true" class="rounded-xl bg-white border border-gray-200 text-gray-600 px-4 py-2 text-sm font-medium hover:bg-gray-50 transition-colors focus:outline-none flex items-center gap-2">
                    <i class='bx bx-slider-alt text-lg'></i>
                    <span class="hidden sm:inline">Filter</span>
                </button>
                <button type="submit" class="rounded-xl bg-gray-100 text-gray-600 px-4 py-2 text-sm font-medium hover:bg-gray-200 transition-colors focus:outline-none">Cari</button>
                
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
                    @forelse($alatList as $item)
                    <tr class="hover:bg-brand-50/50 transition-colors group">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                <div class="h-10 w-10 shrink-0 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400 overflow-hidden">
                                    @if($item->gambar)
                                        <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama_alat }}" class="h-full w-full object-cover">
                                    @else
                                        <i class='bx bx-image text-xl'></i>
                                    @endif
                                </div>
                                <div>
                                    <span class="block font-semibold text-gray-800 text-[15px]">{{ $item->nama_alat }}</span>
                                    <span class="text-xs font-medium text-gray-400 max-w-[12rem] truncate block" title="{{ $item->deskripsi }}">{{ Str::limit($item->deskripsi, 30) }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1.5 rounded-lg px-2.5 py-1.5 text-xs font-semibold bg-indigo-50 text-indigo-600">
                                <i class='bx {{ $item->kategori->icon ?? 'bx-layer' }} text-sm'></i>
                                {{ $item->kategori->kategori ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="font-semibold text-gray-700">{{ $item->stok }} Unit</span>
                                @if($item->stok > 0)
                                <span class="mt-1 w-max rounded-md bg-emerald-100/80 px-2 py-0.5 text-[10px] font-bold tracking-wider text-emerald-700 uppercase">Tersedia</span>
                                @else
                                <span class="mt-1 w-max rounded-md bg-red-100/80 px-2 py-0.5 text-[10px] font-bold tracking-wider text-red-700 uppercase">Habis</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-brand-600 font-bold whitespace-nowrap">Rp {{ number_format($item->harga_sewa, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" @click="editData = { id: '{{ $item->idalat }}', nama: {{ json_encode($item->nama_alat) }}, kategori: '{{ $item->idkategori }}', stok: '{{ $item->stok }}', harga: '{{ $item->harga_sewa }}', deskripsi: {{ json_encode($item->deskripsi) }} }; editModalOpen = true; hasEditErrors = false" class="rounded-lg p-2 text-blue-500 bg-blue-50 hover:bg-blue-100 hover:text-blue-600 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1" title="Edit">
                                    <i class='bx bx-edit text-xl'></i>
                                </button>
                                <form id="delete-form-{{ $item->idalat }}" action="{{ route('admin.alat.destroy', $item->idalat) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button" onclick="confirmDelete('{{ $item->idalat }}', {{ json_encode($item->nama_alat) }})" class="rounded-lg p-2 text-red-500 bg-red-50 hover:bg-red-100 hover:text-red-600 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1" title="Hapus">
                                    <i class='bx bx-trash text-xl'></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada data alat produksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="bg-gray-50/50 p-4 sm:flex sm:items-center sm:justify-between border-t border-gray-100 rounded-b-2xl">
            <p class="text-sm text-gray-500">
                Menampilkan <span class="font-medium text-gray-700">{{ $alatList->firstItem() ?? 0 }}</span> 
                sampai <span class="font-medium text-gray-700">{{ $alatList->lastItem() ?? 0 }}</span> 
                dari <span class="font-medium text-gray-700">{{ $alatList->total() }}</span> alat
            </p>
            <div class="mt-4 sm:mt-0 flex gap-2">
                @if ($alatList->onFirstPage())
                    <button class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed focus:outline-none" disabled>Sebelumnya</button>
                @else
                    <a href="{{ $alatList->appends(request()->query())->previousPageUrl() }}" class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors">Sebelumnya</a>
                @endif

                @if ($alatList->hasMorePages())
                    <a href="{{ $alatList->appends(request()->query())->nextPageUrl() }}" class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors">Selanjutnya</a>
                @else
                    <button class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed focus:outline-none" disabled>Selanjutnya</button>
                @endif
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
            @click.outside="modalOpen = false; hasErrors = false"
            class="w-full max-w-2xl rounded-2xl bg-white shadow-xl ring-1 ring-gray-200/50 max-h-[90vh] flex flex-col overflow-hidden"
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
                <button @click="modalOpen = false; hasErrors = false" class="rounded-lg p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition focus:outline-none">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>

            <form action="{{ route('admin.alat.store') }}" method="POST" enctype="multipart/form-data" class="flex-1 flex flex-col min-h-0" x-data="{ fileName: '' }">
                @csrf
                <div class="overflow-y-auto p-6 space-y-4 flex-1">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Nama Alat</label>
                            <input type="text" name="nama_alat" value="{{ old('nama_alat') }}" class="block w-full rounded-xl border px-4 py-2 text-sm focus:outline-none focus:ring-1 transition-colors" :class="hasErrors && {{ $errors->has('nama_alat') ? 'true' : 'false' }} ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-brand-500 focus:ring-brand-500'" placeholder="Misal: Mesin Press Cup">
                            @error('nama_alat')
                            <p x-show="hasErrors" class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Kategori</label>
                            <select name="idkategori" class="block w-full rounded-xl border px-4 py-2 text-sm focus:outline-none focus:ring-1 transition-colors" :class="hasErrors && {{ $errors->has('idkategori') ? 'true' : 'false' }} ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-brand-500 focus:ring-brand-500'">
                                <option disabled {{ old('idkategori') ? '' : 'selected' }} value="">Pilih Kategori...</option>
                                @foreach($kategoriList as $kat)
                                <option value="{{ $kat->id_kategori }}" {{ old('idkategori') == $kat->id_kategori ? 'selected' : '' }}>{{ $kat->kategori }}</option>
                                @endforeach
                            </select>
                            @error('idkategori')
                            <p x-show="hasErrors" class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Total Stok</label>
                            <input type="number" name="stok" value="{{ old('stok') }}" min="0" class="block w-full rounded-xl border px-4 py-2 text-sm focus:outline-none focus:ring-1 transition-colors" :class="hasErrors && {{ $errors->has('stok') ? 'true' : 'false' }} ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-brand-500 focus:ring-brand-500'" placeholder="0">
                            @error('stok')
                            <p x-show="hasErrors" class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Harga Sewa / Hari (Rp)</label>
                            <input type="number" name="harga_sewa" value="{{ old('harga_sewa') }}" min="0" step="1000" class="block w-full rounded-xl border px-4 py-2 text-sm focus:outline-none focus:ring-1 transition-colors" :class="hasErrors && {{ $errors->has('harga_sewa') ? 'true' : 'false' }} ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-brand-500 focus:ring-brand-500'" placeholder="50000">
                            @error('harga_sewa')
                            <p x-show="hasErrors" class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                        <textarea rows="3" name="deskripsi" class="block w-full rounded-xl border px-4 py-2 text-sm focus:outline-none focus:ring-1 transition-colors" :class="hasErrors && {{ $errors->has('deskripsi') ? 'true' : 'false' }} ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-brand-500 focus:ring-brand-500'" placeholder="Spesifikasi atau catatan khusus terkait alat ini...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
                        <p x-show="hasErrors" class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Foto Alat</label>
                        <div class="mt-1 flex justify-center rounded-xl border border-dashed px-6 py-6 transition-colors relative overflow-hidden group" :class="hasErrors && {{ $errors->has('gambar') ? 'true' : 'false' }} ? 'border-red-500 bg-red-50' : 'border-gray-300 hover:bg-gray-50'">
                            
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
                                        <input id="file-upload" name="gambar" type="file" accept="image/png, image/jpeg, image/jpg" class="sr-only" @change="fileName = $event.target.files.length ? $event.target.files[0].name : ''">
                                    </label>
                                    <p class="pl-1">atau drag and drop</p>
                                </div>
                                <p class="text-xs leading-5 text-gray-500">PNG, JPG up to 2MB</p>
                            </div>
                        </div>
                        @error('gambar')
                        <p x-show="hasErrors" class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center gap-2 border-t border-gray-100 px-6 py-4 justify-end bg-gray-50/50 rounded-b-2xl shrink-0">
                    <button type="button" @click="modalOpen = false; hasErrors = false" class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                        Batal
                    </button>
                    <button type="submit" class="rounded-xl bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 shadow-sm">
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
            @click.outside="editModalOpen = false; hasEditErrors = false"
            class="w-full max-w-2xl rounded-2xl bg-white shadow-xl ring-1 ring-gray-200/50 max-h-[90vh] flex flex-col overflow-hidden"
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
                <button type="button" @click="editModalOpen = false; hasEditErrors = false" class="rounded-lg p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition focus:outline-none">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>

            <form action="{{ route('admin.alat.update') }}" method="POST" enctype="multipart/form-data" class="flex-1 flex flex-col min-h-0" x-data="{ fileNameEdit: '' }">
                @csrf
                @method('PUT')
                <input type="hidden" name="idalat_edit" :value="editData.id">
                <div class="overflow-y-auto p-6 space-y-4 flex-1">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Nama Alat</label>
                            <input type="text" name="nama_alat" x-model="editData.nama" class="block w-full rounded-xl border px-4 py-2 text-sm focus:outline-none focus:ring-1 transition-colors" :class="hasEditErrors && {{ $errors->has('nama_alat') ? 'true' : 'false' }} ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-brand-500 focus:ring-brand-500'" placeholder="Misal: Mesin Press Cup">
                            @error('nama_alat')
                            <p x-show="hasEditErrors" class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Kategori</label>
                            <select name="idkategori" x-model="editData.kategori" class="block w-full rounded-xl border px-4 py-2 text-sm focus:outline-none focus:ring-1 transition-colors" :class="hasEditErrors && {{ $errors->has('idkategori') ? 'true' : 'false' }} ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-brand-500 focus:ring-brand-500'">
                                <option disabled value="">Pilih Kategori...</option>
                                @foreach($kategoriList as $kat)
                                <option value="{{ $kat->id_kategori }}">{{ $kat->kategori }}</option>
                                @endforeach
                            </select>
                            @error('idkategori')
                            <p x-show="hasEditErrors" class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Total Stok</label>
                            <input type="number" name="stok" x-model="editData.stok" min="0" class="block w-full rounded-xl border px-4 py-2 text-sm focus:outline-none focus:ring-1 transition-colors" :class="hasEditErrors && {{ $errors->has('stok') ? 'true' : 'false' }} ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-brand-500 focus:ring-brand-500'" placeholder="0">
                            @error('stok')
                            <p x-show="hasEditErrors" class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="mb-1 block text-sm font-medium text-gray-700">Harga Sewa / Hari (Rp)</label>
                            <input type="number" name="harga_sewa" x-model="editData.harga" min="0" step="1000" class="block w-full rounded-xl border px-4 py-2 text-sm focus:outline-none focus:ring-1 transition-colors" :class="hasEditErrors && {{ $errors->has('harga_sewa') ? 'true' : 'false' }} ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-brand-500 focus:ring-brand-500'" placeholder="50000">
                            @error('harga_sewa')
                            <p x-show="hasEditErrors" class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Deskripsi Singkat</label>
                        <textarea rows="3" name="deskripsi" x-model="editData.deskripsi" class="block w-full rounded-xl border px-4 py-2 text-sm focus:outline-none focus:ring-1 transition-colors" :class="hasEditErrors && {{ $errors->has('deskripsi') ? 'true' : 'false' }} ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : 'border-gray-300 focus:border-brand-500 focus:ring-brand-500'" placeholder="Spesifikasi..."></textarea>
                        @error('deskripsi')
                        <p x-show="hasEditErrors" class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-1 block text-sm font-medium text-gray-700">Ganti Foto Alat (Kosongkan jika tidak diganti)</label>
                        <div class="mt-1 flex justify-center rounded-xl border border-dashed px-6 py-6 transition-colors relative overflow-hidden group" :class="hasEditErrors && {{ $errors->has('gambar') ? 'true' : 'false' }} ? 'border-red-500 bg-red-50' : 'border-gray-300 hover:bg-gray-50'">
                            
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
                        @error('gambar')
                        <p x-show="hasEditErrors" class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex items-center gap-2 border-t border-gray-100 px-6 py-4 justify-end bg-gray-50/50 rounded-b-2xl shrink-0">
                    <button type="button" @click="editModalOpen = false; hasEditErrors = false" class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                        Batal
                    </button>
                    <button type="submit" name="update_alat" class="rounded-xl bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 shadow-sm">
                        Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal Filter  -->
    <div 
        x-show="filterModalOpen" 
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
            @click.outside="filterModalOpen = false"
            class="w-full max-w-md rounded-2xl bg-white shadow-xl ring-1 ring-gray-200/50 max-h-[90vh] flex flex-col overflow-hidden"
            x-show="filterModalOpen" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4 shrink-0">
                <h3 class="text-lg font-bold text-gray-800">Filter</h3>
                <button type="button" @click="filterModalOpen = false" class="rounded-lg p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition focus:outline-none">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>

            <form action="{{ route('admin.alat') }}" method="GET" class="flex-1 flex flex-col min-h-0">
                <!-- Pertahankan nilai pencarian utama -->
                <input type="hidden" name="search" value="{{ request('search') }}">

                <div class="overflow-y-auto p-6 space-y-6 flex-1">
                    <!-- Kategori -->
                    <div>
                        <label class="mb-3 block text-sm font-semibold text-gray-800">Kategori Alat</label>
                        <select name="idkategori_filter" class="w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors bg-white">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoriList as $kat)
                            <option value="{{ $kat->id_kategori }}" {{ request('idkategori_filter') == $kat->id_kategori ? 'selected' : '' }}>{{ $kat->kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Ketersediaan -->
                    <div>
                        <label class="mb-3 block text-sm font-semibold text-gray-800">Status Ketersediaan</label>
                        <div class="grid grid-cols-2 gap-3" x-data="{ stokTersedia: {{ request('stok_tersedia') ? 'true' : 'false' }}, stokHabis: {{ request('stok_habis') ? 'true' : 'false' }} }">
                            <label :class="stokTersedia ? 'border-brand-500 bg-brand-50 ring-1 ring-brand-500' : 'border-gray-200 bg-white hover:border-brand-300'" class="flex items-center justify-center gap-2 cursor-pointer rounded-xl p-3 transition-all border">
                                <input type="checkbox" name="stok_tersedia" value="1" x-model="stokTersedia" class="hidden">
                                <i class='bx' :class="stokTersedia ? 'bx-check-circle text-brand-600 text-lg' : 'bx-circle text-gray-400 text-lg'"></i>
                                <span class="text-sm font-medium" :class="stokTersedia ? 'text-brand-700' : 'text-gray-600'">Tersedia</span>
                            </label>
                            <label :class="stokHabis ? 'border-brand-500 bg-brand-50 ring-1 ring-brand-500' : 'border-gray-200 bg-white hover:border-brand-300'" class="flex items-center justify-center gap-2 cursor-pointer rounded-xl p-3 transition-all border">
                                <input type="checkbox" name="stok_habis" value="1" x-model="stokHabis" class="hidden">
                                <i class='bx' :class="stokHabis ? 'bx-check-circle text-brand-600 text-lg' : 'bx-circle text-gray-400 text-lg'"></i>
                                <span class="text-sm font-medium" :class="stokHabis ? 'text-brand-700' : 'text-gray-600'">Habis</span>
                            </label>
                        </div>
                    </div>

                    <!-- Range Harga -->
                    <div>
                        <label class="mb-3 block text-sm font-semibold text-gray-800">Range Harga Sewa / Hari</label>
                        <div class="flex items-center gap-3">
                            <div class="flex-1">
                                <div class="relative group">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm group-focus-within:text-brand-500 transition-colors">Rp</span>
                                    <input type="number" name="harga_min" value="{{ request('harga_min') }}" placeholder="Minimum" class="w-full rounded-xl border border-gray-300 pl-9 pr-3 py-2.5 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors">
                                </div>
                            </div>
                            <span class="text-gray-300 font-medium">-</span>
                            <div class="flex-1">
                                <div class="relative group">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm group-focus-within:text-brand-500 transition-colors">Rp</span>
                                    <input type="number" name="harga_max" value="{{ request('harga_max') }}" placeholder="Maksimum" class="w-full rounded-xl border border-gray-300 pl-9 pr-3 py-2.5 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between border-t border-gray-100 px-6 py-4 bg-gray-50/50 rounded-b-2xl">
                    <a href="{{ route('admin.alat') }}" class="text-sm font-medium text-gray-500 hover:text-red-500 transition-colors">Reset Filter</a>
                    <div class="flex gap-2">
                        <button type="button" @click="filterModalOpen = false" class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
                            Batal
                        </button>
                        <button type="submit" class="rounded-xl bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 shadow-sm">
                            Terapkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmDelete(id, nama) {
        Swal.fire({
            title: 'Hapus Data Alat?',
            html: `Apakah Anda yakin ingin menghapus alat <strong>${nama}</strong>?<br><span class="text-sm text-gray-500">Tindakan ini tidak dapat dibatalkan.</span>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-2xl',
                confirmButton: 'rounded-xl px-6 py-2.5 font-semibold text-white bg-red-500 hover:bg-red-600 focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-all',
                cancelButton: 'rounded-xl px-6 py-2.5 font-semibold bg-gray-100 text-gray-700 hover:bg-gray-200 focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition-all mr-3'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>
@endsection

