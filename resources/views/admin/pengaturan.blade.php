@extends('layouts.admin')

@section('title', 'Pengaturan Sistem')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Pengaturan Sistem Rental (SewaIN)</h2>
        <p class="text-sm text-gray-500 mt-1">Konfigurasi operasional penyewaan dan pengiriman</p>
    </div>

    <form class="space-y-6">
        
        <!-- Seksi 1: Profile App -->
        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden">
            <div class="border-b border-gray-100 bg-gray-50/50 px-6 py-4">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <i class='bx bx-building text-brand-500'></i>
                    Profil Usaha
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Perusahaan / Aplikasi</label>
                        <input type="text" class="w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500" value="SewaIN Platform" placeholder="Nama aplikasi">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email Perusahaan</label>
                        <input type="email" class="w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500" value="admin@sewain.co.id" placeholder="email@contoh.com">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Gudang Utama (Titik Penjemputan)</label>
                    <textarea rows="3" class="w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500">Jl. Industri Raya Blok C1 No.12, Kawasan Pergudangan Sentosa, Jakarta</textarea>
                    <p class="text-xs text-gray-500 mt-1">*Alamat ini digunakan oleh Google Maps API sebagai titik awal penentuan jarak dan Ongkir.</p>
                </div>
            </div>
        </div>

        <!-- Seksi 2: Ongkos Kirim & Radius -->
        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden">
            <div class="border-b border-gray-100 bg-gray-50/50 px-6 py-4">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <i class='bx bx-map-alt text-brand-500'></i>
                    Pengaturan Pengiriman (Opsional Kurir)
                </h3>
            </div>
            <div class="p-6 space-y-4">
                
                <div class="flex items-center gap-3 mb-6">
                    <input type="checkbox" id="aktif_kirim" class="w-5 h-5 rounded border-gray-300 text-brand-600 focus:ring-brand-500" checked>
                    <label for="aktif_kirim" class="font-medium text-gray-700">Aktifkan opsi "Kirim ke Penyewa" untuk pelanggan UMKM</label>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50/50 rounded-xl p-4 border border-gray-100">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tarif Ongkos Kirim / KM (Rp)</label>
                        <input type="number" min="0" step="500" class="w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500" value="5000">
                        <p class="text-[10px] sm:text-xs text-gray-500 mt-1">Sistem mencari: Jarak x Tarif</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Batas Maksimal Radius Kirim (KM)</label>
                        <input type="number" min="1" class="w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500" value="30">
                        <p class="text-[10px] sm:text-xs text-gray-500 mt-1">Alamat toko melebihi batas ini akan ditolak opsi kirimnya.</p>
                    </div>
                </div>

            </div>
        </div>

        <!-- Seksi 3: Aturan Penyewaan -->
        <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden">
            <div class="border-b border-gray-100 bg-gray-50/50 px-6 py-4">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <i class='bx bx-calendar-event text-brand-500'></i>
                    Aturan Penyewaan & Denda
                </h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Maksimal Hari Pemesanan ke Depan</label>
                        <select class="w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500">
                            <option value="30">1 Bulan</option>
                            <option value="90" selected>3 Bulan</option>
                            <option value="180">6 Bulan</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Pembatasan kalender booking di sisi UX Customer.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Denda Terlambat / Hari (%)</label>
                        <input type="number" min="0" max="100" class="w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500" value="100">
                        <p class="text-xs text-gray-500 mt-1">Persentase dari harga sewa barang harian (Contoh 100% = Denda 1x harga sewa/hari).</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-4 mb-20">
            <button type="button" class="rounded-xl bg-brand-500 px-8 py-3 font-semibold text-white shadow-sm hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition-all">
                Simpan Konfigurasi
            </button>
        </div>

    </form>
</div>
@endsection
