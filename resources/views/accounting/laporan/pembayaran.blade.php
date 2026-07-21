@extends('layouts.admin')
@section('title', 'Laporan Pembayaran — Mount Carmel')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight uppercase">Laporan Pembayaran</h1>
        <p class="text-sm text-slate-500 mt-1">Data rekapitulasi pembayaran masuk dan performa keuangan Mount Carmel.</p>
    </div>
    <a href="{{ route('accounting.laporan.pdf', array_merge(request()->all(), ['type' => 'pembayaran'])) }}" 
       class="bg-[#800000] hover:bg-[#800000]/90 text-white px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-widest transition-all shadow-md flex items-center gap-2">
        <span class="material-icons-outlined text-sm">picture_as_pdf</span> Export PDF
    </a>
</div>

{{-- Tab Navigation --}}
<div class="flex items-center gap-1.5 mb-8 p-1.5 bg-white border border-slate-100 rounded-2xl w-full shadow-sm overflow-x-auto whitespace-nowrap">
    <a href="{{ route('accounting.laporan.pembayaran', request()->except('page')) }}" 
       class="flex-1 shrink-0 text-center px-5 py-2.5 rounded-xl text-xs font-bold transition-all bg-[#800000] text-white shadow-sm">
        Laporan Pembayaran
    </a>
    <a href="{{ route('accounting.laporan.reservasi', request()->except('page')) }}" 
       class="flex-1 shrink-0 text-center px-5 py-2.5 rounded-xl text-xs font-bold transition-all text-slate-500 hover:text-slate-800">
        Laporan Reservasi
    </a>
</div>

{{-- Filters --}}
<div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 mb-6">
    <form action="{{ route('accounting.laporan.pembayaran') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Periode Awal</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" onchange="this.form.submit()"
                   class="w-full bg-white border border-slate-100 rounded-xl px-4 py-2 text-sm font-medium shadow-sm outline-none focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Periode Akhir</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" onchange="this.form.submit()"
                   class="w-full bg-white border border-slate-100 rounded-xl px-4 py-2 text-sm font-medium shadow-sm outline-none focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Status Pembayaran</label>
            <div class="relative">
                <select name="status" onchange="this.form.submit()" class="w-full px-4 py-2 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all appearance-none cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="Lunas" {{ request('status') == 'Lunas' ? 'selected' : '' }}>Terverifikasi (Lunas)</option>
                    <option value="Menunggu Konfirmasi" {{ request('status') == 'Menunggu Konfirmasi' ? 'selected' : '' }}>Pending</option>
                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
                <span class="material-icons-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 text-sm">expand_more</span>
            </div>
        </div>

        <div class="flex">
            <a href="{{ route('accounting.laporan.pembayaran') }}" 
               class="w-full px-5 py-2 bg-slate-100 text-slate-500 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-200 transition-all text-center flex items-center justify-center">
                Reset
            </a>
        </div>
    </form>
</div>

{{-- Report Table --}}
<div class="bg-white border border-slate-100 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="bg-slate-50/80 border-b border-slate-100">
                    <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Invoice & Tanggal</th>
                    <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pembeli</th>
                    <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Lahan & Cluster</th>
                    <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Rekening Penerima</th>
                    <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Nominal</th>
                    <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($pembayarans as $p)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-4 py-2.5">
                        <p class="font-bold text-slate-900">{{ $p->no_invoice }}</p>
                        <p class="text-[10px] text-slate-400 font-bold mt-0.5">{{ \Carbon\Carbon::parse($p->tanggal_bayar)->format('d/m/Y') }}</p>
                    </td>
                    <td class="px-4 py-2.5">
                        <p class="font-bold text-slate-900 uppercase tracking-tight">{{ $p->reservasi->user->name ?? '-' }}</p>
                        <p class="text-[10px] text-slate-400 font-bold mt-0.5">{{ $p->reservasi->user->email ?? '' }}</p>
                    </td>
                    <td class="px-4 py-2.5">
                        <p class="font-bold text-slate-900 uppercase tracking-tight">#{{ $p->reservasi->lahan->nomor_lahan ?? '-' }}</p>
                        <p class="text-[10px] text-slate-400 font-bold mt-0.5">{{ $p->reservasi->lahan->cluster->nama_cluster ?? '' }}</p>
                    </td>
                    <td class="px-4 py-2.5">
                        <p class="font-bold text-slate-900 uppercase text-[10px]">{{ $p->nama_bank }} Account</p>
                        <p class="text-[10px] text-slate-400 font-bold mt-0.5">{{ $p->rekening_tujuan }}</p>
                    </td>
                    <td class="px-4 py-2.5 font-bold text-slate-900 text-right">
                        Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-2.5 text-right">
                        <span class="inline-block px-2.5 py-0.5 rounded-md text-[9px] font-bold uppercase tracking-tight
                            {{ $p->status_pembayaran == 'Lunas' ? 'bg-emerald-100 text-emerald-700' : 
                               ($p->status_pembayaran == 'Ditolak' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                            {{ $p->status_pembayaran == 'Lunas' ? 'Terverifikasi' : ($p->status_pembayaran == 'Ditolak' ? 'Ditolak' : 'Pending') }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center">
                        <p class="text-xs font-bold text-slate-300 uppercase tracking-widest">Tidak ada data ditemukan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($pembayarans, 'hasPages') && $pembayarans->hasPages())
    <div class="px-4 py-3 border-t border-slate-50">
        {{ $pembayarans->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
