@extends('layouts.admin')

@section('title', 'Data Jenazah - Mount Carmel')

@push('styles')
<style>
    body { font-family: 'Roboto', sans-serif !important; }
</style>
@endpush

@section('content')

@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
    <span class="material-icons-outlined">check_circle</span>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

@if(session('error'))
<div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl flex items-center gap-3">
    <span class="material-icons-outlined">error</span>
    <span class="font-medium text-sm">{{ session('error') }}</span>
</div>
@endif

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight uppercase">Data Jenazah</h1>
        <p class="text-sm text-slate-500 mt-1">Daftar lengkap jenazah yang dimakamkan di seluruh sektor Mount Carmel.</p>
    </div>
</div>

{{-- Filtering System --}}
<div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 mb-6">
    <form method="GET" action="{{ route(auth()->user()->role . '.jenazah.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div class="md:col-span-2">
            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1.5">Cari Data</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 material-icons-outlined text-slate-400 text-sm">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama jenazah, nomor lahan, atau nama ahli waris..."
                       class="w-full pl-11 pr-4 py-2 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all placeholder:text-slate-300">
            </div>
        </div>
        <div>
            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1.5">Status Validasi</label>
            <div class="relative">
                <select name="status" onchange="this.form.submit()" class="w-full px-4 py-2 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all appearance-none cursor-pointer">
                    <option value="">Semua Status</option>
                    <option value="Menunggu Validasi" {{ request('status') == 'Menunggu Validasi' ? 'selected' : '' }}>Pending</option>
                    <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
                <span class="material-icons-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 text-sm">expand_more</span>
            </div>
        </div>
        <div class="flex">
            @if(request('search') || request('status'))
            <a href="{{ route(auth()->user()->role . '.jenazah.index') }}" class="w-full px-5 py-2 bg-slate-100 text-slate-500 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-200 transition-all text-center flex items-center justify-center">
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
                <tr class="text-slate-500 font-bold bg-slate-50/50 border-b border-slate-100 uppercase tracking-widest text-[10px]">
                    <th class="px-4 py-2.5">Nama Jenazah</th>
                    <th class="px-4 py-2.5">Lokasi Lahan</th>
                    <th class="px-4 py-2.5">Tanggal Dimakamkan</th>
                    <th class="px-4 py-2.5">Nama Pembeli</th>
                    <th class="px-4 py-2.5">Status Validasi</th>
                    @if(auth()->user()->role === 'marketing')
                    <th class="px-4 py-2.5 text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($jenazahs as $j)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-4 py-2.5">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                                <span class="material-icons-outlined text-sm">person</span>
                            </div>
                            <div>
                                <p class="font-extrabold text-slate-900 uppercase tracking-tight">{{ $j->nama_jenazah }}</p>
                                <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">ID: #RE-{{ $j->reservasi->id }} (Slot {{ $j->nomor_slot }})</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-2.5">
                        <p class="font-extrabold text-slate-800 uppercase tracking-tight">Unit {{ $j->reservasi->lahan->nomor_lahan }}</p>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">{{ $j->reservasi->lahan->cluster->nama_cluster }}</p>
                    </td>
                    <td class="px-4 py-2.5">
                        @if($j->tanggal_dimakamkan)
                            <p class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($j->tanggal_dimakamkan)->translatedFormat('d F Y') }}</p>
                        @else
                            <span class="text-slate-300">Belum ditentukan</span>
                        @endif
                    </td>
                    <td class="px-4 py-2.5">
                        <p class="font-bold text-slate-800 uppercase text-xs">{{ $j->reservasi->user->name }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5">{{ $j->reservasi->user->email }}</p>
                    </td>
                    <td class="px-4 py-2.5">
                        @php
                            $vStatus = $j->status ?? 'Menunggu Validasi';
                            $vBadgeClass = match($vStatus) {
                                'Disetujui' => 'bg-emerald-50 text-emerald-600 border border-emerald-200',
                                'Ditolak' => 'bg-rose-50 text-rose-600 border border-rose-200',
                                default => 'bg-amber-50 text-amber-600 border border-amber-200',
                            };
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[9px] font-black uppercase tracking-widest {{ $vBadgeClass }}">
                            {{ $vStatus }}
                        </span>
                    </td>
                    @if(auth()->user()->role === 'marketing')
                    <td class="px-4 py-2.5 text-center">
                        @if(($j->status ?? 'Menunggu Validasi') === 'Menunggu Validasi')
                            <div class="flex items-center justify-center gap-2">
                                <form action="{{ route('marketing.jenazah.setujui', $j->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-[9px] uppercase px-2.5 py-1.5 rounded-lg transition-all active:scale-95 shadow-sm inline-flex items-center gap-1">
                                        <span class="material-icons-outlined text-[11px]">check</span> Setujui
                                    </button>
                                </form>
                                <form action="{{ route('marketing.jenazah.tolak', $j->id) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white font-bold text-[9px] uppercase px-2.5 py-1.5 rounded-lg transition-all active:scale-95 shadow-sm inline-flex items-center gap-1">
                                        <span class="material-icons-outlined text-[11px]">close</span> Tolak
                                    </button>
                                </form>
                            </div>
                        @else
                            <span class="text-xs text-slate-400 italic font-semibold">Tervalidasi</span>
                        @endif
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center">
                        <div class="flex flex-col items-center gap-4">
                            <span class="material-icons-outlined text-4xl text-slate-100">person_off</span>
                            <p class="text-slate-400 font-bold uppercase text-[10px] tracking-[0.3em]">Belum ada data jenazah yang tercatat</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($jenazahs->hasPages())
    <div class="px-4 py-3 border-t border-slate-50 bg-slate-50/30">
        {{ $jenazahs->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
