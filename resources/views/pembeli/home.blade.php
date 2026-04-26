@extends('layouts.master')

@section('title', 'Beranda - Mount Carmel Cluster')

@section('content')

@php
$reservedKavlings = $reservedKavlings ?? [];
@endphp

<style>
    /* ── Font ── */
    body { font-family: 'Inter', sans-serif; }
    h1, h2, h3, h4, h5, .font-poppins { font-family: 'Poppins', sans-serif; }

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

    /* ── Counter animasi ── */
    @keyframes countUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .stat-animate { animation: countUp 0.8s ease forwards; }

    /* ── Marquee ── */
    @keyframes marquee {
        0%   { transform: translateX(0); }
        100% { transform: translateX(-50%); }
    }
    .marquee-track { animation: marquee 24s linear infinite; }
    .marquee-track:hover { animation-play-state: paused; }

    /* ── FAQ accordion ── */
    .faq-answer { max-height: 0; overflow: hidden; transition: max-height 0.4s ease, padding 0.3s ease; }
    .faq-item.open .faq-answer { max-height: 300px; }
    .faq-item.open .faq-icon { transform: rotate(45deg); }
    .faq-icon { transition: transform 0.3s ease; }

    /* ── Galeri hover ── */
    .gallery-item img { transition: transform 0.6s cubic-bezier(.25,.46,.45,.94); }
    .gallery-item:hover img { transform: scale(1.08); }
    .gallery-overlay { opacity: 0; transition: opacity 0.4s ease; }
    .gallery-item:hover .gallery-overlay { opacity: 1; }

    /* ── Hero floating cards — sembunyikan di mobile ── */
    .hero-float-card { display: none; }
    @media (min-width: 768px) {
        .hero-float-card { display: block; }
    }
</style>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Poppins:ital,wght@0,400;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet" />

{{-- ═══════════════════════════════════════════════════════════════
     HERO SECTION
     ═══════════════════════════════════════════════════════════════ --}}

<header class="relative overflow-hidden min-h-screen flex flex-col pt-28 md:pt-40 px-4 md:px-8 xl:px-24">
    <div data-aos="fade-in" data-aos-duration="1500" class="absolute top-0 right-0 w-1/2 h-full bg-primary/20 rounded-bl-[100px] md:rounded-bl-[200px] -z-10"></div>
    <div data-aos="fade-in" data-aos-duration="2000" class="absolute -top-16 left-0 w-48 h-48 md:w-96 md:h-96 bg-primary/30 rounded-full blur-3xl -z-10"></div>
    
    <div class="flex-grow flex flex-col justify-center relative z-10 pb-10 md:pb-20">
        <h1 data-aos="fade-up" data-aos-delay="0" class="text-4xl sm:text-5xl md:text-7xl lg:text-8xl font-bold max-w-4xl leading-tight tracking-tight mb-6 md:mb-12">
            Mount Carmel Cluster Madinah
        </h1>

        <h4 data-aos="fade-up" data-aos-delay="100" class="text-base md:text-xl lg:text-2xl font-poppins font-semibold italic text-gray-700 max-w-2xl mb-8 md:mb-12">
            "Berikan yang terbaik untuk terakhir kalinya"
        </h4>
        
        <div data-aos="zoom-in" data-aos-delay="200" data-aos-duration="1000" class="relative w-full h-[300px] sm:h-[400px] md:h-[500px] rounded-2xl md:rounded-[2rem] overflow-hidden shadow-2xl group">
            <img alt="Pemandangan indah pemakaman" class="w-full h-full object-cover object-center transform transition-transform duration-700 group-hover:scale-105"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuC1NyIlZmBiYtT_kIu9sIln0H_-6RueC2Hhc_d6kZXH1IScjujHYPs6awIbu5dRMlY6nh3OHS1NSyx_fBcV7oOIg267GAnn0m7Dmy2SYQtQcbdLRfesZdEgbtNBETqCuWIVnqGkcdMwWMXj_pXaa-9yAZFgRqIMFAYsbtXSydiAp8yeFKTcA-sa0Emlh4YOvMdCaPtYTaF9zS1c7aKDxKlmU_zIPST46YbjjlfflaEwp9vViTnYZ990e-nAoVM2fkKAhJwzbhau-yI" />
            
            {{-- Floating cards: hanya tampil di md ke atas --}}
            <div data-aos="fade-right" data-aos-delay="500" class="hero-float-card absolute bottom-8 left-8 bg-white/90 backdrop-blur-md p-6 rounded-2xl shadow-lg max-w-sm transition-transform hover:-translate-y-2 cursor-pointer btn-press">
                <img alt="Pratinjau cluster" class="w-full h-40 object-cover rounded-xl mb-4" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCKKlS1j_Zt3H2_tLdwUcZy3qankghtW1i1Z_CwZctvMaNAB6rj9WvYrHL3jwoPljnQjbwgX-wOB61mlkFoHUxqt_S0zV7NoHPF5t1gTcZ2wb4P0HKv7ripuN0rO5W71tkzxVnzxIqaQ7Dc8p0S0QKYT3crM1aj8H3wq0lQGPx-n4dJSc0DoENon9u9Nc60JG6ou2rOUQ8pD9s7UXqTxyMGomfOJ1FK5F3h_NAMcq3XGhEcG-GAfKcf3n8lzikz-kwhBLb0QNuLmLc" />
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-gray-900">Lihat Semua Cluster</span>
                    <span class="material-icons text-gray-500">arrow_forward</span>
                </div>
            </div>
            
            <div data-aos="fade-left" data-aos-delay="700" class="hero-float-card absolute bottom-32 right-8 bg-white/90 backdrop-blur-md p-6 rounded-2xl shadow-lg max-w-sm transition-transform hover:-translate-y-2 cursor-pointer btn-press">
                <img alt="Pratinjau layanan" class="w-full h-40 object-cover rounded-xl mb-4" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDOy1Fohlq_qivWE2tkM433deJqLAQ3UogU5-WSqG19mRZNu9OmlEuPQ1U06tbq0gdMbF0Ck-PAYzTBMlskj5DAkT-uNDwHpskU1Dl1eoUeygiIidyS5eeHLFpz0zt2d1TIfYlbxRLfJx1o_DXE7pH0PxPeyGigVt9a_ryqk2-e_iNR8oUYCQxyFMTCES7kBIrLIOpYtrlVK4vi9pO0ZbGqRBYIW7YG7GGQuf_tf8GP3pXp_wb8cb0_x4OhwB-nGxmxFINL8LCrYYQ" />
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-gray-900">Layanan Kami</span>
                    <span class="material-icons text-gray-500">arrow_forward</span>
                </div>
            </div>
            
            <div data-aos="fade-up" data-aos-delay="900" class="absolute bottom-4 md:bottom-8 left-1/2 -translate-x-1/2 flex items-center gap-3 md:gap-6 bg-white/50 backdrop-blur-sm py-2 md:py-3 px-4 md:px-8 rounded-full whitespace-nowrap">
                <span class="text-xs md:text-sm font-medium uppercase tracking-wider text-gray-800">Watch a video</span>
                <button class="btn-ripple btn-press w-10 h-10 md:w-16 md:h-16 bg-primary text-gray-900 rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition-transform">
                    <span class="material-icons text-xl md:text-3xl">play_arrow</span>
                </button>
                <span class="text-xs md:text-sm font-medium uppercase tracking-wider text-gray-800">Tentang Kami</span>
            </div>
        </div>

        {{-- CTA cards mobile only: tampil di bawah gambar di mobile --}}
        <div class="flex gap-3 mt-4 md:hidden">
            <a href="{{ url('/cluster') }}" class="btn-press flex-1 flex items-center justify-between gap-2 bg-white border border-gray-200 rounded-2xl p-4 shadow-sm">
                <span class="font-semibold text-gray-900 text-sm">Lihat Cluster</span>
                <span class="material-icons text-gray-500 text-sm">arrow_forward</span>
            </a>
            <a href="#" class="btn-press flex-1 flex items-center justify-between gap-2 bg-white border border-gray-200 rounded-2xl p-4 shadow-sm">
                <span class="font-semibold text-gray-900 text-sm">Layanan Kami</span>
                <span class="material-icons text-gray-500 text-sm">arrow_forward</span>
            </a>
        </div>
    </div>
</header>

{{-- ═══════════════════════════════════════════════════════════════
     STATISTIK
     ═══════════════════════════════════════════════════════════════ --}}
<section class="py-0 px-4 md:px-8 xl:px-24 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <div class="grid grid-cols-2 md:grid-cols-4 divide-x divide-y md:divide-y-0 divide-gray-100">
            @php
            $stats = [
                ['value' => '2.500+', 'label' => 'Keluarga Dipercayakan', 'accent' => 'text-emerald-600'],
                ['value' => '15+',    'label' => 'Tahun Pengalaman',      'accent' => 'text-blue-600'],
                ['value' => '4',      'label' => 'Cluster Tersedia',      'accent' => 'text-amber-600'],
                ['value' => '98%',    'label' => 'Kepuasan Keluarga',     'accent' => 'text-rose-600'],
            ];
            @endphp
            @foreach($stats as $i => $s)
            <div data-aos="fade-up" data-aos-delay="{{ $i * 80 }}"
                 class="flex flex-col items-center justify-center py-8 md:py-14 px-4 md:px-8 text-center group hover:bg-gray-50 transition-colors duration-300">
                <span class="font-poppins text-3xl sm:text-4xl md:text-6xl font-extrabold {{ $s['accent'] }} mb-2 md:mb-3 tabular-nums leading-none">{{ $s['value'] }}</span>
                <div class="w-8 h-0.5 {{ str_replace('text-', 'bg-', $s['accent']) }} rounded-full mb-2 md:mb-3 opacity-40 group-hover:opacity-100 group-hover:w-12 transition-all duration-300"></div>
                <span class="text-[10px] md:text-xs uppercase tracking-widest text-gray-400 font-semibold">{{ $s['label'] }}</span>
            </div>
            @endforeach
        </div>
        <div class="border-t border-gray-100"></div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     KEINDAHAN SECTION
     ═══════════════════════════════════════════════════════════════ --}}
