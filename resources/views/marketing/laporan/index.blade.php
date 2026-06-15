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
    <a href="{{ route('marketing.laporan.pdf', array_merge(request()->all(), ['type' => $type])) }}" 
       class="bg-[#800000] hover:bg-[#800000]/90 text-white px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-widest transition-all shadow-md flex items-center gap-2">
        <span class="material-icons-outlined text-sm">picture_as_pdf</span> Export PDF
    </a>
</div>

{{-- Navigation Tabs --}}
<div class="flex items-center gap-1.5 mb-8 p-1.5 bg-white border border-slate-100 rounded-2xl w-full shadow-sm">
    @php
        $tabs = [
            'reservasi' => 'Penjualan',
            'jenazah' => 'Data Jenazah',
            'lahan' => 'Data Lahan',
            'pembeli' => 'Data Pembeli',
            'cluster' => 'Data Cluster',
        ];
    @endphp
    @foreach($tabs as $tabKey => $tabLabel)
        <a href="{{ route('marketing.laporan.index', array_merge(request()->except(['type', 'page']), ['type' => $tabKey])) }}" 
           class="flex-1 text-center px-5 py-2.5 rounded-xl text-xs font-bold transition-all 
           {{ $type === $tabKey ? 'bg-[#800000] text-white shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
            {{ $tabLabel }}
        </a>
    @endforeach
</div>

{{-- Filtering --}}
@if($type === 'reservasi')
    <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 mb-6">
        <form action="{{ route('marketing.laporan.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <input type="hidden" name="type" value="{{ $type }}">

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Periode Awal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" onchange="this.form.submit()"
                       class="w-full bg-white border border-slate-100 rounded-xl px-4 py-2 text-sm font-medium shadow-sm outline-none focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Periode Akhir</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" onchange="this.form.submit()"
                       class="w-full bg-white border border-slate-100 rounded-xl px-4 py-2 text-sm font-medium shadow-sm outline-none focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5">Status</label>
                <div class="relative">
                    <select name="status" onchange="this.form.submit()" class="w-full px-4 py-2 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all appearance-none cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="Menunggu Validasi" {{ request('status') == 'Menunggu Validasi' ? 'selected' : '' }}>Pending</option>
                        <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    </select>
                    <span class="material-icons-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 text-sm">expand_more</span>
                </div>
            </div>

            <div class="flex">
                <a href="{{ route('marketing.laporan.index', ['type' => $type]) }}" 
                   class="w-full px-5 py-2 bg-slate-100 text-slate-500 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-200 transition-all text-center flex items-center justify-center">
                    Reset
                </a>
            </div>
        </form>
    </div>
@else
    <form action="{{ route('marketing.laporan.index') }}" method="GET" class="relative mb-6 group">
        <input type="hidden" name="type" value="{{ $type }}">
        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <span class="material-icons-outlined text-slate-400 group-focus-within:text-slate-900 transition-colors">search</span>
        </div>
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari data..." 
               class="w-full pl-11 pr-10 py-2 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all placeholder:text-slate-300">
        
        @if(request('search'))
        <a href="{{ route('marketing.laporan.index', ['type' => $type]) }}" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
            <span class="material-icons-outlined text-xl">close</span>
        </a>
        @endif
    </form>
@endif

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
                        <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Harga Lahan</th>
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
                        <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Pembeli</th>
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
                        <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">TGL Beli</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($pembelis as $p)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-4 py-2.5 font-bold text-slate-900 uppercase tracking-tight">{{ $p->name }}</td>
                        <td class="px-4 py-2.5 text-[10px] font-bold text-slate-600 uppercase">{{ $p->email }}</td>
                        <td class="px-4 py-2.5 text-center font-bold text-slate-900 text-sm">{{ $p->reservasis_count }} UNIT</td>
                        <td class="px-4 py-2.5 text-right text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $p->created_at->format('d/m/Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-4 py-8 text-center font-bold text-slate-300 uppercase text-xs">Data Kosong</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        @elseif($type === 'cluster')
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="bg-slate-50/80 border-b border-slate-100">
                        <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Cluster</th>
                        <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Kategori</th>
                        <th class="px-4 py-2.5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Total Lahan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($clusters as $c)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-4 py-2.5 font-bold text-slate-900 uppercase tracking-tight">{{ $c->nama_cluster }}</td>
                        <td class="px-4 py-2.5">
                            <span class="inline-block px-3 py-1 rounded-md text-[10px] font-black uppercase tracking-tighter {{ $c->kategori == 'Muslim' ? 'bg-emerald-50 text-emerald-600' : 'bg-blue-50 text-blue-600' }}">
                                {{ $c->kategori }}
                            </span>
                        </td>
                        <td class="px-4 py-2.5 text-center font-bold text-slate-900 text-sm">{{ $c->lahans_count }} UNIT</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-4 py-8 text-center font-bold text-slate-300 uppercase text-xs">Belum Ada Data Cluster</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection
