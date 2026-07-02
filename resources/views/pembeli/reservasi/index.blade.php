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
        <div class="py-32 text-center bg-white border border-gray-100 rounded-3xl p-8 shadow-sm">
            <span class="material-icons text-5xl text-gray-250 mb-3 block">event_note</span>
            <h3 class="text-lg font-semibold text-gray-500 mb-1">Belum Ada Reservasi</h3>
            <p class="text-xs text-gray-400 mb-6">Anda belum memesan atau melakukan reservasi lahan peristirahatan.</p>
            <a href="{{ route('cluster.index') }}"
               class="inline-flex items-center justify-center px-6 py-2.5 bg-[#800000] text-white text-xs font-semibold rounded-xl hover:bg-[#800000]/90 transition-all active:scale-95 shadow-md">
                Mulai Reservasi Pertama
            </a>
        </div>
        @else
        <div class="grid grid-cols-1 gap-6">
            @foreach($reservasis as $i => $res)
            @php
                $statusBayar = $res->status_pembayaran;
                $statusRes = $res->status_reservasi;
                $lunasPayments = $res->pembayarans->where('status_pembayaran', 'Lunas');
            @endphp
            <div class="group bg-white border border-gray-100 rounded-3xl p-6 md:p-8 shadow-[0_10px_30px_rgba(0,0,0,0.015)] transition-all duration-300 hover:shadow-[0_20px_50px_rgba(128,0,0,0.035)] hover:-translate-y-0.5">
                
                <div class="flex flex-col lg:flex-row gap-6 items-start">
                    
                    {{-- Main Info --}}
                    <div class="flex-grow space-y-6 w-full">
                        <div>
                            <div class="flex flex-wrap items-center gap-3 mb-2">
                                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-[#800000]/5 text-[#800000] rounded-lg text-xs font-semibold">
                                    <span class="material-icons text-sm">landscape</span> Kavling #{{ $res->lahan->nomor_lahan }}
                                </div>
                                <div class="flex items-center gap-2 text-xs text-gray-400 font-medium">
                                    <span>{{ $res->lahan->cluster->nama_cluster }}</span>
                                    <span class="text-gray-200">&bull;</span>
                                    <span>{{ $res->lahan->tipe_lahan }}</span>
                                </div>
                            </div>
                            
                            @if($res->lahan->kapasitas == 1)
                                @php
                                    $detail = $res->detailJenazahs->where('nomor_slot', 1)->first();
                                    $isApproved = $statusRes === 'Disetujui';
                                    $isPaid = ($statusBayar === 'Lunas' || $statusBayar === 'DP Lunas' || str_contains($statusBayar, 'Lunas'));
                                    $canFill = $isApproved && $isPaid;
                                @endphp

                                <h3 class="text-lg font-semibold text-slate-800 tracking-tight mt-3 mb-4">
                                    {{ $detail ? 'Alm. ' . ucwords(strtolower($detail->nama_jenazah)) : 'Lahan Persiapan (Belum Diisi)' }}
                                </h3>

                                <div class="flex flex-wrap gap-8 items-center text-xs">
                                    <div>
                                        <p class="text-gray-400 font-medium mb-1">Tanggal Pesan</p>
                                        <p class="font-semibold text-slate-700">{{ $res->created_at->translatedFormat('d F Y') }}</p>
                                    </div>
                                    @if($detail && $detail->tanggal_dimakamkan)
                                    <div>
                                        <p class="text-gray-400 font-medium mb-1">Rencana Pemakaman</p>
                                        <p class="font-semibold text-slate-700">{{ \Carbon\Carbon::parse($detail->tanggal_dimakamkan)->translatedFormat('d F Y') }}</p>
                                    </div>
                                    @endif

                                    @if($detail)
                                    <div>
                                        <p class="text-gray-400 font-medium mb-1">Status Data Jenazah</p>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            @if($detail->status === 'Menunggu Validasi')
                                                <span class="px-2 py-0.5 bg-amber-50 text-amber-700 border border-amber-200 text-[10px] font-medium rounded-md">
                                                    Menunggu Validasi
                                                </span>
                                            @elseif($detail->status === 'Disetujui')
                                                <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-medium rounded-md inline-flex items-center gap-1">
                                                    <span class="material-icons text-xs">check_circle</span> Disetujui
                                                </span>
                                            @elseif($detail->status === 'Ditolak')
                                                <span class="px-2 py-0.5 bg-red-50 text-red-700 border border-red-200 text-[10px] font-medium rounded-md inline-flex items-center gap-1">
                                                    <span class="material-icons text-xs">cancel</span> Ditolak
                                                </span>
                                                <a href="{{ route('pembeli.reservasi.isi_slot_form', ['reservasi_id' => $res->id, 'nomor_slot' => 1]) }}"
                                                   class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-[#800000] text-white rounded-md text-[10px] font-medium hover:bg-[#800000]/90 transition-colors shadow-sm ml-2">
                                                    <span class="material-icons text-xs">edit</span> Edit Data Diri
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    @else
                                        @if($canFill)
                                        <div>
                                            <p class="text-gray-400 font-medium mb-1">Data Jenazah</p>
                                            <a href="{{ route('pembeli.reservasi.isi_slot_form', ['reservasi_id' => $res->id, 'nomor_slot' => 1]) }}"
                                               class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-[#800000] text-white rounded-md text-[10px] font-medium hover:bg-[#800000]/90 transition-colors shadow-sm">
                                                <span class="material-icons text-xs">edit</span> Isi Data Diri
                                            </a>
                                        </div>
                                        @endif
                                    @endif
                                </div>
                            @else
                                <h3 class="text-lg font-semibold text-slate-800 tracking-tight mt-3 mb-4">
                                    {{ $res->lahan->tipe_lahan }} &middot; {{ $res->lahan->kapasitas }} Slot
                                </h3>

                                <div class="flex flex-wrap gap-8 items-center text-xs mb-4">
                                    <div>
                                        <p class="text-gray-400 font-medium mb-1">Tanggal Pesan</p>
                                        <p class="font-semibold text-slate-700">{{ $res->created_at->translatedFormat('d F Y') }}</p>
                                    </div>
                                </div>

                                {{-- Slot Grid for Multi-slot --}}
                                <div class="mt-4 p-4 bg-slate-50 border border-slate-100 rounded-2xl">
                                    <div class="flex items-center justify-between mb-4">
                                        <h4 class="text-xs font-semibold text-slate-500">Daftar Slot Lahan</h4>
                                        @php
                                            $filledCount = $res->detailJenazahs->where('status', 'Disetujui')->count();
                                            $kapasitas = $res->lahan->kapasitas;
                                        @endphp
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-medium {{ $filledCount >= $kapasitas ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                                            {{ $filledCount }} / {{ $kapasitas }} Terisi
                                        </span>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        @for($slot = 1; $slot <= $kapasitas; $slot++)
                                            @php
                                                $detail = $res->detailJenazahs->where('nomor_slot', $slot)->first();
                                                $isApproved = $statusRes === 'Disetujui';
                                                $isPaid = ($statusBayar === 'Lunas' || $statusBayar === 'DP Lunas' || str_contains($statusBayar, 'Lunas'));
                                                $canFill = $isApproved && $isPaid;
                                            @endphp
                                            
                                            <div class="p-3 bg-white border border-slate-100 rounded-xl flex items-center justify-between shadow-sm">
                                                <div>
                                                    <div class="flex items-center gap-2">
                                                        <p class="text-[9px] font-semibold text-slate-400">Slot #{{ $slot }}</p>
                                                        @if($detail)
                                                            @if($detail->status === 'Menunggu Validasi')
                                                                <span class="px-1.5 py-0.5 bg-amber-50 text-amber-700 border border-amber-200 rounded text-[8px] font-medium">
                                                                    Pending
                                                                </span>
                                                            @elseif($detail->status === 'Disetujui')
                                                                <span class="px-1.5 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded text-[8px] font-medium">
                                                                    Disetujui
                                                                </span>
                                                            @elseif($detail->status === 'Ditolak')
                                                                <span class="px-1.5 py-0.5 bg-red-50 text-red-700 border border-red-200 rounded text-[8px] font-medium">
                                                                    Ditolak
                                                                </span>
                                                            @endif
                                                        @endif
                                                    </div>
                                                    @if($detail)
                                                        <p class="text-xs font-semibold text-slate-800 mt-1">Alm. {{ ucwords(strtolower($detail->nama_jenazah)) }}</p>
                                                        @if($detail->tanggal_dimakamkan)
                                                            <p class="text-[10px] text-gray-400 mt-0.5">Dimakamkan: {{ \Carbon\Carbon::parse($detail->tanggal_dimakamkan)->translatedFormat('d M Y') }}</p>
                                                        @else
                                                            <p class="text-[10px] text-gray-400 mt-0.5">Belum dimakamkan</p>
                                                        @endif
                                                    @else
                                                        <p class="text-xs font-medium text-slate-400 mt-1 italic">Slot Belum Diisi</p>
                                                        @if(!$canFill)
                                                            <span class="inline-block text-[8px] text-slate-350 mt-0.5">Menunggu Aktivasi Lahan</span>
                                                        @endif
                                                    @endif
                                                </div>
                                                
                                                @if(!$detail && $canFill)
                                                    <a href="{{ route('pembeli.reservasi.isi_slot_form', ['reservasi_id' => $res->id, 'nomor_slot' => $slot]) }}"
                                                       class="px-2.5 py-1 bg-[#800000] text-white rounded-md text-[10px] font-medium hover:bg-[#800000]/90 transition-colors flex items-center gap-1 shadow-sm">
                                                       <span class="material-icons text-xs">edit</span> Isi Data
                                                    </a>
                                                @elseif($detail)
                                                    <div class="flex items-center gap-2">
                                                        @if($detail->status === 'Ditolak')
                                                            <a href="{{ route('pembeli.reservasi.isi_slot_form', ['reservasi_id' => $res->id, 'nomor_slot' => $slot]) }}"
                                                               class="px-2.5 py-1 bg-[#800000] text-white rounded-md text-[10px] font-medium hover:bg-[#800000]/90 transition-colors flex items-center gap-0.5 shadow-sm">
                                                               <span class="material-icons text-[10px]">edit</span> Edit
                                                            </a>
                                                        @elseif($detail->status === 'Menunggu Validasi')
                                                            <span class="material-icons text-amber-500 text-sm">hourglass_empty</span>
                                                        @else
                                                            <span class="material-icons text-emerald-500 text-sm">check_circle</span>
                                                        @endif
                                                    </div>
                                                @else
                                                    <span class="material-icons text-slate-200 text-sm">lock</span>
                                                @endif
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            @endif

                            <div class="flex flex-wrap gap-8 mt-6 text-xs">
                                @if($res->marketing_oleh)
                                <div>
                                    <p class="text-gray-400 font-medium mb-0.5">Staf Marketing</p>
                                    <p class="font-semibold text-slate-700">{{ $res->marketing_oleh }}</p>
                                </div>
                                @endif
                                
                                @if($res->disetujui_oleh)
                                <div>
                                    <p class="text-gray-400 font-medium mb-0.5">Disetujui Oleh</p>
                                    <p class="font-semibold text-slate-700">{{ $res->disetujui_oleh }}</p>
                                </div>
                                @endif
                                
                                @php
                                    $latestLunasPayment = $res->pembayarans->where('status_pembayaran', 'Lunas')->last();
                                @endphp
                                @if($latestLunasPayment && $latestLunasPayment->dikonfirmasi_oleh)
                                <div>
                                    <p class="text-gray-400 font-medium mb-0.5">Dikonfirmasi Oleh</p>
                                    <p class="font-semibold text-slate-700">{{ $latestLunasPayment->dikonfirmasi_oleh }} (Accounting)</p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-6 pt-5 border-t border-slate-100 text-xs">
                            <div>
                                <p class="text-gray-400 font-medium mb-0.5">Harga Lahan</p>
                                <p class="text-base font-semibold text-slate-900">
                                    Rp {{ number_format($res->lahan->harga, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-gray-400 font-medium mb-0.5">Status Reservasi</p>
                                <span class="text-xs font-semibold
                                    {{ $statusRes === 'Selesai' ? 'text-emerald-600' :
                                       ($statusRes === 'Disetujui' ? 'text-blue-600' :
                                       ($statusRes === 'Ditolak' ? 'text-red-600' : 'text-amber-600')) }}">
                                    {{ $statusRes }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Actions Panel --}}
                    <div class="w-full lg:w-64 shrink-0 space-y-5 pt-6 lg:pt-0 lg:pl-8 lg:border-l border-slate-100 text-xs">
                        <div>
                            <p class="text-gray-400 font-medium mb-0.5">Status Bayar</p>
                            <p class="text-sm font-semibold
                                {{ $statusBayar === 'Lunas' ? 'text-emerald-600' :
                                   (strpos($statusBayar, 'Lunas') !== false ? 'text-blue-600' : 'text-slate-700') }}">
                                {{ $statusBayar }}
                            </p>
                        </div>

                        <div class="space-y-2.5">
                            @if(in_array($statusBayar, ['Belum Bayar', 'DP Lunas']) || (strpos($statusBayar, 'Cicilan Ke-') !== false && strpos($statusBayar, 'Lunas') !== false))
                                @if($statusRes === 'Disetujui' || ($statusRes === 'Menunggu Validasi' && $statusBayar === 'Belum Bayar'))
                                <a href="{{ route('pembeli.pembayaran.create', ['reservasi_id' => $res->id]) }}"
                                   class="w-full block bg-[#800000] text-white text-center py-2.5 rounded-xl font-semibold hover:bg-[#800000]/90 transition-all shadow-sm">
                                    {{ $statusBayar === 'Belum Bayar' ? 'Bayar Sekarang' : 'Bayar Cicilan Selanjutnya' }}
                                </a>
                                @endif
                            @endif

                            @if($statusBayar === 'Ditolak' || $statusBayar === 'Menunggu Konfirmasi')
                                @if($statusBayar === 'Ditolak')
                                <a href="{{ route('pembeli.pembayaran.create', ['reservasi_id' => $res->id]) }}"
                                   class="w-full block bg-red-600 text-white text-center py-2.5 rounded-xl font-semibold hover:bg-red-700 transition-all shadow-sm">
                                    Kirim Ulang Bukti
                                </a>
                                @else
                                <span class="w-full block bg-slate-50 text-slate-400 text-center py-2.5 rounded-xl font-semibold cursor-not-allowed border border-slate-100">
                                    Menunggu Verifikasi
                                </span>
                                @endif
                            @endif

                            @if($lunasPayments->isNotEmpty())
                            <div class="space-y-2 pt-3 border-t border-slate-100">
                                <p class="text-[9px] font-semibold text-gray-400 uppercase tracking-wider">Unduh Invoice</p>
                                @foreach($lunasPayments as $p)
                                <a href="{{ route('pembeli.pembayaran.invoice', $p->id) }}"
                                   class="w-full block bg-white border border-gray-200 text-gray-600 text-center py-2 rounded-lg text-[10px] font-semibold hover:bg-gray-50 transition-all">
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
