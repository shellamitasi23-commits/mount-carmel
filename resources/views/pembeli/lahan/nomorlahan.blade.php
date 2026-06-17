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
        <div class="flex flex-col lg:flex-row gap-24"
             x-data="{
                 selected: null,
                 nomor: '',
                 harga: 0,
                 ukuran: '',
                 kap: 0,
                 pilih(id, n, h, u, k) {
                     this.selected = id;
                     this.nomor = n;
                     this.harga = h;
                     this.ukuran = u;
                     this.kap = k;
                 },
                 rupiah(v) {
                     return 'Rp ' + parseInt(v).toLocaleString('id-ID');
                 }
             }">

            {{-- LEFT: Grid Section --}}
            <div class="flex-1">
                <header class="mb-6">
                    <span class="inline-block text-xs font-bold text-slate-400 mb-1.5">
                        {{ $cluster->nama_cluster }} &middot; {{ $sample?->tipe_lahan ?? 'N/A' }}
                    </span>
                    <h1 class="text-2xl font-bold text-slate-900 tracking-tight mb-2">
                        Pilih Kavling
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
                    <div class="flex items-center gap-2">
                        <div class="w-3.5 h-3.5 rounded-full bg-[#800000] shadow-sm shadow-[#800000]/30"></div>
                        <span class="text-[10px] font-bold text-[#800000]">Pilihan Anda</span>
                    </div>
                </div>

                {{-- Cluster Layout Map --}}
                <div class="mb-8 bg-slate-50 p-4 rounded-2xl border border-slate-100 flex flex-col items-center">
                    <span class="text-[9px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 block">Peta Lokasi Kavling (Blok A, B, C)</span>
                    <img src="{{ asset('images/cluster_map.png') }}" alt="Peta Layout Cluster" class="max-h-[220px] w-auto object-contain rounded-xl shadow-sm border border-white">
                </div>

                {{-- Grid --}}
                <div class="grid gap-4" style="grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));">
                    @foreach($lahans as $lahan)
                        @php
                            $status = strtolower($lahan->status);
                            $isAvailable = $status === 'tersedia';
                        @endphp

                        <div class="aspect-square flex items-center justify-center rounded-2xl border-2 transition-all duration-500 font-black text-sm relative
                             {{ $isAvailable 
                                ? 'bg-white border-slate-100 text-slate-900 hover:border-slate-900 cursor-pointer' 
                                : 'bg-slate-50 border-transparent text-slate-200 cursor-not-allowed' }}"
                             :class="{ 
                                 'bg-[#800000] border-[#800000] text-white scale-110 shadow-2xl shadow-[#800000]/30 z-10': selected == {{ $lahan->id }}
                             }"
                             @if($isAvailable)
                                 @click="pilih({{ $lahan->id }}, '{{ $lahan->nomor_lahan }}', {{ $lahan->harga }}, '{{ $lahan->ukuran }}', {{ $lahan->kapasitas }})"
                             @endif>
                            {{ $lahan->nomor_lahan }}
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- RIGHT: Sidebar Section --}}
            <div class="lg:w-[420px] shrink-0">
                <div class="sticky top-40">
                    
                    {{-- Premium Summary Card --}}
                    <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-[2rem] shadow-xl shadow-gray-100/30 dark:shadow-none overflow-hidden">
                        
                        {{-- Placeholder / Specs --}}
                        <div class="p-8 border-b border-gray-50 dark:border-gray-800">
                            <div x-show="selected === null" class="py-6 text-center">
                                <div class="w-12 h-12 rounded-full bg-gray-50 dark:bg-gray-800 flex items-center justify-center mx-auto mb-4 text-gray-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"/></svg>
                                </div>
                                <h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200 mb-1">Pilih Nomor Kavling</h3>
                                <p class="text-xs text-gray-400 dark:text-gray-500">Tentukan nomor lahan pada grid untuk melihat rincian lokasi dan detail harga.</p>
                            </div>
 
                            <div x-show="selected !== null" x-cloak class="space-y-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wider block mb-0.5">Kavling Terpilih</span>
                                        <h2 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tight" x-text="'#' + nomor"></h2>
                                    </div>
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/30 text-emerald-600 dark:text-emerald-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        Tersedia
                                    </span>
                                </div>

                                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-gray-50 dark:border-gray-850">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-gray-400 shrink-0">
                                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
                                        </div>
                                        <div>
                                            <span class="text-[9px] font-semibold text-gray-400 uppercase tracking-wider block">Luas</span>
                                            <span class="text-xs font-bold text-gray-800 dark:text-gray-200" x-text="ukuran"></span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-gray-400 shrink-0">
                                            <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        </div>
                                        <div>
                                            <span class="text-[9px] font-semibold text-gray-400 uppercase tracking-wider block">Kapasitas</span>
                                            <span class="text-xs font-bold text-gray-800 dark:text-gray-200" x-text="kap + ' Slot'"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Final Action --}}
                        <div class="p-8 bg-gray-50/50 dark:bg-gray-950/20">
                            <div x-show="selected === null" class="text-gray-400 dark:text-gray-500 text-xs italic text-center">
                                Silakan pilih salah satu nomor kavling.
                            </div>
                            <div x-show="selected !== null" x-cloak class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="text-xs font-medium text-gray-400 dark:text-gray-500">Nilai Investasi</span>
                                    <span class="text-xl font-bold text-[#800000] tracking-tight" x-text="rupiah(harga)"></span>
                                </div>
                                <a :href="'{{ route('pembeli.reservasi.create') }}?lahan_id=' + selected"
                                   class="w-full py-4 bg-[#800000] text-white text-center rounded-xl font-semibold text-xs transition-all hover:bg-[#900000] hover:shadow-lg hover:shadow-[#800000]/20 flex items-center justify-center gap-2">
                                    Lanjutkan Pemesanan
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
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

    </div>
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
