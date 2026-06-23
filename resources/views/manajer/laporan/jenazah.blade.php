@extends('layouts.admin')
@section('title', 'Laporan Penjualan — Mount Carmel')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight uppercase">Laporan Penjualan</h1>
        <p class="text-sm text-slate-500 mt-1">Data operasional dan performa penjualan Mount Carmel.</p>
    </div>
    <a href="{{ route('manajer.laporan.cetak', array_merge(request()->all(), ['type' => 'jenazah'])) }}" target="_blank" 
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
            'lahan' => 'Lahan Terjual',
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
    <form action="{{ route('manajer.laporan.jenazah') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div class="md:col-span-3">
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Cari Data</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Masukkan kata kunci..." 
                   class="w-full px-4 py-2 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
        </div>

        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-[#800000] text-white px-5 py-2 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-[#800000]/90 transition-all">
                Filter
            </button>
            <a href="{{ route('manajer.laporan.jenazah') }}" 
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
                    <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Jenazah</th>
                    <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Lokasi Lahan</th>
                    <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Ahli Waris (Pembeli)</th>
                    <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Tgl Dimakamkan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($jenazahs as $j)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-4 py-2.5 font-black text-slate-900 uppercase tracking-tight">
                        {{ $j->nama_jenazah }}
                        <span class="text-[9px] text-slate-400 font-bold lowercase tracking-wider block">Slot {{ $j->nomor_slot }}</span>
                    </td>
                    <td class="px-4 py-2.5">
                        <p class="font-bold text-slate-800 uppercase tracking-tight">UNIT {{ $j->reservasi->lahan->nomor_lahan }}</p>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">{{ $j->reservasi->lahan->cluster->nama_cluster }}</p>
                    </td>
                    <td class="px-4 py-2.5">
                        <p class="font-bold text-slate-800 uppercase text-xs">{{ $j->reservasi->user->name }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5">{{ $j->reservasi->user->email }}</p>
                    </td>
                    <td class="px-4 py-2.5 text-right text-[10px] font-bold text-slate-500 uppercase">
                        {{ $j->tanggal_dimakamkan ? \Carbon\Carbon::parse($j->tanggal_dimakamkan)->format('d/m/Y') : '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center font-bold text-slate-300 uppercase text-xs">Belum ada data jenazah</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($jenazahs, 'hasPages') && $jenazahs->hasPages())
    <div class="px-4 py-3 border-t border-slate-50">
        {{ $jenazahs->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