<section class="py-16 md:py-24 px-4 md:px-8 xl:px-24 bg-white">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row gap-8 md:gap-16">
        <div class="md:w-1/2 flex flex-col justify-between gap-8">
            <div data-aos="fade-right">
                <h2 class="text-3xl md:text-5xl font-bold mb-4 md:mb-8 leading-tight">Keindahan Hening dan Ketentraman Mendalam</h2>
                <p class="text-gray-600 leading-relaxed">
                    Cluster dirancang menggunakan metode desain berdampak rendah yang memeluk kontur alami tanah.
                </p>
            </div>
            <div class="flex gap-3 md:gap-6">
                <img data-aos="fade-up" data-aos-delay="100" alt="Jalur penuh ketenangan" class="w-1/2 h-44 md:h-64 object-cover rounded-2xl shadow-md" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCSeV8r5vTKVZson8x8U7XKosDU4OBIVwZCPNZOGiv7g8lL5mQYOegvqR47c2dPLgGFWhnrnslq9ErpprziLGhdeyqqystblfmKjcXSYUs3Ex5arOXBjjL80xf80mRmXZS6gCg9ShL7wBZ09_YS6GYhWfYN8ngIMMJKxo-PMrFVAhpyGaPNnDwhj0B12HdNVsq6MbUvK0TVpR3IYfH2whIB76pNLxyD6Zc2Asd_nuvAYJufsHTjqWMGi_EKBGJGKb7I688tdFK_1Qw" />
                <img data-aos="fade-up" data-aos-delay="200" alt="Alam tenang" class="w-1/2 h-44 md:h-64 object-cover rounded-2xl shadow-md" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC84fEtfZb8hWa8DG2uJJfLUZGCaLm5oOnQI0MHj2S6K5kwbfoCHJseJ0nNLKVR_yh8U1W9MSn7c9b1uZeAWC3mjLXJHYtd4R7_oQcvB0nZeBHp2-33dtHJPAdie6SAHmyx2wWFg6PDA7K7Cio3YuEF2GfixpWADifW8iIZGvnYnuDU0DHY_nNJVwJZPUEJjX_OAFnbE7VCZuUlC-ufcD-_1rp5Olu60H67Ih9XH2AZSPPvqiVWhtGOGGCjSDWO_tBe89VFeTumpjk" />
            </div>
        </div>
        <div class="md:w-1/2 flex flex-col items-start md:items-end gap-6 md:gap-0">
            <a data-aos="fade-left" class="btn-ripple btn-press px-6 md:px-8 py-3 md:py-4 bg-gray-900 text-white font-semibold rounded-full hover:bg-gray-800 transition-colors md:mb-16 shadow-md inline-block" href="#">
                Pelajari Lebih Lanjut
            </a>
            <p data-aos="fade-left" data-aos-delay="100" class="text-gray-600 leading-relaxed max-w-md md:text-right md:mb-12">
                Lanskap dibentuk dengan metode berdampak rendah yang memeluk kontur alami tanah.
            </p>
            <img data-aos="zoom-in-up" data-aos-delay="200" alt="Taman damai" class="w-full h-56 md:h-80 object-cover rounded-2xl shadow-lg" src="https://lh3.googleusercontent.com/aida-public/AB6AXuA2MjBzlOb1Xtp-slKDXU-ymQdqBY3DBvmaPs-yG7PM8xWCw3Cs_jfc_lXkDC8sM5fk5Z4KR03A9B3UsbY5gqp5KpPKJukm9TjaZfFpAilL9XT-qVOY9uC9FFyyRLWPmEguiKFajZUbGA3kwYyih3DAgCkgKpW3Hqjl0nHQrzo80r878DfsvpYBLB5Yw4qAnJ30FpDYd-78LnX8zVPRO5B3PFWosU_d6g5-WrjDnlNmIDoTPdVYecEUFhZmQYXXCCZapMRsxt8baCo" />
        </div>
    </div>
    <hr class="mt-16 md:mt-32 border-gray-200 max-w-7xl mx-auto" />
</section>

{{-- ═══════════════════════════════════════════════════════════════
     MARQUEE
     ═══════════════════════════════════════════════════════════════ --}}
<div class="py-5 md:py-6 bg-primary overflow-hidden select-none">
    <div class="flex whitespace-nowrap marquee-track">
        @php
        $items = ['Lingkungan Asri & Tenang', 'Orientasi Kiblat Terverifikasi', 'Keamanan 24 Jam', 'Perawatan Profesional', 'Legalitas Terjamin', 'Cluster Muslim & Non-Muslim', 'Desain Berdampak Rendah', 'Kavling Keluarga Tersedia'];
        @endphp
        @foreach(array_merge($items, $items) as $item)
        <span class="inline-flex items-center gap-4 px-8 text-gray-900 font-bold text-xs md:text-sm uppercase tracking-widest">
            <span class="w-1.5 h-1.5 rounded-full bg-gray-900/40 inline-block"></span>
            {{ $item }}
        </span>
        @endforeach
    </div>
</div>

{{-- ═══════════════════════════════════════════════════════════════
     MASTERPLAN INTERAKTIF & FASILITAS (Pure Code/SVG)
     ═══════════════════════════════════════════════════════════════ --}}
<section class="py-16 md:py-24 px-4 md:px-8 xl:px-24 bg-[#FDFCFB] relative overflow-hidden font-inter">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700;800;900&display=swap');
        .font-poppins { font-family: 'Poppins', sans-serif; }
        .font-inter { font-family: 'Inter', sans-serif; }
    </style>

    <div class="max-w-7xl mx-auto space-y-16 md:space-y-24">
        
        <div x-data="{ view: 'semua', selectedKavling: null, zoom: 1, panX: 0, panY: 0, isPanning: false, startX: 0, startY: 0 }" class="relative">
            <div class="mb-10">
                <div class="max-w-2xl mb-6">
                    <span data-aos="fade-up" class="text-emerald-600 font-bold tracking-[0.2em] uppercase text-xs mb-3 block">Digital Masterplan</span>
                    <h2 data-aos="fade-up" data-aos-delay="100" class="text-3xl md:text-5xl font-black text-slate-900 font-poppins leading-tight">
                        Tata Letak Harmonis
                    </h2>
                    <p data-aos="fade-up" data-aos-delay="200" class="text-slate-500 mt-4 text-sm md:text-base leading-relaxed">
                        Jelajahi peta kawasan kami. Lanskap dirancang memeluk kontur alami, memisahkan area sesuai syariat dan universal dalam satu harmoni kedamaian.
                    </p>
                </div>
                
                <div data-aos="fade-left" data-aos-delay="300" class="bg-white p-1.5 rounded-xl md:rounded-full shadow-sm border border-slate-200 inline-flex font-inter z-20 w-full md:w-auto overflow-x-auto scrollbar-hide">
                    <button @click="view = 'semua'" :class="view === 'semua' ? 'bg-slate-900 text-white shadow-md' : 'text-slate-500 hover:text-slate-900'" class="px-6 py-2.5 rounded-full text-xs font-bold transition-all duration-300 tracking-wide uppercase whitespace-nowrap">
                        Seluruh Kawasan
                    </button>
                    <button @click="view = 'muslim'" :class="view === 'muslim' ? 'bg-emerald-600 text-white shadow-md' : 'text-slate-500 hover:text-slate-900'" class="px-6 py-2.5 rounded-full text-xs font-bold transition-all duration-300 tracking-wide uppercase whitespace-nowrap">
                        Cluster Muslim
                    </button>
                    <button @click="view = 'non_muslim'" :class="view === 'non_muslim' ? 'bg-amber-600 text-white shadow-md' : 'text-slate-500 hover:text-slate-900'" class="px-6 py-2.5 rounded-full text-xs font-bold transition-all duration-300 tracking-wide uppercase whitespace-nowrap">
                        Non-Muslim
                    </button>
                    <button @click="zoom = Math.min(zoom + 0.2, 2)" class="px-4 py-2.5 rounded-full text-xs font-bold transition-all duration-300 tracking-wide uppercase bg-slate-100 text-slate-600 hover:bg-slate-200 ml-2 whitespace-nowrap">+</button>
                    <button @click="zoom = Math.max(zoom - 0.2, 0.5)" class="px-4 py-2.5 rounded-full text-xs font-bold transition-all duration-300 tracking-wide uppercase bg-slate-100 text-slate-600 hover:bg-slate-200 ml-1 whitespace-nowrap">-</button>
                </div>
            </div>

            <div data-aos="zoom-in" data-aos-delay="400" class="relative w-full h-[400px] md:h-[600px] lg:h-[650px] bg-[#Eef5F0] rounded-2xl md:rounded-3xl border-2 md:border-4 border-white shadow-xl overflow-auto cursor-grab"
                 @mousedown="isPanning = true; startX = $event.clientX - panX; startY = $event.clientY - panY" 
                 @mousemove="if(isPanning) { panX = $event.clientX - startX; panY = $event.clientY - startY }" 
                 @mouseup="isPanning = false" 
                 @mouseleave="isPanning = false"
                 :class="isPanning ? 'cursor-grabbing' : 'cursor-grab'">
                
                <svg viewBox="0 0 1200 800" preserveAspectRatio="xMidYMid slice" 
                     class="absolute inset-0 w-full h-full transition-transform duration-1000 ease-in-out"
                     :style="`transform: translate(${panX}px, ${panY}px) scale(${zoom * (view === 'semua' ? 1 : 1.35)}) ${view === 'muslim' ? 'translateX(15%) translateY(5%)' : view === 'non_muslim' ? 'translateX(-15%) translateY(5%)' : ''};`">
                    
                    <defs>
                        <pattern id="grid-muslim" width="16" height="10" patternUnits="userSpaceOnUse">
                            <rect x="1" y="1" width="14" height="8" fill="#ffffff" stroke="#cbd5e1" stroke-width="0.5" rx="1"/>
                            <rect x="2" y="2" width="3" height="6" fill="#94a3b8" rx="1"/> </pattern>
                        
                        <pattern id="grid-nonmuslim" width="24" height="24" patternUnits="userSpaceOnUse">
                            <rect x="2" y="2" width="20" height="20" fill="#ffffff" stroke="#cbd5e1" stroke-width="0.5" rx="2"/>
                            <rect x="8" y="4" width="8" height="4" fill="#64748b" rx="1"/> <rect x="6" y="10" width="12" height="10" fill="#f1f5f9" rx="1"/> </pattern>

                        <pattern id="grid-plaza" width="20" height="20" patternUnits="userSpaceOnUse">
                            <path d="M 20 0 L 0 20 M 0 0 L 20 20" stroke="#e2e8f0" stroke-width="1" fill="none"/>
                        </pattern>

                        <linearGradient id="muslimGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#f0fdf4;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#dcfce7;stop-opacity:1" />
                        </linearGradient>

                        <linearGradient id="nonmuslimGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#fffbeb;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#fef3c7;stop-opacity:1" />
                        </linearGradient>

                        <linearGradient id="bgGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#E8F1EC;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#F0F9F4;stop-opacity:1" />
                        </linearGradient>
                    </defs>

                    <rect width="1200" height="800" fill="url(#bgGrad)"/>
                    
                    <path d="M 600,0 L 600,650" stroke="#D1D9E0" stroke-width="50" stroke-linecap="square"/>
                    <path d="M 50,150 L 1150,150" stroke="#D1D9E0" stroke-width="40" stroke-linecap="round"/>
                    <path d="M 50,400 L 1150,400" stroke="#D1D9E0" stroke-width="40" stroke-linecap="round"/>

                    <g transform="translate(600, 720)">
                        <circle r="120" fill="#D1D9E0"/>
                        <circle r="90" fill="url(#grid-plaza)"/>
                        <circle r="90" fill="none" stroke="#ffffff" stroke-width="4"/>
                        <path d="M 0,-40 L 10,-10 L 40,0 L 10,10 L 0,40 L -10,10 L -40,0 L -10,-10 Z" fill="#64748B" opacity="0.3"/>
                        <circle r="15" fill="#34D399"/>
                    </g>

                    <g class="trees">
                        <!-- Pohon 1 -->
                        <circle cx="150" cy="200" r="8" fill="#16a34a" />
                        <path d="M 150 208 L 146 216 L 154 216 Z" fill="#16a34a" />
                        <!-- Pohon 2 -->
                        <circle cx="400" cy="350" r="8" fill="#16a34a" />
                        <path d="M 400 358 L 396 366 L 404 366 Z" fill="#16a34a" />
                        <!-- Pohon 3 -->
                        <circle cx="800" cy="250" r="8" fill="#16a34a" />
                        <path d="M 800 258 L 796 266 L 804 266 Z" fill="#16a34a" />
                        <!-- Pohon 4 -->
                        <circle cx="1000" cy="400" r="8" fill="#16a34a" />
                        <path d="M 1000 408 L 996 416 L 1004 416 Z" fill="#16a34a" />
                    </g>

                    <g filter="url(#drop-shadow)" class="cursor-pointer transition-opacity duration-300 hover:opacity-80" @click="view = 'muslim'">
                        <!-- Grid Kavling Muslim -->
                        @php
                        $kavlingMuslim = 1;
                        $rows = 4;
                        $cols = 10;
                        $blockHeight = 80;
                        $blockWidth = 450;
                        $cellWidth = $blockWidth / $cols;
                        $cellHeight = $blockHeight / $rows;
                        @endphp
                        @for($block = 0; $block < 4; $block++)
                            @php
                            $yStart = [50, 190, 290, 440][$block];
                            $height = [80, 80, 90, 150][$block];
                            $rows = ceil($height / 20); // approximate rows
                            @endphp
                            @for($r = 0; $r < $rows; $r++)
                                @for($c = 0; $c < $cols; $c++)
                                    @if($kavlingMuslim <= 100) <!-- Limit to 100 -->
                                        @php $nomorFormatted = 'A-' . str_pad($kavlingMuslim, 3, '0', STR_PAD_LEFT); @endphp
                                        <rect x="{{ 80 + $c * $cellWidth }}" y="{{ $yStart + $r * $cellHeight }}" width="{{ $cellWidth }}" height="{{ $cellHeight }}" 
                                              fill="url(#muslimGrad)" stroke="#10b981" stroke-width="0.3" rx="2" 
                                              class="cursor-pointer hover:fill-emerald-100 transition-all" 
                                              @click="selectedKavling = '{{ $nomorFormatted }}'">
                                            <title>Kavling {{ $nomorFormatted }}</title>
                                        </rect>
                                        @if(in_array($nomorFormatted, $reservedKavlings))
                                        <text x="{{ 80 + $c * $cellWidth + $cellWidth/2 }}" y="{{ $yStart + $r * $cellHeight + $cellHeight/2 }}" text-anchor="middle" dominant-baseline="middle" font-size="4" fill="#065f46" class="pointer-events-none" font-family="Inter">{{ $nomorFormatted }}</text>
                                        @endif
                                        @php $kavlingMuslim++; @endphp
                                    @endif
                                @endfor
                            @endfor
                        @endfor
                    </g>

                    <g filter="url(#drop-shadow)" class="cursor-pointer transition-opacity duration-300 hover:opacity-80" @click="view = 'non_muslim'">
                        <!-- Grid Kavling Non-Muslim -->
                        @php
                        $kavlingNonMuslim = 101;
                        $blocks = [
                            ['x' => 670, 'y' => 50, 'w' => 200, 'h' => 80],
                            ['x' => 890, 'y' => 50, 'w' => 230, 'h' => 80],
                            ['x' => 670, 'y' => 190, 'w' => 450, 'h' => 190],
                            ['x' => 670, 'y' => 440, 'w' => 450, 'h' => 150]
                        ];
                        @endphp
                        @foreach($blocks as $b)
                            @php
                            $cols = ceil($b['w'] / 30);
                            $rows = ceil($b['h'] / 20);
                            $cellW = $b['w'] / $cols;
                            $cellH = $b['h'] / $rows;
                            @endphp
                            @for($r = 0; $r < $rows; $r++)
                                @for($c = 0; $c < $cols; $c++)
                                    @if($kavlingNonMuslim <= 200)
                                        @php $nomor = $kavlingNonMuslim - 100; $nomorFormatted = 'B-' . str_pad($nomor, 3, '0', STR_PAD_LEFT); @endphp
                                        <rect x="{{ $b['x'] + $c * $cellW }}" y="{{ $b['y'] + $r * $cellH }}" width="{{ $cellW }}" height="{{ $cellH }}" 
                                              fill="url(#nonmuslimGrad)" stroke="#f59e0b" stroke-width="0.3" rx="2" 
                                              class="cursor-pointer hover:fill-amber-100 transition-all" 
                                              @click="selectedKavling = '{{ $nomorFormatted }}'">
                                            <title>Kavling {{ $nomorFormatted }}</title>
                                        </rect>
                                        @if(in_array($nomorFormatted, $reservedKavlings))
                                        <text x="{{ $b['x'] + $c * $cellW + $cellW/2 }}" y="{{ $b['y'] + $r * $cellH + $cellH/2 }}" text-anchor="middle" dominant-baseline="middle" font-size="4" fill="#92400e" class="pointer-events-none" font-family="Inter">{{ $nomorFormatted }}</text>
                                        @endif
                                        @php $kavlingNonMuslim++; @endphp
                                    @endif
                                @endfor
                            @endfor
                        @endforeach
                    </g>

                    <circle cx="50" cy="150" r="15" fill="#10B981" opacity="0.8"/>
                    <circle cx="50" cy="400" r="15" fill="#10B981" opacity="0.8"/>
                    <circle cx="570" cy="100" r="18" fill="#059669" opacity="0.9"/>
                    <circle cx="570" cy="250" r="14" fill="#34D399" opacity="0.9"/>
                    <circle cx="570" cy="400" r="20" fill="#059669" opacity="0.9"/>
                    <circle cx="570" cy="550" r="16" fill="#10B981" opacity="0.9"/>
                    <circle cx="1150" cy="150" r="15" fill="#10B981" opacity="0.8"/>
                    <circle cx="1150" cy="400" r="15" fill="#10B981" opacity="0.8"/>
                    <circle cx="630" cy="100" r="18" fill="#059669" opacity="0.9"/>
                    <circle cx="630" cy="250" r="14" fill="#34D399" opacity="0.9"/>
                    <circle cx="630" cy="400" r="20" fill="#059669" opacity="0.9"/>
                    <circle cx="630" cy="550" r="16" fill="#10B981" opacity="0.9"/>
                    <circle cx="450" cy="650" r="25" fill="#059669" opacity="0.9"/>
                    <circle cx="490" cy="680" r="15" fill="#34D399" opacity="0.9"/>
                    <circle cx="750" cy="650" r="25" fill="#059669" opacity="0.9"/>
                    <circle cx="710" cy="680" r="15" fill="#34D399" opacity="0.9"/>
                </svg>

                <div class="absolute inset-0 bg-slate-900/10 pointer-events-none transition-opacity duration-500" :class="view === 'semua' ? 'opacity-0' : 'opacity-30'"></div>

                <div class="absolute top-[25%] left-[20%] md:left-[25%] flex flex-col items-center transition-all duration-700 pointer-events-none"
                     :class="{
                        'opacity-100 scale-100': view === 'semua' || view === 'muslim',
                        'opacity-0 scale-75 blur-sm': view === 'non_muslim'
                     }">
                    <div class="bg-white/90 backdrop-blur-md border border-emerald-100 shadow-xl px-4 md:px-6 py-2 md:py-3 rounded-2xl flex flex-col items-center pointer-events-auto cursor-pointer hover:scale-105 transition-transform" @click="view = 'muslim'">
                        <span class="text-emerald-600 text-[8px] md:text-[10px] font-black uppercase tracking-[0.2em] mb-0.5">Kawasan Syariat</span>
                        <span class="text-slate-900 font-black text-sm md:text-lg font-poppins">Cluster Muslim</span>
                    </div>
                    <div class="w-1 h-8 bg-emerald-500/50 mt-1 rounded-full"></div>
                    <div class="w-3 h-3 bg-emerald-500 rounded-full animate-pulse"></div>
                </div>

                <div class="absolute top-[30%] right-[15%] md:right-[25%] flex flex-col items-center transition-all duration-700 pointer-events-none"
                     :class="{
                        'opacity-100 scale-100': view === 'semua' || view === 'non_muslim',
                        'opacity-0 scale-75 blur-sm': view === 'muslim'
                     }">
                    <div class="bg-white/90 backdrop-blur-md border border-amber-100 shadow-xl px-4 md:px-6 py-2 md:py-3 rounded-2xl flex flex-col items-center pointer-events-auto cursor-pointer hover:scale-105 transition-transform" @click="view = 'non_muslim'">
                        <span class="text-amber-600 text-[8px] md:text-[10px] font-black uppercase tracking-[0.2em] mb-0.5">Kawasan Universal</span>
                        <span class="text-slate-900 font-black text-sm md:text-lg font-poppins">Cluster Non-Muslim</span>
                    </div>
                    <div class="w-1 h-8 bg-amber-500/50 mt-1 rounded-full"></div>
                    <div class="w-3 h-3 bg-amber-500 rounded-full animate-pulse"></div>
                </div>

                <div class="absolute bottom-6 left-6 md:bottom-10 md:left-10 bg-white/95 backdrop-blur-md border border-white p-5 rounded-3xl shadow-2xl max-w-[260px] md:max-w-sm transform transition-all duration-500"
                     x-show="view !== 'semua'" 
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-8"
                     style="display: none;">
                    
                    <div class="w-10 h-10 rounded-full flex items-center justify-center mb-3" :class="view === 'muslim' ? 'bg-emerald-100' : 'bg-amber-100'">
                        <span class="material-icons" :class="view === 'muslim' ? 'text-emerald-600' : 'text-amber-600'" x-text="view === 'muslim' ? 'mosque' : 'account_balance'"></span>
                    </div>
                    <h3 class="font-poppins font-black text-slate-900 text-base md:text-xl mb-2" x-text="view === 'muslim' ? 'Cluster Muslim' : 'Cluster Non-Muslim'"></h3>
                    <p class="text-xs md:text-sm text-slate-500 font-inter leading-relaxed mb-4" 
                       x-text="view === 'muslim' ? 'Desain blok rapat menghadap kiblat dengan presisi. Dipisahkan oleh jalan utama yang rindang, menjaga kesucian dan ketenangan area.' : 'Desain blok luas untuk makam keluarga dan VIP. Bebas mengatur arsitektur makam dengan estetika universal yang mewah.'">
                    </p>
                    <a href="#tipe-kavling" class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-slate-900 hover:underline">
                        Pesan Sekarang <span class="material-icons text-[14px]">arrow_forward</span>
                    </a>
                </div>
            </div>
            
            <!-- Info Kavling Terpilih -->
            <div x-show="selectedKavling" 
                 x-transition 
                 class="mt-4 bg-white p-4 rounded-xl shadow-md border border-slate-200 max-w-md mx-auto text-center">
                <h3 class="font-bold text-slate-900">Kavling Terpilih</h3>
                <p class="text-slate-600" x-text="selectedKavling"></p>
                <button @click="selectedKavling = null" class="mt-2 text-sm text-slate-500 hover:text-slate-700">Tutup</button>
            </div>
        </div>

        <div id="fasilitas">
            <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 md:mb-14 gap-6">
                <div>
                    <span data-aos="fade-up" class="text-emerald-600 font-bold tracking-[0.2em] uppercase text-xs mb-3 block">Keunggulan</span>
                    <h2 data-aos="fade-up" data-aos-delay="100" class="text-3xl md:text-5xl font-black text-slate-900 mt-2 leading-tight max-w-md font-poppins">Standar Perawatan</h2>
                </div>
                <p data-aos="fade-up" data-aos-delay="200" class="text-slate-500 max-w-sm text-sm md:text-base leading-relaxed md:text-right font-inter">
                    Setiap jengkal tanah dirawat sepenuh hati. Memberikan kedamaian abadi bagi mereka dan ketenangan bagi keluarga yang ditinggalkan.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-4 md:gap-6 lg:gap-8">
                @php
                $features = [
                    ['icon' => 'security',        'title' => 'Keamanan 24 Jam',    'desc' => 'Pemantauan CCTV terintegrasi dan patroli rutin petugas keamanan.'],
                    ['icon' => 'mosque',          'title' => 'Fasilitas Ibadah',   'desc' => 'Tersedia Mushola internal dan area khusus peziarah yang nyaman.'],
                    ['icon' => 'nature',          'title' => 'Perawatan Lanskap',  'desc' => 'Tim hortikultura menjaga keasrian rumput dan pohon setiap harinya.'],
                    ['icon' => 'gavel',           'title' => 'Legalitas Aman',     'desc' => 'Dokumen kepemilikan transparan, legal, dan dapat diwariskan.'],
                    ['icon' => 'local_parking',   'title' => 'Akses & Parkir',     'desc' => 'Jalan utama lebar dengan area parkir khusus keluarga besar.'],
                    ['icon' => 'support_agent',   'title' => 'Layanan Konsultan',  'desc' => 'Pendampingan penuh dari proses pemilihan kavling hingga pemakaman.'],
                ];
                @endphp

                @foreach($features as $i => $f)
                <div data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 100 }}"
                     class="group p-6 md:p-8 rounded-2xl md:rounded-3xl border border-slate-100 hover:border-emerald-200 hover:shadow-xl transition-all duration-500 hover:-translate-y-1 bg-white relative overflow-hidden flex flex-col">
                    <div class="w-14 h-14 rounded-2xl bg-slate-50 flex items-center justify-center mb-6 group-hover:bg-emerald-50 transition-colors duration-300">
                        <span class="material-icons text-slate-400 group-hover:text-emerald-600 transition-colors text-2xl">{{ $f['icon'] }}</span>
                    </div>
                    <h3 class="font-poppins font-black text-slate-900 text-lg mb-2">{{ $f['title'] }}</h3>
                    <p class="text-sm text-slate-500 leading-relaxed font-inter">{{ $f['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
        
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     KEUNGGULAN / FASILITAS
     ═══════════════════════════════════════════════════════════════ --}}
<section class="py-16 md:py-24 px-4 md:px-8 xl:px-24 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 md:mb-16 gap-6">
            <div>
                <span data-aos="fade-up" class="text-primary font-bold tracking-widest uppercase text-xs">Mengapa Kami</span>
                <h2 data-aos="fade-up" data-aos-delay="100" class="text-3xl md:text-5xl font-bold mt-2 leading-tight max-w-md">Standar Perawatan yang Tak Tertandingi</h2>
            </div>
            <p data-aos="fade-up" data-aos-delay="200" class="text-gray-500 max-w-sm text-sm leading-relaxed md:text-right">
                Setiap detail dirancang untuk memberikan ketenangan bagi keluarga yang Anda kasihi.
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
            @php
            $features = [
                ['icon' => 'security',        'title' => 'Keamanan 24 Jam',         'desc' => 'Sistem CCTV terintegrasi dan petugas keamanan berjaga sepanjang waktu tanpa henti.'],
                ['icon' => 'mosque',          'title' => 'Fasilitas Ibadah',         'desc' => 'Mushola internal dan area wudu tersedia di dalam kawasan untuk kemudahan beribadah.'],
                ['icon' => 'nature',          'title' => 'Taman Hijau Terawat',      'desc' => 'Tim hortikultura profesional merawat setiap tanaman dan lanskap setiap hari.'],
                ['icon' => 'gavel',           'title' => 'Legalitas Lengkap',        'desc' => 'Sertifikat kavling resmi dan dokumen legal yang transparan dan dapat diverifikasi.'],
                ['icon' => 'local_parking',   'title' => 'Parkir Luas',              'desc' => 'Area parkir yang memadai untuk ratusan kendaraan keluarga yang berkunjung.'],
                ['icon' => 'support_agent',   'title' => 'Layanan Keluarga',         'desc' => 'Tim konsultan siap mendampingi seluruh proses dari pemilihan hingga selesai.'],
            ];
            @endphp

            @foreach($features as $i => $f)
            <div data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 100 }}"
                 class="group p-5 md:p-7 rounded-3xl border border-gray-100 hover:border-primary/30 hover:shadow-xl transition-all duration-500 hover:-translate-y-1 bg-white relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500 rounded-3xl"></div>
                <div class="relative z-10">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-2xl bg-gray-100 flex items-center justify-center mb-4 md:mb-5 group-hover:bg-primary/10 transition-colors">
                        <span class="material-icons text-gray-600 group-hover:text-primary transition-colors">{{ $f['icon'] }}</span>
                    </div>
                    <h3 class="font-bold text-gray-900 text-base md:text-lg mb-2">{{ $f['title'] }}</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">{{ $f['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     TESTIMONIAL (Kompak ala Marketplace / Review Premium)
     ═══════════════════════════════════════════════════════════════ --}}
<section class="py-16 md:py-24 px-4 md:px-8 xl:px-24 bg-[#FDFCFB] relative overflow-hidden font-inter">
    
    <div class="absolute top-0 right-0 w-full h-full bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-slate-100 via-transparent to-transparent opacity-50 pointer-events-none -z-10"></div>

    <div class="max-w-7xl mx-auto relative z-10">
        
        <div class="text-center mb-12 md:mb-16">
            <span data-aos="fade-up" class="text-emerald-600 font-bold tracking-[0.2em] uppercase text-xs mb-3 block">Testimoni</span>
            <h2 data-aos="fade-up" data-aos-delay="100" class="text-3xl md:text-4xl font-black text-slate-900 font-poppins">
                Kepercayaan Keluarga
            </h2>
            <p data-aos="fade-up" data-aos-delay="200" class="text-slate-500 mt-3 text-sm md:text-base max-w-2xl mx-auto">
                Pengalaman nyata dari keluarga yang telah mempercayakan peristirahatan terakhir orang terkasih mereka kepada Mount Carmel.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
            
            @php
            $reviews = [
                [
                    'name' => 'Samira Hadid',
                    'date' => '2 Bulan yang lalu',
                    'text' => '"Pelayanannya sangat tenang dan penuh hormat. Layanan dari tim memuaskan sekali, membantu kami di masa berduka dengan sangat profesional."',
                    'stars' => 5
                ],
                [
                    'name' => 'Juliana Silva',
                    'date' => '4 Bulan yang lalu',
                    'text' => '"Fasilitasnya sangat luar biasa, penataannya sangat rapi dan hijau. Memberi ketenangan tersendiri setiap kali kami datang berziarah."',
                    'stars' => 5
                ],
                [
                    'name' => 'Mariana Napolitani',
                    'date' => '1 Tahun yang lalu',
                    'text' => '"Keluarga merasa sangat dihargai dan dibantu. Kawasannya benar-benar damai dan indah. Legalitasnya juga sangat jelas dan transparan."',
                    'stars' => 5
                ],
                [
                    'name' => 'Keluarga Wijaya',
                    'date' => '3 Minggu yang lalu',
                    'text' => '"Sangat merekomendasikan Cluster Madinah. Orientasi kiblatnya presisi dan suasananya sangat mendukung untuk berdoa dengan khusyuk."',
                    'stars' => 5
                ],
                [
                    'name' => 'Bapak Hadi',
                    'date' => '5 Bulan yang lalu',
                    'text' => '"Pilihan yang sangat bijak untuk warisan ketenangan keluarga. Proses pembayarannya mudah dan timnya sangat responsif menjawab pertanyaan."',
                    'stars' => 5
                ],
                [
                    'name' => 'Anita & Keluarga',
                    'date' => '8 Bulan yang lalu',
                    'text' => '"Awalnya ragu membeli secara pre-need, tapi setelah melihat langsung perawatannya yang sangat baik setiap hari, kami merasa tenang."',
                    'stars' => 5
                ]
            ];
            @endphp

            @foreach($reviews as $i => $review)
            <div data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 100 }}" 
                 class="bg-white p-6 md:p-8 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:border-slate-200 transition-all duration-300 flex flex-col group">
                
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full overflow-hidden bg-slate-100 border border-slate-200 shrink-0 group-hover:scale-105 transition-transform">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($review['name']) }}&background=047857&color=fff&font-size=0.4" alt="{{ $review['name'] }}" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h4 class="font-poppins font-bold text-slate-900 text-sm md:text-base">{{ $review['name'] }}</h4>
                            <p class="text-[10px] md:text-xs text-slate-400 font-medium">{{ $review['date'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-1 mb-4">
                    @for($j = 0; $j < $review['stars']; $j++)
                        <span class="material-icons text-amber-400 text-base md:text-lg">star</span>
                    @endfor
                </div>

                <p class="text-sm text-slate-600 leading-relaxed font-inter italic flex-grow">
                    {{ $review['text'] }}
                </p>
            </div>
            @endforeach

        </div>


    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     PROSES PEMESANAN
     ═══════════════════════════════════════════════════════════════ --}}

<section class="py-16 md:py-24 px-4 md:px-8 xl:px-24 bg-white">
    <div class="max-w-7xl mx-auto">
        <div class="text-center mb-10 md:mb-16">
            <span data-aos="fade-up" class="text-primary font-bold tracking-widest uppercase text-xs">Cara Memesan</span>
            <h2 data-aos="fade-up" data-aos-delay="100" class="text-3xl md:text-5xl font-bold mt-2 leading-tight">Proses Mudah & Transparan</h2>
        </div>

        <div class="relative">
            <div class="hidden md:block absolute top-10 left-[12.5%] right-[12.5%] h-px bg-gradient-to-r from-transparent via-gray-200 to-transparent z-0"></div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 md:gap-8 relative z-10">
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
                    <div class="w-14 h-14 md:w-20 md:h-20 rounded-full border-2 border-gray-100 bg-white shadow-lg flex items-center justify-center mb-4 md:mb-5 relative group hover:border-primary transition-colors duration-300">
                        <span class="material-icons text-gray-400 group-hover:text-primary transition-colors text-xl md:text-2xl">{{ $step['icon'] }}</span>
                        <span class="absolute -top-2 -right-2 w-5 h-5 md:w-6 md:h-6 bg-primary text-gray-900 text-[10px] md:text-xs font-black rounded-full flex items-center justify-center">{{ $step['no'] }}</span>
                    </div>
                    <h3 class="font-bold text-gray-900 mb-1 md:mb-2 text-sm md:text-base">{{ $step['title'] }}</h3>
                    <p class="text-xs md:text-sm text-gray-500 leading-relaxed">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>

        <div data-aos="fade-up" class="text-center mt-10 md:mt-14">
            <a href="{{ url('/register') }}"
               class="btn-press btn-ripple inline-flex items-center gap-2 px-6 md:px-8 py-3 md:py-4 bg-gray-900 text-white font-bold rounded-full hover:bg-gray-800 transition-colors shadow-lg">
                Mulai Sekarang <span class="material-icons text-sm">arrow_forward</span>
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     FAQ
     ═══════════════════════════════════════════════════════════════ --}}
     
