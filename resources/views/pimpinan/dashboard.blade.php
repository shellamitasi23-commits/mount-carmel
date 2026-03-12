@extends('layouts.admin')

@section('title', 'Executive Dashboard')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-xl font-black text-slate-800 tracking-tight">Executive Overview</h1>
        <p class="text-xs text-slate-500">Selamat datang, {{ auth()->user()->name }}. Berikut ringkasan performa Mount Carmel hari ini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-3">
                <div class="p-2 bg-emerald-50 rounded-lg text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                    <span class="material-icons-outlined text-sm">payments</span>
                </div>
                <span class="text-[10px] font-bold text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full uppercase">Finance</span>
            </div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Estimasi Omzet</p>
            <h3 class="text-xl font-black text-slate-800 mt-1">Rp {{ number_format($stats['omzet'], 0, ',', '.') }}</h3>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-3">
                <div class="p-2 bg-blue-50 rounded-lg text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                    <span class="material-icons-outlined text-sm">book_online</span>
                </div>
                <span class="text-[10px] font-bold text-blue-500 bg-blue-50 px-2 py-0.5 rounded-full uppercase">Booking</span>
            </div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Reservasi</p>
            <h3 class="text-xl font-black text-slate-800 mt-1">{{ $stats['reservasi'] }} <span class="text-xs font-normal text-slate-400">Unit</span></h3>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-3">
                <div class="p-2 bg-orange-50 rounded-lg text-orange-600 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                    <span class="material-icons-outlined text-sm">map</span>
                </div>
                <span class="text-[10px] font-bold text-orange-500 bg-orange-50 px-2 py-0.5 rounded-full uppercase">Inventory</span>
            </div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Lahan Tersedia</p>
            <h3 class="text-xl font-black text-slate-800 mt-1">{{ $stats['tersedia'] }} <span class="text-xs font-normal text-slate-400">Kavling</span></h3>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-shadow group">
            <div class="flex items-center justify-between mb-3">
                <div class="p-2 bg-purple-50 rounded-lg text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                    <span class="material-icons-outlined text-sm">group</span>
                </div>
                <span class="text-[10px] font-bold text-purple-500 bg-purple-50 px-2 py-0.5 rounded-full uppercase">Clients</span>
            </div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Pembeli</p>
            <h3 class="text-xl font-black text-slate-800 mt-1">{{ $stats['pembeli'] }} <span class="text-xs font-normal text-slate-400">Orang</span></h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-50 flex justify-between items-center">
                <h3 class="text-sm font-bold text-slate-800">Aktifitas Reservasi Terbaru</h3>
                <a href="{{ route('pimpinan.laporan.index') }}" class="text-[10px] font-bold text-blue-600 hover:underline">LIHAT SEMUA</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50/50 text-slate-400 font-bold uppercase text-[9px]">
                        <tr>
                            <th class="px-5 py-3">Pembeli</th>
                            <th class="px-5 py-3">Kavling</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($latest_reservasi as $rs)
                        <tr class="hover:bg-slate-50/50 transition-colors italic">
                            <td class="px-5 py-3 font-semibold text-slate-700">{{ $rs->user->name }}</td>
                            <td class="px-5 py-3 text-slate-500">{{ $rs->kavling->nomor_kavling }} ({{ $rs->kavling->cluster->nama_cluster }})</td>
                            <td class="px-5 py-3">
                                <span class="px-2 py-0.5 rounded-md text-[9px] font-black uppercase
                                    {{ $rs->status_reservasi == 'Disetujui' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                    {{ $rs->status_reservasi }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right text-slate-400 font-medium">{{ $rs->created_at->format('d/m/y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-slate-900 rounded-2xl p-6 text-white flex flex-col justify-between relative overflow-hidden shadow-xl shadow-slate-200">
            <div class="relative z-10">
                <h3 class="text-sm font-bold opacity-60 uppercase tracking-widest mb-1">Status Lahan</h3>
                <p class="text-xs font-light leading-relaxed">Persentase lahan tersedia saat ini membantu dalam perencanaan perluasan area pemakaman di masa mendatang.</p>
            </div>
            <div class="mt-8 relative z-10">
                <div class="flex justify-between text-[10px] font-bold mb-1 italic">
                    <span>Okupansi Lahan</span>
                    <span>75%</span>
                </div>
                <div class="w-full bg-slate-700 h-1.5 rounded-full">
                    <div class="bg-emerald-400 h-full rounded-full w-[75%]"></div>
                </div>
            </div>
            <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-slate-800 rounded-full blur-3xl opacity-50"></div>
        </div>
    </div>
</div>
@endsection