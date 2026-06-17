<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\AlatController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\OwnerTransaksiController;
use App\Http\Controllers\AdminOwnerController;

use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SpesifikasiController;
use App\Http\Controllers\FotoDetailController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
|
*/

Route::get('/', [CustomerController::class, 'home'])->name('home');
Route::get('/katalog', [CustomerController::class, 'katalog'])->name('katalog.index');
Route::get('/alat/{id}', [CustomerController::class, 'detail'])->name('alat.detail');
Route::get('/keranjang/count', [CustomerController::class, 'getCartCount'])->name('keranjang.count');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Customer auth protected routes
Route::middleware('auth')->group(function () {
    Route::get('/keranjang', [CustomerController::class, 'keranjang'])->name('keranjang.index');
    Route::post('/keranjang/add', [CustomerController::class, 'addToCart'])->name('keranjang.add');
    Route::get('/keranjang/update/{id}/{delta}', [CustomerController::class, 'updateQty'])->name('keranjang.update');
    Route::get('/keranjang/hapus/{id}', [CustomerController::class, 'hapusItem'])->name('keranjang.hapus');
    Route::get('/keranjang/kosongkan', [CustomerController::class, 'kosongkanCart'])->name('keranjang.kosongkan');
    
    Route::get('/checkout', [CustomerController::class, 'checkout'])->name('checkout.index');
    Route::post('/checkout/proses', [CustomerController::class, 'prosesCheckout'])->name('checkout.proses');
    Route::get('/checkout/sukses/{id}', [CustomerController::class, 'checkoutSukses'])->name('checkout.sukses');
    
    Route::get('/riwayat-sewa', [CustomerController::class, 'riwayat'])->name('riwayat.sewa');
    Route::get('/riwayat-sewa/nota/{id}', [CustomerController::class, 'cetakNota'])->name('riwayat.nota');
    Route::get('/profil', [CustomerController::class, 'editProfile'])->name('profil.edit');
    Route::post('/profil/update', [CustomerController::class, 'updateProfile'])->name('profil.update');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/admin/kategori', [KategoriController::class, 'index'])->name('admin.kategori');
    Route::post('/admin/kategori', [KategoriController::class, 'store']);
    Route::put('/admin/kategori/update', [KategoriController::class, 'update']);
    Route::delete('/admin/kategori/{id}', [KategoriController::class, 'destroy']);

    Route::get('/admin/alat', [AlatController::class, 'index'])->name('admin.alat');
    Route::post('/admin/alat', [AlatController::class, 'store'])->name('admin.alat.store');
    Route::put('/admin/alat/update', [AlatController::class, 'update'])->name('admin.alat.update');
    Route::delete('/admin/alat/{id}', [AlatController::class, 'destroy'])->name('admin.alat.destroy');
    Route::get('/admin/alat/{id}', [AlatController::class, 'show'])->name('admin.alat.show');

    Route::post('/admin/spesifikasi', [SpesifikasiController::class, 'store'])->name('admin.spesifikasi.store');
    Route::put('/admin/spesifikasi/update', [SpesifikasiController::class, 'update'])->name('admin.spesifikasi.update');
    Route::delete('/admin/spesifikasi/{id}', [SpesifikasiController::class, 'destroy'])->name('admin.spesifikasi.destroy');

    Route::post('/admin/fotodetail', [FotoDetailController::class, 'store'])->name('admin.fotodetail.store');
    Route::delete('/admin/fotodetail/{id}', [FotoDetailController::class, 'destroy'])->name('admin.fotodetail.destroy');

    Route::get('/admin/transaksi', function () { return view('admin.transaksi'); });
    Route::get('/admin/pengembalian', [PengembalianController::class, 'index'])->name('admin.pengembalian');
    Route::post('/admin/pengembalian/validasi', [PengembalianController::class, 'validasi'])->name('admin.pengembalian.validasi');
    Route::get('/admin/pelanggan', [PelangganController::class, 'index'])->name('admin.pelanggan');
    Route::get('/admin/pelanggan/export', [PelangganController::class, 'export'])->name('admin.pelanggan.export');
    Route::get('/admin/pengaturan', function () { return view('admin.pengaturan'); });
    Route::get('/admin/admin-owner', [AdminOwnerController::class, 'index'])->name('admin.admin-owner');
    Route::post('/admin/admin-owner', [AdminOwnerController::class, 'store'])->name('admin.admin-owner.store');
    Route::put('/admin/admin-owner/update', [AdminOwnerController::class, 'update'])->name('admin.admin-owner.update');
    Route::delete('/admin/admin-owner/{id}', [AdminOwnerController::class, 'destroy'])->name('admin.admin-owner.destroy');
});

Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/owner/dashboard', [OwnerController::class, 'dashboard'])->name('owner.dashboard');
    Route::get('/owner/transaksi', [OwnerTransaksiController::class, 'transaksi'])->name('owner.transaksi');
    Route::post('/owner/transaksi/update-status', [OwnerTransaksiController::class, 'updateStatusTransaksi'])->name('owner.transaksi.update');
    Route::get('/owner/pengembalian', [PengembalianController::class, 'index'])->name('owner.pengembalian');
    Route::post('/owner/pengembalian/validasi', [PengembalianController::class, 'validasi'])->name('owner.pengembalian.validasi');
    Route::get('/owner/cetak-laporan', [App\Http\Controllers\LaporanController::class, 'index'])->name('owner.cetak_laporan');
});

