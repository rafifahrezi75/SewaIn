@extends('layouts.owner')

@section('title', 'Owner Dashboard')

@section('content')
<!-- Dashboard Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stat Card 1 -->
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 transition-shadow hover:shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Menunggu Diambil</p>
                <h3 class="mt-2 text-3xl font-bold text-gray-800">5</h3>
            </div>
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-orange-50 text-2xl text-orange-500 shadow-inner">
                <i class='bx bx-time-five'></i>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-2 text-sm">
            <span class="flex items-center text-orange-500 font-medium bg-orange-50 px-2 py-0.5 rounded-md text-xs">Pesanan Pending</span>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 transition-shadow hover:shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Alat Sedang Disewa</p>
                <h3 class="mt-2 text-3xl font-bold text-gray-800">12</h3>
            </div>
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-50 text-2xl text-brand-600 shadow-inner">
                <i class='bx bx-shopping-bag'></i>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-2 text-sm">
            <span class="flex items-center text-brand-600 font-medium bg-brand-50 px-2 py-0.5 rounded-md text-xs">Penyewaan Aktif</span>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 transition-shadow hover:shadow-md border-b-4 border-red-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Belum Dikembalikan</p>
                <h3 class="mt-2 text-3xl font-bold text-red-600">2</h3>
            </div>
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-red-50 text-red-500 shadow-md">
                <i class='bx bx-error-circle'></i>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-2 text-sm">
            <span class="flex items-center text-red-500 font-medium bg-red-50 px-2 py-0.5 rounded-md text-[11px]">Terlambat</span>
            <span class="text-gray-400 text-[11px]">Segera tindak lanjuti</span>
        </div>
    </div>

    <!-- Stat Card 4 -->
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 transition-shadow hover:shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Pendapatan</p>
                <h3 class="mt-2 text-xl font-bold text-gray-800">Rp 5.2M</h3>
            </div>
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-2xl text-emerald-500 shadow-inner">
                <i class='bx bx-wallet'></i>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-2 text-sm">
            <span class="text-emerald-500 font-medium bg-emerald-50 px-2 py-0.5 rounded-md text-xs">+12% Bulan ini</span>
        </div>
    </div>
</div>

<!-- Chart Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

    <!-- Line Chart -->
    <div class="lg:col-span-2 bg-white rounded-3xl p-6 shadow-sm ring-1 ring-gray-100">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            Statistik Penyewaan & Pendapatan (2026)
        </h2>
        <div class="relative h-80 w-full">
            <canvas id="rentalsChart"></canvas>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="bg-white rounded-3xl p-6 shadow-sm ring-1 ring-gray-100">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            Alat Paling Diminati
        </h2>
        <div class="relative h-80 w-full">
            <canvas id="myPieChart"></canvas>
        </div>
    </div>

</div>

