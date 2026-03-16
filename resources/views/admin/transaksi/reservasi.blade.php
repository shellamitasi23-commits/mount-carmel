@extends('layouts.admin')
@section('title', 'Data Reservasi')

@section('content')

@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
    <span class="material-icons-outlined text-sm">check_circle</span>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

<div class="space-y-8 animate-fade-in-up">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-xl font-black text-slate-800 tracking-tight">Data Reservasi Pemakaman</h1>
            <p class="text-xs text-slate-500 mt-1 italic">Kelola permohonan pemakaman dan status ketersediaan kavling.</p>
        </div>

        @if(auth()->user()->role == 'admin')
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')"
                class="bg-slate-900 hover:bg-black text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-xl shadow-slate-200 transition-all hover:-translate-y-1 flex items-center gap-2">
            <span class="material-icons-outlined text-sm">add_circle</span>
            Input Reservasi Baru
        </button>
        @endif
    </div>

    {{-- Search Bar --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        <form method="GET" action="{{ route('admin.reservasi.index') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-widest mb-2">Cari Reservasi</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pembeli, nomor kavling, atau status..."
                       class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-300 focus:border-slate-300">
            </div>
            <div class="md:w-48">
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-widest mb-2">Filter Status</label>
                <select name="status" class="w-full px-4 py-3 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-slate-300 focus:border-slate-300">
                    <option value="">Semua Status</option>
                    <option value="Menunggu Validasi" {{ request('status') == 'Menunggu Validasi' ? 'selected' : '' }}>Menunggu Validasi</option>
                    <option value="Disetujui" {{ request('status') == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                    <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                    <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="bg-slate-900 hover:bg-black text-white px-6 py-3 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
                    <span class="material-icons-outlined text-sm">search</span>
                    Cari
                </button>
                @if(request('search') || request('status'))
                <a href="{{ route('admin.reservasi.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-3 rounded-xl text-sm font-bold transition-all flex items-center gap-2">
                    <span class="material-icons-outlined text-sm">clear</span>
                    Reset
                </a>
                @endif
            </div>
        </form>
    </div>

    <div class="bg-white rounded-[1.5rem] shadow-2xl shadow-slate-100/50 border border-slate-50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] border-b border-slate-100">
                        <th class="px-8 py-5">Informasi Pembeli</th>
                        <th class="px-8 py-5">Kavling & Area</th>
                        <th class="px-8 py-5 text-center">Jenazah / Jenis</th>
                        <th class="px-8 py-5 text-center">Tgl. Dimakamkan</th>
                        <th class="px-8 py-5 text-center">Status</th>
                        @if(auth()->user()->role == 'admin')
                        <th class="px-8 py-5 text-right">Tindakan</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($reservasis as $rs)
                    <tr class="group hover:bg-slate-50/30 transition-colors">

                        {{-- Pembeli --}}
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-extrabold text-slate-800">{{ $rs->user->name }}</span>
                                <span class="text-[10px] text-slate-400 font-medium lowercase italic">{{ $rs->user->email }}</span>
                                @if($rs->alamat_pemesan)
                                <span class="text-[10px] text-slate-400 mt-0.5">{{ Str::limit($rs->alamat_pemesan, 40) }}</span>
                                @endif
                            </div>
                        </td>

                        {{-- Kavling --}}
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-slate-700">{{ $rs->kavling->nomor_kavling }}</span>
                                <span class="text-[10px] text-slate-500">{{ $rs->kavling->tipe_kavling }}</span>
                                <span class="text-[9px] font-bold text-blue-500 uppercase tracking-widest">{{ $rs->kavling->cluster->nama_cluster }}</span>
                            </div>
                        </td>

                        {{-- FIX: Handle pre-need (nama_jenazah null) --}}
                        <td class="px-8 py-6 text-center">
                            @if($rs->nama_jenazah)
                                <span class="italic text-slate-600 font-medium text-xs block">Alm. {{ $rs->nama_jenazah }}</span>
                                <span class="mt-1 inline-block px-2 py-0.5 bg-green-50 text-green-700 rounded-full text-[9px] font-black uppercase">At-Need</span>
                            @else
                                <span class="italic text-slate-400 text-[11px] block">Belum diisi</span>
                                <span class="mt-1 inline-block px-2 py-0.5 bg-blue-50 text-blue-700 rounded-full text-[9px] font-black uppercase">Pre-Need</span>
                            @endif
                        </td>

                        {{-- Tanggal Dimakamkan --}}
                        <td class="px-8 py-6 text-center text-xs text-slate-600">
                            @if($rs->tanggal_dimakamkan)
                                {{ \Carbon\Carbon::parse($rs->tanggal_dimakamkan)->translatedFormat('d M Y') }}
                            @else
                                <span class="italic text-slate-400">Belum ditentukan</span>
                            @endif
                        </td>

                        {{-- FIX: Badge status lengkap semua nilai --}}
                        <td class="px-8 py-6 text-center">
                            @php
                                $badgeClass = match($rs->status_reservasi) {
                                    'Menunggu Validasi' => 'bg-amber-50 text-amber-600 border border-amber-100',
                                    'Disetujui'        => 'bg-emerald-50 text-emerald-600 border border-emerald-100',
                                    'Ditolak'          => 'bg-rose-50 text-rose-600 border border-rose-100',
                                    'Selesai'          => 'bg-slate-100 text-slate-600 border border-slate-200',
                                    default            => 'bg-gray-50 text-gray-500 border border-gray-100',
                                };
                            @endphp
                            <span class="px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-wider {{ $badgeClass }}">
                                {{ $rs->status_reservasi }}
                            </span>
                        </td>

                        {{-- Tindakan --}}
                        @if(auth()->user()->role == 'admin')
                        <td class="px-8 py-6 text-right">
                            {{-- FIX: value dropdown sesuai nilai di database --}}
                            @if(in_array($rs->status_reservasi, ['Menunggu Validasi', 'Disetujui', 'Ditolak']))
                            <form action="{{ route('admin.reservasi.updateStatus', $rs->id) }}" method="POST">
                                @csrf @method('PUT')
                                <select name="status" onchange="this.form.submit()"
                                        class="bg-white border border-slate-200 text-[10px] font-bold text-slate-700 rounded-lg px-2 py-1.5 outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all cursor-pointer shadow-sm">
                                    <option value="Menunggu Validasi" {{ $rs->status_reservasi == 'Menunggu Validasi' ? 'selected' : '' }}>
                                        Menunggu Validasi
                                    </option>
                                    <option value="Disetujui" {{ $rs->status_reservasi == 'Disetujui' ? 'selected' : '' }}>
                                        Setujui
                                    </option>
                                    <option value="Ditolak" {{ $rs->status_reservasi == 'Ditolak' ? 'selected' : '' }}>
                                        Tolak
                                    </option>
                                </select>
                            </form>
                            @else
                            {{-- Selesai: tidak bisa diubah lagi --}}
                            <span class="text-slate-400 text-[10px] font-bold italic">Selesai</span>
                            @endif
                        </td>
                        @endif

                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role == 'admin' ? '6' : '5' }}"
                            class="px-8 py-16 text-center text-slate-400">
                            <span class="material-icons-outlined text-4xl text-slate-200 block mb-2">inbox</span>
                            <p class="font-medium text-sm">Belum ada data reservasi.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($reservasis->hasPages())
        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/50">
            {{ $reservasis->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>

{{-- Modal Tambah Reservasi --}}
@if(auth()->user()->role == 'admin')
<div id="modalTambah" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-[2rem] w-full max-w-md p-8 shadow-2xl animate-fade-in-up">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-black text-slate-800 tracking-tight">Input Reservasi</h3>
            <button onclick="document.getElementById('modalTambah').classList.add('hidden')"
                    class="text-slate-400 hover:text-rose-500">
                <span class="material-icons-outlined">cancel</span>
            </button>
        </div>

        <form action="{{ route('admin.reservasi.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Pilih Pembeli</label>
                <select name="user_id" required
                        class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-semibold outline-none focus:ring-4 focus:ring-slate-900/5 transition-all">
                    <option value="" disabled selected>-- Pilih Pembeli --</option>
                    @foreach($pembelis as $p)
                    <option value="{{ $p->id }}">{{ $p->name }} — {{ $p->email }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Kavling Tersedia</label>
                <select name="kavling_id" required
                        class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-semibold outline-none focus:ring-4 focus:ring-slate-900/5 transition-all">
                    <option value="" disabled selected>-- Pilih Kavling --</option>
                    @foreach($kavlings as $k)
                    <option value="{{ $k->id }}">{{ $k->nomor_kavling }} — {{ $k->tipe_kavling }} ({{ $k->cluster->nama_cluster }})</option>
                    @endforeach
                </select>
            </div>

            {{-- Toggle Pre-Need / At-Need di modal admin --}}
            <div x-data="{ jenis: 'at-need' }">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Jenis Reservasi</label>
                <div class="grid grid-cols-2 gap-2 mb-4">
                    <label class="flex items-center gap-2 p-3 border-2 rounded-xl cursor-pointer transition-all text-xs font-bold"
                           :class="jenis === 'at-need' ? 'border-slate-900 bg-slate-50' : 'border-slate-100'"
                           @click="jenis = 'at-need'">
                        <div class="w-3.5 h-3.5 rounded-full border-2 flex items-center justify-center"
                             :class="jenis === 'at-need' ? 'border-slate-900' : 'border-slate-300'">
                            <div class="w-1.5 h-1.5 rounded-full bg-slate-900" :class="jenis === 'at-need' ? 'opacity-100' : 'opacity-0'"></div>
                        </div>
                        Langsung (At-Need)
                    </label>
                    <label class="flex items-center gap-2 p-3 border-2 rounded-xl cursor-pointer transition-all text-xs font-bold"
                           :class="jenis === 'pre-need' ? 'border-slate-900 bg-slate-50' : 'border-slate-100'"
                           @click="jenis = 'pre-need'">
                        <div class="w-3.5 h-3.5 rounded-full border-2 flex items-center justify-center"
                             :class="jenis === 'pre-need' ? 'border-slate-900' : 'border-slate-300'">
                            <div class="w-1.5 h-1.5 rounded-full bg-slate-900" :class="jenis === 'pre-need' ? 'opacity-100' : 'opacity-0'"></div>
                        </div>
                        Persiapan (Pre-Need)
                    </label>
                </div>

                {{-- Nama Jenazah --}}
                <div class="mb-4">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">
                        Nama Jenazah
                        <span x-show="jenis === 'at-need'" class="text-red-400">*</span>
                        <span x-show="jenis === 'pre-need'" class="text-slate-400 normal-case font-normal">(opsional)</span>
                    </label>
                    <input type="text" name="nama_jenazah"
                           :required="jenis === 'at-need'"
                           placeholder="Contoh: Alm. Fulan bin Fulan"
                           class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-semibold outline-none focus:ring-4 focus:ring-slate-900/5 transition-all">
                </div>

                {{-- Tanggal Dimakamkan --}}
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">
                        Tanggal Dimakamkan
                        <span x-show="jenis === 'at-need'" class="text-red-400">*</span>
                        <span x-show="jenis === 'pre-need'" class="text-slate-400 normal-case font-normal">(opsional)</span>
                    </label>
                    <input type="date" name="tanggal_dimakamkan"
                           :required="jenis === 'at-need'"
                           class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-semibold outline-none focus:ring-4 focus:ring-slate-900/5 transition-all">
                </div>
            </div>

            <div class="pt-4 flex gap-3">
                <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')"
                        class="flex-1 bg-slate-100 text-slate-500 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-200 transition-all">
                    Batal
                </button>
                <button type="submit"
                        class="flex-1 bg-slate-900 text-white py-3 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-slate-200 hover:bg-black transition-all">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
@endif

@endsection 