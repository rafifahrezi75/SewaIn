@extends('layouts.owner')

@section('title', 'Owner Dashboard')

@section('content')
<!-- Dashboard Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stat Card 1 -->
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 transition-shadow hover:shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Pendapatan</p>
                <h3 class="mt-2 text-2xl font-bold text-gray-800">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
            </div>
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-emerald-50 text-2xl text-emerald-500 shadow-inner">
                <i class='bx bx-wallet'></i>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-2 text-sm">
            <span class="flex items-center text-emerald-600 font-medium bg-emerald-50 px-2 py-0.5 rounded-md text-xs">Penyewaan Selesai</span>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 transition-shadow hover:shadow-md border-b-4 border-teal-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Penyewaan Selesai</p>
                <h3 class="mt-2 text-3xl font-bold text-gray-800">{{ number_format($penyewaanSelesai, 0, ',', '.') }}</h3>
            </div>
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-teal-50 text-2xl text-teal-600 shadow-inner">
                <i class='bx bx-check-circle'></i>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-2 text-sm">
            <span class="flex items-center text-teal-600 font-medium bg-teal-50 px-2 py-0.5 rounded-md text-xs">Transaksi Sukses</span>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 transition-shadow hover:shadow-md">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Pelanggan Aktif</p>
                <h3 class="mt-2 text-3xl font-bold text-gray-800">{{ number_format($pelangganAktif, 0, ',', '.') }}</h3>
            </div>
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-50 text-2xl text-blue-500 shadow-inner">
                <i class='bx bx-user-check'></i>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-2 text-sm">
            <span class="flex items-center text-blue-500 font-medium bg-blue-50 px-2 py-0.5 rounded-md text-[11px]">User Unik</span>
        </div>
    </div>

    <!-- Stat Card 4 -->
    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-gray-100 transition-shadow hover:shadow-md border-b-4 border-orange-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Pesanan Pending</p>
                <h3 class="mt-2 text-3xl font-bold text-orange-600">{{ number_format($pesananPending, 0, ',', '.') }}</h3>
            </div>
            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-orange-50 text-orange-500 shadow-md">
                <i class='bx bx-time-five'></i>
            </div>
        </div>
        <div class="mt-4 flex items-center gap-2 text-sm">
            <span class="flex items-center text-orange-500 font-medium bg-orange-50 px-2 py-0.5 rounded-md text-[11px]">Menunggu Konfirmasi</span>
        </div>
    </div>
</div>

