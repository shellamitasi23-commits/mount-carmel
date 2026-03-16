@extends('layouts.admin')

@section('title', 'Executive Dashboard')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-xl font-black text-slate-800 tracking-tight">Executive Overview</h1>
        <p class="text-xs text-slate-500">Selamat datang, {{ auth()->user()->name }}. Berikut ringkasan performa Mount Carmel hari ini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Omzet --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-3">
                <div class="p-2 bg-emerald-50 rounded-lg text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                    <span class="material-icons-outlined text-sm">payments</span>
                </div>
                <span class="text-[10px] font-bold text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full uppercase tracking-wider">Finance</span>
            </div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Estimasi Omzet</p>
            <h3 class="text-xl font-black text-slate-800 mt-1">Rp {{ number_format($stats['omzet'] ?? 0, 0, ',', '.') }}</h3>
        </div>

        {{-- Reservasi --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-3">
                <div class="p-2 bg-blue-50 rounded-lg text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <span class="material-icons-outlined text-sm">book_online</span>
                </div>
                <span class="text-[10px] font-bold text-blue-500 bg-blue-50 px-2 py-0.5 rounded-full uppercase tracking-wider">Booking</span>
            </div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Reservasi</p>
            <h3 class="text-xl font-black text-slate-800 mt-1">{{ $stats['reservasi'] ?? 0 }} <span class="text-xs font-normal text-slate-400">Unit</span></h3>
        </div>

        {{-- Inventory --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-3">
                <div class="p-2 bg-orange-50 rounded-lg text-orange-600 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                    <span class="material-icons-outlined text-sm">map</span>
                </div>
                <span class="text-[10px] font-bold text-orange-500 bg-orange-50 px-2 py-0.5 rounded-full uppercase tracking-wider">Inventory</span>
            </div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Lahan Tersedia</p>
            <h3 class="text-xl font-black text-slate-800 mt-1">{{ $stats['tersedia'] ?? 0 }} <span class="text-xs font-normal text-slate-400">Kavling</span></h3>
        </div>

        {{-- Clients --}}
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-3">
                <div class="p-2 bg-purple-50 rounded-lg text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                    <span class="material-icons-outlined text-sm">group</span>
                </div>
                <span class="text-[10px] font-bold text-purple-500 bg-purple-50 px-2 py-0.5 rounded-full uppercase tracking-wider">Clients</span>
            </div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Pembeli</p>
            <h3 class="text-xl font-black text-slate-800 mt-1">{{ $stats['pembeli'] ?? 0 }} <span class="text-xs font-normal text-slate-400">Orang</span></h3>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6">
        <h3 class="text-sm font-bold text-slate-800 mb-4">Menu Laporan</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
            <a href="{{ route('pimpinan.laporan.index', ['type' => 'reservasi']) }}" class="px-4 py-3 rounded-xl text-xs font-semibold text-center transition-all {{ request('type', 'reservasi') === 'reservasi' ? 'bg-slate-900 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                <span class="material-icons-outlined text-base">shopping_cart</span>
                <div class="mt-1">Penjualan</div>
            </a>
            <a href="{{ route('pimpinan.laporan.index', ['type' => 'kavling']) }}" class="px-4 py-3 rounded-xl text-xs font-semibold text-center transition-all {{ request('type') === 'kavling' ? 'bg-slate-900 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                <span class="material-icons-outlined text-base">apartment</span>
                <div class="mt-1">Kavling</div>
            </a>
            <a href="{{ route('pimpinan.laporan.index', ['type' => 'pembeli']) }}" class="px-4 py-3 rounded-xl text-xs font-semibold text-center transition-all {{ request('type') === 'pembeli' ? 'bg-slate-900 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                <span class="material-icons-outlined text-base">people</span>
                <div class="mt-1">Pembeli</div>
            </a>
            <a href="{{ route('pimpinan.laporan.index', ['type' => 'cluster']) }}" class="px-4 py-3 rounded-xl text-xs font-semibold text-center transition-all {{ request('type') === 'cluster' ? 'bg-slate-900 text-white shadow-sm' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                <span class="material-icons-outlined text-base">location_on</span>
                <div class="mt-1">Cluster</div>
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Tabel Reservasi --}}
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-50 flex justify-between items-center">
                <h3 class="text-sm font-bold text-slate-800">Aktifitas Reservasi Terbaru</h3>
                <a href="{{ route('pimpinan.laporan.index') }}" class="text-[10px] font-bold text-blue-600 hover:text-blue-800 hover:underline uppercase tracking-widest transition-colors">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50/50 text-slate-400 font-bold uppercase text-[9px] tracking-wider">
                        <tr>
                            <th class="px-5 py-4">Pembeli</th>
                            <th class="px-5 py-4">Kavling</th>
                            <th class="px-5 py-4">Status</th>
                            <th class="px-5 py-4 text-right">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($latest_reservasi as $rs)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-5 py-3.5 font-bold text-slate-700">{{ $rs->user?->name ?? 'Pemesan Dihapus' }}</td>
                            <td class="px-5 py-3.5 text-slate-500">
                                {{ $rs->kavling?->nomor_kavling ?? 'N/A' }} 
                                <span class="text-[10px] opacity-70">({{ $rs->kavling?->cluster?->nama_cluster ?? '-' }})</span>
                            </td>
                            <td class="px-5 py-3.5">
                                @php
                                    // Logika warna status otomatis
                                    $statusText = strtolower($rs->status_reservasi ?? '');
                                    if (str_contains($statusText, 'setuju') || str_contains($statusText, 'lunas') || str_contains($statusText, 'selesai')) {
                                        $color = 'bg-emerald-100 text-emerald-700';
                                    } elseif (str_contains($statusText, 'tolak') || str_contains($statusText, 'batal')) {
                                        $color = 'bg-rose-100 text-rose-700';
                                    } else {
                                        $color = 'bg-amber-100 text-amber-700';
                                    }
                                @endphp
                                <span class="px-2.5 py-1 rounded-md text-[9px] font-black uppercase tracking-wider {{ $color }}">
                                    {{ $rs->status_reservasi ?? 'Pending' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-right text-slate-400 font-medium">
                                {{ $rs->created_at ? $rs->created_at->format('d/m/y') : '-' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-5 py-10 text-center text-slate-400 font-medium">Belum ada aktifitas reservasi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Status Lahan (Dinamis) --}}
        @php
            // PERHITUNGAN DATA OKUPANSI REAL
            // 1. Ambil data dari array $stats, atau kasih fallback 0
            $kavlingTersedia = $stats['tersedia'] ?? 0;
            $kavlingTerisi = $stats['terisi'] ?? 0;
            
            // 2. Hitung total keseluruhan kavling
            $totalKavling = $stats['total'] ?? ($kavlingTersedia + $kavlingTerisi);
            
            // 3. Hitung persentase agar tidak error Division by Zero
            $persentaseOkupansi = $totalKavling > 0 ? round(($kavlingTerisi / $totalKavling) * 100) : 0;
        @endphp

        <div class="bg-slate-900 rounded-2xl p-6 text-white flex flex-col justify-between relative overflow-hidden shadow-xl shadow-slate-200">
            <div class="relative z-10">
                <h3 class="text-sm font-bold opacity-60 uppercase tracking-widest mb-2">Status Lahan</h3>
                <p class="text-xs font-light leading-relaxed text-slate-300 mb-5">Persentase lahan tersedia saat ini membantu dalam perencanaan perluasan area pemakaman di masa mendatang.</p>
                
                {{-- Tambahan Info Angka Asli --}}
                <div class="flex gap-6 text-xs font-medium">
                    <div>
                        <span class="block text-slate-400 text-[9px] font-bold uppercase tracking-widest mb-1">Terisi</span>
                        <span class="text-xl font-black text-white">{{ $kavlingTerisi }}</span>
                    </div>
                    <div>
                        <span class="block text-slate-400 text-[9px] font-bold uppercase tracking-widest mb-1">Total</span>
                        <span class="text-xl font-black text-white">{{ $totalKavling }}</span>
                    </div>
                </div>
            </div>
            
            <div class="mt-8 relative z-10">
                <div class="flex justify-between items-center text-[10px] font-bold mb-2 uppercase tracking-widest text-slate-300">
                    <span>Okupansi Lahan</span>
                    <span class="text-emerald-400 text-lg font-black">{{ $persentaseOkupansi }}%</span>
                </div>
                <div class="w-full bg-slate-700 h-2.5 rounded-full overflow-hidden">
                    {{-- Bar persentase yang dinamis sesuai style inline --}}
                    <div class="bg-emerald-400 h-full rounded-full transition-all duration-1000 ease-out" style="width: {{ $persentaseOkupansi }}%"></div>
                </div>
            </div>
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>
        </div>
    </div>
</div>
@endsection