@extends('layouts.admin')

@section('title', 'Pelanggan')

@section('content')
<div>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Data Pelanggan</h2>
        
        <form method="GET" action="{{ route('admin.pelanggan') }}" class="flex flex-wrap items-center gap-3">
            <div class="relative w-full sm:w-auto flex-1 sm:flex-none">
                <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg'></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." class="pl-10 pr-4 py-2 w-full sm:w-64 rounded-xl border border-gray-200 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors">
            </div>
            
            <div class="flex items-center gap-2 w-full sm:w-auto justify-end">
                @if(request()->filled('search'))
                <a href="{{ route('admin.pelanggan') }}" class="rounded-xl bg-red-50 text-red-600 px-4 py-2 text-sm font-medium hover:bg-red-100 transition-colors focus:outline-none border border-red-100 flex items-center justify-center">
                    Reset
                </a>
                @endif
                <button type="submit" class="rounded-xl bg-gray-100 text-gray-600 px-4 py-2 text-sm font-medium hover:bg-gray-200 transition-colors focus:outline-none">Cari</button>
                <a href="{{ route('admin.pelanggan.export', request()->query()) }}" class="flex shrink-0 items-center gap-2 rounded-xl bg-white border border-gray-200 px-4 py-2 text-sm font-medium text-gray-700 transition-all hover:bg-gray-50 focus:outline-none shadow-sm">
                    <i class='bx bx-export text-lg text-gray-500'></i>
                    <span class="hidden sm:inline">Export</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left text-sm text-gray-500">
                <thead class="bg-gray-50/50 text-xs uppercase text-gray-400 border-b border-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Nama Pelanggan</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Kontak</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Alamat Lengkap</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Bergabung</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($pelangganList as $pelanggan)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 shrink-0 rounded-full bg-orange-100 text-orange-600 font-bold flex items-center justify-center">
                                    {{ strtoupper(substr($pelanggan->nama, 0, 2)) }}
                                </div>
                                <div>
                                    <span class="block font-medium text-gray-900">{{ $pelanggan->nama }}</span>
                                    <span class="text-xs text-gray-500">ID: PLG-{{ str_pad($pelanggan->id_user, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-xs">
                            <i class='bx bx-phone mr-1 text-gray-400'></i> {{ $pelanggan->notelp ?? '-' }}<br>
                            <span class="text-gray-400 mt-1 block">{{ $pelanggan->email }}</span>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-600 max-w-xs truncate" title="{{ $pelanggan->alamat }}">
                            {{ $pelanggan->alamat ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-500">
                            {{ $pelanggan->created_at ? $pelanggan->created_at->format('d M Y') : '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada data pelanggan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="bg-gray-50/50 p-4 sm:flex sm:items-center sm:justify-between border-t border-gray-100 rounded-b-2xl">
            <p class="text-sm text-gray-500">
                Menampilkan <span class="font-medium text-gray-700">{{ $pelangganList->firstItem() ?? 0 }}</span> 
                sampai <span class="font-medium text-gray-700">{{ $pelangganList->lastItem() ?? 0 }}</span> 
                dari <span class="font-medium text-gray-700">{{ $pelangganList->total() }}</span> pelanggan
            </p>
            <div class="mt-4 sm:mt-0 flex gap-2">
                @if ($pelangganList->onFirstPage())
                    <button class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed focus:outline-none" disabled>Sebelumnya</button>
                @else
                    <a href="{{ $pelangganList->appends(request()->query())->previousPageUrl() }}" class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors">Sebelumnya</a>
                @endif

                @if ($pelangganList->hasMorePages())
                    <a href="{{ $pelangganList->appends(request()->query())->nextPageUrl() }}" class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors">Selanjutnya</a>
                @else
                    <button class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed focus:outline-none" disabled>Selanjutnya</button>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
