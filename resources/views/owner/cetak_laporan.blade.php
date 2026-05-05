@extends('layouts.owner')

@section('title', 'Cetak Laporan')

@section('content')
<style>
    @media print {
        /* Hide navbar, sidebar, footer, and no-print elements */
        aside, header, footer, .no-print { display: none !important; }
        
        /* Reset body and wrapper margins/paddings for printing */
        body { background-color: white !important; margin: 0; padding: 0; }
        main { overflow: visible !important; height: auto !important; padding: 0 !important; }
        
        /* Overwrite Tailwind flex-h-screen wrappers */
        .flex-1 { flex: none !important; }
        .overflow-hidden { overflow: visible !important; }
        .h-screen { height: auto !important; }
        .bg-\[\#f8f9fa\] { background-color: white !important; }

        /* Print area styles */
        .print-area { 
            border: none !important; 
            box-shadow: none !important; 
            max-width: 100% !important; 
            margin: 0 !important; 
            padding: 0 !important; 
        }
    }
</style>

<div class="no-print max-w-6xl mx-auto mb-6">
    <div class="bg-white p-6 rounded-3xl shadow-sm ring-1 ring-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
        <div>
            <a href="{{ url('owner/dashboard') }}" class="group flex items-center gap-2 mb-1 transition-all">
                <i class='bx bx-left-arrow-alt text-2xl text-brand-500 group-hover:-translate-x-1 transition-transform'></i>
                <h1 class="text-lg font-bold italic text-gray-800 uppercase tracking-tight">
                    Cetak Laporan Penjualan
                </h1>
            </a>
        </div>

        <form method="GET" class="flex flex-wrap gap-2">
            <select name="bulan" class="rounded-xl border border-gray-200 bg-gray-50 text-sm focus:ring-brand-500 font-medium px-3 py-2 outline-none">
                <option value="">Semua Bulan</option>
                <option value="01">Januari</option>
                <option value="02">Februari</option>
                <option value="03">Maret</option>
                <option value="04">April</option>
                <option value="05">Mei</option>
                <option value="06">Juni</option>
                <option value="07">Juli</option>
                <option value="08">Agustus</option>
                <option value="09">September</option>
                <option value="10">Oktober</option>
                <option value="11">November</option>
                <option value="12">Desember</option>
            </select>
            
            <select name="tahun" class="rounded-xl border border-gray-200 bg-gray-50 text-sm focus:ring-brand-500 font-medium px-3 py-2 outline-none">
                <option value="2026">2026</option>
                <option value="2025">2025</option>
                <option value="2024">2024</option>
            </select>

            <button type="submit" class="bg-gray-100 text-gray-700 border border-gray-200 px-4 py-2 rounded-xl text-sm font-bold hover:bg-gray-200 transition flex items-center gap-2 shadow-sm">
                <i class='bx bx-filter'></i> Filter
            </button>
            
            <button type="button" onclick="window.print()" class="bg-brand-500 text-white border border-brand-600 px-5 py-2 rounded-xl text-sm font-bold hover:bg-brand-600 transition flex items-center gap-2 shadow-sm">
                <i class='bx bx-printer'></i> Cetak PDF
            </button>
        </form>
    </div>
</div>

<div class="print-area max-w-6xl mx-auto bg-white p-8 md:p-12 shadow-sm ring-1 ring-gray-100 rounded-3xl min-h-[297mm]">
    
    <div class="flex justify-between items-start border-b-4 border-black pb-6 mb-8">
        <div>
            <h2 class="text-4xl font-black tracking-tighter uppercase text-gray-900">Sewa<span class="text-brand-500">In</span></h2>
            <p class="text-gray-500 font-bold text-sm mt-1">Laporan Pendapatan Alat Produksi</p>
        </div>
        <div class="text-right">
            <p class="text-lg font-black uppercase italic text-gray-800">Tahun 2026</p>
            <p class="text-xs text-gray-400 mt-1">Dicetak: {{ date('d/m/Y H:i') }}</p>
        </div>
    </div>

    <table class="w-full mb-8">
        <thead>
            <tr class="bg-gray-50 border-y border-gray-300">
                <th class="p-3 text-left text-xs font-black uppercase text-gray-600">No</th>
                <th class="p-3 text-left text-xs font-black uppercase text-gray-600">ID Sewa</th>
                <th class="p-3 text-left text-xs font-black uppercase text-gray-600">Pelanggan</th>
                <th class="p-3 text-left text-xs font-black uppercase text-gray-600">Tgl Sewa</th>
                <th class="p-3 text-right text-xs font-black uppercase text-gray-600">Total Biaya</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            <!-- Dummy Data 1 -->
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="p-3 text-sm text-gray-500">1</td>
                <td class="p-3 text-sm font-bold text-gray-700">INV-0012</td>
                <td class="p-3 text-sm italic text-gray-600">UMKM Maju Jaya</td>
                <td class="p-3 text-sm text-gray-600">10/05/2026</td>
                <td class="p-3 text-sm text-right font-bold text-gray-800">Rp 250.000</td>
            </tr>
            <!-- Dummy Data 2 -->
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="p-3 text-sm text-gray-500">2</td>
                <td class="p-3 text-sm font-bold text-gray-700">INV-0013</td>
                <td class="p-3 text-sm italic text-gray-600">Toko Berkah</td>
                <td class="p-3 text-sm text-gray-600">14/05/2026</td>
                <td class="p-3 text-sm text-right font-bold text-gray-800">Rp 75.000</td>
            </tr>
            <!-- Dummy Data 3 -->
            <tr class="hover:bg-gray-50 transition-colors">
                <td class="p-3 text-sm text-gray-500">3</td>
                <td class="p-3 text-sm font-bold text-gray-700">INV-0014</td>
                <td class="p-3 text-sm italic text-gray-600">Kedai Kopi</td>
                <td class="p-3 text-sm text-gray-600">01/05/2026</td>
                <td class="p-3 text-sm text-right font-bold text-gray-800">Rp 400.000</td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="bg-gray-50 border-y border-gray-300">
                <td colspan="4" class="p-4 text-right font-black uppercase text-xs text-gray-600">Total Pendapatan</td>
                <td class="p-4 text-right font-black text-lg text-emerald-600">Rp 725.000</td>
            </tr>
        </tfoot>
    </table>

    <div class="mt-24 flex justify-end text-center">
        <div class="w-64">
            <p class="text-sm font-bold mb-24 text-gray-600">Mengetahui, Owner SewaIn</p>
            <p class="font-black border-b-2 border-black inline-block px-4 text-gray-800">{{ auth()->user()->nama ?? 'Owner' }}</p>
        </div>
    </div>
</div>
@endsection
