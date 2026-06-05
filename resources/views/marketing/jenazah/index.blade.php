@extends('layouts.admin')

@section('title', 'Data Jenazah - Mount Carmel')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200..800&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif !important; }
</style>
@endpush

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight uppercase">Data Jenazah</h1>
        <p class="text-sm text-slate-500 mt-1">Daftar lengkap jenazah yang dimakamkan di seluruh sektor Mount Carmel.</p>
    </div>
</div>

{{-- Search --}}
<form method="GET" action="{{ route(auth()->user()->role . '.jenazah.index') }}" class="relative mb-6 group">
    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
        <span class="material-icons-outlined text-slate-400 group-focus-within:text-slate-900 transition-colors">search</span>
    </div>
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Cari nama jenazah, nomor lahan, atau nama ahli waris..." 
           class="w-full pl-11 pr-10 py-2 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all placeholder:text-slate-300">
    
    @if(request('search'))
    <a href="{{ route(auth()->user()->role . '.jenazah.index') }}" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
        <span class="material-icons-outlined text-xl">close</span>
    </a>
    @endif
</form>

<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="text-slate-500 font-bold bg-slate-50/50 border-b border-slate-100 uppercase tracking-widest text-[10px]">
                    <th class="px-4 py-2.5">Nama Jenazah</th>
                    <th class="px-4 py-2.5">Lokasi Lahan</th>
                    <th class="px-4 py-2.5">Tanggal Dimakamkan</th>
                    <th class="px-4 py-2.5">Nama Pembeli</th>
                    <th class="px-4 py-2.5 text-right">Status Reservasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($jenazahs as $j)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-4 py-2.5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                                <span class="material-icons-outlined text-sm">person</span>
                            </div>
                            <div>
                                <p class="font-extrabold text-slate-900 uppercase tracking-tight">{{ $j->nama_jenazah }}</p>
                                <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">ID: #RE-{{ $j->id }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-2.5">
                        <p class="font-extrabold text-slate-800 uppercase tracking-tight">Unit {{ $j->lahan->nomor_lahan }}</p>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">{{ $j->lahan->cluster->nama_cluster }}</p>
                    </td>
                    <td class="px-4 py-2.5">
                        @if($j->tanggal_dimakamkan)
                            <p class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($j->tanggal_dimakamkan)->translatedFormat('d F Y') }}</p>
                        @else
                            <span class="text-slate-300">Belum ditentukan</span>
                        @endif
                    </td>
                    <td class="px-4 py-2.5">
                        <p class="font-bold text-slate-800 uppercase text-xs">{{ $j->user->name }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5">{{ $j->user->email }}</p>
                    </td>
                    <td class="px-4 py-2.5 text-right">
                        @php
                            $status = $j->status_reservasi;
                            $badgeClass = match($status) {
                                'Selesai' => 'bg-emerald-50 text-emerald-600',
                                'Ditolak' => 'bg-rose-50 text-rose-600',
                                'Disetujui' => 'bg-indigo-50 text-indigo-600',
                                default => 'bg-amber-50 text-amber-600',
                            };
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $badgeClass }}">
                            {{ $status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center">
                        <div class="flex flex-col items-center gap-4">
                            <span class="material-icons-outlined text-4xl text-slate-100">person_off</span>
                            <p class="text-slate-400 font-bold uppercase text-[10px] tracking-[0.3em]">Belum ada data jenazah yang tercatat</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($jenazahs->hasPages())
    <div class="px-4 py-3 border-t border-slate-50 bg-slate-50/30">
        {{ $jenazahs->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
