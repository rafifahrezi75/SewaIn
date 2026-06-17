<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Sewa {{ 'INV-' . str_pad($sewa->idsewa, 4, '0', STR_PAD_LEFT) }} - SewaIn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        @media print {
            .no-print { display: none !important; }
            body { font-size: 12px; background-color: #fff; }
            @page { margin: 1.5cm; size: A4 portrait; }
            .print-border { border: 1px solid #000 !important; }
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 p-4 md:p-8" onload="window.print()">

    <!-- Action Bar (Hidden when printing) -->
    <div class="no-print max-w-2xl mx-auto flex justify-between items-center mb-8 bg-white border-2 border-black p-4 shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] rounded-2xl">
        <button onclick="window.close()" class="px-4 py-2 bg-slate-100 border-2 border-black font-black text-xs uppercase italic rounded-xl hover:bg-slate-200 active:translate-y-0.5 transition-all">
            Tutup
        </button>
        <div class="flex gap-2">
            <button onclick="window.print()" class="px-4 py-2 bg-yellow-300 border-2 border-black font-black text-xs uppercase italic rounded-xl hover:bg-yellow-400 active:translate-y-0.5 transition-all">
                Cetak Struk (PDF)
            </button>
        </div>
    </div>

    <!-- Receipt Container -->
    <div class="max-w-2xl mx-auto bg-white p-8 border-2 border-black print-border shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] rounded-[2rem] print:shadow-none print:rounded-none">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b-2 border-black border-dashed pb-6 mb-6">
            <div class="text-left">
                <h1 class="text-2xl font-black uppercase tracking-tight italic">Sewa<span class="text-blue-700">In</span></h1>
                <p class="text-[10px] font-bold text-slate-500 uppercase mt-1 leading-tight">
                    Jl. Kartini no.4 Sidoarjo, Jawa Timur<br>
                    WA: +62 877-7660-0292 | halo@sewain.com
                </p>
            </div>
            <div class="text-left sm:text-right mt-4 sm:mt-0">
                <span class="inline-block px-3 py-1 bg-slate-100 border border-black font-black text-[9px] uppercase tracking-wider rounded-md mb-2">
                    {{ strtoupper($sewa->status) }}
                </span>
                <p class="text-xs font-black text-slate-900">INVOICE: #INV-{{ str_pad($sewa->idsewa, 4, '0', STR_PAD_LEFT) }}</p>
                <p class="text-[10px] font-bold text-slate-400">Tanggal: {{ date('d M Y H:i', strtotime($sewa->created_at)) }}</p>
            </div>
        </div>

        <!-- Rental Info Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-left mb-6 text-xs">
            <div>
                <h4 class="font-black text-slate-400 uppercase tracking-widest text-[9px] mb-2">Detail Penyewa</h4>
                <p class="font-black text-slate-900 text-sm uppercase italic leading-none mb-1">{{ $sewa->user->nama }}</p>
                <p class="font-bold text-slate-500 leading-tight">
                    Email: {{ $sewa->user->email }}<br>
                    No. WA: {{ $sewa->user->notelp ?? '-' }}
                </p>
            </div>
            <div>
                <h4 class="font-black text-slate-400 uppercase tracking-widest text-[9px] mb-2">Info Penyewaan</h4>
                <p class="font-bold text-slate-800">
                    <span class="font-black">Periode:</span> {{ date('d M Y', strtotime($sewa->tanggal_mulai)) }} s/d {{ date('d M Y', strtotime($sewa->tanggal_selesai)) }}<br>
                    <span class="font-black">Durasi:</span> {{ $sewa->durasi }} Hari<br>
                    <span class="font-black">Pengiriman:</span> {{ $sewa->metode_pengiriman }}
                </p>
                @if($sewa->alamat_sewa)
                    <p class="font-bold text-slate-500 mt-1"><span class="font-black text-slate-800">Alamat:</span> {{ $sewa->alamat_sewa }}</p>
                @endif
            </div>
        </div>

        <!-- Items Table -->
        <div class="mb-6">
            <h4 class="font-black text-slate-400 uppercase tracking-widest text-[9px] mb-3 text-left">Daftar Alat</h4>
            <div class="border-2 border-black rounded-2xl overflow-hidden print:border">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b-2 border-black font-black text-[9px] uppercase tracking-wider text-slate-600 print:border-b">
                            <th class="px-4 py-3">Nama Alat</th>
                            <th class="px-4 py-3 text-center">Harga/Hari</th>
                            <th class="px-4 py-3 text-center">Unit</th>
                            <th class="px-4 py-3 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y-2 divide-black divide-dashed print:divide-y print:divide-solid text-xs font-bold text-slate-700">
                        @foreach($sewa->details as $detail)
                            <tr>
                                <td class="px-4 py-3">
                                    <p class="font-black text-slate-900 uppercase italic">{{ $detail->alat->nama_alat ?? 'Alat' }}</p>
                                </td>
                                <td class="px-4 py-3 text-center">Rp{{ number_format($detail->harga, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-center">{{ $detail->jumlah }}</td>
                                <td class="px-4 py-3 text-right font-black text-slate-900">
                                    Rp{{ number_format($detail->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Summary Cost -->
        <div class="border-t-2 border-black pt-4 flex flex-col items-end text-xs font-bold text-slate-800">
            <div class="w-full sm:w-64 space-y-2">
                <div class="flex justify-between">
                    <span class="text-slate-400 uppercase">Subtotal Alat:</span>
                    <span>Rp{{ number_format($sewa->details->sum('subtotal') / $sewa->durasi, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400 uppercase">Durasi Sewa:</span>
                    <span>x {{ $sewa->durasi }} Hari</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-slate-400 uppercase">Ongkos Kirim:</span>
                    <span>Rp{{ number_format($sewa->ongkir, 0, ',', '.') }}</span>
                </div>
                @if($sewa->pengembalian && $sewa->pengembalian->total_denda > 0)
                <div class="flex justify-between text-red-600">
                    <span class="uppercase">Denda Telat/Kerusakan:</span>
                    <span>Rp{{ number_format($sewa->pengembalian->total_denda, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="flex justify-between items-center pt-3 border-t-2 border-black border-dashed">
                    <span class="text-sm font-black text-slate-900 uppercase italic">Total Bayar:</span>
                    <span class="text-lg font-black text-blue-700 italic">Rp{{ number_format($sewa->total_biaya + ($sewa->pengembalian ? $sewa->pengembalian->total_denda : 0), 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="mt-8 pt-6 border-t-2 border-black border-dashed text-center text-[10px] font-black uppercase text-slate-400 italic">
            *** TERIMA KASIH TELAH MEMILIH SEWAIN ***
        </div>
    </div>

</body>
</html>
