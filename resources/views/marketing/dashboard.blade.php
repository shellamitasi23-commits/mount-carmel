@extends('layouts.admin')

@section('title', 'Dashboard — Mount Carmel')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200..800&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif !important; }
</style>
@endpush

@section('content')
<div class="mb-6">
    <h1 class="text-xl font-extrabold text-slate-800 tracking-tight uppercase">Dashboard Utama</h1>
    <p class="text-xs text-slate-500 mt-1">Ringkasan operasional dan inventori lahan Mount Carmel secara real-time.</p>
</div>

{{-- Main Stats --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 border-l-4 border-l-[#800000]">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Kapasitas Lahan</p>
        <h3 class="text-2xl font-black text-slate-900 tracking-tighter">{{ number_format($totalLahan) }} <span class="text-xs text-slate-300 uppercase">Unit</span></h3>
    </div>
    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 border-l-4 border-l-teal-500">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Unit Tersedia</p>
        <h3 class="text-2xl font-black text-teal-600 tracking-tighter">{{ number_format($availableLahan) }} <span class="text-xs text-slate-300 uppercase">Ready</span></h3>
    </div>
    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 border-l-4 border-l-rose-500">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Unit Terjual</p>
        <h3 class="text-2xl font-black text-rose-600 tracking-tighter">{{ number_format($occupiedLahan) }} <span class="text-xs text-slate-300 uppercase">Sold</span></h3>
    </div>
</div>

{{-- Detail Per Sektor --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    {{-- Sektor Muslim --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden group">
        <div class="px-4 py-3 border-b border-slate-50 bg-slate-50/50 flex items-center justify-between">
            <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                 Cluster Madinah
            </h4>
            <span class="text-[10px] font-bold text-slate-400 uppercase">{{ number_format($muslimStats['total']) }} Total Unit</span>
        </div>
        <div class="p-4 grid grid-cols-4 gap-3 text-center">
            <div class="bg-slate-50 p-2.5 rounded-lg">
                <p class="text-[8px] font-bold text-slate-400 uppercase mb-1">Sold</p>
                <p class="text-base font-black text-slate-900 leading-none">{{ number_format($muslimStats['terjual']) }}</p>
            </div>
            <div class="bg-slate-50 p-2.5 rounded-lg">
                <p class="text-[8px] font-bold text-slate-400 uppercase mb-1">Booked</p>
                <p class="text-base font-black text-slate-900 leading-none">{{ number_format($muslimStats['booked']) }}</p>
            </div>
            <div class="bg-slate-50 p-2.5 rounded-lg">
                <p class="text-[8px] font-bold text-slate-400 uppercase mb-1">Used</p>
                <p class="text-base font-black text-slate-900 leading-none">{{ number_format($muslimStats['used']) }}</p>
            </div>
            <div class="bg-teal-50 p-2.5 rounded-lg border border-teal-100">
                <p class="text-[8px] font-bold text-teal-600 uppercase mb-1">Ready</p>
                <p class="text-base font-black text-teal-700 leading-none">{{ number_format($muslimStats['available']) }}</p>
            </div>
        </div>
    </div>

    {{-- Sektor Non-Muslim --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden group">
        <div class="px-4 py-3 border-b border-slate-50 bg-slate-50/50 flex items-center justify-between">
            <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                Cluster Mount Carmel
            </h4>
            <span class="text-[10px] font-bold text-slate-400 uppercase">{{ number_format($nonMuslimStats['total']) }} Total Unit</span>
        </div>
        <div class="p-4 grid grid-cols-4 gap-3 text-center">
            <div class="bg-slate-50 p-2.5 rounded-lg">
                <p class="text-[8px] font-bold text-slate-400 uppercase mb-1">Terjual</p>
                <p class="text-base font-black text-slate-900 leading-none">{{ number_format($nonMuslimStats['terjual']) }}</p>
            </div>
            <div class="bg-slate-50 p-2.5 rounded-lg">
                <p class="text-[8px] font-bold text-slate-400 uppercase mb-1">Reservasi</p>
                <p class="text-base font-black text-slate-900 leading-none">{{ number_format($nonMuslimStats['booked']) }}</p>
            </div>
            <div class="bg-slate-50 p-2.5 rounded-lg">
                <p class="text-[8px] font-bold text-slate-400 uppercase mb-1">Terpakai</p>
                <p class="text-base font-black text-slate-900 leading-none">{{ number_format($nonMuslimStats['used']) }}</p>
            </div>
            <div class="bg-indigo-50 p-2.5 rounded-lg border border-indigo-100">
                <p class="text-[8px] font-bold text-indigo-600 uppercase mb-1">Tersedia</p>
                <p class="text-base font-black text-indigo-700 leading-none">{{ number_format($nonMuslimStats['available']) }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Left Column (Span 2) --}}
    <div class="lg:col-span-2 flex flex-col gap-6">
        {{-- Recent Sales Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-4 py-3 border-b border-slate-50">
                <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest">Aktivitas Transaksi Terbaru</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-slate-400 border-b border-slate-50">
                            <th class="px-4 py-2 font-bold uppercase text-[9px]">Nama Pembeli</th>
                            <th class="px-4 py-2 font-bold uppercase text-[9px]">Unit</th>
                            <th class="px-4 py-2 font-bold uppercase text-[9px]">Nama Jenazah</th>
                            <th class="px-4 py-2 font-bold uppercase text-[9px] text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-xs">
                        @foreach($recentSales as $sale)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-2.5">
                                <p class="font-bold text-slate-900 uppercase leading-none">{{ $sale['name'] }}</p>
                                <p class="text-[8px] text-slate-400 mt-1 uppercase">{{ $sale['email'] }}</p>
                            </td>
                            <td class="px-4 py-2.5 font-bold text-slate-500 uppercase">{{ $sale['type'] }}</td>
                            <td class="px-4 py-2.5 font-black text-slate-900">{{ $sale['price'] }}</td>
                            <td class="px-4 py-2.5 text-right">
                                <span class="inline-block px-2 py-1 rounded text-[8px] font-black uppercase tracking-tighter {{ $sale['status_color'] }}">
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

    {{-- KANAN (Span 1) --}}
    <div class="flex flex-col gap-6">
        {{-- Revenue Summary --}}
        <div class="bg-[#800000] text-white p-5 rounded-xl shadow-xl relative overflow-hidden group">
            <div class="absolute top-[-20%] right-[-10%] w-32 h-32 bg-[#800000]/80 rounded-full blur-3xl opacity-50"></div>
            <p class="text-[9px] font-black text-white/50 uppercase tracking-[0.3em] mb-2 relative z-10">Sales Revenue</p>
            <h3 class="text-xl font-black tracking-tighter relative z-10">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            <div class="mt-4 pt-4 border-t border-white/10 flex justify-between items-center relative z-10">
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Growth</span>
                <span class="text-[10px] font-black {{ $revenueChange >= 0 ? 'text-emerald-400' : 'text-rose-400' }} flex items-center gap-1">
                    <span class="material-icons-outlined text-xs">{{ $revenueChange >= 0 ? 'north_east' : 'south_west' }}</span>
                    {{ number_format(abs($revenueChange), 0) }}%
                </span>
            </div>
        </div>

        {{-- Performance Chart --}}
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-100 flex-1 flex flex-col">
            <h4 class="text-[10px] font-black text-slate-800 uppercase tracking-widest mb-4">Performa Bulanan</h4>
            <div class="relative flex-1 min-h-[200px]">
                <canvas id="revenueLineChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctxLine = document.getElementById('revenueLineChart').getContext('2d');
        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Revenue',
                    data: @json($revenueData),
                    borderColor: '#0f172a',
                    borderWidth: 3,
                    pointBackgroundColor: '#0f172a',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    fill: true,
                    backgroundColor: 'rgba(15, 23, 42, 0.03)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    x: { grid: { display: false }, ticks: { font: { size: 9, family: 'Plus Jakarta Sans', weight: '600' }, color: '#94a3b8' } },
                    y: { grid: { borderDash: [5, 5], color: '#f1f5f9' }, ticks: { font: { size: 9, family: 'Plus Jakarta Sans', weight: '600' }, color: '#94a3b8' } }
                }
            }
        });
    });
</script>
@endsection