<!-- Chart Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">

    <!-- Line Chart -->
    <div class="lg:col-span-2 bg-white rounded-3xl p-6 shadow-sm ring-1 ring-gray-100">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-800">
                Statistik Pendapatan
            </h2>
            <form method="GET" action="{{ route('owner.dashboard') }}">
                <select name="tahun" onchange="this.form.submit()" class="rounded-xl border border-gray-200 bg-gray-50 text-sm font-medium px-3 py-1.5 focus:ring-brand-500 outline-none cursor-pointer">
                    @php $currentYear = date('Y'); @endphp
                    @for($y = $currentYear; $y >= $currentYear - 3; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>Tahun {{ $y }}</option>
                    @endfor
                </select>
            </form>
        </div>
        <div class="relative h-80 w-full">
            <canvas id="rentalsChart"></canvas>
        </div>
    </div>

    <!-- Alat Paling Laris List -->
    <div class="bg-white rounded-3xl p-6 shadow-sm ring-1 ring-gray-100 flex flex-col">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Alat Paling Laris</h2>
        <div class="flex-1 overflow-y-auto pr-2 space-y-3">
            @forelse($alatLaris as $index => $item)
            <div class="flex items-center gap-4 p-3 rounded-2xl hover:bg-gray-50 border border-transparent hover:border-gray-100 transition-colors">
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl {{ $index == 0 ? 'bg-amber-100 text-amber-600' : ($index == 1 ? 'bg-gray-200 text-gray-600' : ($index == 2 ? 'bg-orange-100 text-orange-600' : 'bg-brand-50 text-brand-600')) }} font-bold text-sm">
                    #{{ $index + 1 }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-semibold text-gray-800">{{ $item->alat->nama_alat ?? 'Alat Dihapus' }}</p>
                    <p class="text-xs text-gray-500">{{ $item->total_disewa }} kali disewa</p>
                </div>
            </div>
            @empty
            <div class="flex flex-col items-center justify-center h-full text-center py-8">
                <p class="text-sm text-gray-500">Belum ada penyewaan.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Analytics & Recent Transactions Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Recent Transactions Table -->
    <div class="lg:col-span-2 bg-white rounded-3xl p-6 shadow-sm ring-1 ring-gray-100">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800">Penyewaan Pending</h2>
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
                    @forelse($transaksiTerbaru as $trx)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3">
                            <div class="font-medium text-gray-900 border-b border-gray-100 pb-0.5 mb-0.5 inline-block">
                                INV-{{ str_pad($trx->idsewa, 4, '0', STR_PAD_LEFT) }}
                            </div>
                            <div class="text-xs">{{ $trx->user->nama ?? 'Unknown' }}</div>
                        </td>
                        <td class="px-4 py-3 text-xs">
                            <i class='bx bx-calendar mr-1 text-gray-400'></i> {{ \Carbon\Carbon::parse($trx->created_at)->format('d M Y') }}
                        </td>
                        <td class="px-4 py-3">
                            <span class="inline-flex items-center gap-1 rounded bg-gray-100 px-2 py-1 text-[10px] font-semibold text-gray-600 uppercase">
                                <i class='bx {{ strtolower($trx->metode_pengiriman) == 'diantar' ? 'bx-truck' : 'bx-store' }}'></i> {{ $trx->metode_pengiriman }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-orange-100 text-orange-600',
                                    'disewa' => 'bg-blue-100 text-blue-600',
                                    'selesai' => 'bg-green-100 text-green-600',
                                    'terlambat' => 'bg-red-100 text-red-600',
                                ];
                                $colorClass = $statusColors[strtolower($trx->status)] ?? 'bg-gray-100 text-gray-600';
                            @endphp
                            <span class="inline-block rounded-full {{ $colorClass }} px-2.5 py-0.5 text-[10px] font-semibold uppercase">
                                {{ $trx->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Cetak Laporan -->
    <div class="bg-brand-500 rounded-3xl p-6 shadow-sm ring-1 ring-brand-600 text-white flex flex-col justify-between relative overflow-hidden">
        <!-- Background element -->
        <i class='bx bx-printer absolute -right-6 -bottom-6 text-[150px] opacity-10'></i>

        <div class="relative z-10">
            <h2 class="text-xl font-bold mb-1">Cetak Laporan</h2>
            <p class="text-brand-200 text-sm mb-6">Unduh atau cetak laporan penyewaan</p>

            <div class="space-y-4">
                <p class="text-sm bg-white/10 p-4 rounded-xl border border-white/20">Fitur ini membantu Anda menganalisis performa bisnis dan mendokumentasikan pendapatan.</p>
            </div>
        </div>

        <a href="{{ url('owner/cetak-laporan') }}" class="relative z-10 w-full mt-6 bg-white text-center text-brand-600 rounded-xl py-3 font-semibold text-sm hover:bg-brand-50 transition-colors focus:outline-none shadow-sm flex items-center justify-center gap-2">
            <i class='bx bx-printer text-lg'></i> Cetak Laporan Sekarang
        </a>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('rentalsChart').getContext('2d');
    const rawData = @json($pendapatanBulanan); 
    const data = rawData;

    
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
                            let value = context.parsed.y;
                            return ' Rp ' + new Intl.NumberFormat('id-ID').format(value);
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
                        stepSize: 100000,
                        callback: function(value, index, values) {
                            if (value >= 1000000) {
                                return 'Rp ' + (value / 1000000).toFixed(1) + ' Jt';
                            } else if (value >= 1000) {
                                return 'Rp ' + (value / 1000) + ' Rb';
                            }
                            return 'Rp ' + value;
                        }
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

    // Pie chart logic removed
</script>
@endsection
