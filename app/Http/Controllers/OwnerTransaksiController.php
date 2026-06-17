<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyewaan;
use App\Models\PenyewaanDetail;

class OwnerTransaksiController extends Controller
{
    public function transaksi(Request $request)
    {
        $query = Penyewaan::with(['user', 'details.alat', 'pengembalian']);

        if ($request->filled('search')) {
            $search = $request->search;
            
            // Ekstrak ID numerik jika input pencarian sesuai format invoice (INV-0002 atau 0002)
            $searchId = $search;
            if (preg_match('/^inv-0*(\d+)$/i', trim($search), $matches)) {
                $searchId = $matches[1];
            } elseif (preg_match('/^0+(\d+)$/', trim($search), $matches)) {
                $searchId = $matches[1];
            }

            $query->where(function($q) use ($search, $searchId) {
                $q->where('idsewa', 'like', "%{$searchId}%")
                  ->orWhereHas('user', function($uq) use ($search) {
                      $uq->where('nama', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('status') && is_array($request->status)) {
            $query->whereIn('status', $request->status);
        }

        if ($request->has('metode_pengiriman') && is_array($request->metode_pengiriman)) {
            $query->whereIn('metode_pengiriman', $request->metode_pengiriman);
        }

        if ($request->filled('tgl_awal')) {
            $query->whereDate('tanggal_mulai', '>=', $request->tgl_awal);
        }

        if ($request->filled('tgl_akhir')) {
            $query->whereDate('tanggal_selesai', '<=', $request->tgl_akhir);
        }

        $transaksi = $query->orderByDesc('created_at')->paginate(10);
        $transaksi->appends($request->all());

        return view('owner.transaksi', compact('transaksi'));
    }

    public function updateStatusTransaksi(Request $request)
    {
        $request->validate([
            'id_sewa' => 'required|exists:penyewaan,idsewa',
            'status_baru' => 'required|in:pending,disewa,selesai,dibatalkan'
        ]);

        $penyewaan = Penyewaan::findOrFail($request->id_sewa);
        $penyewaan->status = $request->status_baru;
        $penyewaan->save();

        return redirect()->back()->with('success', 'Status transaksi berhasil diperbarui.');
    }
}
