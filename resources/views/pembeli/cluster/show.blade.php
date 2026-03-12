@extends('layouts.master')
@section('title', 'Detail Cluster - Mount Carmel')

@section('content')
<div class="pt-24 min-h-screen bg-white dark:bg-gray-950">

    <!-- Breadcrumb -->
    <div class="px-8 xl:px-24 pt-8 pb-0">
        <div class="max-w-7xl mx-auto flex items-center gap-2 text-sm text-gray-400">
            <a href="/" class="hover:text-gray-600 transition-colors">Beranda</a>
            <span class="material-icons text-xs">chevron_right</span>
            <a href="/cluster" class="hover:text-gray-600 transition-colors">Cluster</a>
            <span class="material-icons text-xs">chevron_right</span>
            <span class="text-gray-900 dark:text-white font-medium">Cluster Madinah</span>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="px-8 xl:px-24 pt-8 pb-0">
        <div class="max-w-7xl mx-auto">
            <div class="relative w-full h-[500px] rounded-3xl overflow-hidden" data-aos="zoom-in">
                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuA6rqI9PeXcrrGEttejmy2Cel3avh8VDbuuLZ9znSeQ0Gw8_f3nDIPA5daXuk1lNSAm-tWxpJ6GMjkfk9Tp4ugchXR-TAxa51kf5RD--deEWZYCqfHqwdgP2haxZx3xe7cTs56uTS0TFSEdFgax5uGIbYCrGwAW6cxENUzjoD6JXr0AiwuyMq0RGnXuNAwZgLJIJ_7ohB4P4zHoRvO2BfqUnDNpU9LpoqSZub_tqXvtwDa3MXakwPvYeN3NT97N3pe77_3ygdwuIsc"
                     alt="Cluster Madinah" class="w-full h-full object-cover" />
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
                <div class="absolute bottom-8 left-8 text-white">
                    <span class="inline-flex items-center gap-1 bg-emerald-500 text-white px-3 py-1 rounded-full text-xs font-bold mb-3">
                        <span class="material-icons text-xs">mosque</span> Muslim
                    </span>
                    <h1 class="font-display text-4xl md:text-5xl font-bold">Cluster Madinah</h1>
                    <p class="text-white/80 text-sm mt-2">Kawasan pemakaman Muslim eksklusif · 2.5 Ha</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Stats Bar -->
    <div class="px-8 xl:px-24 py-8">
        <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach([
                ['icon' => 'grid_view', 'label' => 'Total Kavling', 'value' => '120 Unit'],
                ['icon' => 'check_circle', 'label' => 'Tersedia', 'value' => '24 Unit'],
                ['icon' => 'square_foot', 'label' => 'Luas Area', 'value' => '2.5 Ha'],
                ['icon' => 'location_on', 'label' => 'Lokasi', 'value' => 'Zona A'],
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

    <!-- Deskripsi & Fasilitas -->
    <div class="px-8 xl:px-24 pb-12">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row gap-12">
            <div data-aos="fade-right" class="md:w-1/2">
                <h2 class="font-display text-3xl font-bold mb-4">Tentang Cluster Ini</h2>
                <p class="text-gray-500 dark:text-gray-400 leading-relaxed mb-4">
                    Cluster Madinah dirancang sepenuhnya sesuai syariat Islam, dengan orientasi setiap makam menghadap kiblat. Lingkungan yang tenang, asri, dan terjaga kebersihanya menjadikan tempat ini pilihan utama bagi keluarga Muslim.
                </p>
                <p class="text-gray-500 dark:text-gray-400 leading-relaxed">
                    Area ini memiliki jalur pedestrian yang lebar, area wudu, mushola mini, serta sistem drainase yang baik sehingga kondisi kavling selalu terjaga sepanjang tahun.
                </p>
            </div>
            <div data-aos="fade-left" class="md:w-1/2">
                <h2 class="font-display text-3xl font-bold mb-4">Fasilitas</h2>
                <div class="grid grid-cols-2 gap-3">
                    @foreach(['Orientasi Kiblat', 'Mushola Internal', 'Area Parkir Luas', 'CCTV 24 Jam', 'Petugas Kebersihan', 'Jalur Pejalan Kaki', 'Area Wudu', 'Sistem Drainase'] as $fasilitas)
                    <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                        <span class="material-icons text-emerald-500 text-base">check_circle</span>
                        {{ $fasilitas }}
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <hr class="border-gray-100 dark:border-gray-800 max-w-7xl mx-auto" />

    <!-- Tipe Kavling - Tab Muslim/Non-Muslim -->
    <div class="px-8 xl:px-24 py-16" x-data="{ activeTab: 'muslim' }">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-12">
                <span data-aos="fade-up" class="text-primary font-bold tracking-widest uppercase text-xs">Pilih Tipe</span>
                <h2 data-aos="fade-up" data-aos-delay="100" class="font-display text-4xl font-bold mt-2">Tipe Kavling Tersedia</h2>
                <p data-aos="fade-up" data-aos-delay="200" class="text-gray-500 mt-3 max-w-lg mx-auto text-sm">Pilih tipe kavling yang sesuai kebutuhan dan anggaran keluarga Anda.</p>
            </div>

            <!-- Tab Toggle -->
            <div data-aos="fade-up" class="flex justify-center mb-10">
                <div class="bg-gray-100 dark:bg-gray-800 p-1 rounded-full inline-flex border border-gray-200 dark:border-gray-700 shadow-sm">
                    <button @click="activeTab = 'muslim'"
                            :class="activeTab === 'muslim' ? 'bg-emerald-600 text-white shadow-md' : 'text-gray-500 hover:text-gray-900 dark:hover:text-white'"
                            class="btn-press px-8 py-3 rounded-full text-sm font-bold transition-all duration-300">
                        Tipe Cluster Muslim
                    </button>
                    <button @click="activeTab = 'non_muslim'"
                            :class="activeTab === 'non_muslim' ? 'bg-gray-900 text-white shadow-md' : 'text-gray-500 hover:text-gray-900 dark:hover:text-white'"
                            class="btn-press px-8 py-3 rounded-full text-sm font-bold transition-all duration-300">
                        Tipe Non-Muslim
                    </button>
                </div>
            </div>

            <!-- Muslim Types -->
            <div x-show="activeTab === 'muslim'"
                 x-transition:enter="transition ease-out duration-400"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0">
                @php
                $muslimTypes = [
                    ['name' => 'Tipe Barokah', 'size' => '1.5m × 2.5m', 'max' => 1, 'price' => 'Rp 15.000.000', 'tersedia' => 8],
                    ['name' => 'Tipe Fitrah', 'size' => '4m × 3m', 'max' => 2, 'price' => 'Rp 35.000.000', 'tersedia' => 6],
                    ['name' => 'Tipe Sakinah', 'size' => '7m × 8m', 'max' => 6, 'price' => 'Rp 120.000.000', 'tersedia' => 7],
                    ['name' => 'Tipe Khalifah', 'size' => '7m × 15m', 'max' => 12, 'price' => 'Rp 250.000.000', 'tersedia' => 3],
                ];
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($muslimTypes as $item)
                    <div class="group bg-white dark:bg-gray-900 border border-emerald-100 dark:border-gray-700 rounded-2xl p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 flex flex-col relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                            <span class="material-icons text-7xl text-emerald-600">mosque</span>
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-display text-xl font-bold text-gray-900 dark:text-white">{{ $item['name'] }}</h3>
                            <span class="text-xs font-bold px-2 py-1 rounded-full {{ $item['tersedia'] > 5 ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                {{ $item['tersedia'] }} tersisa
                            </span>
                        </div>

                        <!-- Denah Visual -->
                        <div class="w-full h-28 bg-emerald-50 dark:bg-emerald-900/20 border-2 border-dashed border-emerald-200 dark:border-emerald-700 rounded-xl flex flex-col items-center justify-center mb-4">
                            <span class="text-[9px] uppercase font-bold text-emerald-400 mb-1">Denah Kavling</span>
                            <span class="text-base font-bold text-emerald-700 dark:text-emerald-300">{{ $item['size'] }}</span>
                        </div>

                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-400">Kapasitas</span>
                                <span class="font-semibold flex items-center gap-1">
                                    <span class="material-icons text-sm text-emerald-600">person</span> {{ $item['max'] }} orang
                                </span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-400">Harga mulai</span>
                                <span class="font-bold text-emerald-700">{{ $item['price'] }}</span>
                            </div>
                        </div>

                        @auth
                            <a href="/kavling?cluster=1&tipe={{ $loop->index+1 }}"
                               class="btn-press btn-ripple mt-auto w-full py-2.5 bg-emerald-600 text-white rounded-xl text-sm font-bold hover:bg-emerald-700 transition-colors text-center block">
                               Pilih Tipe Ini
                            </a>
                        @else
                            <a href="/login"
                               class="btn-press mt-auto w-full py-2.5 border-2 border-emerald-600 text-emerald-600 rounded-xl text-sm font-bold hover:bg-emerald-50 transition-colors text-center block">
                               Login untuk Pilih
                            </a>
                        @endauth
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Non-Muslim Types -->
            <div x-show="activeTab === 'non_muslim'" style="display:none"
                 x-transition:enter="transition ease-out duration-400"
                 x-transition:enter-start="opacity-0 translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0">
                @php
                $nonMuslimTypes = [
                    ['name' => 'Single', 'size' => '1.5m × 4m', 'max' => 1, 'price' => 'Rp 20.000.000', 'tersedia' => 10],
                    ['name' => 'Double', 'size' => '3m × 4m', 'max' => 2, 'price' => 'Rp 38.000.000', 'tersedia' => 8],
                    ['name' => 'Double Deluxe', 'size' => '4m × 4.5m', 'max' => 2, 'price' => 'Rp 55.000.000', 'tersedia' => 4],
                    ['name' => 'Double Special', 'size' => '8m × 4.5m', 'max' => 4, 'price' => 'Rp 90.000.000', 'tersedia' => 6],
                    ['name' => 'Family', 'size' => '8m × 5m', 'max' => 4, 'price' => 'Rp 110.000.000', 'tersedia' => 5],
                    ['name' => 'Super Family', 'size' => '8m × 10m', 'max' => 6, 'price' => 'Rp 200.000.000', 'tersedia' => 3],
                    ['name' => 'Royal Family', 'size' => '16m × 20m', 'max' => 10, 'price' => 'Rp 450.000.000', 'tersedia' => 2],
                    ['name' => 'VIP', 'size' => '26m × 36m', 'max' => 18, 'price' => 'Rp 950.000.000', 'tersedia' => 1],
                ];
                @endphp
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($nonMuslimTypes as $item)
                    <div class="group bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 flex flex-col relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                            <span class="material-icons text-7xl text-gray-600">church</span>
                        </div>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="font-display text-lg font-bold text-gray-900 dark:text-white truncate">{{ $item['name'] }}</h3>
                            <span class="text-xs font-bold px-2 py-1 rounded-full ml-2 shrink-0 {{ $item['tersedia'] > 4 ? 'bg-blue-100 text-blue-700' : ($item['tersedia'] > 1 ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700') }}">
                                {{ $item['tersedia'] }} tersisa
                            </span>
                        </div>
                        <div class="w-full h-24 bg-gray-50 dark:bg-gray-800 border-2 border-dashed border-gray-200 dark:border-gray-600 rounded-xl flex items-center justify-center mb-4">
                            <span class="text-sm font-bold text-gray-600 dark:text-gray-300">{{ $item['size'] }}</span>
                        </div>
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-400">Kapasitas</span>
                                <span class="font-semibold flex items-center gap-1">
                                    <span class="material-icons text-sm">groups</span> {{ $item['max'] }} orang
                                </span>
                            </div>
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-gray-400">Harga mulai</span>
                                <span class="font-bold text-gray-900 dark:text-white">{{ $item['price'] }}</span>
                            </div>
                        </div>
                        @auth
                            <a href="/kavling?cluster=1&tipe={{ $loop->index+1 }}"
                               class="btn-press btn-ripple mt-auto w-full py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 rounded-xl text-sm font-bold hover:bg-gray-700 transition-colors text-center block">
                               Pilih Tipe Ini
                            </a>
                        @else
                            <a href="/login"
                               class="btn-press mt-auto w-full py-2.5 border-2 border-gray-900 dark:border-white text-gray-900 dark:text-white rounded-xl text-sm font-bold hover:bg-gray-50 transition-colors text-center block">
                               Login untuk Pilih
                            </a>
                        @endauth
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection