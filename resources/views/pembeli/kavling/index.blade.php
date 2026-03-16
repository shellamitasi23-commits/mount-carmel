@extends('layouts.master')
@section('title', 'Tipe Kavling — {{ $cluster->nama_cluster }}')

@section('content')
<div class="min-h-screen bg-[#F3F4F6] pt-28 pb-20">
<div class="max-w-5xl mx-auto px-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8" data-aos="fade-down">
        <a href="{{ route('home') }}" class="hover:text-gray-600 transition-colors">Beranda</a>
        <span class="material-icons text-xs">chevron_right</span>
        <a href="{{ route('cluster.index') }}" class="hover:text-gray-600 transition-colors">Cluster</a>
        <span class="material-icons text-xs">chevron_right</span>
        <span class="text-gray-700 font-semibold">{{ $cluster->nama_cluster }}</span>
    </nav>

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10" data-aos="fade-up">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="material-icons text-base {{ $cluster->kategori === 'Muslim' ? 'text-emerald-500' : 'text-amber-500' }}">
                    {{ $cluster->kategori === 'Muslim' ? 'mosque' : 'church' }}
                </span>
                <span class="text-xs font-bold tracking-widest uppercase {{ $cluster->kategori === 'Muslim' ? 'text-emerald-500' : 'text-amber-500' }}">
                    {{ $cluster->kategori }}
                </span>
            </div>
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-1">{{ $cluster->nama_cluster }}</h1>
            <p class="text-gray-500 text-sm">{{ $cluster->deskripsi ?? 'Pilih tipe kavling yang sesuai.' }}</p>
        </div>

        {{-- Pilih Cluster Lain --}}
        @if($clusters->count() > 1)
        <div x-data="{ open: false }" class="relative shrink-0">
            <button @click="open = !open" @click.away="open = false"
                    class="flex items-center gap-2 px-5 py-2.5 bg-white border border-gray-200 rounded-full text-sm font-semibold text-gray-600 hover:border-gray-400 transition-all">
                <span class="material-icons text-base">swap_horiz</span>
                Ganti Cluster
                <span class="material-icons text-sm">expand_more</span>
            </button>
            <div x-show="open" x-transition
                 class="absolute right-0 top-full mt-2 w-56 bg-white border border-gray-100 rounded-2xl shadow-xl py-2 z-50">
                @foreach($clusters as $cl)
                <a href="{{ route('pembeli.kavling.index', ['cluster_id' => $cl->id]) }}"
                   class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition-colors
                       {{ $cl->id === $cluster->id ? 'font-bold text-gray-900 bg-gray-50' : '' }}">
                    <span class="material-icons text-base {{ $cl->kategori === 'Muslim' ? 'text-emerald-500' : 'text-amber-500' }}">
                        {{ $cl->kategori === 'Muslim' ? 'mosque' : 'church' }}
                    </span>
                    {{ $cl->nama_cluster }}
                    @if($cl->id === $cluster->id)
                    <span class="material-icons text-sm text-gray-400 ml-auto">check</span>
                    @endif
                </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    {{-- Tipe Kavling Cards --}}
    @if($tipeKavlings->isEmpty())
    <div class="py-20 text-center bg-white rounded-2xl border border-gray-100 shadow-sm">
        <span class="material-icons text-5xl text-gray-200 block mb-3">inventory_2</span>
        <h3 class="text-lg font-bold text-gray-400 mb-1">Tidak Ada Kavling Tersedia</h3>
        <p class="text-sm text-gray-400">Semua kavling di cluster ini sudah terisi.</p>
        <a href="{{ route('cluster.index') }}" class="inline-flex items-center gap-2 mt-4 text-sm font-semibold text-gray-500 hover:text-gray-900 transition-colors">
            <span class="material-icons text-sm">arrow_back</span> Kembali ke Cluster
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($tipeKavlings as $i => $tipe)

        {{-- Klik card tipe → ke halaman nomor kavling --}}
        <a href="{{ route('pembeli.kavling.nomor', ['cluster_id' => $cluster->id, 'tipe_kavling' => $tipe['tipe_kavling']]) }}"
           class="group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300"
           data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 80 }}">

            {{-- Bar warna atas --}}
            <div class="h-1.5 w-full {{ $cluster->kategori === 'Muslim' ? 'bg-emerald-500' : 'bg-amber-500' }}"></div>

            <div class="p-6">
                {{-- Denah SVG --}}
                @php
                    preg_match('/(\d+(?:\.\d+)?)\s*[mx×x]\s*(\d+(?:\.\d+)?)/i', $tipe['ukuran'], $dim);
                    $w = isset($dim[1]) ? (float)$dim[1] : 4;
                    $h = isset($dim[2]) ? (float)$dim[2] : 3;
                    $svgW=140; $svgH=80; $pad=12;
                    $maxW=$svgW-$pad*2; $maxH=$svgH-$pad*2;
                    $ratio=min($maxW/max($w,.1),$maxH/max($h,.1));
                    $rw=round($w*$ratio); $rh=round($h*$ratio);
                    $rx=round(($svgW-$rw)/2); $ry=round(($svgH-$rh)/2);
                    $fill   = $cluster->kategori==='Muslim' ? '#d1fae5' : '#fef3c7';
                    $stroke = $cluster->kategori==='Muslim' ? '#10b981' : '#f59e0b';
                @endphp
                <div class="bg-gray-50 rounded-xl flex items-center justify-center mb-4" style="height:90px">
                    <svg width="{{ $svgW }}" height="{{ $svgH }}" viewBox="0 0 {{ $svgW }} {{ $svgH }}" xmlns="http://www.w3.org/2000/svg">
                        <rect width="{{ $svgW }}" height="{{ $svgH }}" fill="#f9fafb" rx="6"/>
                        <rect x="{{ $rx }}" y="{{ $ry }}" width="{{ $rw }}" height="{{ $rh }}"
                            fill="{{ $fill }}" stroke="{{ $stroke }}" stroke-width="1.5" stroke-dasharray="4 2" rx="3"/>
                        <text x="{{ $rx+$rw/2 }}" y="{{ $ry+$rh/2+4 }}" text-anchor="middle"
                            font-size="9" font-weight="700" fill="#6b7280" font-family="Inter,sans-serif">
                            {{ $tipe['ukuran'] }}
                        </text>
                    </svg>
                </div>

                <h3 class="font-bold text-gray-900 text-lg mb-1">{{ $tipe['tipe_kavling'] }}</h3>
                <p class="text-xs text-gray-400 mb-4">
                    Kapasitas {{ $tipe['kapasitas'] }} orang &middot;
                    <span class="text-emerald-600 font-semibold">{{ $tipe['tersedia'] }} unit tersedia</span>
                </p>

                <div class="flex items-center justify-between pt-4 border-t border-gray-50">
                    <div>
                        <p class="text-[10px] text-gray-400 font-semibold uppercase tracking-wider">Harga mulai</p>
                        <p class="font-bold text-gray-900 text-sm">Rp {{ number_format($tipe['harga_min'],0,',','.') }}</p>
                    </div>
                    <div class="w-9 h-9 bg-gray-900 rounded-full flex items-center justify-center group-hover:bg-amber-500 transition-colors">
                        <span class="material-icons text-white text-sm">arrow_forward</span>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @endif

</div>
</div>
@endsection