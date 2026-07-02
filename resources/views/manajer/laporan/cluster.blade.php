@extends('layouts.admin')
@section('title', 'Laporan Penjualan — Mount Carmel')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight uppercase">Laporan Penjualan</h1>
        <p class="text-sm text-slate-500 mt-1">Data operasional dan performa penjualan Mount Carmel.</p>
    </div>
    <a href="{{ route('manajer.laporan.cetak', array_merge(request()->all(), ['type' => 'cluster'])) }}" target="_blank" 
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
    <form action="{{ route('manajer.laporan.cluster') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div class="md:col-span-3">
            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Cari Data</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Masukkan kata kunci..." 
                   class="w-full px-4 py-2 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
        </div>

        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-[#800000] text-white px-5 py-2 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-[#800000]/90 transition-all">
                Filter
            </button>
            <a href="{{ route('manajer.laporan.cluster') }}" 
               class="bg-slate-100 text-slate-500 px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-slate-200 transition-all text-center font-bold flex items-center justify-center">
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
                    <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Cluster</th>
                    <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Kategori</th>
                    <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Total Lahan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($clusters as $c)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-4 py-2.5 font-bold text-slate-900 uppercase tracking-tight">{{ $c->nama_cluster }}</td>
                    <td class="px-4 py-2.5">
                        <span class="inline-block px-3 py-1 rounded-md text-[10px] font-black uppercase tracking-tighter {{ $c->kategori == 'Muslim' ? 'bg-emerald-50 text-emerald-600' : 'bg-blue-50 text-blue-600' }}">
                            {{ $c->kategori }}
                        </span>
                    </td>
                    <td class="px-4 py-2.5 text-center font-bold text-slate-900 text-sm">{{ $c->lahans_count }} UNIT</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-4 py-8 text-center font-bold text-slate-300 uppercase text-xs">Belum Ada Data Cluster</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($clusters, 'hasPages') && $clusters->hasPages())
    <div class="px-4 py-3 border-t border-slate-50">
        {{ $clusters->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
