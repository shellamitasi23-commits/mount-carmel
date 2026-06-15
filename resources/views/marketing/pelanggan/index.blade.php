@extends('layouts.admin')
@section('title', 'Data Pelanggan - Mount Carmel')

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
        <p class="text-sm text-slate-500 mt-1">Kelola data pembeli lahan di Mount Carmel.</p>
    </div>
    @if(auth()->user()->role == 'marketing')
    <button onclick="openModal()" class="bg-[#800000] hover:bg-[#800000]/80 text-white px-5 py-2.5 rounded-xl font-semibold text-sm transition-all shadow-md flex items-center gap-2">
        <span class="material-icons-outlined text-lg">add</span>
        Tambah Pembeli Baru
    </button>
    @endif
</div>

{{-- Search --}}
<form method="GET" action="{{ route(auth()->user()->role . '.pembeli.index') }}" class="relative mb-6 group">
    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
        <span class="material-icons-outlined text-slate-400 group-focus-within:text-slate-900 transition-colors">search</span>
    </div>
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Cari nama pembeli, email, atau no. telepon..." 
           class="w-full pl-11 pr-10 py-2 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all placeholder:text-slate-300">
    
    @if(request('search'))
    <a href="{{ route(auth()->user()->role . '.pembeli.index') }}" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
        <span class="material-icons-outlined text-xl">close</span>
    </a>
    @endif
</form>

<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="text-slate-500 font-semibold bg-slate-50/80 border-b border-slate-100 uppercase tracking-wider text-[11px]">
                    <th class="px-4 py-2.5 text-center">ID</th>
                    <th class="px-4 py-2.5">Informasi Pembeli</th>
                    <th class="px-4 py-2.5">Kontak</th>
                    <th class="px-4 py-2.5">Alamat</th>
                    <th class="px-4 py-2.5">Tgl Terdaftar</th>
                    @if(auth()->user()->role == 'marketing')
                    <th class="px-4 py-2.5 text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 text-slate-700">
                @forelse($pembelis as $pembeli)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-4 py-2.5 text-center text-slate-400 font-mono text-xs">#{{ $pembeli->id }}</td>
                    <td class="px-4 py-2.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold text-sm">
                                {{ strtoupper(substr($pembeli->name, 0, 1)) }}
                            </div>
                            <p class="font-bold text-slate-900">{{ $pembeli->name }}</p>
                        </div>
                    </td>
                    <td class="px-4 py-2.5">
                        <p class="font-medium text-slate-800">{{ $pembeli->email }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $pembeli->no_telepon ?? '-' }}</p>
                    </td>
                    <td class="px-4 py-2.5 text-slate-500 truncate max-w-xs">{{ $pembeli->alamat ?? '-' }}</td>
                    <td class="px-4 py-2.5">{{ $pembeli->created_at->format('d/m/Y') }}</td>
                    @if(auth()->user()->role == 'marketing')
                    <td class="px-4 py-2.5 text-center">
                        <form action="{{ route('marketing.pembeli.destroy', $pembeli->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pembeli ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-slate-400 hover:text-red-600 p-2 rounded-lg transition-all" title="Hapus">
                                <span class="material-icons-outlined text-lg block">delete</span>
                            </button>
                        </form>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-slate-500 font-medium">Belum ada data pembeli.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pembelis->hasPages())
    <div class="px-4 py-3 border-t border-slate-50">
        {{ $pembelis->appends(request()->query())->links() }}
    </div>
    @endif
</div>

@if(auth()->user()->role == 'marketing')
    @include('marketing.pelanggan.create')
@endif

<script>
    function openModal() { document.getElementById('createModal').classList.remove('hidden'); }
    function closeModal() { document.getElementById('createModal').classList.add('hidden'); }
</script>
@endsection
