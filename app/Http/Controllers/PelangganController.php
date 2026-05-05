<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PelangganController extends Controller
{
    /**
     * Tampilkan halaman data pelanggan UMKM (owner)
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'owner');
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('notelp', 'like', '%' . $request->search . '%');
            });
        }
        
        // Menggunakan paginate 10 (atau 2 untuk testing)
        $pelangganList = $query->paginate(10);
        
        return view('admin.pelanggan', compact('pelangganList'));
    }
}
