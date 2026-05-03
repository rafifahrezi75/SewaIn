<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyewaan;
use App\Models\User;
use App\Models\Alat;
use App\Models\Kategori;
use App\Models\PenyewaanDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Stats
        $pendingPesanan = Penyewaan::where('status', 'pending')->count();
        $penyewaanAktif = Penyewaan::where('status', 'disewa')->count();
        
        // Asumsi terlambat jika disewa tapi melewati tanggal selesai
        $terlambat = Penyewaan::where('status', 'disewa')
            ->whereDate('tanggal_selesai', '<', Carbon::now())
            ->count();
            
        $totalUmkm = User::where('role', 'pelanggan')->count();

        // Chart Data - Statistik Penyewaan (12 bulan tahun ini)
        $year = Carbon::now()->year;
        $monthlyRentals = Penyewaan::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();
            
        $chartRentalsData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartRentalsData[] = $monthlyRentals[$i] ?? 0;
        }

        // Chart Data - Statistik Kategori (Jumlah Alat per Kategori)
        $kategoriStats = Kategori::withCount('alat')->get();
        $pieLabels = $kategoriStats->pluck('kategori')->toArray();
        $pieData = $kategoriStats->pluck('alat_count')->toArray();

        // Recent Transactions
        $recentTransactions = Penyewaan::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Stock Analytics
        $totalStokAlat = Alat::sum('stok');
        // Total stok yang sedang disewa
        $stokDisewa = PenyewaanDetail::whereHas('penyewaan', function($q) {
            $q->where('status', 'disewa');
        })->sum('jumlah');

        return view('admin.dashboard', compact(
            'pendingPesanan',
            'penyewaanAktif',
            'terlambat',
            'totalUmkm',
            'chartRentalsData',
            'pieLabels',
            'pieData',
            'recentTransactions',
            'totalStokAlat',
            'stokDisewa'
        ));
    }
}