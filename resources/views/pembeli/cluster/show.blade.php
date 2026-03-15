@extends('layouts.master')
@section('title', '{{ $cluster->nama_cluster }} - Mount Carmel')

@section('content')
<div class="pt-24 min-h-screen bg-white dark:bg-gray-950">

    {{-- Breadcrumb --}}
    <div class="px-8 xl:px-24 pt-8">
        <div class="max-w-7xl mx-auto flex items-center gap-2 text-sm text-gray-400">
            <a href="{{ route('home') }}" class="hover:text-gray-600 transition-colors">Beranda</a>
            <span class="material-icons text-xs">chevron_right</span>
            <a href="{{ route('cluster.index') }}" class="hover:text-gray-600 transition-colors">Cluster</a>
            <span class="material-icons text-xs">chevron_right</span>
            <span class="text-gray-900 dark:text-white font-medium">{{ $cluster->nama_cluster }}</span>
        </div>
    </div>

    {{-- Hero --}}
    <div class="px-8 xl:px-24 pt-6 pb-0">
        <div class="max-w-7xl mx-auto">
            <div class="relative w-full h-[420px] rounded-3xl overflow-hidden" data-aos="zoom-in">
                @php
                    $isMuslim = $cluster->kategori === 'Muslim';
                    $heroImg = $isMuslim
                        ? 'https://lh3.googleusercontent.com/aida-public/AB6AXuA6rqI9PeXcrrGEttejmy2Cel3avh8VDbuuLZ9znSeQ0Gw8_f3nDIPA5daXuk1lNSAm-tWxpJ6GMjkfk9Tp4ugchXR-TAxa51kf5RD--deEWZYCqfHqwdgP2haxZx3xe7cTs56uTS0TFSEdFgax5uGIbYCrGwAW6cxENUzjoD6JXr0AiwuyMq0RGnXuNAwZgLJIJ_7ohB4P4zHoRvO2BfqUnDNpU9LpoqSZub_tqXvtwDa3MXakwPvYeN3NT97N3pe77_3ygdwuIsc'
                        : 'https://lh3.googleusercontent.com/aida-public/AB6AXuCSeV8r5vTKVZson8x8U7XKosDU4OBIVwZCPNZOGiv7g8lL5mQYOegvqR47c2dPLgGFWhnrnslq9ErpprziLGhdeyqqystblfmKjcXSYUs3Ex5arOXBjjL80xf80mRmXZS6gCg9ShL7wBZ09_YS6GYhWfYN8ngIMMJKxo-PMrFVAhpyGaPNnDwhj0B12HdNVsq6MbUvK0TVpR3IYfH2whIB76pNLxyD6Zc2Asd_nuvAYJufsHTjqWMGi_EKBGJGKb7I688tdFK_1Qw';
                @endphp
                <img src="{{ $heroImg }}" alt="{{ $cluster->nama_cluster }}"
                     class="w-full h-full object-cover" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                <div class="absolute bottom-8 left-8 text-white">
                    <span class="inline-flex items-center gap-1 {{ $isMuslim ? 'bg-white/20 border border-white/30' : 'bg-white/20 border border-white/30' }} backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold mb-3">
                        <span class="material-icons text-xs">{{ $isMuslim ? 'mosque' : 'church' }}</span>
                        {{ $cluster->kategori }}
                    </span>
                    <h1 class="font-display text-4xl md:text-5xl font-bold">{{ $cluster->nama_cluster }}</h1>
                    <p class="text-white/80 text-sm mt-2 max-w-xl">
                        {{ $cluster->deskripsi ?? 'Kawasan pemakaman eksklusif Mount Carmel' }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Bar --}}
    <div class="px-8 xl:px-24 py-8">
        <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-4">
            @php
                $allKavlings  = $cluster->kavlings;
                $totalKavling = $allKavlings->count();
                $tersedia     = $allKavlings->where('status','Tersedia')->count();
                $dipesan      = $allKavlings->where('status','Dipesan')->count();
                $terjual      = $allKavlings->where('status','Terjual')->count();
            @endphp
            @foreach([
                ['icon'=>'grid_view',    'label'=>'Total Kavling', 'value'=> $totalKavling.' Unit'],
                ['icon'=>'check_circle', 'label'=>'Tersedia',      'value'=> $tersedia.' Unit'],
                ['icon'=>'pending',      'label'=>'Dipesan',       'value'=> $dipesan.' Unit'],
                ['icon'=>'sell',         'label'=>'Terjual',       'value'=> $terjual.' Unit'],
            ] as $stat)
            <div data-aos="fade-up" class="bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-5 flex items-center gap-4">
                <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center">
                    <span class="material-icons text-primary">{{ $stat['icon'] }}</span>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider font-bold">{{ $stat['label'] }}</p>
                    <p class="text-base font-bold text-gray-900 dark:text-white mt-0.5">{{ $stat['value'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Tipe Kavling — Tab --}}
    @php
        $tipeList = $cluster->kavlings->groupBy('tipe_kavling');
    @endphp

    @if($tipeList->isNotEmpty())
    <div class="px-8 xl:px-24 pb-16" x-data="{ activeTab: '{{ $tipeList->keys()->first() }}' }">
        <div class="max-w-7xl mx-auto">

            <div class="mb-10">
                <span data-aos="fade-up" class="text-primary font-bold tracking-widest uppercase text-xs">Pilih Tipe</span>
                <h2 data-aos="fade-up" data-aos-delay="100" class="font-display text-3xl md:text-4xl font-bold mt-2 leading-tight">
                    Tipe Kavling di {{ $cluster->nama_cluster }}
                </h2>
                <p data-aos="fade-up" data-aos-delay="200" class="text-gray-500 mt-3 max-w-lg text-sm">
                    Pilih tipe kavling sesuai kebutuhan keluarga. Klik kavling untuk langsung memesan.
                </p>
            </div>

            {{-- Tab Selector --}}
            <div data-aos="fade-up" data-aos-delay="300"
                 class="flex flex-wrap gap-2 mb-10 p-1.5 bg-gray-100 dark:bg-gray-800 rounded-2xl w-fit border border-gray-200 dark:border-gray-700">
                @foreach($tipeList as $tipe => $kavlings)
                @php
                    $tersediaTipe = $kavlings->where('status','Tersedia')->count();
                @endphp
                <button @click="activeTab = '{{ $tipe }}'"
                        :class="activeTab === '{{ $tipe }}'
                            ? 'bg-gray-900 dark:bg-white text-white dark:text-gray-900 shadow-md'
                            : 'text-gray-500 hover:text-gray-900 dark:hover:text-white'"
                        class="btn-press px-5 py-2.5 rounded-xl text-sm font-bold transition-all duration-300 flex items-center gap-2">
                    {{ $tipe }}
                    @if($tersediaTipe > 0)
                    <span class="text-[10px] px-1.5 py-0.5 rounded-full font-black
                        {{ 'bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300' }}"
                          :class="activeTab === '{{ $tipe }}' ? 'bg-white/20 text-white dark:bg-black/20 dark:text-white' : ''">
                        {{ $tersediaTipe }}
                    </span>
                    @endif
                </button>
                @endforeach
            </div>

            {{-- Konten per Tipe --}}
            @foreach($tipeList as $tipe => $kavlings)
            <div x-show="activeTab === '{{ $tipe }}'"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 style="{{ $loop->first ? '' : 'display:none' }}">

                {{-- Info tipe --}}
                @php
                    $contohKavling = $kavlings->first();
                    $hargaMinTipe  = $kavlings->min('harga');
                    $hargaMaxTipe  = $kavlings->max('harga');
                    $ukuranList    = $kavlings->pluck('ukuran')->unique();
                    $kapList       = $kavlings->pluck('kapasitas')->unique()->sort();
                    $tersediaTipe  = $kavlings->where('status','Tersedia')->count();
                @endphp

                <div class="bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl p-6 mb-8 flex flex-col md:flex-row gap-6 items-start">
                    <div class="flex-grow">
                        <h3 class="font-display text-xl font-bold text-gray-900 dark:text-white mb-2">
                            Tipe {{ $tipe }}
                        </h3>
                        <div class="flex flex-wrap gap-4 text-sm text-gray-600 dark:text-gray-400">
                            <span class="flex items-center gap-1.5">
                                <span class="material-icons text-primary text-base">square_foot</span>
                                Ukuran: {{ $ukuranList->implode(' / ') }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="material-icons text-primary text-base">people</span>
                                Kapasitas: {{ $kapList->implode(' / ') }} orang
                            </span>
                            <span class="flex items-center gap-1.5">
                                <span class="material-icons text-primary text-base">check_circle</span>
                                {{ $tersediaTipe }} kavling tersedia
                            </span>
                        </div>
                    </div>
                    <div class="shrink-0 text-right">
                        <p class="text-xs text-gray-400 mb-1">Harga</p>
                        @if($hargaMinTipe == $hargaMaxTipe)
                        <p class="text-2xl font-bold text-gray-900 dark:text-white">Rp {{ number_format($hargaMinTipe,0,',','.') }}</p>
                        @else
                        <p class="text-lg font-bold text-gray-900 dark:text-white">
                            Rp {{ number_format($hargaMinTipe,0,',','.') }}<br>
                            <span class="text-sm font-normal text-gray-400">s/d Rp {{ number_format($hargaMaxTipe,0,',','.') }}</span>
                        </p>
                        @endif
                    </div>
                </div>

                {{-- Daftar Kavling dalam tipe ini --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                    @foreach($kavlings as $j => $kavling)
                    <div data-aos="fade-up" data-aos-delay="{{ ($j % 4) * 60 }}"
                         class="group bg-white dark:bg-gray-900 border rounded-2xl overflow-hidden transition-all duration-300 flex flex-col
                             {{ $kavling->status === 'Tersedia'
                                 ? 'border-gray-100 dark:border-gray-800 hover:shadow-xl hover:-translate-y-1 cursor-pointer'
                                 : 'border-gray-100 dark:border-gray-800 opacity-60' }}">

                        {{-- Status Bar --}}
                        <div class="h-1.5 w-full
                            {{ $kavling->status === 'Tersedia' ? 'bg-primary' : ($kavling->status === 'Dipesan' ? 'bg-yellow-400' : 'bg-gray-300') }}">
                        </div>

                        <div class="p-5 flex flex-col flex-grow">
                            {{-- Header --}}
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-xs font-black text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-800 px-2.5 py-1 rounded-lg">
                                    #{{ $kavling->nomor_kavling }}
                                </span>
                                @if($kavling->status === 'Tersedia')
                                    <span class="px-2 py-1 bg-primary/10 text-primary rounded-full text-[10px] font-bold">Tersedia</span>
                                @elseif($kavling->status === 'Dipesan')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-[10px] font-bold">Dipesan</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-500 rounded-full text-[10px] font-bold">Terjual</span>
                                @endif
                            </div>

                            {{-- Denah Visual Kavling --}}
                            @php
                                // Parse ukuran "4m x 3m" → width dan height
                                preg_match('/(\d+(?:\.\d+)?)\s*[mx×x]\s*(\d+(?:\.\d+)?)/i', $kavling->ukuran, $dim);
                                $w = isset($dim[1]) ? (float)$dim[1] : 4;
                                $h = isset($dim[2]) ? (float)$dim[2] : 3;
                                $svgW = 160; $svgH = 90;
                                $pad  = 14;
                                $maxW = $svgW - $pad * 2;
                                $maxH = $svgH - $pad * 2;
                                $ratio = min($maxW / max($w,0.1), $maxH / max($h,0.1));
                                $rw = round($w * $ratio);
                                $rh = round($h * $ratio);
                                $rx = round(($svgW - $rw) / 2);
                                $ry = round(($svgH - $rh) / 2);
                            @endphp
                            <div class="w-full bg-gray-50 dark:bg-gray-800 rounded-xl flex items-center justify-center mb-4" style="height:100px">
                                <svg width="{{ $svgW }}" height="{{ $svgH }}"
                                     viewBox="0 0 {{ $svgW }} {{ $svgH }}"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <rect width="{{ $svgW }}" height="{{ $svgH }}"
                                          fill="{{ $kavling->status==='Tersedia' ? '#f8fafc' : '#f3f4f6' }}" rx="6"/>
                                    <rect x="{{ $rx }}" y="{{ $ry }}"
                                          width="{{ $rw }}" height="{{ $rh }}"
                                          fill="{{ $kavling->status==='Tersedia' ? '#e2e8f0' : '#e5e7eb' }}"
                                          stroke="{{ $kavling->status==='Tersedia' ? '#94a3b8' : '#9ca3af' }}"
                                          stroke-width="1.5" stroke-dasharray="4 2" rx="3"/>
                                    {{-- Label ukuran --}}
                                    <text x="{{ $rx + $rw/2 }}" y="{{ $ry + $rh/2 + 4 }}"
                                          text-anchor="middle"
                                          font-size="10" font-weight="700"
                                          fill="{{ $kavling->status==='Tersedia' ? '#475569' : '#9ca3af' }}"
                                          font-family="sans-serif">{{ $kavling->ukuran }}</text>
                                </svg>
                            </div>

                            {{-- Info --}}
                            <div class="space-y-1.5 mb-4 flex-grow">
                                <div class="flex justify-between text-xs">
                                    <span class="text-gray-400">Kapasitas</span>
                                    <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $kavling->kapasitas }} orang</span>
                                </div>
                                <div class="flex justify-between text-xs pt-1.5 border-t border-gray-100 dark:border-gray-700">
                                    <span class="text-gray-400">Harga</span>
                                    <span class="font-bold text-gray-900 dark:text-white">Rp {{ number_format($kavling->harga,0,',','.') }}</span>
                                </div>
                            </div>

                            {{-- CTA --}}
                            @if($kavling->status === 'Tersedia')
                                @auth
                                <a href="{{ route('pembeli.reservasi.index', ['kavling_id' => $kavling->id]) }}"
                                   class="btn-press btn-ripple w-full py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-xl text-xs font-bold hover:bg-gray-800 transition-colors text-center flex items-center justify-center gap-1.5">
                                    <span class="material-icons text-sm">bookmark_add</span>
                                    Pesan Kavling Ini
                                </a>
                                @else
                                <a href="{{ route('login') }}"
                                   class="btn-press w-full py-2.5 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-xl text-xs font-bold hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors text-center">
                                    Login untuk Pesan
                                </a>
                                @endauth
                            @else
                            <div class="w-full py-2.5 bg-gray-100 dark:bg-gray-800 text-gray-400 rounded-xl text-xs font-bold text-center">
                                Tidak Tersedia
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Jika tidak ada kavling sama sekali di tipe ini --}}
                @if($kavlings->isEmpty())
                <div class="text-center py-12 text-gray-400">
                    <span class="material-icons text-4xl text-gray-200 block mb-2">crop_square</span>
                    <p class="font-medium">Belum ada kavling untuk tipe ini.</p>
                </div>
                @endif

            </div>
            @endforeach

        </div>
    </div>

    @else
    {{-- Cluster ada tapi belum ada kavling --}}
    <div class="px-8 xl:px-24 pb-16">
        <div class="max-w-7xl mx-auto text-center py-20 bg-gray-50 dark:bg-gray-900 rounded-3xl border border-gray-100 dark:border-gray-800">
            <span class="material-icons text-5xl text-gray-200 mb-4 block">inventory_2</span>
            <h3 class="text-xl font-bold text-gray-500 mb-2">Belum Ada Kavling</h3>
            <p class="text-sm text-gray-400 mb-6">Admin belum menambahkan kavling untuk cluster ini.</p>
            <a href="{{ route('cluster.index') }}"
               class="inline-flex items-center gap-2 px-6 py-3 bg-gray-900 text-white rounded-xl text-sm font-bold hover:bg-gray-800 transition-colors">
                ← Kembali ke Daftar Cluster
            </a>
        </div>
    </div>
    @endif

    {{-- CTA Login --}}
    @guest
    <div class="px-8 xl:px-24 pb-16">
        <div class="max-w-7xl mx-auto bg-gradient-to-r from-primary/10 to-primary/5 border border-primary/20 rounded-3xl p-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h3 class="font-display text-2xl font-bold mb-2">Siap memesan kavling?</h3>
                <p class="text-sm text-gray-500">Masuk atau daftar untuk melanjutkan proses reservasi.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('login') }}" class="btn-press px-6 py-3 border border-gray-300 rounded-full text-sm font-semibold hover:bg-gray-50 transition-colors">Masuk</a>
                <a href="{{ route('register') }}" class="btn-press btn-ripple px-6 py-3 bg-primary text-white rounded-full text-sm font-semibold hover:bg-primary/90 transition-colors">Daftar Sekarang</a>
            </div>
        </div>
    </div>
    @endguest

</div>
@endsection