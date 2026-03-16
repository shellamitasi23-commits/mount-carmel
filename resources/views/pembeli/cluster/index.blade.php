@extends('layouts.master')
@section('title', 'Daftar Cluster - Mount Carmel')

@section('content')
<div class="pt-24 min-h-screen bg-white dark:bg-gray-950">

    {{-- Page Header --}}
    <div class="px-8 xl:px-24 py-16 border-b border-gray-100 dark:border-gray-800">
        <div class="max-w-7xl mx-auto">
            <span data-aos="fade-up" class="text-primary font-bold tracking-widest uppercase text-xs">Pilihan Kami</span>
            <h1 data-aos="fade-up" data-aos-delay="100" class="text-5xl md:text-6xl font-bold mt-2 leading-tight">Daftar Cluster</h1>
            <p data-aos="fade-up" data-aos-delay="200" class="text-gray-500 dark:text-gray-400 mt-4 max-w-xl text-base leading-relaxed">
                Temukan cluster yang sesuai untuk ketenangan keluarga Anda. Tersedia pilihan Muslim dan Non-Muslim dengan berbagai tipe kavling.
            </p>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="px-8 xl:px-24 py-6 bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800"
         x-data="{ filter: 'semua' }">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center gap-3">
            <span class="text-xs font-bold uppercase tracking-wider text-gray-400 mr-2">Filter:</span>

            <button @click="filter = 'semua'"
                    :class="filter === 'semua' ? 'bg-gray-900 dark:bg-white text-white dark:text-gray-900' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700'"
                    class="px-5 py-2 rounded-full text-sm font-semibold transition-all">
                Semua ({{ $clusters->count() }})
            </button>

            <button @click="filter = 'Muslim'"
                    :class="filter === 'Muslim' ? 'bg-gray-900 text-white' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700'"
                    class="px-5 py-2 rounded-full text-sm font-semibold transition-all">
                Cluster Muslim ({{ $clusters->where('kategori','Muslim')->count() }})
            </button>

            <button @click="filter = 'Non-Muslim'"
                    :class="filter === 'Non-Muslim' ? 'bg-gray-900 text-white' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700'"
                    class="px-5 py-2 rounded-full text-sm font-semibold transition-all">
                Cluster Non-Muslim ({{ $clusters->where('kategori','Non-Muslim')->count() }})
            </button>
        </div>
    </div>

    {{-- Cluster Grid --}}
    <div class="px-8 xl:px-24 py-16" x-data="{ filter: 'semua' }">
        <div class="max-w-7xl mx-auto">

            @if($clusters->isEmpty())
            <div class="text-center py-24">
                <span class="material-icons text-6xl text-gray-200 block mb-4">map</span>
                <h3 class="text-xl font-bold text-gray-400 mb-2">Belum ada cluster tersedia</h3>
                <p class="text-sm text-gray-400">Admin belum menambahkan data cluster.</p>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

                @foreach($clusters as $i => $cluster)
                @php
                    $totalKavling = $cluster->kavlings->count();
                    $tersedia     = $cluster->kavlings->where('status','Tersedia')->count();
                    $isMuslim     = $cluster->kategori === 'Muslim';
                    $tipeKavling  = $cluster->kavlings->pluck('tipe_kavling')->unique()->values();
                    $hargaMin     = $cluster->kavlings->min('harga');

                    $img = $isMuslim
                        ? 'https://lh3.googleusercontent.com/aida-public/AB6AXuA6rqI9PeXcrrGEttejmy2Cel3avh8VDbuuLZ9znSeQ0Gw8_f3nDIPA5daXuk1lNSAm-tWxpJ6GMjkfk9Tp4ugchXR-TAxa51kf5RD--deEWZYCqfHqwdgP2haxZx3xe7cTs56uTS0TFSEdFgax5uGIbYCrGwAW6cxENUzjoD6JXr0AiwuyMq0RGnXuNAwZgLJIJ_7ohB4P4zHoRvO2BfqUnDNpU9LpoqSZub_tqXvtwDa3MXakwPvYeN3NT97N3pe77_3ygdwuIsc'
                        : 'https://lh3.googleusercontent.com/aida-public/AB6AXuCSeV8r5vTKVZson8x8U7XKosDU4OBIVwZCPNZOGiv7g8lL5mQYOegvqR47c2dPLgGFWhnrnslq9ErpprziLGhdeyqqystblfmKjcXSYUs3Ex5arOXBjjL80xf80mRmXZS6gCg9ShL7wBZ09_YS6GYhWfYN8ngIMMJKxo-PMrFVAhpyGaPNnDwhj0B12HdNVsq6MbUvK0TVpR3IYfH2whIB76pNLxyD6Zc2Asd_nuvAYJufsHTjqWMGi_EKBGJGKb7I688tdFK_1Qw';
                @endphp

                <div data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 100 }}"
                     x-show="filter === 'semua' || filter === '{{ $cluster->kategori }}'"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="group bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl overflow-hidden hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 flex flex-col">

                    {{-- Image --}}
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ $img }}" alt="{{ $cluster->nama_cluster }}"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
                        <div class="absolute inset-0 bg-gradient-to-t from-black/30 to-transparent"></div>

                        <span class="absolute top-4 left-4 inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold bg-white/90 text-gray-900">
                            <span class="material-icons text-xs">{{ $isMuslim ? 'mosque' : 'church' }}</span>
                            {{ $cluster->kategori }}
                        </span>

                        <span class="absolute top-4 right-4 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold
                            {{ $tersedia > 0 ? 'bg-white/90 text-gray-900' : 'bg-black/60 text-white' }}">
                            {{ $tersedia > 0 ? $tersedia.' tersedia' : 'Penuh' }}
                        </span>

                        <div class="absolute bottom-4 left-5 right-5">
                            <h3 class="text-xl font-bold text-white drop-shadow-md">{{ $cluster->nama_cluster }}</h3>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-6 flex flex-col flex-grow">
                        <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed mb-5 flex-grow min-h-[48px]">
                            {{ $cluster->deskripsi ?? 'Kawasan pemakaman eksklusif dengan lingkungan asri dan fasilitas lengkap.' }}
                        </p>

                        {{-- Tipe Kavling --}}
                        @if($tipeKavling->isNotEmpty())
                        <div class="mb-5">
                            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Tipe Kavling</p>
                            <div class="flex flex-wrap gap-1.5">
                                @foreach($tipeKavling->take(4) as $tipe)
                                <span class="px-2.5 py-1 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-300 rounded-lg text-[11px] font-semibold">
                                    {{ $tipe }}
                                </span>
                                @endforeach
                                @if($tipeKavling->count() > 4)
                                <span class="px-2.5 py-1 bg-gray-100 text-gray-400 rounded-lg text-[11px] font-semibold">
                                    +{{ $tipeKavling->count() - 4 }} lainnya
                                </span>
                                @endif
                            </div>
                        </div>
                        @endif

                        {{-- Stats --}}
                        <div class="flex items-center gap-4 py-4 border-t border-gray-100 dark:border-gray-800 mb-5">
                            <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                <span class="material-icons text-primary text-base">grid_view</span>
                                {{ $totalKavling }} Total
                            </div>
                            <div class="flex items-center gap-1.5 text-xs text-gray-500">
                                <span class="material-icons text-primary text-base">check_circle</span>
                                {{ $tersedia }} Tersedia
                            </div>
                            @if($hargaMin)
                            <div class="text-xs text-gray-500 ml-auto">
                                <span class="font-bold text-gray-700 dark:text-gray-300">
                                    Mulai Rp {{ number_format($hargaMin/1000000, 0, ',', '.') }}jt
                                </span>
                            </div>
                            @endif
                        </div>

                        {{-- CTA — ARAHKAN KE kavling/index dengan cluster_id --}}
                        @auth
                        <a href="{{ route('pembeli.kavling.index', ['cluster_id' => $cluster->id]) }}"
                           class="btn-press btn-ripple flex items-center justify-between px-5 py-3 rounded-xl
                               bg-gray-900 dark:bg-white text-white dark:text-gray-900 hover:bg-gray-800
                               transition-colors font-semibold text-sm">
                            Pilih Tipe Kavling
                            <span class="material-icons text-base">arrow_forward</span>
                        </a>
                        @else
                        <a href="{{ route('login') }}"
                           class="btn-press flex items-center justify-between px-5 py-3 rounded-xl
                               border border-gray-300 text-gray-700 hover:bg-gray-50
                               transition-colors font-semibold text-sm">
                            Login untuk Pesan
                            <span class="material-icons text-base">arrow_forward</span>
                        </a>
                        @endauth
                    </div>
                </div>
                @endforeach

            </div>
            @endif

        </div>
    </div>

    {{-- CTA Login --}}
    @guest
    <div class="px-8 xl:px-24 pb-20">
        <div class="max-w-7xl mx-auto bg-gradient-to-r from-primary/10 to-primary/5 dark:from-primary/20 dark:to-primary/10 border border-primary/20 rounded-3xl p-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h3 class="text-2xl font-bold mb-2">Ingin memesan kavling?</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Masuk atau daftar terlebih dahulu untuk melanjutkan proses pemesanan.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('login') }}" class="btn-press px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-full text-sm font-semibold hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">Masuk</a>
                <a href="{{ route('register') }}" class="btn-press btn-ripple px-6 py-3 bg-primary text-white rounded-full text-sm font-semibold hover:bg-primary/90 transition-colors">Daftar Sekarang</a>
            </div>
        </div>
    </div>
    @endguest

</div>
@endsection