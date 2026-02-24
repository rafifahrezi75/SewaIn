@extends('layouts.admin')

@section('title', 'Pelanggan UMKM')

@section('content')
<div>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
        <h2 class="text-2xl font-bold text-gray-800">Data Pelanggan UMKM</h2>
        
        <div class="flex items-center gap-3">
            <div class="relative">
                <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg'></i>
                <input type="text" placeholder="Cari nama restoran..." class="pl-10 pr-4 py-2 w-full sm:w-64 rounded-xl border border-gray-200 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors">
            </div>
            
            <button class="flex shrink-0 items-center gap-2 rounded-xl bg-white border border-gray-200 px-4 py-2 text-sm font-medium text-gray-700 transition-all hover:bg-gray-50 focus:outline-none shadow-sm">
                <i class='bx bx-export text-lg text-gray-500'></i>
                <span class="hidden sm:inline">Export</span>
            </button>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left text-sm text-gray-500">
                <thead class="bg-gray-50/50 text-xs uppercase text-gray-400 border-b border-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Nama UMKM / Owner</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Kontak</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Alamat Lengkap</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Bergabung</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 shrink-0 rounded-full bg-orange-100 text-orange-600 font-bold flex items-center justify-center">
                                    RM
                                </div>
                                <div>
                                    <span class="block font-medium text-gray-900">RM Salero Kita</span>
                                    <span class="text-xs text-gray-500">Bpk. Haryanto</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-xs">
                            <i class='bx bx-phone mr-1 text-gray-400'></i> 0812-3456-7890<br>
                            <span class="text-gray-400 mt-1 block">salero@gmail.com</span>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-600 max-w-xs truncate" title="Jl. Jendral Sudirman No.45, Kecamatan Pusat Kota, Kota Maju">
                            Jl. Jendral Sudirman No.45, Ke...
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-500">
                            10 Jan 2026
                        </td>
                    </tr>
                    
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 shrink-0 rounded-full bg-blue-100 text-blue-600 font-bold flex items-center justify-center">
                                    KS
                                </div>
                                <div>
                                    <span class="block font-medium text-gray-900">Kafe Senja</span>
                                    <span class="text-xs text-gray-500">Ibu Dian Ayu</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-xs">
                            <i class='bx bx-phone mr-1 text-gray-400'></i> 0857-1234-9090<br>
                            <span class="text-gray-400 mt-1 block">dian@senja.co.id</span>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-600 max-w-xs truncate" title="Jl. Mawar Raya Ruko Blok C2">
                            Jl. Mawar Raya Ruko Blok C2
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-500">
                            18 Feb 2026
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        
        <div class="bg-gray-50/50 p-4 sm:flex sm:items-center sm:justify-between border-t border-gray-100 rounded-b-2xl">
            <p class="text-sm text-gray-500">Menampilkan <span class="font-medium text-gray-700">1</span> sampai <span class="font-medium text-gray-700">2</span> dari <span class="font-medium text-gray-700">128</span> pelanggan</p>
        </div>
    </div>
</div>
@endsection
