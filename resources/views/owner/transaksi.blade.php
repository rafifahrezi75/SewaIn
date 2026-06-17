@extends('layouts.owner')

@section('title', 'Daftar Transaksi')

@section('content')
<div x-data="{ statusModalOpen: false, statusData: { id: '', current: '' }, filterModalOpen: false, detailModalOpen: false, detailData: { items: [] } }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Transaksi</h2>
        
        <form method="GET" action="{{ route('owner.transaksi') }}" class="flex flex-wrap items-center gap-3">
            @if(request()->has('status'))
                @foreach((array)request('status') as $s)
                    <input type="hidden" name="status[]" value="{{ $s }}">
                @endforeach
            @endif
            @if(request()->has('metode_pengiriman'))
                @foreach((array)request('metode_pengiriman') as $m)
                    <input type="hidden" name="metode_pengiriman[]" value="{{ $m }}">
                @endforeach
            @endif
            @if(request()->filled('tgl_awal'))
                <input type="hidden" name="tgl_awal" value="{{ request('tgl_awal') }}">
            @endif
            @if(request()->filled('tgl_akhir'))
                <input type="hidden" name="tgl_akhir" value="{{ request('tgl_akhir') }}">
            @endif

            <div class="relative w-full sm:w-auto flex-1 sm:flex-none">
                <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg'></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari invoice atau pelanggan..." class="pl-10 pr-4 py-2 w-full sm:w-48 xl:w-64 rounded-xl border border-gray-200 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors">
            </div>
            
            <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                @if(request()->filled('search') || request()->has('status') || request()->has('metode_pengiriman') || request()->filled('tgl_awal') || request()->filled('tgl_akhir'))
                <a href="{{ route('owner.transaksi') }}" class="rounded-xl bg-red-50 text-red-600 px-4 py-2 text-sm font-medium hover:bg-red-100 transition-colors focus:outline-none border border-red-100 flex items-center justify-center">
                    Reset
                </a>
                @endif
                <button type="button" @click="filterModalOpen = true" class="rounded-xl bg-white border border-gray-200 text-gray-600 px-4 py-2 text-sm font-medium hover:bg-gray-50 transition-colors focus:outline-none flex items-center gap-2">
                    <i class='bx bx-slider-alt text-lg'></i>
                    <span class="hidden sm:inline">Filter</span>
                </button>
                <button type="submit" class="rounded-xl bg-brand-500 text-white px-4 py-2 text-sm font-medium hover:bg-brand-600 transition-colors focus:outline-none">Cari</button>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left text-sm text-gray-500 whitespace-nowrap">
                <thead class="bg-gray-50/50 text-xs uppercase text-gray-400 border-b border-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Invoice & Pelanggan</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Item Disewa</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Periode</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Metode</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Total</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($transaksi as $trx)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="block font-medium text-gray-900 border-b border-gray-100 pb-1 mb-1">INV-{{ str_pad($trx->idsewa, 4, '0', STR_PAD_LEFT) }}</span>
                            <span class="text-xs text-gray-500">{{ $trx->user->nama ?? 'Unknown' }}</span>
                        </td>
                        <td class="px-6 py-4 text-xs">
                            @if($trx->details && $trx->details->count() > 0)
                                <div class="font-medium text-gray-700">{{ $trx->details[0]->jumlah }}x {{ $trx->details[0]->alat->nama_alat ?? 'Alat' }}</div>
                                @if($trx->details->count() > 1)
                                    <div class="text-gray-400">+{{ $trx->details->count() - 1 }} Item lainnya</div>
                                @endif
                            @else
                                <div class="text-gray-400">Tidak ada item</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs">
                            <span class="block whitespace-nowrap"><i class='bx bx-calendar mr-1'></i>{{ \Carbon\Carbon::parse($trx->tanggal_mulai)->format('d M y') }} - {{ \Carbon\Carbon::parse($trx->tanggal_selesai)->format('d M y') }}</span>
                            <span class="block text-gray-400 mt-1">({{ $trx->durasi }} Hari)</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 rounded bg-gray-100 px-2 py-1 text-[10px] font-semibold text-gray-600 uppercase">
                                <i class='bx {{ str_contains(strtolower($trx->metode_pengiriman), 'antar') ? 'bx-truck' : 'bx-store' }}'></i> {{ $trx->metode_pengiriman }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900">
                            @php
                                $total_bayar = $trx->total_biaya + ($trx->pengembalian ? $trx->pengembalian->total_denda : 0);
                            @endphp
                            Rp {{ number_format($total_bayar, 0, ',', '.') }}
                            @if($trx->ongkir > 0)
                                <span class="text-[10px] text-gray-500 block font-normal">(inc. Ongkir Rp {{ number_format($trx->ongkir, 0, ',', '.') }})</span>
                            @endif
                            @if($trx->pengembalian && $trx->pengembalian->total_denda > 0)
                                <span class="text-[10px] text-red-500 block font-semibold">(inc. Denda Rp {{ number_format($trx->pengembalian->total_denda, 0, ',', '.') }})</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-orange-100 text-orange-600',
                                    'disewa' => 'bg-blue-100 text-blue-600',
                                    'selesai' => 'bg-green-100 text-green-600',
                                    'dibatalkan' => 'bg-red-100 text-red-600',
                                    'terlambat' => 'bg-red-100 text-red-600',
                                ];
                                $colorClass = $statusColors[strtolower($trx->status)] ?? 'bg-gray-100 text-gray-600';
                            @endphp
                            <span class="inline-flex items-center gap-1 rounded-full {{ $colorClass }} px-2.5 py-1 text-xs font-semibold capitalize">
                                {{ $trx->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button @click="statusData = { id: '{{ $trx->idsewa }}', current: '{{ $trx->status }}' }; statusModalOpen = true" 
                                    class="rounded-lg bg-brand-50 text-brand-600 px-3 py-1.5 text-xs font-semibold hover:bg-brand-100 transition-colors focus:outline-none border border-brand-100">
                                    Ubah Status
                                </button>
                                 <button data-detail="{{ json_encode([
                                     'idsewa' => 'INV-' . str_pad($trx->idsewa, 4, '0', STR_PAD_LEFT),
                                     'status' => $trx->status,
                                     'nama' => $trx->user->nama ?? 'Unknown',
                                     'email' => $trx->user->email ?? '-',
                                     'notelp' => $trx->user->notelp ?? '-',
                                     'tanggal_mulai' => \Carbon\Carbon::parse($trx->tanggal_mulai)->format('d M Y'),
                                     'tanggal_selesai' => \Carbon\Carbon::parse($trx->tanggal_selesai)->format('d M Y'),
                                     'durasi' => $trx->durasi . ' Hari',
                                     'metode_pengiriman' => $trx->metode_pengiriman,
                                     'alamat_sewa' => $trx->alamat_sewa,
                                     'lat_sewa' => $trx->lat_sewa,
                                     'lon_sewa' => $trx->lon_sewa,
                                     'ongkir' => $trx->ongkir,
                                     'total_denda' => $trx->pengembalian ? $trx->pengembalian->total_denda : 0,
                                     'total_biaya' => $trx->total_biaya + ($trx->pengembalian ? $trx->pengembalian->total_denda : 0),
                                     'ongkir_formatted' => 'Rp ' . number_format($trx->ongkir, 0, ',', '.'),
                                     'denda_formatted' => $trx->pengembalian && $trx->pengembalian->total_denda > 0 ? 'Rp ' . number_format($trx->pengembalian->total_denda, 0, ',', '.') : '-',
                                     'total_biaya_formatted' => 'Rp ' . number_format($trx->total_biaya + ($trx->pengembalian ? $trx->pengembalian->total_denda : 0), 0, ',', '.'),
                                     'items' => $trx->details->map(function($d) {
                                         return [
                                             'nama_alat' => $d->alat->nama_alat ?? 'Alat',
                                             'jumlah' => $d->jumlah,
                                             'harga' => 'Rp ' . number_format($d->harga, 0, ',', '.'),
                                             'subtotal' => 'Rp ' . number_format($d->subtotal, 0, ',', '.'),
                                             'gambar_ktp' => $d->gambar_ktp ? asset('storage/uploads/' . $d->gambar_ktp) : ''
                                         ];
                                     })
                                 ]) }}"
                                 @click="detailData = JSON.parse($el.getAttribute('data-detail')); detailModalOpen = true"
                                 class="rounded-lg bg-gray-50 text-gray-600 px-3 py-1.5 text-xs font-medium hover:bg-gray-100 transition-colors focus:outline-none border border-gray-200" title="Detail">
                                     <i class='bx bx-show'></i>
                                 </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <i class='bx bx-search text-4xl mb-2 text-gray-300'></i>
                                <p>Tidak ada data transaksi ditemukan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="bg-gray-50/50 p-4 border-t border-gray-100 rounded-b-2xl">
            {{ $transaksi->links('pagination::tailwind') }}
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

            <form action="{{ route('owner.transaksi.update') }}" method="POST" class="p-6 space-y-4">
                @csrf
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

    <!-- Filter Modal -->
    <div 
        x-show="filterModalOpen" 
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 p-4 backdrop-blur-sm"
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
            @click.outside="filterModalOpen = false"
            class="w-full max-w-md rounded-2xl bg-white shadow-xl ring-1 ring-gray-200/50 overflow-hidden flex flex-col max-h-[90vh]"
            x-show="filterModalOpen" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        >
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4 shrink-0">
                <h3 class="text-lg font-bold text-gray-800">Filter</h3>
                <button @click="filterModalOpen = false" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>

            <form action="{{ route('owner.transaksi') }}" method="GET" class="flex flex-col overflow-hidden">
                <!-- Keep search query if exists -->
                @if(request()->filled('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif
                
                <div class="p-6 overflow-y-auto space-y-5 flex-1">
                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">Rentang Tanggal</label>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Mulai</label>
                                <input type="date" name="tgl_awal" value="{{ request('tgl_awal') }}" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 text-gray-700">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Sampai</label>
                                <input type="date" name="tgl_akhir" value="{{ request('tgl_akhir') }}" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 text-gray-700">
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">Status Pesanan</label>
                        <div class="grid grid-cols-2 gap-2">
                            @php $statuses = ['pending' => 'Pending', 'disewa' => 'Sedang Disewa', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan', 'terlambat' => 'Terlambat']; @endphp
                            @foreach($statuses as $val => $label)
                            <label class="relative flex cursor-pointer items-center gap-2 rounded-xl border border-gray-200 p-2.5 transition hover:bg-gray-50 has-[:checked]:border-brand-500 has-[:checked]:bg-brand-50">
                                <input type="checkbox" name="status[]" value="{{ $val }}" {{ in_array($val, (array)request('status')) ? 'checked' : '' }} class="accent-brand-500 rounded text-brand-600 focus:ring-brand-500 border-gray-300">
                                <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-gray-700">Metode Pengiriman</label>
                        <div class="flex gap-2">
                            @php $metodes = ['Antar Lokasi' => 'Diantar', 'Ambil Sendiri' => 'Ambil Sendiri']; @endphp
                            @foreach($metodes as $val => $label)
                            <label class="relative flex cursor-pointer items-center gap-2 rounded-xl border border-gray-200 p-2.5 transition hover:bg-gray-50 has-[:checked]:border-brand-500 has-[:checked]:bg-brand-50 flex-1">
                                <input type="checkbox" name="metode_pengiriman[]" value="{{ $val }}" {{ in_array($val, (array)request('metode_pengiriman')) ? 'checked' : '' }} class="accent-brand-500 rounded text-brand-600 focus:ring-brand-500 border-gray-300">
                                <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="border-t border-gray-100 bg-gray-50/50 px-6 py-4 flex gap-3 justify-end shrink-0">
                    <button type="button" @click="filterModalOpen = false" class="rounded-xl border border-gray-300 bg-white px-5 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors">Batal</button>
                    <button type="submit" class="rounded-xl bg-brand-500 px-5 py-2 text-sm font-semibold text-white hover:bg-brand-600 focus:outline-none shadow-sm transition-colors">Terapkan Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Detail Transaksi -->
    <div 
        x-show="detailModalOpen" 
        class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900/50 p-4 backdrop-blur-sm"
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
            @click.outside="detailModalOpen = false"
            class="w-full max-w-4xl rounded-2xl bg-white shadow-xl ring-1 ring-gray-200/50 overflow-hidden flex flex-col max-h-[90vh]"
            x-show="detailModalOpen" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        >
            <!-- Modal Header -->
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4 bg-brand-500 text-white shrink-0">
                <div>
                    <h3 class="text-lg font-bold" x-text="'Detail Transaksi: ' + detailData.idsewa"></h3>
                    <p class="text-xs text-brand-100 mt-0.5">Periksa keaslian data user dan rincian transaksi</p>
                </div>
                <button @click="detailModalOpen = false" class="text-white/80 hover:text-white transition focus:outline-none">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="p-6 overflow-y-auto space-y-6 flex-1 bg-gray-50/50">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    
                    <!-- Left Side: User Verification & KTP -->
                    <div class="space-y-6">
                        <!-- Data Pelanggan -->
                        <div class="bg-white rounded-xl p-5 border border-gray-200/60 shadow-sm">
                            <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2 border-b border-gray-100 pb-2">
                                <i class='bx bx-user-circle text-lg text-brand-500'></i>
                                Data Pelanggan
                            </h4>
                            <div class="space-y-3 text-sm">
                                <div>
                                    <span class="text-xs text-gray-400 block">Nama Lengkap</span>
                                    <span class="font-semibold text-gray-800" x-text="detailData.nama"></span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-400 block">Email</span>
                                    <span class="font-medium text-gray-700" x-text="detailData.email"></span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-400 block">No. Telepon / WhatsApp</span>
                                    <div class="flex items-center gap-2 mt-0.5">
                                        <span class="font-semibold text-gray-800" x-text="detailData.notelp"></span>
                                        <template x-if="detailData.notelp && detailData.notelp !== '-'">
                                            <a :href="'https://wa.me/' + detailData.notelp.replace(/[^0-9]/g, '')" target="_blank" class="inline-flex items-center gap-0.5 bg-green-50 text-green-600 px-2 py-0.5 rounded text-xs font-semibold hover:bg-green-100 border border-green-100 transition-colors">
                                                <i class='bx bxl-whatsapp'></i> Chat
                                            </a>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Verifikasi Foto KTP -->
                        <div class="bg-white rounded-xl p-5 border border-gray-200/60 shadow-sm">
                            <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2 border-b border-gray-100 pb-2">
                                <i class='bx bx-id-card text-lg text-brand-500'></i>
                                Verifikasi Foto KTP
                            </h4>
                            
                            <!-- Display KTP Preview -->
                            <div class="mt-2">
                                <template x-if="detailData.items.length > 0 && detailData.items[0].gambar_ktp">
                                    <div class="space-y-2">
                                        <a :href="detailData.items[0].gambar_ktp" target="_blank" class="group relative block rounded-xl overflow-hidden border border-gray-200 bg-gray-50 hover:border-brand-500 transition-all">
                                            <img :src="detailData.items[0].gambar_ktp" alt="Foto KTP" class="w-full h-48 object-cover group-hover:scale-[1.02] transition duration-300">
                                            <div class="absolute inset-0 bg-gray-900/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white text-xs font-semibold gap-1">
                                                <i class='bx bx-zoom-in text-lg'></i> Klik untuk Memperbesar
                                            </div>
                                        </a>
                                        <p class="text-xs text-gray-400 text-center"><i class='bx bx-info-circle'></i> Pastikan foto KTP terbaca jelas dan sesuai dengan nama pelanggan.</p>
                                    </div>
                                </template>
                                <template x-if="!(detailData.items.length > 0 && detailData.items[0].gambar_ktp)">
                                    <div class="rounded-xl border border-dashed border-gray-200 bg-gray-50 py-10 flex flex-col items-center justify-center text-gray-400">
                                        <i class='bx bx-id-card text-4xl mb-2'></i>
                                        <span class="text-xs font-medium">Foto KTP Tidak Tersedia</span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Right Side: Rent Info & Costs -->
                    <div class="space-y-6">
                        <!-- Informasi Penyewaan -->
                        <div class="bg-white rounded-xl p-5 border border-gray-200/60 shadow-sm">
                            <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2 border-b border-gray-100 pb-2">
                                <i class='bx bx-info-circle text-lg text-brand-500'></i>
                                Informasi Penyewaan
                            </h4>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-xs text-gray-400 block">Status Pesanan</span>
                                    <span class="inline-flex items-center gap-1 rounded-full px-2.5 py-0.5 text-xs font-semibold capitalize mt-1"
                                          :class="{
                                              'bg-orange-100 text-orange-600': detailData.status === 'pending',
                                              'bg-blue-100 text-blue-600': detailData.status === 'disewa',
                                              'bg-green-100 text-green-600': detailData.status === 'selesai',
                                              'bg-red-100 text-red-600': detailData.status === 'dibatalkan' || detailData.status === 'terlambat'
                                          }"
                                          x-text="detailData.status">
                                    </span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-400 block">Metode Pengiriman</span>
                                    <span class="inline-flex items-center gap-1 rounded bg-gray-100 px-2 py-0.5 text-[10px] font-semibold text-gray-600 uppercase mt-1">
                                        <i class='bx' :class="detailData.metode_pengiriman && detailData.metode_pengiriman.toLowerCase().includes('antar') ? 'bx-truck' : 'bx-store'"></i>
                                        <span x-text="detailData.metode_pengiriman"></span>
                                    </span>
                                </div>
                                <div class="col-span-2">
                                    <span class="text-xs text-gray-400 block">Periode Sewa</span>
                                    <span class="font-medium text-gray-800" x-text="detailData.tanggal_mulai + ' s/d ' + detailData.tanggal_selesai"></span>
                                    <span class="text-xs text-gray-500 font-semibold block mt-0.5" x-text="'Durasi: ' + detailData.durasi"></span>
                                </div>
                                <div class="col-span-2">
                                    <span class="text-xs text-gray-400 block">Alamat Pengiriman/Ambil</span>
                                    <span class="font-medium text-gray-700 block" x-text="detailData.alamat_sewa || '-'"></span>
                                    
                                    <template x-if="detailData.lat_sewa && detailData.lon_sewa">
                                        <a :href="'https://www.google.com/maps/search/?api=1&query=' + detailData.lat_sewa + ',' + detailData.lon_sewa" target="_blank" class="inline-flex items-center gap-1 text-xs text-brand-600 hover:text-brand-700 font-semibold mt-1">
                                            <i class='bx bx-map-pin'></i> Buka Lokasi di Google Maps
                                        </a>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- Rincian Biaya -->
                        <div class="bg-white rounded-xl p-5 border border-gray-200/60 shadow-sm">
                            <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2 border-b border-gray-100 pb-2">
                                <i class='bx bx-receipt text-lg text-brand-500'></i>
                                Rincian Biaya
                            </h4>
                            
                            <!-- Items List -->
                            <div class="space-y-3 mb-4 max-h-48 overflow-y-auto pr-1">
                                <template x-for="item in detailData.items">
                                    <div class="flex items-start justify-between text-sm gap-2">
                                        <div>
                                            <span class="font-medium text-gray-800 block" x-text="item.nama_alat"></span>
                                            <span class="text-xs text-gray-400" x-text="item.jumlah + ' unit x ' + item.harga + ' / hari'"></span>
                                        </div>
                                        <span class="font-semibold text-gray-800" x-text="item.subtotal"></span>
                                    </div>
                                </template>
                            </div>

                            <!-- Cost Breakdown -->
                            <div class="border-t border-gray-100 pt-3 space-y-2 text-sm">
                                <div class="flex justify-between text-gray-500">
                                    <span>Ongkos Kirim</span>
                                    <span x-text="detailData.ongkir_formatted"></span>
                                </div>
                                <template x-if="detailData.total_denda > 0">
                                    <div class="flex justify-between text-red-500 font-semibold">
                                        <span>Total Denda</span>
                                        <span x-text="detailData.denda_formatted"></span>
                                    </div>
                                </template>
                                <div class="flex justify-between text-base font-bold text-brand-600 border-t border-dashed border-gray-100 pt-2">
                                    <span>Total Biaya</span>
                                    <span x-text="detailData.total_biaya_formatted"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="border-t border-gray-100 bg-gray-50 px-6 py-4 flex justify-end shrink-0">
                <button type="button" @click="detailModalOpen = false" class="rounded-xl border border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection
