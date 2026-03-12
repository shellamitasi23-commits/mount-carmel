@extends('layouts.master')

@section('title', 'Beranda - Mount Carmel Cluster')

@section('content')

<style>
    /* Animasi Tekan (Press) */
    .btn-press:active { transform: scale(0.95); }
    
    /* Animasi Riak Air (Ripple) */
    .btn-ripple { position: relative; overflow: hidden; transform: translate3d(0, 0, 0); }
    .btn-ripple:after {
        content: ""; display: block; position: absolute; width: 100%; height: 100%; top: 0; left: 0;
        pointer-events: none; background-image: radial-gradient(circle, #fff 10%, transparent 10.01%);
        background-repeat: no-repeat; background-position: 50%; transform: scale(10, 10); opacity: 0;
        transition: transform .5s, opacity 1s;
    }
    .btn-ripple:active:after { transform: scale(0, 0); opacity: 0.3; transition: 0s; }

    /* ── TAMBAHAN: Counter animasi ── */
    @keyframes countUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .stat-animate { animation: countUp 0.8s ease forwards; }

    /* ── TAMBAHAN: Marquee ── */
    @keyframes marquee {
        0%   { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .marquee-track { animation: marquee 24s linear infinite; }
    .marquee-track:hover { animation-play-state: paused; }

    /* ── TAMBAHAN: FAQ accordion ── */
    .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.4s ease, padding 0.3s ease; }
    .faq-item.open .faq-answer { max-height: 300px; }
    .faq-item.open .faq-icon { transform: rotate(45deg); }
    .faq-icon { transition: transform 0.3s ease; }

    /* ── TAMBAHAN: galeri hover ── */
    .gallery-item img { transition: transform 0.6s cubic-bezier(.25,.46,.45,.94); }
    .gallery-item:hover img { transform: scale(1.08); }
    .gallery-overlay { opacity: 0; transition: opacity 0.4s ease; }
    .gallery-item:hover .gallery-overlay { opacity: 1; }
</style>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

{{-- ═══════════════════════════════════════════════════════════════
     BAGIAN ASLI — TIDAK DIUBAH
     ═══════════════════════════════════════════════════════════════ --}}

<header class="relative overflow-hidden min-h-screen flex flex-col pt-40 px-8 xl:px-24">
    <div data-aos="fade-in" data-aos-duration="1500" class="absolute top-0 right-0 w-1/2 h-full bg-primary/20 rounded-bl-[200px] -z-10 dark:bg-primary/10"></div>
    <div data-aos="fade-in" data-aos-duration="2000" class="absolute -top-32 -left-32 w-96 h-96 bg-primary/30 rounded-full blur-3xl -z-10 dark:bg-primary/20"></div>
    
    <div class="flex-grow flex flex-col justify-center relative z-10 pb-20">
        <h1 data-aos="fade-up" data-aos-delay="0" class="text-6xl md:text-8xl font-bold max-w-4xl leading-tight tracking-tight mb-12">
            Mount Carmel Cluster Madinah
        </h1>

        <h4 data-aos="fade-up" data-aos-delay="100" class="text-xl md:text-2xl font-serif font-semibold italic text-gray-700 dark:text-gray-300 max-w-2xl mb-12">
            "Berikan yang terbaik untuk terakhir kalinya"
        </h4>
        
        <div data-aos="zoom-in" data-aos-delay="200" data-aos-duration="1000" class="relative w-full h-[500px] rounded-[2rem] overflow-hidden shadow-2xl group">
            <img alt="Pemandangan indah pemakaman" class="w-full h-full object-cover object-center transform transition-transform duration-700 group-hover:scale-105"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuC1NyIlZmBiYtT_kIu9sIln0H_-6RueC2Hhc_d6kZXH1IScjujHYPs6awIbu5dRMlY6nh3OHS1NSyx_fBcV7oOIg267GAnn0m7Dmy2SYQtQcbdLRfesZdEgbtNBETqCuWIVnqGkcdMwWMXj_pXaa-9yAZFgRqIMFAYsbtXSydiAp8yeFKTcA-sa0Emlh4YOvMdCaPtYTaF9zS1c7aKDxKlmU_zIPST46YbjjlfflaEwp9vViTnYZ990e-nAoVM2fkKAhJwzbhau-yI" />
            
            <div data-aos="fade-right" data-aos-delay="500" class="absolute bottom-8 left-8 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md p-6 rounded-2xl shadow-lg max-w-sm transition-transform hover:-translate-y-2 hidden md:block cursor-pointer btn-press">
                <img alt="Pratinjau cluster" class="w-full h-40 object-cover rounded-xl mb-4" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCKKlS1j_Zt3H2_tLdwUcZy3qankghtW1i1Z_CwZctvMaNAB6rj9WvYrHL3jwoPljnQjbwgX-wOB61mlkFoHUxqt_S0zV7NoHPF5t1gTcZ2wb4P0HKv7ripuN0rO5W71tkzxVnzxIqaQ7Dc8p0S0QKYT3crM1aj8H3wq0lQGPx-n4dJSc0DoENon9u9Nc60JG6ou2rOUQ8pD9s7UXqTxyMGomfOJ1FK5F3h_NAMcq3XGhEcG-GAfKcf3n8lzikz-kwhBLb0QNuLmLc" />
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-gray-900 dark:text-white">Lihat Semua Cluster</span>
                    <span class="material-icons text-gray-500">arrow_forward</span>
                </div>
            </div>
            
            <div data-aos="fade-left" data-aos-delay="700" class="absolute bottom-32 right-8 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md p-6 rounded-2xl shadow-lg max-w-sm transition-transform hover:-translate-y-2 hidden md:block cursor-pointer btn-press">
                <img alt="Pratinjau layanan" class="w-full h-40 object-cover rounded-xl mb-4" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDOy1Fohlq_qivWE2tkM433deJqLAQ3UogU5-WSqG19mRZNu9OmlEuPQ1U06tbq0gdMbF0Ck-PAYzTBMlskj5DAkT-uNDwHpskU1Dl1eoUeygiIidyS5eeHLFpz0zt2d1TIfYlbxRLfJx1o_DXE7pH0PxPeyGigVt9a_ryqk2-e_iNR8oUYCQxyFMTCES7kBIrLIOpYtrlVK4vi9pO0ZbGqRBYIW7YG7GGQuf_tf8GP3pXp_wb8cb0_x4OhwB-nGxmxFINL8LCrYYQ" />
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-gray-900 dark:text-white">Layanan Kami</span>
                    <span class="material-icons text-gray-500">arrow_forward</span>
                </div>
            </div>
            
            <div data-aos="fade-up" data-aos-delay="900" class="absolute bottom-8 left-1/2 -translate-x-1/2 flex items-center gap-6 bg-white/50 dark:bg-gray-900/50 backdrop-blur-sm py-3 px-8 rounded-full">
                <span class="text-sm font-medium uppercase tracking-wider text-gray-800 dark:text-gray-200">Watch a video</span>
                <button class="btn-ripple btn-press w-16 h-16 bg-primary text-gray-900 rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition-transform">
                    <span class="material-icons text-3xl">play_arrow</span>
                </button>
                <span class="text-sm font-medium uppercase tracking-wider text-gray-800 dark:text-gray-200">Tentang Kami</span>
            </div>
        </div>
    </div>
</header>

{{-- ═══════════════════════════════════════════════════════════════
     ✦ TAMBAHAN 1: STATISTIK / ANGKA KEPERCAYAAN
     ═══════════════════════════════════════════════════════════════ --}}
<section class="py-16 px-8 xl:px-24 bg-gray-950 dark:bg-black overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-0 divide-x divide-gray-800">
            @php
            $stats = [
                ['value' => '2.500+', 'label' => 'Keluarga Dipercayakan', 'icon' => 'favorite'],
                ['value' => '15+',    'label' => 'Tahun Pengalaman',      'icon' => 'history_edu'],
                ['value' => '4',      'label' => 'Cluster Tersedia',      'icon' => 'park'],
                ['value' => '98%',    'label' => 'Kepuasan Keluarga',     'icon' => 'verified'],
            ];
            @endphp
            @foreach($stats as $i => $s)
            <div data-aos="fade-up" data-aos-delay="{{ $i * 100 }}"
                 class="flex flex-col items-center justify-center py-10 px-6 text-center group">
                <span class="material-icons text-primary mb-3 text-3xl opacity-60 group-hover:opacity-100 transition-opacity">{{ $s['icon'] }}</span>
                <span class="text-4xl md:text-5xl font-bold text-white tracking-tight font-serif mb-2">{{ $s['value'] }}</span>
                <span class="text-xs uppercase tracking-widest text-gray-500 font-medium">{{ $s['label'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     BAGIAN ASLI — TIDAK DIUBAH
     ═══════════════════════════════════════════════════════════════ --}}
<section class="py-24 px-8 xl:px-24 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row gap-16">
        <div class="md:w-1/2 flex flex-col justify-between">
            <div data-aos="fade-right">
                <h2 class="text-5xl font-bold mb-8 leading-tight">Keindahan Hening dan Ketentraman Mendalam</h2>
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-8">
                    Cluster dirancang menggunakan metode desain berdampak rendah yang memeluk kontur alami tanah.
                </p>
            </div>
            <div class="flex gap-6">
                <img data-aos="fade-up" data-aos-delay="100" alt="Jalur penuh ketenangan" class="w-1/2 h-64 object-cover rounded-2xl shadow-md" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCSeV8r5vTKVZson8x8U7XKosDU4OBIVwZCPNZOGiv7g8lL5mQYOegvqR47c2dPLgGFWhnrnslq9ErpprziLGhdeyqqystblfmKjcXSYUs3Ex5arOXBjjL80xf80mRmXZS6gCg9ShL7wBZ09_YS6GYhWfYN8ngIMMJKxo-PMrFVAhpyGaPNnDwhj0B12HdNVsq6MbUvK0TVpR3IYfH2whIB76pNLxyD6Zc2Asd_nuvAYJufsHTjqWMGi_EKBGJGKb7I688tdFK_1Qw" />
                <img data-aos="fade-up" data-aos-delay="200" alt="Alam tenang" class="w-1/2 h-64 object-cover rounded-2xl shadow-md" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC84fEtfZb8hWa8DG2uJJfLUZGCaLm5oOnQI0MHj2S6K5kwbfoCHJseJ0nNLKVR_yh8U1W9MSn7c9b1uZeAWC3mjLXJHYtd4R7_oQcvB0nZeBHp2-33dtHJPAdie6SAHmyx2wWFg6PDA7K7Cio3YuEF2GfixpWADifW8iIZGvnYnuDU0DHY_nNJVwJZPUEJjX_OAFnbE7VCZuUlC-ufcD-_1rp5Olu60H67Ih9XH2AZSPPvqiVWhtGOGGCjSDWO_tBe89VFeTumpjk" />
            </div>
        </div>
        <div class="md:w-1/2 flex flex-col items-end">
            <a data-aos="fade-left" class="btn-ripple btn-press px-8 py-4 bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900 font-semibold rounded-full hover:bg-gray-800 dark:hover:bg-white transition-colors mb-16 shadow-md inline-block" href="#">
                Pelajari Lebih Lanjut
            </a>
            <p data-aos="fade-left" data-aos-delay="100" class="text-gray-600 dark:text-gray-400 leading-relaxed max-w-md text-right mb-12">
                Lanskap dibentuk dengan metode berdampak rendah yang memeluk kontur alami tanah.
            </p>
            <img data-aos="zoom-in-up" data-aos-delay="200" alt="Taman damai" class="w-full h-80 object-cover rounded-2xl shadow-lg mt-auto" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA2MjBzlOb1Xtp-slKDXU-ymQdqBY3DBvmaPs-yG7PM8xWCw3Cs_jfc_lXkDC8sM5fk5Z4KR03A9B3UsbY5gqp5KpPKJukm9TjaZfFpAilL9XT-qVOY9uC9FFyyRLWPmEguiKFajZUbGA3kwYyih3DAgCkgKpW3Hqjl0nHQrzo80r878DfsvpYBLB5Yw4qAnJ30FpDYd-78LnX8zVPRO5B3PFWosU_d6g5-WrjDnlNmIDoTPdVYecEUFhZmQYXXCCZapMRsxt8baCo" />
        </div>
    </div>
    <hr class="mt-32 border-gray-200 dark:border-gray-800 max-w-7xl mx-auto" />
</section>

{{-- ═══════════════════════════════════════════════════════════════
     ✦ TAMBAHAN 2: MARQUEE — KEUNGGULAN / NILAI
     ═══════════════════════════════════════════════════════════════ --}}
<div class="py-6 bg-primary overflow-hidden select-none">
    <div class="flex whitespace-nowrap marquee-track">
        @php
        $items = ['Lingkungan Asri & Tenang', 'Orientasi Kiblat Terverifikasi', 'Keamanan 24 Jam', 'Perawatan Profesional', 'Legalitas Terjamin', 'Cluster Muslim & Non-Muslim', 'Desain Berdampak Rendah', 'Kavling Keluarga Tersedia'];
        @endphp
        @foreach(array_merge($items, $items) as $item)
        <span class="inline-flex items-center gap-4 px-8 text-gray-900 font-bold text-sm uppercase tracking-widest">
            <span class="w-1.5 h-1.5 rounded-full bg-gray-900/40 inline-block"></span>
            {{ $item }}
        </span>
        @endforeach
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     BAGIAN ASLI — TIDAK DIUBAH
     ═══════════════════════════════════════════════════════════════ --}}
<section class="py-24 px-8 xl:px-24 bg-background-light dark:bg-background-dark">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-start mb-16">
            <h2 data-aos="fade-right" class="text-5xl font-bold max-w-sm leading-tight">Kehidupan di Taman Perdamaian</h2>
            <div data-aos="fade-left" class="flex flex-col items-end max-w-lg text-right mt-8 md:mt-0">
                <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-6">
                    Ruang-ruang dibuat dengan metode bangunan berdampak rendah yang memeluk kontur alami tanah.
                </p>
                <a class="btn-ripple btn-press px-8 py-4 bg-gray-900 dark:bg-gray-100 text-white dark:text-gray-900 font-semibold rounded-full hover:bg-gray-800 dark:hover:bg-white transition-colors shadow-md inline-block" href="#">
                    Lihat Semua Area
                </a>
            </div>
        </div>
        <div class="flex flex-col lg:flex-row gap-16">
            <div class="lg:w-1/4 flex flex-col gap-6" data-aos="fade-up">
                <button data-aos="fade-up" data-aos-delay="0" class="text-left text-2xl font-bold text-gray-900 dark:text-white border-b-2 border-gray-900 dark:border-white pb-2 w-max">Muslim Cluster</button>
                <button data-aos="fade-up" data-aos-delay="100" class="text-left text-2xl font-medium text-gray-400 dark:text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors w-max">Cluster Non-Muslim</button>
                <button data-aos="fade-up" data-aos-delay="200" class="text-left text-2xl font-medium text-gray-400 dark:text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors w-max">Kavling Keluarga</button>
                <button data-aos="fade-up" data-aos-delay="300" class="text-left text-2xl font-medium text-gray-400 dark:text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors w-max">Kavling Tunggal</button>
                <a data-aos="fade-in" data-aos-delay="400" class="mt-auto inline-flex items-center text-gray-500 hover:text-gray-900 dark:hover:text-white transition-colors pt-12" href="#">
                    Detail Akomodasi <span class="material-icons ml-2 text-sm">arrow_forward</span>
                </a>
            </div>
            <div class="lg:w-3/4 relative">
                <div data-aos="fade-left" data-aos-duration="1000" class="w-full h-[600px] rounded-3xl overflow-hidden shadow-2xl relative">
                    <img alt="Pemandangan indah sebuah cluster" class="w-full h-full object-cover object-center" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA6rqI9PeXcrrGEttejmy2Cel3avh8VDbuuLZ9znSeQ0Gw8_f3nDIPA5daXuk1lNSAm-tWxpJ6GMjkfk9Tp4ugchXR-TAxa51kf5RD--deEWZYCqfHqwdgP2haxZx3xe7cTs56uTS0TFSEdFgax5uGIbYCrGwAW6cxENUzjoD6JXr0AiwuyMq0RGnXuNAwZgLJIJ_7ohB4P4zHoRvO2BfqUnDNpU9LpoqSZub_tqXvtwDa3MXakwPvYeN3NT97N3pe77_3ygdwuIsc" />
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     ✦ TAMBAHAN 3: KEUNGGULAN / FASILITAS
     ═══════════════════════════════════════════════════════════════ --}}