<!-- Analytics & Recent Transactions Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Recent Transactions Table -->
    <div class="lg:col-span-2 bg-white rounded-3xl p-6 shadow-sm ring-1 ring-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800">Penyewaan Terbaru</h2>
            <a href="{{ url('owner/transaksi') }}" class="text-sm font-medium text-brand-500 hover:text-brand-600 focus:outline-none">Lihat Semua</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-500">
                <thead class="bg-gray-50/50 text-xs uppercase text-gray-400 border-b border-gray-100">
                    <tr>
                        <th scope="col" class="px-4 py-3 font-semibold tracking-wider">ID / Penyewa</th>
                        <th scope="col" class="px-4 py-3 font-semibold tracking-wider">Tanggal Mulai</th>
                        <th scope="col" class="px-4 py-3 font-semibold tracking-wider">Metode</th>
                        <th scope="col" class="px-4 py-3 font-semibold tracking-wider text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-900 border-b border-gray-100 pb-0.5 mb-0.5 inline-block">
                                INV-0012
                            </div>
                            <div class="text-xs">UMKM Sejahtera</div>
                        </td>
                        <td class="px-4 py-3 text-xs">
                            <i class='bx bx-calendar mr-1 text-gray-400'></i> 12 Mei 2026
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1 rounded bg-gray-100 px-2 py-1 text-[10px] font-semibold text-gray-600 uppercase">
                                <i class='bx bx-truck'></i> Diantar
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <span class="inline-block rounded-full bg-blue-100 px-2.5 py-0.5 text-[10px] font-semibold uppercase text-blue-600">
                                disewa
                            </span>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-900 border-b border-gray-100 pb-0.5 mb-0.5 inline-block">
                                INV-0011
                            </div>
                            <div class="text-xs">Toko Sumber Rejeki</div>
                        </td>
                        <td class="px-4 py-3 text-xs">
                            <i class='bx bx-calendar mr-1 text-gray-400'></i> 10 Mei 2026
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1 rounded bg-gray-100 px-2 py-1 text-[10px] font-semibold text-gray-600 uppercase">
                                <i class='bx bx-store'></i> Ambil Sendiri
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <span class="inline-block rounded-full bg-orange-100 px-2.5 py-0.5 text-[10px] font-semibold uppercase text-orange-600">
                                pending
                            </span>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-900 border-b border-gray-100 pb-0.5 mb-0.5 inline-block">
                                INV-0010
                            </div>
                            <div class="text-xs">Kedai Kopi ABC</div>
                        </td>
                        <td class="px-4 py-3 text-xs">
                            <i class='bx bx-calendar mr-1 text-gray-400'></i> 05 Mei 2026
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1 rounded bg-gray-100 px-2 py-1 text-[10px] font-semibold text-gray-600 uppercase">
                                <i class='bx bx-truck'></i> Diantar
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <span class="inline-block rounded-full bg-green-100 px-2.5 py-0.5 text-[10px] font-semibold uppercase text-green-600">
                                selesai
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Stock Analytics -->
    <div class="bg-brand-500 rounded-3xl p-6 shadow-sm ring-1 ring-brand-600 text-white flex flex-col justify-between relative overflow-hidden">
        <!-- Background element -->
        <i class='bx bx-archive-in absolute -right-6 -bottom-6 text-[150px] opacity-10'></i>

        <div class="relative z-10">
            <h2 class="text-xl font-bold mb-1">Status Alat Produksi</h2>
            <p class="text-brand-200 text-sm mb-6">Ringkasan kondisi stok di gudang</p>

            <div class="space-y-4">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm font-medium">Tersedia Digudang</span>
                        <span class="text-lg font-bold">150 <span class="text-xs font-normal">unit</span></span>
                    </div>
                    <div class="w-full bg-brand-600 rounded-full h-1.5 mt-2">
                        <div class="bg-white h-1.5 rounded-full" style="width: 75%"></div>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm font-medium">Sedang Disewa</span>
                        <span class="text-lg font-bold">50 <span class="text-xs font-normal">unit</span></span>
                    </div>
                    <div class="w-full bg-brand-600 rounded-full h-1.5 mt-2">
                        <div class="bg-[#f9db72] h-1.5 rounded-full" style="width: 25%"></div>
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ url('owner/transaksi') }}" class="relative z-10 w-full mt-6 bg-white text-center text-brand-600 rounded-xl py-3 font-semibold text-sm hover:bg-brand-50 transition-colors focus:outline-none shadow-sm inline-block">
            Lihat Transaksi Aktif
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('rentalsChart').getContext('2d');
    const data = [12, 19, 15, 25, 22, 30, 28, 35, 40, 38, 45, 50]; // Dummy data
    
    let gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(30, 58, 138, 0.4)'); // brand-500
    gradient.addColorStop(1, 'rgba(30, 58, 138, 0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Total Penyewaan',
                data: data,
                borderColor: '#1E3A8A', // brand-500
                borderWidth: 3,
                backgroundColor: gradient,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#1E3A8A',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1f2937',
                    padding: 12,
                    titleFont: { size: 13, family: "'Poppins', sans-serif" },
                    bodyFont: { size: 13, family: "'Poppins', sans-serif" },
                    callbacks: {
                        label: function(context) {
                            return ' ' + context.parsed.y + ' Transaksi';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    suggestedMax: Math.max(...data) + 10,
                    ticks: {
                        precision: 0,
                        font: { family: "'Poppins', sans-serif", size: 11 },
                        color: '#9ca3af',
                        stepSize: 10
                    },
                    grid: {
                        color: '#f3f4f6',
                        drawBorder: false
                    }
                },
                x: {
                    ticks: {
                        font: { family: "'Poppins', sans-serif", size: 11 },
                        color: '#9ca3af'
                    },
                    grid: {
                        display: false,
                        drawBorder: false
                    }
                }
            },
            interaction: {
                intersect: false,
                mode: 'index',
            },
            layout: {
                padding: {
                    top: 10,
                    bottom: 0
                }
            }
        }
    });

    const labels = ['Kamera', 'Lensa', 'Lighting', 'Audio', 'Aksesoris'];
    const dataPie = [35, 20, 15, 10, 20]; // Dummy data

    const ctxPie = document.getElementById('myPieChart').getContext('2d');

    new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: dataPie,
                backgroundColor: [
                    '#1E3A8A', // brand-500
                    '#3b82f6', // blue-500
                    '#14B8A6', // teal-500
                    '#f59e0b', // amber-500
                    '#ef4444'  // red-500
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>
@endsection
