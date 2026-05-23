<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyewaan;
use App\Models\Pengembalian;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    public function index(Request $request)
    {
        // Antrean Validasi (Status: disewa)
        $antrean = Penyewaan::with(['user'])->where('status', 'disewa')->orderBy('tanggal_selesai', 'asc')->get();

        // Riwayat Pengembalian Selesai
        $riwayat = Pengembalian::with(['penyewaan.user'])->orderBy('tanggal_kembali', 'desc')->get();

        $view = auth()->user()->role === 'admin' ? 'admin.pengembalian' : 'owner.pengembalian';
        return view($view, compact('antrean', 'riwayat'));
    }

    public function validasi(Request $request)
    {
        $request->validate([
            'id_sewa' => 'required|exists:penyewaan,idsewa',
            'denda_kerusakan' => 'nullable|numeric|min:0',
            'kondisi' => 'nullable|array'
        ]);

        $penyewaan = Penyewaan::findOrFail($request->id_sewa);
        
        // Cek keterlambatan
        $tenggatWaktu = Carbon::parse($penyewaan->tanggal_selesai)->endOfDay();
        $sekarang = now();
        $telatHari = 0;
        
        if ($sekarang->greaterThan($tenggatWaktu)) {
            $telatHari = $sekarang->diffInDays($tenggatWaktu) + 1; // +1 if partially late today
        }

        $dendaPerHari = 50000; // Contoh: 50rb per hari
        $totalDendaTelat = $telatHari * $dendaPerHari;
        
        $dendaKerusakan = $request->denda_kerusakan ? $request->denda_kerusakan : 0;
        $totalDenda = $totalDendaTelat + $dendaKerusakan;

        $kondisi = $request->kondisi ? implode(', ', $request->kondisi) : 'Aman';

        Pengembalian::create([
            'id_sewa' => $penyewaan->idsewa,
            'tanggal_kembali' => $sekarang,
            'kondisi' => $kondisi,
            'keterlambatan_hari' => $telatHari,
            'denda_per_hari' => $dendaPerHari,
            'denda_kerusakan' => $dendaKerusakan,
            'total_denda' => $totalDenda,
            'status' => 'selesai',
            'metode_kembali' => 'langsung' // as default
        ]);

        $penyewaan->status = 'selesai';
        $penyewaan->save();

        return redirect()->back()->with('success', 'Validasi pengembalian berhasil disimpan.');
    }
}
