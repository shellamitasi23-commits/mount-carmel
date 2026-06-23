@extends('layouts.admin')
@section('title', 'Laporan Penjualan — Mount Carmel')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight uppercase">Laporan Penjualan</h1>
        <p class="text-sm text-slate-500 mt-1">Data operasional dan performa penjualan Mount Carmel.</p>
    </div>
    <a href="{{ route('marketing.laporan.pdf', array_merge(request()->all(), ['type' => 'lahan'])) }}" 
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
<form action="{{ route('marketing.laporan.lahan') }}" method="GET" class="relative mb-6 group">
    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
        <span class="material-icons-outlined text-slate-400 group-focus-within:text-slate-900 transition-colors">search</span>
    </div>
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari data..." 
           class="w-full pl-11 pr-10 py-2 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all placeholder:text-slate-300">
    
    @if(request('search'))
    <a href="{{ route('marketing.laporan.lahan') }}" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
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
                    <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Unit Lahan</th>
                    <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Cluster</th>
                    <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tipe</th>
                    <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Harga</th>
                    <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($lahans as $k)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-4 py-2.5 font-bold text-slate-900 uppercase tracking-tight">#{{ $k->nomor_lahan }}</td>
                    <td class="px-4 py-2.5 text-[10px] font-bold text-slate-600 uppercase">{{ $k->cluster->nama_cluster ?? '-' }}</td>
                    <td class="px-4 py-2.5 text-[10px] font-bold text-slate-600 uppercase">{{ $k->tipe_lahan }}</td>
                    <td class="px-4 py-2.5 font-bold text-slate-900 text-sm">Rp {{ number_format($k->harga, 0, ',', '.') }}</td>
                    <td class="px-4 py-2.5 text-center">
                        <span class="inline-block px-3 py-1 rounded-md text-[10px] font-black uppercase tracking-tighter 
                            {{ $k->status == 'Digunakan' ? 'bg-rose-100 text-rose-700 border border-rose-200' : 
                               ($k->status == 'Terjual' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700') }}">
                            {{ $k->status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center font-bold text-slate-300 uppercase text-xs">Belum Ada Lahan Terjual</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($lahans, 'hasPages') && $lahans->hasPages())
    <div class="px-4 py-3 border-t border-slate-50">
        {{ $lahans->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
