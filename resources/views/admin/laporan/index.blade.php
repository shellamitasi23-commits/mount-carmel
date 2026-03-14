@extends('layouts.admin')

@section('title', 'Laporan Keuangan & Penjualan - Mount Carmel')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Laporan Analitik</h1>
        <p class="text-sm text-gray-500 mt-1">Pantau performa penjualan dan pendapatan Cluster.</p>
    </div>
    
    <div class="flex items-center gap-3">
        <div class="bg-white border border-gray-200 text-gray-700 px-4 py-2.5 rounded-xl text-sm flex items-center gap-2 shadow-sm">
            <span class="material-icons-outlined text-gray-400 text-sm">calendar_today</span>
            <span>Okt 2023 - Nov 2023</span>
            <span class="material-icons-outlined text-gray-400 text-sm ml-2 cursor-pointer">expand_more</span>
        </div>
        <a href="{{ route('admin.laporan.pdf') }}" class="bg-primary hover:bg-opacity-90 text-white px-5 py-2.5 rounded-xl font-semibold flex items-center gap-2 transition-all shadow-md text-sm">
            <span class="material-icons-outlined text-sm">picture_as_pdf</span>
            Export PDF
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 border-l-4 border-l-teal">
        <p class="text-sm font-medium text-gray-500 mb-1">Total Pendapatan Bersih</p>
        <h3 class="text-3xl font-bold text-navy">Rp {{ number_format($totalPendapatan / 1000000, 2, ',', '.') }} M</h3>
        <p class="text-xs text-green-500 font-semibold mt-2 flex items-center gap-1"><span class="material-icons-outlined text-xs">trending_up</span> Periode ini</p>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 border-l-4 border-l-blue-500">
        <p class="text-sm font-medium text-gray-500 mb-1">Kavling Terjual (Periode Ini)</p>
        <h3 class="text-3xl font-bold text-navy">{{ $kavlingTerjual }} Unit</h3>
        <p class="text-xs text-green-500 font-semibold mt-2 flex items-center gap-1"><span class="material-icons-outlined text-xs">trending_up</span> Unit terjual</p>
    </div>
    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 border-l-4 border-l-purple-500">
        <p class="text-sm font-medium text-gray-500 mb-1">Pendapatan Tertunda (Pending)</p>
        <h3 class="text-3xl font-bold text-navy">Rp {{ number_format($pendapatanTertunda / 1000000, 2, ',', '.') }} M</h3>
        <p class="text-xs text-gray-400 font-medium mt-2">Menunggu konfirmasi pembayaran</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="lg:col-span-2 bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col min-h-[350px]">
        <h3 class="font-bold text-gray-800 mb-4">Grafik Tren Penjualan</h3>
        
        <div class="relative w-full flex-1 min-h-[250px]">
            <canvas id="laporanBarChart"></canvas>
        </div>

    </div>

    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
        <h3 class="font-bold text-gray-800 mb-4">Tipe Kavling Terlaris</h3>
        <div class="space-y-5">
            @php $index = 0; @endphp
            @foreach($tipeTerlaris as $tipe => $count)
                @php
                    $colors = ['bg-teal', 'bg-blue-500', 'bg-purple-500'];
                    $color = $colors[$index % count($colors)] ?? 'bg-gray-500';
                    $percentage = $totalTerjualSemuaTipe > 0 ? round(($count / $totalTerjualSemuaTipe) * 100) : 0;
                    $index++;
                @endphp
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="font-medium text-gray-700">{{ $tipe }}</span>
                        <span class="font-bold text-navy">{{ $percentage }}%</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2">
                        <div class="{{ $color }} h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">{{ $count }} Unit Terjual</p>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100">
        <h3 class="text-lg font-bold text-gray-800">Rincian Transaksi Selesai</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="bg-gray-50 text-gray-500 font-semibold border-b border-gray-100">
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">No. Invoice</th>
                    <th class="px-6 py-4">Pelanggan</th>
                    <th class="px-6 py-4">Tipe Kavling</th>
                    <th class="px-6 py-4">Nominal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-gray-700">
                @forelse($transaksi as $pembayaran)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 text-gray-500">{{ $pembayaran->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4 font-medium">{{ $pembayaran->no_invoice }}</td>
                    <td class="px-6 py-4 font-semibold">{{ $pembayaran->reservasi->user->name ?? 'N/A' }}</td>
                    <td class="px-6 py-4">{{ $pembayaran->reservasi->kavling->tipe_kavling ?? 'N/A' }}</td>
                    <td class="px-6 py-4 font-bold text-navy">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        Belum ada transaksi yang selesai
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctxBar = document.getElementById('laporanBarChart').getContext('2d');
        
        new Chart(ctxBar, {
            type: 'bar',
            data: {
                labels: @json($chartLabels),
                datasets: [{
                    label: 'Pendapatan (Miliar Rp)',
                    data: @json($chartData),
                    backgroundColor: '#4a9fb5', // Teal Mount Carmel
                    borderRadius: 6,
                    barPercentage: 0.6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1a2332',
                        padding: 12,
                        titleFont: { family: 'Plus Jakarta Sans', size: 13 },
                        bodyFont: { family: 'Plus Jakarta Sans', size: 14, weight: 'bold' },
                        callbacks: {
                            label: function(context) { return 'Rp ' + context.parsed.y + ' Miliar'; }
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false, drawBorder: false } },
                    y: { 
                        grid: { borderDash: [4, 4], color: '#e5e7eb', drawBorder: false },
                        ticks: { callback: function(value) { return value + ' M'; } }
                    }
                }
            }
        });
    });
</script>
@endsection