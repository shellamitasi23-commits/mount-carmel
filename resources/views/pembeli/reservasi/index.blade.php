@extends('layouts.master')
@section('title', 'Reservasi Saya — Mount Carmel')

@section('content')
<div class="min-h-screen bg-[#F3F4F6] pt-28 pb-20">
<div class="max-w-5xl mx-auto px-6">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10" data-aos="fade-up">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-1">Reservasi Saya</h1>
            <p class="text-gray-500 text-sm">Daftar semua pemesanan kavling yang telah Anda buat.</p>
        </div>
        <a href="{{ route('cluster.index') }}"
           class="btn-press btn-ripple inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 text-white rounded-xl text-sm font-bold hover:bg-gray-800 transition-colors shadow-md">
            <span class="material-icons text-sm">add</span> Pesan Lahan Baru
        </a>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-xl text-sm font-medium flex items-center gap-2">
        <span class="material-icons text-sm">check_circle</span> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl text-sm font-medium flex items-center gap-2">
        <span class="material-icons text-sm">error</span> {{ session('error') }}
    </div>
    @endif

    @if($reservasis->isEmpty())
    <div class="py-20 text-center bg-white rounded-2xl border border-gray-100 shadow-sm" data-aos="fade-up">
        <span class="material-icons text-5xl text-gray-200 block mb-3">inbox</span>
        <h3 class="text-lg font-bold text-gray-400 mb-1">Belum Ada Reservasi</h3>
        <p class="text-sm text-gray-400 mb-6">Anda belum pernah melakukan pemesanan kavling.</p>
        <a href="{{ route('cluster.index') }}"
           class="btn-press btn-ripple inline-flex items-center gap-2 px-6 py-3 bg-gray-900 text-white rounded-xl text-sm font-bold hover:bg-gray-800 transition-colors">
            <span class="material-icons text-sm">search</span> Lihat Cluster Tersedia
        </a>
    </div>
    @else
    <div class="space-y-4">
        @foreach($reservasis as $i => $res)
        @php
            // Prioritaskan status dari tabel pembayarans (diupdate admin)
            // Fallback ke kolom status_pembayaran di tabel reservasis
            $statusBayar = $res->pembayaran
                ? $res->pembayaran->status_pembayaran
                : $res->status_pembayaran;
            $statusRes = $res->status_reservasi;
        @endphp
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-all duration-300"
             data-aos="fade-up" data-aos-delay="{{ ($i % 5) * 60 }}">

            <div class="h-1 w-full
                {{ $statusRes === 'Selesai' ? 'bg-emerald-500' :
                   ($statusRes === 'Disetujui' ? 'bg-blue-500' :
                   ($statusRes === 'Ditolak' ? 'bg-red-400' : 'bg-amber-400')) }}">
            </div>

            <div class="p-5 flex flex-col md:flex-row md:items-center gap-4">

                <div class="w-12 h-12 rounded-xl {{ $res->kavling->cluster->kategori === 'Muslim' ? 'bg-emerald-50' : 'bg-amber-50' }} flex items-center justify-center shrink-0">
                    <span class="material-icons {{ $res->kavling->cluster->kategori === 'Muslim' ? 'text-emerald-600' : 'text-amber-600' }}">
                        {{ $res->kavling->cluster->kategori === 'Muslim' ? 'mosque' : 'church' }}
                    </span>
                </div>

                <div class="flex-grow">
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <h3 class="font-bold text-gray-900">lahan #{{ $res->kavling->nomor_kavling }}</h3>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                            {{ $statusRes === 'Selesai' ? 'bg-emerald-100 text-emerald-700' :
                               ($statusRes === 'Disetujui' ? 'bg-blue-100 text-blue-700' :
                               ($statusRes === 'Ditolak' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700')) }}">
                            {{ $statusRes }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-400 mb-0.5">
                        {{ $res->kavling->cluster->nama_cluster }} &middot; {{ $res->kavling->tipe_kavling }}
                        @if($res->nama_jenazah)
                        &middot; Alm. {{ $res->nama_jenazah }}
                        @else
                        &middot; <span class="italic">Pre-Need</span>
                        @endif
                    </p>
                    <p class="text-xs text-gray-400">
                        Dipesan: {{ $res->created_at->translatedFormat('d M Y') }}
                        @if($res->tanggal_dimakamkan)
                        &middot; Dimakamkan: {{ \Carbon\Carbon::parse($res->tanggal_dimakamkan)->translatedFormat('d M Y') }}
                        @endif
                    </p>
                </div>

                <div class="flex flex-col md:items-end gap-2 shrink-0">
                    <p class="font-bold text-gray-900">Rp {{ number_format($res->kavling->harga, 0, ',', '.') }}</p>

                    <span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase
                        {{ $statusBayar === 'Lunas' ? 'bg-emerald-100 text-emerald-700' :
                           ($statusBayar === 'Menunggu Konfirmasi' ? 'bg-blue-100 text-blue-700' :
                           ($statusBayar === 'Ditolak' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-500')) }}">
                        @if($statusBayar === 'Belum Bayar') Belum Bayar
                        @elseif($statusBayar === 'Menunggu Konfirmasi') Menunggu Konfirmasi
                        @elseif($statusBayar === 'Lunas') Lunas ✓
                        @elseif($statusBayar === 'Ditolak') Pembayaran Ditolak
                        @else {{ $statusBayar }}
                        @endif
                    </span>

                    <div class="flex gap-2 flex-wrap justify-end">
                        {{-- Tombol Bayar: muncul kalau belum bayar dan reservasi tidak ditolak --}}
                        @if($statusBayar === 'Belum Bayar' && $statusRes !== 'Ditolak')
                        <a href="{{ route('pembeli.pembayaran.create', ['reservasi_id' => $res->id]) }}"
                           class="btn-press px-4 py-2 bg-gray-900 text-white rounded-xl text-xs font-bold hover:bg-amber-500 transition-colors flex items-center gap-1.5">
                            <span class="material-icons text-xs">payments</span> Bayar Sekarang
                        </a>
                        @endif

                        {{-- Tombol Kirim Ulang: kalau pembayaran ditolak --}}
                        @if($statusBayar === 'Ditolak')
                        <a href="{{ route('pembeli.pembayaran.create', ['reservasi_id' => $res->id]) }}"
                           class="btn-press px-4 py-2 bg-red-50 text-red-600 border border-red-200 rounded-xl text-xs font-bold hover:bg-red-100 transition-colors flex items-center gap-1.5">
                            <span class="material-icons text-xs">refresh</span> Kirim Ulang
                        </a>
                        @endif

                        {{-- Tombol Invoice: hanya kalau sudah Lunas --}}
                        @if($statusBayar === 'Lunas' && $res->pembayaran)
                        <a href="{{ route('pembeli.pembayaran.invoice', $res->pembayaran->id) }}"
                           class="btn-press px-4 py-2 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl text-xs font-bold hover:bg-emerald-100 transition-colors flex items-center gap-1.5">
                            <span class="material-icons text-xs">receipt</span> Invoice
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>
</div>
@endsection
