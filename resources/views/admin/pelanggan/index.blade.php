@extends('layouts.admin')
@section('title', 'Data Pembeli - Mount Carmel')

@section('content')

@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
    <span class="material-icons-outlined">check_circle</span>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Data Pembeli</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola data akun pelanggan/keluarga yang terdaftar di sistem.</p>
    </div>
    @if(auth()->user()->role == 'admin')
    <div class="flex gap-3 w-full md:w-auto">
        <button onclick="openModal()" class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-2.5 rounded-xl font-semibold flex items-center gap-2 transition-all shadow-md text-sm hover:shadow-lg hover:-translate-y-0.5">
            <span class="material-icons-outlined text-sm">person_add</span> Tambah Pembeli
        </button>
    </div>
    @endif
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="text-slate-500 font-semibold bg-slate-50/80 border-b border-slate-100 uppercase tracking-wider text-[11px]">
                    <th class="px-6 py-4">Nama Lengkap</th>
                    <th class="px-6 py-4">Kontak (Email & No. Telp)</th>
                    <th class="px-6 py-4">Alamat Lengkap</th>
                    <th class="px-6 py-4">Tgl. Bergabung</th>
                    @if(auth()->user()->role == 'admin')
                    <th class="px-6 py-4 text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 text-slate-700">
                
                @forelse($pembelis as $pembeli)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-lg">
                                {{ strtoupper(substr($pembeli->name, 0, 1)) }}
                            </div>
                            <p class="font-bold text-slate-900 text-base">{{ $pembeli->name }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-slate-800">{{ $pembeli->email }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $pembeli->no_telepon ?? 'Tidak ada No. Telp' }}</p>
                    </td>
                    <td class="px-6 py-4 text-slate-500 whitespace-normal min-w-[200px] text-xs leading-relaxed">
                        {{ $pembeli->alamat ?? 'Alamat belum diisi.' }}
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-slate-800">{{ $pembeli->created_at->format('d M Y') }}</p>
                    </td>
                    @if(auth()->user()->role == 'admin')
                    <td class="px-6 py-4 text-center flex justify-center gap-2">
                        <form action="{{ route('admin.pembeli.destroy', $pembeli->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun pembeli ini beserta semua data reservasinya?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-slate-400 hover:text-red-600 bg-white border border-slate-200 hover:border-red-200 p-2 rounded-lg transition-all shadow-sm" title="Hapus Data">
                                <span class="material-icons-outlined text-lg block">delete</span>
                            </button>
                        </form>
                    </td>
                    @endif
                </tr>
                

                @empty
                <tr>
                    <td colspan="{{ auth()->user()->role == 'admin' ? '5' : '4' }}" class="px-6 py-10 text-center text-slate-500">
                        <div class="flex flex-col items-center justify-center">
                            <span class="material-icons-outlined text-4xl text-slate-300 mb-2">group_off</span>
                            <p class="font-medium">Belum ada data pembeli.</p>
                            <p class="text-xs mt-1">Pembeli yang mendaftar di halaman depan akan otomatis muncul di sini.</p>
                        </div>
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>

@if(auth()->user()->role == 'admin')
@include('admin.pelanggan.create')
@endif

<script>
    function openModal() { document.getElementById('createModal').classList.remove('hidden'); }
    function closeModal() { document.getElementById('createModal').classList.add('hidden'); }
    function openEditModal(id) { document.getElementById('editModal' + id).classList.remove('hidden'); }
    function closeEditModal(id) { document.getElementById('editModal' + id).classList.add('hidden'); }
</script>
@endsection