@extends('layouts.admin')
@section('title', 'Laporan Penjualan — Mount Carmel')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight uppercase">Laporan Penjualan</h1>
        <p class="text-sm text-slate-500 mt-1">Data operasional dan performa penjualan Mount Carmel.</p>
    </div>
    <a href="{{ route('marketing.laporan.pdf', array_merge(request()->all(), ['type' => 'jenazah'])) }}" 
       class="bg-[#800000] hover:bg-[#800000]/90 text-white px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-widest transition-all shadow-md flex items-center gap-2">
        <span class="material-icons-outlined text-sm">picture_as_pdf</span> Export PDF
    </a>
</div>

{{-- Navigation Tabs --}}
<div class="flex items-center gap-1.5 mb-8 p-1.5 bg-white border border-slate-100 rounded-2xl w-full shadow-sm overflow-x-auto whitespace-nowrap">
    @php
        $tabs = [
            'reservasi' => 'Penjualan',
            'jenazah' => 'Data Jenazah',
            'lahan' => 'Data Lahan',
            'pembeli' => 'Data Pembeli',
            'cluster' => 'Data Cluster',
        ];
    @endphp
    @foreach($tabs as $tabKey => $tabLabel)
        <a href="{{ route('marketing.laporan.' . $tabKey, request()->except('page')) }}" 
           class="flex-1 shrink-0 text-center px-5 py-2.5 rounded-xl text-xs font-bold transition-all 
           {{ Route::is('marketing.laporan.' . $tabKey) ? 'bg-[#800000] text-white shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
            {{ $tabLabel }}
        </a>
    @endforeach
</div>

{{-- Filtering --}}
<form action="{{ route('marketing.laporan.jenazah') }}" method="GET" class="relative mb-6 group">
    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
        <span class="material-icons-outlined text-slate-400 group-focus-within:text-slate-900 transition-colors">search</span>
    </div>
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari data..." 
           class="w-full pl-11 pr-10 py-2 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all placeholder:text-slate-300">
    
    @if(request('search'))
    <a href="{{ route('marketing.laporan.jenazah') }}" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
        <span class="material-icons-outlined text-xl">close</span>
    </a>
    @endif
</form>

{{-- Data Table --}}
<div class="bg-white border border-slate-100 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="bg-slate-50/80 border-b border-slate-100">
                    <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Jenazah</th>
                    <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Lokasi Lahan</th>
                    <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Pembeli</th>
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
