@extends('layouts.admin')
@section('title', 'Verifikasi Pembayaran - Mount Carmel')

@section('content')

@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
    <span class="material-icons-outlined">check_circle</span>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Verifikasi Pembayaran</h1>
        <p class="text-sm text-slate-500 mt-1">Validasi bukti transfer dan pengesahan kepemilikan lahan.</p>
    </div>
</div>

{{-- Filtering System --}}
<div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 mb-6">
    <form method="GET" action="{{ route('accounting.pembayaran.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div class="md:col-span-2">
            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1.5">Cari Transaksi</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 material-icons-outlined text-slate-400 text-sm">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama pembeli, unit lahan, atau invoice..."
                       class="w-full pl-11 pr-4 py-2 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all placeholder:text-slate-300">
            </div>
        </div>
        <div>
            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1.5">Status</label>
            <div class="relative">
                <select name="status" onchange="this.form.submit()" class="w-full px-4 py-2 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all appearance-none cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="Lunas" {{ request('status') == 'Lunas' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="Menunggu Konfirmasi" {{ request('status') == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Pending</option>
                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
                <span class="material-icons-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 text-sm">expand_more</span>
            </div>
        </div>
        <div class="flex">
            @if(request('search') || request('status'))
            <a href="{{ route('accounting.pembayaran.index') }}" class="w-full px-5 py-2 bg-slate-100 text-slate-500 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-200 transition-all text-center flex items-center justify-center">
                Reset
            </a>
            @endif
        </div>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="text-slate-500 font-semibold bg-slate-50/80 border-b border-slate-100 uppercase tracking-wider text-[11px]">
                    <th class="px-4 py-2.5">Invoice & Tanggal</th>
                    <th class="px-4 py-2.5">Pembeli</th>
                    <th class="px-4 py-2.5">Detail Lahan</th>
                    <th class="px-4 py-2.5 text-right">Nominal</th>
                    <th class="px-4 py-2.5 text-center">Bukti Bayar</th>
                    <th class="px-4 py-2.5 text-center">Tindakan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 text-slate-700">
                @forelse($pembayarans as $p)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-4 py-2.5">
                        <p class="font-bold text-slate-900">{{ $p->no_invoice }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5 uppercase tracking-tighter mb-1">{{ $p->created_at->format('d M Y') }}</p>
                        @if($p->dikonfirmasi_oleh)
                            <span class="inline-block text-[9px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md">Oleh: {{ $p->dikonfirmasi_oleh }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-2.5">
                        <p class="font-bold text-slate-800">{{ $p->reservasi?->user?->name ?? 'N/A' }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5 uppercase tracking-tighter">{{ $p->reservasi?->user?->email ?? '-' }}</p>
                    </td>
                    <td class="px-4 py-2.5">
                        <p class="font-bold text-slate-800 uppercase">UNIT {{ $p->reservasi?->lahan?->nomor_lahan ?? '-' }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5 uppercase tracking-tighter mb-1">{{ $p->reservasi?->lahan?->cluster?->nama_cluster ?? '-' }}</p>
                        @if($p->reservasi?->marketing_oleh)
                            <span class="inline-block text-[9px] font-bold text-[#800000] bg-[#800000]/5 px-2 py-0.5 rounded-md">Sales: {{ $p->reservasi->marketing_oleh }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-2.5 text-right font-bold text-slate-900">
                        Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-2.5 text-center">
                        @if($p->bukti_pembayaran)
                        <a href="{{ asset('storage/' . $p->bukti_pembayaran) }}" target="_blank"
                           class="inline-flex items-center gap-1.5 text-indigo-600 hover:text-indigo-800 font-bold text-[11px] uppercase tracking-wider">
                            <span class="material-icons-outlined text-sm">visibility</span> Lihat Bukti
                        </a>
                        @else
                        <span class="text-slate-300 text-[10px] font-bold uppercase tracking-widest italic">No Data</span>
                        @endif
                    </td>
                    <td class="px-4 py-2.5">
                        <div class="flex justify-center items-center gap-3">
                            @if($p->status_pembayaran === 'Menunggu Konfirmasi' || $p->status_pembayaran === 'Pending' || $p->status_pembayaran === 'menunggu konfirmasi')
                                @if($p->reservasi && $p->reservasi->status_reservasi === 'Menunggu Validasi')
                                    <div class="text-center">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-bold text-amber-600 bg-amber-50 border border-amber-200 uppercase tracking-wider">
                                            <span class="material-icons-outlined text-xs">hourglass_empty</span>
                                            Validasi Marketing
                                        </span>
                                    </div>
                                @else
                                    <form id="form-approve-{{ $p->id }}" action="{{ route('accounting.pembayaran.konfirmasi', $p->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status_pembayaran" value="Lunas">
                                        <button type="button"
                                            @click="$dispatch('confirm-modal', { 
                                                title: 'Sahkan Pembayaran', 
                                                message: 'Pastikan dana telah masuk ke rekening sebelum melakukan pengesahan ini.', 
                                                confirmText: 'Sahkan Sekarang',
                                                type: 'success',
                                                action: () => document.getElementById('form-approve-{{ $p->id }}').submit() 
                                            })"
                                            class="bg-[#800000] text-white px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-wider hover:bg-[#800000]/90 transition-all shadow-sm">
                                            Setujui
                                        </button>
                                    </form>

                                    <form id="form-reject-{{ $p->id }}" action="{{ route('accounting.pembayaran.konfirmasi', $p->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" name="status_pembayaran" value="Ditolak">
                                        <button type="button"
                                            @click="$dispatch('confirm-modal', { 
                                                title: 'Tolak Transaksi', 
                                                message: 'Apakah bukti transfer tidak valid atau dana belum diterima?', 
                                                confirmText: 'Ya, Tolak',
                                                type: 'danger',
                                                action: () => document.getElementById('form-reject-{{ $p->id }}').submit() 
                                            })"
                                            class="bg-white border border-rose-200 text-rose-600 px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase tracking-wider hover:bg-rose-50 transition-all">
                                            Tolak
                                        </button>
                                    </form>
                                @endif
                            @elseif($p->status_pembayaran === 'Lunas' || $p->status_pembayaran === 'Dikonfirmasi')
                            <div class="flex flex-col items-center">
                                <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest mb-1.5">Terverifikasi</span>
                                <a href="{{ route('accounting.pembayaran.invoice', $p->id) }}" target="_blank"
                                   class="px-2.5 py-1 bg-slate-100 text-slate-700 text-[9px] font-bold uppercase tracking-wider rounded-lg hover:bg-slate-200 transition-all border border-slate-200">
                                    Invoice
                                </a>
                            </div>
                            @else
                            <span class="text-[10px] font-bold text-rose-400 uppercase tracking-widest italic">Ditolak</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-slate-400 font-medium">Belum ada data pembayaran yang masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($pembayarans, 'hasPages') && $pembayarans->hasPages())
    <div class="px-4 py-3 border-t border-slate-50 bg-slate-50/30">
        {{ $pembayarans->appends(request()->query())->links() }}
    </div>
    @endif
</div>

@endsection
