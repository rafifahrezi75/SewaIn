<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivitas Sewa - SewaIn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F1F5F9;
        }

        .cartoon-border {
            border: 3px solid #000;
        }

        .cartoon-shadow {
            box-shadow: 6px 6px 0px 0px rgba(0, 0, 0, 1);
        }

        .cartoon-shadow-sm {
            box-shadow: 4px 4px 0px 0px rgba(0, 0, 0, 1);
        }

        .tab-active {
            background-color: #FACC15 !important; /* Kuning Terang */
            transform: translate(-2px, -2px);
            box-shadow: 4px 4px 0px 0px #000;
        }

        [x-cloak] { display: none !important; }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="p-4 md:p-8" x-data="{ tab: 'aktif', modalOpen: false, returnInv: '', returnName: '', detailOpen: false, selectedSewa: null }">

    <div class="max-w-4xl mx-auto">
        <div class="flex items-center gap-4 mb-10 text-left">
            <a href="{{ route('home') }}"
                class="w-12 h-12 bg-white cartoon-border rounded-2xl flex items-center justify-center cartoon-shadow-sm hover:bg-yellow-50 transition-all">
                <i data-lucide="arrow-left" class="w-6 h-6"></i>
            </a>
            <div>
                <h1 class="text-3xl font-black uppercase italic tracking-tighter text-slate-900">Aktivitas Sewa</h1>
            </div>
        </div>

        <div class="flex gap-4 mb-8">
            <button @click="tab = 'aktif'" 
                :class="tab === 'aktif' ? 'tab-active' : ''"
                class="px-6 py-3 bg-white cartoon-border rounded-xl font-black text-xs uppercase italic transition-all">
                Sewa Aktif ({{ $q_aktif->count() }})
            </button>
            <button @click="tab = 'selesai'" 
                :class="tab === 'selesai' ? 'tab-active' : ''"
                class="px-6 py-3 bg-white cartoon-border rounded-xl font-black text-xs uppercase italic hover:bg-slate-50 transition-all">
                Riwayat Selesai ({{ $q_selesai->count() }})
            </button>
        </div>

        <div x-show="tab === 'aktif'" class="space-y-6 text-left" x-transition.opacity>
            @if ($q_aktif->count() > 0)
                @foreach ($q_aktif as $row)
                    @php 
                        $inv = "INV-" . str_pad($row->idsewa, 4, '0', STR_PAD_LEFT);
                        $firstDetail = $row->details->first();
                        $tampil_nama = $firstDetail && $firstDetail->alat ? $firstDetail->alat->nama_alat : 'Alat';
                        if ($row->details->count() > 1) {
                            $tampil_nama .= " (+ " . ($row->details->count() - 1) . " item lainnya)";
                        }
                        
                        $is_pending = ($row->status == 'pending');
                        $is_disewa = ($row->status == 'disewa');
                        $is_qc = in_array(strtolower($row->status), ['kembali', 'menunggu qc']);
                    @endphp

                    @if ($is_disewa)
                        <div class="bg-white cartoon-border cartoon-shadow rounded-[2.5rem] p-6 flex flex-col md:flex-row items-center gap-6 border-b-[8px]">
                            <div class="w-24 h-24 bg-blue-100 cartoon-border rounded-[1.5rem] flex items-center justify-center shrink-0 overflow-hidden">
                                @if($firstDetail && $firstDetail->alat && $firstDetail->alat->gambar)
                                    <img src="{{ asset('storage/' . $firstDetail->alat->gambar) }}" class="w-full h-full object-cover">
                                @else
                                    <i data-lucide="package" class="w-12 h-12 text-blue-600"></i>
                                @endif
                            </div>

                            <div class="flex-1 text-center md:text-left">
                                <div class="flex flex-wrap justify-center md:justify-start items-center gap-2 mb-2">
                                    <span class="bg-blue-100 text-blue-600 text-[9px] font-black px-3 py-1 rounded-full cartoon-border uppercase tracking-widest">Sedang Digunakan</span>
                                    <span class="text-[9px] font-black text-slate-400 uppercase italic">#{{ $inv }}</span>
                                </div>
                                <h3 class="text-xl font-black uppercase italic text-slate-900">{{ $tampil_nama }}</h3>
                                <div class="flex items-center justify-center md:justify-start gap-4 mt-2">
                                    <div class="flex items-center gap-1.5">
                                        <i data-lucide="calendar" class="w-3.5 h-3.5 text-slate-400"></i>
                                        <span class="text-[10px] font-bold text-slate-500 uppercase">Deadline: {{ date('d M Y', strtotime($row->tanggal_selesai)) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="w-full md:w-auto flex flex-wrap gap-3 justify-center items-center">
                                <button @click="selectedSewa = {{ json_encode($row->load('details.alat')) }}; detailOpen = true"
                                    class="px-4 py-2 border-2 border-black rounded-xl font-black text-[10px] uppercase italic bg-white cartoon-shadow-sm active:translate-y-0.5 transition-all">
                                    Detail
                                </button>
                                <a href="{{ route('riwayat.nota', $row->idsewa) }}" target="_blank"
                                    class="px-4 py-2 border-2 border-black rounded-xl font-black text-[10px] uppercase italic bg-yellow-300 cartoon-shadow-sm active:translate-y-0.5 transition-all flex items-center justify-center gap-1.5">
                                    <i data-lucide="printer" class="w-3.5 h-3.5"></i> Struk
                                </a>
                                <button @click="modalOpen = true; returnInv = '{{ $inv }}'; returnName = '{{ addslashes($firstDetail && $firstDetail->alat ? $firstDetail->alat->nama_alat : 'Alat') }}'"
                                    class="bg-red-700 text-white px-6 py-3 rounded-xl cartoon-border cartoon-shadow-sm font-black text-[10px] uppercase italic hover:translate-x-1 hover:translate-y-1 hover:shadow-none transition-all active:scale-95">
                                    Kembalikan Alat
                                </button>
                            </div>
                        </div>

                    @elseif ($is_pending)
                        <div class="bg-slate-50 cartoon-border rounded-[2.5rem] p-6 flex flex-col md:flex-row items-center gap-6 border-dashed">
                            <div class="w-24 h-24 bg-slate-200 cartoon-border rounded-[1.5rem] flex items-center justify-center shrink-0 overflow-hidden">
                                @if($firstDetail && $firstDetail->alat && $firstDetail->alat->gambar)
                                    <img src="{{ asset('storage/' . $firstDetail->alat->gambar) }}" class="w-full h-full object-cover grayscale opacity-70">
                                @else
                                    <i data-lucide="hourglass" class="w-12 h-12 text-slate-500"></i>
                                @endif
                            </div>
                            <div class="flex-1 text-center md:text-left">
                                <div class="flex flex-wrap justify-center md:justify-start items-center gap-2 mb-2">
                                    <span class="bg-orange-100 text-orange-600 text-[9px] font-black px-3 py-1 rounded-full cartoon-border uppercase animate-pulse italic">Menunggu Konfirmasi</span>
                                    <span class="text-[9px] font-black text-slate-400 uppercase italic">#{{ $inv }}</span>
                                </div>
                                <h3 class="text-xl font-black uppercase italic text-slate-600 tracking-tighter">{{ $tampil_nama }}</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase mt-1 italic leading-tight">Admin sedang memverifikasi pesanan Anda.</p>
                            </div>
                            <div class="w-full md:w-auto flex flex-wrap gap-3 justify-center items-center">
                                <button @click="selectedSewa = {{ json_encode($row->load('details.alat')) }}; detailOpen = true"
                                    class="px-4 py-2 border-2 border-black rounded-xl font-black text-[10px] uppercase italic bg-white cartoon-shadow-sm active:translate-y-0.5 transition-all">
                                    Detail
                                </button>
                                <a href="{{ route('riwayat.nota', $row->idsewa) }}" target="_blank"
                                    class="px-4 py-2 border-2 border-black rounded-xl font-black text-[10px] uppercase italic bg-yellow-300 cartoon-shadow-sm active:translate-y-0.5 transition-all flex items-center justify-center gap-1.5">
                                    <i data-lucide="printer" class="w-3.5 h-3.5"></i> Struk
                                </a>
                                <div class="px-6 py-3 bg-slate-200 cartoon-border rounded-xl font-black text-[10px] text-slate-500 uppercase italic text-center">
                                    PENDING
                                </div>
                            </div>
                        </div>

                    @elseif ($is_qc)
                        <div class="bg-slate-50 opacity-80 cartoon-border rounded-[2.5rem] p-6 flex flex-col md:flex-row items-center gap-6 border-dashed border-slate-300">
                            <div class="w-24 h-24 bg-white cartoon-border rounded-[1.5rem] flex items-center justify-center shrink-0 grayscale overflow-hidden">
                                @if($firstDetail && $firstDetail->alat && $firstDetail->alat->gambar)
                                    <img src="{{ asset('storage/' . $firstDetail->alat->gambar) }}" class="w-full h-full object-cover">
                                @else
                                    <i data-lucide="search" class="w-12 h-12 text-slate-400"></i>
                                @endif
                            </div>
                            <div class="flex-1 text-center md:text-left">
                                <div class="flex flex-wrap justify-center md:justify-start items-center gap-2 mb-2">
                                    <span class="bg-yellow-100 text-yellow-600 text-[9px] font-black px-3 py-1 rounded-full cartoon-border uppercase animate-pulse italic">Menunggu Validasi Admin</span>
                                    <span class="text-[9px] font-black text-slate-400 uppercase italic">#{{ $inv }}</span>
                                </div>
                                <h3 class="text-xl font-black uppercase italic text-slate-400 tracking-tighter">{{ $tampil_nama }}</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase mt-1 italic leading-tight">Unit sedang dalam pengecekan QC di gudang.</p>
                            </div>
                            <div class="w-full md:w-auto flex flex-wrap gap-3 justify-center items-center">
                                <button @click="selectedSewa = {{ json_encode($row->load('details.alat')) }}; detailOpen = true"
                                    class="px-4 py-2 border-2 border-black rounded-xl font-black text-[10px] uppercase italic bg-white cartoon-shadow-sm active:translate-y-0.5 transition-all">
                                    Detail
                                </button>
                                <a href="{{ route('riwayat.nota', $row->idsewa) }}" target="_blank"
                                    class="px-4 py-2 border-2 border-black rounded-xl font-black text-[10px] uppercase italic bg-yellow-300 cartoon-shadow-sm active:translate-y-0.5 transition-all flex items-center justify-center gap-1.5">
                                    <i data-lucide="printer" class="w-3.5 h-3.5"></i> Struk
                                </a>
                                <div class="px-6 py-3 bg-slate-200 cartoon-border rounded-xl font-black text-[10px] text-slate-400 uppercase italic text-center">
                                    PROSES QC
                                </div>
                            </div>
                        </div>
                    @endif

                @endforeach
            @else
                <div class="text-center py-12 px-6 bg-white cartoon-border rounded-[2.5rem]">
                    <i data-lucide="inbox" class="w-16 h-16 text-slate-300 mx-auto mb-4"></i>
                    <h3 class="text-lg font-black uppercase italic text-slate-400">Belum ada aktivitas sewa</h3>
                    <a href="{{ route('home') }}" class="inline-block mt-4 bg-yellow-400 cartoon-border cartoon-shadow-sm px-6 py-3 rounded-xl font-black text-xs uppercase italic hover:bg-yellow-300 transition-all">Mulai Sewa Alat</a>
                </div>
            @endif
        </div>

        <div x-show="tab === 'selesai'" class="space-y-6 text-left" x-transition.opacity x-cloak>
            @if ($q_selesai->count() > 0)
                @foreach ($q_selesai as $row)
                    @php 
                        $inv = "INV-" . str_pad($row->idsewa, 4, '0', STR_PAD_LEFT);
                        $firstDetail = $row->details->first();
                        $tampil_nama = $firstDetail && $firstDetail->alat ? $firstDetail->alat->nama_alat : 'Alat';
                        if ($row->details->count() > 1) {
                            $tampil_nama .= " (+ " . ($row->details->count() - 1) . " item lainnya)";
                        }
                    @endphp
                    <div class="bg-white cartoon-border rounded-[2.5rem] p-6 flex flex-col md:flex-row items-center gap-6 border-b-[8px] border-slate-300">
                        <div class="w-20 h-20 bg-slate-100 cartoon-border rounded-2xl flex items-center justify-center overflow-hidden opacity-65 grayscale">
                            @if($firstDetail && $firstDetail->alat && $firstDetail->alat->gambar)
                                <img src="{{ asset('storage/' . $firstDetail->alat->gambar) }}" class="w-full h-full object-cover">
                            @else
                                <i data-lucide="check-circle" class="w-10 h-10 text-slate-400"></i>
                            @endif
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <span class="text-[9px] font-black text-slate-400 uppercase italic">#{{ $inv }}</span>
                            <h3 class="text-lg font-black uppercase italic text-slate-700 leading-none mb-1 mt-1">{{ $tampil_nama }}</h3>
                            <p class="text-[10px] font-bold text-emerald-600 uppercase italic">Selesai: {{ $row->tanggal_selesai ? date('d M Y', strtotime($row->tanggal_selesai)) : '' }}</p>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                            <button @click="selectedSewa = {{ json_encode($row->load('details.alat')) }}; detailOpen = true"
                                class="px-4 py-2 border-2 border-black rounded-xl font-black text-[10px] uppercase italic bg-white cartoon-shadow-sm active:translate-y-0.5 transition-all">
                                Detail
                            </button>
                            <a href="{{ route('riwayat.nota', $row->idsewa) }}" target="_blank"
                                class="px-4 py-2 border-2 border-black rounded-xl font-black text-[10px] uppercase italic bg-yellow-300 cartoon-shadow-sm active:translate-y-0.5 transition-all flex items-center justify-center gap-1.5">
                                <i data-lucide="printer" class="w-3.5 h-3.5"></i> Struk
                            </a>
                            @if ($firstDetail && $firstDetail->alat)
                                <a href="{{ route('alat.detail', $firstDetail->alat->idalat) }}" class="bg-white cartoon-border cartoon-shadow-sm px-4 py-2.5 rounded-xl font-black text-[10px] uppercase italic hover:bg-yellow-300 transition-all flex items-center justify-center">
                                    Sewa Lagi
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-12 px-6 bg-white cartoon-border rounded-3xl">
                    <i data-lucide="archive" class="w-16 h-16 text-slate-300 mx-auto mb-4"></i>
                    <h3 class="text-lg font-black uppercase italic text-slate-400">Riwayat kosong</h3>
                </div>
            @endif
        </div>

        <div class="mt-12 bg-white cartoon-border border-dashed p-6 rounded-[2rem] flex items-start gap-4 text-left">
            <i data-lucide="help-circle" class="text-blue-500 w-8 h-8 shrink-0"></i>
            <div>
                <h5 class="font-black uppercase italic text-sm text-slate-900">Butuh bantuan pengembalian?</h5>
                <p class="text-[11px] font-bold text-slate-600 mt-1 italic leading-relaxed">
                    Silakan antar unit ke Gudang SewaIn. Jika alat terlalu berat untuk diantar sendiri (seperti Oven besar), 
                    silakan hubungi admin via WhatsApp untuk penjemputan unit ke lokasi Anda.
                </p>
            </div>
        </div>
    </div>

    <div x-show="modalOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm" x-cloak x-transition.opacity>
        <div @click.outside="modalOpen = false" class="bg-white cartoon-border cartoon-shadow rounded-[3rem] w-full max-w-sm p-8 relative overflow-hidden" x-transition.scale.90>
            <div class="text-center">
                <div class="w-20 h-20 bg-yellow-400 cartoon-border rounded-full flex items-center justify-center mx-auto mb-6 shadow-[4px_4px_0px_0px_#000]">
                    <i data-lucide="map-pin" class="w-10 h-10 text-black"></i>
                </div>
                <h3 class="text-2xl font-black uppercase italic text-slate-900 mb-2 leading-none tracking-tighter">Cara Kembalikan</h3>
                <p class="text-[11px] font-bold text-slate-500 mb-8 uppercase italic leading-tight px-4">
                    Antar alat langsung ke **Gudang SewaIn (Blok B-12)**. <br>Admin akan cek fisik & validasi di tempat.
                </p>
                
                <div class="space-y-4">
                    <button @click="modalOpen = false" class="w-full bg-blue-500 text-white py-4 rounded-2xl cartoon-border shadow-[4px_4px_0px_0px_#000] font-black text-xs uppercase italic hover:bg-blue-600 transition-all active:translate-x-[2px] active:translate-y-[2px] active:shadow-none">
                        OKE, SIAP!
                    </button>

                    <a :href="'https://wa.me/6287776600292?text=' + encodeURIComponent('*Halo Admin SewaIn, saya butuh bantuan penjemputan alat untuk unit ' + returnName + ' dengan nomor Invoice #' + returnInv + '*. Terima kasih.')" 
                       target="_blank"
                       class="w-full bg-white border-2 border-black py-4 rounded-2xl flex items-center justify-center gap-2 font-black text-xs uppercase italic hover:bg-slate-50 transition-all shadow-[4px_4px_0px_0px_#000] active:translate-x-[2px] active:translate-y-[2px] active:shadow-none">
                        BUTUH JEMPUTAN
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Transaksi Modal (Cartoon style) -->
    <div x-show="detailOpen" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/40 backdrop-blur-sm" x-cloak x-transition.opacity>
        <div @click.outside="detailOpen = false" class="bg-white cartoon-border cartoon-shadow rounded-[3rem] w-full max-w-md p-8 relative overflow-hidden" x-transition.scale.90>
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-black uppercase italic text-slate-900 leading-none">Detail Peminjaman</h3>
                <button @click="detailOpen = false" class="w-10 h-10 bg-slate-100 cartoon-border rounded-xl flex items-center justify-center cartoon-shadow-sm active:translate-y-1">
                    <i data-lucide="x" class="w-6 h-6 text-black"></i>
                </button>
            </div>
            
            <template x-if="selectedSewa">
                <div class="space-y-4 text-xs font-bold text-slate-800 text-left">
                    <div class="flex justify-between border-b-2 border-dashed border-slate-200 pb-2">
                        <span class="text-slate-400 uppercase">No. Invoice</span>
                        <span class="text-slate-900" x-text="'#INV-' + String(selectedSewa.idsewa).padStart(4, '0')"></span>
                    </div>
                    <div class="flex justify-between border-b-2 border-dashed border-slate-200 pb-2">
                        <span class="text-slate-400 uppercase">Periode Sewa</span>
                        <span class="text-slate-900" x-text="selectedSewa.tanggal_mulai + ' s/d ' + selectedSewa.tanggal_selesai + ' (' + selectedSewa.durasi + ' Hari)'"></span>
                    </div>
                    <div class="flex justify-between border-b-2 border-dashed border-slate-200 pb-2">
                        <span class="text-slate-400 uppercase">Metode Pengiriman</span>
                        <span class="text-slate-900" x-text="selectedSewa.metode_pengiriman"></span>
                    </div>
                    <div class="flex justify-between border-b-2 border-dashed border-slate-200 pb-2" x-show="selectedSewa.alamat_sewa">
                        <span class="text-slate-400 uppercase">Alamat</span>
                        <span class="text-slate-900 text-right" x-text="selectedSewa.alamat_sewa"></span>
                    </div>
                    
                    <div class="mt-4">
                        <p class="text-slate-400 uppercase mb-2">Daftar Alat:</p>
                        <div class="space-y-2 max-h-40 overflow-y-auto pr-1">
                            <template x-for="detail in selectedSewa.details">
                                <div class="bg-slate-50 cartoon-border p-3 rounded-xl flex justify-between items-center">
                                    <div>
                                        <p class="font-black text-slate-900 uppercase italic" x-text="detail.alat ? detail.alat.nama_alat : 'Alat'"></p>
                                        <p class="text-[10px] text-slate-400" x-text="detail.jumlah + ' Unit x Rp' + Number(detail.harga).toLocaleString('id-ID') + '/hari'"></p>
                                    </div>
                                    <span class="font-black text-slate-900" x-text="'Rp' + Number(detail.subtotal).toLocaleString('id-ID')"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="pt-4 border-t-4 border-black space-y-2">
                        <div class="flex justify-between">
                            <span class="text-slate-400 uppercase">Ongkos Kirim</span>
                            <span class="text-slate-900" x-text="'Rp' + Number(selectedSewa.ongkir).toLocaleString('id-ID')"></span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-black text-slate-900 uppercase italic">Total Pembayaran</span>
                            <span class="text-lg font-black text-blue-700 italic" x-text="'Rp' + Number(selectedSewa.total_biaya).toLocaleString('id-ID')"></span>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>
