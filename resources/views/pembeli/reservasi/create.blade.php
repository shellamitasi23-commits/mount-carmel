@extends('layouts.master')
@section('title', 'Reservasi — Mount Carmel')

@section('content')
<div class="min-h-screen bg-white dark:bg-gray-950 pt-32 pb-32">
    <div class="max-w-6xl mx-auto px-8">

        {{-- Minimalist Breadcrumb --}}
        <nav class="flex items-center gap-4 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-12" data-aos="fade-down">
            <a href="{{ route('home') }}" class="hover:text-[#800000] transition-colors">Beranda</a>
            <span class="text-gray-200 dark:text-gray-800">/</span>
            <a href="{{ route('cluster.index') }}" class="hover:text-[#800000] transition-colors">Cluster</a>
            <span class="text-gray-200 dark:text-gray-800">/</span>
            <a href="{{ route('pembeli.lahan.index', ['cluster_id' => $lahan->cluster_id]) }}" class="hover:text-[#800000] transition-colors">{{ $lahan->cluster->nama_cluster }}</a>
            <span class="text-gray-200 dark:text-gray-800">/</span>
            <span class="text-gray-900 dark:text-white">Isi Data Reservasi</span>
        </nav>

        {{-- Minimalist Progress Bar --}}
        <div class="flex items-center justify-between max-w-2xl mx-auto mb-20" data-aos="fade-down">
            @foreach([
                ['label'=>'Pilih Lahan','done'=>true,'active'=>false],
                ['label'=>'Pilih Nomor','done'=>true,'active'=>false],
                ['label'=>'Isi Data','done'=>false,'active'=>true],
                ['label'=>'Pembayaran','done'=>false,'active'=>false],
            ] as $s)
            <div class="flex flex-col items-center gap-3 relative">
                <div class="w-6 h-6 rounded-full flex items-center justify-center text-[10px] font-black
                    {{ $s['active'] ? 'bg-[#800000] text-white ring-4 ring-[#800000]/10' :
                       ($s['done'] ? 'bg-[#800000]/20 text-[#800000]' : 'bg-gray-100 text-gray-300 dark:bg-gray-900 dark:text-gray-700') }}">
                    {{ $loop->index + 1 }}
                </div>
                <span class="text-[9px] font-black uppercase tracking-widest whitespace-nowrap
                    {{ $s['active'] ? 'text-[#800000]' : ($s['done'] ? 'text-[#800000]/80' : 'text-gray-300 dark:text-gray-700') }}">
                    {{ $s['label'] }}
                </span>
            </div>
            @if(!$loop->last)
            <div class="flex-1 h-px bg-gray-100 dark:bg-gray-900 mx-4 mb-8"></div>
            @endif
            @endforeach
        </div>

        @if($errors->any())
        <div class="mb-12 p-6 bg-red-50 dark:bg-red-950/20 border-l-4 border-red-500" data-aos="fade-up">
            <ul class="space-y-2">
                @foreach($errors->all() as $err)
                <li class="text-xs font-bold uppercase tracking-widest text-red-600 dark:text-red-400">{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="flex flex-col lg:flex-row gap-16 lg:gap-24">

            {{-- LEFT: Form Section --}}
            <div class="flex-1" data-aos="fade-up">
                <header class="mb-12">
                    <h1 class="text-4xl md:text-5xl font-bold text-gray-900 dark:text-white tracking-tighter mb-4 leading-none">
                        Lengkapi Data Reservasi
                    </h1>
                    <p class="text-gray-400 dark:text-gray-500 text-lg font-light leading-relaxed">
                        Mohon pastikan semua informasi sesuai dengan kartu identitas resmi untuk kelengkapan administrasi sertifikat lahan.
                    </p>
                </header>

                <form action="{{ route('pembeli.reservasi.store') }}" method="POST" enctype="multipart/form-data" 
                      class="space-y-12"
                      x-data="{ metode: 'tunai' }">
                    @csrf
                    <input type="hidden" name="lahan_id" value="{{ $lahan->id }}">

                    <div class="grid grid-cols-1 gap-12">
                        {{-- Dokumen KTP --}}
                        <div class="group">
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 group-focus-within:text-primary transition-colors mb-4">
                                Foto KTP Pemesan <span class="text-primary">*</span>
                            </label>
                            <input type="file" name="dokumen_ktp" accept=".jpg,.jpeg,.png,.pdf" required
                                class="w-full px-6 py-5 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl text-sm text-gray-900 dark:text-white focus:border-primary focus:ring-0 transition-all">
                            <p class="text-[10px] font-bold text-gray-300 mt-3 uppercase tracking-widest">Format: JPG, PNG, PDF (Maks. 2MB)</p>
                        </div>

                        {{-- Metode Pembayaran --}}
                        <div class="group">
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-6">
                                Metode Pembayaran <span class="text-primary">*</span>
                            </label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <label class="relative flex items-center p-6 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl cursor-pointer transition-all hover:border-primary/30"
                                       :class="metode === 'tunai' ? 'ring-2 ring-primary border-primary bg-white dark:bg-gray-800 shadow-lg shadow-primary/5' : ''">
                                    <input type="radio" name="metode_pembayaran" value="tunai" x-model="metode" class="hidden">
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 dark:text-white mb-1 uppercase tracking-wider">Bayar Langsung</p>
                                        <p class="text-[10px] font-medium text-gray-400 uppercase tracking-widest">Pelunasan penuh di awal</p>
                                    </div>
                                </label>
                                <label class="relative flex items-center p-6 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl cursor-pointer transition-all hover:border-primary/30"
                                       :class="metode === 'cicilan' ? 'ring-2 ring-primary border-primary bg-white dark:bg-gray-800 shadow-lg shadow-primary/5' : ''">
                                    <input type="radio" name="metode_pembayaran" value="cicilan" x-model="metode" class="hidden">
                                    <div>
                                        <p class="text-sm font-bold text-gray-900 dark:text-white mb-1 uppercase tracking-wider">Cicilan</p>
                                        <p class="text-[10px] font-medium text-gray-400 uppercase tracking-widest">DP 20% & angsuran bulanan</p>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                            {{-- Tenor --}}
                            <div class="group" x-show="metode === 'cicilan'" x-transition x-cloak>
                                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 group-focus-within:text-primary transition-colors mb-4">
                                    Tenor Cicilan <span class="text-primary">*</span>
                                </label>
                                <select name="tenor_cicilan" :required="metode === 'cicilan'"
                                    class="w-full px-6 py-5 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl text-lg font-medium text-gray-900 dark:text-white focus:border-primary focus:ring-0 transition-all appearance-none">
                                    <option value="">Pilih Jangka Waktu</option>
                                    @for($i = 1; $i <= 24; $i++)
                                    <option value="{{ $i }}" {{ old('tenor_cicilan') == $i ? 'selected' : '' }}>{{ $i }} Bulan</option>
                                    @endfor
                                </select>
                            </div>

                            {{-- Kontak Kerabat --}}
                            <div class="group">
                                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 group-focus-within:text-primary transition-colors mb-4">
                                    Kontak Kerabat <span class="text-gray-300 lowercase font-normal">(opsional)</span>
                                </label>
                                <input type="text" name="kontak_kerabat" value="{{ old('kontak_kerabat') }}"
                                    placeholder="No. WhatsApp / HP"
                                    class="w-full px-6 py-5 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl text-lg font-medium text-gray-900 dark:text-white focus:border-primary focus:ring-0 transition-all placeholder:text-gray-200 dark:placeholder:text-gray-800">
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="group">
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 group-focus-within:text-primary transition-colors mb-4">
                                Alamat Lengkap Pemesan <span class="text-primary">*</span>
                            </label>
                            <textarea name="alamat_pemesan" rows="3" required placeholder="Alamat pengiriman dokumen/sertifikat"
                                class="w-full px-6 py-5 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl text-lg font-medium text-gray-900 dark:text-white focus:border-primary focus:ring-0 transition-all resize-none placeholder:text-gray-200 dark:placeholder:text-gray-800">{{ old('alamat_pemesan', $user->alamat) }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                            {{-- Nama Jenazah --}}
                            <div class="group">
                                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 group-focus-within:text-primary transition-colors mb-4">
                                    Nama Lengkap Jenazah <span class="text-gray-300 lowercase font-normal">(opsional)</span>
                                </label>
                                <input type="text" name="nama_jenazah" value="{{ old('nama_jenazah') }}"
                                    placeholder="Tulis nama lengkap sesuai KTP"
                                    class="w-full px-6 py-5 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl text-lg font-medium text-gray-900 dark:text-white focus:border-primary focus:ring-0 transition-all placeholder:text-gray-200 dark:placeholder:text-gray-800">
                            </div>

                            {{-- Tanggal Dimakamkan --}}
                            <div class="group">
                                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 group-focus-within:text-primary transition-colors mb-4">
                                    Rencana Tanggal Pemakaman <span class="text-gray-300 lowercase font-normal">(opsional)</span>
                                </label>
                                <input type="date" name="tanggal_dimakamkan" value="{{ old('tanggal_dimakamkan') }}" min="{{ date('Y-m-d') }}"
                                    class="w-full px-6 py-5 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl text-lg font-medium text-gray-900 dark:text-white focus:border-primary focus:ring-0 transition-all">
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row items-center gap-8 pt-8">
                        <button type="submit"
                            class="w-full sm:flex-1 py-6 bg-[#800000] text-white text-[11px] font-black uppercase tracking-[0.3em] rounded-2xl hover:bg-[#800000]/90 transition-all duration-300 shadow-xl shadow-[#800000]/10">
                            Lanjut ke Pembayaran
                        </button>
                        <a href="{{ route('pembeli.lahan.nomor', ['cluster_id' => $lahan->cluster_id, 'tipe_lahan' => $lahan->tipe_lahan]) }}"
                           class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors border-b border-transparent hover:border-gray-900">
                            Ganti Nomor Kavling
                        </a>
                    </div>
                </form>
            </div>

            {{-- RIGHT: Summary Sidebar --}}
            <div class="lg:w-96 shrink-0" data-aos="fade-left">
                <div class="sticky top-32">
                    <div class="bg-gray-50/50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-800 rounded-[2rem] p-10">
                        <span class="text-[9px] font-black uppercase tracking-[0.2em] text-primary block mb-10">Ringkasan Pesanan</span>
                        
                        <div class="space-y-10">
                            <div>
                                <span class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-300 block mb-2">Lokasi Terpilih</span>
                                <h3 class="text-4xl font-bold text-gray-900 dark:text-white tracking-tighter">#{{ $lahan->nomor_lahan }}</h3>
                                <p class="text-xs font-bold text-primary mt-1 uppercase tracking-widest">{{ $lahan->tipe_lahan }}</p>
                            </div>

                            <div class="space-y-4">
                                <div class="flex justify-between items-center border-b border-gray-100 dark:border-gray-800/50 pb-3">
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Cluster</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $lahan->cluster->nama_cluster }}</span>
                                </div>
                                <div class="flex justify-between items-center border-b border-gray-100 dark:border-gray-800/50 pb-3">
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-gray-400">Dimensi</span>
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $lahan->ukuran }}</span>
                                </div>
                            </div>

                            <div class="pt-6">
                                <span class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-300 block mb-2">Total Investasi</span>
                                <h3 class="text-3xl font-bold text-gray-900 dark:text-white tracking-tighter font-poppins">
                                    Rp {{ number_format($lahan->harga, 0, ',', '.') }}
                                </h3>
                            </div>

                            <div class="pt-10 border-t border-gray-100 dark:border-gray-800/50">
                                <span class="text-[9px] font-black uppercase tracking-[0.2em] text-gray-300 block mb-3">Identitas Pemesan</span>
                                <p class="text-sm font-bold text-gray-900 dark:text-white mb-1">{{ $user->name }}</p>
                                <p class="text-xs text-gray-400">{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
