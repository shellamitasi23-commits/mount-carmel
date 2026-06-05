@extends('layouts.admin')
@section('title', 'Data Lahan — Mount Carmel')

@section('content')

@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
    <span class="material-icons-outlined">check_circle</span>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800 uppercase tracking-tight">Data Lahan</h1>
        <p class="text-sm text-slate-500 mt-1">Status dan inventori unit Mount Carmel (Non-Muslim) & Madinah (Muslim).</p>
    </div>
    <button onclick="openModal()"
            class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-2.5 rounded-xl font-bold flex items-center gap-2 shadow-md text-xs uppercase tracking-widest transition-all active:scale-95">
        <span class="material-icons-outlined text-sm">add</span> Tambah Lahan
    </button>
</div>

{{-- Search --}}
<div class="relative mb-6 group">
    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
        <span class="material-icons-outlined text-slate-400 group-focus-within:text-slate-900 transition-colors">search</span>
    </div>
    <form action="{{ route('koordinator_lapangan.lahan.index') }}" method="GET">
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Cari nomor lahan, tipe, cluster, atau status..." 
               class="w-full pl-11 pr-10 py-2 bg-white border border-slate-100 rounded-xl text-sm font-bold shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all placeholder:text-slate-300">
    </form>
</div>

{{-- Tab per Cluster --}}
<div x-data="{ activeCluster: 'semua' }">

    {{-- Tab Nav --}}
    <div class="flex items-center gap-1.5 mb-6 p-1.5 bg-white border border-slate-100 rounded-xl w-full shadow-sm">
        <button @click="activeCluster='semua'"
                :class="activeCluster==='semua'?'bg-slate-900 text-white shadow-sm':'text-slate-500 hover:text-slate-800'"
                class="flex-1 text-center px-4 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all">
            Semua ({{ $lahans->total() }})
        </button>
        @foreach($clusters as $cl)
        <button @click="activeCluster='{{ $cl->id }}'"
                :class="activeCluster==='{{ $cl->id }}'?'bg-slate-900 text-white shadow-sm':'text-slate-500 hover:text-slate-800'"
                class="flex-1 text-center px-4 py-2 rounded-lg text-[10px] font-black uppercase tracking-widest transition-all flex items-center justify-center gap-1.5">
            <span class="material-icons-outlined text-[14px]">{{ $cl->kategori==='Muslim'?'mosque':'church' }}</span>
            {{ $cl->nama_cluster }}
            <span class="text-[10px] opacity-70">({{ $cl->lahans()->count() }})</span>
        </button>
        @endforeach
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="text-slate-500 font-bold bg-slate-50/80 border-b border-slate-100 uppercase tracking-widest text-[10px]">
                        <th class="px-4 py-2.5">Nomor</th>
                        <th class="px-4 py-2.5">Lahan & Cluster</th>
                        <th class="px-4 py-2.5">Hadap</th>
                        <th class="px-4 py-2.5">Ukuran & Kapasitas</th>
                        <th class="px-4 py-2.5">Harga</th>
                        <th class="px-4 py-2.5">Status</th>
                        <th class="px-4 py-2.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-slate-700">
                    @forelse($lahans as $lahan)
                    <tr class="hover:bg-slate-50/50 transition-colors"
                        x-show="activeCluster==='semua' || activeCluster==='{{ $lahan->cluster_id }}'">
                        <td class="px-4 py-2.5 font-bold text-slate-900">#{{ $lahan->nomor_lahan }}</td>
                        <td class="px-4 py-2.5">
                            <p class="font-bold text-slate-900 uppercase tracking-tight">{{ $lahan->tipe_lahan }}</p>
                            <p class="text-[10px] font-bold mt-0.5 flex items-center gap-1
                                {{ $lahan->cluster->kategori==='Muslim' ? 'text-teal-600' : 'text-blue-600' }}">
                                <span class="material-icons-outlined text-[14px]">{{ $lahan->cluster->kategori==='Muslim'?'mosque':'church' }}</span>
                                {{ $lahan->cluster->nama_cluster ?? '—' }}
                            </p>
                        </td>
                        <td class="px-4 py-2.5">
                            <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded text-[10px] font-bold uppercase">{{ $lahan->hadap ?? '—' }}</span>
                        </td>
                        <td class="px-4 py-2.5">
                            <p class="font-bold text-slate-800">{{ $lahan->ukuran }}</p>
                            <p class="text-[10px] font-bold text-slate-400 mt-0.5">{{ $lahan->kapasitas }} Orang</p>
                        </td>
                        <td class="px-4 py-2.5 font-bold text-slate-900">
                            Rp {{ number_format($lahan->harga, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-2.5">
                            @if($lahan->status == 'Tersedia')
                                <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-md text-[10px] font-black uppercase tracking-tighter">Tersedia</span>
                            @elseif($lahan->status == 'Dipesan')
                                <span class="px-3 py-1 bg-amber-50 text-amber-600 rounded-md text-[10px] font-black uppercase tracking-tighter">Dipesan</span>
                            @else
                                <span class="px-3 py-1 bg-slate-200 text-slate-600 rounded-md text-[10px] font-black uppercase tracking-tighter">Terjual</span>
                            @endif
                        </td>
                        <td class="px-4 py-2.5 text-center">
                            <div class="flex justify-center gap-2">
                                <button onclick="openEditModal({{ $lahan->id }})"
                                        class="text-slate-400 hover:text-slate-900 bg-white border border-slate-100 p-2 rounded-lg shadow-sm transition-all">
                                    <span class="material-icons-outlined text-lg">edit</span>
                                </button>
                                <form id="form-delete-{{ $lahan->id }}" action="{{ route('koordinator_lapangan.lahan.destroy', $lahan->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="button"
                                            @click="$dispatch('confirm-modal', { 
                                                title: 'Hapus Lahan', 
                                                message: 'Apakah Anda yakin ingin menghapus <b>Lahan #{{ $lahan->nomor_lahan }}</b>? <br><br> Data yang sudah dihapus tidak dapat dikembalikan.', 
                                                confirmText: 'Ya, Hapus Lahan',
                                                type: 'danger',
                                                action: () => document.getElementById('form-delete-{{ $lahan->id }}').submit() 
                                            })"
                                            class="text-slate-400 hover:text-red-600 bg-white border border-slate-100 hover:border-red-100 p-2 rounded-lg shadow-sm transition-all">
                                        <span class="material-icons-outlined text-lg">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @include('koordinator_lapangan.lahan.edit')
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-slate-400">
                            <span class="material-icons-outlined text-4xl text-slate-200 block mb-2">inventory_2</span>
                            <p class="font-bold uppercase tracking-widest text-xs">Belum ada Data Lahan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($lahans->hasPages())
        <div class="px-4 py-3 border-t border-slate-50">{{ $lahans->links() }}</div>
        @endif
    </div>

</div>

@include('koordinator_lapangan.lahan.create')

<script>
    function openModal()        { document.getElementById('createModal').classList.remove('hidden'); }
    function closeModal()       { document.getElementById('createModal').classList.add('hidden'); }
    function openEditModal(id)  { document.getElementById('editModal'+id).classList.remove('hidden'); }
    function closeEditModal(id) { document.getElementById('editModal'+id).classList.add('hidden'); }
</script>
@endsection
