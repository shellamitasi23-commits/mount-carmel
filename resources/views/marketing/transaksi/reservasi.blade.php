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
        <p class="text-sm text-slate-500 mt-1">Kelola permohonan pemakaman dan pantau status unit lahan.</p>
    </div>

    @if(auth()->user()->role == 'marketing')
    <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
            class="bg-slate-900 text-white px-5 py-3 rounded-xl font-semibold text-sm hover:bg-black transition-all shadow-md flex items-center gap-2">
        <span class="material-icons-outlined text-sm">add</span> Input Reservasi
    </button>
    @endif
</div>

{{-- Filtering System --}}
<div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 mb-8">
    <form method="GET" action="{{ route('marketing.reservasi.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="md:col-span-2">
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Cari Data</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 material-icons-outlined text-slate-400 text-sm">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama pembeli atau nomor lahan..."
                       class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-slate-900/5 outline-none transition-all">
            </div>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status Pipeline</label>
            <select name="status" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-2 focus:ring-slate-900/5 outline-none transition-all appearance-none">
                <option value="">Semua Status</option>
                <option value="Menunggu Validasi" {{ request('status') == 'Menunggu Validasi' ? 'selected' : '' }}>Pending</option>
                <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="flex-1 bg-slate-900 text-white px-5 py-3 rounded-xl font-semibold text-sm hover:bg-black transition-all shadow-md">
                Filter
            </button>
            @if(request('search') || request('status'))
            <a href="{{ route('marketing.reservasi.index') }}" class="px-5 py-3 bg-slate-100 text-slate-600 rounded-xl font-semibold text-sm hover:bg-slate-200 transition-all text-center">
                Reset
            </a>
            @endif
        </div>
    </form>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="text-slate-500 font-semibold bg-slate-50/80 border-b border-slate-100 uppercase tracking-wider text-[11px]">
                    <th class="px-6 py-4">Pembeli</th>
                    <th class="px-6 py-4">Detail Lahan</th>
                    <th class="px-6 py-4">Informasi Jenazah</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    @if(auth()->user()->role == 'marketing')
                    <th class="px-6 py-4 text-right">Manajemen</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 text-slate-700">
                @forelse($reservasis as $rs)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-5">
                        <p class="font-bold text-slate-900 uppercase">{{ $rs->user->name }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5 uppercase tracking-tighter">{{ $rs->user->email }}</p>
                    </td>
                    <td class="px-6 py-5">
                        <p class="font-bold text-slate-800 uppercase">UNIT {{ $rs->lahan->nomor_lahan }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5 uppercase tracking-tighter">{{ $rs->lahan->cluster->nama_cluster }} / {{ $rs->lahan->tipe_lahan }}</p>
                    </td>
                    <td class="px-6 py-5">
                        @if($rs->nama_jenazah)
                            <p class="font-bold text-slate-700 uppercase text-[11px]">ALM. {{ $rs->nama_jenazah }}</p>
                            <p class="text-[10px] text-slate-400 mt-0.5 italic">Dimakamkan: {{ $rs->tanggal_dimakamkan ? \Carbon\Carbon::parse($rs->tanggal_dimakamkan)->translatedFormat('d M Y') : '-' }}</p>
                        @else
                            <span class="text-slate-300 text-[10px] font-medium italic">Data jenazah belum diisi</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-center">
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
                    @if(auth()->user()->role == 'marketing')
                    <td class="px-6 py-5 text-right" x-data="{ originalStatus: '{{ $rs->status_reservasi }}', newStatus: '{{ $rs->status_reservasi }}' }">
                        @if(in_array($rs->status_reservasi, ['Menunggu Validasi', 'Disetujui', 'Ditolak']))
                        <form id="form-status-{{ $rs->id }}" action="{{ route('marketing.reservasi.updateStatus', $rs->id) }}" method="POST" class="inline-block">
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
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-medium">Belum ada data reservasi yang tercatat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($reservasis->hasPages())
    <div class="px-6 py-4 border-t border-slate-50 bg-slate-50/30">
        {{ $reservasis->appends(request()->query())->links() }}
    </div>
    @endif
</div>

{{-- Modal Tambah Reservasi --}}
@if(auth()->user()->role == 'marketing')
<div id="modalTambah" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center z-50 p-6">
    <div class="bg-white rounded-3xl w-full max-w-xl shadow-2xl overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <h3 class="text-xl font-bold text-slate-800">Input Reservasi Baru</h3>
            <button onclick="document.getElementById('modalTambah').classList.add('hidden')" class="text-slate-400 hover:text-rose-500 transition-colors">
                <span class="material-icons-outlined">close</span>
            </button>
        </div>

        <form action="{{ route('marketing.reservasi.store') }}" method="POST" class="p-8 space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Pembeli <span class="text-rose-500">*</span></label>
                    <select name="user_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-slate-900/5 outline-none appearance-none">
                        <option value="" disabled selected>-- Pilih Pembeli --</option>
                        @foreach($pembelis as $p)
                        <option value="{{ $p->id }}">{{ strtoupper($p->name) }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Lahan <span class="text-rose-500">*</span></label>
                    <select name="lahan_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-slate-900/5 outline-none appearance-none">
                        <option value="" disabled selected>-- Pilih Lahan --</option>
                        @foreach($lahans as $k)
                        <option value="{{ $k->id }}">UNIT {{ $k->nomor_lahan }} ({{ strtoupper($k->cluster->nama_cluster) }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Jenazah <span class="text-slate-300 font-normal">(Opsional)</span></label>
                <input type="text" name="nama_jenazah" placeholder="Contoh: Alm. Fulan bin Fulan"
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-slate-900/5 outline-none">
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal Dimakamkan <span class="text-slate-300 font-normal">(Opsional)</span></label>
                <input type="date" name="tanggal_dimakamkan" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-slate-900/5 outline-none">
            </div>

            <div class="pt-4 flex gap-3">
                <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="flex-1 px-5 py-3 bg-slate-100 text-slate-600 rounded-xl font-semibold text-sm hover:bg-slate-200 transition-all">
                    Batal
                </button>
                <button type="submit" class="flex-1 bg-slate-900 text-white px-5 py-3 rounded-xl font-semibold text-sm hover:bg-black transition-all shadow-md">
                    Simpan Reservasi
                </button>
            </div>
        </form>
    </div>
</div>
@endif

@endsection
