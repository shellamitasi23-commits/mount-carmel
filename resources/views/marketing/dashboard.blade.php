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
<div class="mb-8">
    <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight uppercase">Dashboard Utama</h1>
    <p class="text-sm text-slate-500 mt-1">Ringkasan operasional dan inventori lahan Mount Carmel secara real-time.</p>
</div>

{{-- Main Stats --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 border-l-4 border-l-slate-900">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Kapasitas Lahan</p>
        <h3 class="text-3xl font-black text-slate-900 tracking-tighter">{{ number_format($totalLahan) }} <span class="text-xs text-slate-300 uppercase">Unit</span></h3>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 border-l-4 border-l-teal-500">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Unit Tersedia</p>
        <h3 class="text-3xl font-black text-teal-600 tracking-tighter">{{ number_format($availableLahan) }} <span class="text-xs text-slate-300 uppercase">Ready</span></h3>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 border-l-4 border-l-rose-500">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Unit Terjual</p>
        <h3 class="text-3xl font-black text-rose-600 tracking-tighter">{{ number_format($occupiedLahan) }} <span class="text-xs text-slate-300 uppercase">Sold</span></h3>
    </div>
</div>

{{-- Detail Per Sektor --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
    {{-- Sektor Muslim --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden group">
        <div class="px-6 py-4 border-b border-slate-50 bg-slate-50/50 flex items-center justify-between">
            <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                <span class="material-icons-outlined text-teal-500">mosque</span> Sektor Muslim (Madinah)
            </h4>
            <span class="text-[10px] font-bold text-slate-400 uppercase">{{ number_format($muslimStats['total']) }} Total Unit</span>
        </div>
        <div class="p-6 grid grid-cols-4 gap-4 text-center">
            <div class="bg-slate-50 p-3 rounded-xl">
                <p class="text-[8px] font-bold text-slate-400 uppercase mb-1">Sold</p>
                <p class="text-lg font-black text-slate-900 leading-none">{{ number_format($muslimStats['terjual']) }}</p>
            </div>
            <div class="bg-slate-50 p-3 rounded-xl">
                <p class="text-[8px] font-bold text-slate-400 uppercase mb-1">Booked</p>
                <p class="text-lg font-black text-slate-900 leading-none">{{ number_format($muslimStats['booked']) }}</p>
            </div>
            <div class="bg-slate-50 p-3 rounded-xl">
                <p class="text-[8px] font-bold text-slate-400 uppercase mb-1">Used</p>
                <p class="text-lg font-black text-slate-900 leading-none">{{ number_format($muslimStats['used']) }}</p>
            </div>
            <div class="bg-teal-50 p-3 rounded-xl border border-teal-100">
                <p class="text-[8px] font-bold text-teal-600 uppercase mb-1">Ready</p>
                <p class="text-lg font-black text-teal-700 leading-none">{{ number_format($muslimStats['available']) }}</p>
            </div>
        </div>
    </div>

    {{-- Sektor Non-Muslim --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden group">
        <div class="px-6 py-4 border-b border-slate-50 bg-slate-50/50 flex items-center justify-between">
            <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest flex items-center gap-2">
                <span class="material-icons-outlined text-indigo-500">church</span> Sektor Non-Muslim
            </h4>
            <span class="text-[10px] font-bold text-slate-400 uppercase">{{ number_format($nonMuslimStats['total']) }} Total Unit</span>
        </div>
        <div class="p-6 grid grid-cols-4 gap-4 text-center">
            <div class="bg-slate-50 p-3 rounded-xl">
                <p class="text-[8px] font-bold text-slate-400 uppercase mb-1">Sold</p>
                <p class="text-lg font-black text-slate-900 leading-none">{{ number_format($nonMuslimStats['terjual']) }}</p>
            </div>
            <div class="bg-slate-50 p-3 rounded-xl">
                <p class="text-[8px] font-bold text-slate-400 uppercase mb-1">Booked</p>
                <p class="text-lg font-black text-slate-900 leading-none">{{ number_format($nonMuslimStats['booked']) }}</p>
            </div>
            <div class="bg-slate-50 p-3 rounded-xl">
                <p class="text-[8px] font-bold text-slate-400 uppercase mb-1">Used</p>
                <p class="text-lg font-black text-slate-900 leading-none">{{ number_format($nonMuslimStats['used']) }}</p>
            </div>
            <div class="bg-indigo-50 p-3 rounded-xl border border-indigo-100">
                <p class="text-[8px] font-bold text-indigo-600 uppercase mb-1">Ready</p>
                <p class="text-lg font-black text-indigo-700 leading-none">{{ number_format($nonMuslimStats['available']) }}</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- Mapping & Recent Sales (Span 2) --}}
    <div class="lg:col-span-2 flex flex-col gap-8">
        {{-- Peta Unit Mapping --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50 flex items-center justify-between bg-white">
                <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest">Peta Unit Madinah & Mapping Lahan</h4>
                <a href="{{ route('marketing.lahan.index') }}" class="text-[9px] font-black text-slate-400 hover:text-slate-900 uppercase tracking-widest transition-colors">Lihat Semua Lahan</a>
            </div>
            <div class="relative w-full h-80 bg-slate-50 group cursor-pointer">
                <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?q=80&w=1200&auto=format&fit=crop" 
                     class="w-full h-full object-cover grayscale opacity-30 group-hover:opacity-100 group-hover:grayscale-0 transition-all duration-1000" alt="Masterplan Mapping">
                <div class="absolute inset-0 flex flex-col items-center justify-center p-8 text-center bg-slate-900/10 group-hover:bg-transparent transition-all">
                    <span class="bg-slate-900 text-white px-8 py-4 rounded-xl shadow-2xl text-[10px] uppercase tracking-[0.4em] font-black group-hover:scale-110 transition-transform">
                        BUKA MAPPING INTERAKTIF
                    </span>
                    <p class="mt-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest group-hover:hidden">Klik untuk memantau detail unit per blok</p>
                </div>
            </div>
        </div>

        {{-- Recent Sales Table --}}
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-50">
                <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest">Aktivitas Transaksi Terbaru</h4>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-slate-400 border-b border-slate-50">
                            <th class="px-6 py-3 font-bold uppercase text-[9px]">Klien</th>
                            <th class="px-6 py-3 font-bold uppercase text-[9px]">Kategori Unit</th>
                            <th class="px-6 py-3 font-bold uppercase text-[9px]">Nilai</th>
                            <th class="px-6 py-3 font-bold uppercase text-[9px] text-right">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-xs">
                        @foreach($recentSales as $sale)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-900 uppercase leading-none">{{ $sale['name'] }}</p>
                                <p class="text-[8px] text-slate-400 mt-1 uppercase">{{ $sale['email'] }}</p>
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-500 uppercase">{{ $sale['type'] }}</td>
                            <td class="px-6 py-4 font-black text-slate-900">{{ $sale['price'] }}</td>
                            <td class="px-6 py-4 text-right">
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
    <div class="flex flex-col gap-8">
        {{-- Revenue Summary --}}
        <div class="bg-slate-900 text-white p-8 rounded-3xl shadow-xl relative overflow-hidden group">
            <div class="absolute top-[-20%] right-[-10%] w-32 h-32 bg-slate-800 rounded-full blur-3xl opacity-50"></div>
            <p class="text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2 relative z-10">Sales Revenue</p>
            <h3 class="text-2xl font-black tracking-tighter relative z-10">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            <div class="mt-6 pt-6 border-t border-slate-800 flex justify-between items-center relative z-10">
                <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Growth</span>
                <span class="text-[10px] font-black {{ $revenueChange >= 0 ? 'text-emerald-400' : 'text-rose-400' }} flex items-center gap-1">
                    <span class="material-icons-outlined text-xs">{{ $revenueChange >= 0 ? 'north_east' : 'south_west' }}</span>
                    {{ number_format(abs($revenueChange), 0) }}%
                </span>
            </div>
        </div>

        {{-- Performance Chart --}}
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100 flex-1 flex flex-col">
            <h4 class="text-[10px] font-black text-slate-800 uppercase tracking-widest mb-6">Monthly Performance</h4>
            <div class="relative flex-1 min-h-[200px]">
                <canvas id="revenueLineChart"></canvas>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-slate-100">
            <h4 class="text-[10px] font-black text-slate-800 uppercase tracking-widest mb-4">Quick Links</h4>
            <div class="flex flex-col gap-3">
                <a href="{{ route('marketing.reservasi.index') }}" class="flex items-center justify-between p-3 bg-slate-50 rounded-xl hover:bg-slate-900 hover:text-white transition-all group">
                    <span class="text-[10px] font-bold uppercase">Buat Reservasi Baru</span>
                    <span class="material-icons-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
                <a href="{{ route('marketing.pembeli.index') }}" class="flex items-center justify-between p-3 bg-slate-50 rounded-xl hover:bg-slate-900 hover:text-white transition-all group">
                    <span class="text-[10px] font-bold uppercase">Data Pelanggan</span>
                    <span class="material-icons-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </a>
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
