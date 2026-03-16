@extends('layouts.admin')

@section('title', 'Dashboard - Mount Carmel')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
    
    {{-- KIRI: KONTEN UTAMA (Span 2) --}}
    <div class="lg:col-span-2 flex flex-col gap-6">
        
        {{-- 1. Hero Banner --}}
        <div class="relative bg-slate-900 rounded-3xl p-8 md:p-10 flex flex-col md:flex-row items-center justify-between overflow-hidden shadow-xl border border-slate-800">
            <div class="absolute top-[-50%] right-[-10%] w-96 h-96 bg-blue-500/20 rounded-full blur-[100px] pointer-events-none z-0"></div>
            
            <div class="relative z-10 text-white max-w-sm text-center md:text-left">
                <h2 class="text-3xl font-black leading-tight mb-4 tracking-tight">Pantau Ketersediaan Kavling Madinah.</h2>
                <button class="bg-white text-slate-900 px-6 py-3 rounded-xl font-bold hover:bg-slate-100 transition-all shadow-lg text-xs uppercase tracking-widest active:scale-95">
                    Lihat Laporan
                </button>
            </div>

            <div class="mt-8 md:mt-0 relative z-10 w-full md:w-auto flex justify-center md:justify-end">
                <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=600&auto=format&fit=crop" 
                     class="w-full max-w-[280px] h-48 md:h-52 object-cover object-center rounded-2xl border border-white/10 shadow-2xl transition-transform duration-500 hover:scale-105" 
                     alt="Ilustrasi Kavling">
            </div>
        </div>

        {{-- 2. Statistik Kavling (3 Kolom Berjejer) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            {{-- Total Kavling --}}
            <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex flex-col justify-between">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                        <span class="material-icons-outlined text-xl">layers</span>
                    </div>
                    <button class="text-slate-400 hover:text-slate-600"><span class="material-icons-outlined">more_horiz</span></button>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Total Kavling</p>
                    <h3 class="text-3xl font-black text-slate-800">{{ number_format($totalKavling) }}</h3>
                </div>
            </div>

            {{-- Kavling Tersedia --}}
            <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex flex-col justify-between">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <span class="material-icons-outlined text-xl">check_circle</span>
                    </div>
                    <button class="text-slate-400 hover:text-slate-600"><span class="material-icons-outlined">more_horiz</span></button>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Tersedia</p>
                    <div class="flex items-end gap-3">
                        <h3 class="text-3xl font-black text-slate-800">{{ number_format($availableKavling) }}</h3>
                        <span class="text-[10px] font-bold bg-emerald-100 text-emerald-700 px-2 py-1 rounded-md mb-1">Siap dipesan</span>
                    </div>
                </div>
            </div>

            {{-- Kavling Terisi --}}
            <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex flex-col justify-between">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                        <span class="material-icons-outlined text-xl">do_not_disturb_on</span>
                    </div>
                    <button class="text-slate-400 hover:text-slate-600"><span class="material-icons-outlined">more_horiz</span></button>
                </div>
                <div>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Terisi</p>
                    <div class="flex items-end gap-3">
                        <h3 class="text-3xl font-black text-slate-800">{{ number_format($occupiedKavling) }}</h3>
                        <span class="text-[10px] font-bold bg-rose-100 text-rose-700 px-2 py-1 rounded-md mb-1">Sudah laku</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. Keuangan & Grafik Pendapatan --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
            
            {{-- Kotak Keuangan (Kiri) --}}
            <div class="lg:col-span-1 flex flex-col gap-4">
                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex-1">
                    <div class="flex items-center gap-2 text-slate-500 mb-3">
                        <span class="material-icons-outlined text-sm">payments</span>
                        <span class="text-xs font-bold uppercase tracking-wider">Pendapatan</span>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <p class="text-[11px] font-semibold mt-2 {{ $revenueChange >= 0 ? 'text-emerald-600 bg-emerald-50' : 'text-rose-600 bg-rose-50' }} w-max px-2 py-1 rounded-md">
                        {{ $revenueChange >= 0 ? '+' : '' }}{{ number_format($revenueChange, 0) }}% vs bulan lalu
                    </p>
                </div>

                <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex-1">
                    <div class="flex items-center gap-2 text-slate-500 mb-3">
                        <span class="material-icons-outlined text-sm">build</span>
                        <span class="text-xs font-bold uppercase tracking-wider">Pemeliharaan</span>
                    </div>
                    <h3 class="text-2xl font-black text-slate-800">Rp {{ number_format($maintenanceCost, 0, ',', '.') }}</h3>
                    <p class="text-[11px] font-semibold mt-2 text-rose-600 bg-rose-50 w-max px-2 py-1 rounded-md">
                        +15% vs bulan lalu
                    </p>
                </div>
            </div>

            {{-- Area Grafik (Kanan) --}}
            <div class="lg:col-span-2 bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex flex-col min-h-[260px]">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Grafik Pendapatan</h4>
                    <select class="text-xs font-semibold border border-slate-200 bg-slate-50 text-slate-600 rounded-lg px-3 py-1.5 outline-none cursor-pointer">
                        <option>Tahun Ini</option>
                        <option>Tahun Lalu</option>
                    </select>
                </div>
                <div class="relative w-full flex-1 min-h-[200px]">
                    <canvas id="revenueLineChart"></canvas>
                </div>
            </div>

        </div>

        {{-- 4. Tabel Penjualan --}}
        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Laporan Penjualan Terbaru</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead>
                        <tr class="text-slate-500 font-bold bg-slate-50 text-xs uppercase tracking-wider border-b border-slate-100">
                            <th class="px-6 py-4">Pembeli</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Tipe Kavling</th>
                            <th class="px-6 py-4">Harga</th>
                            <th class="px-6 py-4">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($recentSales as $sale)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($sale['name']) }}&background=f1f5f9&color=475569" class="w-8 h-8 rounded-full" alt="avatar">
                                <span class="font-bold text-slate-800">{{ $sale['name'] }}</span>
                            </td>
                            <td class="px-6 py-4 text-slate-500">{{ $sale['email'] }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $sale['type'] }}</td>
                            <td class="px-6 py-4 font-bold text-slate-800">{{ $sale['price'] }}</td>
                            <td class="px-6 py-4">
                                {{-- Pemanggilan warna dari Controller, tanpa perlu di-PHP-kan lagi di sini --}}
                                <span class="px-3 py-1.5 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $sale['status_color'] }}">
                                    {{ $sale['status'] }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-400 font-medium">
                                Belum ada data reservasi
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- KANAN: SIDEBAR (Span 1) --}}
    <div class="flex flex-col gap-6">
        
        {{-- Peta Cluster --}}
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm flex flex-col">
            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider mb-4">Peta Cluster Madinah</h3>
            <div class="w-full h-48 bg-slate-100 rounded-xl overflow-hidden relative border border-slate-200 cursor-pointer group">
                <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover opacity-70 group-hover:scale-105 transition-transform duration-700" alt="Map">
                <div class="absolute inset-0 flex items-center justify-center bg-slate-900/30 group-hover:bg-slate-900/10 transition-colors">
                    <span class="bg-white px-4 py-2.5 rounded-lg shadow-xl text-[10px] uppercase tracking-widest font-bold text-slate-800 flex items-center gap-2">
                        <span class="material-icons-outlined text-blue-600 text-sm">location_on</span> View Masterplan
                    </span>
                </div>
            </div>
        </div>

        {{-- Kavling Premium --}}
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm">
            <div class="flex justify-between items-center mb-5">
                <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Kavling Premium</h3>
                <a href="#" class="text-[11px] font-bold text-blue-600 hover:text-blue-800 uppercase tracking-wider">Lihat Semua</a>
            </div>

            <div class="space-y-5">
                @forelse($premiumKavlings as $index => $kavling)
                <div class="group cursor-pointer">
                    <div class="relative w-full h-32 rounded-xl overflow-hidden mb-3 shadow-sm border border-slate-100">
                        <img src="https://images.unsplash.com/photo-{{ $index == 0 ? '1599809275671-b5942cabc7a2' : '1584622650111-993a426fbf0a' }}?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt="Kavling">
                        <span class="absolute top-2 left-2 bg-white/95 backdrop-blur text-[10px] uppercase tracking-widest font-bold px-2 py-1 rounded shadow-sm text-emerald-600">Tersedia</span>
                    </div>
                    <h4 class="font-bold text-slate-800">{{ $kavling->cluster->nama_cluster ?? 'N/A' }}</h4>
                    <p class="text-xs font-medium text-slate-500 mt-0.5 mb-1.5">Ukuran {{ $kavling->ukuran ?? 'N/A' }} • Kap. {{ $kavling->kapasitas ?? 'N/A' }} org</p>
                    <p class="font-black text-slate-900">Rp {{ number_format($kavling->harga ?? 0, 0, ',', '.') }}</p>
                </div>
                @if(!$loop->last)
                <hr class="border-slate-100">
                @endif
                @empty
                <div class="text-center py-8 text-slate-400">
                    <span class="material-icons-outlined text-4xl mb-2 opacity-50">location_off</span>
                    <p class="text-sm font-medium">Tidak ada kavling premium</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctxLine = document.getElementById('revenueLineChart').getContext('2d');
        
        let gradient = ctxLine.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(59, 130, 246, 0.2)'); // Tailwind Blue-500
        gradient.addColorStop(1, 'rgba(59, 130, 246, 0)'); 

        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: @json($labels),
                datasets: [{
                    label: 'Pendapatan',
                    data: @json($revenueData),
                    borderColor: '#3b82f6', // Tailwind Blue-500
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#3b82f6',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true, 
                    tension: 0.4 
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }, 
                    tooltip: {
                        backgroundColor: '#0f172a',
                        padding: 12,
                        titleFont: { family: 'Inter', size: 12 },
                        bodyFont: { family: 'Inter', size: 14, weight: 'bold' },
                        displayColors: false,
                        callbacks: {
                            label: function(context) { return 'Rp ' + context.parsed.y + ' Juta'; }
                        }
                    }
                },
                scales: {
                    x: { 
                        grid: { display: false, drawBorder: false },
                        ticks: { font: { family: 'Inter', size: 11 }, color: '#64748b' }
                    },
                    y: { 
                        grid: { borderDash: [4, 4], color: '#f1f5f9', drawBorder: false },
                        ticks: { 
                            font: { family: 'Inter', size: 11 },
                            color: '#64748b',
                            callback: function(value) { return value + ' Jt'; }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection