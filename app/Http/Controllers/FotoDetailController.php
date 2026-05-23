<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FotoDetail;
use Illuminate\Support\Facades\Storage;

class FotoDetailController extends Controller
{
    /**
     * Store a newly uploaded detailed photo.
     */
    public function store(Request $request)
    {
        $request->validate([
            'idalat' => 'required|exists:alat,idalat',
            'fotodetail' => 'required|image|mimes:jpeg,png,jpg,webp|max:3072',
        ], [
            'fotodetail.required' => 'File gambar wajib diunggah.',
            'fotodetail.image' => 'File harus berupa gambar.',
            'fotodetail.mimes' => 'Format gambar harus JPEG, PNG, JPG, atau WEBP.',
            'fotodetail.max' => 'Ukuran gambar maksimal 3MB.',
        ]);

        $idalat = $request->idalat;

        if ($request->hasFile('fotodetail')) {
            $file = $request->file('fotodetail');
            $ekstensi = strtolower($file->getClientOriginalExtension());
            $nama_file = time() . '-' . uniqid() . '.' . $ekstensi;
            
            // Simpan di storage/app/public/uploads/
            $file->storeAs('uploads', $nama_file, 'public');

            FotoDetail::create([
                'idalat' => $idalat,
                'fotodetail' => 'uploads/' . $nama_file,
            ]);

            return redirect()->route('admin.alat.show', $idalat)->with('pesan', 'berhasil_tambah_foto');
        }

        return redirect()->route('admin.alat.show', $idalat)->with('pesan', 'gagal_tambah_foto');
    }

    /**
     * Remove the specified detailed photo.
     */
    public function destroy($id)
    {
        $foto = FotoDetail::findOrFail($id);
        $idalat = $foto->idalat;

        // Hapus fisik file dari storage jika ada
        if ($foto->fotodetail) {
            $filePath = $foto->fotodetail;
            
            // Clean path
            if (str_starts_with($filePath, 'uploads/')) {
                $filePath = substr($filePath, 8);
            }
            
            if (Storage::disk('public')->exists('uploads/' . $filePath)) {
                Storage::disk('public')->delete('uploads/' . $filePath);
            }
        }

        $foto->delete();

        return redirect()->route('admin.alat.show', $idalat)->with('pesan', 'berhasil_hapus_foto');
    }
}
