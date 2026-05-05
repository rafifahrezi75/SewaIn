<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyewaan;
use App\Models\PenyewaanDetail;
use Illuminate\Support\Facades\DB;

class OwnerController extends Controller
{
    public function dashboard(Request $request)
    {
        $tahun = $request->input('tahun', date('Y'));

        // 1. Total Pendapatan (dari total_biaya penyewaan yang sudah selesai)
        $totalPendapatan = Penyewaan::where('status', 'selesai')->sum('total_biaya');

        // 2. Penyewaan Selesai
        $penyewaanSelesai = Penyewaan::where('status', 'selesai')->count();

        // 3. Pelanggan Aktif (user unik di penyewaan)
        $pelangganAktif = Penyewaan::distinct('iduser')->count('iduser');

        // 4. Pesanan Pending
        $pesananPending = Penyewaan::where('status', 'pending')->count();

        // Grafik Pendapatan Bulanan (Filter Tahun)
        $pendapatanBulananRaw = Penyewaan::where('status', 'selesai')
            ->whereYear('created_at', $tahun)
            ->select(
                DB::raw('MONTH(created_at) as bulan'),
                DB::raw('SUM(total_biaya) as total')
            )
            ->groupBy('bulan')
            ->get()
            ->keyBy('bulan');

        $pendapatanBulanan = [];
        for ($i = 1; $i <= 12; $i++) {
            $pendapatanBulanan[] = $pendapatanBulananRaw->has($i) ? $pendapatanBulananRaw[$i]->total : 0;
        }

        // Alat Paling Laris
        // Asumsi penyewaan_detail ada relasi ke alat
        $alatLaris = PenyewaanDetail::select('idalat', DB::raw('SUM(jumlah) as total_disewa'))
            ->groupBy('idalat')
            ->orderByDesc('total_disewa')
            ->limit(5)
            ->with('alat') // Pastikan relasi 'alat' ada di PenyewaanDetail
            ->get();

        // Daftar Transaksi Pending Terbaru
        $transaksiTerbaru = Penyewaan::with('user')
            ->where('status', 'pending')
            ->orderByDesc('created_at')
            ->limit(3)
            ->get();

        return view('owner.dashboard', compact(
            'totalPendapatan',
            'penyewaanSelesai',
            'pelangganAktif',
            'pesananPending',
            'pendapatanBulanan',
            'alatLaris',
            'transaksiTerbaru',
            'tahun'
        ));
    }
}
