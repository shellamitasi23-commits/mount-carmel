@extends('layouts.master')
@section('title', 'Reservasi Saya — Mount Carmel')

@section('content')
<div class="min-h-screen bg-white pt-40 pb-32">
    <div class="max-w-7xl mx-auto px-10">

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-12 mb-24">
            <div class="max-w-3xl">
                <span class="inline-block text-slate-400 font-black tracking-[0.4em] uppercase text-[10px] mb-6">
                    Manajemen Reservasi
                </span>
                <h1 class="text-7xl md:text-8xl font-black text-slate-900 tracking-tighter leading-[0.85] italic mb-8">
                    Reservasi Saya
                </h1>
                <p class="text-slate-500 text-xl font-medium leading-relaxed">
                    Pantau status kepemilikan dan administrasi lahan peristirahatan Anda di Mount Carmel.
                </p>
            </div>
            <a href="{{ route('cluster.index') }}"
               class="inline-flex items-center justify-center px-10 py-6 bg-[#800000] text-white text-[11px] font-black uppercase tracking-[0.3em] rounded-2xl hover:bg-[#800000]/90 transition-all active:scale-95 shadow-2xl shadow-slate-200">
                Pesan Lahan Baru
            </a>
        </div>

        @if(session('success'))
        <div class="mb-12 p-6 bg-emerald-50 dark:bg-emerald-950/20 border-l-4 border-emerald-500" data-aos="fade-up">
            <p class="text-[11px] font-black uppercase tracking-widest text-emerald-700 dark:text-emerald-400">
                {{ session('success') }}
            </p>
        </div>
        @endif

        @if(session('error'))
        <div class="mb-12 p-6 bg-red-50 dark:bg-red-950/20 border-l-4 border-red-500" data-aos="fade-up">
            <p class="text-[11px] font-black uppercase tracking-widest text-red-700 dark:text-red-400">
                {{ session('error') }}
            </p>
        </div>
        @endif

        @if($reservasis->isEmpty())
        <div class="py-40 text-center border-t-4 border-slate-900">
            <h3 class="text-4xl font-black text-slate-200 uppercase tracking-tighter mb-8 italic">Belum Ada Reservasi</h3>
            <a href="{{ route('cluster.index') }}"
               class="text-[11px] font-black uppercase tracking-[0.4em] text-slate-900 border-b-4 border-slate-900 pb-2 transition-all">
                Mulai Reservasi Pertama
            </a>
        </div>
        @else
        <div class="grid grid-cols-1 gap-12">
            @foreach($reservasis as $i => $res)
            @php
                $statusBayar = $res->pembayaran ? $res->pembayaran->status_pembayaran : $res->status_pembayaran;
                $statusRes = $res->status_reservasi;
            @endphp
            <div class="group bg-white border-t-8 border-slate-900 shadow-2xl shadow-slate-200/60 p-10 md:p-16 transition-all duration-500">
                
                <div class="flex flex-col lg:flex-row gap-16 items-start">
                    {{-- Kavling Big Display --}}
                    <div class="shrink-0">
                        <div class="w-32 h-32 bg-[#800000] flex flex-col items-center justify-center shadow-2xl">
                            <span class="text-[10px] font-black text-slate-200 uppercase tracking-widest mb-1">Unit</span>
                            <span class="text-4xl font-black text-white tracking-tighter">#{{ $res->lahan->nomor_lahan }}</span>
                        </div>
                    </div>

                    {{-- Main Info --}}
                    <div class="flex-grow space-y-10">
                        <div>
                            <div class="flex flex-wrap items-center gap-6 mb-4">
                                <span class="text-[11px] font-black uppercase tracking-[0.4em] text-slate-400">
                                    {{ strtoupper($res->lahan->cluster->nama_cluster) }}
                                </span>
                                <span class="text-slate-200">/</span>
                                <span class="text-[11px] font-black uppercase tracking-[0.4em] text-slate-400">
                                    {{ strtoupper($res->lahan->tipe_lahan) }}
                                </span>
                            </div>
                            
                            <h3 class="text-5xl font-black text-slate-900 tracking-tighter leading-none mb-6">
                                {{ $res->nama_jenazah ? 'ALM. ' . strtoupper($res->nama_jenazah) : 'LAHAN PERSIAPAN' }}
                            </h3>

                            <div class="flex flex-wrap gap-12">
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-300 mb-1">Tanggal Pesan</p>
                                    <p class="text-sm font-black text-slate-900">{{ $res->created_at->translatedFormat('d F Y') }}</p>
                                </div>
                                @if($res->tanggal_dimakamkan)
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-300 mb-1">Rencana Pemakaman</p>
                                    <p class="text-sm font-black text-slate-900">{{ \Carbon\Carbon::parse($res->tanggal_dimakamkan)->translatedFormat('d F Y') }}</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 pt-10 border-t border-slate-50">
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-300 mb-2">Nilai Investasi</p>
                                <p class="text-3xl font-black text-slate-900 tracking-tighter">
                                    Rp {{ number_format($res->lahan->harga, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="flex flex-wrap gap-4 md:justify-end items-center">
                                <div class="text-right">
                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-300 mb-2 text-right">Status Reservasi</p>
                                    <span class="text-sm font-black uppercase tracking-[0.2em]
                                        {{ $statusRes === 'Selesai' ? 'text-emerald-600' :
                                           ($statusRes === 'Disetujui' ? 'text-blue-600' :
                                           ($statusRes === 'Ditolak' ? 'text-red-600' : 'text-amber-600')) }}">
                                        {{ $statusRes }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions Panel --}}
                    <div class="w-full lg:w-72 shrink-0 space-y-6 pt-10 lg:pt-0 lg:pl-16 lg:border-l border-slate-50">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-300 mb-4">Administrasi</p>
                        
                        <div class="mb-8">
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-300 mb-1">Status Bayar</p>
                            <p class="text-sm font-black uppercase tracking-widest {{ $statusBayar === 'Lunas' ? 'text-emerald-600' : 'text-slate-900' }}">
                                {{ $statusBayar }}
                            </p>
                        </div>

                        <div class="space-y-4">
                            @if($statusBayar === 'Belum Bayar' && $statusRes !== 'Ditolak')
                            <a href="{{ route('pembeli.pembayaran.create', ['reservasi_id' => $res->id]) }}"
                               class="w-full block bg-[#800000] text-white text-center py-5 rounded-2xl text-[10px] font-black uppercase tracking-[0.3em] hover:bg-[#800000]/90 transition-all shadow-2xl shadow-[#800000]/10">
                                BAYAR SEKARANG
                            </a>
                            @endif

                            @if($statusBayar === 'Ditolak')
                            <a href="{{ route('pembeli.pembayaran.create', ['reservasi_id' => $res->id]) }}"
                               class="w-full block bg-red-600 text-white text-center py-5 rounded-2xl text-[10px] font-black uppercase tracking-[0.3em] hover:bg-red-700 transition-all shadow-2xl shadow-red-100">
                                KIRIM ULANG BUKTI
                            </a>
                            @endif

                            @if($statusBayar === 'Lunas' && $res->pembayaran)
                            <a href="{{ route('pembeli.pembayaran.invoice', $res->pembayaran->id) }}"
                               class="w-full block bg-white border-2 border-slate-900 text-slate-900 text-center py-5 rounded-2xl text-[10px] font-black uppercase tracking-[0.3em] hover:bg-slate-50 transition-all">
                                UNDUH INVOICE
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
