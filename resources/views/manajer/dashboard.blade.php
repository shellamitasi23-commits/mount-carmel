@extends('layouts.admin')
@section('title', 'Performance Dashboard — Mount Carmel')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200..800&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif !important; }
</style>
@endpush

@section('content')
<div class="mb-10">
    <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight uppercase">Performance Hub</h1>
    <p class="text-sm text-slate-500 mt-1">Monitoring operasional dan performa kawasan Mount Carmel.</p>
</div>

{{-- Stats Grid --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 border-l-4 border-l-slate-900">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Kapasitas Lahan</p>
        <h3 class="text-3xl font-black text-slate-900 tracking-tighter">{{ number_format($totalLahan) }} <span class="text-xs text-slate-300 uppercase">Unit</span></h3>
    </div>
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 border-l-4 border-l-teal-500">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Unit Tersedia</p>
        <h3 class="text-3xl font-black text-teal-600 tracking-tighter">{{ number_format($availableLahan) }} <span class="text-xs text-slate-300 uppercase">Ready</span></h3>
    </div>
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 border-l-4 border-l-rose-500">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Unit Terjual</p>
        <h3 class="text-3xl font-black text-rose-600 tracking-tighter">{{ number_format($occupiedLahan) }} <span class="text-xs text-slate-300 uppercase">Sold</span></h3>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-10">
    
    {{-- Mapping --}}
    <div class="lg:col-span-2 space-y-8">
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden group">
            <div class="aspect-[16/9] bg-slate-900 relative overflow-hidden">
                {{-- Peta Lahan --}}
                <div class="absolute inset-0 opacity-40 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="bg-slate-900 text-white px-8 py-4 rounded-xl shadow-2xl text-[10px] uppercase tracking-[0.4em] font-black">
                        MAPPING INTERAKTIF (VIEW ONLY)
                    </span>
                </div>
            </div>
        </div>

        {{-- Laporan Penjualan Terbaru --}}
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between">
                <h4 class="text-[10px] font-black text-slate-800 uppercase tracking-widest">Aktivitas Penjualan</h4>
                <a href="{{ route('manajer.laporan.index') }}" class="text-[9px] font-bold text-slate-400 hover:text-slate-900 uppercase">Lihat Laporan Lengkap</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <tbody class="divide-y divide-slate-50">
                        @foreach($recentSales as $sale)
                        <tr class="hover:bg-slate-50/50 transition-all">
                            <td class="px-8 py-5">
                                <p class="font-black text-slate-900 text-xs uppercase tracking-tight">{{ $sale['name'] }}</p>
                                <p class="text-[8px] text-slate-400 mt-1 uppercase">{{ $sale['email'] }}</p>
                            </td>
                            <td class="px-8 py-5 font-bold text-slate-500 uppercase text-[10px]">{{ $sale['type'] }}</td>
                            <td class="px-8 py-5 font-black text-slate-900">{{ $sale['price'] }}</td>
                            <td class="px-8 py-5 text-right">
                                <span class="inline-block px-2 py-1 rounded text-[8px] font-black uppercase {{ $sale['status_color'] }}">
                                    {{ $sale['status'] }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Kanan: Finance & Details --}}
    <div class="space-y-8">
        {{-- Revenue --}}
        <div class="bg-slate-900 text-white p-8 rounded-3xl shadow-xl relative overflow-hidden">
            <p class="text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2">Total Sales Revenue</p>
            <h3 class="text-2xl font-black tracking-tighter">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            <div class="mt-6 pt-6 border-t border-slate-800 flex justify-between items-center">
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Performance</span>
                <span class="text-[10px] font-black {{ $revenueChange >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
                    {{ $revenueChange >= 0 ? '▲' : '▼' }} {{ number_format(abs($revenueChange), 1) }}%
                </span>
            </div>
        </div>

        {{-- Sector Breakdown --}}
        <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100">
            <h4 class="text-[10px] font-black text-slate-800 uppercase tracking-widest mb-6">Inventory Breakdown</h4>
            <div class="space-y-6">
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-[10px] font-bold text-teal-600 uppercase">Muslim Sector</span>
                        <span class="text-[10px] font-black">{{ $muslimStats['terjual'] }}/{{ $muslimStats['total'] }}</span>
                    </div>
                    <div class="h-1.5 w-full bg-slate-50 rounded-full overflow-hidden">
                        <div class="h-full bg-teal-500" style="width: {{ ($muslimStats['terjual'] / $muslimStats['total']) * 100 }}%"></div>
                    </div>
                </div>
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-[10px] font-bold text-blue-600 uppercase">Non-Muslim</span>
                        <span class="text-[10px] font-black">{{ $nonMuslimStats['terjual'] }}/{{ $nonMuslimStats['total'] }}</span>
                    </div>
                    <div class="h-1.5 w-full bg-slate-50 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-500" style="width: {{ ($nonMuslimStats['terjual'] / $nonMuslimStats['total']) * 100 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Monthly Chart --}}
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <h4 class="text-[10px] font-black text-slate-800 uppercase tracking-widest mb-6">Monthly Revenue</h4>
            <div class="h-40 flex items-end justify-between gap-2 px-2">
                @foreach($revenueData as $index => $rev)
                    @php $maxV = max($revenueData) ?: 1; $pct = ($rev / $maxV) * 100; @endphp
                    <div class="flex-1 flex flex-col items-center group relative">
                        <div class="absolute -top-6 text-[8px] font-black opacity-0 group-hover:opacity-100 transition-opacity">{{ $rev }}M</div>
                        <div style="height: {{ max($pct, 10) }}%" class="w-full bg-slate-100 group-hover:bg-slate-900 rounded-t-md transition-all"></div>
                        <span class="text-[8px] font-bold text-slate-400 mt-2">{{ $labels[$index] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
@endsection