<section class="py-16 md:py-24 px-4 md:px-8 xl:px-24 bg-gray-50">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-10 md:mb-14">
            <span data-aos="fade-up" class="text-primary font-bold tracking-widest uppercase text-xs">FAQ</span>
            <h2 data-aos="fade-up" data-aos-delay="100" class="text-3xl md:text-5xl font-bold mt-2 leading-tight">Pertanyaan yang Sering Ditanyakan</h2>
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
                 class="faq-item bg-white border border-gray-100 rounded-2xl overflow-hidden">
                <button onclick="toggleFaq(this)"
                        class="w-full flex items-center justify-between px-5 md:px-7 py-4 md:py-5 text-left gap-4">
                    <span class="font-semibold text-gray-900 text-sm md:text-base">{{ $faq['q'] }}</span>
                    <span class="material-icons faq-icon text-gray-400 shrink-0">add</span>
                </button>
                <div class="faq-answer px-5 md:px-7 pb-0">
                    <p class="text-sm text-gray-500 leading-relaxed pb-5">{{ $faq['a'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<script>
function toggleFaq(btn) {
    const item = btn.closest('.faq-item');
    const isOpen = item.classList.contains('open');
    document.querySelectorAll('.faq-item.open').forEach(el => el.classList.remove('open'));
    if (!isOpen) item.classList.add('open');
}
</script>

@endsection