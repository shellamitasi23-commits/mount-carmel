@extends('layouts.master')
@section('title', 'Pembayaran Saya — Mount Carmel')

@section('content')
<div class="min-h-screen bg-[#F3F4F6] pt-28 pb-20">
<div class="max-w-5xl mx-auto px-6">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10" data-aos="fade-up">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-1">Pembayaran Saya</h1>
            <p class="text-gray-500 text-sm">Riwayat pembayaran dan invoice kavling Anda.</p>
        </div>
        <a href="{{ route('cluster.index') }}"
           class="btn-press btn-ripple inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 text-white rounded-xl text-sm font-bold hover:bg-gray-800 transition-colors shadow-md">
            <span class="material-icons text-sm">add</span> Pesan Kavling Baru
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

    {{-- Tagihan yang perlu dibayar --}}
    @if($reservasiSiapBayar->count() > 0)
    <div class="mb-8" data-aos="fade-up">
        <h2 class="text-sm font-bold text-gray-700 uppercase tracking-widest mb-4 flex items-center gap-2">
            <span class="material-icons text-amber-500 text-base">pending_actions</span>
            Menunggu Pembayaran ({{ $reservasiSiapBayar->count() }})
        </h2>
        <div class="space-y-3">
            @foreach($reservasiSiapBayar as $res)
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 flex flex-col sm:flex-row sm:items-center gap-4">
                <div class="flex-grow">
                    <p class="font-bold text-gray-900">Kavling #{{ $res->kavling->nomor_kavling }}</p>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $res->kavling->cluster->nama_cluster }} &middot; {{ $res->kavling->tipe_kavling }}</p>
                    @if($res->nama_jenazah)
                    <p class="text-xs text-gray-500">Alm. {{ $res->nama_jenazah }}</p>
                    @else
                    <p class="text-xs text-gray-400 italic">Pre-Need</p>
                    @endif
                </div>
                <div class="shrink-0 flex items-center gap-4">
                    <div class="text-right">
                        <p class="text-xs text-gray-400">Total Bayar</p>
                        <p class="font-bold text-gray-900">Rp {{ number_format($res->kavling->harga, 0, ',', '.') }}</p>
                    </div>
                    <a href="{{ route('pembeli.pembayaran.create', ['reservasi_id' => $res->id]) }}"
                       class="btn-press btn-ripple px-5 py-2.5 bg-gray-900 text-white rounded-xl text-sm font-bold hover:bg-amber-500 transition-colors flex items-center gap-2 whitespace-nowrap">
                        <span class="material-icons text-sm">payments</span> Bayar Sekarang
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Riwayat Pembayaran --}}
    <div data-aos="fade-up">
        <h2 class="text-sm font-bold text-gray-700 uppercase tracking-widest mb-4 flex items-center gap-2">
            <span class="material-icons text-gray-400 text-base">history</span>
            Riwayat Pembayaran
        </h2>

        @if($pembayarans->isEmpty())
        <div class="py-16 text-center bg-white rounded-2xl border border-gray-100 shadow-sm">
            <span class="material-icons text-4xl text-gray-200 block mb-2">receipt_long</span>
            <p class="font-medium text-gray-400">Belum ada riwayat pembayaran.</p>
            <p class="text-xs text-gray-400 mt-1">Lakukan pemesanan dan pembayaran pertama Anda.</p>
        </div>
        @else
        <div class="space-y-4">
            @foreach($pembayarans as $i => $bayar)
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-md transition-all"
                 data-aos="fade-up" data-aos-delay="{{ ($i % 5) * 60 }}">

                <div class="h-1 w-full
                    {{ $bayar->status_pembayaran === 'Lunas' ? 'bg-emerald-500' :
                       ($bayar->status_pembayaran === 'Ditolak' ? 'bg-red-400' : 'bg-amber-400') }}">
                </div>

                <div class="p-5 flex flex-col sm:flex-row sm:items-center gap-4">

                    <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center shrink-0">
                        <span class="material-icons text-gray-400">receipt_long</span>
                    </div>

                    <div class="flex-grow">
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <p class="font-bold text-gray-900 text-sm">{{ $bayar->no_invoice }}</p>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                                {{ $bayar->status_pembayaran === 'Lunas' ? 'bg-emerald-100 text-emerald-700' :
                                   ($bayar->status_pembayaran === 'Ditolak' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                                @if($bayar->status_pembayaran === 'Lunas') Lunas ✓
                                @elseif($bayar->status_pembayaran === 'Ditolak') Ditolak
                                @else Menunggu Konfirmasi
                                @endif
                            </span>
                        </div>
                        <p class="text-xs text-gray-500">
                            Kavling #{{ $bayar->reservasi->kavling->nomor_kavling }} &middot;
                            {{ $bayar->reservasi->kavling->cluster->nama_cluster }}
                            @if($bayar->nama_bank)
                            &middot; Transfer via {{ $bayar->nama_bank }}
                            @endif
                        </p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $bayar->created_at->translatedFormat('d M Y') }}</p>
                    </div>

                    <div class="flex flex-col sm:items-end gap-2 shrink-0">
                        <p class="font-bold text-gray-900">Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}</p>
                        <div class="flex gap-2">
                            {{-- Invoice HANYA kalau Lunas --}}
                            @if($bayar->status_pembayaran === 'Lunas')
                            <a href="{{ route('pembeli.pembayaran.invoice', $bayar->id) }}"
                               class="btn-press px-4 py-2 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-xl text-xs font-bold hover:bg-emerald-100 transition-colors flex items-center gap-1.5">
                                <span class="material-icons text-xs">receipt</span> Invoice
                            </a>
                            @endif
                            {{-- Kirim ulang kalau ditolak --}}
                            @if($bayar->status_pembayaran === 'Ditolak')
                            <a href="{{ route('pembeli.pembayaran.create', ['reservasi_id' => $bayar->reservasi_id]) }}"
                               class="btn-press px-4 py-2 bg-red-50 text-red-600 border border-red-200 rounded-xl text-xs font-bold hover:bg-red-100 transition-colors flex items-center gap-1.5">
                                <span class="material-icons text-xs">refresh</span> Kirim Ulang
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
</div>
@endsection