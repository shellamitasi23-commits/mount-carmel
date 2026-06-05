@extends('layouts.admin')
@section('title', 'Laporan Penjualan — Mount Carmel')

@section('content')
@php
    $type = request('type', 'reservasi');
@endphp

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight uppercase">Laporan Penjualan</h1>
        <p class="text-sm text-slate-500 mt-1">Data operasional dan performa penjualan Mount Carmel.</p>
    </div>
    <a href="{{ route('manajer.laporan.cetak', array_merge(request()->all(), ['type' => $type])) }}" target="_blank" 
       class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-widest transition-all shadow-md flex items-center gap-2">
        <span class="material-icons-outlined text-sm">print</span> Cetak Laporan (PDF)
    </a>
</div>

{{-- Navigation Tabs --}}
<div class="flex flex-wrap items-center gap-1.5 mb-6 p-1.5 bg-white border border-slate-100 rounded-xl w-fit shadow-sm">
    @php
        $tabs = [
            'reservasi' => 'Penjualan',
            'jenazah' => 'Data Jenazah',
            'lahan' => 'Lahan Terjual',
            'pembeli' => 'Database Pembeli',
            'cluster' => 'Distribusi Cluster',
        ];
    @endphp
    @foreach($tabs as $tabKey => $tabLabel)
        <a href="{{ route('manajer.laporan.index', array_merge(request()->except(['type', 'page']), ['type' => $tabKey])) }}" 
           class="px-5 py-2 rounded-lg text-xs font-bold transition-all 
           {{ $type === $tabKey ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
            {{ $tabLabel }}
        </a>
    @endforeach
</div>

{{-- Filtering --}}
<div class="bg-white border border-slate-100 rounded-xl shadow-sm p-4 mb-6">
    <form action="{{ route('manajer.laporan.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <input type="hidden" name="type" value="{{ $type }}">

        @if($type === 'reservasi')
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Periode Awal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" 
                       class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2 text-sm font-bold outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Periode Akhir</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" 
                       class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2 text-sm font-bold outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Status</label>
                <select name="status" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2 text-sm font-bold outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
                    <option value="">Semua Status</option>
                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Pending</option>
                    <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
        @else
            <div class="md:col-span-3">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Cari Data</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Masukkan kata kunci..." 
                       class="w-full px-4 py-2 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
            </div>
        @endif

        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-slate-900 text-white px-5 py-2 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-black transition-all">
                Filter
            </button>
            <a href="{{ route('manajer.laporan.index', ['type' => $type]) }}" 
               class="bg-slate-100 text-slate-500 px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-widest hover:bg-slate-200 transition-all text-center">
                Reset
            </a>
        </div>
    </form>
</div>

{{-- Data Table --}}
<div class="bg-white border border-slate-100 rounded-xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        @if($type === 'reservasi')
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tanggal</th>
                        <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Pembeli</th>
                        <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Lahan</th>
                        <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Investasi</th>
                        <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($reservasis as $rs)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-4 py-2.5 font-bold text-slate-900">{{ $rs->created_at->format('d/m/Y') }}</td>
                        <td class="px-4 py-2.5">
                            <p class="font-bold text-slate-900 uppercase tracking-tight">{{ $rs->user->name }}</p>
                            <p class="text-[10px] text-slate-400 font-bold mt-0.5">{{ $rs->user->email }}</p>
                        </td>
                        <td class="px-4 py-2.5">
                            <p class="font-bold text-slate-900 uppercase tracking-tight">#{{ $rs->lahan->nomor_lahan }}</p>
                            <p class="text-[10px] text-slate-400 font-bold mt-0.5">{{ $rs->lahan->cluster->nama_cluster }}</p>
                        </td>
                        <td class="px-4 py-2.5 font-bold text-slate-900">
                            Rp {{ number_format($rs->lahan->harga, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-2.5 text-center">
                            <span class="inline-block px-3 py-1 rounded-md text-[10px] font-black uppercase tracking-tighter
                                {{ $rs->status_reservasi == 'Disetujui' ? 'bg-emerald-50 text-emerald-600' : 
                                   ($rs->status_reservasi == 'Ditolak' ? 'bg-red-50 text-red-600' : 'bg-amber-50 text-amber-600') }}">
                                {{ $rs->status_reservasi }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center">
                            <p class="text-xs font-bold text-slate-300 uppercase tracking-widest">Tidak ada data ditemukan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        @elseif($type === 'jenazah')
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Jenazah</th>
                        <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Lokasi Lahan</th>
                        <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Ahli Waris (Pembeli)</th>
                        <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Tgl Dimakamkan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($jenazahs as $j)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-4 py-2.5 font-black text-slate-900 uppercase tracking-tight">{{ $j->nama_jenazah }}</td>
                        <td class="px-4 py-2.5">
                            <p class="font-bold text-slate-800 uppercase tracking-tight">UNIT {{ $j->lahan->nomor_lahan }}</p>
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">{{ $j->lahan->cluster->nama_cluster }}</p>
                        </td>
                        <td class="px-4 py-2.5">
                            <p class="font-bold text-slate-800 uppercase text-xs">{{ $j->user->name }}</p>
                            <p class="text-[10px] text-slate-400 mt-0.5">{{ $j->user->email }}</p>
                        </td>
                        <td class="px-4 py-2.5 text-right text-[10px] font-bold text-slate-500 uppercase">
                            {{ $j->tanggal_dimakamkan ? \Carbon\Carbon::parse($j->tanggal_dimakamkan)->format('d/m/Y') : '-' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center font-bold text-slate-300 uppercase text-xs">Belum ada data jenazah</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        @elseif($type === 'lahan')
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Unit Lahan</th>
                        <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Cluster</th>
                        <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Tipe</th>
                        <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Harga</th>
                        <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($lahans as $k)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-4 py-2.5 font-bold text-slate-900 uppercase tracking-tight">#{{ $k->nomor_lahan }}</td>
                        <td class="px-4 py-2.5 text-[10px] font-bold text-slate-600 uppercase">{{ $k->cluster->nama_cluster ?? '-' }}</td>
                        <td class="px-4 py-2.5 text-[10px] font-bold text-slate-600 uppercase">{{ $k->tipe_lahan }}</td>
                        <td class="px-4 py-2.5 font-bold text-slate-900 text-sm">Rp {{ number_format($k->harga, 0, ',', '.') }}</td>
                        <td class="px-4 py-2.5 text-center">
                            <span class="inline-block px-3 py-1 rounded-md text-[10px] font-black uppercase tracking-tighter {{ $k->status == 'Tersedia' ? 'bg-emerald-50 text-emerald-600' : 'bg-amber-50 text-amber-700' }}">
                                {{ $k->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-8 text-center font-bold text-slate-300 uppercase text-xs">Belum Ada Lahan Terjual</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        @elseif($type === 'pembeli')
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Pembeli</th>
                        <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Email</th>
                        <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Unit</th>
                        <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Join Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($pembelis as $p)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-4 py-2.5 font-bold text-slate-900 uppercase tracking-tight">{{ $p->name }}</td>
                        <td class="px-4 py-2.5 text-[10px] font-bold text-slate-600 uppercase">{{ $p->email }}</td>
                        <td class="px-4 py-2.5 text-center font-bold text-slate-900 text-sm">{{ $p->reservasis_count }} UNIT</td>
                        <td class="px-4 py-2.5 text-right text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $p->created_at ? $p->created_at->format('d/m/Y') : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center font-bold text-slate-300 uppercase text-xs">Database Kosong</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
