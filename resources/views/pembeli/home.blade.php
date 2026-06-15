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
            
            <div data-aos="fade-up" data-aos-delay="900" class="absolute bottom-4 md:bottom-8 left-1/2 -translate-x-1/2 flex items-center gap-3 md:gap-6 bg-white/50 backdrop-blur-sm py-2 md:py-3 px-4 md:px-8 rounded-full whitespace-nowrap">
                <span class="text-xs md:text-sm font-medium uppercase tracking-wider text-gray-800">Watch a video</span>
                <button class="btn-ripple btn-press w-10 h-10 md:w-16 md:h-16 bg-[#800000] text-gray-900 rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition-transform">
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
                <img data-aos="fade-up" data-aos-delay="100" alt="Jalur penuh ketenangan" class="w-1/2 h-44 md:h-64 object-cover rounded-2xl shadow-md" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCSeV8r5vTKVZson8x8U7XKosDU4OBIVwZCPNZOGiv7g8lL5mQYOegvqR47c2dPLgGFWhnrnslq9ErpprziLGhdeyqqystblfmKjcXSYUs3Ex5arOXBjjL80xf80mRmXZS6gCg9ShL7wBZ09_YS6GYhWfYN8ngIMMJKxo-PMrFVAhpyGaPNnDwhj0B12HdNVsq6MbUvK0TVpR3IYfH2whIB76pNLxyD6Zc2Asd_nuvAYJufsHTjqWMGi_EKBGJGKb7I688tdFK_1Qw" />
                <img data-aos="fade-up" data-aos-delay="200" alt="Alam tenang" class="w-1/2 h-44 md:h-64 object-cover rounded-2xl shadow-md" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC84fEtfZb8hWa8DG2uJJfLUZGCaLm5oOnQI0MHj2S6K5kwbfoCHJseJ0nNLKVR_yh8U1W9MSn7c9b1uZeAWC3mjLXJHYtd4R7_oQcvB0nZeBHp2-33dtHJPAdie6SAHmyx2wWFg6PDA7K7Cio3YuEF2GfixpWADifW8iIZGvnYnuDU0DHY_nNJVwJZPUEJjX_OAFnbE7VCZuUlC-ufcD-_1rp5Olu60H67Ih9XH2AZSPPvqiVWhtGOGGCjSDWO_tBe89VFeTumpjk" />
            </div>
        </div>
        <div class="md:w-1/2 flex flex-col items-start md:items-end gap-6 md:gap-0">
            <a data-aos="fade-left" class="btn-ripple btn-press px-6 md:px-8 py-3 md:py-4 bg-[#800000] text-white font-semibold rounded-full hover:bg-[#800000]/90 transition-colors md:mb-16 shadow-md inline-block" href="#">
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
                    <span class="text-xs font-semibold text-slate-500">Dipesan</span>
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
        const color = l.status === 'Tersedia' ? '#6EE7B7' : (l.status === 'Dipesan' ? '#FCD34D' : '#CBD5E1');
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

    // 4. Render representative plots (Muslim Cluster)
    // Map data to sectors in the image
    let idxM = 0;
    const sectorsM = [
        { y: 800, x: 200, rows: 5, cols: 8 },
        { y: 500, x: 200, rows: 5, cols: 8 },
        { y: 800, x: 700, rows: 5, cols: 8 }
    ];

    sectorsM.forEach(s => {
        for(let r=0; r<s.rows; r++) {
            for(let c=0; c<s.cols; c++) {
                if(lahanMuslim[idxM]) {
                    addPlot(lahanMuslim[idxM], s.y + r*35, s.x + c*55, 50, 30);
                    idxM++;
                }
            }
        }
    });

    // 5. Render representative plots (Non-Muslim Cluster)
    let idxNM = 0;
    const sectorsNM = [
        { y: 800, x: 1200, rows: 5, cols: 8 },
        { y: 500, x: 1200, rows: 5, cols: 8 },
        { y: 200, x: 1200, rows: 5, cols: 8 }
    ];

    sectorsNM.forEach(s => {
        for(let r=0; r<s.rows; r++) {
            for(let c=0; c<s.cols; c++) {
                if(lahanNonMuslim[idxNM]) {
                    addPlot(lahanNonMuslim[idxNM], s.y + r*35, s.x + c*55, 50, 30);
                    idxNM++;
                }
            }
        }
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
</style>

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
                    ['icon' => 'support_agent',   'title' => 'Layanan Konsultan',  'desc' => 'Pendampingan penuh dari proses pemilihan lahan hingga pemakaman.'],
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
                    ['no' => '02', 'icon' => 'edit_note',    'title' => 'Isi Formulir',       'desc' => 'Lengkapi data reservasi dan upload dokumen yang diperlukan secara online.'],
                    ['no' => '03', 'icon' => 'payments',     'title' => 'Lakukan Pembayaran', 'desc' => 'Pilih metode pembayaran yang nyaman dan kirim bukti transfer.'],
                    ['no' => '04', 'icon' => 'verified',     'title' => 'Konfirmasi Resmi',   'desc' => 'Dapatkan sertifikat dan Nomor Lahan resmi atas nama keluarga Anda.'],
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
               class="btn-press btn-ripple inline-flex items-center gap-2 px-6 md:px-8 py-3 md:py-4 bg-[#800000] text-white font-bold rounded-full hover:bg-[#800000]/90 transition-colors shadow-lg">
                Mulai Sekarang <span class="material-icons text-sm">arrow_forward</span>
            </a>
        </div>
    </div>
</section>


{{-- External Home Scripts --}}
<script src="{{ asset('js/home.js') }}"></script>

@endsection
