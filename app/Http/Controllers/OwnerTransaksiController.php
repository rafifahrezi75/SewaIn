<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyewaan;
use App\Models\PenyewaanDetail;

class OwnerTransaksiController extends Controller
{
    public function transaksi(Request $request)
    {
        $query = Penyewaan::with(['user', 'details.alat']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('idsewa', 'like', "%{$search}%")
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
            $query->whereDate('created_at', '>=', $request->tgl_awal);
        }

        if ($request->filled('tgl_akhir')) {
            $query->whereDate('created_at', '<=', $request->tgl_akhir);
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
