<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penyewaan;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Penyewaan::with(['user', 'details.alat']);

        if ($request->filled('tgl_awal')) {
            $query->whereDate('created_at', '>=', $request->tgl_awal);
        }

        if ($request->filled('tgl_akhir')) {
            $query->whereDate('created_at', '<=', $request->tgl_akhir);
        }

        if ($request->has('print')) {
            $transaksi = $query->orderByDesc('created_at')->get();
            return view('owner.laporan_pdf', compact('transaksi'));
        }

        $transaksi = $query->orderByDesc('created_at')->paginate(10);
        $transaksi->appends($request->all());

        return view('owner.cetak_laporan', compact('transaksi'));
    }
}
