@extends('layouts.admin')
@section('title', 'Dashboard Accounting')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-slate-800">Ringkasan Keuangan</h1>
    <p class="text-xs text-slate-500 mt-1">Pantau arus kas, konfirmasi pembayaran, dan kelola harga tipe Lahan.</p>
</div>

{{-- Stats Grid --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    {{-- Total Pendapatan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex items-center justify-between transition-all hover:shadow-md duration-300">
        <div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Pendapatan</p>
            <h3 class="text-xl font-extrabold text-slate-800 mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            <span class="inline-flex items-center gap-1.5 mt-2 text-[11px] font-bold {{ $revenueChange >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                <span class="material-icons-outlined text-sm">{{ $revenueChange >= 0 ? 'trending_up' : 'trending_down' }}</span>
                {{ number_format(abs($revenueChange), 1) }}% dibanding bulan lalu
            </span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-slate-900/5 text-slate-900 flex items-center justify-center">
            <span class="material-icons-outlined text-2xl">payments</span>
        </div>
    </div>

    {{-- Pembayaran Tertunda --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex items-center justify-between transition-all hover:shadow-md duration-300">
        <div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Menunggu Verifikasi</p>
            <h3 class="text-xl font-extrabold text-slate-800 mt-2">{{ $pendingPayments }} Transaksi</h3>
            <span class="inline-flex items-center gap-1.5 mt-2 text-[11px] font-bold text-amber-600">
                <span class="material-icons-outlined text-sm">hourglass_empty</span>
                Membutuhkan konfirmasi Accounting
            </span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
            <span class="material-icons-outlined text-2xl">pending_actions</span>
        </div>
    </div>

    {{-- Pendapatan Bulan Ini --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 flex items-center justify-between transition-all hover:shadow-md duration-300">
        <div>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Pemasukan Bulan Ini</p>
            <h3 class="text-xl font-extrabold text-slate-800 mt-2">Rp {{ number_format($currentMonthRevenue, 0, ',', '.') }}</h3>
            <span class="inline-flex items-center gap-1.5 mt-2 text-[11px] font-bold text-blue-600">
                <span class="material-icons-outlined text-sm">calendar_today</span>
                Periode berjalan
            </span>
        </div>
        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
            <span class="material-icons-outlined text-2xl">account_balance_wallet</span>
        </div>
    </div>
</div>

{{-- Chart & Activity --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    {{-- Chart Pendapatan --}}
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <h3 class="text-sm font-bold text-slate-800 mb-4">Grafik Arus Kas Masuk (Juta Rupiah)</h3>
        <div class="h-64 flex items-end justify-between gap-4 pt-6 px-4 border-b border-slate-100 relative">
            @foreach($revenueData as $index => $rev)
                @php
                    $maxVal = max($revenueData) ?: 1;
                    $percent = ($rev / $maxVal) * 80; // Scale to 80% max height
                @endphp
                <div class="flex-1 flex flex-col items-center group relative">
                    <div class="absolute -top-10 bg-slate-900 text-white text-[10px] px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity font-bold">
                        Rp {{ $rev }} Jt
                    </div>
                    <div style="height: {{ max($percent, 8) }}%" class="w-full bg-slate-950 rounded-t-lg transition-all group-hover:bg-indigo-600 duration-300 shadow-sm"></div>
                    <span class="text-[10px] font-bold text-slate-400 mt-3">{{ $labels[$index] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Recent Payments --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-sm font-bold text-slate-800">Aktivitas Terbaru</h3>
            <a href="{{ route('accounting.pembayaran.index') }}" class="text-[10px] font-black text-slate-400 hover:text-slate-900 transition-colors uppercase tracking-widest">Semua</a>
        </div>
        <div class="space-y-4">
            @forelse($latestPayments as $payment)
                <div class="flex items-center gap-3.5 pb-4 border-b border-slate-50 last:border-b-0 last:pb-0">
                    <div class="w-9 h-9 rounded-full bg-slate-100 flex items-center justify-center font-bold text-xs text-slate-600">
                        {{ strtoupper(substr($payment->reservasi?->user?->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-slate-800 truncate">{{ $payment->reservasi?->user?->name ?? 'User' }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5">{{ $payment->created_at->diffForHumans() }} • Lahan #{{ $payment->reservasi?->kavling?->nomor_kavling ?? '-' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-extrabold text-slate-950">Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</p>
                        <span class="inline-block mt-1 text-[8px] font-black uppercase px-1.5 py-0.5 rounded
                            {{ $payment->status_pembayaran === 'Lunas' ? 'bg-emerald-50 text-emerald-700' :
                               ($payment->status_pembayaran === 'Ditolak' ? 'bg-rose-50 text-rose-700' : 'bg-amber-50 text-amber-700') }}">
                            {{ $payment->status_pembayaran }}
                        </span>
                    </div>
                </div>
            @empty
                <p class="text-xs text-slate-400 italic py-6 text-center">Belum ada transaksi pembayaran.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
