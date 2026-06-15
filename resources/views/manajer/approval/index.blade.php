@extends('layouts.admin')
@section('title', 'Approval Transaksi - Mount Carmel')

@section('content')

@if(session('success'))
<div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl flex items-center gap-3">
    <span class="material-icons-outlined">check_circle</span>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Approval Reservasi</h1>
        <p class="text-sm text-slate-500 mt-1">Daftar transaksi reservasi yang menunggu persetujuan (Menunggu Validasi).</p>
    </div>
</div>

<div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 mb-6">
    <form method="GET" action="{{ route('manajer.approval.index') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
        <div>
            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1.5">Cari Data</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 material-icons-outlined text-slate-400 text-sm">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama pembeli atau nomor lahan..."
                       class="w-full pl-11 pr-4 py-2 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all placeholder:text-slate-300">
            </div>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-5 py-2 bg-[#800000] text-white rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-[#800000]/90 transition-all">
                Cari
            </button>
            @if(request('search'))
            <a href="{{ route('manajer.approval.index') }}" class="px-5 py-2 bg-slate-100 text-slate-500 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-200 transition-all text-center flex items-center justify-center">
                Reset
            </a>
            @endif
        </div>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="text-slate-500 font-semibold bg-slate-50/80 border-b border-slate-100 uppercase tracking-wider text-[11px]">
                    <th class="px-4 py-2.5">Pembeli</th>
                    <th class="px-4 py-2.5">Detail Lahan</th>
                    <th class="px-4 py-2.5">Informasi Jenazah</th>
                    <th class="px-4 py-2.5 text-center">Status</th>
                    <th class="px-4 py-2.5 text-center">Aksi (Approval)</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 text-slate-700">
                @forelse($reservasis as $rs)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-4 py-2.5">
                        <p class="font-bold text-slate-900 uppercase">{{ $rs->user->name }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5 uppercase tracking-tighter">{{ $rs->user->email }}</p>
                    </td>
                    <td class="px-4 py-2.5">
                        <p class="font-bold text-slate-800 uppercase">UNIT {{ $rs->lahan->nomor_lahan }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5 uppercase tracking-tighter">{{ $rs->lahan->cluster->nama_cluster }} / {{ $rs->lahan->tipe_lahan }}</p>
                    </td>
                    <td class="px-4 py-2.5">
                        @if($rs->nama_jenazah)
                            <p class="font-bold text-slate-700 uppercase text-[11px]">ALM. {{ $rs->nama_jenazah }}</p>
                            <p class="text-[10px] text-slate-400 mt-0.5 italic">Dimakamkan: {{ $rs->tanggal_dimakamkan ? \Carbon\Carbon::parse($rs->tanggal_dimakamkan)->translatedFormat('d M Y') : '-' }}</p>
                        @else
                            <span class="text-slate-300 text-[10px] font-medium italic">Data jenazah belum diisi</span>
                        @endif
                    </td>
                    <td class="px-4 py-2.5 text-center">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-600">
                            {{ $rs->status_reservasi }}
                        </span>
                    </td>
                    <td class="px-4 py-2.5 text-center flex justify-center gap-2">
                        <form action="{{ route('manajer.approval.approve', $rs->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menyetujui reservasi ini?');">
                            @csrf @method('PUT')
                            <button type="submit" class="px-3 py-1.5 bg-[#800000] text-white text-[10px] font-bold uppercase rounded hover:bg-[#800000]/90 transition-colors">
                                Setujui
                            </button>
                        </form>
                        
                        <form action="{{ route('manajer.approval.reject', $rs->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menolak reservasi ini? Lahan akan kembali tersedia.');">
                            @csrf @method('PUT')
                            <button type="submit" class="px-3 py-1.5 bg-slate-100 text-slate-600 text-[10px] font-bold uppercase rounded hover:bg-slate-200 transition-colors">
                                Tolak
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-slate-400 font-medium">Tidak ada reservasi yang perlu persetujuan saat ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($reservasis->hasPages())
    <div class="px-4 py-3 border-t border-slate-50 bg-slate-50/30">
        {{ $reservasis->appends(request()->query())->links() }}
    </div>
    @endif
</div>

@endsection