<section class="py-24 px-8 xl:px-24 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
            <div>
                <span data-aos="fade-up" class="text-primary font-bold tracking-widest uppercase text-xs">Mengapa Kami</span>
                <h2 data-aos="fade-up" data-aos-delay="100" class="text-4xl md:text-5xl font-bold mt-2 leading-tight max-w-md">Standar Perawatan yang Tak Tertandingi</h2>
            </div>
            <p data-aos="fade-up" data-aos-delay="200" class="text-gray-500 dark:text-gray-400 max-w-sm text-sm leading-relaxed md:text-right">
                Setiap detail dirancang untuk memberikan ketenangan bagi keluarga yang Anda kasihi.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $features = [
                ['icon' => 'security',        'title' => 'Keamanan 24 Jam',         'desc' => 'Sistem CCTV terintegrasi dan petugas keamanan berjaga sepanjang waktu tanpa henti.', 'color' => 'blue'],
                ['icon' => 'mosque',          'title' => 'Fasilitas Ibadah',         'desc' => 'Mushola internal dan area wudu tersedia di dalam kawasan untuk kemudahan beribadah.', 'color' => 'emerald'],
                ['icon' => 'nature',          'title' => 'Taman Hijau Terawat',      'desc' => 'Tim hortikultura profesional merawat setiap tanaman dan lanskap setiap hari.', 'color' => 'green'],
                ['icon' => 'gavel',           'title' => 'Legalitas Lengkap',        'desc' => 'Sertifikat kavling resmi dan dokumen legal yang transparan dan dapat diverifikasi.', 'color' => 'amber'],
                ['icon' => 'local_parking',   'title' => 'Parkir Luas',              'desc' => 'Area parkir yang memadai untuk ratusan kendaraan keluarga yang berkunjung.', 'color' => 'gray'],
                ['icon' => 'support_agent',   'title' => 'Layanan Keluarga',         'desc' => 'Tim konsultan siap mendampingi seluruh proses dari pemilihan hingga selesai.', 'color' => 'rose'],
            ];
            @endphp

            @foreach($features as $i => $f)
            <div data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 100 }}"
                 class="group p-7 rounded-3xl border border-gray-100 dark:border-gray-800 hover:border-primary/30 hover:shadow-xl transition-all duration-500 hover:-translate-y-1 bg-white dark:bg-gray-900 relative overflow-hidden">
                {{-- background glow on hover --}}
                <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-3xl"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 rounded-2xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-5 group-hover:bg-primary/10 transition-colors">
                        <span class="material-icons text-gray-600 dark:text-gray-300 group-hover:text-primary transition-colors">{{ $f['icon'] }}</span>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2">{{ $f['title'] }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">{{ $f['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     BAGIAN ASLI — TIDAK DIUBAH
     ═══════════════════════════════════════════════════════════════ --}}
<section id="tipe-kavling" class="py-24 px-8 xl:px-24 bg-white dark:bg-gray-900 relative">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <span data-aos="fade-up" class="text-primary font-bold tracking-widest uppercase text-sm">Pilihan Kavling</span>
            <h2 data-aos="fade-up" data-aos-delay="100" class="text-4xl md:text-5xl font-bold mt-2 leading-tight">Spesifikasi & Ukuran</h2>
            <p data-aos="fade-up" data-aos-delay="200" class="text-gray-500 mt-4 max-w-2xl mx-auto">Tersedia berbagai pilihan tipe kavling untuk kenyamanan peristirahatan keluarga Anda.</p>
        </div>

        <div x-data="{ activeTab: 'muslim' }" class="w-full">
            <div data-aos="fade-up" data-aos-delay="200" class="flex justify-center mb-12">
                <div class="bg-gray-100 dark:bg-gray-800 p-1 rounded-full inline-flex relative shadow-sm border border-gray-200 dark:border-gray-700">
                    <button @click="activeTab = 'muslim'" 
                            :class="{ 'bg-primary text-gray-900 shadow-md': activeTab === 'muslim', 'text-gray-500 hover:text-gray-900 dark:hover:text-white': activeTab !== 'muslim' }"
                            class="btn-press px-6 md:px-10 py-3 rounded-full text-sm font-bold transition-all duration-300">
                        Cluster Muslim
                    </button>
                    <button @click="activeTab = 'non_muslim'" 
                            :class="{ 'bg-gray-900 text-white shadow-md': activeTab === 'non_muslim', 'text-gray-500 hover:text-gray-900 dark:hover:text-white': activeTab !== 'non_muslim' }"
                            class="btn-press px-6 md:px-10 py-3 rounded-full text-sm font-bold transition-all duration-300">
                        Cluster Non-Muslim
                    </button>
                </div>
            </div>

            <div class="relative min-h-[500px]">
                <div x-show="activeTab === 'muslim'" 
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @php
                        $muslimTypes = [
                            ['name' => 'Tipe Barokah', 'size' => '1.5m x 2.5m', 'max' => 1],
                            ['name' => 'Tipe Fitrah', 'size' => '4m x 3m', 'max' => 2],
                            ['name' => 'Tipe Sakinah', 'size' => '7m x 8m', 'max' => 6],
                            ['name' => 'Tipe Khalifah', 'size' => '7m x 15m', 'max' => 12],
                        ];
                    @endphp
                    @foreach($muslimTypes as $item)
                    <div class="group relative bg-white dark:bg-gray-800 border border-emerald-100 dark:border-gray-700 rounded-2xl p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 flex flex-col">
                        <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                            <span class="material-icons text-6xl text-emerald-600">mosque</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">{{ $item['name'] }}</h3>
                        <div class="w-full h-32 bg-emerald-50 dark:bg-emerald-900/20 border-2 border-dashed border-emerald-200 dark:border-emerald-700 rounded-lg flex flex-col items-center justify-center mb-4 relative overflow-hidden">
                            <span class="text-[10px] uppercase font-bold text-emerald-400 absolute top-2 left-2">Denah</span>
                            <span class="text-lg font-bold text-emerald-700 dark:text-emerald-300">{{ $item['size'] }}</span>
                        </div>
                        <div class="mt-auto border-t border-gray-100 dark:border-gray-700 pt-4 flex justify-between items-center">
                            <span class="text-xs font-bold uppercase text-gray-400">Max Isi</span>
                            <span class="flex items-center gap-1 font-bold text-emerald-600 bg-emerald-50 dark:bg-emerald-900/30 px-3 py-1 rounded-full text-sm">
                                <span class="material-icons text-sm">person</span> {{ $item['max'] }}
                            </span>
                        </div>
                        <button class="btn-ripple btn-press mt-4 w-full py-2 bg-emerald-600 text-white rounded-lg text-sm font-bold hover:bg-emerald-700 transition-colors">
                            Pilih Tipe Ini
                        </button>
                    </div>
                    @endforeach
                </div>

                <div x-show="activeTab === 'non_muslim'" style="display: none;"
                     x-transition:enter="transition ease-out duration-500"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @php
                        $nonMuslimTypes = [
                            ['name' => 'Single', 'size' => '1.5m x 4m', 'max' => 1],
                            ['name' => 'Double', 'size' => '3m x 4m', 'max' => 2],
                            ['name' => 'Double Deluxe', 'size' => '4m x 4.5m', 'max' => 2],
                            ['name' => 'Double Special', 'size' => '8m x 4.5m', 'max' => 4],
                            ['name' => 'Family', 'size' => '8m x 5m', 'max' => 4],
                            ['name' => 'Super Family', 'size' => '8m x 10m', 'max' => 6],
                            ['name' => 'Royal Family', 'size' => '16m x 20m', 'max' => 10],
                            ['name' => 'VIP', 'size' => '26m x 36m', 'max' => 18],
                        ];
                    @endphp
                    @foreach($nonMuslimTypes as $item)
                    <div class="group relative bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl p-6 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 flex flex-col">
                        <div class="absolute top-0 right-0 p-4 opacity-5 group-hover:opacity-10 transition-opacity">
                            <span class="material-icons text-6xl text-gray-900 dark:text-white">church</span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 truncate">{{ $item['name'] }}</h3>
                        <div class="w-full h-24 bg-gray-50 dark:bg-gray-700/30 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg flex flex-col items-center justify-center mb-4">
                            <span class="text-sm font-bold text-gray-600 dark:text-gray-300">{{ $item['size'] }}</span>
                        </div>
                        <div class="mt-auto border-t border-gray-100 dark:border-gray-700 pt-4 flex justify-between items-center">
                            <span class="text-xs font-bold uppercase text-gray-400">Max Isi</span>
                            <span class="flex items-center gap-1 font-bold text-gray-900 dark:text-white bg-gray-100 dark:bg-gray-700 px-3 py-1 rounded-full text-sm">
                                <span class="material-icons text-sm">groups</span> {{ $item['max'] }}
                            </span>
                        </div>
                        <button class="btn-ripple btn-press mt-4 w-full py-2 border border-gray-900 dark:border-white text-gray-900 dark:text-white hover:bg-gray-900 hover:text-white dark:hover:bg-white dark:hover:text-gray-900 rounded-lg text-sm font-bold transition-colors">
                            Lihat Detail
                        </button>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     ✦ TAMBAHAN 4: GALERI FOTO
     ═══════════════════════════════════════════════════════════════ --}}
<section class="py-24 px-8 xl:px-24 bg-gray-50 dark:bg-gray-950">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <span data-aos="fade-up" class="text-primary font-bold tracking-widest uppercase text-xs">Galeri</span>
                <h2 data-aos="fade-up" data-aos-delay="100" class="text-4xl md:text-5xl font-bold mt-2 leading-tight">Keindahan yang Nyata</h2>
            </div>
            <a data-aos="fade-up" href="{{ url('/cluster') }}"
               class="btn-press inline-flex items-center gap-2 px-6 py-3 border border-gray-300 dark:border-gray-700 rounded-full text-sm font-semibold hover:border-gray-900 dark:hover:border-white transition-colors self-start md:self-auto">
                Lihat Semua Foto <span class="material-icons text-sm">arrow_forward</span>
            </a>
        </div>

        {{-- Grid galeri asimetris --}}
        <div class="grid grid-cols-2 md:grid-cols-4 grid-rows-2 gap-3 h-[480px] md:h-[560px]">

            {{-- Besar kiri --}}
            <div data-aos="zoom-in" data-aos-delay="0"
                 class="gallery-item col-span-2 row-span-2 rounded-3xl overflow-hidden relative cursor-pointer">
                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuA6rqI9PeXcrrGEttejmy2Cel3avh8VDbuuLZ9znSeQ0Gw8_f3nDIPA5daXuk1lNSAm-tWxpJ6GMjkfk9Tp4ugchXR-TAxa51kf5RD--deEWZYCqfHqwdgP2haxZx3xe7cTs56uTS0TFSEdFgax5uGIbYCrGwAW6cxENUzjoD6JXr0AiwuyMq0RGnXuNAwZgLJIJ_7ohB4P4zHoRvO2BfqUnDNpU9LpoqSZub_tqXvtwDa3MXakwPvYeN3NT97N3pe77_3ygdwuIsc"
                     alt="Galeri 1" class="w-full h-full object-cover" />
                <div class="gallery-overlay absolute inset-0 bg-gray-900/40 flex items-end p-6">
                    <span class="text-white font-bold text-lg">Cluster Madinah</span>
                </div>
            </div>

            {{-- Kanan atas --}}
            <div data-aos="zoom-in" data-aos-delay="100"
                 class="gallery-item col-span-1 row-span-1 rounded-2xl overflow-hidden relative cursor-pointer">
                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuCSeV8r5vTKVZson8x8U7XKosDU4OBIVwZCPNZOGiv7g8lL5mQYOegvqR47c2dPLgGFWhnrnslq9ErpprziLGhdeyqqystblfmKjcXSYUs3Ex5arOXBjjL80xf80mRmXZS6gCg9ShL7wBZ09_YS6GYhWfYN8ngIMMJKxo-PMrFVAhpyGaPNnDwhj0B12HdNVsq6MbUvK0TVpR3IYfH2whIB76pNLxyD6Zc2Asd_nuvAYJufsHTjqWMGi_EKBGJGKb7I688tdFK_1Qw"
                     alt="Galeri 2" class="w-full h-full object-cover" />
                <div class="gallery-overlay absolute inset-0 bg-gray-900/30 flex items-end p-4">
                    <span class="text-white font-semibold text-sm">Jalur Pedestrian</span>
                </div>
            </div>

            {{-- Kanan atas ke-2 --}}
            <div data-aos="zoom-in" data-aos-delay="200"
                 class="gallery-item col-span-1 row-span-1 rounded-2xl overflow-hidden relative cursor-pointer">
                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuCKKlS1j_Zt3H2_tLdwUcZy3qankghtW1i1Z_CwZctvMaNAB6rj9WvYrHL3jwoPljnQjbwgX-wOB61mlkFoHUxqt_S0zV7NoHPF5t1gTcZ2wb4P0HKv7ripuN0rO5W71tkzxVnzxIqaQ7Dc8p0S0QKYT3crM1aj8H3wq0lQGPx-n4dJSc0DoENon9u9Nc60JG6ou2rOUQ8pD9s7UXqTxyMGomfOJ1FK5F3h_NAMcq3XGhEcG-GAfKcf3n8lzikz-kwhBLb0QNuLmLc"
                     alt="Galeri 3" class="w-full h-full object-cover" />
                <div class="gallery-overlay absolute inset-0 bg-gray-900/30 flex items-end p-4">
                    <span class="text-white font-semibold text-sm">Cluster Preview</span>
                </div>
            </div>

            {{-- Kanan bawah --}}
            <div data-aos="zoom-in" data-aos-delay="300"
                 class="gallery-item col-span-1 row-span-1 rounded-2xl overflow-hidden relative cursor-pointer">
                <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuC84fEtfZb8hWa8DG2uJJfLUZGCaLm5oOnQI0MHj2S6K5kwbfoCHJseJ0nNLKVR_yh8U1W9MSn7c9b1uZeAWC3mjLXJHYtd4R7_oQcvB0nZeBHp2-33dtHJPAdie6SAHmyx2wWFg6PDA7K7Cio3YuEF2GfixpWADifW8iIZGvnYnuDU0DHY_nNJVwJZPUEJjX_OAFnbE7VCZuUlC-ufcD-_1rp5Olu60H67Ih9XH2AZSPPvqiVWhtGOGGCjSDWO_tBe89VFeTumpjk"
                     alt="Galeri 4" class="w-full h-full object-cover" />
                <div class="gallery-overlay absolute inset-0 bg-gray-900/30 flex items-end p-4">
                    <span class="text-white font-semibold text-sm">Alam Tenang</span>
                </div>
            </div>

            {{-- Kanan bawah ke-2: CTA card --}}
            <div data-aos="zoom-in" data-aos-delay="400"
                 class="col-span-1 row-span-1 rounded-2xl bg-primary flex flex-col items-center justify-center p-5 text-center cursor-pointer group">
                <span class="material-icons text-gray-900 text-3xl mb-2 group-hover:scale-110 transition-transform">photo_library</span>
                <span class="font-bold text-gray-900 text-sm">+24 Foto Lainnya</span>
                <span class="text-xs text-gray-800/70 mt-1">Lihat Galeri Lengkap</span>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     BAGIAN ASLI — TIDAK DIUBAH (Testimonial)
     ═══════════════════════════════════════════════════════════════ --}}
