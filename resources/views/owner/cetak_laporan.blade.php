@extends('layouts.owner')

@section('title', 'Cetak Laporan')

@section('content')
<div x-data="{ filterModalOpen: false }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Cetak Laporan</h2>
        
        <form id="filterForm" method="GET" action="{{ route('owner.cetak_laporan') }}" class="flex flex-wrap items-center gap-3">
            @if(request()->filled('tgl_awal'))
                <input type="hidden" name="tgl_awal" value="{{ request('tgl_awal') }}">
            @endif
            @if(request()->filled('tgl_akhir'))
                <input type="hidden" name="tgl_akhir" value="{{ request('tgl_akhir') }}">
            @endif

            <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                @if(request()->filled('tgl_awal') || request()->filled('tgl_akhir'))
                <a href="{{ route('owner.cetak_laporan') }}" class="rounded-xl bg-red-50 text-red-600 px-4 py-2 text-sm font-medium hover:bg-red-100 transition-colors focus:outline-none border border-red-100 flex items-center justify-center">
                    Reset Filter
                </a>
                @endif
                <button type="button" @click="filterModalOpen = true" class="rounded-xl bg-white border border-gray-200 text-gray-600 px-4 py-2 text-sm font-medium hover:bg-gray-50 transition-colors focus:outline-none flex items-center gap-2">
                    <i class='bx bx-calendar text-lg'></i>
                    <span class="hidden sm:inline">Pilih Tanggal</span>
                </button>
                <a href="{{ request()->fullUrlWithQuery(['print' => 1]) }}" target="_blank" class="rounded-xl bg-brand-500 text-white px-4 py-2 text-sm font-medium hover:bg-brand-600 transition-colors focus:outline-none flex items-center gap-2 shadow-sm">
                    <i class='bx bxs-file-pdf text-lg'></i>
                    Cetak PDF
                </a>
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
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Total Biaya</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Status</th>
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
                        <td class="px-6 py-4 font-medium text-gray-900">
                            Rp {{ number_format($trx->total_biaya, 0, ',', '.') }}
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
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <i class='bx bx-file text-4xl mb-2 text-gray-300'></i>
                                <p>Tidak ada data laporan pada periode ini.</p>
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
            class="w-full max-w-sm rounded-2xl bg-white shadow-xl ring-1 ring-gray-200/50 overflow-hidden flex flex-col"
            x-show="filterModalOpen" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        >
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                <h3 class="text-lg font-bold text-gray-800">Filter Tanggal</h3>
                <button @click="filterModalOpen = false" class="text-gray-400 hover:text-gray-600 focus:outline-none">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>

            <form action="{{ route('owner.cetak_laporan') }}" method="GET" class="flex flex-col">
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal Mulai</label>
                        <input type="date" name="tgl_awal" value="{{ request('tgl_awal') }}" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 text-gray-700">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal Sampai</label>
                        <input type="date" name="tgl_akhir" value="{{ request('tgl_akhir') }}" class="w-full rounded-xl border border-gray-200 bg-gray-50 px-3 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 text-gray-700">
                    </div>
                </div>

                <div class="border-t border-gray-100 bg-gray-50/50 px-6 py-4 flex gap-3 justify-end">
                    <button type="button" @click="filterModalOpen = false" class="rounded-xl border border-gray-300 bg-white px-5 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors">Batal</button>
                    <button type="submit" class="rounded-xl bg-brand-500 px-5 py-2 text-sm font-semibold text-white hover:bg-brand-600 focus:outline-none shadow-sm transition-colors">Terapkan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
