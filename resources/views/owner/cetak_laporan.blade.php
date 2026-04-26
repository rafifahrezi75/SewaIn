<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan | Owner Dashboard</title>
    
    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            200: '#bfdbfe', 
                            400: '#60a5fa', 
                            500: '#1E3A8A', 
                            600: '#172554', 
                            700: '#1e3a8a', 
                        }
                    }
                }
            }
        }
    </script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background-color: white; padding: 0; }
            .print-area { border: none; box-shadow: none; max-width: 100%; margin: 0; padding: 0; }
        }
    </style>
</head>
<body class="bg-gray-100 p-4 md:p-10 font-sans">

    <div class="no-print max-w-6xl mx-auto mb-6">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <a href="{{ url('owner/transaksi') }}" class="group flex items-center gap-2 mb-1 transition-all">
                    <i class='bx bx-left-arrow-alt text-2xl text-brand-500 group-hover:-translate-x-1 transition-transform'></i>
                    <h1 class="text-lg font-bold italic text-gray-800 uppercase tracking-tight">
                        Cetak Laporan Penjualan
                    </h1>
                </a>
            </div>

            <form method="GET" class="flex flex-wrap gap-2">
                <select name="bulan" class="rounded-xl border-gray-300 text-sm focus:ring-brand-500 font-medium px-3 py-2 border">
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
                
                <select name="tahun" class="rounded-xl border-gray-300 text-sm focus:ring-brand-500 font-medium px-3 py-2 border">
                    <option value="2026">2026</option>
                    <option value="2025">2025</option>
                    <option value="2024">2024</option>
                </select>

                <button type="button" class="bg-brand-500 text-white px-4 py-2 rounded-xl text-sm font-bold hover:bg-black transition flex items-center gap-2">
                    <i class='bx bx-search'></i> CARI DATA
                </button>
                
                <button type="button" onclick="window.print()" class="bg-brand-500 text-white px-5 py-2 rounded-xl text-sm font-bold hover:bg-brand-600 shadow-lg flex items-center gap-2">
                    <i class='bx bx-printer'></i> CETAK PDF
                </button>
            </form>
        </div>
    </div>

    <div class="print-area max-w-6xl mx-auto bg-white p-12 shadow-xl border border-gray-200 min-h-[297mm]">
        
        <div class="flex justify-between items-start border-b-4 border-black pb-6 mb-8">
            <div>
                <h2 class="text-4xl font-black tracking-tighter uppercase">Sewa<span class="text-brand-500">In</span></h2>
                <p class="text-gray-500 font-bold text-sm">Laporan Peminjaman Alat Produksi</p>
            </div>
            <div class="text-right">
                <p class="text-lg font-black uppercase italic">Tahun 2026</p>
                <p class="text-xs text-gray-400">Dicetak: 26/04/2026 12:00</p>
            </div>
        </div>

        <table class="w-full mb-8">
            <thead>
                <tr class="bg-gray-50 border-y border-gray-300">
                    <th class="p-3 text-left text-xs font-black uppercase">No</th>
                    <th class="p-3 text-left text-xs font-black uppercase">ID Sewa</th>
                    <th class="p-3 text-left text-xs font-black uppercase">Pelanggan</th>
                    <th class="p-3 text-left text-xs font-black uppercase">Tgl Sewa</th>
                    <th class="p-3 text-right text-xs font-black uppercase">Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dummy Data 1 -->
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="p-3 text-sm text-gray-400">1</td>
                    <td class="p-3 text-sm font-bold">#0001</td>
                    <td class="p-3 text-sm italic">UMKM Maju Jaya</td>
                    <td class="p-3 text-sm">10/05/2026</td>
                    <td class="p-3 text-sm text-right font-bold">Rp 250.000</td>
                </tr>
                <!-- Dummy Data 2 -->
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="p-3 text-sm text-gray-400">2</td>
                    <td class="p-3 text-sm font-bold">#0002</td>
                    <td class="p-3 text-sm italic">Toko Berkah</td>
                    <td class="p-3 text-sm">14/05/2026</td>
                    <td class="p-3 text-sm text-right font-bold">Rp 75.000</td>
                </tr>
                <!-- Dummy Data 3 -->
                <tr class="border-b border-gray-100 hover:bg-gray-50">
                    <td class="p-3 text-sm text-gray-400">3</td>
                    <td class="p-3 text-sm font-bold">#0003</td>
                    <td class="p-3 text-sm italic">Kedai Kopi</td>
                    <td class="p-3 text-sm">01/05/2026</td>
                    <td class="p-3 text-sm text-right font-bold">Rp 400.000</td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="bg-gray-900 text-brand-500">
                    <td colspan="4" class="p-4 text-right font-black uppercase text-xs">Total Pendapatan</td>
                    <td class="p-4 text-right font-black text-lg">Rp 725.000</td>
                </tr>
            </tfoot>
        </table>

        <div class="mt-20 flex justify-end text-center">
            <div class="w-64">
                <p class="text-sm font-bold mb-20">Mengetahui, Owner SewaIn</p>
                <p class="font-black border-b-2 border-black inline-block px-4">Owner Name</p>
            </div>
        </div>
    </div>

</body>
</html>
