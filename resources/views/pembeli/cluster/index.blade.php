@extends('layouts.master')
@section('title', 'Daftar Cluster - Mount Carmel')

@section('content')
<div class="pt-24 min-h-screen bg-white dark:bg-gray-950">

    {{-- Page Header --}}
    <div class="px-8 xl:px-24 py-12 border-b border-gray-100 dark:border-gray-900">
        <div class="max-w-7xl mx-auto">
            <span data-aos="fade-up" class="text-[#800000] font-bold text-xs">Eksklusivitas & Ketenangan</span>
            <h1 data-aos="fade-up" data-aos-delay="100" class="text-3xl md:text-4xl font-bold mt-2 tracking-tight">Daftar Cluster</h1>
            <p data-aos="fade-up" data-aos-delay="200" class="text-gray-500 dark:text-gray-400 mt-4 max-w-2xl text-sm leading-relaxed">
                Kurasi kawasan pemakaman terbaik yang dirancang khusus untuk menghadirkan kedamaian abadi. Pilih antara kawasan Muslim dan Non-Muslim dengan berbagai spesifikasi lahan.
            </p>
        </div>
    </div>
    {{-- Cluster Grid --}}
    <div class="px-8 xl:px-24 py-12" x-data="{ filter: 'semua' }">
        <div class="max-w-7xl mx-auto">

            @if($clusters->isEmpty())
            <div class="text-center py-32">
                <h3 class="text-2xl font-light text-gray-300 mb-2 italic">Belum ada cluster yang dipublikasikan</h3>
                <p class="text-sm text-gray-400 tracking-wide uppercase">Silakan hubungi administrator untuk informasi lebih lanjut.</p>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10 justify-center">

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
                     class="group flex flex-col w-full max-w-md mx-auto bg-white dark:bg-gray-900/50 border border-gray-100 dark:border-gray-800 rounded-3xl p-5 shadow-[0_10px_30px_rgba(0,0,0,0.02)] hover:shadow-[0_20px_40px_rgba(128,0,0,0.06)] dark:hover:shadow-[0_20px_40px_rgba(0,0,0,0.25)] transition-all duration-500 hover:-translate-y-2">

                    {{-- Image Container --}}
                    <div class="relative aspect-[4/3] overflow-hidden bg-gray-100 dark:bg-gray-800 rounded-2xl mb-6">
                        <img src="{{ $img }}" alt="{{ $cluster->nama_cluster }}"
                             class="w-full h-full object-cover transition-transform duration-[1.5s] ease-out group-hover:scale-105" />
                        
                        <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition-colors duration-500"></div>

                        <div class="absolute top-4 left-4 right-4 flex justify-between items-center">
                            <span class="px-3 py-1 bg-white/95 dark:bg-gray-950/95 backdrop-blur-md text-[9px] font-black uppercase tracking-[0.2em] text-[#800000] dark:text-red-400 rounded-full shadow-sm">
                                {{ $cluster->kategori }}
                            </span>
                            
                            @if($tersedia > 0)
                            <span class="px-3 py-1 bg-emerald-500 text-[9px] font-black uppercase tracking-[0.2em] text-white rounded-full shadow-sm">
                                {{ $tersedia }} Unit
                            </span>
                            @else
                            <span class="px-3 py-1 bg-red-500 text-[9px] font-black uppercase tracking-[0.2em] text-white rounded-full shadow-sm">
                                Habis
                            </span>
                            @endif
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="flex flex-col flex-grow px-2">
                        <div class="flex justify-between items-start mb-4 gap-4">
                            <h3 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white group-hover:text-[#800000] dark:group-hover:text-red-400 transition-colors duration-300">
                                {{ $cluster->nama_cluster }}
                            </h3>
                            @if($hargaMin)
                            <div class="text-right shrink-0">
                                <span class="block text-[9px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Mulai</span>
                                <span class="text-[#800000] dark:text-red-400 font-extrabold text-base">
                                    Rp {{ number_format($hargaMin/1000000, 0, ',', '.') }}<span class="text-xs font-semibold">jt</span>
                                </span>
                            </div>
                            @endif
                        </div>

                        <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed font-light mb-6 line-clamp-2">
                            {{ $cluster->deskripsi ?? 'Kawasan pemakaman eksklusif dengan lingkungan asri dan fasilitas lengkap untuk kedamaian keluarga.' }}
                        </p>

                        {{-- Tipe Lahan Tags --}}
                        @if($tipeLahan->isNotEmpty())
                        <div class="flex flex-wrap gap-2 mb-6">
                            @foreach($tipeLahan->take(3) as $tipe)
                            <span class="px-2.5 py-1 text-[9px] font-bold uppercase tracking-wider bg-gray-50 dark:bg-gray-800 text-gray-500 dark:text-gray-400 border border-gray-100 dark:border-gray-800 rounded-lg">
                                {{ $tipe }}
                            </span>
                            @endforeach
                            @if($tipeLahan->count() > 3)
                            <span class="px-2.5 py-1 text-[9px] font-bold text-gray-400 dark:text-gray-500 bg-gray-50/50 dark:bg-gray-800/50 rounded-lg border border-gray-100/50 dark:border-gray-800/50 italic">+{{ $tipeLahan->count() - 3 }}</span>
                            @endif
                        </div>
                        @endif

                        {{-- CTA --}}
                        <div class="mt-auto pt-5 border-t border-gray-50 dark:border-gray-900 flex justify-between items-center">
                            @auth
                            <a href="{{ route('pembeli.lahan.index', ['cluster_id' => $cluster->id]) }}"
                               class="group/btn inline-flex items-center gap-1.5 text-xs font-black uppercase tracking-[0.2em] text-[#800000] dark:text-red-400 transition-all duration-300">
                                <span class="relative py-1">
                                    Lihat Detail Lahan
                                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#800000] dark:bg-red-400 transition-all duration-300 group-hover/btn:w-full"></span>
                                </span>
                                <svg class="w-4 h-4 transform group-hover/btn:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                </svg>
                            </a>
                            @else
                            <a href="{{ route('login') }}"
                               class="group/btn inline-flex items-center gap-1.5 text-xs font-black uppercase tracking-[0.2em] text-gray-400 hover:text-[#800000] dark:hover:text-red-400 transition-all duration-300">
                                <span class="relative py-1">
                                    Login Untuk Memesan
                                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#800000] dark:bg-red-400 transition-all duration-300 group-hover/btn:w-full"></span>
                                </span>
                                <svg class="w-4 h-4 transform group-hover/btn:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14"/>
                                </svg>
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

