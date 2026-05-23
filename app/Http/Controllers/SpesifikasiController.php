<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spesifikasi;

class SpesifikasiController extends Controller
{
    /**
     * Store a newly created specification.
     */
    public function store(Request $request)
    {
        $request->validate([
            'idalat' => 'required|exists:alat,idalat',
            'spek' => 'required|string|max:255',
            'iconspek' => 'nullable|string|max:255',
            'satuan' => 'required|string|max:255',
        ], [
            'spek.required' => 'Nama spesifikasi wajib diisi.',
            'satuan.required' => 'Satuan / Nilai wajib diisi.',
        ]);

        Spesifikasi::create([
            'idalat' => $request->idalat,
            'spek' => $request->spek,
            'iconspek' => $request->iconspek,
            'satuan' => $request->satuan,
        ]);

        return redirect()->route('admin.alat.show', $request->idalat)->with('pesan', 'berhasil_tambah_spek');
    }

    /**
     * Update the specified specification.
     */
    public function update(Request $request)
    {
        $request->validate([
            'idspek' => 'required|exists:spesifikasi,id_spek',
            'spek' => 'required|string|max:255',
            'iconspek' => 'nullable|string|max:255',
            'satuan' => 'required|string|max:255',
        ], [
            'spek.required' => 'Nama spesifikasi wajib diisi.',
            'satuan.required' => 'Satuan / Nilai wajib diisi.',
        ]);

        $spek = Spesifikasi::findOrFail($request->idspek);
        $spek->update([
            'spek' => $request->spek,
            'iconspek' => $request->iconspek,
            'satuan' => $request->satuan,
        ]);

        return redirect()->route('admin.alat.show', $spek->idalat)->with('pesan', 'berhasil_update_spek');
    }

    /**
     * Remove the specified specification.
     */
    public function destroy($id)
    {
        $spek = Spesifikasi::findOrFail($id);
        $idalat = $spek->idalat;
        $spek->delete();

        return redirect()->route('admin.alat.show', $idalat)->with('pesan', 'berhasil_hapus_spek');
    }
}
