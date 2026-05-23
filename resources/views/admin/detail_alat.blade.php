@extends('layouts.admin')

@section('title', 'Detail Alat - ' . $data->nama_alat)

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div x-data="{ 
    modalTambah: false, 
    modalEdit: false, 
    editData: { id: '', spek: '', iconspek: '', satuan: '' }, 
    modalFoto: false, 
    fotoPreview: '', 
    fotoName: '' 
}">

    <!-- Back Button & Breadcrumbs -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4 text-left">
        <a href="{{ route('admin.alat') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-brand-600 transition-colors bg-white px-4 py-2 rounded-xl shadow-sm border border-gray-100">
            <i class="bx bx-left-arrow-alt text-xl"></i>
            Kembali ke Daftar Alat
        </a>
        <nav class="text-xs text-gray-400 flex items-center gap-1.5 justify-end">
            <span>Admin</span><i class='bx bx-chevron-right'></i>
            <a href="{{ route('admin.alat') }}" class="hover:text-brand-500 transition-colors">Alat Produksi</a><i class='bx bx-chevron-right'></i>
            <span class="text-gray-700 font-semibold">{{ $data->nama_alat }}</span>
        </nav>
    </div>

    <!-- ===== HERO DETAIL CARD ===== -->
    <div class="bg-white rounded-3xl shadow-sm ring-1 ring-gray-100 overflow-hidden mb-6 text-left">
        <!-- Top gradient strip -->
        <div class="h-1.5 w-full bg-gradient-to-r from-brand-400 via-brand-500 to-brand-600"></div>

        <div class="flex flex-col md:flex-row">
            <!-- Image Section -->
            <div class="md:w-1/2 relative isolate flex items-center justify-center aspect-square bg-gradient-to-br from-gray-50 to-gray-100 border-r border-gray-100 overflow-hidden p-8">
                <!-- Decorative circle -->
                <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="h-56 w-56 rounded-full bg-brand-100/30"></div>
                </div>

                @if ($data->gambar)
                    <img src="{{ asset('storage/' . $data->gambar) }}" 
                        alt="{{ $data->nama_alat }}" 
                        class="relative z-10 w-[240px] aspect-square object-cover mx-auto rounded-2xl shadow-lg transition-transform duration-300 hover:scale-105">
                @else
                    <div class="relative z-10 flex flex-col items-center text-gray-300">
                        <i class="bx bx-image text-8xl"></i>
                        <span class="text-sm font-medium mt-2 text-gray-400">Tidak ada gambar</span>
                    </div>
                @endif
            </div>

            <!-- Info Section -->
            <div class="md:w-1/2 p-8 lg:p-12 flex flex-col gap-6 bg-white justify-between">
                <div class="space-y-4">
                    <div>
                        <span class="inline-flex items-center gap-2.5 bg-blue-50 border border-blue-200 rounded-xl px-3.5 py-1.5 text-[11px] font-bold text-blue-700 tracking-widest uppercase shadow-sm">
                            <span class="inline-flex items-center justify-center w-5.5 h-5.5 bg-blue-100 rounded-full shrink-0">
                                <i class='bx {{ $data->kategori && $data->kategori->icon ? $data->kategori->icon : "bx-layer" }} text-[13px] text-blue-600'></i>
                            </span>
                            {{ $data->kategori ? $data->kategori->kategori : 'Umum' }}
                        </span>
                    </div>

                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight leading-[1.1]">
                        {{ $data->nama_alat }}
                    </h2>
                    
                    <div class="inline-flex flex-col">
                        <div class="flex items-baseline gap-1">
                            <span class="text-sm font-bold text-brand-400 uppercase tracking-tighter">Rp</span>
                            <span class="text-3xl font-black text-gray-900 tracking-tight">
                                {{ number_format($data->harga_sewa, 0, ',', '.') }}
                            </span>
                            <span class="text-gray-400 font-medium ml-1">/ hari</span>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="group relative overflow-hidden rounded-2xl bg-gray-50 border border-gray-100 p-5 transition-all hover:border-brand-200 hover:bg-white hover:shadow-xl hover:shadow-brand-500/5">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 rounded-lg bg-white shadow-sm group-hover:bg-brand-500 group-hover:text-white transition-colors">
                                <i class='bx bx-package text-xl text-brand-500 group-hover:text-white'></i>
                            </div>
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.1em]">Total Stok</span>
                        </div>
                        <p class="text-2xl font-black text-gray-800">
                            {{ $data->stok }} <span class="text-xs font-bold text-gray-400 -ml-1">Unit</span>
                        </p>
                    </div>

                    <div class="group relative overflow-hidden rounded-2xl {{ $data->status == 'tersedia' ? 'bg-emerald-50/50 border-emerald-100' : 'bg-red-50/50 border-red-100' }} border p-5 transition-all hover:shadow-lg">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 rounded-lg bg-white shadow-sm">
                                <i class='bx {{ $data->status == "tersedia" ? "bx-check-double text-emerald-500" : "bx-time-five text-red-500" }} text-xl'></i>
                            </div>
                            <span class="text-[10px] font-bold {{ $data->status == 'tersedia' ? 'text-emerald-500' : 'text-red-400' }} uppercase tracking-[0.1em]">Ketersediaan</span>
                        </div>
                        <p class="text-xl font-black {{ $data->status == 'tersedia' ? 'text-emerald-700' : 'text-red-700' }} uppercase tracking-tighter">
                            {{ $data->status == 'tersedia' ? 'Tersedia' : 'Kosong' }}
                        </p>
                    </div>
                </div>

                <div class="relative group">
                    <div class="relative rounded-2xl border border-gray-100 bg-white p-5 shadow-sm">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="flex h-8 w-8 items-center justify-center rounded-xl bg-brand-500 text-white shadow-lg shadow-brand-200">
                                <i class='bx bx-align-left text-sm'></i>
                            </span>
                            <h3 class="font-bold text-gray-800 tracking-tight text-sm">Deskripsi Detail</h3>
                        </div>
                        <p class="leading-[1.8] text-xs text-gray-500">
                            {!! nl2br(htmlspecialchars($data->deskripsi)) !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== SPECIFICATIONS TABLE SECTION ===== -->
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden mb-6 text-left">
        <!-- Table Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div>
                <div class="flex items-center gap-2">
                    <h3 class="text-base font-bold text-gray-800">Spesifikasi Teknis</h3>
                    <span class="rounded-full bg-gray-100 px-2 py-0.5 text-[10px] font-bold text-red-400 uppercase tracking-tighter border border-gray-200">Maks 4</span>
                </div>
                <p class="text-xs text-gray-400 mt-0.5">Detail spesifikasi {{ $data->nama_alat }}</p>
            </div>
            @if ($num_spek < 4)
            <button @click="modalTambah = true" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 transition-all shadow-sm focus:outline-none">
                <i class='bx bx-plus text-lg'></i>
                <span>Tambah Spek</span>
            </button>
            @else
            <div class="inline-flex items-center gap-2 rounded-xl bg-gray-100 px-4 py-2 text-sm font-medium text-red-400 cursor-not-allowed border border-gray-200">
                <i class='bx bx-plus text-lg'></i>
                <span>Penuh (Max 4)</span>
            </div>
            @endif
        </div>

        <!-- Spek Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-500">
                <thead class="bg-gray-50/50 text-xs uppercase text-gray-400 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3 font-semibold tracking-wider w-10">#</th>
                        <th class="px-6 py-3 font-semibold tracking-wider">Spesifikasi</th>
                        <th class="px-6 py-3 font-semibold tracking-wider">Satuan / Nilai</th>
                        <th class="px-6 py-3 font-semibold tracking-wider text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 bg-white">
                    @forelse ($data->spesifikasi as $spek)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-3 text-gray-400 font-medium">{{ $loop->iteration }}</td>
                        <td class="px-6 py-3">
                            <div class="flex items-center gap-3">
                                @if(!empty($spek->iconspek))
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-brand-50 text-brand-500">
                                        <i class="bx {{ $spek->iconspek }} text-lg"></i>
                                    </span>
                                @else
                                    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-gray-100 text-gray-400">
                                        <i class="bx bx-file text-lg"></i>
                                    </span>
                                @endif
                                <span class="font-semibold text-gray-700">{{ $spek->spek }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-3">
                            <span class="inline-block rounded-lg bg-brand-50 border border-brand-100 px-3 py-1 text-xs font-bold text-brand-600">
                                {{ $spek->satuan }}
                            </span>
                        </td>
                        <td class="px-6 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" @click="editData = { id: '{{ $spek->id_spek }}', spek: '{{ addslashes($spek->spek) }}', iconspek: '{{ addslashes($spek->iconspek ?? '') }}', satuan: '{{ addslashes($spek->satuan) }}' }; modalEdit = true" class="rounded-lg p-2 text-blue-500 bg-blue-50 hover:bg-blue-100 transition-colors focus:outline-none" title="Edit">
                                    <i class='bx bx-edit text-lg'></i>
                                </button>
                                <form id="delete-spec-form-{{ $spek->id_spek }}" action="{{ route('admin.spesifikasi.destroy', $spek->id_spek) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button type="button" onclick="confirmDeleteSpec('{{ $spek->id_spek }}', '{{ addslashes($spek->spek) }}')" class="rounded-lg p-2 text-red-500 bg-red-50 hover:bg-red-100 transition-colors focus:outline-none" title="Hapus">
                                    <i class='bx bx-trash text-lg'></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-400">
                            <div class="flex flex-col items-center gap-2">
                                <i class='bx bx-list-ul text-4xl text-gray-300'></i>
                                <span class="text-sm">Belum ada spesifikasi. Klik <strong class="text-brand-500">+ Tambah Spek</strong> untuk memulai.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ===== DETAILED PHOTOS SECTION ===== -->
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden mb-6 text-left">
        <!-- Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <div>
                <div class="flex items-center gap-2">
                    <h3 class="text-base font-bold text-gray-800">Foto Tambahan</h3>
                    <span class="rounded-full bg-gray-100 px-2 py-0.5 text-[10px] font-bold text-red-400 uppercase tracking-tighter border border-gray-200">Maks 5</span>
                </div>
                <p class="text-xs text-gray-400 mt-0.5">Galeri foto detail {{ $data->nama_alat }}</p>
            </div>
            @if ($num_foto < 5)
            <button @click="modalFoto = true" class="inline-flex items-center gap-2 rounded-xl bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 transition-all shadow-sm focus:outline-none">
                <i class='bx bx-image-add text-lg'></i>
                <span>Tambah Foto</span>
            </button>
            @else
            <div class="inline-flex items-center gap-2 rounded-xl bg-gray-100 px-4 py-2 text-sm font-medium text-red-400 cursor-not-allowed border border-gray-200">
                <i class='bx bx-image-add text-lg'></i>
                <span>Penuh (Max 5)</span>
            </div>
            @endif
        </div>

        <!-- Photo Grid -->
        <div class="p-6">
            @if (count($data->fotoDetail) > 0)
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach ($data->fotoDetail as $foto)
                @php
                    $src = str_starts_with($foto->fotodetail, 'uploads/') ? asset('storage/' . $foto->fotodetail) : asset('storage/uploads/' . $foto->fotodetail);
                @endphp
                <div class="relative overflow-hidden rounded-2xl bg-gray-100 aspect-square shadow-sm border border-gray-100 group">
                    <img src="{{ $src }}"
                         alt="Foto Detail"
                         class="w-full h-full object-cover block">

                    <!-- Expand button -->
                    <a href="{{ $src }}" target="_blank"
                       title="Lihat Asli"
                       class="absolute top-3 left-3 z-20 w-8 h-8 flex items-center justify-center bg-gray-900/60 rounded-xl text-white shadow-md transition-all hover:scale-110">
                        <i class='bx bx-expand-alt text-base'></i>
                    </a>

                    <!-- Hapus button -->
                    <form id="delete-foto-form-{{ $foto->id_foto }}" action="{{ route('admin.fotodetail.destroy', $foto->id_foto) }}" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                    <button type="button" onclick="confirmDeleteFoto('{{ $foto->id_foto }}')"
                            title="Hapus Foto"
                            class="absolute top-3 right-3 z-20 w-8 h-8 flex items-center justify-center bg-red-600/80 rounded-xl text-white shadow-sm transition-all hover:scale-110 cursor-pointer">
                        <i class='bx bx-trash text-base'></i>
                    </button>
                </div>
                @endforeach
            </div>
            @else
            <div class="flex flex-col items-center justify-center py-14 text-gray-300">
                <i class='bx bx-image text-6xl mb-3'></i>
                <p class="text-sm font-medium text-gray-400">Belum ada foto tambahan.</p>
                <p class="text-xs text-gray-300 mt-1">Klik <strong class="text-brand-500">+ Tambah Foto</strong> untuk mengunggah.</p>
            </div>
            @endif
        </div>
    </div>

    <!-- MODAL TAMBAH SPEK -->
    <div x-show="modalTambah"
         class="fixed inset-0 z-[60] flex items-center justify-center bg-gray-900/50 p-4 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         style="display: none;"
         x-cloak>
        <div @click.outside="modalTambah = false"
             class="w-full max-w-md rounded-2xl bg-white shadow-xl ring-1 ring-gray-200/50"
             x-show="modalTambah"
             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                <h3 class="text-base font-bold text-gray-800">Tambah Spesifikasi</h3>
                <button @click="modalTambah = false" class="rounded-lg p-1 text-gray-400 hover:bg-gray-100 transition focus:outline-none">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>
            <form action="{{ route('admin.spesifikasi.store') }}" method="POST" class="p-6 space-y-4 text-left">
                @csrf
                <input type="hidden" name="idalat" value="{{ $data->idalat }}">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700">Nama Spesifikasi</label>
                    <input type="text" name="spek" required placeholder="Contoh: Daya Listrik, Berat, Dimensi..." class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700">Icon Boxicons <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <input type="text" name="iconspek" placeholder="Contoh: bx-bolt-circle, bx-chip, bx-cog" class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500">
                    <p class="mt-1 text-[11px] text-gray-400">Cari nama icon di <a href="https://boxicons.com/icons?free=true" target="_blank" class="text-brand-500 underline">boxicons.com</a></p>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700">Satuan / Nilai</label>
                    <input type="text" name="satuan" required placeholder="Contoh: 220V, 5 kg, 30x40 cm..." class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500">
                </div>
                <div class="flex gap-3 justify-end pt-2">
                    <button type="button" @click="modalTambah = false" class="rounded-xl border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">Batal</button>
                    <button type="submit" class="rounded-xl bg-brand-500 px-5 py-2 text-sm font-medium text-white hover:bg-brand-600 shadow-sm focus:outline-none">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT SPEK -->
    <div x-show="modalEdit"
         class="fixed inset-0 z-[60] flex items-center justify-center bg-gray-900/50 p-4 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         style="display: none;"
         x-cloak>
        <div @click.outside="modalEdit = false"
             class="w-full max-w-md rounded-2xl bg-white shadow-xl ring-1 ring-gray-200/50"
             x-show="modalEdit"
             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                <h3 class="text-base font-bold text-gray-800">Edit Spesifikasi</h3>
                <button @click="modalEdit = false" class="rounded-lg p-1 text-gray-400 hover:bg-gray-100 transition focus:outline-none">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>
            <form action="{{ route('admin.spesifikasi.update') }}" method="POST" class="p-6 space-y-4 text-left">
                @csrf
                @method('PUT')
                <input type="hidden" name="idspek" :value="editData.id">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700">Nama Spesifikasi</label>
                    <input type="text" name="spek" :value="editData.spek" x-model="editData.spek" required placeholder="Contoh: Daya Listrik..." class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500">
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700">Icon Boxicons <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <input type="text" name="iconspek" :value="editData.iconspek" x-model="editData.iconspek" placeholder="Contoh: bx-bolt-circle, bx-chip, bx-cog" class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500">
                    <p class="mt-1 text-[11px] text-gray-400">Cari nama icon di <a href="https://boxicons.com/icons?free=true" target="_blank" class="text-brand-500 underline">boxicons.com</a></p>
                </div>
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700">Satuan / Nilai</label>
                    <input type="text" name="satuan" :value="editData.satuan" x-model="editData.satuan" required placeholder="Contoh: 220V..." class="block w-full rounded-xl border border-gray-300 px-4 py-2.5 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500">
                </div>
                <div class="flex gap-3 justify-end pt-2">
                    <button type="button" @click="modalEdit = false" class="rounded-xl border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">Batal</button>
                    <button type="submit" class="rounded-xl bg-brand-500 px-5 py-2 text-sm font-medium text-white hover:bg-brand-600 shadow-sm focus:outline-none">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL TAMBAH FOTO -->
    <div x-show="modalFoto"
         class="fixed inset-0 z-[60] flex items-center justify-center bg-gray-900/50 p-4 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         style="display: none;"
         x-cloak>
        <div @click.outside="modalFoto = false"
             class="w-full max-w-md rounded-2xl bg-white shadow-xl ring-1 ring-gray-200/50"
             x-show="modalFoto"
             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95">
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                <h3 class="text-base font-bold text-gray-800">Unggah Foto Detail</h3>
                <button @click="modalFoto = false" class="rounded-lg p-1 text-gray-400 hover:bg-gray-100 transition focus:outline-none">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>
            <form action="{{ route('admin.fotodetail.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 text-left">
                @csrf
                <input type="hidden" name="idalat" value="{{ $data->idalat }}">
                <div>
                    <label class="mb-1.5 block text-sm font-medium text-gray-700">Pilih File Gambar</label>
                    <div class="mt-1 flex justify-center rounded-xl border border-dashed border-gray-300 px-6 py-8 hover:bg-gray-50 transition-colors relative overflow-hidden group">
                        <!-- File Upload input -->
                        <div class="text-center">
                            <i class='bx bx-image-add text-4xl text-gray-400'></i>
                            <div class="mt-4 flex text-sm leading-6 text-gray-600 justify-center">
                                <label class="relative cursor-pointer rounded-md bg-transparent font-semibold text-brand-500 hover:text-brand-600">
                                    <span>Upload gambar</span>
                                    <input name="fotodetail" type="file" required accept="image/*" class="sr-only" @change="fotoName = $event.target.files.length ? $event.target.files[0].name : ''; if ($event.target.files.length) { const r = new FileReader(); r.onload = (e) => fotoPreview = e.target.result; r.readAsDataURL($event.target.files[0]) }">
                                </label>
                            </div>
                            <p class="text-xs leading-5 text-gray-500">PNG, JPG, WEBP up to 3MB</p>
                        </div>

                        <!-- Preview Area -->
                        <div x-show="fotoPreview" class="absolute inset-0 bg-white flex flex-col items-center justify-center p-3" x-cloak>
                            <img :src="fotoPreview" class="max-h-24 rounded-lg shadow-md mb-2">
                            <p class="text-xs text-gray-500 font-bold max-w-[200px] truncate" x-text="fotoName"></p>
                            <button type="button" @click="fotoPreview = ''; fotoName = ''" class="mt-2 text-xs text-red-500 hover:underline">Hapus Pilihan</button>
                        </div>
                    </div>
                </div>
                <div class="flex gap-3 justify-end pt-2">
                    <button type="button" @click="modalFoto = false" class="rounded-xl border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">Batal</button>
                    <button type="submit" class="rounded-xl bg-brand-500 px-5 py-2 text-sm font-medium text-white hover:bg-brand-600 shadow-sm focus:outline-none">Unggah</button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    // SweetAlert alerts mapping
    document.addEventListener('DOMContentLoaded', () => {
        @if (session('pesan'))
            const pesan = "{{ session('pesan') }}";
            if (pesan === 'berhasil_tambah_spek') {
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Spesifikasi berhasil ditambahkan.', confirmButtonColor: '#3b82f6', timer: 3000, timerProgressBar: true });
            } else if (pesan === 'gagal_tambah_spek') {
                Swal.fire({ icon: 'error', title: 'Oops...', text: 'Gagal menambahkan spesifikasi.', confirmButtonColor: '#ef4444' });
            } else if (pesan === 'berhasil_update_spek') {
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Spesifikasi berhasil diperbarui.', confirmButtonColor: '#3b82f6', timer: 3000, timerProgressBar: true });
            } else if (pesan === 'gagal_update_spek') {
                Swal.fire({ icon: 'error', title: 'Oops...', text: 'Gagal memperbarui spesifikasi.', confirmButtonColor: '#ef4444' });
            } else if (pesan === 'berhasil_hapus_spek') {
                Swal.fire({ icon: 'success', title: 'Terhapus!', text: 'Spesifikasi berhasil dihapus.', confirmButtonColor: '#3b82f6', timer: 3000, timerProgressBar: true });
            } else if (pesan === 'gagal_hapus_spek') {
                Swal.fire({ icon: 'error', title: 'Oops...', text: 'Gagal menghapus spesifikasi.', confirmButtonColor: '#ef4444' });
            } else if (pesan === 'berhasil_tambah_foto') {
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Foto berhasil diunggah.', confirmButtonColor: '#3b82f6', timer: 3000, timerProgressBar: true });
            } else if (pesan === 'gagal_tambah_foto') {
                Swal.fire({ icon: 'error', title: 'Gagal!', text: 'Foto gagal diunggah. Pastikan format dan ukuran file sesuai (maks 3MB).', confirmButtonColor: '#ef4444' });
            } else if (pesan === 'berhasil_hapus_foto') {
                Swal.fire({ icon: 'success', title: 'Terhapus!', text: 'Foto berhasil dihapus.', confirmButtonColor: '#3b82f6', timer: 3000, timerProgressBar: true });
            } else if (pesan === 'gagal_hapus_foto') {
                Swal.fire({ icon: 'error', title: 'Oops...', text: 'Gagal menghapus foto.', confirmButtonColor: '#ef4444' });
            }
        @endif
    });

    function confirmDeleteSpec(idspek, nama) {
        Swal.fire({
            title: 'Hapus Spesifikasi?',
            html: `Spesifikasi <strong>${nama}</strong> akan dihapus permanen.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-spec-form-' + idspek).submit();
            }
        });
    }

    function confirmDeleteFoto(idfoto) {
        Swal.fire({
            title: 'Hapus Foto?',
            text: 'Foto detail ini akan dihapus permanen.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-foto-form-' + idfoto).submit();
            }
        });
    }
</script>
@endsection
