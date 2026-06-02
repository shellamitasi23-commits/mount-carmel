@extends('layouts.admin')
@section('title', 'Data Cluster — Mount Carmel')

@section('content')

@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
    <span class="material-icons-outlined">check_circle</span>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Data Cluster</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola zona pemakaman Muslim dan Non-Muslim.</p>
    </div>
    @if(auth()->user()->role == 'koordinator_lapangan')
    <button onclick="openModal()"
            class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-2.5 rounded-xl font-semibold flex items-center gap-2 transition-all shadow-md text-sm hover:shadow-lg hover:-translate-y-0.5">
        <span class="material-icons-outlined text-sm">add</span> Tambah Cluster
    </button>
    @endif
</div>

{{-- Search --}}
<div class="mb-6">
    <input id="cluster-search" type="text" placeholder="Cari cluster (nama, kategori, deskripsi)..." 
        class="w-full md:w-1/2 px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:border-blue-600 outline-none text-sm" />
</div>

{{-- Ringkasan Cluster List --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
    @forelse($clusters as $cluster)
    @php
        $isMuslim    = $cluster->kategori === 'Muslim';
        $totalKav    = $cluster->lahans()->count();
        $tersedia    = $cluster->lahans()->where('status','Tersedia')->count();
        $dipesan     = $cluster->lahans()->where('status','Dipesan')->count();
        $terjual     = $cluster->lahans()->where('status','Terjual')->count();
        $tipeList    = $cluster->lahans()->pluck('tipe_lahan')->unique()->sort()->values();
    @endphp
    <div class="bg-white border border-slate-100 rounded-[2rem] shadow-sm hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-500 overflow-hidden group">
        <div class="p-10">
            <div class="flex items-start justify-between mb-8">
                <div class="flex items-center gap-5">
                    <div class="w-14 h-14 rounded-2xl {{ $isMuslim ? 'bg-teal-500' : 'bg-indigo-600' }} flex items-center justify-center shadow-lg shadow-slate-200">
                        <span class="text-white font-black text-xl italic tracking-tighter">{{ substr($cluster->nama_cluster, 0, 1) }}</span>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-xl tracking-tight leading-none mb-2 uppercase">{{ $cluster->nama_cluster }}</h3>
                        <span class="inline-block px-3 py-1 rounded-md text-[9px] font-black uppercase tracking-widest {{ $isMuslim ? 'bg-teal-50 text-teal-600' : 'bg-indigo-50 text-indigo-600' }}">
                            {{ strtoupper($cluster->kategori) }} SECTOR
                        </span>
                    </div>
                </div>
                
                @if(auth()->user()->role == 'koordinator_lapangan')
                <div class="flex gap-2">
                    <button onclick="openEditModal({{ $cluster->id }})"
                            class="w-10 h-10 flex items-center justify-center bg-white border border-slate-100 text-slate-400 hover:text-slate-900 hover:border-slate-200 rounded-xl transition-all shadow-sm" title="Edit Configuration">
                        <span class="material-icons-outlined text-lg">edit</span>
                    </button>
                    <form id="form-delete-cluster-{{ $cluster->id }}" action="{{ route('koordinator_lapangan.cluster.destroy', $cluster->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="button"
                                @click="$dispatch('confirm-modal', { 
                                    title: 'Hapus Cluster', 
                                    message: 'Apakah Anda yakin ingin menghapus <b>{{ $cluster->nama_cluster }}</b>? <br><br> Seluruh data lahan di dalamnya akan ikut terhapus secara permanen.', 
                                    confirmText: 'Hapus Permanen',
                                    type: 'danger',
                                    action: () => document.getElementById('form-delete-cluster-{{ $cluster->id }}').submit() 
                                })"
                                class="w-10 h-10 flex items-center justify-center bg-white border border-slate-100 text-slate-400 hover:text-rose-600 hover:border-rose-100 rounded-xl transition-all shadow-sm" title="Remove Cluster">
                            <span class="material-icons-outlined text-lg">delete</span>
                        </button>
                    </form>
                </div>
                @endif
            </div>

            <p class="text-xs font-medium text-slate-400 leading-relaxed mb-8 uppercase tracking-wide">
                {{ $cluster->deskripsi ?? 'No sector description available.' }}
            </p>

            {{-- Stat Matrix --}}
            <div class="grid grid-cols-3 gap-4 mb-10">
                <div class="bg-slate-50/50 p-5 rounded-3xl text-center">
                    <p class="text-2xl font-black text-slate-900 tracking-tighter">{{ $tersedia }}</p>
                    <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mt-1">Ready</p>
                </div>
                <div class="bg-indigo-50/30 p-5 rounded-3xl text-center">
                    <p class="text-2xl font-black text-indigo-600 tracking-tighter">{{ $dipesan }}</p>
                    <p class="text-[9px] font-black text-indigo-300 uppercase tracking-widest mt-1">Booked</p>
                </div>
                <div class="bg-slate-900 p-5 rounded-3xl text-center">
                    <p class="text-2xl font-black text-white tracking-tighter">{{ $terjual }}</p>
                    <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mt-1">Sold</p>
                </div>
            </div>

            <div class="flex items-center justify-between pt-6 border-t border-slate-50">
                <div class="flex -space-x-2">
                    @foreach($tipeList->take(3) as $tipe)
                        <div class="px-3 py-1.5 bg-white border border-slate-100 rounded-lg text-[9px] font-black text-slate-500 uppercase tracking-widest shadow-sm">
                            {{ $tipe }}
                        </div>
                    @endforeach
                    @if($tipeList->count() > 3)
                        <div class="px-2 py-1.5 text-[9px] font-black text-slate-300 uppercase tracking-widest">+{{ $tipeList->count() - 3 }}</div>
                    @endif
                </div>
                <div class="text-right">
                    <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest leading-none mb-1 italic">Total Capacity</p>
                    <p class="text-lg font-black text-slate-900 tracking-tighter leading-none">{{ $totalKav }} Units</p>
                </div>
            </div>
        </div>
    </div>
    @if(auth()->user()->role == 'koordinator_lapangan')
    @include('koordinator_lapangan.cluster.edit')
    @endif
    @empty
    <div class="col-span-2 py-32 bg-white border border-slate-100 rounded-[3rem] text-center shadow-inner">
        <p class="text-3xl font-black text-slate-100 uppercase tracking-[0.3em] italic mb-4">No Sector Data</p>
        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Database is currently empty</p>
    </div>
    @endforelse
</div>

@if(auth()->user()->role == 'koordinator_lapangan')
@include('koordinator_lapangan.cluster.create')
@endif

<script>
    function openModal()        { document.getElementById('createModal').classList.remove('hidden'); }
    function closeModal()       { document.getElementById('createModal').classList.add('hidden'); }
    function openEditModal(id)  { document.getElementById('editModal'+id).classList.remove('hidden'); }
    function closeEditModal(id) { document.getElementById('editModal'+id).classList.add('hidden'); }

    // Search/filter card list
    function initClusterSearch() {
        const input = document.getElementById('cluster-search');
        const cards = document.querySelectorAll('.grid > div');

        if (!input) return;

        input.addEventListener('input', () => {
            const query = input.value.trim().toLowerCase();

            cards.forEach(card => {
                const text = card.innerText.toLowerCase();
                const matches = query === '' || text.includes(query);
                card.style.display = matches ? '' : 'none';
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initClusterSearch);
    } else {
        initClusterSearch();
    }
</script>
@endsection
