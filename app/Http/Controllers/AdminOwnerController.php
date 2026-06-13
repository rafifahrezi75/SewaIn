<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminOwnerController extends Controller
{
    /**
     * Tampilkan halaman data admin & owner
     */
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['admin', 'owner']);
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('notelp', 'like', '%' . $request->search . '%');
            });
        }
        
        // Menggunakan paginate 10
        $usersList = $query->paginate(10);
        
        return view('admin.admin_owner', compact('usersList'));
    }

    /**
     * Simpan user admin/owner baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:user,email',
            'notelp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,owner',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'notelp' => $request->notelp,
            'alamat' => $request->alamat,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'User Admin / Owner berhasil ditambahkan!');
    }

    /**
     * Update data user admin/owner
     */
    public function update(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:user,id_user',
            'edit_nama' => 'required|string|max:255',
            'edit_email' => 'required|string|email|max:255|unique:user,email,' . $request->id_user . ',id_user',
            'edit_notelp' => 'nullable|string|max:20',
            'edit_alamat' => 'nullable|string',
            'edit_password' => 'nullable|string|min:8',
            'edit_role' => 'required|in:admin,owner',
        ]);

        $user = User::findOrFail($request->id_user);
        
        $data = [
            'nama' => $request->edit_nama,
            'email' => $request->edit_email,
            'notelp' => $request->edit_notelp,
            'alamat' => $request->edit_alamat,
            'role' => $request->edit_role,
        ];

        if ($request->filled('edit_password')) {
            $data['password'] = Hash::make($request->edit_password);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'User Admin / Owner berhasil diupdate!');
    }

    /**
     * Hapus data user admin/owner
     */
    public function destroy($id)
    {
        if ($id == auth()->id()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus diri sendiri!');
        }

        try {
            $user = User::findOrFail($id);
            $user->delete();

            $url = url()->previous();
            $components = parse_url($url);
            
            if (isset($components['query'])) {
                parse_str($components['query'], $query);
                if (isset($query['page']) && $query['page'] > 1) {
                    $total = User::whereIn('role', ['admin', 'owner'])->count();
                    $perPage = 10;
                    $maxPage = max(1, ceil($total / $perPage));
                    
                    if ($query['page'] > $maxPage) {
                        $query['page'] = $maxPage;
                        $components['query'] = http_build_query($query);
                        
                        $newUrl = $components['scheme'] . '://' . $components['host'] . (isset($components['port']) ? ':' . $components['port'] : '') . $components['path'] . '?' . $components['query'];
                        
                        return redirect($newUrl)->with('success', 'User berhasil dihapus!');
                    }
                }
            }

            return redirect()->back()->with('success', 'User berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus user. User mungkin memiliki relasi data lain.');
        }
    }
}
