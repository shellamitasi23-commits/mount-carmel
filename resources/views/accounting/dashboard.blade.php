@extends('layouts.admin')

@section('title', 'Financial Dashboard — Mount Carmel')

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
    <h1 class="text-xl font-extrabold text-slate-800 tracking-tight uppercase">Ringkasan Keuangan</h1>
    <p class="text-xs text-slate-500 mt-1">Monitoring arus kas dan verifikasi transaksi pembayaran.</p>
</div>

{{-- Stats Grid --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 border-l-4 border-l-[#800000]">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total Pendapatan</p>
        <h3 class="text-xl font-black text-slate-900 tracking-tighter">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
        <p class="text-[9px] font-bold mt-2 {{ $revenueChange >= 0 ? 'text-emerald-500' : 'text-rose-500' }}">
            {{ $revenueChange >= 0 ? '▲' : '▼' }} {{ number_format(abs($revenueChange), 1) }}% <span class="text-slate-300">vs bulan lalu</span>
        </p>
    </div>

    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 border-l-4 border-l-amber-500">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Menunggu Verifikasi</p>
        <h3 class="text-xl font-black text-slate-900 tracking-tighter">{{ $pendingPayments }} <span class="text-xs text-slate-300 uppercase">Transaksi</span></h3>
        <p class="text-[9px] font-bold text-amber-600 mt-2 uppercase tracking-widest">Perlu Konfirmasi Segera</p>
    </div>

    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 border-l-4 border-l-indigo-500">
        <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Pendapatan Bulan Ini</p>
        <h3 class="text-xl font-black text-slate-900 tracking-tighter">Rp {{ number_format($currentMonthRevenue, 0, ',', '.') }}</h3>
        <p class="text-[9px] font-bold text-slate-300 mt-2 uppercase tracking-widest">Periode {{ date('F Y') }}</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Chart Pendapatan --}}
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-100 p-5">
        <h4 class="text-[10px] font-black text-slate-800 uppercase tracking-widest mb-4">Tren Pendapatan (6 Bulan Terakhir)</h4>
        <div class="h-64 flex items-end justify-between gap-4">
            @foreach($revenueData as $index => $rev)
                @php
                    $maxVal = max($revenueData) ?: 1;
                    $percent = ($rev / $maxVal) * 100;
                @endphp
                <div class="flex-1 flex flex-col items-center group relative">
                    <div class="absolute -top-6 text-[8px] font-black text-slate-900 opacity-0 group-hover:opacity-100 transition-opacity">
                        {{ $rev }}M
                    </div>
                    <div style="height: {{ max($percent, 5) }}%" 
                         class="w-full bg-slate-100 group-hover:bg-[#800000] transition-all rounded-t-lg"></div>
                    <span class="text-[9px] font-bold text-slate-400 mt-3 uppercase">{{ $labels[$index] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Recent Activities --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden flex flex-col">
        <div class="px-4 py-3 border-b border-slate-50 flex items-center justify-between">
            <h4 class="text-[10px] font-black text-slate-800 uppercase tracking-widest">Aktivitas Terbaru</h4>
            <a href="{{ route('accounting.pembayaran.index') }}" class="text-[9px] font-bold text-slate-400 hover:text-slate-900 uppercase">Lihat Semua</a>
        </div>
        <div class="flex-1 overflow-y-auto">
            <div class="divide-y divide-slate-50">
                @forelse($latestPayments as $payment)
                <div class="px-4 py-2.5 hover:bg-slate-50 transition-colors">
                    <div class="flex justify-between items-start mb-1">
                        <p class="text-xs font-extrabold text-slate-900 uppercase tracking-tight truncate max-w-[120px]">
                            {{ $payment->reservasi?->user?->name ?? 'USER' }}
                        </p>
                        <p class="text-xs font-black text-slate-900 tracking-tighter">Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">
                            Unit {{ $payment->reservasi?->lahan?->nomor_lahan ?? '-' }} • {{ $payment->created_at->diffForHumans() }}
                        </p>
                        <span class="text-[8px] font-black uppercase px-2 py-0.5 rounded
                            {{ $payment->status_pembayaran === 'Lunas' ? 'bg-emerald-50 text-emerald-600' :
                               ($payment->status_pembayaran === 'Ditolak' ? 'bg-rose-50 text-rose-600' : 'bg-amber-50 text-amber-600') }}">
                            {{ $payment->status_pembayaran }}
                        </span>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center">
                    <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">Belum ada transaksi</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
