@extends('layouts.master')
@section('title', 'Konfirmasi Pesanan — Mount Carmel')

@section('content')
<div class="min-h-screen bg-white dark:bg-gray-950 pt-32 pb-32">
    <div class="max-w-6xl mx-auto px-8">

        {{-- Minimalist Breadcrumb --}}
        <nav class="flex items-center gap-4 text-xs font-semibold text-gray-400 mb-12" data-aos="fade-down">
            <a href="{{ route('home') }}" class="hover:text-[#800000] transition-colors">Beranda</a>
            <span class="text-gray-200 dark:text-gray-800">/</span>
            <span class="text-gray-900 dark:text-white">Konfirmasi Reservasi</span>
        </nav>

        {{-- Minimalist Progress Bar --}}
        <div class="flex items-center justify-between max-w-2xl mx-auto mb-20" data-aos="fade-down">
            @foreach([
                ['label'=>'Pilih Lahan','done'=>true,'active'=>false],
                ['label'=>'Pilih Nomor','done'=>true,'active'=>false],
                ['label'=>'Isi Data','done'=>true,'active'=>false],
                ['label'=>'Konfirmasi','done'=>false,'active'=>true],
                ['label'=>'Pembayaran','done'=>false,'active'=>false],
            ] as $s)
            <div class="flex flex-col items-center gap-3 relative">
                <div class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-semibold
                    {{ $s['active'] ? 'bg-[#800000] text-white ring-4 ring-[#800000]/10' :
                       ($s['done'] ? 'bg-[#800000]/20 text-[#800000]' : 'bg-gray-100 text-gray-300 dark:bg-gray-900 dark:text-gray-700') }}">
                    {{ $loop->index + 1 }}
                </div>
                <span class="text-xs font-semibold whitespace-nowrap
                    {{ $s['active'] ? 'text-[#800000]' : ($s['done'] ? 'text-[#800000]/80' : 'text-gray-300 dark:text-gray-700') }}">
                    {{ $s['label'] }}
                </span>
            </div>
            @if(!$loop->last)
            <div class="flex-1 h-px bg-gray-100 dark:bg-gray-900 mx-4 mb-8"></div>
            @endif
            @endforeach
        </div>

        @if(session('success'))
        <div class="mb-12 p-6 bg-emerald-50 dark:bg-emerald-950/20 border-l-4 border-emerald-500 rounded-r-xl" data-aos="fade-up">
            <p class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">{{ session('success') }}</p>
        </div>
        @endif

        <div class="max-w-2xl mx-auto bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-8 shadow-sm" data-aos="fade-up">
            <header class="mb-8 border-b border-gray-100 dark:border-gray-800/50 pb-6">
                <span class="text-xs font-semibold text-[#800000] block mb-1">Langkah 4 dari 5: Konfirmasi</span>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight mb-2 leading-none">
                    Periksa Kembali Pesanan Anda
                </h1>
                <p class="text-gray-400 dark:text-gray-500 text-xs">
                    Pastikan seluruh informasi pemesanan dan skema pembayaran telah sesuai sebelum melakukan transfer.
                </p>
            </header>

            <div class="space-y-8 text-xs">
                {{-- Detail Lahan --}}
                <div class="bg-gray-50 dark:bg-gray-950 p-6 rounded-2xl border border-gray-100/50 dark:border-gray-900/50">
                    <span class="text-xs font-bold text-[#800000] block mb-4">I. Detail Lahan</span>
                    <div class="grid grid-cols-2 gap-y-4 gap-x-6">
                        <div>
                            <span class="text-[10px] font-semibold text-gray-400 block mb-0.5">Cluster</span>
                            <span class="font-bold text-gray-900 dark:text-white uppercase">{{ $reservasi->lahan->cluster->nama_cluster }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] font-semibold text-gray-400 block mb-0.5">Nomor Lahan</span>
                            <span class="font-bold text-gray-900 dark:text-white">#{{ $reservasi->lahan->nomor_lahan }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] font-semibold text-gray-400 block mb-0.5">Tipe Lahan</span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $reservasi->lahan->tipe_lahan }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] font-semibold text-gray-400 block mb-0.5">Ukuran / Kapasitas</span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $reservasi->lahan->ukuran }} / {{ $reservasi->lahan->kapasitas }} Slot</span>
                        </div>
                    </div>
                </div>

                {{-- Informasi Pemesan & Jenazah --}}
                <div class="bg-gray-50 dark:bg-gray-950 p-6 rounded-2xl border border-gray-100/50 dark:border-gray-900/50">
                    <span class="text-xs font-bold text-[#800000] block mb-4">II. Informasi Pemesan & Kebutuhan</span>
                    <div class="grid grid-cols-2 gap-y-4 gap-x-6">
                        <div>
                            <span class="text-[10px] font-semibold text-gray-400 block mb-0.5">Nama Pemesan</span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $reservasi->user->name }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] font-semibold text-gray-400 block mb-0.5">Email / Kontak</span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $reservasi->user->email }} / {{ $reservasi->user->telepon }}</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-[10px] font-semibold text-gray-400 block mb-0.5">Alamat Pengiriman Dokumen</span>
                            <span class="font-medium text-gray-800 dark:text-gray-200">{{ $reservasi->alamat_pemesan }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] font-semibold text-gray-400 block mb-0.5">Kategori Kebutuhan</span>
                            <span class="font-bold text-[#800000] uppercase tracking-wide">
                                {{ $reservasi->kategori_kebutuhan === 'end_user' ? 'Kebutuhan Segera (End-User)' : 'Persiapan Jangka Panjang (Pre-Need)' }}
                            </span>
                        </div>
                        @if($reservasi->kontak_kerabat)
                        <div>
                            <span class="text-[10px] font-semibold text-gray-400 block mb-0.5">Kontak Kerabat</span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $reservasi->kontak_kerabat }}</span>
                        </div>
                        @endif

                        @if($reservasi->marketing_oleh)
                        <div>
                            <span class="text-[10px] font-semibold text-gray-400 block mb-0.5">Staf Marketing</span>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $reservasi->marketing_oleh }}</span>
                        </div>
                        @endif

                        @if($reservasi->kategori_kebutuhan === 'end_user' || $reservasi->nama_jenazah)
                        <div class="col-span-2 border-t border-gray-100 dark:border-gray-900 pt-4 mt-2 grid grid-cols-2 gap-4">
                            <div>
                                <span class="text-[10px] font-semibold text-gray-400 block mb-0.5">Nama Lengkap Jenazah</span>
                                <span class="font-bold text-gray-900 dark:text-white">ALM. {{ strtoupper($reservasi->nama_jenazah) }}</span>
                            </div>
                            <div>
                                <span class="text-[10px] font-semibold text-gray-400 block mb-0.5">Rencana Tanggal Pemakaman</span>
                                <span class="font-bold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($reservasi->tanggal_dimakamkan)->translatedFormat('d F Y') }}</span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Kustomisasi Lahan (Khusus Special) --}}
                @if($reservasi->request_tambahan || $reservasi->biaya_tambahan > 0)
                <div class="bg-gray-50 dark:bg-gray-950 p-6 rounded-2xl border border-gray-100/50 dark:border-gray-900/50">
                    <span class="text-xs font-bold text-[#800000] block mb-4">III. Request Tambahan (Lahan Special)</span>
                    <div class="space-y-4">
                        @if($reservasi->request_tambahan)
                        <div>
                            <span class="text-[10px] font-semibold text-gray-400 block mb-0.5">Deskripsi Tambahan</span>
                            <p class="font-medium text-gray-800 dark:text-gray-200 bg-white dark:bg-gray-900 p-3 rounded-lg border border-gray-100 dark:border-gray-800 leading-relaxed">
                                {{ $reservasi->request_tambahan }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Rincian Biaya & Skema Pembayaran --}}
                <div class="border border-gray-100 dark:border-gray-850 rounded-2xl overflow-hidden shadow-sm">
                    <div class="p-6 bg-gray-50 dark:bg-gray-950 border-b border-gray-100 dark:border-gray-900">
                        <span class="text-xs font-bold text-[#800000] block mb-4">IV. Rincian & Skema Pembayaran</span>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center text-gray-500">
                                <span>Harga Lahan</span>
                                <span class="font-bold text-gray-900 dark:text-white">Rp {{ number_format($reservasi->lahan->harga, 0, ',', '.') }}</span>
                            </div>
                            @if($reservasi->biaya_tambahan > 0)
                            <div class="flex justify-between items-center text-gray-500">
                                <span>Biaya Tambahan Kustomisasi</span>
                                <span class="font-bold text-gray-900 dark:text-white">Rp {{ number_format($reservasi->biaya_tambahan, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between items-center text-gray-900 dark:text-white font-bold border-t border-gray-200/50 dark:border-gray-800 pt-3 text-xs">
                                <span>Total Harga Lahan</span>
                                <span>Rp {{ number_format($reservasi->biaya_penuh, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-white dark:bg-gray-900 space-y-4">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-[10px] font-semibold text-gray-400 block mb-0.5">Metode Pembayaran</span>
                                <span class="font-bold text-gray-900 dark:text-white uppercase tracking-wider">
                                    @if($reservasi->jenis_pembayaran === 'tunai')
                                        Tunai (Cash)
                                    @else
                                        Cicilan 12 Bulan + DP
                                    @endif
                                </span>
                            </div>
                        </div>

                        {{-- Breakdown specific to method --}}
                        <div class="bg-gray-50 dark:bg-gray-950 p-4 rounded-xl border border-gray-100 dark:border-gray-900 space-y-2">
                            @if($reservasi->jenis_pembayaran === 'tunai')
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500">Tagihan Pembayaran Penuh</span>
                                    <span class="font-black text-gray-900 dark:text-white">Rp {{ number_format($reservasi->biaya_penuh, 0, ',', '.') }}</span>
                                </div>
                            @else
                                <div class="flex justify-between items-center text-gray-500">
                                    <span>Uang Muka / DP (Dibayar Sekarang)</span>
                                    <span class="font-bold text-gray-900 dark:text-white">Rp {{ number_format($reservasi->biaya_reservasi, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-gray-500">
                                    <span>Sisa Pokok Cicilan</span>
                                    <span class="font-bold text-gray-900 dark:text-white">Rp {{ number_format($reservasi->biaya_penuh - $reservasi->biaya_reservasi, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-[#800000] font-bold border-t border-gray-200/50 dark:border-gray-800 pt-2">
                                    <span>Cicilan Bulanan (x12 Bulan)</span>
                                    <span>Rp {{ number_format(($reservasi->biaya_penuh - $reservasi->biaya_reservasi) / 12, 0, ',', '.') }}/bulan</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Highlight Tagihan Pertama --}}
                    <div class="p-6 bg-[#800000]/5 dark:bg-[#800000]/10 border-t border-gray-150 dark:border-gray-850 flex justify-between items-center">
                        <div>
                            <span class="text-xs font-semibold text-[#800000] block mb-0.5">Tagihan Pertama Anda</span>
                            <span class="text-[10px] font-bold text-gray-400 uppercase">
                                @if($reservasi->jenis_pembayaran === 'tunai')
                                    Pelunasan Penuh
                                @else
                                    Pembayaran Uang Muka (DP)
                                @endif
                            </span>
                        </div>
                        <div class="text-right">
                            <span class="text-lg font-bold text-[#800000]">
                                @if($reservasi->jenis_pembayaran === 'tunai')
                                    Rp {{ number_format($reservasi->biaya_penuh, 0, ',', '.') }}
                                @else
                                    Rp {{ number_format($reservasi->biaya_reservasi, 0, ',', '.') }}
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex flex-col sm:flex-row items-center gap-6 pt-8 mt-8 border-t border-gray-100 dark:border-gray-800/50">
                <a href="{{ route('pembeli.pembayaran.create', ['reservasi_id' => $reservasi->id]) }}"
                    class="w-full sm:flex-1 py-3.5 bg-[#800000] text-white text-xs font-semibold text-center rounded-xl hover:bg-[#900000] transition-all duration-300">
                    Konfirmasi & Lanjut ke Pembayaran
                </a>
                <a href="{{ route('pembeli.reservasi.index') }}"
                   class="text-xs font-semibold text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                    Lihat Riwayat Reservasi
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
