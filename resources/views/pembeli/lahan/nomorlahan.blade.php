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
            <a href="{{ route('pembeli.lahan.index') }}" class="hover:text-slate-900 transition-colors">Lahan</a>
            <span>/</span>
            <a href="{{ route('pembeli.lahan.index', ['cluster_id' => $cluster->id]) }}" class="hover:text-slate-900 transition-colors">{{ $cluster->nama_cluster }}</a>
            <span>/</span>
            <span class="text-slate-900 font-medium">{{ $sample?->tipe_lahan ?? 'N/A' }}</span>
        </nav>

        {{-- Alpine Container --}}
        <div class="max-w-3xl mx-auto" x-data="{
            showModal: false,
            selectedLahan: {
                id: '',
                nomor: '',
                tipe: '',
                ukuran: '',
                kapasitas: '',
                harga: '',
                hadap: '',
                image: '',
                url: ''
            },
            openDetail(lahan) {
                this.selectedLahan = lahan;
                this.showModal = true;
            }
        }">

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
            <div class="space-y-12 mb-12">
                @php
                    $groupedLahans = $lahans->groupBy(function($l) {
                        $parts = explode('-', $l->nomor_lahan);
                        return count($parts) > 1 ? $parts[0] : 'Lahan';
                    });
                @endphp

                @foreach($groupedLahans as $blok => $blokLahans)
                    <div class="bg-white rounded-3xl border border-slate-100 p-6 shadow-sm">
                        <div class="flex items-center gap-2 mb-6">
                            <span class="w-3.5 h-3.5 rounded-full bg-[#800000] border-2 border-white shadow-sm"></span>
                            <h3 class="text-sm font-black uppercase tracking-wider text-slate-800">
                                Blok {{ $blok }}
                            </h3>
                        </div>
                        <div class="grid gap-3 grid-cols-4 sm:grid-cols-6 md:grid-cols-8">
                            @foreach($blokLahans as $lahan)
                                @php
                                    $status = strtolower($lahan->status);
                                    $isAvailable = $status === 'tersedia';

                                    // Map image just like we did in index
                                    $tipeLower = strtolower($lahan->tipe_lahan);
                                    if (str_contains($tipeLower, 'barokah')) {
                                        $img = asset('storage/assets/tipe/barokah.png');
                                    } elseif (str_contains($tipeLower, 'fitrah')) {
                                        $img = asset('storage/assets/tipe/Fitrah.png');
                                    } elseif (str_contains($tipeLower, 'shakinah')) {
                                        $img = asset('storage/assets/tipe/shakinah.png');
                                    } elseif (str_contains($tipeLower, 'khalifah')) {
                                        $img = asset('storage/assets/tipe/khalifah.png');
                                    } elseif (str_contains($tipeLower, 'single')) {
                                        $img = asset('storage/assets/tipe/single.jpeg');
                                    } elseif (str_contains($tipeLower, 'double deluxe') || str_contains($tipeLower, 'd. deluxe')) {
                                        $img = asset('storage/assets/tipe/double-deluxe.jpeg');
                                    } elseif (str_contains($tipeLower, 'double special') || str_contains($tipeLower, 'd. special') || str_contains($tipeLower, 'db-special')) {
                                        $img = asset('storage/assets/tipe/db-special.jpeg');
                                    } elseif (str_contains($tipeLower, 'deluxe')) {
                                        $img = asset('storage/assets/tipe/deluxe.png');
                                    } elseif (str_contains($tipeLower, 'double')) {
                                        $img = asset('storage/assets/tipe/double(2).png');
                                    } elseif (str_contains($tipeLower, 'super family') || str_contains($tipeLower, 'super-family') || str_contains($tipeLower, 's. family')) {
                                        $img = asset('storage/assets/tipe/super-family.png');
                                    } elseif (str_contains($tipeLower, 'royal family') || str_contains($tipeLower, 'royal-family') || str_contains($tipeLower, 'royal')) {
                                        $img = asset('storage/assets/tipe/royal-family.png');
                                    } elseif (str_contains($tipeLower, 'vip')) {
                                        $img = asset('storage/assets/tipe/vip.png');
                                    } elseif (str_contains($tipeLower, 'family')) {
                                        $img = asset('storage/assets/tipe/family.png');
                                    } else {
                                        $img = $cluster->kategori === 'Muslim' 
                                            ? asset('storage/assets/tipe/barokah.png')
                                            : asset('storage/assets/tipe/non-muslim.png');
                                    }

                                    $lahanData = json_encode([
                                        'id' => $lahan->id,
                                        'nomor' => $lahan->nomor_lahan,
                                        'tipe' => $lahan->tipe_lahan,
                                        'ukuran' => $lahan->ukuran,
                                        'kapasitas' => $lahan->kapasitas,
                                        'harga' => 'Rp ' . number_format($lahan->harga, 0, ',', '.'),
                                        'hadap' => $lahan->hadap ?? '—',
                                        'image' => $img,
                                        'url' => route('pembeli.reservasi.create') . '?lahan_id=' . $lahan->id
                                    ]);
                                @endphp

                                <div class="aspect-square flex items-center justify-center rounded-2xl border border-slate-100 transition-all duration-300 font-bold text-[10px] sm:text-xs relative
                                     {{ $isAvailable 
                                        ? 'bg-white text-slate-800 hover:border-slate-900 cursor-pointer hover:scale-105 hover:shadow-md' 
                                        : 'bg-slate-50 text-slate-300 cursor-not-allowed' }}"
                                     @if($isAvailable)
                                         @click="openDetail({{ $lahanData }})"
                                     @endif>
                                    {{ $lahan->nomor_lahan }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-8 text-center">
                <a href="{{ route('pembeli.lahan.index', ['cluster_id' => $cluster->id]) }}"
                   class="text-xs font-bold text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors pb-1 border-b border-dashed border-gray-200 hover:border-gray-950">
                    Pilih Tipe Lahan Lainnya
                </a>
            </div>

            {{-- Detail Lahan Modal --}}
            <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none;">
                {{-- Backdrop --}}
                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showModal = false"></div>

                {{-- Modal Box --}}
                <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative bg-white dark:bg-gray-900 rounded-3xl w-[92%] sm:w-full max-w-[360px] overflow-hidden shadow-2xl border border-gray-100 dark:border-gray-800 p-4 sm:p-5 z-10">
                    
                    {{-- Close Button --}}
                    <button @click="showModal = false" class="absolute top-3 right-3 w-7 h-7 flex items-center justify-center bg-white/90 dark:bg-gray-800/90 hover:bg-[#800000] dark:hover:bg-red-500 text-gray-400 hover:text-white rounded-full transition-all duration-300 focus:outline-none z-20 shadow-sm hover:scale-105 active:scale-95">
                        <i class="bi bi-x-lg text-[10px]"></i>
                    </button>

                    <div class="flex flex-col gap-4">
                        {{-- Image Container --}}
                        <div class="relative aspect-[16/10] overflow-hidden bg-slate-50 dark:bg-gray-800 rounded-xl shadow-inner">
                            <img :src="selectedLahan.image" :alt="selectedLahan.tipe" class="w-full h-full object-cover object-center">
                            <div class="absolute top-3 left-3">
                                <span class="px-2.5 py-0.5 bg-[#800000] text-[8px] font-black uppercase tracking-[0.2em] text-white rounded-full shadow-sm">
                                    Kavling #<span x-text="selectedLahan.nomor"></span>
                                </span>
                            </div>
                        </div>

                        {{-- Details --}}
                        <div>
                            <span class="text-[8px] font-bold uppercase tracking-widest text-[#800000] dark:text-red-400 block mb-0.5">Detail Kavling</span>
                            <h3 class="text-xl font-bold text-gray-900 dark:text-white tracking-tight mb-3" x-text="selectedLahan.tipe"></h3>

                            <div class="grid grid-cols-2 gap-3 border-t border-b border-gray-100 dark:border-gray-800 py-3 mb-4">
                                <div>
                                    <span class="block text-[8px] font-bold uppercase tracking-wider text-gray-400">Luas Dimensi</span>
                                    <span class="text-xs font-bold text-gray-700 dark:text-gray-300" x-text="selectedLahan.ukuran"></span>
                                </div>
                                <div>
                                    <span class="block text-[8px] font-bold uppercase tracking-wider text-gray-400">Kapasitas</span>
                                    <span class="text-xs font-bold text-gray-700 dark:text-gray-300"><span x-text="selectedLahan.kapasitas"></span> Slot</span>
                                </div>
                                <div class="mt-1">
                                    <span class="block text-[8px] font-bold uppercase tracking-wider text-gray-400">Hadap</span>
                                    <span class="text-xs font-bold text-gray-700 dark:text-gray-300" x-text="selectedLahan.hadap"></span>
                                </div>
                                <div class="mt-1">
                                    <span class="block text-[8px] font-bold uppercase tracking-wider text-gray-400">Harga Lahan</span>
                                    <span class="text-xs font-extrabold text-[#800000] dark:text-red-400" x-text="selectedLahan.harga"></span>
                                </div>
                            </div>

                            {{-- CTA Button --}}
                            <a :href="selectedLahan.url" class="w-full inline-flex justify-center items-center gap-2 bg-[#800000] text-white text-center py-3 rounded-xl text-[10px] font-black uppercase tracking-[0.2em] hover:bg-[#800000]/90 transition-all shadow-md hover:shadow-lg hover:shadow-[#800000]/10 duration-300">
                                <span>Pesan Lahan Ini</span>
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                        </div>
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
