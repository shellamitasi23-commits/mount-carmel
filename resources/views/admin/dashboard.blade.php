@extends('layouts.admin')

@section('title', 'Dashboard - Mount Carmel')

@section('content')

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
    
    <div class="lg:col-span-2 flex flex-col gap-6">
        
<div class="relative bg-[#0a1120] rounded-[2rem] p-10 flex flex-col md:flex-row items-center justify-between overflow-hidden shadow-2xl shadow-slate-900/50 border border-slate-800/50">
    
    <div class="absolute top-[-20%] right-[-10%] w-96 h-96 bg-blue-600/15 rounded-full blur-[120px] pointer-events-none z-0"></div>
    
    <div class="relative z-10 text-white max-w-sm text-center md:text-left">
        <h2 class="text-3xl font-black leading-tight mb-5 tracking-tight">Pantau Ketersediaan Kavling Madinah.</h2>
        <button class="bg-white text-slate-900 px-8 py-3.5 rounded-xl font-bold hover:bg-slate-50 transition-all shadow-lg text-xs uppercase tracking-widest active:scale-95">
            Lihat Laporan
        </button>
    </div>

    <div class="mt-10 md:mt-0 relative z-10 w-full md:w-auto flex justify-center md:justify-end">
        <img src="https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=600&auto=format&fit=crop" 
             class="w-72 h-52 md:w-80 md:h-56 object-cover object-center rounded-2xl 
                    border border-white/20 
                    shadow-[0_20px_50px_rgba(8,_112,_184,_0.3)] 
                    transition-all duration-500 hover:scale-105 hover:shadow-[0_30px_60px_rgba(8,_112,_184,_0.5)]" 
             alt="Ilustrasi Kavling">
    </div>
