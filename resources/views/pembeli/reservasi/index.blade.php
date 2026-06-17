@extends('layouts.master')
@section('title', 'Reservasi Saya — Mount Carmel')

@section('content')
<div class="min-h-screen bg-white pt-28 pb-20">
    <div class="max-w-7xl mx-auto px-10">

        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
            <div class="max-w-3xl">
                <span class="inline-block text-slate-400 font-bold tracking-wider text-xs mb-2">
                    Manajemen Reservasi
                </span>
                <h1 class="text-3xl md:text-4xl font-bold text-slate-900 tracking-tight mb-3">
                    Reservasi Saya
                </h1>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Pantau status kepemilikan dan administrasi lahan peristirahatan Anda di Mount Carmel.
                </p>
            </div>
            <a href="{{ route('cluster.index') }}"
               class="inline-flex items-center justify-center px-6 py-3 bg-[#800000] text-white text-xs font-semibold rounded-xl hover:bg-[#800000]/90 transition-all active:scale-95 shadow-md">
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
        <div class="grid grid-cols-1 gap-8">
            @foreach($reservasis as $i => $res)
            @php
                $statusBayar = $res->status_pembayaran;
                $statusRes = $res->status_reservasi;
                $lunasPayments = $res->pembayarans->where('status_pembayaran', 'Lunas');
            @endphp
            <div class="group bg-white border-t-4 border-slate-900 shadow-lg p-8 md:p-10 transition-all duration-500">
                
                <div class="flex flex-col lg:flex-row gap-8 items-start">
                    {{-- Kavling Big Display --}}
                    <div class="shrink-0">
                        <div class="w-20 h-20 bg-[#800000] flex flex-col items-center justify-center shadow-md rounded-xl">
                            <span class="text-[9px] font-bold text-slate-200 uppercase tracking-wider mb-0.5">Unit</span>
                            <span class="text-2xl font-bold text-white tracking-tight">#{{ $res->lahan->nomor_lahan }}</span>
                        </div>
                    </div>

                    {{-- Main Info --}}
                    <div class="flex-grow space-y-6">
                        <div>
                            <div class="flex flex-wrap items-center gap-3 mb-2">
                                <span class="text-xs font-bold text-slate-400">
                                    {{ strtoupper($res->lahan->cluster->nama_cluster) }}
                                </span>
                                <span class="text-slate-200">/</span>
                                <span class="text-xs font-bold text-slate-400">
                                    {{ strtoupper($res->lahan->tipe_lahan) }}
                                </span>
                            </div>
                            
                            <h3 class="text-xl font-bold text-slate-900 tracking-tight mb-4">
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

                            <div class="flex flex-wrap gap-12 mt-6">
                                @if($res->marketing_oleh)
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-300 mb-1">Staf Marketing</p>
                                    <p class="text-xs font-bold text-[#800000]">{{ $res->marketing_oleh }}</p>
                                </div>
                                @endif
                                
                                @if($res->disetujui_oleh)
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-300 mb-1">Disetujui Oleh</p>
                                    <p class="text-xs font-bold text-slate-700">{{ $res->disetujui_oleh }}</p>
                                </div>
                                @endif
                                
                                @php
                                    $latestLunasPayment = $res->pembayarans->where('status_pembayaran', 'Lunas')->last();
                                @endphp
                                @if($latestLunasPayment && $latestLunasPayment->dikonfirmasi_oleh)
                                <div>
                                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-300 mb-1">Dikonfirmasi Oleh</p>
                                    <p class="text-xs font-bold text-emerald-700">{{ $latestLunasPayment->dikonfirmasi_oleh }} (Accounting)</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6 pt-6 border-t border-slate-100">
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Nilai Investasi</p>
                                <p class="text-lg font-bold text-slate-900">
                                    Rp {{ number_format($res->lahan->harga, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Status Reservasi</p>
                                <span class="text-xs font-bold uppercase
                                    {{ $statusRes === 'Selesai' ? 'text-emerald-600' :
                                       ($statusRes === 'Disetujui' ? 'text-blue-600' :
                                       ($statusRes === 'Ditolak' ? 'text-red-600' : 'text-amber-600')) }}">
                                    {{ $statusRes }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Actions Panel --}}
                    <div class="w-full lg:w-72 shrink-0 space-y-6 pt-6 lg:pt-0 lg:pl-10 lg:border-l border-slate-100">
                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-2">Administrasi</p>
                        
                        <div class="mb-4">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 mb-1">Status Bayar</p>
                            <p class="text-sm font-bold uppercase
                                {{ $statusBayar === 'Lunas' ? 'text-emerald-600' :
                                   (strpos($statusBayar, 'Lunas') !== false ? 'text-blue-600' : 'text-slate-900') }}">
                                {{ $statusBayar }}
                            </p>
                        </div>

                        <div class="space-y-3">
                            @if(in_array($statusBayar, ['Belum Bayar', 'DP Lunas']) || (strpos($statusBayar, 'Cicilan Ke-') !== false && strpos($statusBayar, 'Lunas') !== false))
                                @if($statusRes === 'Disetujui' || ($statusRes === 'Menunggu Validasi' && $statusBayar === 'Belum Bayar'))
                                <a href="{{ route('pembeli.pembayaran.create', ['reservasi_id' => $res->id]) }}"
                                   class="w-full block bg-[#800000] text-white text-center py-3.5 rounded-xl text-xs font-semibold hover:bg-[#800000]/90 transition-all shadow-md">
                                    {{ $statusBayar === 'Belum Bayar' ? 'Bayar Sekarang' : 'Bayar Cicilan Selanjutnya' }}
                                </a>
                                @endif
                            @endif

                            @if($statusBayar === 'Ditolak' || $statusBayar === 'Menunggu Konfirmasi')
                                @if($statusBayar === 'Ditolak')
                                <a href="{{ route('pembeli.pembayaran.create', ['reservasi_id' => $res->id]) }}"
                                   class="w-full block bg-red-600 text-white text-center py-3.5 rounded-xl text-xs font-semibold hover:bg-red-700 transition-all shadow-md">
                                    Kirim Ulang Bukti
                                </a>
                                @else
                                <span class="w-full block bg-slate-50 text-slate-400 text-center py-3.5 rounded-xl text-xs font-semibold cursor-not-allowed border border-slate-100">
                                    Menunggu Verifikasi
                                </span>
                                @endif
                            @endif

                            @if($lunasPayments->isNotEmpty())
                            <div class="space-y-2 pt-4 border-t border-slate-100">
                                <p class="text-[9px] font-black uppercase tracking-widest text-slate-300">Unduh Invoice</p>
                                @foreach($lunasPayments as $p)
                                <a href="{{ route('pembeli.pembayaran.invoice', $p->id) }}"
                                   class="w-full block bg-white border border-slate-200 text-slate-700 text-center py-3 rounded-xl text-[9px] font-black uppercase tracking-widest hover:bg-slate-50 transition-all">
                                    @if($p->cicilan_ke === 0)
                                        Invoice DP (20%)
                                    @elseif($res->jenis_pembayaran === 'cicilan')
                                        Invoice Cicilan #{{ $p->cicilan_ke }}
                                    @else
                                        Invoice Pelunasan
                                    @endif
                                </a>
                                @endforeach
                            </div>
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
