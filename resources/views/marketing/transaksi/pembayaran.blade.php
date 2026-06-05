@extends('layouts.admin')
@section('title', 'Riwayat Pembayaran - Mount Carmel')

@section('content')

@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
    <span class="material-icons-outlined">check_circle</span>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Riwayat Pembayaran</h1>
        <p class="text-sm text-slate-500 mt-1">Daftar transaksi yang telah divalidasi oleh departemen keuangan.</p>
    </div>
</div>

{{-- Search Bar --}}
<form method="GET" action="{{ route('marketing.pembayaran.index') }}" class="relative mb-6 group">
    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
        <span class="material-icons-outlined text-slate-400 group-focus-within:text-slate-900 transition-colors">search</span>
    </div>
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama pembeli, unit lahan, atau nomor invoice..."
           class="w-full pl-11 pr-10 py-2 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all placeholder:text-slate-300">
    
    @if(request('search'))
    <a href="{{ route('marketing.pembayaran.index') }}" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
        <span class="material-icons-outlined text-xl">close</span>
    </a>
    @endif
</form>

<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="text-slate-500 font-semibold bg-slate-50/80 border-b border-slate-100 uppercase tracking-wider text-[11px]">
                    <th class="px-4 py-2.5">Invoice & Tanggal</th>
                    <th class="px-4 py-2.5">Pembeli</th>
                    <th class="px-4 py-2.5">Unit Lahan</th>
                    <th class="px-4 py-2.5">Rekening Tujuan</th>
                    <th class="px-4 py-2.5">Nominal</th>
                    <th class="px-4 py-2.5 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 text-slate-700">
                @forelse($pembayarans as $p)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-4 py-2.5">
                        <p class="font-bold text-slate-900">{{ $p->no_invoice }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5 uppercase">{{ $p->created_at->format('d M Y') }}</p>
                    </td>
                    <td class="px-4 py-2.5">
                        <p class="font-bold text-slate-800">{{ $p->reservasi?->user?->name ?? 'N/A' }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5 uppercase tracking-tighter">{{ $p->reservasi?->user?->email ?? '-' }}</p>
                    </td>
                    <td class="px-4 py-2.5">
                        <p class="font-bold text-slate-800 uppercase">UNIT {{ $p->reservasi?->lahan?->nomor_lahan ?? '-' }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5 uppercase">{{ $p->reservasi?->lahan?->cluster?->nama_cluster ?? '-' }}</p>
                    </td>
                    <td class="px-4 py-2.5">
                        @if($p->nama_bank)
                            <p class="font-bold text-slate-800 uppercase">{{ $p->nama_bank }}</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">{{ $p->rekening_tujuan }}</p>
                        @else
                            <span class="text-slate-300">—</span>
                        @endif
                    </td>
                    <td class="px-4 py-2.5 font-bold text-slate-900">
                        Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}
                    </td>
                    <td class="px-4 py-2.5 text-center">
                        @php
                            $status = $p->status_pembayaran;
                            $badgeClass = match($status) {
                                'Dikonfirmasi', 'Lunas', 'Berhasil', 'Selesai' => 'bg-emerald-50 text-emerald-600',
                                'Ditolak' => 'bg-rose-50 text-rose-600',
                                default => 'bg-amber-50 text-amber-600',
                            };
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $badgeClass }}">
                            {{ $status }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-slate-400 font-medium">Belum ada riwayat pembayaran yang terdata.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if(method_exists($pembayarans, 'hasPages') && $pembayarans->hasPages())
    <div class="px-4 py-3 border-t border-slate-50 bg-slate-50/30">
        {{ $pembayarans->appends(request()->query())->links() }}
    </div>
    @endif
</div>

@endsection
