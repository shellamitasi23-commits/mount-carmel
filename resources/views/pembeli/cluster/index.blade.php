@extends('layouts.master')
@section('title', 'Daftar Cluster - Mount Carmel')

@section('content')
<div class="pt-24 min-h-screen bg-white dark:bg-gray-950">

    {{-- Page Header --}}
    <div class="px-8 xl:px-24 py-20 border-b border-gray-100 dark:border-gray-900">
        <div class="max-w-7xl mx-auto">
            <span data-aos="fade-up" class="text-primary font-bold tracking-[0.2em] uppercase text-[10px]">Eksklusivitas & Ketenangan</span>
            <h1 data-aos="fade-up" data-aos-delay="100" class="text-6xl md:text-7xl font-bold mt-4 tracking-tighter leading-[0.9]">Daftar Cluster</h1>
            <p data-aos="fade-up" data-aos-delay="200" class="text-gray-400 dark:text-gray-500 mt-6 max-w-2xl text-lg leading-relaxed font-light">
                Kurasi kawasan pemakaman terbaik yang dirancang khusus untuk menghadirkan kedamaian abadi. Pilih antara kawasan Muslim dan Non-Muslim dengan berbagai spesifikasi lahan.
            </p>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="px-8 xl:px-24 py-8 bg-white dark:bg-gray-950 sticky top-20 z-10 border-b border-gray-50 dark:border-gray-900"
         x-data="{ filter: 'semua' }">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center gap-8">
            <button @click="filter = 'semua'"
                    :class="filter === 'semua' ? 'text-gray-900 dark:text-white border-b-2 border-primary' : 'text-gray-400 hover:text-gray-600'"
                    class="pb-2 text-xs font-bold uppercase tracking-widest transition-all">
                Semua Koleksi
            </button>

            <button @click="filter = 'Muslim'"
                    :class="filter === 'Muslim' ? 'text-gray-900 dark:text-white border-b-2 border-primary' : 'text-gray-400 hover:text-gray-600'"
                    class="pb-2 text-xs font-bold uppercase tracking-widest transition-all">
                Kawasan Muslim
            </button>

            <button @click="filter = 'Non-Muslim'"
                    :class="filter === 'Non-Muslim' ? 'text-gray-900 dark:text-white border-b-2 border-primary' : 'text-gray-400 hover:text-gray-600'"
                    class="pb-2 text-xs font-bold uppercase tracking-widest transition-all">
                Kawasan Non-Muslim
            </button>
        </div>
    </div>

    {{-- Cluster Grid --}}
    <div class="px-8 xl:px-24 py-20" x-data="{ filter: 'semua' }">
        <div class="max-w-7xl mx-auto">

            @if($clusters->isEmpty())
            <div class="text-center py-32">
                <h3 class="text-2xl font-light text-gray-300 mb-2 italic">Belum ada cluster yang dipublikasikan</h3>
                <p class="text-sm text-gray-400 tracking-wide uppercase">Silakan hubungi administrator untuk informasi lebih lanjut.</p>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 lg:gap-16">

                @foreach($clusters as $i => $cluster)
                @php
                    $lahans         = $cluster->lahans;
                    $tersedia       = $lahans->where('status', 'Tersedia')->count();
                    $isMuslim       = $cluster->kategori === 'Muslim';
                    $tipeLahan      = $lahans->pluck('tipe_lahan')->unique()->values();
                    
                    // Hanya ambil harga terendah dari unit yang tersedia dan harga > 0
                    $hargaMin       = $lahans->where('status', 'Tersedia')->where('harga', '>', 0)->min('harga');
                    
                    // Format harga untuk tampilan (misal: 25jt)
                    $hargaDisplay   = $hargaMin ? number_format($hargaMin / 1000000, 0, ',', '.') . 'jt' : '—';

                    $img = $isMuslim
                        ? 'https://lh3.googleusercontent.com/aida-public/AB6AXuA6rqI9PeXcrrGEttejmy2Cel3avh8VDbuuLZ9znSeQ0Gw8_f3nDIPA5daXuk1lNSAm-tWxpJ6GMjkfk9Tp4ugchXR-TAxa51kf5RD--deEWZYCqfHqwdgP2haxZx3xe7cTs56uTS0TFSEdFgax5uGIbYCrGwAW6cxENUzjoD6JXr0AiwuyMq0RGnXuNAwZgLJIJ_7ohB4P4zHoRvO2BfqUnDNpU9LpoqSZub_tqXvtwDa3MXakwPvYeN3NT97N3pe77_3ygdwuIsc'
                        : 'https://lh3.googleusercontent.com/aida-public/AB6AXuCSeV8r5vTKVZson8x8U7XKosDU4OBIVwZCPNZOGiv7g8lL5mQYOegvqR47c2dPLgGFWhnrnslq9ErpprziLGhdeyqqystblfmKjcXSYUs3Ex5arOXBjjL80xf80mRmXZS6gCg9ShL7wBZ09_YS6GYhWfYN8ngIMMJKxo-PMrFVAhpyGaPNnDwhj0B12HdNVsq6MbUvK0TVpR3IYfH2whIB76pNLxyD6Zc2Asd_nuvAYJufsHTjqWMGi_EKBGJGKb7I688tdFK_1Qw';
                @endphp

                <div data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 100 }}"
                     x-show="filter === 'semua' || filter === '{{ $cluster->kategori }}'"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 translate-y-8"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="group flex flex-col">

                    {{-- Image Aspect Ratio 4:5 for Premium Feel --}}
                    <div class="relative aspect-[4/5] overflow-hidden bg-gray-100 dark:bg-gray-900 rounded-sm">
                        <img src="{{ $img }}" alt="{{ $cluster->nama_cluster }}"
                             class="w-full h-full object-cover transition-transform duration-[1.5s] ease-out group-hover:scale-105" />
                        
                        <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition-colors duration-500"></div>

                        <div class="absolute top-6 left-6 right-6 flex justify-between items-start">
                            <span class="px-4 py-1.5 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md text-[9px] font-black uppercase tracking-[0.2em] text-gray-900 dark:text-white">
                                {{ $cluster->kategori }}
                            </span>
                            
                            @if($tersedia > 0)
                            <span class="text-[9px] font-bold uppercase tracking-widest text-white drop-shadow-sm">
                                {{ $tersedia }} Unit Tersedia
                            </span>
                            @else
                            <span class="text-[9px] font-bold uppercase tracking-widest text-red-400 drop-shadow-sm">
                                Terjual Habis
                            </span>
                            @endif
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="py-8 flex flex-col flex-grow">
                        <div class="flex justify-between items-end mb-4">
                            <h3 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $cluster->nama_cluster }}</h3>
                            @if($hargaMin)
                            <span class="text-xs font-medium text-gray-400">
                                Mulai <span class="text-gray-900 dark:text-white font-bold text-base ml-1">Rp {{ number_format($hargaMin/1000000, 0, ',', '.') }}jt</span>
                            </span>
                            @endif
                        </div>

                        <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed font-light mb-8 line-clamp-2">
                            {{ $cluster->deskripsi ?? 'Kawasan pemakaman eksklusif dengan lingkungan asri dan fasilitas lengkap untuk kedamaian keluarga.' }}
                        </p>

                        {{-- Tipe Lahan Tags --}}
                        @if($tipeLahan->isNotEmpty())
                        <div class="flex flex-wrap gap-2 mb-10">
                            @foreach($tipeLahan->take(3) as $tipe)
                            <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400 border-b border-gray-100 dark:border-gray-800 pb-0.5">
                                {{ $tipe }}
                            </span>
                            @endforeach
                            @if($tipeLahan->count() > 3)
                            <span class="text-[10px] font-bold text-gray-300 italic">+{{ $tipeLahan->count() - 3 }} lainnya</span>
                            @endif
                        </div>
                        @endif

                        {{-- CTA --}}
                        <div class="mt-auto pt-6 border-t border-gray-50 dark:border-gray-900">
                            @auth
                            <a href="{{ route('pembeli.lahan.index', ['cluster_id' => $cluster->id]) }}"
                               class="group/btn inline-flex items-center text-xs font-black uppercase tracking-[0.3em] text-gray-900 dark:text-white transition-all">
                                <span class="border-b-2 border-primary pb-1 group-hover/btn:pr-4 transition-all duration-300">Lihat Detail Lahan</span>
                            </a>
                            @else
                            <a href="{{ route('login') }}"
                               class="group/btn inline-flex items-center text-xs font-black uppercase tracking-[0.3em] text-gray-400 transition-all">
                                <span class="border-b-2 border-gray-200 pb-1 group-hover/btn:text-gray-900 group-hover/btn:border-primary transition-all duration-300">Login Untuk Memesan</span>
                            </a>
                            @endauth
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
            @endif

        </div>
    </div>

</div>
@endsection

