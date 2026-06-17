<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Sewa - SewaIn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #F8FAFC; }
        .cartoon-accent-shadow { box-shadow: 4px 4px 0px 0px rgba(0, 0, 0, 0.05); border: 1.5px solid #E2E8F0; }
        .btn-cartoon-buy { box-shadow: 4px 4px 0px 0px #1E3A8A; transition: all 0.2s; }
        .btn-cartoon-buy:active { transform: translate(2px, 2px); box-shadow: 0px 0px 0px 0px #1E3A8A; }
        .text-primary { color: #1E3A8A; }
        .bg-primary { background-color: #1E3A8A; }
        .cartoon-border { border: 3px solid #000; }
        .cartoon-shadow-sm { box-shadow: 3px 3px 0px 0px rgba(0, 0, 0, 1); }
        .cartoon-shadow { box-shadow: 6px 6px 0px 0px rgba(0, 0, 0, 1); }
    </style>
</head>

<body class="pb-20">

    <nav class="bg-white border-b border-slate-100 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="{{ route('katalog.index') }}" class="flex items-center gap-2 text-slate-500 hover:text-primary transition-all font-bold uppercase italic text-xs">
                <i data-lucide="chevron-left" class="w-5 h-5"></i>
                <span>Kembali Belanja</span>
            </a>
            <span class="text-sm font-black text-slate-900 tracking-tighter uppercase italic">Keranjang Saya</span>
            <div class="w-8"></div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-10">
        @if (session('error'))
            <div class="mb-6 bg-red-100 text-red-700 p-4 rounded-2xl border-2 border-red-500 font-black text-xs uppercase italic flex items-center gap-3">
                <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif
        @if (session('success'))
            <div class="mb-6 bg-green-100 text-green-700 p-4 rounded-2xl border-2 border-green-500 font-black text-xs uppercase italic flex items-center gap-3">
                <i data-lucide="check-circle" class="w-5 h-5 shrink-0"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-10">

            <div class="flex-1">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-black text-slate-900 uppercase italic">Daftar Alat</h2>
                    @if (count($items) > 0)
                        <button onclick="confirmAction('{{ route('keranjang.kosongkan') }}', 'Kosongkan semua item di keranjang?')" class="text-[10px] font-black text-red-400 hover:text-red-600 uppercase italic">
                            Kosongkan Keranjang
                        </button>
                    @endif
                </div>

                <div id="cartItemsContainer" class="space-y-4">
                    @if (count($items) === 0)
                        <div class="bg-white rounded-[2.5rem] p-20 text-center border border-dashed border-slate-200">
                            <i data-lucide="shopping-cart" class="w-16 h-16 text-slate-100 mx-auto mb-4"></i>
                            <p class="text-slate-400 font-bold italic uppercase text-sm">Keranjangmu masih kosong</p>
                            <a href="{{ route('katalog.index') }}" class="text-primary font-black text-xs uppercase italic mt-2 inline-block underline">Cari Alat Sekarang</a>
                        </div>
                    @else
                        @foreach ($items as $item)
                            <div class="bg-white rounded-3xl p-5 border border-primary shadow-md flex flex-col md:flex-row items-center gap-6 shadow-sm transition-all text-left">
                                <div class="w-20 h-20 bg-slate-50 rounded-2xl flex items-center justify-center flex-none overflow-hidden">
                                    @if ($item->alat->gambar)
                                        <img src="{{ asset('storage/' . $item->alat->gambar) }}" class="w-full h-full object-cover">
                                    @else
                                        <i data-lucide="package" class="w-8 h-8 text-slate-200"></i>
                                    @endif
                                </div>
                                <div class="flex-1 text-center md:text-left">
                                    <h4 class="font-black text-slate-900 text-sm italic uppercase">{{ $item->alat->nama_alat }}</h4>
                                    <p class="text-primary font-black text-xs italic">Rp{{ number_format($item->alat->harga_sewa, 0, ',', '.') }}/hari</p>
                                    <span class="text-slate-400 font-bold text-[10px] uppercase block mt-1">Stok Tersedia: {{ $item->alat->stok }} Unit</span>
                                </div>
                                <div class="flex items-center gap-4 bg-slate-50 p-2 rounded-xl border border-slate-100">
                                    <a href="{{ route('keranjang.update', ['id' => $item->id_keranjang, 'delta' => -1]) }}" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-primary font-black text-lg">-</a>
                                    <span class="text-xs font-black text-slate-900 w-6 text-center italic">{{ $item->jumlah }}</span>
                                    <a href="{{ route('keranjang.update', ['id' => $item->id_keranjang, 'delta' => 1]) }}" class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-primary font-black text-lg">+</a>
                                </div>
                                <div class="text-right flex flex-col items-center md:items-end gap-2">
                                     <p class="text-sm font-black text-slate-900 italic">Rp{{ number_format($item->alat->harga_sewa * $item->jumlah, 0, ',', '.') }}</p>
                                     <button onclick="confirmAction('{{ route('keranjang.hapus', $item->id_keranjang) }}', 'Hapus item ini dari keranjang?')" class="text-red-300 hover:text-red-500 transition-colors">
                                        <i data-lucide="trash-2" class="w-4 h-4"></i>
                                     </button>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="w-full lg:w-[380px] text-left">
                <div class="bg-white rounded-[2.5rem] p-8 cartoon-accent-shadow sticky top-24">
                    <h3 class="font-black text-slate-900 mb-6 text-xs uppercase italic tracking-wider">Ringkasan Pesanan</h3>
                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between text-xs font-bold">
                            <span class="text-slate-400 uppercase italic">Total Item</span>
                            <span class="text-slate-700 italic">{{ $total_item }} Unit</span>
                        </div>
                        <div class="pt-4 border-t border-slate-100 flex justify-between items-center">
                            <span class="text-sm font-black text-slate-900 uppercase italic">Estimasi Biaya</span>
                            <span class="text-2xl font-black text-primary italic">Rp{{ number_format($total_biaya, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @if (count($items) > 0)
                        <a href="{{ route('checkout.index') }}" class="w-full bg-primary text-white py-5 rounded-2xl font-black text-xs tracking-widest btn-cartoon-buy uppercase italic block text-center">
                            LANJUT KE CHECKOUT
                        </a>
                    @else
                        <button disabled class="w-full bg-slate-300 text-white py-5 rounded-2xl font-black text-xs tracking-widest uppercase italic cursor-not-allowed">
                            LANJUT KE CHECKOUT
                        </button>
                    @endif
                    <div class="mt-6 p-4 bg-blue-50 rounded-2xl border border-blue-100">
                        <p class="text-[10px] text-blue-700 font-bold italic leading-relaxed">
                            💡 Kamu akan mengisi detail alamat dan metode pengiriman di halaman selanjutnya.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Modal Konfirmasi Custom (Cartoon) -->
    <div id="confirmModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[300] hidden items-center justify-center p-6">
        <div class="bg-white cartoon-border cartoon-shadow p-10 flex flex-col items-center gap-6 text-center w-full max-w-[400px]">
            <div class="w-20 h-20 bg-red-100 cartoon-border rounded-full flex items-center justify-center text-red-500 cartoon-shadow-sm">
                <i data-lucide="alert-circle" class="w-10 h-10"></i>
            </div>
            <div>
                <h4 class="font-black text-xl uppercase italic mb-2">Konfirmasi</h4>
                <p id="confirmMessage" class="text-xs font-bold text-slate-500 uppercase tracking-tight italic px-4">Apakah Anda yakin ingin melakukan tindakan ini?</p>
            </div>
            <div class="flex gap-4 w-full">
                <button onclick="closeConfirm()" class="flex-1 bg-slate-100 text-slate-900 py-3 rounded-xl font-black text-[10px] cartoon-border cartoon-shadow-sm uppercase italic">Batal</button>
                <a id="confirmBtn" href="#" class="flex-1 bg-red-400 text-white py-3 rounded-xl font-black text-[10px] cartoon-border cartoon-shadow-sm uppercase italic flex items-center justify-center">Ya, Lanjutkan</a>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        function confirmAction(url, message) {
            const modal = document.getElementById('confirmModal');
            const messageEl = document.getElementById('confirmMessage');
            const confirmBtn = document.getElementById('confirmBtn');
            
            messageEl.innerText = message;
            confirmBtn.href = url;
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeConfirm() {
            const modal = document.getElementById('confirmModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</body>
</html>
