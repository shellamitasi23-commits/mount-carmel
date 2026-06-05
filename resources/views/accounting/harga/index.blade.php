@extends('layouts.admin')
@section('title', 'Kelola Harga Lahan - Mount Carmel')

@section('content')

@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
    <span class="material-icons-outlined">check_circle</span>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Kelola Harga Lahan</h1>
        <p class="text-sm text-slate-500 mt-1">Atur harga per meter atau total untuk setiap unit lahan.</p>
    </div>
</div>

{{-- Form Filter --}}
<div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 mb-6">
    <form action="{{ route('accounting.harga.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div class="md:col-span-2">
            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1.5">Cari Nomor Lahan</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 material-icons-outlined text-slate-400 text-sm">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Contoh: A-01" 
                       class="w-full pl-11 pr-4 py-2 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all placeholder:text-slate-300">
            </div>
        </div>

        <div>
            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1.5">Cluster Filter</label>
            <div class="relative">
                <select name="cluster_id" onchange="this.form.submit()" class="w-full px-4 py-2 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all appearance-none cursor-pointer">
                    <option value="">SEMUA CLUSTER</option>
                    @foreach($clusters as $cluster)
                        <option value="{{ $cluster->id }}" {{ request('cluster_id') == $cluster->id ? 'selected' : '' }}>
                            {{ strtoupper($cluster->nama_cluster) }}
                        </option>
                    @endforeach
                </select>
                <span class="material-icons-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 text-sm">expand_more</span>
            </div>
        </div>

        <div class="flex">
            @if(request('search') || request('cluster_id'))
            <a href="{{ route('accounting.harga.index') }}" class="w-full px-5 py-2 bg-slate-100 text-slate-500 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-200 transition-all text-center flex items-center justify-center">
                Reset
            </a>
            @endif
        </div>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="text-slate-500 font-semibold bg-slate-50/80 border-b border-slate-100 uppercase tracking-wider text-[11px]">
                    <th class="px-4 py-2.5 text-center">ID</th>
                    <th class="px-4 py-2.5">Nomor Lahan</th>
                    <th class="px-4 py-2.5">Cluster</th>
                    <th class="px-4 py-2.5">Tipe</th>
                    <th class="px-4 py-2.5">Harga Lahan</th>
                    <th class="px-4 py-2.5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 text-slate-700">
                @forelse($lahans as $lahan)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-4 py-2.5 text-center text-slate-400 font-mono text-xs">#{{ $lahan->id }}</td>
                    <td class="px-4 py-2.5">
                        <p class="font-bold text-slate-900">Lahan {{ $lahan->nomor_lahan }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5 uppercase tracking-tighter italic">Status: {{ $lahan->status_lahan }}</p>
                    </td>
                    <td class="px-4 py-2.5">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">
                            {{ $lahan->cluster?->nama_cluster ?? '-' }}
                        </span>
                    </td>
                    <td class="px-4 py-2.5 text-slate-500">{{ $lahan->tipe_lahan }}</td>
                    <td class="px-4 py-2.5">
                        <p class="font-bold text-slate-900">Rp {{ number_format($lahan->harga, 0, ',', '.') }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5">Terakhir diupdate: {{ $lahan->updated_at->format('d/m/Y') }}</p>
                    </td>
                    <td class="px-4 py-2.5 text-center">
                        <button onclick="openModal('modal-edit-{{ $lahan->id }}')" class="bg-white border border-slate-200 text-slate-600 hover:text-slate-900 hover:border-slate-400 p-2 rounded-lg transition-all shadow-sm" title="Ubah Harga">
                            <span class="material-icons-outlined text-lg block">edit</span>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-slate-500 font-medium">Belum ada data lahan yang tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($lahans->hasPages())
    <div class="px-4 py-3 border-t border-slate-50">
        {{ $lahans->links() }}
    </div>
    @endif
</div>

<style>
    /* Custom style for editorial pagination */
    .pagination-premium nav { display: inline-flex; gap: 0.5rem; }
    .pagination-premium .relative { display: none; } /* Hide mobile info */
    .pagination-premium a, .pagination-premium span { 
        padding: 0.75rem 1.25rem; 
        font-size: 10px; 
        font-weight: 900; 
        text-transform: uppercase; 
        letter-spacing: 0.2em; 
        border-radius: 0.75rem;
        transition: all 0.3s;
    }
    .pagination-premium a { background: #f8fafc; color: #94a3b8; }
    .pagination-premium a:hover { background: #0f172a; color: #ffffff; }
    .pagination-premium .active span { background: #0f172a; color: #ffffff; box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1); }
</style>

@endsection
