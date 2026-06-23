@extends('layouts.master')
@section('title')
Nomor Lahan — {{ $sample?->tipe_lahan ?? 'N/A' }}
@endsection

@section('content')
<div class="min-h-screen bg-white pt-28 pb-20">
    <div class="max-w-7xl mx-auto px-10">

        {{-- Minimalist Breadcrumb --}}
        <nav class="flex items-center gap-2 text-xs text-gray-400 mb-8">
            <a href="{{ route('home') }}" class="hover:text-slate-900 transition-colors">Beranda</a>
            <span>/</span>
            <a href="{{ route('cluster.index') }}" class="hover:text-slate-900 transition-colors">Cluster</a>
            <span>/</span>
            <a href="{{ route('pembeli.lahan.index', ['cluster_id' => $cluster->id]) }}" class="hover:text-slate-900 transition-colors">{{ $cluster->nama_cluster }}</a>
            <span>/</span>
            <span class="text-slate-900 font-medium">{{ $sample?->tipe_lahan ?? 'N/A' }}</span>
        </nav>

        {{-- Alpine Container --}}
        <div class="max-w-3xl mx-auto" x-data="{}">

            <header class="mb-6">
                <span class="inline-block text-xs font-bold text-slate-400 mb-1.5">
                    {{ $cluster->nama_cluster }} &middot; {{ $sample?->tipe_lahan ?? 'N/A' }}
                </span>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight mb-2">
                    Pilih Nomor Lahan
                </h1>
                <p class="text-slate-555 text-xs leading-relaxed max-w-xl">
                    Tentukan lokasi terbaik untuk peristirahatan terakhir. Tersedia {{ collect($lahans)->where('status','Tersedia')->count() }} unit di cluster ini.
                </p>
            </header>

            {{-- Legend --}}
            <div class="flex flex-wrap gap-6 mb-6 border-b border-slate-100 pb-6">
                <div class="flex items-center gap-2">
                    <div class="w-3.5 h-3.5 rounded-full border border-slate-200 bg-slate-50"></div>
                    <span class="text-[10px] font-bold text-slate-400">Tersedia</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3.5 h-3.5 rounded-full bg-slate-100"></div>
                    <span class="text-[10px] font-bold text-slate-300">Terjual</span>
                </div>
            </div>

            {{-- Cluster Layout Map --}}
            <div class="mb-8 bg-slate-50 p-4 rounded-2xl border border-slate-100 flex flex-col items-center">
                <span class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 block">Peta Lokasi Lahan</span>
                <img src="{{ asset('images/cluster_map.png') }}" alt="Peta Layout Cluster" class="max-h-[220px] w-auto object-contain rounded-xl shadow-sm border border-white">
            </div>

            {{-- Grid --}}
            <div class="grid gap-4 mb-12" style="grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));">
                @foreach($lahans as $lahan)
                    @php
                        $status = strtolower($lahan->status);
                        $isAvailable = $status === 'tersedia';
                    @endphp

                    <div class="aspect-square flex items-center justify-center rounded-2xl border-2 transition-all duration-500 font-black text-sm relative
                         {{ $isAvailable 
                            ? 'bg-white border-slate-100 text-slate-900 hover:border-slate-900 cursor-pointer hover:scale-105 hover:shadow-md' 
                            : 'bg-slate-50 border-transparent text-slate-200 cursor-not-allowed' }}"
                         @if($isAvailable)
                             @click="window.location.href = '{{ route('pembeli.reservasi.create') }}?lahan_id={{ $lahan->id }}'"
                         @endif>
                        {{ $lahan->nomor_lahan }}
                    </div>
                @endforeach
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('pembeli.lahan.index', ['cluster_id' => $cluster->id]) }}"
                   class="text-xs font-bold text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors pb-1 border-b border-dashed border-gray-200 hover:border-gray-950">
                    Pilih Tipe Lahan Lainnya
                </a>
            </div>
        </div>

    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
