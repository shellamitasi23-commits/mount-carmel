@extends('layouts.master')
@section('title')
Nomor Lahan — {{ $sample?->tipe_lahan ?? 'N/A' }}
@endsection

@section('content')
<div class="min-h-screen bg-white pt-40 pb-32">
    <div class="max-w-7xl mx-auto px-10">

        {{-- Editorial Breadcrumb --}}
        <nav class="flex items-center gap-4 text-[11px] font-black uppercase tracking-[0.3em] text-slate-300 mb-16">
            <a href="{{ route('home') }}" class="hover:text-slate-900 transition-colors">Beranda</a>
            <span>/</span>
            <a href="{{ route('cluster.index') }}" class="hover:text-slate-900 transition-colors">Cluster</a>
            <span>/</span>
            <a href="{{ route('pembeli.lahan.index', ['cluster_id' => $cluster->id]) }}" class="hover:text-slate-900 transition-colors">{{ $cluster->nama_cluster }}</a>
            <span>/</span>
            <span class="text-slate-900">{{ $sample?->tipe_lahan ?? 'N/A' }}</span>
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
                <header class="mb-20">
                    <span class="inline-block text-slate-400 font-black tracking-[0.4em] uppercase text-[10px] mb-6">
                        {{ $cluster->nama_cluster }} &middot; {{ $sample?->tipe_lahan ?? 'N/A' }}
                    </span>
                    <h1 class="text-7xl md:text-8xl font-black text-slate-900 tracking-tighter mb-8 leading-[0.85] italic">
                        Pilih Kavling
                    </h1>
                    <p class="text-slate-500 text-xl font-medium leading-relaxed max-w-xl">
                        Tentukan lokasi terbaik untuk peristirahatan terakhir. Tersedia {{ collect($lahans)->where('status','Tersedia')->count() }} unit di cluster ini.
                    </p>
                </header>

                {{-- Legend --}}
                <div class="flex flex-wrap gap-12 mb-16 border-b-2 border-slate-50 pb-12">
                    <div class="flex items-center gap-4">
                        <div class="w-5 h-5 rounded-full border-2 border-slate-200 bg-slate-50"></div>
                        <span class="text-[11px] font-black uppercase tracking-widest text-slate-400">Tersedia</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-5 h-5 rounded-full bg-slate-100"></div>
                        <span class="text-[11px] font-black uppercase tracking-widest text-slate-200">Terjual</span>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="w-5 h-5 rounded-full bg-slate-900 shadow-2xl shadow-slate-300"></div>
                        <span class="text-[11px] font-black uppercase tracking-widest text-slate-900">Pilihan Anda</span>
                    </div>
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
                                 'bg-slate-900 border-slate-900 text-white scale-110 shadow-2xl shadow-slate-300 z-10': selected == {{ $lahan->id }}
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
            <div class="lg:w-[450px] shrink-0">
                <div class="sticky top-40">
                    
                    {{-- Premium Summary Card --}}
                    <div class="bg-white border-t-[12px] border-slate-900 shadow-2xl shadow-slate-200/60 overflow-hidden">
                        
                        {{-- Placeholder / Specs --}}
                        <div class="p-12 border-b border-slate-100">
                            <div x-show="selected === null">
                                <p class="text-[11px] font-black text-slate-300 uppercase tracking-[0.4em] mb-12">Detail Kavling</p>
                                <h3 class="text-3xl font-black text-slate-900 tracking-tighter leading-tight mb-8">Pilih nomor kavling untuk melihat rincian</h3>
                                <div class="h-1 w-12 bg-slate-100"></div>
                            </div>

                            <div x-show="selected !== null" x-cloak>
                                <p class="text-[11px] font-black text-slate-300 uppercase tracking-[0.4em] mb-12">Kavling Terpilih</p>
                                
                                <div class="mb-12">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nomor Lahan</p>
                                    <h2 class="text-7xl font-black text-slate-900 tracking-tighter leading-none italic" x-text="'#' + nomor"></h2>
                                </div>

                                <div class="space-y-8">
                                    <div class="grid grid-cols-2 gap-8">
                                        <div>
                                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Luas</p>
                                            <p class="text-lg font-black text-slate-900" x-text="ukuran"></p>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Kapasitas</p>
                                            <p class="text-lg font-black text-slate-900" x-text="kap + ' Slot'"></p>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Status Lahan</p>
                                        <p class="text-sm font-black text-emerald-600 uppercase tracking-widest">Tersedia Untuk Dipesan</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Final Action --}}
                        <div class="p-12 bg-slate-50/50">
                            <div x-show="selected === null" class="text-slate-300 font-bold text-sm italic">
                                Belum ada lokasi terpilih.
                            </div>
                            <div x-show="selected !== null" x-cloak class="space-y-8">
                                <div class="flex justify-between items-end">
                                    <div>
                                        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Nilai Investasi</p>
                                        <p class="text-3xl font-black text-slate-900 tracking-tight" x-text="rupiah(harga)"></p>
                                    </div>
                                </div>
                                <a :href="'{{ route('pembeli.reservasi.create') }}?lahan_id=' + selected"
                                   class="w-full block bg-slate-900 text-white text-center py-6 rounded-2xl font-black text-xs uppercase tracking-[0.3em] hover:bg-black transition-all active:scale-95 shadow-2xl shadow-slate-200">
                                    Lanjutkan Pemesanan
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mt-12 text-center">
                        <a href="{{ route('pembeli.lahan.index', ['cluster_id' => $cluster->id]) }}"
                           class="text-[11px] font-black uppercase tracking-[0.3em] text-slate-400 hover:text-slate-900 transition-all border-b-2 border-transparent hover:border-slate-900 pb-1">
                            Kembali Pilih Tipe Lahan
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