</div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            <div class="flex flex-col gap-6">
                <div class="bg-card rounded-2xl p-6 border border-gray-100 shadow-sm relative overflow-hidden">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex items-center gap-2 text-textMuted text-sm font-medium">
                            <span class="material-icons-outlined text-base">payments</span> Total Pendapatan
                        </div>
                        <button class="text-gray-400"><span class="material-icons-outlined text-lg">more_horiz</span></button>
                    </div>
                    <h3 class="text-3xl font-bold text-textMain mt-2">Rp 7.83M</h3>
                    <p class="text-xs text-green-500 font-semibold mt-2 bg-green-50 w-max px-2 py-1 rounded-md">+28% <span class="text-textMuted font-normal">Dari bulan lalu</span></p>
                </div>

                <div class="bg-card rounded-2xl p-6 border border-gray-100 shadow-sm relative overflow-hidden">
                    <div class="flex justify-between items-start mb-2">
                        <div class="flex items-center gap-2 text-textMuted text-sm font-medium">
                            <span class="material-icons-outlined text-base">build</span> Biaya Pemeliharaan
                        </div>
                        <button class="text-gray-400"><span class="material-icons-outlined text-lg">more_horiz</span></button>
                    </div>
                    <h3 class="text-3xl font-bold text-textMain mt-2">Rp 582 Jt</h3>
                    <p class="text-xs text-red-500 font-semibold mt-2 bg-red-50 w-max px-2 py-1 rounded-md">+15% <span class="text-textMuted font-normal">Dari bulan lalu</span></p>
                </div>
            </div>

           <div class="bg-card rounded-2xl p-6 border border-gray-100 shadow-sm h-full min-h-[250px] flex flex-col">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="font-bold text-textMain text-sm">Grafik Pendapatan</h4>
                    <select class="text-xs border border-gray-200 bg-gray-50 text-textMuted rounded-md px-2 py-1 outline-none focus:ring-0 cursor-pointer">
                        <option>Tahun Ini</option>
                        <option>Tahun Lalu</option>
                    </select>
                </div>
                
                <div class="relative w-full flex-1">
                    <canvas id="revenueLineChart"></canvas>
                </div>
            </div>

        </div>

        <div class="bg-card rounded-2xl border border-gray-100 shadow-sm overflow-hidden mt-2">
            <div class="p-6 border-b border-gray-50">
                <h3 class="text-lg font-bold text-textMain">Laporan Penjualan</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead>
                        <tr class="text-textMuted font-semibold bg-gray-50/50">
                            <th class="px-6 py-4 font-medium">Pembeli</th>
                            <th class="px-6 py-4 font-medium">Email</th>
                            <th class="px-6 py-4 font-medium">Tipe Kavling</th>
                            <th class="px-6 py-4 font-medium">Harga</th>
                            <th class="px-6 py-4 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @php
                            $sales = [
                                ['name' => 'Budi Santoso', 'email' => 'budi@gmail.com', 'type' => 'Muslim - Fitrah', 'price' => 'Rp 150 Jt', 'status' => 'Lunas', 'color' => 'bg-green-100 text-green-700'],
                                ['name' => 'Michael Verade', 'email' => 'michael@gmail.com', 'type' => 'Non-Muslim - Family', 'price' => 'Rp 450 Jt', 'status' => 'Pending', 'color' => 'bg-teal-100 text-teal-700'],
                                ['name' => 'Siti Aminah', 'email' => 'siti.am@gmail.com', 'type' => 'Muslim - Sakinah', 'price' => 'Rp 210 Jt', 'status' => 'Lunas', 'color' => 'bg-green-100 text-green-700'],
                                ['name' => 'Keluarga Lee', 'email' => 'lee.fam@gmail.com', 'type' => 'Non-Muslim - VIP', 'price' => 'Rp 1.2 M', 'status' => 'Lunas', 'color' => 'bg-green-100 text-green-700'],
                                ['name' => 'Ahmad Rizal', 'email' => 'arizal@gmail.com', 'type' => 'Muslim - Barokah', 'price' => 'Rp 100 Jt', 'status' => 'Pending', 'color' => 'bg-teal-100 text-teal-700'],
                            ];
                        @endphp
                        @foreach($sales as $sale)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 flex items-center gap-3">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($sale['name']) }}&background=f3f4f6" class="w-8 h-8 rounded-full" alt="avatar">
                                <span class="font-semibold text-textMain">{{ $sale['name'] }}</span>
                            </td>
                            <td class="px-6 py-4 text-textMuted">{{ $sale['email'] }}</td>
                            <td class="px-6 py-4 text-textMuted">{{ $sale['type'] }}</td>
                            <td class="px-6 py-4 font-medium text-textMain">{{ $sale['price'] }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-[11px] font-bold uppercase tracking-wide {{ $sale['color'] }}">
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

    <div class="flex flex-col gap-6">
        
        <div class="bg-card rounded-2xl p-6 border border-gray-100 shadow-sm">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-textMain">Kavling Premium</h3>
                <a href="#" class="text-xs font-semibold text-textMuted hover:text-primary">Lihat Semua</a>
            </div>

            <div class="space-y-6">
                <div class="group cursor-pointer">
                    <div class="relative w-full h-36 rounded-xl overflow-hidden mb-3 shadow-lg border-2 border-slate-50">
                        <img src="https://images.unsplash.com/photo-1599809275671-b5942cabc7a2?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Kavling">
                        <span class="absolute top-2 left-2 bg-white/90 backdrop-blur text-xs font-bold px-2 py-1 rounded-md text-textMain shadow-sm">Tersedia</span>
                    </div>
                    <h4 class="font-bold text-textMain">Cluster Non-Muslim VIP</h4>
                    <p class="text-xs text-textMuted mt-1 mb-2">Ukuran 26m x 36m • Kapasitas 18</p>
                    <p class="font-bold text-primary text-lg">Rp 1.250.000.000</p>
                </div>

                <hr class="border-gray-50">

                <div class="group cursor-pointer">
                    <div class="relative w-full h-36 rounded-xl overflow-hidden mb-3 shadow-lg border-2 border-slate-50">
                        <img src="https://images.unsplash.com/photo-1584622650111-993a426fbf0a?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" alt="Kavling">
                        <span class="absolute top-2 left-2 bg-white/90 backdrop-blur text-xs font-bold px-2 py-1 rounded-md text-textMain shadow-sm">Tersedia</span>
                    </div>
                    <h4 class="font-bold text-textMain">Cluster Muslim Khalifah</h4>
                    <p class="text-xs text-textMuted mt-1 mb-2">Ukuran 7m x 15m • Kapasitas 12</p>
                    <p class="font-bold text-primary text-lg">Rp 650.000.000</p>
                </div>
            </div>
        </div>

        <div class="bg-card rounded-2xl p-6 border border-gray-100 shadow-sm flex-1 flex flex-col">
            <h3 class="font-bold text-textMain mb-4">Peta Cluster Madinah</h3>
            <div class="w-full flex-1 min-h-[200px] bg-gray-100 rounded-xl overflow-hidden relative border border-gray-200 cursor-pointer">
                <img src="https://images.unsplash.com/photo-1524661135-423995f22d0b?q=80&w=400&auto=format&fit=crop" class="w-full h-full object-cover opacity-50 grayscale" alt="Map">
                <div class="absolute inset-0 flex items-center justify-center bg-black/20">
                    <span class="bg-white px-4 py-2 rounded-lg shadow-xl text-[11px] uppercase tracking-wider font-extrabold text-textMain flex items-center gap-1.5 hover:scale-105 transition-all">
                        <span class="material-icons-outlined text-primary text-sm">location_on</span> View Masterplan
                    </span>
                </div>
            </div>
        </div>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctxLine = document.getElementById('revenueLineChart').getContext('2d');
        
        let gradient = ctxLine.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(74, 159, 181, 0.4)'); 
        gradient.addColorStop(1, 'rgba(74, 159, 181, 0.0)'); 

        new Chart(ctxLine, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Pendapatan',
                    data: [120, 250, 180, 320, 280, 450, 520],
                    borderColor: '#4a9fb5', 
                    backgroundColor: gradient,
                    borderWidth: 3,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#4a9fb5',
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
                        backgroundColor: '#1a2332',
                        padding: 10,
                        titleFont: { family: 'Plus Jakarta Sans', size: 12 },
                        bodyFont: { family: 'Plus Jakarta Sans', size: 14, weight: 'bold' },
                        displayColors: false,
                        callbacks: {
                            label: function(context) { return 'Rp ' + context.parsed.y + ' Juta'; }
                        }
                    }
                },
                scales: {
                    x: { 
                        grid: { display: false, drawBorder: false },
                        ticks: { font: { size: 11 } }
                    },
                    y: { 
                        grid: { borderDash: [4, 4], color: '#f3f4f6', drawBorder: false },
                        ticks: { 
                            font: { size: 11 },
                            callback: function(value) { return value + ' Jt'; }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection