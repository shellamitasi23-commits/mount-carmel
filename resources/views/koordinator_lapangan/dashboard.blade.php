@extends('layouts.admin')
@section('title', 'Dashboard Koordinator Lapangan')

@section('content')
<div class="mb-6">
    <h1 class="text-xl font-bold text-slate-800">Manajemen Lapangan</h1>
    <p class="text-xs text-slate-500 mt-1">Kelola data Cluster makam, plot Lahan (Lahan), dan pantau ketersediaan lahan secara real-time.</p>
</div>

{{-- Stats Grid --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    {{-- Total Cluster --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 flex items-center justify-between transition-all hover:shadow-md duration-300">
        <div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Cluster</p>
            <h3 class="text-lg font-extrabold text-slate-800 mt-1">{{ $stats['total_cluster'] }} Cluster</h3>
            <span class="inline-flex items-center gap-1 mt-1 text-[10px] font-bold text-slate-500">
                Area Pemakaman
            </span>
        </div>
        <div class="w-10 h-10 rounded-lg bg-[#800000]/5 text-[#800000] flex items-center justify-center">
            <span class="material-icons-outlined text-lg">map</span>
        </div>
    </div>

    {{-- Total Lahan --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 flex items-center justify-between transition-all hover:shadow-md duration-300">
        <div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Lahan</p>
            <h3 class="text-lg font-extrabold text-slate-800 mt-1">{{ $stats['total_lahan'] }} Unit</h3>
            <span class="inline-flex items-center gap-1 mt-1 text-[10px] font-bold text-slate-500">
                Lahan Terdaftar
            </span>
        </div>
        <div class="w-10 h-10 rounded-lg bg-[#800000]/5 text-[#800000] flex items-center justify-center">
            <span class="material-icons-outlined text-lg">view_module</span>
        </div>
    </div>

    {{-- Lahan Tersedia --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 flex items-center justify-between transition-all hover:shadow-md duration-300">
        <div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Lahan Kosong</p>
            <h3 class="text-lg font-extrabold text-emerald-600 mt-1">{{ $stats['tersedia'] }} Unit</h3>
            <span class="inline-flex items-center gap-1 mt-1 text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                Siap Dipesan
            </span>
        </div>
        <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
            <span class="material-icons-outlined text-lg">check_circle</span>
        </div>
    </div>

    {{-- Lahan Terisi/Dipesan --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 flex items-center justify-between transition-all hover:shadow-md duration-300">
        <div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Lahan Terisi</p>
            <h3 class="text-lg font-extrabold text-blue-600 mt-1">{{ $stats['terisi'] }} Unit</h3>
            <span class="inline-flex items-center gap-1 mt-1 text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">
                Reservasi & Digunakan
            </span>
        </div>
        <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
            <span class="material-icons-outlined text-lg">block</span>
        </div>
    </div>
</div>

{{-- Occupancy Overview --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Land Occupancy Bar --}}
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-100 p-4">
        <h3 class="text-sm font-bold text-slate-800 mb-3">Rasio Okupansi Lahan</h3>
        @php
            $total = $stats['total_lahan'] ?: 1;
            $percentTersedia = round(($stats['tersedia'] / $total) * 100, 1);
            $percentTerisi = round(($stats['terisi'] / $total) * 100, 1);
        @endphp
        <div class="space-y-4 pt-2">
            <div>
                <div class="flex justify-between items-center text-xs font-bold text-slate-600 mb-1.5">
                    <span>Lahan Terisi (Okupansi)</span>
                    <span>{{ $percentTerisi }}%</span>
                </div>
                <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                    <div style="width: {{ $percentTerisi }}%" class="bg-[#800000] h-full rounded-full shadow-inner"></div>
                </div>
            </div>

            <div>
                <div class="flex justify-between items-center text-xs font-bold text-slate-600 mb-1.5">
                    <span>Lahan Tersedia (Kosong)</span>
                    <span>{{ $percentTersedia }}%</span>
                </div>
                <div class="w-full bg-slate-100 h-2.5 rounded-full overflow-hidden">
                    <div style="width: {{ $percentTersedia }}%" class="bg-emerald-500 h-full rounded-full shadow-inner"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Allocations --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4">
        <h3 class="text-sm font-bold text-slate-800 mb-3">Alokasi Reservasi Terbaru</h3>
        <div class="space-y-3">
            @forelse($latest_allocations as $alloc)
                <div class="flex items-center gap-3 pb-2.5 border-b border-slate-50 last:border-b-0 last:pb-0">
                    <span class="material-icons-outlined text-slate-400">landscape</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-slate-800">Lahan #{{ $alloc->lahan?->nomor_lahan ?? '-' }}</p>
                        <p class="text-[10px] text-slate-400 truncate">{{ $alloc->lahan?->cluster?->nama_cluster ?? 'N/A' }} • {{ $alloc->created_at->diffForHumans() }}</p>
                    </div>
                    <div>
                        <span class="px-2 py-0.5 rounded text-[8px] font-black uppercase
                            {{ $alloc->status_reservasi === 'Selesai' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ $alloc->status_reservasi }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-xs text-slate-400 italic py-6 text-center">Belum ada alokasi reservasi.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
