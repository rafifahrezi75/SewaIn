<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Sewa Alat - SewaIn</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F1F5F9;
        }

        /* CARTOON CORE UI */
        .cartoon-border {
            border: 3px solid #000;
        }

        .cartoon-shadow {
            box-shadow: 6px 6px 0px 0px rgba(0, 0, 0, 1);
        }

        .cartoon-shadow-sm {
            box-shadow: 3px 3px 0px 0px rgba(0, 0, 0, 1);
        }

        .cartoon-accent-shadow {
            box-shadow: 4px 4px 0px 0px rgba(0, 0, 0, 1);
        }

        .btn-cartoon-buy {
            box-shadow: 4px 4px 0px 0px #000;
            transition: all 0.2s;
            border: 3px solid #000;
        }

        .btn-cartoon-buy:active {
            transform: translate(3px, 3px);
            box-shadow: 0px 0px 0px 0px #000;
        }

        .text-primary { color: #1E3A8A; }
        .bg-primary { background-color: #1E3A8A; }
        .text-aksen { color: #14B8A6; }
        .bg-aksen { background-color: #14B8A6; }
        
        .bg-card-yellow { background-color: #FDE047; }
        .bg-card-blue { background-color: #93C5FD; }
        .bg-card-pink { background-color: #F9A8D4; }
        .bg-card-green { background-color: #86EFAC; }
        .bg-card-orange { background-color: #FDBA74; }
    </style>
</head>

<body class="pb-20">

    <nav class="bg-yellow-300 cartoon-border sticky top-0 z-50 cartoon-shadow-sm">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <a href="javascript:history.back()"
                class="flex items-center gap-2 text-black hover:text-primary transition-all bg-white px-3 py-1 cartoon-border rounded-xl cartoon-shadow-sm font-black text-xs uppercase italic btn-cartoon-buy">
                <i data-lucide="arrow-left" class="w-4 h-4"></i>
                <span>Kembali</span>
            </a>
            <span class="text-sm font-black text-black tracking-[0.2em] uppercase italic bg-white px-4 py-1 cartoon-border rounded-xl cartoon-shadow-sm">Detail Produk</span>
            <div class="flex items-center gap-3">
                @auth
                    <button onclick="toggleProfile()" class="flex items-center gap-2 bg-white px-3 py-1.5 cartoon-border rounded-xl cartoon-shadow-sm font-black text-xs uppercase italic btn-cartoon-buy">
                        <i data-lucide="user" class="w-4 h-4"></i> <span>{{ explode(' ', auth()->user()->nama)[0] }}</span>
                    </button>
                @endauth
                @guest
                    <a href="{{ route('login') }}" class="flex items-center gap-2 bg-white px-3 py-1 cartoon-border rounded-xl cartoon-shadow-sm font-black text-xs uppercase italic btn-cartoon-buy">
                        <i data-lucide="log-in" class="w-4 h-4"></i>
                        <span>Masuk</span>
                    </a>
                @endguest
            </div>
        </div>
    </nav>

    <main class="max-w-6xl mx-auto px-6 py-10">
        <div id="mainContent" class="flex flex-col lg:flex-row gap-24 items-stretch text-left">
            
            <div class="w-full lg:w-1/2 sticky top-24">
                <div class="bg-white cartoon-border cartoon-shadow rounded-[2.5rem] p-8 space-y-6">
                    <div class="bg-slate-50 cartoon-border rounded-[2rem] border-dashed border-4 aspect-square flex items-center justify-center overflow-hidden relative mb-4">
                        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-blue-400 via-transparent to-transparent"></div>
                        @if ($alat->gambar)
                            <img id="alatImageMain" src="{{ asset('storage/' . $alat->gambar) }}" alt="{{ $alat->nama_alat }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-110">
                        @else
                            <i id="alatIcon" data-lucide="package" class="w-48 h-48 text-black drop-shadow-xl relative z-10 transition-transform duration-500 hover:scale-105"></i>
                        @endif
                    </div>
                    <div class="flex gap-3 px-1 overflow-x-auto" id="galleryContainer">
                        @if ($alat->gambar)
                            <div onclick="document.getElementById('alatImageMain').src='{{ asset('storage/' . $alat->gambar) }}'" class="w-20 h-20 bg-card-yellow cartoon-border rounded-2xl flex items-center justify-center cartoon-shadow-sm hover:-translate-y-1 transition-transform cursor-pointer overflow-hidden relative">
                                <img src="{{ asset('storage/' . $alat->gambar) }}" class="w-full h-full object-cover" />
                            </div>
                        @endif
                        @foreach ($alat->fotoDetail as $foto)
                            <div onclick="document.getElementById('alatImageMain').src='{{ asset('storage/' . $foto->fotodetail) }}'" class="w-20 h-20 bg-card-yellow cartoon-border rounded-2xl flex items-center justify-center cartoon-shadow-sm hover:-translate-y-1 transition-transform cursor-pointer overflow-hidden relative">
                                <img src="{{ asset('storage/' . $foto->fotodetail) }}" class="w-full h-full object-cover" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/2">
                <div class="bg-white cartoon-border cartoon-shadow rounded-[2.5rem] p-8 space-y-6">
                    
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span id="alatKategori" class="bg-card-pink text-black cartoon-border text-[10px] font-black px-3 py-1 rounded-lg uppercase italic">{{ $alat->kategori ? $alat->kategori->kategori : 'Umum' }}</span>
                            <div class="flex items-center gap-3">
                                <span class="bg-yellow-300 text-black cartoon-border text-[10px] font-black px-3 py-1 rounded-lg uppercase italic">Stok: {{ $alat->stok }} Unit</span>
                                <div class="flex items-center gap-1.5 bg-card-green cartoon-border px-3 py-1 rounded-lg text-[10px] font-black uppercase">
                                    <i data-lucide="circle-check" class="w-3.5 h-3.5"></i> {{ ucfirst($alat->status) }}
                                </div>
                            </div>
                        </div>
                        <h1 id="alatNama" class="text-4xl font-black text-slate-900 leading-tight italic uppercase">
                            {{ $alat->nama_alat }}
                        </h1>
                        <div class="flex items-center gap-2 mt-3">
                            <div class="flex text-yellow-400">
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                                <i data-lucide="star" class="w-4 h-4 fill-current"></i>
                            </div>
                            <span class="text-[10px] font-black text-slate-400 uppercase italic">4.9 (Top Rated)</span>
                        </div>
                    </div>

                    <div class="bg-card-yellow rounded-[2rem] p-6 cartoon-border shadow-[4px_4px_0px_0px_#000]">
                        <h3 class="font-black text-black mb-3 text-xs uppercase italic tracking-wider flex items-center gap-2">
                            <i data-lucide="file-text" class="w-4 h-4"></i> Spesifikasi
                        </h3>
                        <p id="alatDeskripsi" class="text-xs text-black font-bold mb-4 italic leading-relaxed bg-white/40 p-3 rounded-xl cartoon-border">
                            {{ $alat->deskripsi ?? 'Alat pilihan terbaik siap mempermudah berbagai kebutuhan Anda.' }}
                        </p>
                        <ul id="alatSpek" class="grid grid-cols-2 gap-3 text-[10px] text-black font-black uppercase italic">
                            @if(count($alat->spesifikasi) > 0)
                                @foreach($alat->spesifikasi as $spek)
                                    <li class="flex items-center gap-3 bg-white cartoon-border p-2 rounded-xl cartoon-shadow-sm">
                                        <div class="p-2 bg-card-blue rounded-lg cartoon-border"><i class="bx {{ $spek->iconspek ?: 'bx-cube' }}" style="font-size:1.25rem;"></i></div> 
                                        <span class="mt-1 font-bold text-xs">{{ $spek->spek }} {{ $spek->satuan }}</span>
                                    </li>
                                @endforeach
                            @else
                                <li class="text-xs text-slate-400 capitalize">Belum ada spesifikasi khusus.</li>
                            @endif
                        </ul>
                    </div>

                    <div class="bg-primary rounded-[1.8rem] p-6 cartoon-border relative overflow-hidden">
                        <div class="absolute -right-6 -bottom-6 opacity-10">
                            <i data-lucide="shopping-cart" class="w-24 h-24 text-white"></i>
                        </div>
                        
                        <div class="relative z-10 space-y-5">
                            <div class="flex items-end justify-between">
                                <div>
                                    <p class="text-blue-200 text-[10px] font-black uppercase tracking-widest mb-1">Harga Sewa</p>
                                    <h2 class="text-3xl font-black text-white italic drop-shadow-[2px_2px_0px_#000]">
                                        <span id="alatHarga">Rp{{ number_format($alat->harga_sewa, 0, ',', '.') }}</span> <span class="text-xs font-bold text-blue-200 uppercase">/ hari</span>
                                    </h2>
                                    <p class="text-yellow-300 text-[10px] font-black uppercase tracking-wider mt-2 flex items-center gap-1.5">
                                        <i data-lucide="package" class="w-3.5 h-3.5"></i> Stok Tersedia: {{ $alat->stok }} Unit
                                    </p>
                                </div>
                                <div class="flex items-center bg-white cartoon-border rounded-xl p-1 shadow-[2px_2px_0px_0px_#000]">
                                    <button onclick="changeDetailQty(-1)" class="w-8 h-8 font-black text-lg">-</button>
                                    <input type="number" id="detailQtyInput" value="1" class="w-8 text-center font-black text-sm bg-transparent outline-none" readonly>
                                    <button onclick="changeDetailQty(1)" class="w-8 h-8 font-black text-lg">+</button>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <button onclick="tambahKeKeranjang()" class="bg-white text-black py-3 rounded-xl font-black text-[10px] flex items-center justify-center gap-2 btn-cartoon-buy uppercase italic">
                                    <i data-lucide="shopping-bag" class="w-4 h-4"></i> + Keranjang
                                </button>
                                <button onclick="sewaSekarangLangsung()" class="bg-aksen text-black py-3 rounded-xl font-black text-[10px] tracking-tighter btn-cartoon-buy uppercase italic shadow-[2px_2px_0px_0px_#fff]">
                                    SEWA SEKARANG!
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    <div id="profile-overlay" class="fixed inset-0 bg-black/50 z-[120] hidden transition-opacity duration-300 opacity-0" onclick="toggleProfile()"></div>

    <div id="profile-panel" class="fixed top-0 right-0 h-full w-full sm:w-1/3 lg:w-1/4 bg-white z-[130] border-l-4 border-black translate-x-full transition-transform duration-500 ease-in-out flex flex-col">
        @auth
        <div class="p-6 border-b-4 border-black bg-yellow-300 flex justify-between items-center text-left">
            <h2 class="text-xl font-black uppercase italic leading-none">Profil Saya</h2>
            <button onclick="toggleProfile()" class="w-10 h-10 bg-white cartoon-border rounded-xl flex items-center justify-center cartoon-shadow-sm active:translate-y-1">
                <i data-lucide="x" class="w-6 h-6 text-black"></i>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto p-6 space-y-6 text-left">
            <div class="text-center space-y-3">
                <div class="w-24 h-24 bg-primary cartoon-border rounded-3xl mx-auto flex items-center justify-center cartoon-shadow">
                    <i data-lucide="user" class="text-white w-12 h-12"></i>
                </div>
                <div>
                    <h3 id="profile-name" class="font-black text-lg uppercase italic text-black">{{ auth()->user()->nama }}</h3>
                    <span class="text-[10px] font-bold bg-aksen cartoon-border px-3 py-1 rounded-full uppercase">Penyewa</span>
                </div>
            </div>

            <hr class="border-2 border-black border-dashed">

            <div class="space-y-4">
                <div class="space-y-1">
                    <span class="text-[10px] font-black text-gray-400 uppercase italic">Email</span>
                    <p id="profile-email" class="font-bold text-sm text-black">{{ auth()->user()->email }}</p>
                </div>
                <div class="space-y-1">
                    <span class="text-[10px] font-black text-gray-400 uppercase italic">No. Telepon</span>
                    <p id="profile-phone" class="font-bold text-sm text-black">{{ auth()->user()->notelp ?? '-' }}</p>
                </div>
            </div>

            <div class="pt-4 space-y-3">
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 p-4 bg-slate-100 cartoon-border rounded-2xl font-black text-xs uppercase italic hover:bg-yellow-50 transition-colors">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 text-primary"></i> Dashboard Admin
                    </a>
                @elseif(auth()->user()->role === 'owner')
                    <a href="{{ route('owner.dashboard') }}" class="flex items-center gap-3 p-4 bg-slate-100 cartoon-border rounded-2xl font-black text-xs uppercase italic hover:bg-yellow-50 transition-colors">
                        <i data-lucide="layout-dashboard" class="w-4 h-4 text-primary"></i> Dashboard Owner
                    </a>
                @endif
                <a href="{{ route('riwayat.sewa') }}" class="flex items-center gap-3 p-4 bg-slate-100 cartoon-border rounded-2xl font-black text-xs uppercase italic hover:bg-yellow-50 transition-colors">
                    <i data-lucide="history" class="w-4 h-4 text-primary"></i> Riwayat Sewa
                </a>
                <a href="{{ route('profil.edit') }}" class="flex items-center gap-3 p-4 bg-slate-100 cartoon-border rounded-2xl font-black text-xs uppercase italic hover:bg-yellow-50 transition-colors">
                    <i data-lucide="edit-3" class="w-4 h-4 text-primary"></i> Edit Profil
                </a>
            </div>
        </div>

        <div class="p-6 border-t-4 border-black">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-red-500 text-white py-4 rounded-2xl cartoon-border cartoon-shadow-sm font-black text-center block uppercase italic hover:bg-red-600 transition-colors">
                    Keluar
                </button>
            </form>
        </div>
        @endauth
    </div>

    <a href="{{ route('keranjang.index') }}"
        class="fixed bottom-8 right-8 z-[100] bg-aksen text-white px-8 py-5 rounded-2xl cartoon-border cartoon-shadow flex items-center gap-3 cartoon-button transition-all group">
        <div class="relative">
            <i data-lucide="shopping-bag" class="w-7 h-7 text-white"></i>
            <span id="cartCount"
                class="absolute -top-3 -right-3 bg-red-500 text-white text-[10px] font-black w-6 h-6 rounded-full flex items-center justify-center border-2 border-black animate-bounce invisible">0</span>
        </div>
        <span class="font-black text-sm tracking-tight uppercase italic">Lihat Keranjang</span>
    </a>

    <script>
        const maxStok = {{ $alat->stok }};

        function showWarningToast(message) {
            const toast = document.createElement('div');
            toast.className = "fixed top-5 left-1/2 -translate-x-1/2 z-[200] bg-red-400 text-white cartoon-border cartoon-shadow px-6 py-3 font-black uppercase italic text-xs animate-bounce";
            toast.innerText = `⚠️ ${message}`;
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 2500);
        }

        function changeDetailQty(delta) {
            const input = document.getElementById('detailQtyInput');
            let val = parseInt(input.value) + delta;
            if (val < 1) val = 1;
            if (val > maxStok) {
                val = maxStok;
                showWarningToast(`Maksimal sewa adalah ${maxStok} unit (stok terbatas)`);
            }
            input.value = val;
        }

        function tampilkanPesanLogin() {
            const toast = document.createElement('div');
            toast.className = "fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-[301] bg-white cartoon-border cartoon-shadow p-10 flex flex-col items-center gap-6 text-center animate-bounce w-full max-w-[400px]";
            toast.innerHTML = `
                <div class="w-20 h-20 bg-primary cartoon-border rounded-full flex items-center justify-center text-white cartoon-shadow-sm">
                    <i data-lucide="lock" class="w-10 h-10"></i>
                </div>
                <div>
                    <h4 class="font-black text-xl uppercase italic mb-2">Akses Terbatas!</h4>
                    <p class="text-xs font-bold text-slate-500 uppercase tracking-tight italic">Silakan Masuk Terlebih Dahulu Untuk Melanjutkan Transaksi</p>
                </div>
                <div class="flex flex-col gap-2 w-full">
                    <div class="bg-yellow-300 cartoon-border px-4 py-2 font-black text-[10px] uppercase italic">Mengalihkan ke halaman login...</div>
                </div>
            `;
            document.body.appendChild(toast);
            lucide.createIcons();
            setTimeout(() => window.location.href = "{{ route('login') }}", 2000);
        }

        function tambahKeKeranjang() {
            @guest
                tampilkanPesanLogin();
                return;
            @endguest

            const qty = parseInt(document.getElementById('detailQtyInput').value);

            if (qty > maxStok) {
                showWarningToast(`Maksimal sewa adalah ${maxStok} unit.`);
                return;
            }

            fetch('{{ route("keranjang.add") }}', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: `idalat={{ $alat->idalat }}&jumlah=${qty}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    updateBadge(data.total_items);
                    const toast = document.createElement('div');
                    toast.className = "fixed top-5 left-1/2 -translate-x-1/2 z-[200] bg-yellow-300 cartoon-border cartoon-shadow px-6 py-3 font-black uppercase italic text-xs animate-bounce";
                    toast.innerText = `🚀 ${qty} Alat Berhasil Di Tambahkan!`;
                    document.body.appendChild(toast);
                    setTimeout(() => toast.remove(), 2500);
                } else {
                    showWarningToast(data.message || 'Gagal menambahkan');
                }
            });
        }

        function updateBadge(count) {
            const badge = document.getElementById('cartCount');
            if (badge) {
                badge.innerText = count;
                badge.classList.toggle('invisible', count <= 0);
            }
        }

        function sewaSekarangLangsung() {
            @guest
                tampilkanPesanLogin();
                return;
            @endguest

            const qty = parseInt(document.getElementById('detailQtyInput').value);

            if (qty > maxStok) {
                showWarningToast(`Maksimal sewa adalah ${maxStok} unit.`);
                return;
            }

            fetch('{{ route("keranjang.add") }}', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: `idalat={{ $alat->idalat }}&jumlah=${qty}`
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    window.location.href = "{{ route('checkout.index') }}";
                } else {
                    showWarningToast(data.message || 'Gagal menyiapkan checkout');
                }
            })
            .catch(err => {
                console.error("Direct checkout failed:", err);
                showWarningToast('Kesalahan jaringan saat checkout');
            });
        }

        function toggleProfile() {
            const panel = document.getElementById('profile-panel');
            const overlay = document.getElementById('profile-overlay');
            if (panel.classList.contains('translate-x-full')) {
                panel.classList.remove('translate-x-full');
                overlay.classList.remove('hidden');
                setTimeout(() => overlay.classList.add('opacity-100'), 10);
                document.body.style.overflow = 'hidden';
            } else {
                panel.classList.add('translate-x-full');
                overlay.classList.remove('opacity-100');
                setTimeout(() => {
                    overlay.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }, 300);
            }
        }

        window.onload = () => {
            fetch('{{ route("keranjang.count") }}')
                .then(res => res.json())
                .then(data => updateBadge(data.count));
            lucide.createIcons();
        };
    </script>
</body>

</html>
