@extends('layouts.master')
@section('title', 'Daftar Cluster - Mount Carmel')

@section('content')
<div class="pt-24 min-h-screen bg-white dark:bg-gray-950">

    <!-- Page Header -->
    <div class="px-8 xl:px-24 py-16 border-b border-gray-100 dark:border-gray-800">
        <div class="max-w-7xl mx-auto">
            <span data-aos="fade-up" class="text-primary font-bold tracking-widest uppercase text-xs">Pilihan Kami</span>
            <h1 data-aos="fade-up" data-aos-delay="100" class="font-display text-5xl md:text-6xl font-bold mt-2 leading-tight">Daftar Cluster</h1>
            <p data-aos="fade-up" data-aos-delay="200" class="text-gray-500 dark:text-gray-400 mt-4 max-w-xl text-base leading-relaxed">
                Temukan cluster yang sesuai untuk ketenangan keluarga Anda. Tersedia pilihan Muslim dan Non-Muslim dengan berbagai tipe kavling.
            </p>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="px-8 xl:px-24 py-6 bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800" x-data="{ filter: 'semua' }">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center gap-3">
            <span class="text-xs font-bold uppercase tracking-wider text-gray-400 mr-2">Filter:</span>
            <button @click="filter = 'semua'" :class="filter === 'semua' ? 'bg-gray-900 dark:bg-white text-white dark:text-gray-900' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700'" class="px-5 py-2 rounded-full text-sm font-semibold transition-all">Semua</button>
            <button @click="filter = 'muslim'" :class="filter === 'muslim' ? 'bg-emerald-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700'" class="px-5 py-2 rounded-full text-sm font-semibold transition-all">Cluster Muslim</button>
            <button @click="filter = 'non_muslim'" :class="filter === 'non_muslim' ? 'bg-gray-700 text-white' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700'" class="px-5 py-2 rounded-full text-sm font-semibold transition-all">Cluster Non-Muslim</button>
        </div>
    </div>

    <!-- Cluster Grid -->
    <div class="px-8 xl:px-24 py-16">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @php
            $clusters = [
                [
                    'id' => 1,
                    'nama' => 'Cluster Madinah',
                    'tipe' => 'muslim',
                    'label' => 'Muslim',
                    'deskripsi' => 'Didesain sesuai syariat Islam dengan orientasi kiblat dan lingkungan yang tenang dan bersih.',
                    'kavling_tersedia' => 24,
                    'luas' => '2.5 Ha',
                    'badge_color' => 'emerald',
                    'icon' => 'mosque',
                    'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuA6rqI9PeXcrrGEttejmy2Cel3avh8VDbuuLZ9znSeQ0Gw8_f3nDIPA5daXuk1lNSAm-tWxpJ6GMjkfk9Tp4ugchXR-TAxa51kf5RD--deEWZYCqfHqwdgP2haxZx3xe7cTs56uTS0TFSEdFgax5uGIbYCrGwAW6cxENUzjoD6JXr0AiwuyMq0RGnXuNAwZgLJIJ_7ohB4P4zHoRvO2BfqUnDNpU9LpoqSZub_tqXvtwDa3MXakwPvYeN3NT97N3pe77_3ygdwuIsc',
                ],
                [
                    'id' => 2,
                    'nama' => 'Cluster Carmel Hijau',
                    'tipe' => 'non_muslim',
                    'label' => 'Non-Muslim',
                    'deskripsi' => 'Area eksklusif dikelilingi pepohonan hijau dengan jalur pejalan kaki yang asri dan tenang.',
                    'kavling_tersedia' => 36,
                    'luas' => '3.8 Ha',
                    'badge_color' => 'gray',
                    'icon' => 'church',
                    'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCSeV8r5vTKVZson8x8U7XKosDU4OBIVwZCPNZOGiv7g8lL5mQYOegvqR47c2dPLgGFWhnrnslq9ErpprziLGhdeyqqystblfmKjcXSYUs3Ex5arOXBjjL80xf80mRmXZS6gCg9ShL7wBZ09_YS6GYhWfYN8ngIMMJKxo-PMrFVAhpyGaPNnDwhj0B12HdNVsq6MbUvK0TVpR3IYfH2whIB76pNLxyD6Zc2Asd_nuvAYJufsHTjqWMGi_EKBGJGKb7I688tdFK_1Qw',
                ],
                [
                    'id' => 3,
                    'nama' => 'Cluster Sakura',
                    'tipe' => 'non_muslim',
                    'label' => 'Non-Muslim',
                    'deskripsi' => 'Suasana damai dengan desain modern minimalis yang menonjolkan keindahan alam sekitar.',
                    'kavling_tersedia' => 18,
                    'luas' => '1.9 Ha',
                    'badge_color' => 'gray',
                    'icon' => 'local_florist',
                    'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuC84fEtfZb8hWa8DG2uJJfLUZGCaLm5oOnQI0MHj2S6K5kwbfoCHJseJ0nNLKVR_yh8U1W9MSn7c9b1uZeAWC3mjLXJHYtd4R7_oQcvB0nZeBHp2-33dtHJPAdie6SAHmyx2wWFg6PDA7K7Cio3YuEF2GfixpWADifW8iIZGvnYnuDU0DHY_nNJVwJZPUEJjX_OAFnbE7VCZuUlC-ufcD-_1rp5Olu60H67Ih9XH2AZSPPvqiVWhtGOGGCjSDWO_tBe89VFeTumpjk',
                ],
                [
                    'id' => 4,
                    'nama' => 'Cluster Al-Barokah',
                    'tipe' => 'muslim',
                    'label' => 'Muslim',
                    'deskripsi' => 'Hadir dengan fasilitas mushola dan area peribadatan yang terintegasi di dalam kawasan.',
                    'kavling_tersedia' => 12,
                    'luas' => '1.2 Ha',
                    'badge_color' => 'emerald',
                    'icon' => 'mosque',
                    'img' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCKKlS1j_Zt3H2_tLdwUcZy3qankghtW1i1Z_CwZctvMaNAB6rj9WvYrHL3jwoPljnQjbwgX-wOB61mlkFoHUxqt_S0zV7NoHPF5t1gTcZ2wb4P0HKv7ripuN0rO5W71tkzxVnzxIqaQ7Dc8p0S0QKYT3crM1aj8H3wq0lQGPx-n4dJSc0DoENon9u9Nc60JG6ou2rOUQ8pD9s7UXqTxyMGomfOJ1FK5F3h_NAMcq3XGhEcG-GAfKcf3n8lzikz-kwhBLb0QNuLmLc',
                ],
            ];
            @endphp

            @foreach($clusters as $i => $cluster)
            <div data-aos="fade-up" data-aos-delay="{{ $i * 100 }}"
                 class="group bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl overflow-hidden hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 flex flex-col">

                <!-- Image -->
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ $cluster['img'] }}" alt="{{ $cluster['nama'] }}"
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" />
                    <!-- Badge -->
                    <span class="absolute top-4 left-4 inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold
                        {{ $cluster['badge_color'] === 'emerald' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-700' }}">
                        <span class="material-icons text-xs">{{ $cluster['icon'] }}</span>
                        {{ $cluster['label'] }}
                    </span>
                    <!-- Kavling tersedia badge -->
                    <span class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-gray-900">
                        {{ $cluster['kavling_tersedia'] }} tersedia
                    </span>
                </div>

                <!-- Content -->
                <div class="p-6 flex flex-col flex-grow">
                    <div class="flex items-start justify-between mb-3">
                        <h3 class="font-display text-xl font-bold text-gray-900 dark:text-white">{{ $cluster['nama'] }}</h3>
                        <span class="text-xs text-gray-400 bg-gray-50 dark:bg-gray-800 px-2 py-1 rounded-lg">{{ $cluster['luas'] }}</span>
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed mb-6 flex-grow">{{ $cluster['deskripsi'] }}</p>

                    <!-- Stats -->
                    <div class="flex items-center gap-4 mb-5 py-4 border-t border-gray-100 dark:border-gray-800">
                        <div class="flex items-center gap-1.5 text-xs text-gray-500">
                            <span class="material-icons text-primary text-base">square_foot</span>
                            Luas {{ $cluster['luas'] }}
                        </div>
                        <div class="flex items-center gap-1.5 text-xs text-gray-500">
                            <span class="material-icons text-primary text-base">grid_view</span>
                            {{ $cluster['kavling_tersedia'] }} Kavling
                        </div>
                    </div>

                    <a href="/cluster/{{ $cluster['id'] }}"
                       class="btn-press btn-ripple flex items-center justify-between px-5 py-3 rounded-xl
                           {{ $cluster['badge_color'] === 'emerald' ? 'bg-emerald-600 text-white hover:bg-emerald-700' : 'bg-gray-900 dark:bg-white text-white dark:text-gray-900 hover:bg-gray-800' }}
                           transition-colors font-semibold text-sm">
                        Lihat Detail
                        <span class="material-icons text-base">arrow_forward</span>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- CTA Login jika belum login -->
    @guest
    <div class="px-8 xl:px-24 pb-20">
        <div class="max-w-7xl mx-auto bg-gradient-to-r from-primary/10 to-primary/5 dark:from-primary/20 dark:to-primary/10 border border-primary/20 rounded-3xl p-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h3 class="font-display text-2xl font-bold mb-2">Ingin memesan kavling?</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">Masuk atau daftar terlebih dahulu untuk melanjutkan proses pemesanan.</p>
            </div>
            <div class="flex gap-3">
                <a href="/login" class="btn-press px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-full text-sm font-semibold hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">Masuk</a>
                <a href="/register" class="btn-press btn-ripple px-6 py-3 bg-primary text-white rounded-full text-sm font-semibold hover:bg-primary/90 transition-colors">Daftar Sekarang</a>
            </div>
        </div>
    </div>
    @endguest
</div>
@endsection