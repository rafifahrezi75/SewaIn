@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<!-- Dashboard Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stat Card 1 -->
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 transition-shadow hover:shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Menunggu Diambil</p>
                <h3 class="mt-2 text-3xl font-bold text-gray-800">{{ $pendingPesanan }}</h3>
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
                <h3 class="mt-2 text-3xl font-bold text-gray-800">{{ $penyewaanAktif }}</h3>
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
                <h3 class="mt-2 text-3xl font-bold text-red-600">{{ $terlambat }}</h3>
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
                <p class="text-sm font-medium text-gray-500">Total UMKM</p>
                <h3 class="mt-2 text-3xl font-bold text-gray-800">{{ $totalUmkm }}</h3>
            </div>
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-2xl text-blue-500 shadow-inner">
                <i class='bx bx-group'></i>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-2 text-sm">
            <span class="text-gray-400 text-xs">Pelanggan Terdaftar</span>
        </div>
    </div>
</div>

<!-- Chart Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

    <!-- Line Chart -->
    <div class="lg:col-span-2 bg-white rounded-3xl p-6 shadow-sm ring-1 ring-gray-100">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            Statistik Penyewaan (2026)
        </h2>
        <div class="relative h-80 w-full">
            <canvas id="rentalsChart"></canvas>
        </div>
    </div>

    <!-- Pie Chart -->
    <div class="bg-white rounded-3xl p-6 shadow-sm ring-1 ring-gray-100">
        <h2 class="text-xl font-bold text-gray-800 mb-4">
            Statistik Kategori
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
            <a href="#" class="text-sm font-medium text-brand-500 hover:text-brand-600 focus:outline-none">Lihat Semua</a>
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
                    @forelse($recentTransactions as $transaksi)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-900 border-b border-gray-100 pb-0.5 mb-0.5 inline-block">
                                INV-{{ str_pad($transaksi->idsewa, 4, '0', STR_PAD_LEFT) }}
                            </div>
                            <div class="text-xs">{{ $transaksi->user->nama ?? 'Unknown User' }}</div>
                        </td>
                        <td class="px-4 py-3 text-xs">
                            <i class='bx bx-calendar mr-1 text-gray-400'></i> {{ \Carbon\Carbon::parse($transaksi->tanggal_mulai)->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1 rounded bg-gray-100 px-2 py-1 text-[10px] font-semibold text-gray-600 uppercase">
                                @if($transaksi->metode_pengiriman == 'diantar')
                                    <i class='bx bx-truck'></i> Diantar
                                @else
                                    <i class='bx bx-store'></i> Ambil Sendiri
                                @endif
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            @php
                                $statusClass = match(strtolower($transaksi->status)) {
                                    'pending' => 'bg-orange-100 text-orange-600',
                                    'disewa' => 'bg-blue-100 text-blue-600',
                                    'selesai' => 'bg-green-100 text-green-600',
                                    'batal' => 'bg-red-100 text-red-600',
                                    default => 'bg-gray-100 text-gray-600'
                                };
                            @endphp
                            <span class="inline-block rounded-full {{ $statusClass }} px-2.5 py-0.5 text-[10px] font-semibold uppercase">
                                {{ $transaksi->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center text-gray-500">Belum ada transaksi terbaru.</td>
                    </tr>
                    @endforelse
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
                @php
                    $percentTersedia = $totalStokAlat > 0 ? round(($totalStokAlat / ($totalStokAlat + $stokDisewa)) * 100) : 0;
                    $percentDisewa = $totalStokAlat > 0 || $stokDisewa > 0 ? 100 - $percentTersedia : 0;
                @endphp
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm font-medium">Tersedia Digudang</span>
                        <span class="text-lg font-bold">{{ $totalStokAlat }} <span class="text-xs font-normal">unit</span></span>
                    </div>
                    <div class="w-full bg-brand-600 rounded-full h-1.5 mt-2">
                        <div class="bg-white h-1.5 rounded-full" style="width: {{ $percentTersedia }}%"></div>
                    </div>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 border border-white/20">
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-sm font-medium">Sedang Disewa</span>
                        <span class="text-lg font-bold">{{ $stokDisewa }} <span class="text-xs font-normal">unit</span></span>
                    </div>
                    <div class="w-full bg-brand-600 rounded-full h-1.5 mt-2">
                        <div class="bg-[#f9db72] h-1.5 rounded-full" style="width: {{ $percentDisewa }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <a href="{{ url('admin/alat') }}" class="relative z-10 w-full mt-6 bg-white text-center text-brand-600 rounded-xl py-3 font-semibold text-sm hover:bg-brand-50 transition-colors focus:outline-none shadow-sm inline-block">
            Lihat Detail Alat
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('rentalsChart').getContext('2d');
    const data = @json($chartRentalsData);
    
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

    const labels = @json($pieLabels);
    const dataPie = @json($pieData);

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
