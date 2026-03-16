@extends('layouts.admin')

@section('title', 'Laporan Penjualan - Pimpinan')

@section('content')
@php
    $type = request('type', 'reservasi');
@endphp

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Laporan {{ ucfirst($type) }}</h1>
        <p class="text-sm text-slate-500 mt-1">Pantau dan cetak rekapitulasi data sesuai pilihan menu.</p>
    </div>

    <a href="{{ route('pimpinan.laporan.cetak', array_merge(request()->all(), ['type' => $type])) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl font-semibold flex items-center gap-2 transition-all shadow-md text-sm">
        <span class="material-icons-outlined text-sm">print</span>
        Cetak Laporan (PDF)
    </a>
</div>

<div class="flex flex-wrap items-center gap-3 mb-6">
    @php
        $tabs = [
            'reservasi' => 'Penjualan',
            'kavling' => 'Kavling',
            'pembeli' => 'Pembeli',
            'cluster' => 'Cluster',
        ];
    @endphp
    @foreach($tabs as $tabKey => $tabLabel)
        <a href="{{ route('pimpinan.laporan.index', array_merge(request()->except(['type', 'page']), ['type' => $tabKey])) }}" class="px-4 py-2 rounded-full text-xs font-semibold transition-all {{ $type === $tabKey ? 'bg-slate-900 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
            {{ $tabLabel }}
        </a>
    @endforeach
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 mb-8">
    <form action="{{ route('pimpinan.laporan.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <input type="hidden" name="type" value="{{ $type }}">

        @if($type === 'reservasi')
            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ request('start_date') }}" 
                       class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg p-2.5 outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ request('end_date') }}" 
                       class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg p-2.5 outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Status Reservasi</label>
                <select name="status" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg p-2.5 outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                    <option value="">Semua Status</option>
                    <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>
        @elseif($type === 'kavling')
            <div class="md:col-span-3">
                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Cari / Filter Kavling</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nomor, tipe, atau cluster" 
                       class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg p-2.5 outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>
        @elseif($type === 'pembeli')
            <div class="md:col-span-3">
                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Cari Pembeli</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama atau email pembeli" 
                       class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg p-2.5 outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>
        @elseif($type === 'cluster')
            <div class="md:col-span-3">
                <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Cari Cluster</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama cluster" 
                       class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-lg p-2.5 outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
            </div>
        @endif

        <div class="flex gap-2">
            <button type="submit" class="flex-1 bg-slate-900 text-white px-4 py-2.5 rounded-lg font-bold text-xs hover:bg-slate-800 transition-colors">
                FILTER
            </button>
            <a href="{{ route('pimpinan.laporan.index', ['type' => $type]) }}" class="px-4 py-2.5 bg-slate-100 text-slate-500 rounded-lg font-bold text-xs hover:bg-slate-200 transition-colors text-center">
                RESET
            </a>
        </div>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        @if($type === 'reservasi')
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="text-slate-500 font-semibold bg-slate-50 border-b border-slate-100 uppercase tracking-wider text-[11px]">
                        <th class="px-6 py-4">Tgl Reservasi</th>
                        <th class="px-6 py-4">Nama Pembeli</th>
                        <th class="px-6 py-4">Kavling / Cluster</th>
                        <th class="px-6 py-4">Harga</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-slate-700">
                    @forelse($reservasis as $rs)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-medium">{{ $rs->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">{{ $rs->user->name }}</td>
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-800">{{ $rs->kavling->nomor_kavling }}</p>
                            <p class="text-[10px] text-slate-400 uppercase tracking-tight">{{ $rs->kavling->cluster->nama_cluster }}</p>
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-900">
                            Rp {{ number_format($rs->kavling->harga, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-md text-[10px] font-bold uppercase 
                                {{ $rs->status_reservasi == 'Disetujui' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $rs->status_reservasi == 'Menunggu' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                {{ $rs->status_reservasi == 'Ditolak' ? 'bg-red-100 text-red-700' : '' }}">
                                {{ $rs->status_reservasi }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <span class="material-icons-outlined text-4xl text-slate-200 mb-2">find_in_page</span>
                                <p class="text-slate-400 font-medium italic text-xs">Tidak ada data yang sesuai dengan filter.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        @elseif($type === 'kavling')
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="text-slate-500 font-semibold bg-slate-50 border-b border-slate-100 uppercase tracking-wider text-[11px]">
                        <th class="px-6 py-4">Nomor Kavling</th>
                        <th class="px-6 py-4">Cluster</th>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4">Harga</th>
                        <th class="px-6 py-4">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-slate-700">
                    @forelse($kavlings as $k)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-medium">{{ $k->nomor_kavling }}</td>
                        <td class="px-6 py-4">{{ $k->cluster->nama_cluster ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $k->tipe_kavling }}</td>
                        <td class="px-6 py-4 font-bold text-slate-900">Rp {{ number_format($k->harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-md text-[10px] font-bold uppercase {{ $k->status == 'Tersedia' ? 'bg-emerald-100 text-emerald-700' : ($k->status == 'Terisi' ? 'bg-amber-100 text-amber-700' : 'bg-slate-100 text-slate-600') }}">
                                {{ $k->status }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <span class="material-icons-outlined text-4xl text-slate-200 mb-2">inventory_2</span>
                                <p class="text-slate-400 font-medium italic text-xs">Tidak ada data kavling.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        @elseif($type === 'pembeli')
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="text-slate-500 font-semibold bg-slate-50 border-b border-slate-100 uppercase tracking-wider text-[11px]">
                        <th class="px-6 py-4">Nama Pembeli</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Total Reservasi</th>
                        <th class="px-6 py-4">Terdaftar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-slate-700">
                    @forelse($pembelis as $p)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-medium">{{ $p->name }}</td>
                        <td class="px-6 py-4">{{ $p->email }}</td>
                        <td class="px-6 py-4 font-bold text-slate-900">{{ $p->reservasis_count }}</td>
                        <td class="px-6 py-4">{{ $p->created_at ? $p->created_at->format('d/m/Y') : '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <span class="material-icons-outlined text-4xl text-slate-200 mb-2">group</span>
                                <p class="text-slate-400 font-medium italic text-xs">Tidak ada data pembeli.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        @elseif($type === 'cluster')
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="text-slate-500 font-semibold bg-slate-50 border-b border-slate-100 uppercase tracking-wider text-[11px]">
                        <th class="px-6 py-4">Nama Cluster</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Total Kavling</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-slate-700">
                    @forelse($clusters as $c)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4 font-medium">{{ $c->nama_cluster }}</td>
                        <td class="px-6 py-4">{{ $c->kategori }}</td>
                        <td class="px-6 py-4 font-bold text-slate-900">{{ $c->kavlings_count }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <span class="material-icons-outlined text-4xl text-slate-200 mb-2">location_city</span>
                                <p class="text-slate-400 font-medium italic text-xs">Tidak ada data cluster.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection