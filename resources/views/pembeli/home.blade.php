@extends('layouts.master')

@section('title', 'Beranda - Mount Carmel Cluster')

@section('content')

@php
$reservedLahans = $reservedLahans ?? [];
@endphp

{{-- External Home Styles --}}
<link rel="stylesheet" href="{{ asset('css/home.css') }}"/>
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
    
    <video autoplay loop muted playsinline class="w-full h-full object-cover object-center transform transition-transform duration-700 group-hover:scale-105">
        <source src="{{ asset('storage/assets/Profile-MC.mp4') }}" type="video/mp4" />
        Browser Anda tidak mendukung pemutaran video.
    </video>
            
            {{-- Floating cards: hanya tampil di md ke atas --}}
            <div data-aos="fade-right" data-aos-delay="500" class="hero-float-card absolute bottom-8 left-8 bg-white/90 backdrop-blur-md p-6 rounded-2xl shadow-lg max-w-sm transition-transform hover:-translate-y-2 cursor-pointer btn-press">
                <img alt="Pratinjau cluster" class="w-full h-40 object-cover rounded-xl mb-4" src="/storage/assets/cluster-hero.jpg" />
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-gray-900">Lihat Semua Cluster</span>
                    <span class="material-icons text-gray-500">arrow_forward</span>
                </div>
            </div>
            
            <div data-aos="fade-left" data-aos-delay="700" class="hero-float-card absolute bottom-32 right-8 bg-white/90 backdrop-blur-md p-6 rounded-2xl shadow-lg max-w-sm transition-transform hover:-translate-y-2 cursor-pointer btn-press">
                <img alt="Pratinjau layanan" class="w-full h-40 object-cover rounded-xl mb-4" src="/storage/assets/Marketing.jpg" />
                <div class="flex justify-between items-center">
                    <span class="font-semibold text-gray-900">Layanan Kami</span>
                    <span class="material-icons text-gray-500">arrow_forward</span>
                </div>
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
                ['value' => '2',      'label' => 'Cluster Tersedia',      'accent' => 'text-amber-600'],
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
                <img data-aos="fade-up" data-aos-delay="100" alt="Jalur penuh ketenangan" class="w-1/2 h-44 md:h-64 object-cover rounded-2xl shadow-md" src="storage/assets/cluster-hero.jpg" />
                <img data-aos="fade-up" data-aos-delay="200" alt="Alam tenang" class="w-1/2 h-44 md:h-64 object-cover rounded-2xl shadow-md" src="storage/assets/tipe/non-muslim.png" />
            </div>
        </div>
        <div class="md:w-1/2 flex flex-col items-start md:items-end gap-6 md:gap-0">
            <button type="button" data-aos="fade-left" onclick="openTipeModal()" class="btn-ripple btn-press px-6 md:px-8 py-3 md:py-4 bg-[#800000] text-white font-semibold rounded-full hover:bg-[#800000]/90 transition-colors md:mb-16 shadow-md inline-block">
                Pelajari Lebih Lanjut
            </button>
            <p data-aos="fade-left" data-aos-delay="100" class="text-gray-600 leading-relaxed max-w-md md:text-right md:mb-12">
                Lanskap dibentuk dengan metode berdampak rendah yang memeluk kontur alami tanah.
            </p>
            <img data-aos="zoom-in-up" data-aos-delay="200" alt="Taman damai" class="w-full h-56 md:h-80 object-cover rounded-2xl shadow-lg" src="storage/assets/tipe/barokah.png" />
        </div>
    </div>
    <hr class="mt-16 md:mt-32 border-gray-200 max-w-7xl mx-auto" />
</section>

