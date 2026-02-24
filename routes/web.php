<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/login', function () {
    return view('admin.login');
});

Route::get('/register', function () {
    return view('admin.register');
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/admin/kategori', function () {
    return view('admin.kategori');
});

Route::get('/admin/alat', function () {
    return view('admin.alat');
});

Route::get('/admin/transaksi', function () {
    return view('admin.transaksi');
});

Route::get('/admin/pengembalian', function () {
    return view('admin.pengembalian');
});

Route::get('/admin/pelanggan', function () {
    return view('admin.pelanggan');
});

Route::get('/admin/pengaturan', function () {
    return view('admin.pengaturan');
});