<section class="relative bg-[#E8EEF2] dark:bg-gray-800 overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" preserveAspectRatio="none" viewBox="0 0 100 100">
            <polygon fill="currentColor" points="0,0 100,0 50,100"></polygon>
        </svg>
    </div>
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center relative z-10">
        <div class="md:w-1/2 p-12 md:p-24 flex flex-col justify-center">
            <span data-aos="fade-down" class="text-6xl text-primary font-serif leading-none mb-6">"</span>
            <p data-aos="fade-right" data-aos-delay="100" class="text-2xl font-medium italic text-gray-800 dark:text-gray-200 leading-relaxed mb-12">
                Menemukan tempat peristirahatan di sini seperti memasuki dunia lain. Setiap area menceritakan kisahnya sendiri.
            </p>
            <div data-aos="fade-up" data-aos-delay="200" class="flex justify-between items-end border-t border-gray-300 dark:border-gray-600 pt-8">
                <div>
                    <h4 class="font-bold text-gray-900 dark:text-white">Keluarga Lee</h4>
                    <p class="text-sm text-gray-500">Jakarta</p>
                </div>
            </div>
        </div>
        <div data-aos="fade-left" class="md:w-1/2 h-full min-h-[500px] bg-cover bg-center" style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuC3I2CHNiF3TYUXpoG8iu9-vLap7F1U4TBu_LmtLP2y-mmB4Om_mKa2hJFdKYGZpYohYYztH82qkY8iC4O_fV1x0r3XagqVTEK2Cpx5p6XuP40-6m1fCrMX1YpnL4JeWD2IWnF_bLl88rpISIucKfB5_D32F8WffiNiSIv8CjiWb-uSo6fHJgVQJTMH2JM5kVbaJyky6lYauNngTmKKsZGaLsZzyi_A1mGkujVgFlF8tIA7IrVyEjnJz8kg51m_c0YDGUwQIOt0qvQ');"></div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     ✦ TAMBAHAN 5: PROSES PEMESANAN (STEP BY STEP)
     ═══════════════════════════════════════════════════════════════ --}}
