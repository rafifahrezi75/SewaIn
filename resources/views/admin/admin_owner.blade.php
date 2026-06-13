@extends('layouts.admin')

@section('title', 'Admin & Owner')

@section('content')
<div x-data="{ modalOpen: false, editModalOpen: false, editData: { id: '', nama: '', email: '', notelp: '', alamat: '', role: '' } }">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
        <div class="flex items-center gap-3">
            <h2 class="text-2xl font-bold text-gray-800">Data Admin & Owner</h2>
        </div>
        
        <div class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
            <form method="GET" action="{{ route('admin.admin-owner') }}" class="flex flex-1 sm:flex-initial items-center gap-2">
                <div class="relative w-full sm:w-64">
                    <i class='bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg'></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, email, telp..." class="pl-10 pr-4 py-2 w-full rounded-xl border border-gray-200 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors">
                </div>
                @if(request()->filled('search'))
                <a href="{{ route('admin.admin-owner') }}" class="rounded-xl bg-red-50 text-red-600 px-4 py-2 text-sm font-medium hover:bg-red-100 transition-colors border border-red-100 flex items-center justify-center">
                    Reset
                </a>
                @endif
                <button type="submit" class="rounded-xl bg-gray-100 text-gray-600 px-4 py-2 text-sm font-medium hover:bg-gray-200 transition-colors focus:outline-none">Cari</button>
            </form>

            <button @click="modalOpen = true" class="flex items-center justify-center gap-2 rounded-xl bg-brand-500 px-4 py-2 text-sm font-medium text-white transition-all hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 shadow-sm w-full sm:w-auto">
                <i class='bx bx-plus text-lg'></i>
                <span>Tambah User</span>
            </button>
        </div>
    </div>

    <!-- Data Table -->
    <div class="bg-white rounded-2xl shadow-sm ring-1 ring-gray-100 overflow-hidden">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-left text-sm text-gray-500">
                <thead class="bg-gray-50/50 text-xs uppercase text-gray-400 border-b border-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Nama User</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Role</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Kontak</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Alamat Lengkap</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider">Bergabung</th>
                        <th scope="col" class="px-6 py-4 font-semibold tracking-wider text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($usersList as $item)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($item->role === 'admin')
                                <div class="h-10 w-10 shrink-0 rounded-full bg-blue-100 text-blue-600 font-bold flex items-center justify-center">
                                    {{ strtoupper(substr($item->nama, 0, 2)) }}
                                </div>
                                @else
                                <div class="h-10 w-10 shrink-0 rounded-full bg-purple-100 text-purple-600 font-bold flex items-center justify-center">
                                    {{ strtoupper(substr($item->nama, 0, 2)) }}
                                </div>
                                @endif
                                <div>
                                    <span class="block font-medium text-gray-900">{{ $item->nama }}</span>
                                    <span class="text-xs text-gray-500">ID: USR-{{ str_pad($item->id_user, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($item->role === 'admin')
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">
                                Admin
                            </span>
                            @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                                Owner
                            </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs">
                            <i class='bx bx-phone mr-1 text-gray-400'></i> {{ $item->notelp ?? '-' }}<br>
                            <span class="text-gray-400 mt-1 block">{{ $item->email }}</span>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-600 max-w-xs truncate" title="{{ $item->alamat }}">
                            {{ $item->alamat ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-500">
                            {{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" 
                                    @click="editData = { id: '{{ $item->id_user }}', nama: '{{ addslashes($item->nama) }}', email: '{{ addslashes($item->email) }}', notelp: '{{ addslashes($item->notelp ?? '') }}', alamat: '{{ addslashes($item->alamat ?? '') }}', role: '{{ $item->role }}' }; editModalOpen = true" 
                                    class="rounded-lg p-2 text-blue-500 bg-blue-50 hover:bg-blue-100 hover:text-blue-600 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-1" 
                                    title="Edit">
                                    <i class='bx bx-edit text-xl'></i>
                                </button>
                                
                                @if($item->id_user == auth()->id())
                                <button type="button" class="rounded-lg p-2 text-gray-400 bg-gray-50 cursor-not-allowed" title="Tidak dapat menghapus diri sendiri" disabled>
                                    <i class='bx bx-trash text-xl'></i>
                                </button>
                                @else
                                <form action="{{ route('admin.admin-owner.destroy', $item->id_user) }}" method="POST" class="inline-block" onsubmit="return confirmDelete(event, this)">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg p-2 text-red-500 bg-red-50 hover:bg-red-100 hover:text-red-600 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1" title="Hapus">
                                        <i class='bx bx-trash text-xl'></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500">Belum ada data admin & owner.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="bg-gray-50/50 p-4 sm:flex sm:items-center sm:justify-between border-t border-gray-100 rounded-b-2xl">
            <p class="text-sm text-gray-500">
                Menampilkan <span class="font-medium text-gray-700">{{ $usersList->firstItem() ?? 0 }}</span> 
                sampai <span class="font-medium text-gray-700">{{ $usersList->lastItem() ?? 0 }}</span> 
                dari total <span class="font-medium text-gray-700">{{ $usersList->total() }}</span> user
            </p>
            <div class="mt-4 sm:mt-0 flex gap-2">
                @if ($usersList->onFirstPage())
                    <button class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed focus:outline-none" disabled>Sebelumnya</button>
                @else
                    <a href="{{ $usersList->appends(request()->query())->previousPageUrl() }}" class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors">Sebelumnya</a>
                @endif

                @if ($usersList->hasMorePages())
                    <a href="{{ $usersList->appends(request()->query())->nextPageUrl() }}" class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors">Selanjutnya</a>
                @else
                    <button class="rounded-lg border border-gray-200 bg-white px-4 py-2 text-sm font-medium text-gray-400 cursor-not-allowed focus:outline-none" disabled>Selanjutnya</button>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Form Tambah User -->
    <div 
        x-show="modalOpen" 
        class="fixed inset-0 z-[60] flex items-center justify-center bg-gray-900/50 p-4 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="display: none;"
    >
        <div 
            @click.outside="modalOpen = false"
            class="w-full max-w-md rounded-2xl bg-white shadow-xl ring-1 ring-gray-200/50"
            x-show="modalOpen" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
            <!-- Modal Header -->
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                <h3 class="text-lg font-bold text-gray-800">Tambah Admin / Owner</h3>
                <button @click="modalOpen = false" class="rounded-lg p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition focus:outline-none">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>
            
            <form action="{{ route('admin.admin-owner.store') }}" method="POST">
                @csrf
                <div class="space-y-4 px-6 py-4 overflow-y-auto max-h-[70vh]">
                    <div>
                        <label for="nama" class="mb-1 block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors" placeholder="Masukkan nama lengkap" required>
                    </div>

                    <div>
                        <label for="email" class="mb-1 block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="email" name="email" class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors" placeholder="nama@email.com" required>
                    </div>

                    <div>
                        <label for="notelp" class="mb-1 block text-sm font-medium text-gray-700">No Telepon</label>
                        <input type="text" id="notelp" name="notelp" class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors" placeholder="Contoh: 08123456789">
                    </div>

                    <div>
                        <label for="alamat" class="mb-1 block text-sm font-medium text-gray-700">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="2" class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors" placeholder="Alamat lengkap..."></textarea>
                    </div>

                    <div>
                        <label for="role" class="mb-1 block text-sm font-medium text-gray-700">Role</label>
                        <select id="role" name="role" class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors" required>
                            <option value="admin">Admin</option>
                            <option value="owner">Owner</option>
                        </select>
                    </div>

                    <div>
                        <label for="password" class="mb-1 block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" id="password" name="password" minlength="8" class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors" placeholder="Minimal 8 karakter" required>
                    </div>
                </div>
                
                <div class="flex items-center gap-2 border-t border-gray-100 px-6 py-4 justify-end bg-gray-50/50 rounded-b-2xl">
                    <button type="button" @click="modalOpen = false" class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="rounded-xl bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition-all shadow-sm">
                        Simpan User
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Form Update User -->
    <div 
        x-show="editModalOpen" 
        class="fixed inset-0 z-[60] flex items-center justify-center bg-gray-900/50 p-4 backdrop-blur-sm"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="display: none;"
    >
        <div 
            @click.outside="editModalOpen = false"
            class="w-full max-w-md rounded-2xl bg-white shadow-xl ring-1 ring-gray-200/50"
            x-show="editModalOpen" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        >
            <div class="flex items-center justify-between border-b border-gray-100 px-6 py-4">
                <h3 class="text-lg font-bold text-gray-800">Update Admin / Owner</h3>
                <button type="button" @click="editModalOpen = false" class="rounded-lg p-1 text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition focus:outline-none">
                    <i class='bx bx-x text-2xl'></i>
                </button>
            </div>

            <form action="{{ route('admin.admin-owner.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id_user" x-model="editData.id">
                <div class="space-y-4 px-6 py-4 overflow-y-auto max-h-[70vh]">
                    <div>
                        <label for="edit_nama" class="mb-1 block text-sm font-medium text-gray-700">Nama Lengkap</label>
                        <input type="text" id="edit_nama" name="edit_nama" x-model="editData.nama" class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors" required>
                    </div>

                    <div>
                        <label for="edit_email" class="mb-1 block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" id="edit_email" name="edit_email" x-model="editData.email" class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors" required>
                    </div>

                    <div>
                        <label for="edit_notelp" class="mb-1 block text-sm font-medium text-gray-700">No Telepon</label>
                        <input type="text" id="edit_notelp" name="edit_notelp" x-model="editData.notelp" class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors">
                    </div>

                    <div>
                        <label for="edit_alamat" class="mb-1 block text-sm font-medium text-gray-700">Alamat</label>
                        <textarea id="edit_alamat" name="edit_alamat" rows="2" x-model="editData.alamat" class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors"></textarea>
                    </div>

                    <div>
                        <label for="edit_role" class="mb-1 block text-sm font-medium text-gray-700">Role</label>
                        <select id="edit_role" name="edit_role" x-model="editData.role" class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors" required>
                            <option value="admin">Admin</option>
                            <option value="owner">Owner</option>
                        </select>
                    </div>

                    <div>
                        <label for="edit_password" class="mb-1 block text-sm font-medium text-gray-700">Password Baru</label>
                        <input type="password" id="edit_password" name="edit_password" minlength="8" class="block w-full rounded-xl border border-gray-300 px-4 py-2 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 transition-colors" placeholder="Kosongkan jika tidak ingin mengubah password">
                    </div>
                </div>

                <div class="flex items-center gap-2 border-t border-gray-100 px-6 py-4 justify-end bg-gray-50/50 rounded-b-2xl">
                    <button type="button" @click="editModalOpen = false" class="rounded-xl border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="rounded-xl bg-brand-500 px-4 py-2 text-sm font-medium text-white hover:bg-brand-600 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition-all shadow-sm">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmDelete(event, form) {
        event.preventDefault();
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "User ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            customClass: {
                popup: 'rounded-3xl',
                title: 'font-sans text-gray-800',
                htmlContainer: 'font-sans text-sm text-gray-500'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }
</script>
@endsection
