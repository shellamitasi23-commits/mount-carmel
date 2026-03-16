@extends('layouts.master')
@section('title', 'Konfirmasi Pembayaran — Mount Carmel')

@section('content')
<div class="min-h-screen bg-[#F3F4F6] pt-28 pb-20">
<div class="max-w-4xl mx-auto px-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8" data-aos="fade-down">
        <a href="{{ route('home') }}" class="hover:text-gray-600 transition-colors">Beranda</a>
        <span class="material-icons text-xs">chevron_right</span>
        <a href="{{ route('pembeli.pembayaran.index') }}" class="hover:text-gray-600 transition-colors">Pembayaran</a>
        <span class="material-icons text-xs">chevron_right</span>
        <span class="text-gray-700 font-semibold">Konfirmasi Pembayaran</span>
    </nav>

    {{-- Progress --}}
    <div class="flex items-center mb-10" data-aos="fade-down" data-aos-delay="50">
        @foreach([
            ['label'=>'Pilih Tipe','done'=>true,'active'=>false],
            ['label'=>'Pilih Nomor','done'=>true,'active'=>false],
            ['label'=>'Isi Data','done'=>true,'active'=>false],
            ['label'=>'Pembayaran','done'=>false,'active'=>true],
        ] as $s)
        <div class="flex items-center {{ !$loop->last ? 'flex-1' : '' }}">
            <div class="flex flex-col items-center">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold border-2
                    {{ $s['active'] ? 'bg-gray-900 border-gray-900 text-white' :
                       ($s['done'] ? 'bg-emerald-500 border-emerald-500 text-white' : 'border-gray-300 text-gray-400 bg-white') }}">
                    @if($s['done'])<span class="material-icons text-xs">check</span>@else{{ $loop->index + 1 }}@endif
                </div>
                <span class="text-[10px] font-semibold mt-1 whitespace-nowrap
                    {{ $s['active'] ? 'text-gray-900' : ($s['done'] ? 'text-emerald-600' : 'text-gray-400') }}">
                    {{ $s['label'] }}
                </span>
            </div>
            @if(!$loop->last)
            <div class="flex-1 h-px {{ $s['done'] ? 'bg-emerald-300' : 'bg-gray-300' }} mx-3 mb-5"></div>
            @endif
        </div>
        @endforeach
    </div>

    @if($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4" data-aos="fade-up">
        <ul class="text-red-700 text-sm space-y-1">
            @foreach($errors->all() as $err)
            <li class="flex items-center gap-2"><span class="material-icons text-sm">error_outline</span>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- KIRI: Form --}}
        <div class="flex-1" data-aos="fade-up">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-1">Konfirmasi Pembayaran</h1>
                <p class="text-gray-500 text-sm">Transfer ke salah satu rekening, lalu upload bukti transfernya.</p>
            </div>

            <form action="{{ route('pembeli.pembayaran.store') }}" method="POST" enctype="multipart/form-data"
                  x-data="{ pilihanBank: '', nomorRek: '', atasNama: '' }"
                  class="space-y-5">
                @csrf
                <input type="hidden" name="reservasi_id" value="{{ $reservasi->id }}">
                <input type="hidden" name="jumlah_bayar" value="{{ $reservasi->kavling->harga }}">
                <input type="hidden" name="nama_bank" x-bind:value="pilihanBank">
                <input type="hidden" name="rekening_tujuan" x-bind:value="nomorRek">
                <input type="hidden" name="atas_nama_rekening" x-bind:value="atasNama">

                {{-- Nominal --}}
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-5">
                    <p class="text-xs font-bold text-amber-600 uppercase tracking-widest mb-1">Total Yang Harus Ditransfer</p>
                    <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($reservasi->kavling->harga, 0, ',', '.') }}</p>
                    <p class="text-xs text-amber-600 mt-1 font-medium">Transfer tepat nominal ini untuk mempercepat verifikasi.</p>
                </div>

                {{-- Pilih Rekening --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-4">Pilih Rekening Tujuan <span class="text-red-400">*</span></label>
                    <div class="space-y-3">
                        @foreach($rekening as $rek)
                        <label class="flex items-center gap-4 p-4 border-2 rounded-xl cursor-pointer transition-all"
                               :class="pilihanBank === '{{ $rek['bank'] }}' ? 'border-gray-900 bg-gray-50' : 'border-gray-200 hover:border-gray-300'"
                               @click="pilihanBank = '{{ $rek['bank'] }}'; nomorRek = '{{ $rek['nomor'] }}'; atasNama = '{{ $rek['atas_nama'] }}'">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 font-bold text-sm
                                {{ $rek['bank'] === 'BCA' ? 'bg-blue-100 text-blue-700' : ($rek['bank'] === 'BNI' ? 'bg-orange-100 text-orange-700' : 'bg-yellow-100 text-yellow-700') }}">
                                {{ $rek['bank'] }}
                            </div>
                            <div class="flex-grow">
                                <p class="font-bold text-gray-900 tracking-widest text-sm">{{ $rek['nomor'] }}</p>
                                <p class="text-xs text-gray-400 mt-0.5">a.n {{ $rek['atas_nama'] }}</p>
                            </div>
                            <div class="w-5 h-5 rounded-full border-2 flex items-center justify-center shrink-0"
                                 :class="pilihanBank === '{{ $rek['bank'] }}' ? 'border-gray-900' : 'border-gray-300'">
                                <div class="w-2.5 h-2.5 rounded-full bg-gray-900"
                                     :class="pilihanBank === '{{ $rek['bank'] }}' ? 'opacity-100 scale-100' : 'opacity-0 scale-0'"></div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                {{-- Upload Bukti --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Upload Bukti Transfer <span class="text-red-400">*</span></label>
                    <div class="border-2 border-dashed border-gray-200 rounded-xl bg-gray-50 hover:border-gray-400 transition-colors">
                        <label class="flex flex-col items-center justify-center p-5 cursor-pointer">
                            <span class="material-icons text-3xl text-gray-300 mb-2">receipt</span>
                            <span class="text-sm font-semibold text-gray-500 mb-1">Klik untuk upload bukti transfer</span>
                            <span class="text-xs text-gray-400">JPG, PNG, PDF — Maks. 4MB</span>
                            <input type="file" name="bukti_pembayaran" class="hidden" accept=".jpg,.jpeg,.png,.pdf" required
                                onchange="document.getElementById('bukti-nama').textContent = this.files[0]?.name || 'Belum ada file'">
                        </label>
                        <div class="pb-3 text-center">
                            <span id="bukti-nama" class="text-xs text-gray-400 font-medium">Belum ada file dipilih</span>
                        </div>
                    </div>
                </div>

                {{-- Catatan --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">Catatan (Opsional)</label>
                    <textarea name="catatan" rows="2" placeholder="Misal: transfer dari rekening atas nama X"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 transition-all resize-none placeholder:text-gray-400"></textarea>
                </div>

                {{-- Submit --}}
                <button type="submit"
                    class="btn-press btn-ripple w-full bg-gray-900 hover:bg-gray-800 text-white py-4 rounded-xl font-bold text-sm transition-colors shadow-lg shadow-gray-900/20 flex items-center justify-center gap-2"
                    :class="pilihanBank === '' ? 'opacity-50 cursor-not-allowed' : ''"
                    :disabled="pilihanBank === ''">
                    <span class="material-icons text-sm">send</span> Kirim Konfirmasi Pembayaran
                </button>
                <p class="text-center text-xs text-gray-400">Admin memverifikasi dalam 1×24 jam kerja.</p>
            </form>
        </div>

        {{-- KANAN: Ringkasan --}}
        <div class="lg:w-72 shrink-0" data-aos="fade-left">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sticky top-28">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-5">Ringkasan Pesanan</p>
                <div class="{{ $reservasi->kavling->cluster->kategori === 'Muslim' ? 'bg-emerald-50 border-emerald-100' : 'bg-amber-50 border-amber-100' }} border rounded-xl p-4 mb-4">
                    <p class="text-[10px] font-bold {{ $reservasi->kavling->cluster->kategori === 'Muslim' ? 'text-emerald-600' : 'text-amber-600' }} uppercase tracking-wider mb-0.5">Kavling</p>
                    <h3 class="text-xl font-bold text-gray-900">#{{ $reservasi->kavling->nomor_kavling }}</h3>
                    <p class="text-xs text-gray-500 mt-0.5">{{ $reservasi->kavling->cluster->nama_cluster }}</p>
                </div>
                <div class="space-y-2.5 text-sm mb-4">
                    <div class="flex justify-between"><span class="text-gray-400">Tipe</span><span class="font-semibold text-gray-800">{{ $reservasi->kavling->tipe_kavling }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-400">Ukuran</span><span class="font-semibold text-gray-800">{{ $reservasi->kavling->ukuran }}</span></div>
                    <div class="flex justify-between">
                        <span class="text-gray-400">Jenazah</span>
                        <span class="font-semibold text-gray-800 text-right max-w-[150px] text-xs leading-tight">
                            {{ $reservasi->nama_jenazah ? 'Alm. '.$reservasi->nama_jenazah : 'Pre-Need' }}
                        </span>
                    </div>
                </div>
                <div class="pt-4 border-t border-gray-100">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-bold text-gray-700">Total Bayar</span>
                        <span class="font-bold text-gray-900">Rp {{ number_format($reservasi->kavling->harga, 0, ',', '.') }}</span>
                    </div>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-amber-400 animate-pulse"></div>
                        <span class="text-xs font-bold text-amber-600">{{ $reservasi->status_reservasi }}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
@endsection