<section class="py-24 px-8 xl:px-24 bg-white dark:bg-gray-900">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <span data-aos="fade-up" class="text-primary font-bold tracking-widest uppercase text-xs">Cara Memesan</span>
            <h2 data-aos="fade-up" data-aos-delay="100" class="text-4xl md:text-5xl font-bold mt-2 leading-tight">Proses Mudah & Transparan</h2>
        </div>

        <div class="relative">
            {{-- Garis penghubung --}}
            <div class="hidden md:block absolute top-10 left-[12.5%] right-[12.5%] h-px bg-gradient-to-r from-transparent via-gray-200 dark:via-gray-700 to-transparent z-0"></div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative z-10">
                @php
                $steps = [
                    ['no' => '01', 'icon' => 'search',       'title' => 'Pilih Cluster',      'desc' => 'Jelajahi pilihan cluster Muslim atau Non-Muslim dan temukan yang sesuai.'],
                    ['no' => '02', 'icon' => 'edit_note',    'title' => 'Isi Formulir',       'desc' => 'Lengkapi data reservasi dan upload dokumen yang diperlukan secara online.'],
                    ['no' => '03', 'icon' => 'payments',     'title' => 'Lakukan Pembayaran', 'desc' => 'Pilih metode pembayaran yang nyaman dan kirim bukti transfer.'],
                    ['no' => '04', 'icon' => 'verified',     'title' => 'Konfirmasi Resmi',   'desc' => 'Dapatkan sertifikat dan nomor kavling resmi atas nama keluarga Anda.'],
                ];
                @endphp
                @foreach($steps as $i => $step)
                <div data-aos="fade-up" data-aos-delay="{{ $i * 150 }}" class="flex flex-col items-center text-center">
                    <div class="w-20 h-20 rounded-full border-2 border-gray-100 dark:border-gray-800 bg-white dark:bg-gray-900 shadow-lg flex items-center justify-center mb-5 relative group hover:border-primary transition-colors duration-300">
                        <span class="material-icons text-gray-400 group-hover:text-primary transition-colors text-2xl">{{ $step['icon'] }}</span>
                        <span class="absolute -top-2 -right-2 w-6 h-6 bg-primary text-gray-900 text-xs font-black rounded-full flex items-center justify-center">{{ $step['no'] }}</span>
                    </div>
                    <h3 class="font-bold text-gray-900 dark:text-white mb-2">{{ $step['title'] }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <div data-aos="fade-up" class="text-center mt-14">
            <a href="{{ url('/register') }}"
               class="btn-press btn-ripple inline-flex items-center gap-2 px-8 py-4 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-bold rounded-full hover:bg-gray-800 transition-colors shadow-lg">
                Mulai Sekarang <span class="material-icons text-sm">arrow_forward</span>
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     ✦ TAMBAHAN 6: FAQ
     ═══════════════════════════════════════════════════════════════ --}}
