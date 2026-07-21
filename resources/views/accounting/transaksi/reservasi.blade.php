@extends('layouts.admin')
@section('title', 'Data Reservasi - Mount Carmel')

@section('content')

@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
    <span class="material-icons-outlined">check_circle</span>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Data Reservasi</h1>
        <p class="text-sm text-slate-500 mt-1">Konfirmasi permohonan pemakaman dan pantau status unit lahan.</p>
    </div>
</div>

{{-- Filtering System --}}
<div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 mb-6">
    <form method="GET" action="{{ route('accounting.reservasi.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
        <div class="md:col-span-2">
            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1.5">Cari Data</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 material-icons-outlined text-slate-400 text-sm">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama pembeli atau nomor lahan..."
                       class="w-full pl-11 pr-4 py-2 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all placeholder:text-slate-300">
            </div>
        </div>
        <div>
            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1.5">Status Pipeline</label>
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
        <div>
            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1.5">Urutan Tanggal</label>
            <div class="relative">
                <select name="sort" onchange="this.form.submit()" class="w-full px-4 py-2 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all appearance-none cursor-pointer">
                    <option value="desc" {{ request('sort', 'desc') === 'desc' ? 'selected' : '' }}>Terbaru (Desc)</option>
                    <option value="asc" {{ request('sort') === 'asc' ? 'selected' : '' }}>Terlama (Asc)</option>
                </select>
                <span class="material-icons-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 text-sm">swap_vert</span>
            </div>
        </div>
        <div class="flex">
            @if(request('search') || request('status') || request('sort'))
            <a href="{{ route('accounting.reservasi.index') }}" class="w-full px-5 py-2 bg-slate-100 text-slate-500 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-200 transition-all text-center flex items-center justify-center">
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
                    <th class="px-4 py-2.5 text-right">Manajemen</th>
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
                        <p class="text-[10px] text-slate-400 mt-0.5 uppercase tracking-tighter mb-1">{{ $rs->lahan->cluster->nama_cluster }} / {{ $rs->lahan->tipe_lahan }}</p>
                        <div class="flex flex-wrap gap-1.5 mt-1">
                            @if($rs->marketing_oleh)
                                <span class="inline-block text-[9px] font-bold text-[#800000] bg-[#800000]/5 px-2 py-0.5 rounded-md">Sales: {{ $rs->marketing_oleh }}</span>
                            @endif
                            @if($rs->disetujui_oleh)
                                <span class="inline-block text-[9px] font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded-md">Oleh: {{ $rs->disetujui_oleh }}</span>
                            @endif
                        </div>
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
                        @php
                            $status = $rs->status_reservasi;
                            $badgeClass = match($status) {
                                'Disetujui' => 'bg-emerald-50 text-emerald-600',
                                'Ditolak' => 'bg-rose-50 text-rose-600',
                                'Selesai' => 'bg-slate-100 text-slate-500',
                                default => 'bg-amber-50 text-amber-600',
                             };
                        @endphp
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $badgeClass }}">
                            {{ $status }}
                        </span>
                    </td>
                    <td class="px-4 py-2.5 text-right" x-data="{ originalStatus: '{{ $rs->status_reservasi }}', newStatus: '{{ $rs->status_reservasi }}' }">
                        @if(in_array($rs->status_reservasi, ['Menunggu Validasi', 'Disetujui', 'Ditolak']))
                        <form id="form-status-{{ $rs->id }}" action="{{ route('accounting.reservasi.updateStatus', $rs->id) }}" method="POST" class="inline-block">
                            @csrf @method('PUT')
                            <select name="status" x-model="newStatus"
                                    @change="
                                         $dispatch('confirm-modal', { 
                                             title: 'Update Status', 
                                             message: 'Ubah status reservasi ini menjadi <b>' + newStatus + '</b>?', 
                                             confirmText: 'Ya, Perbarui',
                                             type: 'primary',
                                             action: () => document.getElementById('form-status-{{ $rs->id }}').submit(),
                                             cancel: () => { newStatus = originalStatus }
                                         })
                                     "
                                     class="bg-slate-50 border border-slate-200 text-[10px] font-bold text-slate-700 uppercase tracking-wider rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-slate-900/5 outline-none cursor-pointer">
                                <option value="Menunggu Validasi">Pending</option>
                                <option value="Disetujui">Setujui</option>
                                <option value="Ditolak">Tolak</option>
                            </select>
                        </form>
                        @else
                        <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest italic">Locked</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-slate-400 font-medium">Belum ada data reservasi yang tercatat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if(method_exists($reservasis, 'hasPages') && $reservasis->hasPages())
    <div class="px-4 py-3 border-t border-slate-50">
        {{ $reservasis->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
