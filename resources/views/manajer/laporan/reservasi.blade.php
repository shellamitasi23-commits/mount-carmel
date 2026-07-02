@extends('layouts.admin')
@section('title', 'Laporan Penjualan — Mount Carmel')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight uppercase">Laporan Penjualan</h1>
        <p class="text-sm text-slate-500 mt-1">Data operasional and performa penjualan Mount Carmel.</p>
    </div>
    <a href="{{ route('manajer.laporan.cetak', array_merge(request()->all(), ['type' => 'reservasi'])) }}" target="_blank" 
       class="bg-[#800000] hover:bg-[#800000]/90 text-white px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-widest transition-all shadow-md flex items-center gap-2">
        <span class="material-icons-outlined text-sm">print</span> Cetak Laporan (PDF)
    </a>
</div>

{{-- Navigation Tabs --}}
<div class="flex items-center gap-1.5 mb-6 p-1.5 bg-white border border-slate-100 rounded-xl w-full shadow-sm overflow-x-auto whitespace-nowrap">
    @php
        $tabs = [
            'reservasi' => 'Penjualan',
            'jenazah' => 'Data Jenazah',
            'lahan' => 'Data Lahan',
            'pembeli' => 'Database Pembeli',
            'cluster' => 'Distribusi Cluster',
        ];
    @endphp
    @foreach($tabs as $tabKey => $tabLabel)
        <a href="{{ route('manajer.laporan.' . $tabKey, request()->except('page')) }}" 
           class="px-5 py-2 rounded-lg text-xs font-bold transition-all shrink-0 
           {{ Route::is('manajer.laporan.' . $tabKey) ? 'bg-[#800000] text-white shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
            {{ $tabLabel }}
        </a>
    @endforeach
</div>

{{-- Filtering --}}
<div class="bg-white border border-slate-100 rounded-xl shadow-sm p-4 mb-6">
    <form action="{{ route('manajer.laporan.reservasi') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Periode Awal</label>
            <input type="date" name="start_date" value="{{ request('start_date') }}" 
                   class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2 text-sm font-bold outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Periode Akhir</label>
            <input type="date" name="end_date" value="{{ request('end_date') }}" 
                   class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2 text-sm font-bold outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Status</label>
            <select name="status" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2 text-sm font-bold outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
                <option value="">Semua Status</option>
                <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Pending</option>
                <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-[#800000] text-white px-5 py-2 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-[#800000]/90 transition-all">
                Filter
            </button>
            <a href="{{ route('manajer.laporan.reservasi') }}" 
               class="bg-slate-100 text-slate-500 px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-slate-200 transition-all text-center">
                Reset
            </a>
        </div>
    </form>
</div>

{{-- Data Table --}}
<div class="bg-white border border-slate-100 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="bg-slate-50/80 border-b border-slate-100">
                    <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal</th>
                    <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pembeli</th>
                    <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Lahan</th>
                    <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Investasi</th>
                    <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($reservasis as $rs)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-4 py-2.5 font-bold text-slate-900">{{ $rs->created_at->format('d/m/Y') }}</td>
                    <td class="px-4 py-2.5">
                        <p class="font-bold text-slate-900 uppercase tracking-tight">{{ $rs->user->name }}</p>
                        <p class="text-[10px] text-slate-400 font-bold mt-0.5">{{ $rs->user->email }}</p>
                    </td>
                    <td class="px-4 py-2.5">
                        <p class="font-bold text-slate-900 uppercase tracking-tight">#{{ $rs->lahan->nomor_lahan }}</p>
                        <p class="text-[10px] text-slate-400 font-bold mt-0.5">{{ $rs->lahan->cluster->nama_cluster }}</p>
                    </td>
                    <td class="px-4 py-2.5 font-bold text-slate-900">
                        Rp {{ number_format($rs->lahan->harga, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-2.5 text-center">
                        <div class="flex flex-col items-center gap-1 justify-center">
                            <span class="inline-block px-3 py-1 rounded-md text-[10px] font-black uppercase tracking-tighter
                                {{ $rs->status_reservasi == 'Disetujui' ? 'bg-emerald-50 text-emerald-600' : 
                                   ($rs->status_reservasi == 'Ditolak' ? 'bg-red-50 text-red-600' : 'bg-amber-50 text-amber-600') }}">
                                {{ $rs->status_reservasi }}
                            </span>
                            @if($rs->status_pembayaran)
                                <span class="inline-block px-2.5 py-0.5 rounded-md text-[9px] font-bold uppercase tracking-tight
                                    {{ $rs->status_pembayaran == 'Lunas' ? 'bg-emerald-100 text-emerald-700' : 
                                       (str_contains(strtolower($rs->status_pembayaran), 'dp') ? 'bg-yellow-100 text-yellow-700 border border-yellow-200' : 'bg-slate-100 text-slate-600') }}">
                                    {{ $rs->status_pembayaran }}
                                </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center">
                        <p class="text-xs font-bold text-slate-300 uppercase tracking-widest">Tidak ada data ditemukan</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($reservasis, 'hasPages') && $reservasis->hasPages())
    <div class="px-4 py-3 border-t border-slate-50">
        {{ $reservasis->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