<section class="py-24 px-8 xl:px-24 bg-gray-50 dark:bg-gray-950">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-14">
            <span data-aos="fade-up" class="text-primary font-bold tracking-widest uppercase text-xs">FAQ</span>
            <h2 data-aos="fade-up" data-aos-delay="100" class="text-4xl md:text-5xl font-bold mt-2 leading-tight">Pertanyaan yang Sering Ditanyakan</h2>
        </div>

        @php
        $faqs = [
            ['q' => 'Apakah kavling bisa dibeli untuk persiapan ke depan (pre-need)?',
             'a' => 'Ya, kami menyediakan pilihan pembelian pre-need. Anda dapat memesan dan memiliki kavling sejak sekarang untuk keperluan di masa mendatang, dengan harga yang terkunci saat pembelian.'],
            ['q' => 'Apa perbedaan Cluster Muslim dan Non-Muslim?',
             'a' => 'Cluster Muslim dirancang dengan orientasi kiblat terverifikasi, fasilitas mushola internal, dan tata cara pemakaman sesuai syariat Islam. Cluster Non-Muslim memiliki desain yang lebih umum dan dapat digunakan oleh berbagai kepercayaan.'],
            ['q' => 'Apakah ada biaya perawatan tahunan?',
             'a' => 'Ya, terdapat biaya perawatan tahunan yang mencakup kebersihan area, perawatan tanaman, dan penerangan. Biaya ini sangat terjangkau dan dapat dibayarkan sekaligus untuk beberapa tahun ke depan.'],
            ['q' => 'Bagaimana dengan legalitas dan sertifikat kavling?',
             'a' => 'Setiap kavling dilengkapi dengan sertifikat resmi dan dokumen legal yang transparan. Kami bekerja sama dengan notaris terpercaya untuk memastikan seluruh proses kepemilikan berjalan dengan benar.'],
            ['q' => 'Bisakah kavling dijual atau dipindahtangankan?',
             'a' => 'Kavling dapat dipindahtangankan kepada anggota keluarga inti. Proses pemindahan kepemilikan dilakukan melalui tim administrasi kami dengan prosedur yang jelas dan transparan.'],
        ];
        @endphp

        <div class="space-y-3" id="faq-list">
            @foreach($faqs as $i => $faq)
            <div data-aos="fade-up" data-aos-delay="{{ $i * 80 }}"
                 class="faq-item bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl overflow-hidden">
                <button onclick="toggleFaq(this)"
                        class="w-full flex items-center justify-between px-7 py-5 text-left gap-4">
                    <span class="font-semibold text-gray-900 dark:text-white text-sm md:text-base">{{ $faq['q'] }}</span>
                    <span class="material-icons faq-icon text-gray-400 shrink-0">add</span>
                </button>
                <div class="faq-answer px-7 pb-0">
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed pb-5">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     BAGIAN ASLI — TIDAK DIUBAH (CTA Akhir)
     ═══════════════════════════════════════════════════════════════ --}}
<section class="px-8 xl:px-24 py-24 bg-white dark:bg-gray-900">
    <div data-aos="zoom-in" data-aos-duration="1000" class="max-w-7xl mx-auto bg-gray-500 dark:bg-gray-800 rounded-3xl overflow-hidden relative flex flex-col justify-center p-16 md:p-24 min-h-[500px]">
        <div class="relative z-10 max-w-2xl text-white">
            <p class="text-sm font-bold tracking-widest uppercase mb-6 text-primary">We Are Waiting For You</p>
            <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-12">
                Come Find the Place Your Soul Already Knows
            </h2>
            <a class="btn-ripple btn-press inline-block px-8 py-4 bg-white text-gray-900 font-bold rounded-full hover:bg-gray-100 transition-colors shadow-lg hover:scale-105 transform duration-300" href="#">
                Pesan Kunjungan
            </a>
        </div>
    </div>
</section>

<script>
function toggleFaq(btn) {
    const item = btn.closest('.faq-item');
    const isOpen = item.classList.contains('open');
    // tutup semua
    document.querySelectorAll('.faq-item.open').forEach(el => el.classList.remove('open'));
    // buka yang diklik (kecuali kalau sudah terbuka)
    if (!isOpen) item.classList.add('open');
}
</script>

@endsection