@extends('layouts.master')
@section('title', 'Form Reservasi — Mount Carmel')

@section('content')
<div class="min-h-screen bg-[#F3F4F6] pt-28 pb-20">
<div class="max-w-4xl mx-auto px-6">

    {{-- Breadcrumb --}}
    <nav class="flex items-center gap-2 text-sm text-gray-400 mb-8" data-aos="fade-down">
        <a href="{{ route('home') }}" class="hover:text-gray-600 transition-colors">Beranda</a>
        <span class="material-icons text-xs">chevron_right</span>
        <a href="{{ route('cluster.index') }}" class="hover:text-gray-600 transition-colors">Cluster</a>
        <span class="material-icons text-xs">chevron_right</span>
        <a href="{{ route('pembeli.kavling.index', ['cluster_id' => $kavling->cluster_id]) }}"
           class="hover:text-gray-600 transition-colors">{{ $kavling->cluster->nama_cluster }}</a>
        <span class="material-icons text-xs">chevron_right</span>
        <a href="{{ route('pembeli.kavling.nomor', ['cluster_id' => $kavling->cluster_id, 'tipe_kavling' => $kavling->tipe_kavling]) }}"
           class="hover:text-gray-600 transition-colors">{{ $kavling->tipe_kavling }}</a>
        <span class="material-icons text-xs">chevron_right</span>
        <span class="text-gray-700 font-semibold">Form Reservasi</span>
    </nav>

    {{-- Progress --}}
    <div class="flex items-center mb-10" data-aos="fade-down" data-aos-delay="50">
        @foreach([
            ['label'=>'Pilih Tipe','done'=>true,'active'=>false],
            ['label'=>'Pilih Nomor','done'=>true,'active'=>false],
            ['label'=>'Isi Data','done'=>false,'active'=>true],
            ['label'=>'Pembayaran','done'=>false,'active'=>false],
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

    @if(session('error'))
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-xl text-sm flex items-center gap-2">
        <span class="material-icons text-sm">error</span> {{ session('error') }}
    </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-8">

        {{-- KIRI: Form --}}
        <div class="flex-1" data-aos="fade-up">
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-1">Isi Data Reservasi</h1>
                <p class="text-gray-500 text-sm">Lengkapi data sesuai dokumen resmi. Semua data tercatat di sertifikat kavling.</p>
            </div>

            <form action="{{ route('pembeli.reservasi.store') }}" method="POST" enctype="multipart/form-data"
                  x-data="{ jenis: '{{ old('jenis_reservasi', 'at-need') }}' }"
                  class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
                @csrf
                <input type="hidden" name="kavling_id" value="{{ $kavling->id }}">
                <input type="hidden" name="jenis_reservasi" x-bind:value="jenis">

                {{-- Toggle Jenis Reservasi --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-3">
                        Jenis Pemesanan <span class="text-red-400">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="flex flex-col gap-2 p-4 border-2 rounded-xl cursor-pointer transition-all"
                               :class="jenis === 'at-need' ? 'border-gray-900 bg-gray-50' : 'border-gray-200 hover:border-gray-300'"
                               @click="jenis = 'at-need'">
                            <div class="flex items-center justify-between">
                                <span class="material-icons text-xl" :class="jenis === 'at-need' ? 'text-gray-900' : 'text-gray-300'">local_hospital</span>
                                <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center" :class="jenis === 'at-need' ? 'border-gray-900' : 'border-gray-300'">
                                    <div class="w-2 h-2 rounded-full bg-gray-900" :class="jenis === 'at-need' ? 'opacity-100' : 'opacity-0'"></div>
                                </div>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-gray-900">Langsung (At-Need)</p>
                                <p class="text-xs text-gray-400 mt-0.5">Jenazah sudah ada, segera dimakamkan</p>
                            </div>
                        </label>
                        <label class="flex flex-col gap-2 p-4 border-2 rounded-xl cursor-pointer transition-all"
                               :class="jenis === 'pre-need' ? 'border-gray-900 bg-gray-50' : 'border-gray-200 hover:border-gray-300'"
                               @click="jenis = 'pre-need'">
                            <div class="flex items-center justify-between">
                                <span class="material-icons text-xl" :class="jenis === 'pre-need' ? 'text-gray-900' : 'text-gray-300'">bookmark_add</span>
                                <div class="w-4 h-4 rounded-full border-2 flex items-center justify-center" :class="jenis === 'pre-need' ? 'border-gray-900' : 'border-gray-300'">
                                    <div class="w-2 h-2 rounded-full bg-gray-900" :class="jenis === 'pre-need' ? 'opacity-100' : 'opacity-0'"></div>
                                </div>
                            </div>
                            <div>
                                <p class="font-bold text-sm text-gray-900">Persiapan (Pre-Need)</p>
                                <p class="text-xs text-gray-400 mt-0.5">Pesan sekarang, jenazah menyusul</p>
                            </div>
                        </label>
                    </div>
                    <div x-show="jenis === 'pre-need'" x-transition
                         class="mt-3 bg-blue-50 border border-blue-100 rounded-xl px-4 py-3 text-xs text-blue-700 flex items-start gap-2">
                        <span class="material-icons text-sm mt-0.5">info</span>
                        Nama jenazah dan tanggal tidak wajib diisi sekarang, bisa dilengkapi nanti melalui admin.
                    </div>
                </div>

                {{-- Nama Jenazah --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                        Nama Lengkap Jenazah
                        <span x-show="jenis === 'at-need'" class="text-red-400">*</span>
                        <span x-show="jenis === 'pre-need'" class="text-gray-400 normal-case font-normal">(opsional)</span>
                    </label>
                    <input type="text" name="nama_jenazah" value="{{ old('nama_jenazah') }}"
                        :required="jenis === 'at-need'"
                        placeholder="Sesuai KTP / Sertifikat Kematian"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 transition-all placeholder:text-gray-400">
                </div>

                {{-- Tanggal Dimakamkan --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                        Tanggal Rencana Dimakamkan
                        <span x-show="jenis === 'at-need'" class="text-red-400">*</span>
                        <span x-show="jenis === 'pre-need'" class="text-gray-400 normal-case font-normal">(opsional)</span>
                    </label>
                    <input type="date" name="tanggal_dimakamkan" value="{{ old('tanggal_dimakamkan') }}"
                        :required="jenis === 'at-need'"
                        min="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 transition-all">
                </div>

                {{-- Alamat --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                        Alamat Lengkap Pemesan <span class="text-red-400">*</span>
                    </label>
                    <textarea name="alamat_pemesan" rows="3" required
                        placeholder="Alamat lengkap keluarga / pemesan"
                        class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm text-gray-800 outline-none focus:border-gray-900 focus:ring-2 focus:ring-gray-900/10 transition-all resize-none placeholder:text-gray-400">{{ old('alamat_pemesan', $user->alamat) }}</textarea>
                    <p class="text-xs text-gray-400 mt-1">Otomatis diisi dari profil, bisa diubah.</p>
                </div>

                {{-- Upload KTP --}}
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">
                        Dokumen KTP Pemesan <span class="text-red-400">*</span>
                    </label>
                    <div class="border-2 border-dashed border-gray-200 rounded-xl bg-gray-50 hover:border-gray-400 transition-colors">
                        <label class="flex flex-col items-center justify-center p-5 cursor-pointer">
                            <span class="material-icons text-3xl text-gray-300 mb-2">upload_file</span>
                            <span class="text-sm font-semibold text-gray-500 mb-1">Klik untuk upload KTP</span>
                            <span class="text-xs text-gray-400">JPG, PNG, PDF — Maks. 2MB</span>
                            <input type="file" name="dokumen_ktp" class="hidden" accept=".jpg,.jpeg,.png,.pdf" required
                                onchange="document.getElementById('ktp-nama').textContent = this.files[0]?.name || 'Belum ada file'">
                        </label>
                        <div class="pb-3 text-center">
                            <span id="ktp-nama" class="text-xs text-gray-400 font-medium">Belum ada file dipilih</span>
                        </div>
                    </div>
                </div>

                {{-- Tombol --}}
                <div class="flex flex-col sm:flex-row gap-3 pt-2">
                    <a href="{{ route('pembeli.kavling.nomor', ['cluster_id' => $kavling->cluster_id, 'tipe_kavling' => $kavling->tipe_kavling]) }}"
                       class="btn-press flex-none px-6 py-3 border-2 border-gray-200 rounded-xl text-sm font-semibold text-gray-500 hover:border-gray-400 transition-colors text-center flex items-center justify-center gap-2">
                        <span class="material-icons text-sm">arrow_back</span> Ganti Nomor
                    </a>
                    <button type="submit"
                        class="btn-press btn-ripple flex-1 bg-gray-900 hover:bg-gray-800 text-white py-3 rounded-xl text-sm font-bold transition-colors flex items-center justify-center gap-2 shadow-lg shadow-gray-900/20">
                        Lanjut ke Pembayaran <span class="material-icons text-sm">arrow_forward</span>
                    </button>
                </div>
            </form>
        </div>

        {{-- KANAN: Info Kavling --}}
        <div class="lg:w-72 shrink-0" data-aos="fade-left">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sticky top-28">
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-4">Kavling Dipilih</p>
                <div class="{{ $kavling->cluster->kategori === 'Muslim' ? 'bg-emerald-50 border-emerald-100' : 'bg-amber-50 border-amber-100' }} border rounded-xl p-4 mb-5">
                    <p class="text-[10px] font-bold {{ $kavling->cluster->kategori === 'Muslim' ? 'text-emerald-600' : 'text-amber-600' }} uppercase tracking-wider mb-0.5">Nomor</p>
                    <h3 class="text-2xl font-bold text-gray-900">#{{ $kavling->nomor_kavling }}</h3>
                </div>
                <div class="space-y-2.5 text-sm mb-5">
                    <div class="flex justify-between"><span class="text-gray-400">Cluster</span><span class="font-semibold text-gray-800 text-right max-w-[150px] leading-tight">{{ $kavling->cluster->nama_cluster }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-400">Tipe</span><span class="font-semibold text-gray-800">{{ $kavling->tipe_kavling }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-400">Ukuran</span><span class="font-semibold text-gray-800">{{ $kavling->ukuran }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-400">Kapasitas</span><span class="font-semibold text-gray-800">{{ $kavling->kapasitas }} orang</span></div>
                </div>
                <div class="pt-4 border-t border-gray-100 flex justify-between items-center">
                    <span class="text-sm text-gray-400">Total Harga</span>
                    <span class="font-bold text-gray-900">Rp {{ number_format($kavling->harga, 0, ',', '.') }}</span>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-2">Pemesan</p>
                    <p class="text-sm font-bold text-gray-800">{{ $user->name }}</p>
                    <p class="text-xs text-gray-400">{{ $user->email }}</p>
                </div>
            </div>
        </div>

    </div>
</div>
</div>
@endsection