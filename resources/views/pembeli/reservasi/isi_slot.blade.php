@extends('layouts.master')
@section('title', 'Isi Data Slot Lahan — Mount Carmel')

@section('content')
<div class="min-h-screen bg-[#F9FAFB] pt-28 pb-20">
    <div class="max-w-2xl mx-auto px-6">

        {{-- Breadcrumb / Back --}}
        <div class="mb-8" data-aos="fade-up">
            <a href="{{ route('pembeli.reservasi.index') }}" 
               class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-900 transition-colors text-xs font-bold uppercase tracking-wider">
                <span class="material-icons text-sm">arrow_back</span> Kembali ke Reservasi Saya
            </a>
        </div>

        {{-- Form Card --}}
        <div class="bg-white border-t-4 border-[#800000] shadow-xl rounded-2xl p-8 md:p-10" data-aos="fade-up" data-aos-delay="100">
            <div class="mb-8">
                <span class="inline-block text-[#800000] font-black tracking-widest text-[10px] uppercase mb-2">
                    Slot Lahan #{{ $reservasi->lahan->nomor_lahan }}
                </span>
                <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight mb-2">
                    Isi Data Diri Slot #{{ $nomor_slot }}
                </h1>
                <p class="text-slate-500 text-xs leading-relaxed">
                    Masukkan informasi lengkap data diri jenazah yang akan menempati **Slot #{{ $nomor_slot }}** pada unit lahan ini.
                </p>
            </div>

            {{-- Detail Lahan --}}
            <div class="bg-slate-50 border border-slate-100 rounded-xl p-4 mb-8 flex items-center justify-between text-xs font-bold text-slate-600">
                <div>
                    <span class="text-slate-400 font-bold block uppercase tracking-wider text-[9px]">Cluster</span>
                    <span class="text-slate-800">{{ $reservasi->lahan->cluster->nama_cluster }}</span>
                </div>
                <div class="text-right">
                    <span class="text-slate-400 font-bold block uppercase tracking-wider text-[9px]">Tipe Lahan / Kapasitas</span>
                    <span class="text-slate-800">{{ $reservasi->lahan->tipe_lahan }} (Kapasitas {{ $reservasi->lahan->kapasitas }} Slot)</span>
                </div>
            </div>

            <form action="{{ route('pembeli.reservasi.simpan_slot', ['reservasi_id' => $reservasi->id, 'nomor_slot' => $nomor_slot]) }}" method="POST" class="space-y-6">
                @csrf

                {{-- Nama Jenazah --}}
                <div class="space-y-2">
                    <label for="nama_jenazah" class="block text-xs font-black uppercase tracking-wider text-slate-700">Nama Lengkap Jenazah <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_jenazah" id="nama_jenazah" 
                           value="{{ old('nama_jenazah', $existingDetail->nama_jenazah ?? '') }}" required placeholder="Contoh: Alm. Budi Santoso"
                           class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-semibold shadow-sm focus:ring-4 focus:ring-[#800000]/5 focus:border-[#800000] outline-none transition-all placeholder:text-slate-300 @error('nama_jenazah') border-red-500 @enderror">
                    @error('nama_jenazah')
                        <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal Dimakamkan --}}
                <div class="space-y-2">
                    <label for="tanggal_dimakamkan" class="block text-xs font-black uppercase tracking-wider text-slate-700">Tanggal Pemakaman (Opsional)</label>
                    <input type="date" name="tanggal_dimakamkan" id="tanggal_dimakamkan" 
                           value="{{ old('tanggal_dimakamkan', $existingDetail->tanggal_dimakamkan ?? '') }}"
                           class="w-full px-4 py-3 bg-white border border-slate-200 rounded-xl text-sm font-semibold shadow-sm focus:ring-4 focus:ring-[#800000]/5 focus:border-[#800000] outline-none transition-all placeholder:text-slate-300 @error('tanggal_dimakamkan') border-red-500 @enderror">
                    <p class="text-[10px] text-slate-400 italic">Kosongkan jika pemakaman belum dijadwalkan (pre-need).</p>
                    @error('tanggal_dimakamkan')
                        <p class="text-xs text-red-500 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Buttons --}}
                <div class="flex items-center justify-end gap-4 pt-4 border-t border-slate-100">
                    <a href="{{ route('pembeli.reservasi.index') }}" 
                       class="px-6 py-3 border border-slate-200 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-50 transition-colors">
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-[#800000] text-white rounded-xl text-xs font-bold hover:bg-[#800000]/95 transition-all shadow-md active:scale-95">
                        Simpan Data Slot
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
