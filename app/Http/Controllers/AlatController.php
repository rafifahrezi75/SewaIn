<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\Kategori;

class AlatController extends Controller
{
    /**
     * Tampilkan halaman daftar alat produksi (Admin)
     */
    public function index(Request $request)
    {
        $query = Alat::with('kategori')->orderBy('idalat', 'desc');

        // Filter berdasarkan kategori jika ada
        if ($request->filled('idkategori_filter')) {
            $query->where('idkategori', $request->idkategori_filter);
        }

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where('nama_alat', 'like', '%' . $request->search . '%');
        }

        // Filter Stok (Tersedia / Habis)
        if ($request->filled('stok_tersedia') && !$request->filled('stok_habis')) {
            $query->where('stok', '>', 0);
        } elseif (!$request->filled('stok_tersedia') && $request->filled('stok_habis')) {
            $query->where('stok', '<=', 0);
        }

        // Filter Range Harga
        if ($request->filled('harga_min')) {
            $query->where('harga_sewa', '>=', $request->harga_min);
        }
        if ($request->filled('harga_max')) {
            $query->where('harga_sewa', '<=', $request->harga_max);
        }

        $alatList = $query->paginate(5);
        $kategoriList = Kategori::all();

        return view('admin.alat', compact('alatList', 'kategoriList'));
    }

    /**
     * Simpan alat produksi baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_alat' => 'required|string|max:255',
            'idkategori' => 'required|exists:kategori,id_kategori',
            'stok' => 'required|integer|min:0',
            'harga_sewa' => 'required|numeric|min:0',
            'deskripsi' => 'required|string',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama_alat.required' => 'Nama alat wajib diisi.',
            'idkategori.required' => 'Kategori wajib dipilih.',
            'stok.required' => 'Stok wajib diisi.',
            'harga_sewa.required' => 'Harga sewa wajib diisi.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'gambar.required' => 'Foto alat wajib diunggah.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus JPEG, PNG, atau JPG.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('alat', 'public');
        }

        Alat::create([
            'nama_alat' => $request->nama_alat,
            'idkategori' => $request->idkategori,
            'stok' => $request->stok,
            'harga_sewa' => $request->harga_sewa,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('admin.alat')->with('success', 'Alat produksi berhasil ditambahkan!');
    }

    /**
     * Update data alat produksi
     */
    public function update(Request $request)
    {
        $request->validate([
            'idalat_edit' => 'required|exists:alat,idalat',
            'nama_alat' => 'required|string|max:255',
            'idkategori' => 'required|exists:kategori,id_kategori',
            'stok' => 'required|integer|min:0',
            'harga_sewa' => 'required|numeric|min:0',
            'deskripsi' => 'required|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'nama_alat.required' => 'Nama alat wajib diisi.',
            'idkategori.required' => 'Kategori wajib dipilih.',
            'stok.required' => 'Stok wajib diisi.',
            'harga_sewa.required' => 'Harga sewa wajib diisi.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus JPEG, PNG, atau JPG.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $alat = Alat::findOrFail($request->idalat_edit);

        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($alat->gambar && \Illuminate\Support\Facades\Storage::disk('public')->exists($alat->gambar)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($alat->gambar);
            }
            $alat->gambar = $request->file('gambar')->store('alat', 'public');
        }

        $alat->nama_alat = $request->nama_alat;
        $alat->idkategori = $request->idkategori;
        $alat->stok = $request->stok;
        $alat->harga_sewa = $request->harga_sewa;
        $alat->deskripsi = $request->deskripsi;
        $alat->save();

        return redirect()->route('admin.alat')->with('success', 'Data alat berhasil diperbarui!');
    }

    /**
     * Hapus data alat produksi
     */
    public function destroy($id)
    {
        $alat = Alat::findOrFail($id);

        // Hapus gambar jika ada
        if ($alat->gambar && \Illuminate\Support\Facades\Storage::disk('public')->exists($alat->gambar)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($alat->gambar);
        }

        $alat->delete();

        return redirect()->route('admin.alat')->with('success', 'Data alat berhasil dihapus!');
    }
}
