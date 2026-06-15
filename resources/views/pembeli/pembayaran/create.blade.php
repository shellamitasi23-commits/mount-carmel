@extends('layouts.master')
@section('title', 'Konfirmasi Pembayaran — Mount Carmel')

@section('content')
<div class="min-h-screen bg-[#F8F9FA] pt-32 pb-24">
<div class="max-w-5xl mx-auto px-8">

    {{-- Breadcrumb (Simplified) --}}
    <nav class="flex items-center gap-3 text-[11px] font-black uppercase tracking-[0.2em] text-slate-400 mb-12">
        <a href="{{ route('home') }}" class="hover:text-slate-900 transition-colors">Beranda</a>
        <span>/</span>
        <a href="{{ route('pembeli.pembayaran.index') }}" class="hover:text-slate-900 transition-colors">Pembayaran</a>
        <span>/</span>
        <span class="text-slate-900">Konfirmasi</span>
    </nav>

    {{-- Progress Stepper (Minimalist) --}}
    <div class="mb-16 border-b border-slate-100 pb-8">
        <div class="flex justify-between items-center max-w-2xl">
            @foreach([
                ['label'=>'Tipe Lahan','done'=>true],
                ['label'=>'Nomor Lahan','done'=>true],
                ['label'=>'Isi Data','done'=>true],
                ['label'=>'Pembayaran','active'=>true],
            ] as $s)
            <div class="flex flex-col gap-2">
                <span class="text-[10px] font-black uppercase tracking-widest {{ isset($s['active']) ? 'text-[#800000]' : 'text-slate-300' }}">
                    {{ $s['label'] }}
                </span>
                <div class="h-1 w-12 {{ isset($s['active']) ? 'bg-[#800000]' : (isset($s['done']) ? 'bg-slate-200' : 'bg-slate-50') }}"></div>
            </div>
            @endforeach
        </div>
    </div>

    @if($errors->any())
    <div class="mb-10 bg-rose-50 border-l-4 border-rose-600 p-6">
        <p class="text-rose-800 font-bold text-sm mb-2 uppercase tracking-tight">Mohon Perbaiki Kesalahan Berikut:</p>
        <ul class="text-rose-700 text-sm space-y-1 font-medium">
            @foreach($errors->all() as $err)
            <li>— {{ $err }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">

        {{-- LEFT: Form Section --}}
        <div class="lg:col-span-7">
            <div class="mb-12">
                <h1 class="text-4xl font-black text-slate-900 tracking-tight mb-4">Konfirmasi Pembayaran</h1>
                <p class="text-lg text-slate-500 leading-relaxed">Silakan lakukan transfer sesuai nominal di bawah, kemudian lampirkan bukti fotonya untuk kami validasi.</p>
            </div>

            <form action="{{ route('pembeli.pembayaran.store') }}" method="POST" enctype="multipart/form-data"
                  x-data="{ pilihanBank: '', nomorRek: '', atasNama: '' }"
                  class="space-y-12">
                @csrf
                <input type="hidden" name="reservasi_id" value="{{ $reservasi->id }}">
                <input type="hidden" name="jumlah_bayar" value="{{ $reservasi->lahan->harga }}">
                <input type="hidden" name="nama_bank" x-bind:value="pilihanBank">
                <input type="hidden" name="rekening_tujuan" x-bind:value="nomorRek">
                <input type="hidden" name="atas_nama_rekening" x-bind:value="atasNama">

                {{-- Amount Display (Extra Large for Elderly) --}}
                <div class="bg-white p-10 border border-slate-100 shadow-2xl shadow-slate-200/50 rounded-[2rem]">
                    <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Total Transfer</p>
                    <div class="flex flex-col gap-1">
                        <span class="text-5xl font-black text-slate-900 tracking-tighter">
                            Rp {{ number_format($reservasi->lahan->harga, 0, ',', '.') }}
                        </span>
                        <p class="text-sm font-bold text-emerald-600 mt-2">Mohon transfer sesuai nominal di atas.</p>
                    </div>
                </div>

                {{-- Bank Selection --}}
                <div>
                    <label class="block text-[11px] font-black text-slate-900 uppercase tracking-[0.2em] mb-6">Pilih Rekening Tujuan</label>
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($rekening as $rek)
                        <div class="relative group">
                            <input type="radio" name="bank_radio" id="bank_{{ $rek['bank'] }}" class="hidden peer"
                                   @change="pilihanBank = '{{ $rek['bank'] }}'; nomorRek = '{{ $rek['nomor'] }}'; atasNama = '{{ $rek['atas_nama'] }}'">
                            <label for="bank_{{ $rek['bank'] }}" 
                                   class="flex items-center justify-between p-8 border-2 rounded-2xl cursor-pointer transition-all duration-300 peer-checked:border-[#800000] peer-checked:bg-slate-50 border-slate-100 hover:border-slate-200">
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">{{ $rek['bank'] }}</p>
                                    <p class="text-2xl font-black text-slate-900 tracking-widest">{{ $rek['nomor'] }}</p>
                                    <p class="text-sm font-medium text-slate-500 mt-1">a.n {{ $rek['atas_nama'] }}</p>
                                </div>
                                <div class="w-6 h-6 rounded-full border-2 border-slate-200 flex items-center justify-center peer-checked:border-[#800000]">
                                    <div class="w-3 h-3 rounded-full bg-[#800000] opacity-0 peer-checked:opacity-100 transition-opacity"
                                         :class="pilihanBank === '{{ $rek['bank'] }}' ? 'opacity-100' : 'opacity-0'"></div>
                                </div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Upload Proof --}}
                <div>
                    <label class="block text-[11px] font-black text-slate-900 uppercase tracking-[0.2em] mb-6">Upload Foto Bukti Transfer</label>
                    <div class="relative group">
                        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="hidden" accept=".jpg,.jpeg,.png,.pdf" required
                               onchange="document.getElementById('file_name_display').textContent = this.files[0]?.name">
                        <label for="bukti_pembayaran" 
                               class="flex flex-col items-center justify-center p-12 border-2 border-dashed border-slate-200 rounded-[2rem] bg-slate-50 hover:bg-white hover:border-[#800000] transition-all cursor-pointer text-center">
                            <span class="text-sm font-black text-slate-900 uppercase tracking-widest mb-2" id="file_name_display">Pilih Foto Bukti</span>
                            <span class="text-xs text-slate-400 font-medium italic">Format: JPG, PNG, atau PDF (Maks. 4MB)</span>
                        </label>
                    </div>
                </div>

                {{-- Notes --}}
                <div>
                    <label class="block text-[11px] font-black text-slate-900 uppercase tracking-[0.2em] mb-6">Catatan Tambahan (Opsional)</label>
                    <textarea name="catatan" rows="3" placeholder="Misal: Dari rekening Bapak Budi..."
                        class="w-full px-8 py-6 bg-slate-50 border border-slate-100 rounded-2xl text-base font-medium outline-none focus:bg-white focus:border-[#800000] transition-all placeholder:text-slate-300"></textarea>
                </div>

                {{-- Submit Button (Ultra Large) --}}
                <div class="pt-6">
                    <button type="submit"
                        class="w-full bg-[#800000] hover:bg-[#800000]/90 text-white py-6 rounded-2xl font-black text-xs uppercase tracking-[0.3em] transition-all active:scale-95 shadow-2xl shadow-slate-200 disabled:opacity-30 disabled:cursor-not-allowed"
                        :disabled="!pilihanBank">
                        Kirim Konfirmasi Sekarang
                    </button>
                    <p class="text-center text-[11px] font-bold text-slate-400 uppercase tracking-widest mt-6">Proses verifikasi membutuhkan waktu 1×24 jam.</p>
                </div>
            </form>
        </div>

        {{-- RIGHT: Premium Summary Card --}}
        <div class="lg:col-span-5">
            <div class="sticky top-32">
                <div class="bg-white border-t-[12px] border-[#800000] shadow-2xl shadow-slate-200/60 overflow-hidden">
                    
                    {{-- Header Document Style --}}
                    <div class="p-12 border-b border-slate-100">
                        <p class="text-[11px] font-black text-slate-300 uppercase tracking-[0.4em] mb-12">Ringkasan Reservasi</p>
                        
                        <div class="mb-12">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nomor Lahan</p>
                            <h2 class="text-7xl font-black text-slate-900 tracking-tighter leading-none italic">
                                #{{ $reservasi->lahan->nomor_lahan }}
                            </h2>
                        </div>

                        <div class="space-y-8">
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Cluster / Lokasi</p>
                                <p class="text-xl font-black text-slate-900 uppercase tracking-tight">{{ $reservasi->lahan->cluster->nama_cluster }}</p>
                            </div>

                            <div class="grid grid-cols-2 gap-8">
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Tipe</p>
                                    <p class="text-sm font-black text-slate-900 uppercase tracking-widest">{{ $reservasi->lahan->tipe_lahan }}</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Ukuran</p>
                                    <p class="text-sm font-black text-slate-900 uppercase tracking-widest">{{ $reservasi->lahan->ukuran }}</p>
                                </div>
                            </div>

                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Nama Jenazah</p>
                                <p class="text-lg font-black text-slate-900">
                                    {{ $reservasi->nama_jenazah ? 'ALM. '.strtoupper($reservasi->nama_jenazah) : '—' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Footer Price Style --}}
                    <div class="p-12 bg-slate-50/50">
                        <div class="flex justify-between items-end">
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Status Pesanan</p>
                                <p class="text-xs font-black text-amber-600 uppercase tracking-[0.2em]">{{ $reservasi->status_reservasi }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Tagihan</p>
                                <p class="text-3xl font-black text-slate-900 tracking-tight">
                                    Rp {{ number_format($reservasi->lahan->harga, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
</div>
@endsection
