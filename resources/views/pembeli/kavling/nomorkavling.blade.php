@extends('layouts.master')
@section('title', 'Pilih Nomor Kavling — {{ $sample?->tipe_kavling ?? "N/A" }}')

@section('content')
<style>
.kavling-cell {
    aspect-ratio: 1;
    border-radius: 10px;
    border: 2px solid transparent;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    font-family: 'Inter', sans-serif;
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 0.02em;
}
.kavling-cell.tersedia {
    background: #f0fdf4;
    border-color: #86efac;
    color: #166534;
}
.kavling-cell.tersedia:hover {
    background: #dcfce7;
    border-color: #22c55e;
    transform: scale(1.07);
    box-shadow: 0 4px 14px rgba(34,197,94,.2);
    z-index: 10;
    position: relative;
}
.kavling-cell.tersedia.dipilih {
    background: #14532d;
    border-color: #14532d;
    color: white;
    transform: scale(1.09);
    box-shadow: 0 6px 20px rgba(20,83,45,.3);
    z-index: 20;
    position: relative;
}
.kavling-cell.dipesan {
    background: #fefce8;
    border-color: #fde047;
    color: #854d0e;
    cursor: not-allowed;
    opacity: 0.8;
}
.kavling-cell.terjual {
    background: #f3f4f6;
    border-color: #e5e7eb;
    color: #9ca3af;
    cursor: not-allowed;
    opacity: 0.5;
}
.kavling-cell .dot {
    width: 5px;
    height: 5px;
    border-radius: 50%;
    margin-top: 3px;
    flex-shrink: 0;
}
.tersedia .dot { background: #22c55e; }
.tersedia.dipilih .dot { background: white; }
.dipesan .dot { background: #eab308; }
.terjual .dot { background: #d1d5db; }
</style>

<div class="min-h-screen bg-[#F3F4F6] pt-28 pb-20">
<div class="max-w-6xl mx-auto px-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8" data-aos="fade-down">
        <a href="{{ route('home') }}" class="hover:text-gray-600 transition-colors">Beranda</a>
        <span class="material-icons text-xs">chevron_right</span>
        <a href="{{ route('cluster.index') }}" class="hover:text-gray-600 transition-colors">Cluster</a>
        <span class="material-icons text-xs">chevron_right</span>
        <a href="{{ route('pembeli.kavling.index', ['cluster_id' => $cluster->id]) }}"
           class="hover:text-gray-600 transition-colors">{{ $cluster->nama_cluster }}</a>
        <span class="material-icons text-xs">chevron_right</span>
        <span class="text-gray-700 font-semibold">{{ $sample?->tipe_kavling ?? 'N/A' }}</span>
    </nav>

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- KIRI: Grid Nomor --}}
        <div class="flex-1" data-aos="fade-up">
            <div class="mb-6">
                <div class="flex items-center gap-2 mb-2">
                    <span class="material-icons text-base {{ $cluster->kategori === 'Muslim' ? 'text-emerald-500' : 'text-amber-500' }}">
                        {{ $cluster->kategori === 'Muslim' ? 'mosque' : 'church' }}
                    </span>
                    <span class="text-xs font-bold tracking-widest uppercase {{ $cluster->kategori === 'Muslim' ? 'text-emerald-500' : 'text-amber-500' }}">
                        {{ $cluster->nama_cluster }}
                    </span>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-1">Pilih Nomor Kavling</h1>
                <p class="text-gray-500 text-sm">
                    Tipe <span class="font-semibold text-gray-700">{{ $sample?->tipe_kavling ?? 'N/A' }}</span> —
                    {{ collect($kavlings)->where('status','Tersedia')->count() }} unit tersedia dari {{ collect($kavlings)->count() }} total
                </p>
            </div>

            {{-- Legenda --}}
            <div class="flex flex-wrap gap-4 mb-6 text-xs font-semibold text-gray-600">
                <div class="flex items-center gap-1.5">
                    <div class="w-4 h-4 rounded bg-green-50 border-2 border-green-300"></div> Tersedia
                </div>
                <div class="flex items-center gap-1.5">
                    <div class="w-4 h-4 rounded bg-yellow-50 border-2 border-yellow-300"></div> Dipesan
                </div>
                <div class="flex items-center gap-1.5">
                    <div class="w-4 h-4 rounded bg-gray-100 border-2 border-gray-200"></div> Terjual
                </div>
                <div class="flex items-center gap-1.5">
                    <div class="w-4 h-4 rounded bg-green-900 border-2 border-green-900"></div> Dipilih
                </div>
            </div>

            {{-- Grid Interaktif --}}
            <div x-data="{
                selected: null,
                nomor: '',
                harga: 0,
                ukuran: '',
                kap: 0,
                pilih(id, n, h, u, k) {
                    this.selected = id;
                    this.nomor = n;
                    this.harga = h;
                    this.ukuran = u;
                    this.kap = k;
                },
                rupiah(v) {
                    return 'Rp ' + parseInt(v).toLocaleString('id-ID');
                }
            }">
                {{-- Grid --}}
                <div class="grid gap-2" style="grid-template-columns: repeat(auto-fill, minmax(68px, 1fr));">
                    @foreach($kavlings as $kavling)
                    <div class="kavling-cell {{ strtolower($kavling->status) }}"
                         :class="{ 'dipilih': selected == {{ $kavling->id }} }"
                         @if($kavling->status === 'Tersedia')
                             @click="pilih({{ $kavling->id }}, '{{ $kavling->nomor_kavling }}', {{ $kavling->harga }}, '{{ $kavling->ukuran }}', {{ $kavling->kapasitas }})"
                         @endif
                         title="{{ $kavling->nomor_kavling }} — {{ $kavling->status }}">
                        <span>{{ $kavling->nomor_kavling }}</span>
                        <div class="dot"></div>
                    </div>
                    @endforeach
                </div>

                {{-- Panel kavling terpilih --}}
                <div x-show="selected !== null"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-3"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="mt-5 bg-gray-900 text-white rounded-2xl p-5 flex flex-col sm:flex-row items-start sm:items-center gap-4">
                    <div class="flex-grow">
                        <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-0.5">Kavling Dipilih</p>
                        <h3 class="text-xl font-bold" x-text="'#' + nomor"></h3>
                        <p class="text-sm text-gray-300 mt-0.5"
                           x-text="ukuran + ' · Kapasitas ' + kap + ' orang'"></p>
                    </div>
                    <div class="shrink-0 text-right">
                        <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-0.5">Harga</p>
                        <p class="text-lg font-bold" x-text="rupiah(harga)"></p>
                    </div>
                    {{-- Tombol Pesan → ke reservasi/create dengan kavling_id --}}
                    <a :href="'{{ route('pembeli.reservasi.create') }}?kavling_id=' + selected"
                       class="btn-press btn-ripple shrink-0 bg-amber-400 hover:bg-amber-300 text-gray-900 font-bold px-6 py-3 rounded-xl text-sm transition-colors flex items-center gap-2 whitespace-nowrap">
                        Pesan Kavling Ini
                        <span class="material-icons text-sm">arrow_forward</span>
                    </a>
                </div>

                {{-- Placeholder belum pilih --}}
                <div x-show="selected === null"
                     class="mt-5 bg-white border-2 border-dashed border-gray-200 rounded-2xl p-5 text-center text-gray-400">
                    <span class="material-icons text-2xl text-gray-200 block mb-1">touch_app</span>
                    <p class="text-sm font-medium">Klik nomor kavling hijau untuk memilih</p>
                    <p class="text-xs mt-1">Kavling abu-abu sudah dipesan / terjual</p>
                </div>

            </div>{{-- /x-data --}}
        </div>

        {{-- KANAN: Info Tipe --}}
        <div class="lg:w-72 shrink-0" data-aos="fade-left">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sticky top-28">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Info Tipe Kavling</p>

                @php
                    preg_match('/(\d+(?:\.\d+)?)\s*[mx×x]\s*(\d+(?:\.\d+)?)/i', $sample?->ukuran ?? '4x3', $dim);
                    $w = isset($dim[1]) ? (float)$dim[1] : 4;
                    $h = isset($dim[2]) ? (float)$dim[2] : 3;
                    $svgW=200; $svgH=110; $pad=16;
                    $maxW=$svgW-$pad*2; $maxH=$svgH-$pad*2;
                    $ratio=min($maxW/max($w,.1),$maxH/max($h,.1));
                    $rw=round($w*$ratio); $rh=round($h*$ratio);
                    $rx=round(($svgW-$rw)/2); $ry=round(($svgH-$rh)/2);
                    $isMuslim = $cluster->kategori === 'Muslim';
                    $fill   = $isMuslim ? '#d1fae5' : '#fef3c7';
                    $stroke = $isMuslim ? '#10b981' : '#f59e0b';
                @endphp
                <div class="bg-gray-50 rounded-xl flex items-center justify-center mb-5" style="height:120px">
                    <svg width="{{ $svgW }}" height="{{ $svgH }}" viewBox="0 0 {{ $svgW }} {{ $svgH }}" xmlns="http://www.w3.org/2000/svg">
                        <rect width="{{ $svgW }}" height="{{ $svgH }}" fill="#f9fafb" rx="8"/>
                        <rect x="{{ $rx }}" y="{{ $ry }}" width="{{ $rw }}" height="{{ $rh }}"
                            fill="{{ $fill }}" stroke="{{ $stroke }}" stroke-width="1.5" stroke-dasharray="5 3" rx="4"/>
                        <line x1="{{ $rx }}" y1="{{ $ry+$rh+8 }}" x2="{{ $rx+$rw }}" y2="{{ $ry+$rh+8 }}" stroke="{{ $stroke }}" stroke-width="1"/>
                        <text x="{{ $rx+$rw/2 }}" y="{{ $ry+$rh+18 }}" text-anchor="middle" font-size="9" fill="{{ $stroke }}" font-family="Inter,sans-serif" font-weight="700">{{ $w }}m</text>
                        <line x1="{{ $rx-8 }}" y1="{{ $ry }}" x2="{{ $rx-8 }}" y2="{{ $ry+$rh }}" stroke="{{ $stroke }}" stroke-width="1"/>
                        <text x="{{ $rx-15 }}" y="{{ $ry+$rh/2 }}" text-anchor="middle" font-size="9" fill="{{ $stroke }}" font-family="Inter,sans-serif" font-weight="700" transform="rotate(-90 {{ $rx-15 }} {{ $ry+$rh/2 }})">{{ $h }}m</text>
                        <text x="{{ $rx+$rw/2 }}" y="{{ $ry+$rh/2+4 }}" text-anchor="middle" font-size="11" fill="#374151" font-family="Inter,sans-serif" font-weight="700">{{ $w*$h }} m²</text>
                    </svg>
                </div>

                <h3 class="font-bold text-gray-900 text-lg mb-4">Tipe {{ $sample?->tipe_kavling ?? 'N/A' }}</h3>

                <div class="space-y-2.5 text-sm mb-5">
                    <div class="flex justify-between">
                        <span class="text-gray-400">Cluster</span>
                        <span class="font-semibold text-gray-800 text-right">{{ $cluster->nama_cluster }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Ukuran</span>
                        <span class="font-semibold text-gray-800">{{ $sample?->ukuran ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Kapasitas</span>
                        <span class="font-semibold text-gray-800">{{ $sample?->kapasitas ?? 0 }} orang</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Harga</span>
                        <span class="font-bold text-gray-900">Rp {{ number_format($sample?->harga ?? 0,0,',','.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Tersedia</span>
                        <span class="font-bold text-emerald-600">{{ collect($kavlings)->where('status','Tersedia')->count() }} unit</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-gray-50">
                    <a href="{{ route('pembeli.kavling.index', ['cluster_id' => $cluster->id]) }}"
                       class="text-sm text-gray-400 hover:text-gray-700 flex items-center gap-1.5 transition-colors">
                        <span class="material-icons text-sm">arrow_back</span> Ganti tipe kavling
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
@endsection