@extends('layouts.admin')
@section('title', 'Data Pembayaran')

@section('content')

@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
    <span class="material-icons-outlined text-sm">check_circle</span>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

<div class="flex justify-between items-start mb-6">
    <div>
        <h1 class="text-xl font-bold text-slate-800">Data Pembayaran Lunas</h1>
        <p class="text-xs text-slate-500 mt-1">Daftar bukti transfer pembayaran lunas dari pembeli.</p>
    </div>
</div>

{{-- Search Bar --}}
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-6">
    <form method="GET" action="{{ route('marketing.pembayaran.index') }}" class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <label class="block text-xs font-bold text-slate-600 uppercase tracking-widest mb-2">Cari Pembayaran</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pembeli, nomor lahan, atau invoice..."
                   class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-300 focus:border-slate-300">
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="bg-slate-900 hover:bg-black text-white px-6 py-3 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
                <span class="material-icons-outlined text-sm">search</span>
                Cari
            </button>
            @if(request('search'))
            <a href="{{ route('marketing.pembayaran.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-3 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
                <span class="material-icons-outlined text-sm">clear</span>
                Reset
            </a>
            @endif
        </div>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 text-slate-400 font-bold uppercase tracking-widest text-[10px] border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4">Invoice</th>
                    <th class="px-6 py-4">Pembeli</th>
                    <th class="px-6 py-4">Lahan</th>
                    <th class="px-6 py-4">Rekening Tujuan</th>
                    <th class="px-6 py-4">Nominal</th>
                    <th class="px-6 py-4">Bukti Transfer</th>
                    <th class="px-6 py-4">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($pembayarans as $p)
                <tr class="hover:bg-slate-50/50 transition-colors">

                    {{-- Invoice --}}
                    <td class="px-6 py-4">
                        <p class="font-bold text-slate-800 text-[11px]">{{ $p->no_invoice }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5">{{ $p->created_at->format('d M Y') }}</p>
                    </td>

                    {{-- Pembeli --}}
                    <td class="px-6 py-4">
                        <p class="font-bold text-slate-700">{{ $p->reservasi?->user?->name ?? 'N/A' }}</p>
                        <p class="text-[10px] text-slate-400 italic">{{ $p->reservasi?->user?->email ?? '-' }}</p>
                    </td>

                    {{-- Lahan/Kavling --}}
                    <td class="px-6 py-4">
                        <p class="font-bold text-slate-700">Lahan #{{ $p->reservasi?->kavling?->nomor_kavling ?? '-' }}</p>
                        <p class="text-[10px] text-slate-400">{{ $p->reservasi?->kavling?->tipe_kavling ?? '-' }}</p>
                        <p class="text-[10px] text-slate-400">{{ $p->reservasi?->kavling?->cluster?->nama_cluster ?? '-' }}</p>
                    </td>

                    {{-- Rekening Tujuan --}}
                    <td class="px-6 py-4">
                        @if($p->nama_bank)
                        <span class="inline-block px-2 py-0.5 rounded text-[10px] font-black uppercase mb-1
                            {{ $p->nama_bank === 'BCA' ? 'bg-blue-100 text-blue-700' :
                                ($p->nama_bank === 'BNI' ? 'bg-orange-100 text-orange-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ $p->nama_bank }}
                        </span>
                        <p class="font-mono font-bold text-slate-700 text-[11px]">{{ $p->rekening_tujuan }}</p>
                        <p class="text-[10px] text-slate-400">a.n {{ $p->atas_nama_rekening }}</p>
                        @else
                        <span class="text-slate-400 italic text-[10px]">—</span>
                        @endif
                    </td>

                    {{-- Nominal --}}
                    <td class="px-6 py-4 font-bold text-slate-900">
                        Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}
                    </td>

                    {{-- Bukti Transfer --}}
                    <td class="px-6 py-4">
                        @if($p->bukti_pembayaran)
                        <a href="{{ asset('storage/' . $p->bukti_pembayaran) }}" target="_blank"
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-[10px] font-bold transition-colors">
                            <span class="material-icons-outlined text-sm">open_in_new</span> Lihat
                        </a>
                        @else
                        <span class="text-slate-400 italic text-[10px]">Belum ada</span>
                        @endif
                    </td>

                    {{-- Status Badge --}}
                    <td class="px-6 py-4">
                        @if($p->status_pembayaran === 'Lunas')
                            <span class="px-2 py-1 rounded-md text-[9px] font-black uppercase bg-emerald-100 text-emerald-700">
                                ✓ Lunas
                            </span>
                        @elseif($p->status_pembayaran === 'Ditolak')
                            <span class="px-2 py-1 rounded-md text-[9px] font-black uppercase bg-red-100 text-red-700">
                                ✗ Ditolak
                            </span>
                        @else
                            <span class="px-2 py-1 rounded-md text-[9px] font-black uppercase bg-amber-100 text-amber-700">
                                ⏳ Menunggu
                            </span>
                        @endif
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-14 text-center text-slate-400 italic">
                        <span class="material-icons-outlined text-4xl text-slate-200 block mb-2">receipt_long</span>
                        Belum ada data pembayaran lunas.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if(method_exists($pembayarans, 'hasPages') && $pembayarans->hasPages())
    <div class="px-6 py-4 border-t border-slate-50">
        {{ $pembayarans->appends(request()->query())->links() }}
    </div>
    @endif
</div>

@endsection
