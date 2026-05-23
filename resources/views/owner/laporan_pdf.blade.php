<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi - SewaIn</title>
    @vite('resources/css/app.css')
    <style>
        @media print {
            .no-print { display: none !important; }
            body { font-size: 12px; }
            @page { margin: 1cm; size: A4 portrait; }
        }
    </style>
</head>
<body class="bg-white text-gray-800 p-8 max-w-4xl mx-auto font-sans" onload="window.print()">

    <!-- Action Bar -->
    <div class="no-print flex justify-end mb-8 gap-4">
        <button onclick="window.close()" class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium hover:bg-gray-50">Tutup</button>
        <button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Cetak PDF</button>
    </div>

    <!-- Header Laporan -->
    <div class="text-center mb-8 border-b-2 border-gray-800 pb-4">
        <h1 class="text-3xl font-bold uppercase tracking-wider mb-1">SewaIn</h1>
        <p class="text-sm text-gray-600 mb-2">Pusat Penyewaan Alat Terbaik dan Terpercaya</p>
        <h2 class="text-xl font-semibold mt-4">Laporan Transaksi Penyewaan</h2>
        
        @if(request('tgl_awal') || request('tgl_akhir'))
            <p class="text-sm mt-1 text-gray-700">
                Periode: 
                {{ request('tgl_awal') ? \Carbon\Carbon::parse(request('tgl_awal'))->translatedFormat('d M Y') : 'Awal' }} 
                - 
                {{ request('tgl_akhir') ? \Carbon\Carbon::parse(request('tgl_akhir'))->translatedFormat('d M Y') : 'Sekarang' }}
            </p>
        @else
            <p class="text-sm mt-1 text-gray-700">Periode: Semua Waktu</p>
        @endif
    </div>

    <!-- Tabel Data -->
    <table class="w-full text-left border-collapse border border-gray-300 mb-8">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2 text-sm font-bold text-gray-800">No</th>
                <th class="border border-gray-300 px-4 py-2 text-sm font-bold text-gray-800">Invoice</th>
                <th class="border border-gray-300 px-4 py-2 text-sm font-bold text-gray-800">Tanggal Mulai</th>
                <th class="border border-gray-300 px-4 py-2 text-sm font-bold text-gray-800">Pelanggan</th>
                <th class="border border-gray-300 px-4 py-2 text-sm font-bold text-gray-800">Item</th>
                <th class="border border-gray-300 px-4 py-2 text-sm font-bold text-gray-800">Status</th>
                <th class="border border-gray-300 px-4 py-2 text-sm font-bold text-gray-800 text-right">Total Biaya</th>
            </tr>
        </thead>
        <tbody>
            @php $total_pendapatan = 0; @endphp
            @forelse($transaksi as $index => $trx)
                @php 
                    // Calculate totals only for completed transactions usually, but we'll sum up what's requested
                    if(strtolower($trx->status) === 'selesai') {
                        $total_pendapatan += $trx->total_biaya; 
                    }
                @endphp
                <tr>
                    <td class="border border-gray-300 px-4 py-2 text-sm text-center">{{ $index + 1 }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-sm">INV-{{ str_pad($trx->idsewa, 4, '0', STR_PAD_LEFT) }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-sm">{{ \Carbon\Carbon::parse($trx->tanggal_mulai)->format('d/m/Y') }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-sm">{{ $trx->user->nama ?? '-' }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-sm">
                        @if($trx->details && $trx->details->count() > 0)
                            {{ $trx->details[0]->alat->nama_alat ?? 'Alat' }}
                            @if($trx->details->count() > 1)
                                <span class="text-xs text-gray-500">(+{{ $trx->details->count() - 1 }})</span>
                            @endif
                        @else
                            -
                        @endif
                    </td>
                    <td class="border border-gray-300 px-4 py-2 text-sm capitalize">{{ $trx->status }}</td>
                    <td class="border border-gray-300 px-4 py-2 text-sm text-right">Rp {{ number_format($trx->total_biaya, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="border border-gray-300 px-4 py-4 text-center text-sm text-gray-500">Tidak ada data transaksi.</td>
                </tr>
            @endforelse
        </tbody>
        @if($transaksi->count() > 0)
        <tfoot>
            <tr class="bg-gray-50 font-bold">
                <td colspan="6" class="border border-gray-300 px-4 py-2 text-right">Total Pendapatan (Status Selesai):</td>
                <td class="border border-gray-300 px-4 py-2 text-right text-green-700">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>

    <!-- Footer Tanda Tangan -->
    <div class="flex justify-end mt-12">
        <div class="text-center w-48">
            <p class="text-sm mb-16">Dicetak pada: {{ now()->translatedFormat('d M Y') }}</p>
            <p class="text-sm font-bold border-b border-gray-800 pb-1">{{ Auth::user()->nama ?? 'Admin/Owner' }}</p>
            <p class="text-xs mt-1 text-gray-500">Mengetahui</p>
        </div>
    </div>

</body>
</html>
