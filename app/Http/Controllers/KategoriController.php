<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    /**
     * Tampilkan halaman daftar kategori (Admin)
     */
    public function index()
    {
        $kategoriList = Kategori::orderBy('id_kategori', 'desc')->paginate(5);
        return view('admin.kategori', compact('kategoriList'));
    }

    /**
     * Simpan kategori baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
        ]);

        Kategori::create([
            'kategori' => $request->nama_kategori,
            'icon' => $request->icon ?? 'bx-layer',
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Update kategori
     */
    public function update(Request $request)
    {
        $request->validate([
            'idkategori' => 'required|exists:kategori,id_kategori',
            'edit_nama_kategori' => 'required|string|max:255',
            'edit_icon' => 'nullable|string|max:255',
        ]);

        $kategori = Kategori::findOrFail($request->idkategori);
        $kategori->update([
            'kategori' => $request->edit_nama_kategori,
            'icon' => $request->edit_icon ?? 'bx-layer',
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diupdate!');
    }

    /**
     * Hapus kategori
     */
    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        $url = url()->previous();
        $components = parse_url($url);
        
        if (isset($components['query'])) {
            parse_str($components['query'], $query);
            if (isset($query['page']) && $query['page'] > 1) {
                $total = Kategori::count();
                $perPage = 5;
                $maxPage = max(1, ceil($total / $perPage));
                
                if ($query['page'] > $maxPage) {
                    $query['page'] = $maxPage;
                    $components['query'] = http_build_query($query);
                    
                    $newUrl = $components['scheme'] . '://' . $components['host'] . (isset($components['port']) ? ':' . $components['port'] : '') . $components['path'] . '?' . $components['query'];
                    
                    return redirect($newUrl)->with('success', 'Kategori berhasil dihapus!');
                }
            }
        }

        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}
