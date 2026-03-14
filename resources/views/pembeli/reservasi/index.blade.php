@extends('layouts.master')
@section('title', 'Reservasi Kavling — Mount Carmel')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700;800;900&display=swap');
    
    .font-poppins { font-family: 'Poppins', sans-serif; }
    .font-inter { font-family: 'Inter', sans-serif; }
    
    /* Animasi halus untuk pop-up */
    @keyframes modalScale {
        0% { opacity: 0; transform: scale(0.95) translateY(10px); }
        100% { opacity: 1; transform: scale(1) translateY(0); }
    }
    .animate-modal { animation: modalScale 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>

<div class="min-h-screen bg-[#FDFCFB] pt-32 pb-24 font-inter">
    
    <div x-data="{ modalForm: {{ isset($kavling_terpilih) ? 'true' : 'false' }} }" class="max-w-7xl mx-auto px-6 lg:px-8">

        {{-- Pesan Sukses --}}
        @if(session('success'))
            <div class="mb-8 bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 rounded-2xl font-bold flex items-center justify-between shadow-sm animate-pulse">
                <span>{{ session('success') }}</span>
                <span class="material-icons text-emerald-500">check_circle</span>
            </div>
        @endif

        {{-- ── HERO / HEADER SECTION ── --}}
        <div class="flex flex-col md:flex-row justify-between items-end gap-6 mb-12">
            <div>
                <span class="text-[10px] font-bold tracking-[0.2em] text-amber-600 uppercase mb-3 block font-inter">Layanan Pemakaman</span>
                <h1 class="text-4xl md:text-5xl font-black text-slate-900 font-poppins leading-tight">
                    Reservasi Kavling
                </h1>
                <p class="text-slate-500 mt-4 max-w-xl text-sm md:text-base leading-relaxed">
                    Pantau status pemesanan lahan Anda atau buat reservasi baru untuk memberikan tempat peristirahatan terbaik bagi keluarga tercinta.
                </p>
            </div>
            
            <button @click="modalForm = true" class="w-full md:w-auto bg-slate-900 text-white px-8 py-4 rounded-full text-sm font-bold shadow-xl shadow-slate-900/20 hover:bg-black hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-2 font-poppins">
                <span class="material-icons text-sm">add</span> BUAT RESERVASI
            </button>
        </div>

        {{-- ── DAFTAR RESERVASI (BENTUK KARTU, BUKAN TABEL) ── --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            @if(isset($reservasis) && $reservasis->count() > 0)
                @foreach($reservasis as $res)
                <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col relative group overflow-hidden">
                    
                    <div class="absolute -right-10 -top-10 text-slate-50 opacity-50 group-hover:scale-110 transition-transform duration-500">
                        <span class="material-icons" style="font-size: 150px;">spa</span>
                    </div>

                    <div class="flex justify-between items-start mb-6 relative z-10">
                        <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center border border-slate-100">
                            <span class="material-icons text-slate-400">book_online</span>
                        </div>
                        
                        @if($res->status_reservasi == 'Disetujui')
                            <span class="bg-emerald-50 text-emerald-600 px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest border border-emerald-100">Disetujui</span>
                        @elseif($res->status_reservasi == 'Ditolak')
                            <span class="bg-red-50 text-red-600 px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest border border-red-100">Ditolak</span>
                        @else
                            <span class="bg-amber-50 text-amber-600 px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest border border-amber-100">Menunggu</span>
                        @endif
                    </div>

                    <div class="relative z-10 mb-6 flex-grow">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Nomor Kavling</p>
                        <h3 class="text-2xl font-black text-slate-900 font-poppins mb-4 group-hover:text-primary transition-colors">
                            {{ $res->kavling->nomor_kavling ?? 'N/A' }}
                        </h3>
                        
                        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100">
                            <p class="text-[10px] text-slate-400 uppercase tracking-widest mb-1 font-bold">Atas Nama Jenazah</p>
                            <p class="font-bold text-slate-800 text-sm">{{ $res->nama_jenazah }}</p>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-50 flex items-center justify-between relative z-10">
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Tanggal Pesan</p>
                            <p class="text-sm font-semibold text-slate-700">{{ $res->created_at->format('d M Y') }}</p>
                        </div>
                        @if($res->status_reservasi == 'Disetujui')
                            <a href="{{ route('pembeli.pembayaran.index') }}" class="w-10 h-10 bg-slate-900 text-white rounded-full flex items-center justify-center hover:bg-primary transition-colors">
                                <span class="material-icons text-sm">arrow_forward</span>
                            </a>
                        @endif
                    </div>
                </div>
                @endforeach
            @else
                
                <div class="col-span-full py-20 bg-white border border-slate-100 rounded-[3rem] shadow-sm text-center flex flex-col items-center justify-center">
                    <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-6">
                        <span class="material-icons text-slate-300 text-4xl">inventory_2</span>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 font-poppins mb-2">Belum Ada Reservasi</h3>
                    <p class="text-slate-500 max-w-md mx-auto text-sm">Anda belum melakukan pemesanan kavling. Silakan klik tombol di atas untuk memulai reservasi lahan.</p>
                </div>
            @endif

        </div>

        {{-- ── MODAL POP-UP FORM RESERVASI ── --}}
        <div x-show="modalForm" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 bg-slate-900/40 backdrop-blur-md" x-transition.opacity>
            
            <div @click.away="modalForm = false" class="bg-white rounded-[2.5rem] w-full max-w-xl shadow-2xl relative animate-modal overflow-hidden flex flex-col max-h-[90vh]">
                
                <div class="px-8 pt-10 pb-6 border-b border-slate-50 relative shrink-0">
                    <button @click="modalForm = false" class="absolute top-8 right-8 w-10 h-10 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center hover:bg-red-50 hover:text-red-500 transition-colors">
                        <span class="material-icons text-sm">close</span>
                    </button>
                    <h3 class="text-2xl font-black text-slate-900 font-poppins mb-2">Formulir Pemesanan</h3>
                    <p class="text-sm text-slate-500 font-inter">Mohon lengkapi data administratif berikut dengan benar.</p>
                </div>

                <div class="px-8 py-6 overflow-y-auto font-inter">
                    <form action="{{ route('pembeli.reservasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Kavling yang Tersedia</label>
                            <div class="relative">
                                <select name="kavling_id" class="w-full border-none bg-slate-50 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-primary/20 appearance-none cursor-pointer" required>
                                    <option value="" disabled selected>-- Pilih Lokasi Kavling --</option>
                                    @if(isset($kavlings))
                                        @foreach($kavlings as $kavling)
                                            <option value="{{ $kavling->id }}" {{ (isset($kavling_terpilih) && $kavling_terpilih == $kavling->id) ? 'selected' : '' }}>
                                                Cluster {{ $kavling->cluster->nama_cluster ?? '' }} - Kavling {{ $kavling->nomor_kavling }} (Rp {{ number_format($kavling->harga, 0, ',', '.') }})
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                                <span class="material-icons absolute right-5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap Jenazah</label>
                            <input type="text" name="nama_jenazah" placeholder="Sesuai KTP/Sertifikat Kematian" class="w-full border-none bg-slate-50 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-primary/20 placeholder:font-normal placeholder:text-slate-400" required>
                        </div>
                        
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Dokumen KTP/KK Pemesan (PDF/JPG)</label>
                            <div class="border-2 border-dashed border-slate-200 rounded-2xl p-2 bg-slate-50 flex items-center hover:border-primary/50 transition-colors group relative overflow-hidden">
                                <input type="file" name="dokumen_ktp" accept=".pdf,.jpg,.jpeg,.png" class="w-full text-xs font-semibold text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:uppercase file:tracking-widest file:font-black file:bg-white file:text-slate-700 file:shadow-sm cursor-pointer" required>
                            </div>
                        </div>

                        <div class="h-4"></div>
                </div>

                <div class="px-8 py-6 border-t border-slate-50 shrink-0">
                    <button type="submit" class="w-full bg-slate-900 text-white font-black text-xs uppercase tracking-widest py-5 rounded-[1.5rem] shadow-xl shadow-slate-900/20 hover:bg-black hover:-translate-y-0.5 transition-all duration-300 font-poppins">
                        KIRIM PENGAJUAN RESERVASI
                    </button>
                </div>
                </form> </div>
        </div>

    </div>
</div>
@endsection