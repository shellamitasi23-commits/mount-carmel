@extends('layouts.master')
@section('title', 'Konfirmasi Pembayaran — Mount Carmel')

@section('content')
<div class="min-h-screen bg-white dark:bg-gray-950 pt-32 pb-32">
    <div class="max-w-6xl mx-auto px-8">

        {{-- Minimalist Breadcrumb --}}
        <nav class="flex items-center gap-4 text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-12" data-aos="fade-down">
            <a href="{{ route('home') }}" class="hover:text-[#800000] transition-colors">Beranda</a>
            <span class="text-gray-200 dark:text-gray-800">/</span>
            <a href="{{ route('pembeli.reservasi.index') }}" class="hover:text-[#800000] transition-colors">Reservasi</a>
            <span class="text-gray-200 dark:text-gray-800">/</span>
            <span class="text-gray-900 dark:text-white">Pembayaran</span>
        </nav>

        {{-- Minimalist Progress Bar --}}
        <div class="flex items-center justify-between max-w-2xl mx-auto mb-20" data-aos="fade-down">
            @foreach([
                ['label'=>'Pilih Lahan','done'=>true,'active'=>false],
                ['label'=>'Pilih Nomor','done'=>true,'active'=>false],
                ['label'=>'Isi Data','done'=>true,'active'=>false],
                ['label'=>'Konfirmasi','done'=>true,'active'=>false],
                ['label'=>'Pembayaran','done'=>false,'active'=>true],
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
        <div class="mb-12 p-6 bg-red-50 dark:bg-red-950/20 border-l-4 border-red-500 rounded-r-xl" data-aos="fade-up">
            <p class="text-xs font-bold uppercase tracking-widest text-red-600 dark:text-red-400 mb-2">Mohon Perbaiki Kesalahan Berikut:</p>
            <ul class="space-y-1 text-[11px] font-bold uppercase tracking-widest text-red-550 dark:text-red-450">
                @foreach($errors->all() as $err)
                <li>— {{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="max-w-2xl mx-auto bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-3xl p-8 shadow-sm" data-aos="fade-up">
            <header class="mb-8 border-b border-gray-100 dark:border-gray-800/50 pb-6">
                <span class="text-[9px] font-black uppercase tracking-[0.2em] text-[#800000] block mb-2">Langkah 5 dari 5: Pembayaran</span>
                <h1 class="text-2xl font-extrabold text-gray-900 dark:text-white tracking-tight mb-2 leading-none">
                    Konfirmasi Pembayaran
                </h1>
                <p class="text-gray-400 dark:text-gray-500 text-xs leading-relaxed">
                    Kavling Terpilih: <strong class="text-[#800000]">#{{ $reservasi->lahan->nomor_lahan }}</strong> ({{ $reservasi->lahan->tipe_lahan }} &middot; {{ $reservasi->lahan->cluster->nama_cluster }})
                </p>
                <p class="text-gray-400 dark:text-gray-500 text-xs mt-1">
                    Tahap: <strong class="text-gray-700 dark:text-gray-300">{{ $namaPembayaran }}</strong>
                </p>
            </header>

            <form action="{{ route('pembeli.pembayaran.store') }}" method="POST" enctype="multipart/form-data"
                  x-data="{ pilihanBank: '', nomorRek: '', atasNama: '' }"
                  class="space-y-8">
                @csrf
                <input type="hidden" name="reservasi_id" value="{{ $reservasi->id }}">
                <input type="hidden" name="jumlah_bayar" value="{{ $jumlahBayar }}">
                <input type="hidden" name="nama_bank" x-bind:value="pilihanBank">
                <input type="hidden" name="rekening_tujuan" x-bind:value="nomorRek">
                <input type="hidden" name="atas_nama_rekening" x-bind:value="atasNama">

                {{-- Amount Display --}}
                <div class="bg-gray-50 dark:bg-gray-950 p-6 rounded-2xl border border-gray-100/50 dark:border-gray-900/50 text-center">
                    <p class="text-xs font-semibold text-gray-500 dark:text-gray-450 mb-1">Nominal Yang Harus Ditransfer</p>
                    <div class="text-3xl font-extrabold text-[#800000] tracking-tight">
                        Rp {{ number_format($jumlahBayar, 0, ',', '.') }}
                    </div>
                    <p class="text-xs font-semibold text-emerald-600 dark:text-emerald-500 mt-1">
                        Mohon transfer tepat sesuai nominal di atas
                    </p>
                </div>

                {{-- Bank Selection --}}
                <div class="group">
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2">
                        Pilih Rekening Tujuan <span class="text-[#800000]">*</span>
                    </label>
                    <div class="grid grid-cols-1 gap-3">
                        @foreach($rekening as $rek)
                        <div class="relative">
                            <input type="radio" name="bank_radio" id="bank_{{ $rek['bank'] }}" class="hidden peer"
                                   @change="pilihanBank = '{{ $rek['bank'] }}'; nomorRek = '{{ $rek['nomor'] }}'; atasNama = '{{ $rek['atas_nama'] }}'">
                            <label for="bank_{{ $rek['bank'] }}" 
                                   class="flex items-center justify-between p-4 border border-gray-100 dark:border-gray-800 rounded-xl cursor-pointer transition-all duration-300 peer-checked:border-[#800000] peer-checked:ring-2 peer-checked:ring-[#800000]/10 hover:border-gray-200 dark:hover:border-gray-700 bg-gray-50 dark:bg-gray-950 peer-checked:bg-white dark:peer-checked:bg-gray-900">
                                <div>
                                    <span class="text-xs font-bold text-[#800000] block mb-0.5">{{ $rek['bank'] }}</span>
                                    <span class="text-base font-extrabold text-gray-950 dark:text-white tracking-wider">{{ $rek['nomor'] }}</span>
                                    <span class="text-[10px] font-medium text-gray-400 dark:text-gray-500 block">a.n {{ $rek['atas_nama'] }}</span>
                                </div>
                                <div class="w-5 h-5 rounded-full border border-gray-200 dark:border-gray-750 flex items-center justify-center peer-checked:border-[#800000]">
                                    <div class="w-2.5 h-2.5 rounded-full bg-[#800000] transition-opacity duration-300"
                                         :class="pilihanBank === '{{ $rek['bank'] }}' ? 'opacity-100' : 'opacity-0'"></div>
                                </div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Upload Proof --}}
                <div class="group">
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-3">
                        Unggah Bukti Transfer <span class="text-[#800000]">*</span>
                    </label>
                    <div x-data="{ fileName: '' }" class="relative">
                        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" accept=".jpg,.jpeg,.png,.pdf" required
                               @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''"
                               class="sr-only">
                        <label for="bukti_pembayaran" 
                               class="flex flex-col items-center justify-center border-2 border-dashed border-gray-200 dark:border-gray-800 rounded-2xl p-6 bg-gray-50/50 dark:bg-gray-900/30 hover:bg-gray-50 dark:hover:bg-gray-900 hover:border-[#800000]/40 dark:hover:border-[#800000]/40 transition-all duration-300 cursor-pointer text-center group/upload">
                            <div class="w-10 h-10 rounded-full bg-[#800000]/5 dark:bg-[#800000]/10 flex items-center justify-center text-[#800000] mb-3 transition-transform duration-300 group-hover/upload:-translate-y-1">
                                <i class="bi bi-cloud-arrow-up text-lg"></i>
                            </div>
                            <p class="text-xs font-bold text-gray-700 dark:text-gray-300 mb-1">
                                <span x-text="fileName ? 'Ganti Bukti Transfer' : 'Pilih File Bukti Transfer'"></span>
                            </p>
                            <p class="text-[9px] font-semibold text-gray-400 uppercase tracking-wider mb-2">
                                Format: JPG, PNG, atau PDF (Maks. 4MB)
                            </p>
                            <div x-show="fileName" x-transition class="inline-flex items-center gap-1.5 px-3 py-1 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-[10px] font-semibold text-slate-700 dark:text-slate-300 max-w-full">
                                <i class="bi bi-paperclip"></i>
                                <span x-text="fileName" class="truncate max-w-[200px]"></span>
                            </div>
                        </label>
                    </div>
                </div>

                {{-- Notes --}}
                <div class="group">
                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 group-focus-within:text-[#800000] transition-colors mb-2">
                        Catatan Tambahan <span class="text-gray-400 font-normal text-[11px]">(opsional)</span>
                    </label>
                    <textarea name="catatan" rows="3" placeholder="Contoh: Transfer atas nama Budi Santoso..."
                        class="w-full px-5 py-3 bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-xl text-xs font-medium text-gray-900 dark:text-white focus:border-[#800000] focus:ring-0 transition-all resize-none placeholder:text-gray-200 dark:placeholder:text-gray-800"></textarea>
                </div>

                {{-- Submit Button --}}
                <div class="flex flex-col sm:flex-row items-center gap-6 pt-6 border-t border-gray-100 dark:border-gray-800/50">
                    <button type="submit"
                        class="w-full sm:flex-1 py-3.5 bg-[#800000] text-white text-xs font-semibold rounded-xl hover:bg-[#900000] transition-all duration-300 disabled:opacity-40 disabled:cursor-not-allowed"
                        :disabled="!pilihanBank">
                        Kirim Konfirmasi Pembayaran
                    </button>
                    <a href="{{ route('pembeli.reservasi.konfirmasi', ['id' => $reservasi->id]) }}"
                       class="text-xs font-semibold text-gray-400 hover:text-gray-900 dark:hover:text-white transition-colors">
                        Kembali Ke Detail
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
