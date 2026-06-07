<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - SewaIn</title>
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

        .btn-cartoon-buy {
            box-shadow: 4px 4px 0px 0px #1E3A8A;
            transition: all 0.2s;
        }

        .btn-cartoon-buy:active {
            transform: translate(2px, 2px);
            box-shadow: 0px 0px 0px 0px #1E3A8A;
        }

        .text-primary {
            color: #1E3A8A;
        }

        .bg-primary {
            background-color: #1E3A8A;
        }

        .bg-aksen {
            background-color: #14B8A6;
        }
    </style>
</head>

<body class="p-4 md:p-8">

    <div class="max-w-xl mx-auto">
        <!-- Back and Title -->
        <div class="flex items-center gap-4 mb-10 text-left">
            <a href="{{ route('home') }}"
                class="w-12 h-12 bg-white cartoon-border rounded-2xl flex items-center justify-center cartoon-shadow-sm hover:bg-yellow-50 transition-all">
                <i data-lucide="arrow-left" class="w-6 h-6 text-black"></i>
            </a>
            <div>
                <h1 class="text-3xl font-black uppercase italic tracking-tighter text-slate-900">Edit Profil</h1>
            </div>
        </div>

        <!-- Alerts -->
        @if (session('error'))
            <div class="mb-6 bg-red-100 text-red-700 cartoon-border p-5 rounded-2xl cartoon-shadow-sm font-bold text-sm text-left flex items-start gap-3">
                <i data-lucide="alert-circle" class="w-5 h-5 shrink-0 text-red-600 mt-0.5"></i>
                <div>
                    {{ session('error') }}
                </div>
            </div>
        @endif

        @if (session('success'))
            <div class="mb-6 bg-emerald-100 text-emerald-800 cartoon-border p-5 rounded-2xl cartoon-shadow-sm font-bold text-sm text-left flex items-start gap-3">
                <i data-lucide="check-circle" class="w-5 h-5 shrink-0 text-emerald-600 mt-0.5"></i>
                <div>
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 bg-red-50 text-red-700 cartoon-border p-5 rounded-2xl cartoon-shadow-sm font-bold text-sm text-left">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form Container -->
        <div class="bg-white cartoon-border cartoon-shadow rounded-[2.5rem] p-8 text-left">
            <div class="flex items-center gap-3 mb-6">
                <div class="w-12 h-12 bg-yellow-300 cartoon-border rounded-2xl flex items-center justify-center shadow-[3px_3px_0px_0px_#000]">
                    <i data-lucide="user-cog" class="w-6 h-6 text-black"></i>
                </div>
                <div>
                    <h3 class="font-black text-lg uppercase italic text-slate-900 leading-none">Informasi Akun</h3>
                    <p class="text-[10px] font-bold text-slate-400 uppercase mt-1">Perbarui nama dan nomor telepon Anda</p>
                </div>
            </div>

            <form action="{{ route('profil.update') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-xs font-black text-slate-700 mb-2 uppercase tracking-wide">Nama Lengkap</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-black">
                            <i data-lucide="user" class="w-4 h-4"></i>
                        </span>
                        <input type="text" name="nama" value="{{ old('nama', $user_data->nama) }}" required 
                            placeholder="Contoh: Budi Santoso" 
                            class="w-full pl-11 pr-4 py-3.5 bg-white cartoon-border rounded-2xl focus:bg-yellow-50 outline-none cartoon-shadow-sm text-sm font-bold text-slate-900 focus:ring-2 focus:ring-primary transition-all">
                    </div>
                </div>

                <!-- Email (Read-only) -->
                <div>
                    <label class="block text-xs font-black text-slate-400 mb-2 uppercase tracking-wide">Alamat Email (Tidak Dapat Diubah)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                        </span>
                        <input type="email" value="{{ $user_data->email }}" disabled 
                            class="w-full pl-11 pr-4 py-3.5 bg-slate-50 cartoon-border rounded-2xl outline-none text-sm font-bold text-slate-400 cursor-not-allowed border-dashed">
                    </div>
                </div>

                <!-- Nomor Telepon / WhatsApp -->
                <div>
                    <label class="block text-xs font-black text-slate-700 mb-2 uppercase tracking-wide">No. Telepon / WhatsApp</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-black">
                            <i data-lucide="phone" class="w-4 h-4"></i>
                        </span>
                        <input type="text" name="notelp" value="{{ old('notelp', $user_data->notelp) }}" required 
                            placeholder="Contoh: 081234567890" 
                            class="w-full pl-11 pr-4 py-3.5 bg-white cartoon-border rounded-2xl focus:bg-yellow-50 outline-none cartoon-shadow-sm text-sm font-bold text-slate-900 focus:ring-2 focus:ring-primary transition-all">
                    </div>
                    <p class="mt-2.5 text-[10px] text-slate-500 font-bold uppercase italic leading-tight">
                        ⚠️ Nomor WhatsApp aktif diperlukan agar Admin dapat menghubungi Anda mengenai detail pengiriman dan konfirmasi peminjaman.
                    </p>
                </div>

                <!-- Alamat Lengkap -->
                <div>
                    <label class="block text-xs font-black text-slate-700 mb-2 uppercase tracking-wide">Alamat Lengkap</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-start pt-3.5 pl-4 text-black">
                            <i data-lucide="map-pin" class="w-4 h-4"></i>
                        </span>
                        <textarea name="alamat" required placeholder="Contoh: Jl. Dharmahusada Indah Timur No. 23, Surabaya" 
                            class="w-full pl-11 pr-4 py-3.5 bg-white cartoon-border rounded-2xl focus:bg-yellow-50 outline-none cartoon-shadow-sm text-sm font-bold text-slate-900 focus:ring-2 focus:ring-primary transition-all h-24">{{ old('alamat', $user_data->alamat) }}</textarea>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                    class="w-full bg-primary text-white py-4 rounded-2xl font-black text-xs tracking-widest btn-cartoon-buy uppercase italic border-2 border-black block text-center mt-8 shadow-[4px_4px_0px_0px_#000] active:translate-x-1 active:translate-y-1 active:shadow-none transition-all">
                    SIMPAN PERUBAHAN
                </button>
            </form>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>
