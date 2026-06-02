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
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-8">
    <form action="{{ route('accounting.harga.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Cari Nomor Lahan</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Contoh: A-01" 
                   class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-slate-900/5 outline-none text-sm transition-all">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Cluster Filter</label>
            <select name="cluster_id" onchange="this.form.submit()" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-slate-900/5 outline-none text-sm transition-all">
                <option value="">SEMUA CLUSTER</option>
                @foreach($clusters as $cluster)
                    <option value="{{ $cluster->id }}" {{ request('cluster_id') == $cluster->id ? 'selected' : '' }}>
                        {{ strtoupper($cluster->nama_cluster) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-slate-900 hover:bg-slate-800 text-white px-5 py-3 rounded-xl font-semibold text-sm transition-all shadow-md">
                Terapkan Filter
            </button>
            @if(request('search') || request('cluster_id'))
            <a href="{{ route('accounting.harga.index') }}" class="px-5 py-3 bg-slate-100 text-slate-600 rounded-xl font-semibold text-sm hover:bg-slate-200 transition-all text-center">
                Reset
            </a>
            @endif
        </div>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="text-slate-500 font-semibold bg-slate-50/80 border-b border-slate-100 uppercase tracking-wider text-[11px]">
                    <th class="px-6 py-4 text-center">ID</th>
                    <th class="px-6 py-4">Nomor Lahan</th>
                    <th class="px-6 py-4">Cluster</th>
                    <th class="px-6 py-4">Tipe</th>
                    <th class="px-6 py-4">Harga Lahan</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 text-slate-700">
                @forelse($lahans as $lahan)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-6 py-4 text-center text-slate-400 font-mono text-xs">#{{ $lahan->id }}</td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-slate-900">Lahan {{ $lahan->nomor_lahan }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5 uppercase tracking-tighter italic">Status: {{ $lahan->status_lahan }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">
                            {{ $lahan->cluster?->nama_cluster ?? '-' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-slate-500">{{ $lahan->tipe_lahan }}</td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-slate-900">Rp {{ number_format($lahan->harga, 0, ',', '.') }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5">Terakhir diupdate: {{ $lahan->updated_at->format('d/m/Y') }}</p>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <button onclick="openModal('modal-edit-{{ $lahan->id }}')" class="bg-white border border-slate-200 text-slate-600 hover:text-slate-900 hover:border-slate-400 p-2 rounded-lg transition-all shadow-sm" title="Ubah Harga">
                            <span class="material-icons-outlined text-lg block">edit</span>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-slate-500 font-medium">Belum ada data lahan yang tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($lahans->hasPages())
    <div class="px-6 py-4 border-t border-slate-50">
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
