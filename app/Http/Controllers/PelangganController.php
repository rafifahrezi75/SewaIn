<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PelangganController extends Controller
{
    /**
     * Tampilkan halaman data pelanggan
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'user');
        
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

    /**
     * Export data pelanggan ke CSV
     */
    public function export(Request $request)
    {
        $query = User::where('role', 'user');

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('notelp', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->get();

        $fileName = 'data-pelanggan-' . date('Y-m-d') . '.csv';

        $headers = array(
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('ID Pelanggan', 'Nama', 'Email', 'No Telepon', 'Tanggal Bergabung');

        $callback = function() use($users, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($users as $user) {
                fputcsv($file, array(
                    'PLG-' . str_pad($user->id_user, 4, '0', STR_PAD_LEFT),
                    $user->nama,
                    $user->email,
                    $user->notelp ?? '-',
                    $user->created_at ? $user->created_at->format('Y-m-d H:i:s') : '-'
                ));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
