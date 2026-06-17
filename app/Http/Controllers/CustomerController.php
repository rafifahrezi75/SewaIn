<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alat;
use App\Models\Kategori;
use App\Models\Keranjang;
use App\Models\Penyewaan;
use App\Models\PenyewaanDetail;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CustomerController extends Controller
{
    /**
     * Home / Welcome Page
     */
    public function home()
    {
        $query_katalog = Alat::with('kategori')
            ->where('status', 'tersedia')
            ->inRandomOrder()
            ->limit(6)
            ->get();

        $hero = Alat::whereNotNull('gambar')
            ->where('gambar', '!=', '')
            ->inRandomOrder()
            ->first();

        return view('welcome', compact('query_katalog', 'hero'));
    }

    /**
     * Catalog Page
     */
    public function katalog(Request $request)
    {
        $kat_filter = $request->input('kategori', 'Semua');
        $search_filter = $request->input('search', '');

        $kategoriList = Kategori::all();

        $query = Alat::with('kategori')->where('status', 'tersedia');

        if ($kat_filter !== 'Semua') {
            $query->whereHas('kategori', function ($q) use ($kat_filter) {
                $q->where('kategori', $kat_filter);
            });
        }

        if ($search_filter !== '') {
            $query->where('nama_alat', 'like', '%' . $search_filter . '%');
        }

        $produk_array = $query->get();

        return view('customer.katalog', compact('kategoriList', 'produk_array', 'kat_filter', 'search_filter'));
    }

    /**
     * Detail Tool Page
     */
    public function detail($id)
    {
        $alat = Alat::with(['kategori', 'spesifikasi', 'fotoDetail'])->findOrFail($id);
        return view('customer.detail', compact('alat'));
    }

    /**
     * Shopping Cart Listing Page
     */
    public function keranjang()
    {
        $id_user = Auth::id();
        $items = Keranjang::with('alat')->where('iduser', $id_user)->get();

        $total_item = $items->sum('jumlah');
        $total_biaya = $items->sum(function ($item) {
            return $item->alat->harga_sewa * $item->jumlah;
        });

        return view('customer.keranjang', compact('items', 'total_item', 'total_biaya'));
    }

    /**
     * Add to Cart Operation (AJAX endpoint)
     */
    public function addToCart(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 'error', 
                'message' => 'Silakan login terlebih dahulu untuk menyewa alat.'
            ]);
        }

        $id_user = Auth::id();
        $id_alat = (int)$request->input('idalat');
        $jumlah = (int)$request->input('jumlah', 1);

        $alat = Alat::find($id_alat);
        if (!$alat) {
            return response()->json(['status' => 'error', 'message' => 'Alat tidak ditemukan']);
        }

        $harga_sewa = $alat->harga_sewa;

        $cartItem = Keranjang::where('iduser', $id_user)->where('idalat', $id_alat)->first();
        $current_qty = $cartItem ? $cartItem->jumlah : 0;
        $new_qty = $current_qty + $jumlah;

        if ($new_qty > $alat->stok) {
            return response()->json([
                'status' => 'error',
                'message' => 'Jumlah sewa melebihi stok yang tersedia (Maksimal: ' . $alat->stok . ' unit. Di keranjang Anda: ' . $current_qty . ' unit).'
            ]);
        }

        if ($cartItem) {
            $cartItem->update([
                'jumlah' => $new_qty,
                'hargakeranjang' => $new_qty * $harga_sewa
            ]);
        } else {
            Keranjang::create([
                'iduser' => $id_user,
                'idalat' => $id_alat,
                'jumlah' => $jumlah,
                'hargakeranjang' => $jumlah * $harga_sewa
            ]);
        }

        $total_items = Keranjang::where('iduser', $id_user)->sum('jumlah');

        return response()->json(['status' => 'success', 'total_items' => $total_items]);
    }

    /**
     * Get Total Cart Count for floating badges (AJAX endpoint)
     */
    public function getCartCount()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }

        $count = Keranjang::where('iduser', Auth::id())->sum('jumlah');
        return response()->json(['count' => (int)$count]);
    }

    /**
     * Update Quantity inside shopping cart list
     */
    public function updateQty($id, $delta)
    {
        $id_user = Auth::id();
        $cartItem = Keranjang::with('alat')->where('id_keranjang', $id)->where('iduser', $id_user)->firstOrFail();

        $new_qty = $cartItem->jumlah + (int)$delta;

        if ($new_qty > $cartItem->alat->stok) {
            return redirect()->route('keranjang.index')->with('error', 'Jumlah sewa untuk ' . $cartItem->alat->nama_alat . ' melebihi stok yang tersedia (Maksimal: ' . $cartItem->alat->stok . ' unit).');
        }

        if ($new_qty >= 1) {
            $cartItem->update([
                'jumlah' => $new_qty,
                'hargakeranjang' => $new_qty * $cartItem->alat->harga_sewa
            ]);
        }

        return redirect()->route('keranjang.index');
    }

    /**
     * Delete item inside shopping cart
     */
    public function hapusItem($id)
    {
        $id_user = Auth::id();
        Keranjang::where('id_keranjang', $id)->where('iduser', $id_user)->delete();

        return redirect()->route('keranjang.index');
    }

    /**
     * Clear all items in shopping cart
     */
    public function kosongkanCart()
    {
        $id_user = Auth::id();
        Keranjang::where('iduser', $id_user)->delete();

        return redirect()->route('keranjang.index');
    }

    /**
     * Checkout Form Page
     */
    public function checkout()
    {
        $id_user = Auth::id();
        $items = Keranjang::with('alat')->where('iduser', $id_user)->get();

        if ($items->isEmpty()) {
            return redirect()->route('keranjang.index');
        }

        $user_data = Auth::user();
        if (empty($user_data->notelp) || empty($user_data->alamat)) {
            return redirect()->route('profil.edit')->with('error', 'Silakan lengkapi nomor telepon dan alamat terlebih dahulu sebelum melanjutkan checkout.');
        }

        $subtotal_alat = $items->sum(function ($item) {
            return $item->alat->harga_sewa * $item->jumlah;
        });

        return view('customer.checkout', compact('items', 'subtotal_alat', 'user_data'));
    }

    /**
     * Process Checkout Form (AJAX endpoint)
     */
    public function prosesCheckout(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Silakan login kembali.']);
        }

        $id_user = Auth::id();

        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'durasi' => 'required|integer|min:1',
            'metode_pengiriman' => 'required|string',
            'alamat_sewa' => 'required|string',
            'gambar_ktp' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $cartItems = Keranjang::with('alat')->where('iduser', $id_user)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Keranjang kosong.']);
        }

        // Handle file KTP upload
        $nama_file_ktp = "";
        if ($request->hasFile('gambar_ktp')) {
            $file = $request->file('gambar_ktp');
            $file_ext = strtolower($file->getClientOriginalExtension());
            $nama_file_ktp = "ktp_" . $id_user . "_" . time() . "." . $file_ext;
            // Store file on public disk inside the 'uploads' directory
            $file->storeAs('uploads', $nama_file_ktp, 'public');
        } else {
            return response()->json(['success' => false, 'message' => 'Harap upload foto KTP Anda.']);
        }

        $metode = $request->input('metode_pengiriman') === 'antar' ? 'Antar Lokasi' : 'Ambil Sendiri';

        // Save order to 'penyewaan'
        $penyewaan = Penyewaan::create([
            'iduser' => $id_user,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'durasi' => (int)$request->durasi,
            'metode_pengiriman' => $metode,
            'alamat_sewa' => $request->alamat_sewa,
            'lat_sewa' => $request->lat_sewa,
            'lon_sewa' => $request->lon_sewa,
            'ongkir' => (int)$request->input('ongkir', 0),
            'total_biaya' => (int)$request->input('total_biaya', 0),
            'status' => 'pending',
        ]);

        // Save detail to 'penyewaan_detail'
        foreach ($cartItems as $item) {
            PenyewaanDetail::create([
                'idsewa' => $penyewaan->idsewa,
                'idalat' => $item->idalat,
                'jumlah' => $item->jumlah,
                'harga' => $item->alat->harga_sewa,
                'subtotal' => $item->jumlah * $item->alat->harga_sewa * (int)$request->durasi,
                'gambar_ktp' => $nama_file_ktp,
            ]);
        }

        // Empty cart
        Keranjang::where('iduser', $id_user)->delete();

        return response()->json(['success' => true, 'idsewa' => $penyewaan->idsewa]);
    }

    /**
     * Checkout Success Confirmation Page
     */
    public function checkoutSukses($id)
    {
        $id_user = Auth::id();
        $data_sewa = Penyewaan::with('user')->where('idsewa', $id)->where('iduser', $id_user)->firstOrFail();

        $details = PenyewaanDetail::with('alat')->where('idsewa', $id)->get();

        $items_list = "";
        foreach ($details as $item) {
            $items_list .= "- " . $item->alat->nama_alat . " (" . $item->jumlah . " Unit)\n";
        }

        $metode = $data_sewa->metode_pengiriman ?: 'Ambil Sendiri';
        $durasi = $data_sewa->durasi ?: 1;

        $wa_number = "6287776600292";
        $msg_template = "*HALO ADMIN SEWAIN!*\n\n"
                      . "SAYA TELAH MELAKUKAN PEMESANAN BARU:\n"
                      . "*ID PESANAN:* #%s\n\n"
                      . "*DETAIL ALAT:*\n%s\n"
                      . "*DATA PENYEWA:*\n"
                      . "- Nama: %s\n"
                      . "- WA: %s\n"
                      . "- Periode: %s s/d %s (%s Hari)\n"
                      . "- Metode: %s\n"
                      . "- Total: Rp%s\n\n"
                      . "Mohon segera diproses ya admin, terima kasih!";

        $msg_full = sprintf(
            $msg_template,
            $id,
            $items_list,
            $data_sewa->user->nama,
            $data_sewa->user->notelp,
            $data_sewa->tanggal_mulai,
            $data_sewa->tanggal_selesai,
            $durasi,
            $metode,
            number_format($data_sewa->total_biaya, 0, ',', '.')
        );

        $wa_url = "https://wa.me/{$wa_number}?text=" . urlencode($msg_full);

        return view('customer.checkout_success', compact('data_sewa', 'wa_url'));
    }

    /**
     * Rental History Page
     */
    public function riwayat()
    {
        $id_user = Auth::id();

        // Active rentals (pending, disewa, kembali, menunggu qc)
        $q_aktif = Penyewaan::with(['details.alat'])
            ->where('iduser', $id_user)
            ->whereNotIn('status', ['selesai', 'dibatalkan', 'ditolak'])
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        // Completed rentals (selesai)
        $q_selesai = Penyewaan::with(['details.alat'])
            ->where('iduser', $id_user)
            ->where('status', 'selesai')
            ->orderBy('tanggal_selesai', 'desc')
            ->get();

        return view('customer.riwayat', compact('q_aktif', 'q_selesai'));
    }

    /**
     * Edit Profile Page
     */
    public function editProfile()
    {
        $user_data = Auth::user();
        return view('customer.profil', compact('user_data'));
    }

    /**
     * Update Profile Process
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'notelp' => 'required|string|max:20',
            'alamat' => 'required|string',
        ]);

        $user->nama = $request->nama;
        $user->notelp = $request->notelp;
        $user->alamat = $request->alamat;
        $user->save();

        return redirect()->route('profil.edit')->with('success', 'Profil Anda berhasil diperbarui.');
    }
}
