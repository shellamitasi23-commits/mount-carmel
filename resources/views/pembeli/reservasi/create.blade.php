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
                ['label'=>'Konfirmasi','done'=>false,'active'=>false],
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

        <div class="max-w-2xl mx-auto bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-8 shadow-sm" data-aos="fade-up">
            <header class="mb-8 border-b border-gray-100 dark:border-gray-800/50 pb-6">
                <span class="text-xs font-semibold text-[#800000] block mb-1">Langkah 3 dari 5: Isi Data</span>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight mb-2 leading-none">
                    Lengkapi Data Reservasi
                </h1>
                <p class="text-gray-400 dark:text-gray-500 text-xs">
                    Kavling Terpilih: <strong class="text-[#800000]">#{{ $lahan->nomor_lahan }}</strong> ({{ $lahan->tipe_lahan }} &middot; {{ $lahan->cluster->nama_cluster }})
                </p>
            </header>

            <form action="{{ route('pembeli.reservasi.store') }}" method="POST" enctype="multipart/form-data" 
                  class="space-y-8"
                  x-data="{ kebutuhan: 'end_user', metode: 'tunai', nominal_dp: '', lahanHarga: {{ $lahan->harga }}, biayaTambahan: 0 }">
                @csrf
                <input type="hidden" name="lahan_id" value="{{ $lahan->id }}">

                <div class="grid grid-cols-1 gap-8">
                    {{-- Foto KTP Pemesan --}}
                    <div class="group">
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 group-focus-within:text-[#800000] transition-colors mb-2">
                            Foto KTP Pemesan <span class="text-[#800000]">*</span>
                        </label>
                        <input type="file" name="dokumen_ktp" accept=".jpg,.jpeg,.png,.pdf" required
                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl text-sm text-gray-900 dark:text-white focus:border-[#800000] focus:ring-0 transition-all">
                        <p class="text-[10px] font-medium text-gray-400 mt-1.5">Format: JPG, PNG, PDF (Maks. 2MB)</p>
                    </div>

                    {{-- Kategori Kebutuhan --}}
                    <div class="group">
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2">
                            Kategori Kebutuhan <span class="text-[#800000]">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <label class="relative flex items-center p-4 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl cursor-pointer transition-all hover:border-[#800000]/30"
                                   :class="kebutuhan === 'end_user' ? 'ring-2 ring-[#800000] border-[#800000] bg-white dark:bg-gray-800 shadow-sm shadow-[#800000]/5' : ''">
                                <input type="radio" name="kategori_kebutuhan" value="end_user" x-model="kebutuhan" @change="metode = 'tunai'" class="hidden">
                                <div>
                                    <p class="text-xs font-bold text-gray-900 dark:text-white mb-0.5 uppercase tracking-wider">Kebutuhan Segera (End-User)</p>
                                    <p class="text-[9px] font-medium text-gray-400 uppercase tracking-widest">Untuk pemakaman segera (Wajib Tunai)</p>
                                </div>
                            </label>
                            <label class="relative flex items-center p-4 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl cursor-pointer transition-all hover:border-[#800000]/30"
                                   :class="kebutuhan === 'pre_need' ? 'ring-2 ring-[#800000] border-[#800000] bg-white dark:bg-gray-800 shadow-sm shadow-[#800000]/5' : ''">
                                <input type="radio" name="kategori_kebutuhan" value="pre_need" x-model="kebutuhan" class="hidden">
                                <div>
                                    <p class="text-xs font-bold text-gray-900 dark:text-white mb-0.5 uppercase tracking-wider">Persiapan Jangka Panjang (Pre-Need)</p>
                                    <p class="text-[9px] font-medium text-gray-400 uppercase tracking-widest">Bisa Cicil 12 Bulan</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Metode Pembayaran --}}
                    <div class="group">
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2">
                            Metode Pembayaran <span class="text-[#800000]">*</span>
                        </label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {{-- Tunai --}}
                            <label class="relative flex items-center p-4 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl cursor-pointer transition-all hover:border-[#800000]/30"
                                   :class="metode === 'tunai' ? 'ring-2 ring-[#800000] border-[#800000] bg-white dark:bg-gray-800 shadow-sm shadow-[#800000]/5' : ''">
                                <input type="radio" name="metode_pembayaran" value="tunai" x-model="metode" class="hidden">
                                <div>
                                    <p class="text-xs font-bold text-gray-900 dark:text-white mb-0.5 uppercase tracking-wider">Tunai (Cash)</p>
                                    <p class="text-[9px] font-medium text-gray-400 uppercase tracking-widest">Pelunasan di awal</p>
                                </div>
                            </label>

                            {{-- Cicilan dengan DP --}}
                            <label x-show="kebutuhan === 'pre_need'" 
                                   x-transition
                                   class="relative flex items-center p-4 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl cursor-pointer transition-all hover:border-[#800000]/30"
                                   :class="metode === 'cicilan_dp' ? 'ring-2 ring-[#800000] border-[#800000] bg-white dark:bg-gray-800 shadow-sm shadow-[#800000]/5' : ''">
                                <input type="radio" name="metode_pembayaran" value="cicilan_dp" x-model="metode" class="hidden">
                                <div>
                                    <p class="text-xs font-bold text-gray-900 dark:text-white mb-0.5 uppercase tracking-wider">Cicilan + DP</p>
                                    <p class="text-[9px] font-medium text-gray-400 uppercase tracking-widest">DP & cicil 12 bulan</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Input DP (Cicilan dengan DP) --}}
                    <div class="group" x-show="metode === 'cicilan_dp'" x-transition x-cloak>
                        <input type="hidden" name="nominal_dp" :value="lahanHarga * 0.2">
                        <div class="bg-gray-50 dark:bg-gray-950 p-6 rounded-2xl border border-gray-100 dark:border-gray-800">
                            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">Nominal Uang Muka (DP) (20%)</p>
                            <p class="text-xl font-bold text-[#800000]">
                                Rp <span x-text="new Intl.NumberFormat('id-ID').format(lahanHarga * 0.2)"></span>
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Kontak Kerabat --}}
                        <div class="group">
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 group-focus-within:text-[#800000] transition-colors mb-2">
                                Kontak Kerabat <span class="text-gray-400 font-normal text-[11px]">(opsional)</span>
                            </label>
                            <input type="text" name="kontak_kerabat" value="{{ old('kontak_kerabat') }}"
                                placeholder="No. WhatsApp / HP"
                                class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl text-sm font-medium text-gray-900 dark:text-white focus:border-[#800000] focus:ring-0 transition-all placeholder:text-gray-300 dark:placeholder:text-gray-700">
                        </div>

                        {{-- Staf Marketing yang Membantu --}}
                        <div class="group">
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 group-focus-within:text-[#800000] transition-colors mb-2">
                                Staf Marketing yang Membantu <span class="text-gray-400 font-normal text-[11px]">(opsional)</span>
                            </label>
                            <select name="marketing_oleh"
                                class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl text-sm font-medium text-gray-900 dark:text-white focus:border-[#800000] focus:ring-0 transition-all">
                                <option value="">-- Pilih Staf Marketing --</option>
                                @foreach($marketingStaff as $marketing)
                                    <option value="{{ $marketing->name }}" {{ old('marketing_oleh') == $marketing->name ? 'selected' : '' }}>
                                        {{ $marketing->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Alamat --}}
                    <div class="group">
                        <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 group-focus-within:text-[#800000] transition-colors mb-2">
                            Alamat Lengkap Pemesan <span class="text-[#800000]">*</span>
                        </label>
                        <textarea name="alamat_pemesan" rows="3" required placeholder="Alamat pengiriman dokumen/sertifikat"
                            class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl text-sm font-medium text-gray-900 dark:text-white focus:border-[#800000] focus:ring-0 transition-all resize-none placeholder:text-gray-300 dark:placeholder:text-gray-700">{{ old('alamat_pemesan', $user->alamat) }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Nama Jenazah --}}
                        <div class="group">
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 group-focus-within:text-[#800000] transition-colors mb-2">
                                Nama Lengkap Jenazah <span x-show="kebutuhan === 'end_user'" class="text-[#800000]">*</span><span x-show="kebutuhan === 'pre_need'" class="text-gray-400 font-normal text-[11px]">(opsional)</span>
                            </label>
                            <input type="text" name="nama_jenazah" value="{{ old('nama_jenazah') }}"
                                :required="kebutuhan === 'end_user'"
                                placeholder="Tulis nama lengkap sesuai KTP"
                                class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl text-sm font-medium text-gray-900 dark:text-white focus:border-[#800000] focus:ring-0 transition-all placeholder:text-gray-300 dark:placeholder:text-gray-700">
                        </div>
 
                        {{-- Tanggal Dimakamkan --}}
                        <div class="group">
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 group-focus-within:text-[#800000] transition-colors mb-2">
                                Rencana Tanggal Pemakaman <span x-show="kebutuhan === 'end_user'" class="text-[#800000]">*</span><span x-show="kebutuhan === 'pre_need'" class="text-gray-400 font-normal text-[11px]">(opsional)</span>
                            </label>
                            <input type="date" name="tanggal_dimakamkan" value="{{ old('tanggal_dimakamkan') }}" min="{{ date('Y-m-d') }}"
                                :required="kebutuhan === 'end_user'"
                                class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl text-sm font-medium text-gray-900 dark:text-white focus:border-[#800000] focus:ring-0 transition-all">
                        </div>
                    </div>

                    {{-- Kustomisasi Lahan (Khusus Lahan Special) --}}
                    @if(str_contains(strtolower($lahan->tipe_lahan), 'special'))
                    <div class="border-t border-slate-100 dark:border-slate-800 pt-8">
                        <span class="text-xs font-bold text-[#800000] block mb-4">Kustomisasi Lahan (Khusus Lahan Special)</span>
                        <div class="grid grid-cols-1 gap-8">
                            <div class="group">
                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 group-focus-within:text-[#800000] transition-colors mb-2">
                                    Deskripsi Tambahan <span class="text-gray-400 font-normal text-[11px]">(opsional)</span>
                                </label>
                                <textarea name="request_tambahan" rows="3" placeholder="Contoh: Pemasangan nisan granit hitam khusus, penambahan pohon cemara kerdil, dsb."
                                    class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl text-sm font-medium text-gray-900 dark:text-white focus:border-[#800000] focus:ring-0 transition-all resize-none placeholder:text-gray-300 dark:placeholder:text-gray-700"></textarea>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-col sm:flex-row items-center gap-6 pt-6 border-t border-gray-100 dark:border-gray-800/50">
                    <button type="submit"
                        class="w-full sm:flex-1 py-3.5 bg-[#800000] text-white text-xs font-semibold rounded-xl hover:bg-[#900000] transition-all duration-300">
                        Lanjut ke Konfirmasi
                    </button>
                    <a href="{{ route('pembeli.lahan.nomor', ['cluster_id' => $lahan->cluster_id, 'tipe_lahan' => $lahan->tipe_lahan]) }}"
                       class="text-xs font-semibold text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                        Ganti Nomor Lahan
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