{{-- ═══════════════════════════════════════════════════════════════
     MARQUEE
     ══════════════════════════════════════�{{-- Leaflet.js for Interactive Map --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<section class="py-16 md:py-24 px-4 md:px-8 xl:px-24 bg-[#FDFCFB] relative overflow-hidden font-inter">
    <div class="max-w-7xl mx-auto">
        <div class="mb-10">
            <div class="max-w-2xl mb-6">
                <span data-aos="fade-up" class="text-emerald-600 font-bold tracking-[0.2em] uppercase text-xs mb-3 block">Interactive Masterplan</span>
                <h2 data-aos="fade-up" data-aos-delay="100" class="text-3xl md:text-5xl font-black text-slate-900 font-poppins leading-tight">
                    Tata Letak Harmonis
                </h2>
                <p data-aos="fade-up" data-aos-delay="200" class="text-slate-500 mt-4 text-sm md:text-base leading-relaxed">
                    Peta interaktif kawasan Mount Carmel. Klik pada petak lahan untuk melihat detail dan melakukan pemesanan langsung.
                </p>
            </div>
            
            {{-- Legend --}}
            <div data-aos="fade-up" data-aos-delay="300" class="flex flex-wrap gap-4 md:gap-8 mb-8">
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded bg-[#6EE7B7] shadow-sm border border-emerald-600/10"></div>
                    <span class="text-xs font-semibold text-slate-500">Tersedia</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded bg-[#FCD34D] shadow-sm border border-amber-600/10"></div>
                    <span class="text-xs font-semibold text-slate-500">Reservasi</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-4 h-4 rounded bg-[#CBD5E1] shadow-sm border border-slate-600/10"></div>
                    <span class="text-xs font-semibold text-slate-500">Terjual</span>
                </div>
            </div>
        </div>

        <div data-aos="zoom-in" data-aos-delay="400" id="masterplan-map" class="w-full h-[500px] md:h-[700px] rounded-3xl md:rounded-[3rem] border-8 border-white shadow-2xl overflow-hidden bg-slate-100 z-10"></div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // 1. Initialize Map
    const map = L.map('masterplan-map', {
        crs: L.CRS.Simple,
        minZoom: -1,
        maxZoom: 2,
        attributionControl: false,
        zoomControl: false,
        renderer: L.canvas() // Use canvas for high performance
    });

    L.control.zoom({ position: 'bottomright' }).addTo(map);

    // 2. Set Bounds & Background
    const w = 2000, h = 1500;
    const bounds = [[0, 0], [h, w]];
    const image = L.imageOverlay('{{ asset("storage/assets/masterplan.png") }}', bounds).addTo(map);
    map.fitBounds(bounds);

    // 3. Data Preparation
    const lahanMuslim = @json($lahanMuslim);
    const lahanNonMuslim = @json($lahanNonMuslim);

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(number);
    }

    function addPlot(l, y, x, sizeW, sizeH) {
        const color = l.status === 'Tersedia' ? '#6EE7B7' : (l.status.includes('Reservasi') ? '#FCD34D' : '#CBD5E1');
        const rect = L.rectangle([[y, x], [y + sizeH, x + sizeW]], {
            color: 'white',
            weight: 0.5,
            fillColor: color,
            fillOpacity: 0.8,
            interactive: true
        }).addTo(map);

        const popupContent = `
            <div class="p-2 min-w-[200px]">
                <div class="flex items-center gap-2 mb-2">
                    <span class="w-2 h-2 rounded-full" style="background: ${color}"></span>
                    <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">${l.status}</span>
                </div>
                <h4 class="font-black text-slate-900 text-lg mb-1">${l.nomor_lahan}</h4>
                <div class="space-y-1 mb-3 text-[11px]">
                    <div class="flex justify-between"><span>Tipe:</span><b>${l.tipe_lahan}</b></div>
                    <div class="flex justify-between"><span>Ukuran:</span><b>${l.ukuran}</b></div>
                    <div class="flex justify-between text-emerald-600 font-bold"><span>Harga:</span><span>${formatRupiah(l.harga)}</span></div>
                </div>
                ${l.status === 'Tersedia' 
                    ? `<a href="{{ url('/register') }}?lahan_id=${l.id}" class="block w-full py-2 bg-[#800000] text-white text-center rounded-lg text-xs font-bold hover:bg-[#800000]/80 transition-colors">Pesan Sekarang</a>`
                    : `<button disabled class="block w-full py-2 bg-slate-100 text-slate-400 rounded-lg text-xs font-bold cursor-not-allowed">Tidak Tersedia</button>`
                }
            </div>
        `;

        rect.bindPopup(popupContent, { maxWidth: 300, className: 'custom-popup' });
        
        rect.on('mouseover', function() { this.setStyle({ fillOpacity: 1, weight: 2 }); });
        rect.on('mouseout', function() { this.setStyle({ fillOpacity: 0.8, weight: 0.5 }); });
    }

    // 4. Render plots (Muslim Cluster)
    const sectorsM = [
        { y: 800, x: 1200 },
        { y: 500, x: 1200 },
        { y: 200, x: 1200 }
    ];

    lahanMuslim.forEach(l => {
        const match = l.nomor_lahan.match(/\d+$/);
        if (match) {
            const num = parseInt(match[0], 10);
            if (num >= 1 && num <= 120) {
                const globalIndex = num - 1;
                const sectorIndex = Math.floor(globalIndex / 40);
                const inSectorIndex = globalIndex % 40;
                const r = Math.floor(inSectorIndex / 8);
                const c = inSectorIndex % 8;
                
                const s = sectorsM[sectorIndex];
                if (s) {
                    addPlot(l, s.y + r*35, s.x + c*55, 50, 30);
                }
            }
        }
    });

    // 5. Render plots (Non-Muslim Cluster)
    const sectorsNM = [
        { y: 800, x: 200 },
        { y: 500, x: 200 },
        { y: 800, x: 700 }
    ];

    lahanNonMuslim.forEach(l => {
        const match = l.nomor_lahan.match(/\d+$/);
        if (match) {
            const num = parseInt(match[0], 10);
            if (num >= 1 && num <= 120) {
                const globalIndex = num - 1;
                const sectorIndex = Math.floor(globalIndex / 40);
                const inSectorIndex = globalIndex % 40;
                const r = Math.floor(inSectorIndex / 8);
                const c = inSectorIndex % 8;
                
                const s = sectorsNM[sectorIndex];
                if (s) {
                    addPlot(l, s.y + r*35, s.x + c*55, 50, 30);
                }
            }
        }
    });

    // 6. Add Facility Markers (Gerbang Masuk, Pos Security, Kantor Marketing)
    const facilities = [
        {
            y: 1150,
            x: 950,
            title: "Gerbang Masuk & Pos Security",
            desc: "Akses masuk utama kawasan Mount Carmel dengan penjagaan keamanan 24 jam.",
            icon: "shield-fill-check"
        },
        {
            y: 1150,
            x: 1080,
            title: "Kantor Marketing & Layanan Pelanggan",
            desc: "Pusat informasi, administrasi, dan layanan reservasi lahan.",
            icon: "building-fill"
        }
    ];

    facilities.forEach(f => {
        const customIcon = L.divIcon({
            className: 'custom-facility-icon',
            html: `<div class="w-10 h-10 rounded-full bg-[#800000] text-white flex items-center justify-center shadow-lg border-2 border-white hover:scale-110 transition-transform cursor-pointer"><i class="bi bi-${f.icon} text-lg"></i></div>`,
            iconSize: [40, 40],
            iconAnchor: [20, 20]
        });

        const marker = L.marker([f.y, f.x], { icon: customIcon }).addTo(map);
        marker.bindPopup(`
            <div class="p-2 min-w-[200px]">
                <h4 class="font-black text-slate-900 text-sm mb-1">${f.title}</h4>
                <p class="text-[11px] text-slate-500 leading-relaxed">${f.desc}</p>
            </div>
        `, { className: 'custom-popup' });
    });
});
</script>

<style>
    .custom-popup .leaflet-popup-content-wrapper {
        border-radius: 1.5rem;
        padding: 0.5rem;
        box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1);
    }
    .custom-popup .leaflet-popup-tip {
        display: none;
    }
    .leaflet-div-icon.custom-facility-icon {
        background: transparent !important;
        border: none !important;
    }
</style>

<section class="py-16 md:py-24 px-4 md:px-8 xl:px-24 bg-white border-t border-slate-100/60">
    <div class="max-w-7xl mx-auto">
        <div id="fasilitas">
            <div class="flex flex-col items-center text-center max-w-2xl mx-auto mb-12 md:mb-16 gap-4">
                <span data-aos="fade-up" class="text-emerald-600 font-bold tracking-[0.2em] uppercase text-xs block">Keunggulan</span>
                <h2 data-aos="fade-up" data-aos-delay="100" class="text-3xl md:text-5xl font-black text-slate-900 leading-tight font-poppins">
                    Standar Perawatan
                </h2>
                <p data-aos="fade-up" data-aos-delay="200" class="text-slate-500 text-sm md:text-base leading-relaxed font-inter">
                    Setiap jengkal tanah dirawat sepenuh hati. Memberikan kedamaian abadi bagi mereka dan ketenangan bagi keluarga yang ditinggalkan.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8">
                @php
                $features = [
                    [
                        'icon' => 'security',
                        'title' => 'Keamanan 24 Jam',
                        'desc' => 'Pemantauan CCTV terintegrasi dan patroli rutin petugas keamanan di seluruh kawasan.',
                        'img' => asset('storage/assets/keamanan.png')
                    ],
                    [
                        'icon' => 'mosque',
                        'title' => 'Fasilitas Ibadah',
                        'desc' => 'Tersedia Mushola internal yang tenang dan area khusus peziarah yang teduh.',
                        'img' => asset('storage/assets/ibadah.png')
                    ],
                    [
                        'icon' => 'nature',
                        'title' => 'Perawatan Lanskap',
                        'desc' => 'Tim hortikultura profesional menjaga kerapian rumput dan keasrian pohon setiap hari.',
                        'img' => asset('storage/assets/lanskap.png')
                    ],
                    [
                        'icon' => 'gavel',
                        'title' => 'Legalitas Aman',
                        'desc' => 'Dokumen kepemilikan transparan, legal, terjamin, dan dapat diwariskan secara sah.',
                        'img' => asset('storage/assets/legalitas.png')
                    ],
                    [
                        'icon' => 'local_parking',
                        'title' => 'Akses & Parkir',
                        'desc' => 'Jalan utama beraspal lebar dengan area parkir khusus untuk rombongan keluarga besar.',
                        'img' => asset('storage/assets/akses.png')
                    ],
                    [
                        'icon' => 'support_agent',
                        'title' => 'Layanan Konsultan',
                        'desc' => 'Pendampingan tulus dari konsultan keluarga mulai dari pemilihan lahan hingga prosesi pemakaman.',
                        'img' => asset('storage/assets/konsultan.png')
                    ],
                ];
                @endphp

                @foreach($features as $i => $f)
                <div data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 100 }}"
                     class="group bg-white rounded-3xl border border-slate-100/80 overflow-hidden shadow-sm hover:shadow-2xl hover:border-slate-200/80 transition-all duration-500 flex flex-col hover:-translate-y-1">
                    
                    {{-- Photo with scale zoom effect --}}
                    <div class="relative w-full h-48 overflow-hidden shrink-0">
                        <img src="{{ $f['img'] }}" alt="{{ $f['title'] }}" class="w-full h-full object-cover transform transition-transform duration-700 group-hover:scale-105">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent"></div>
                        
                        {{-- Floating Icon with color transition --}}
                        <div class="absolute bottom-4 left-4 w-12 h-12 bg-white/90 backdrop-blur-sm rounded-2xl flex items-center justify-center shadow-md group-hover:bg-[#800000] group-hover:text-white transition-all duration-300">
                            <span class="material-icons text-slate-700 group-hover:text-white transition-colors text-xl">{{ $f['icon'] }}</span>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-6 md:p-8 flex-grow flex flex-col justify-between">
                        <div class="space-y-3">
                            <h3 class="font-poppins font-bold text-slate-800 text-base md:text-lg group-hover:text-[#800000] transition-colors duration-300">{{ $f['title'] }}</h3>
                            <p class="text-xs md:text-sm text-slate-500 leading-relaxed font-inter">{{ $f['desc'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════
     TESTIMONIAL 
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
                    ['no' => '02', 'icon' => 'edit_note',    'title' => 'Pilih Tipe Pemakaman',       'desc' => 'Memilih makam yang sesuai dengan kebutuhan anda.'],
                    ['no' => '03', 'icon' => 'edit_note',    'title' => 'Pilih Nomor Kavling',       'desc' => 'Memilih nomor kavling yang sesuai dengan kebutuhan anda.'],
                    ['no' => '04', 'icon' => 'edit_note',    'title' => 'Lengkapi Data Reservasi',       'desc' => 'Melengkapi data reservasi dan upload dokumen yang diperlukan secara online.'],
                    ['no' => '05', 'icon' => 'payments',     'title' => 'Lakukan Pembayaran', 'desc' => 'Pilih metode pembayaran yang nyaman dan kirim bukti transfer.'],
                    ['no' => '06', 'icon' => 'verified',     'title' => 'Konfirmasi Resmi',   'desc' => 'Dapatkan sertifikat dan Nomor Lahan resmi atas nama keluarga Anda.'],
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
</section>


{{-- External Home Scripts --}}
<script src="{{ asset('js/home.js') }}"></script>

{{-- Modal Pop-up Tipe Lahan --}}
<div id="tipeLahanModal" class="fixed inset-0 z-[9999] hidden flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" onclick="if(event.target === this) closeTipeModal()">
    <div class="bg-white dark:bg-slate-950 w-full max-w-5xl rounded-[2rem] shadow-2xl overflow-hidden transform transition-all duration-300 flex flex-col max-h-[85vh] md:max-h-[80vh]">
        
        {{-- Header --}}
        <div class="px-8 py-5 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-slate-50 dark:bg-slate-900 shrink-0">
            <div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-white">Daftar Tipe Lahan</h3>
                <p class="text-xs text-slate-400 dark:text-slate-550 mt-1">Spesifikasi dimensi dan kapasitas unit yang tersedia</p>
            </div>
            <button type="button" onclick="closeTipeModal()" class="text-slate-400 hover:text-red-500 transition-colors flex items-center justify-center">
                <span class="material-icons text-2xl">close</span>
            </button>
        </div>

        {{-- Content: Split Pane Layout --}}
        <div class="flex flex-col md:flex-row flex-grow overflow-hidden">
            <div class="w-full md:w-80 border-r border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-900/50 p-6 overflow-y-auto flex flex-col gap-6 shrink-0">
                
                {{-- Kawasan Muslim --}}
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-455 dark:text-slate-500 mb-3">Kawasan Muslim</h4>
                    <div class="flex flex-col gap-1.5">
                        <button type="button" onclick="selectTipe('barokah')" id="btn-barokah" class="tipe-list-btn w-full text-left px-4 py-3 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-200/50 dark:hover:bg-slate-800 transition-all outline-none">
                            Barokah (1 Slot)
                        </button>
                        <button type="button" onclick="selectTipe('fitrah')" id="btn-fitrah" class="tipe-list-btn w-full text-left px-4 py-3 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-200/50 dark:hover:bg-slate-800 transition-all outline-none">
                            Fitrah (2 Slot)
                        </button>
                        <button type="button" onclick="selectTipe('shakinah')" id="btn-shakinah" class="tipe-list-btn w-full text-left px-4 py-3 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-200/50 dark:hover:bg-slate-800 transition-all outline-none">
                            Shakinah (6 Slot)
                        </button>
                        <button type="button" onclick="selectTipe('khalifah')" id="btn-khalifah" class="tipe-list-btn w-full text-left px-4 py-3 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-200/50 dark:hover:bg-slate-800 transition-all outline-none">
                            Khalifah (12 Slot)
                        </button>
                    </div>
                </div>

                {{-- Kawasan Non-Muslim --}}
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-455 dark:text-slate-500 mb-3">Kawasan Non-Muslim</h4>
                    <div class="flex flex-col gap-1.5">
                        <button type="button" onclick="selectTipe('single')" id="btn-single" class="tipe-list-btn w-full text-left px-4 py-3 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-200/50 dark:hover:bg-slate-800 transition-all outline-none">
                            Single (1 Slot)
                        </button>
                        <button type="button" onclick="selectTipe('double')" id="btn-double" class="tipe-list-btn w-full text-left px-4 py-3 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-200/50 dark:hover:bg-slate-800 transition-all outline-none">
                            Double & Deluxe
                        </button>
                        <button type="button" onclick="selectTipe('family')" id="btn-family" class="tipe-list-btn w-full text-left px-4 py-3 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-200/50 dark:hover:bg-slate-800 transition-all outline-none">
                            Family & Super Family
                        </button>
                        <button type="button" onclick="selectTipe('royal')" id="btn-royal" class="tipe-list-btn w-full text-left px-4 py-3 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-200/50 dark:hover:bg-slate-800 transition-all outline-none">
                            Royal Family & VIP
                        </button>
                    </div>
                </div>

            </div>

            {{-- Right Pane: Live Image Preview and Details --}}
            <div class="flex-grow p-8 flex flex-col md:flex-row gap-8 overflow-y-auto">
                {{-- Image Box --}}
                <div class="w-full md:w-1/2 aspect-[4/3] md:aspect-auto md:h-full max-h-[300px] md:max-h-none rounded-2xl overflow-hidden bg-slate-50 border border-slate-100 dark:border-slate-800 shrink-0 shadow-sm">
                    <img id="modal-tipe-img" src="{{ asset('storage/assets/tipe/barokah.png') }}" class="w-full h-full object-cover object-center" alt="Preview Tipe Lahan" />
                </div>

                {{-- Detail Box --}}
                <div class="flex flex-col justify-between flex-grow">
                    <div>
                        <h4 id="modal-tipe-title" class="text-2xl font-bold text-slate-900 dark:text-white mb-6">Tipe Barokah</h4>
                        
                        <div class="space-y-4">
                            <div class="flex justify-between items-center py-2.5 border-b border-slate-100 dark:border-slate-800">
                                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Ukuran Dimensi</span>
                                <span id="modal-tipe-size" class="text-sm font-bold text-slate-800 dark:text-slate-200">1.5 x 2.5 m</span>
                            </div>
                            <div class="flex justify-between items-center py-2.5 border-b border-slate-100 dark:border-slate-800">
                                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Kapasitas Slot</span>
                                <span id="modal-tipe-slots" class="text-sm font-bold text-slate-800 dark:text-slate-200">1 Slot</span>
                            </div>
                            <div class="py-2.5">
                                <span class="text-xs font-semibold text-slate-400 uppercase tracking-wider block mb-1.5">Keterangan</span>
                                <p id="modal-tipe-desc" class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">Lahan pemakaman tunggal (single).</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Footer --}}
        <div class="px-8 py-5 border-t border-slate-100 dark:border-slate-850 bg-slate-50 dark:bg-slate-900/50 flex justify-end gap-3 shrink-0">
            <button type="button" onclick="closeTipeModal()" class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all">
                Tutup
            </button>
            <a href="/cluster" class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-white bg-[#800000] hover:bg-[#800000]/90 rounded-xl transition-all shadow-md">
                Buka Halaman Cluster
            </a>
        </div>
    </div>
</div>

<script>
    const tipeData = {
        'barokah': {
            name: 'Tipe Barokah',
            size: '1.5 x 2.5 m',
            slots: '1 Slot',
            desc: 'Lahan pemakaman tunggal (single).',
            img: "{{ asset('storage/assets/tipe/barokah.png') }}"
        },
        'fitrah': {
            name: 'Tipe Fitrah',
            size: '4 x 3 m',
            slots: '2 Slot',
            desc: 'Lahan pemakaman ganda (double) berdampingan.',
            img: "{{ asset('storage/assets/tipe/Fitrah.png') }}"
        },
        'shakinah': {
            name: 'Tipe Shakinah',
            size: '7 x 8 m',
            slots: '6 Slot',
            desc: 'Lahan pemakaman keluarga dengan pembatas khusus.',
            img: "{{ asset('storage/assets/tipe/shakinah.png') }}"
        },
        'khalifah': {
            name: 'Tipe Khalifah',
            size: '7 x 15 m',
            slots: '12 Slot',
            desc: 'Lahan pemakaman keluarga besar semi-private.',
            img: "{{ asset('storage/assets/tipe/khalifah.png') }}"
        },
        'single': {
            name: 'Tipe Single',
            size: '1.5 x 4 m',
            slots: '1 Slot',
            desc: 'Lahan pemakaman tunggal (single).',
            img: "{{ asset('storage/assets/tipe/single.jpeg') }}"
        },
        'double': {
            name: 'Tipe Double & Deluxe',
            size: '3 x 4 m s.d 4 x 4.5 m',
            slots: '2 Slot',
            desc: 'Lahan pemakaman ganda (double) berdampingan.',
            img: "{{ asset('storage/assets/tipe/double(2).png') }}"
        },
        'family': {
            name: 'Tipe Family & Super Family',
            size: '8 x 5 m s.d 8 x 10 m',
            slots: '4 - 6 Slot',
            desc: 'Lahan pemakaman keluarga semi-private.',
            img: "{{ asset('storage/assets/tipe/super-family.png') }}"
        },
        'royal': {
            name: 'Tipe Royal Family & VIP',
            size: '16 x 20 m s.d 26 x 36 m',
            slots: '10 - 18 Slot',
            desc: 'Lahan pemakaman keluarga besar tipe private.',
            img: "{{ asset('storage/assets/tipe/royal-family.png') }}"
        }
    };

    function selectTipe(key) {
        const data = tipeData[key];
        if (!data) return;

        // Update content
        document.getElementById('modal-tipe-img').src = data.img;
        
        // Custom object positioning for double
        if (key === 'double') {
            document.getElementById('modal-tipe-img').className = 'w-full h-full object-cover object-top';
        } else {
            document.getElementById('modal-tipe-img').className = 'w-full h-full object-cover object-center';
        }

        document.getElementById('modal-tipe-title').textContent = data.name;
        document.getElementById('modal-tipe-size').textContent = data.size;
        document.getElementById('modal-tipe-slots').textContent = data.slots;
        document.getElementById('modal-tipe-desc').textContent = data.desc;

        // Reset all buttons to inactive style
        document.querySelectorAll('.tipe-list-btn').forEach(btn => {
            btn.classList.remove('bg-[#800000]', 'text-white', 'shadow-sm');
            btn.classList.add('text-slate-700', 'dark:text-slate-200');
        });

        // Set active style for selected button
        const activeBtn = document.getElementById('btn-' + key);
        if (activeBtn) {
            activeBtn.classList.remove('text-slate-700', 'dark:text-slate-200');
            activeBtn.classList.add('bg-[#800000]', 'text-white', 'shadow-sm');
        }
    }

    function openTipeModal() {
        const modal = document.getElementById('tipeLahanModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');
        selectTipe('barokah');
    }

    function closeTipeModal() {
        const modal = document.getElementById('tipeLahanModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.classList.remove('overflow-hidden');
    }
</script>

@endsection
