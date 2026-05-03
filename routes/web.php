<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\AlatController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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

    Route::get('/admin/transaksi', function () { return view('admin.transaksi'); });
    Route::get('/admin/pengembalian', function () { return view('admin.pengembalian'); });
    Route::get('/admin/pelanggan', function () { return view('admin.pelanggan'); });
    Route::get('/admin/pengaturan', function () { return view('admin.pengaturan'); });
});

Route::middleware(['auth', 'role:owner'])->group(function () {
    Route::get('/owner/dashboard', function () { return view('owner.dashboard'); });
    Route::get('/owner/transaksi', function () { return view('owner.transaksi'); });
    Route::get('/owner/pengembalian', function () { return view('owner.pengembalian'); });
    Route::get('/owner/cetak-laporan', function () { return view('owner.cetak_laporan'); });
});

