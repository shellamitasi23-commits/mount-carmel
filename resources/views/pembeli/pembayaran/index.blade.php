@extends('layouts.master')
@section('title', 'Pembayaran — Mount Carmel')

@section('content')
<style>
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@500;600;700;800;900&display=swap');
    .font-poppins { font-family: 'Poppins', sans-serif; }
    .font-inter { font-family: 'Inter', sans-serif; }
    @keyframes modalScale {
        0% { opacity: 0; transform: scale(0.95) translateY(10px); }
        100% { opacity: 1; transform: scale(1) translateY(0); }
    }
    .animate-modal { animation: modalScale 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
</style>

<div class="min-h-screen bg-[#FDFCFB] pt-32 pb-24 font-inter">
    
    <div x-data="{ modalForm: false, currentReservasiId: null, currentTagihan: 0 }" class="max-w-7xl mx-auto px-6 lg:px-8">

        {{-- Flash Message --}}
        @if(session('success'))
            <div class="mb-8 bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 rounded-2xl font-bold flex items-center justify-between shadow-sm animate-pulse">
                <span>{{ session('success') }}</span>
                <span class="material-icons text-emerald-500">check_circle</span>
            </div>
        @endif

        {{-- ── HERO SECTION ── --}}
        <div class="flex flex-col md:flex-row justify-between items-end gap-6 mb-12">
            <div>
                <span class="text-[10px] font-bold tracking-[0.2em] text-amber-600 uppercase mb-3 block font-inter">Administrasi</span>
                <h1 class="text-4xl md:text-5xl font-black text-slate-900 font-poppins leading-tight">
                    Pembayaran
                </h1>
                <p class="text-slate-500 mt-4 max-w-xl text-sm md:text-base leading-relaxed">
                    Selesaikan proses pembayaran untuk reservasi kavling Anda yang telah disetujui, atau cetak invoice untuk pembayaran yang telah selesai.
                </p>
            </div>
        </div>

        {{-- ── TABEL TAGIHAN (RESERVASI SIAP BAYAR) ── --}}
        <div class="mb-16">
            <h2 class="text-xl font-bold text-slate-900 font-poppins mb-6 flex items-center gap-2">
                <span class="material-icons text-amber-500">pending_actions</span> Menunggu Pembayaran
            </h2>
            
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead class="bg-slate-50 text-[10px] font-black uppercase text-slate-400 tracking-widest border-b border-slate-100">
                            <tr>
                                <th class="px-8 py-5">Kavling</th>
                                <th class="px-8 py-5">Atas Nama</th>
                                <th class="px-8 py-5">Total Tagihan</th>
                                <th class="px-8 py-5 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @if(isset($reservasis_siap_bayar) && $reservasis_siap_bayar->count() > 0)
                                @foreach($reservasis_siap_bayar as $res)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-8 py-5">
                                        <span class="font-bold text-slate-800">{{ $res->kavling->nomor_kavling ?? '-' }}</span>
                                    </td>
                                    <td class="px-8 py-5 font-medium text-slate-600">{{ $res->nama_jenazah }}</td>
                                    <td class="px-8 py-5 font-black text-slate-900">Rp {{ number_format($res->kavling->harga ?? 0, 0, ',', '.') }}</td>
                                    <td class="px-8 py-5 text-right">
                                        <button @click="modalForm = true; currentReservasiId = '{{ $res->id }}'; currentTagihan = '{{ $res->kavling->harga ?? 0 }}'" class="bg-slate-900 text-white px-5 py-2.5 rounded-full text-xs font-bold shadow-lg shadow-slate-900/20 hover:bg-primary transition-all font-poppins">
                                            BAYAR SEKARANG
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="px-8 py-10 text-center text-slate-400 font-medium">
                                        Tidak ada tagihan pembayaran saat ini.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- ── DAFTAR RIWAYAT PEMBAYARAN (BENTUK KARTU) ── --}}
        <div>
            <h2 class="text-xl font-bold text-slate-900 font-poppins mb-6 flex items-center gap-2">
                <span class="material-icons text-emerald-500">history</span> Riwayat Transaksi
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @if(isset($riwayat_pembayaran) && $riwayat_pembayaran->count() > 0)
                    @foreach($riwayat_pembayaran as $bayar)
                    <div class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col relative group overflow-hidden">
                        
                        <div class="absolute -right-8 -top-8 text-slate-50 opacity-50 group-hover:scale-110 transition-transform duration-500">
                            <span class="material-icons" style="font-size: 120px;">receipt_long</span>
                        </div>

                        <div class="flex justify-between items-start mb-6 relative z-10">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Kavling</p>
                                <h3 class="text-xl font-black text-slate-900 font-poppins">
                                    {{ $bayar->reservasi->kavling->nomor_kavling ?? 'N/A' }}
                                </h3>
                            </div>
                            @if($bayar->status_pembayaran == 'Lunas')
                                <span class="bg-emerald-50 text-emerald-600 px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-emerald-100">Lunas</span>
                            @elseif($bayar->status_pembayaran == 'Ditolak')
                                <span class="bg-red-50 text-red-600 px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-red-100">Ditolak</span>
                            @else
                                <span class="bg-amber-50 text-amber-600 px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border border-amber-100">Menunggu</span>
                            @endif
                        </div>

                        <div class="bg-slate-50 rounded-2xl p-4 border border-slate-100 mb-6 relative z-10 flex-grow">
                            <p class="text-[10px] text-slate-400 uppercase tracking-widest mb-1 font-bold">Nominal Bayar</p>
                            <p class="font-black text-slate-800 text-lg">Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}</p>
                            <p class="text-xs text-slate-500 mt-2">Tanggal: {{ $bayar->created_at->format('d M Y') }}</p>
                        </div>

                        <div class="pt-4 border-t border-slate-50 flex items-center justify-between relative z-10">
                            @if($bayar->status_pembayaran == 'Lunas')
                                <a href="{{ route('pembeli.pembayaran.invoice', $bayar->id) }}" class="w-full bg-slate-100 text-slate-700 py-3 rounded-xl flex items-center justify-center gap-2 font-bold text-xs hover:bg-slate-200 transition-colors">
                                    <span class="material-icons text-sm">print</span> CETAK INVOICE
                                </a>
                            @else
                                <span class="text-xs font-semibold text-slate-400 italic text-center w-full">Invoice belum tersedia</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-span-full py-16 bg-white border border-slate-100 rounded-[3rem] shadow-sm text-center">
                        <span class="material-icons text-slate-300 text-4xl mb-4">receipt_long</span>
                        <h3 class="text-xl font-black text-slate-900 font-poppins mb-2">Belum Ada Transaksi</h3>
                        <p class="text-slate-500 text-sm">Riwayat pembayaran Anda akan muncul di sini.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- ── MODAL UPLOAD BUKTI BAYAR ── --}}
        <div x-show="modalForm" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6 bg-slate-900/60 backdrop-blur-md" x-transition.opacity>
            <div @click.away="modalForm = false" class="bg-white rounded-[2.5rem] w-full max-w-md shadow-2xl relative animate-modal overflow-hidden flex flex-col">
                
                <div class="px-8 pt-10 pb-6 border-b border-slate-50 relative shrink-0 text-center">
                    <button @click="modalForm = false" class="absolute top-6 right-6 text-slate-400 hover:text-red-500 transition-colors">
                        <span class="material-icons">close</span>
                    </button>
                    <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="material-icons text-primary text-3xl">account_balance_wallet</span>
                    </div>
                    <h3 class="text-2xl font-black text-slate-900 font-poppins">Upload Bukti Bayar</h3>
                </div>

                <div class="px-8 py-6 font-inter">
                    <div class="bg-amber-50 border border-amber-100 rounded-2xl p-4 mb-6 text-center">
                        <p class="text-[10px] font-bold text-amber-600 uppercase tracking-widest mb-1">Transfer Ke Rekening BCA</p>
                        <p class="font-black text-slate-800 text-lg tracking-wider font-poppins">8890 123 456</p>
                        <p class="text-xs font-semibold text-slate-600">a.n PT Mount Carmel</p>
                    </div>

                    <form action="{{ route('pembeli.pembayaran.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        
                        <input type="hidden" name="reservasi_id" x-bind:value="currentReservasiId">
                        
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Jumlah Transfer (Rp)</label>
                            <input type="number" name="jumlah_bayar" x-bind:value="currentTagihan" class="w-full border-none bg-slate-50 rounded-2xl px-5 py-4 text-sm font-bold text-slate-700 outline-none focus:ring-2 focus:ring-primary/20" required readonly>
                        </div>
                        
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2 ml-1">Upload Bukti Transfer (JPG/PDF)</label>
                            <div class="border-2 border-dashed border-slate-200 rounded-2xl p-2 bg-slate-50 flex items-center hover:border-primary/50 transition-colors">
                                <input type="file" name="bukti_pembayaran" accept=".jpg,.jpeg,.png,.pdf" class="w-full text-xs font-semibold text-slate-500 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:uppercase file:tracking-widest file:font-black file:bg-white file:text-slate-700 file:shadow-sm cursor-pointer" required>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-slate-900 text-white font-black text-xs uppercase tracking-widest py-5 rounded-[1.5rem] mt-4 shadow-xl shadow-slate-900/20 hover:bg-black hover:-translate-y-0.5 transition-all duration-300 font-poppins">
                            KONFIRMASI PEMBAYARAN
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection