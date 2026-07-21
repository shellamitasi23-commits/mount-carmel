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
    <button onclick="openModal()"
            class="bg-[#800000] hover:bg-[#800000]/80 text-white px-5 py-2.5 rounded-xl font-bold flex items-center gap-2 shadow-md text-xs uppercase tracking-widest transition-all active:scale-95">
        <span class="material-icons-outlined text-sm">add</span> Tambah Cluster
    </button>
</div>

<div class="mb-6">
    <input id="cluster-search" type="text" placeholder="Cari cluster (nama, kategori, deskripsi)..." 
        class="w-full md:w-1/2 px-4 py-2 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all placeholder:text-slate-300" />
</div>

<div id="cluster-container" class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
    @forelse($clusters as $cluster)
    @php
        $isMuslim    = $cluster->kategori === 'Muslim';
        $totalKav    = $cluster->lahans_count;
        $tersedia    = $cluster->lahans()->where('status','Tersedia')->count();
        $dipesan     = $cluster->lahans()->whereIn('status', ['Reservasi (Lunas)', 'Reservasi Cicilan dengan DP', 'Terjual'])->count();
        $terpakai    = $cluster->lahans()->where('status','Digunakan')->count();
        $tipeList    = $cluster->lahans()->pluck('tipe_lahan')->unique()->sort()->values();
    @endphp
    <div class="bg-white border border-slate-100 rounded-xl shadow-sm hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-500 overflow-hidden group">
        <div class="p-5">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl {{ $isMuslim ? 'bg-teal-500' : 'bg-indigo-600' }} flex items-center justify-center shadow-lg shadow-slate-200">
                        <span class="text-white font-black text-lg italic tracking-tighter">{{ substr($cluster->nama_cluster, 0, 1) }}</span>
                    </div>
                    <div>
                        <h3 class="font-black text-slate-900 text-base tracking-tight leading-none mb-1.5 uppercase">{{ $cluster->nama_cluster }}</h3>
                        <span class="inline-block px-2.5 py-0.5 rounded-md text-[8px] font-black uppercase tracking-widest {{ $isMuslim ? 'bg-teal-50 text-teal-600' : 'bg-indigo-50 text-indigo-600' }}">
                            {{ strtoupper($cluster->kategori) }} SECTOR
                        </span>
                    </div>
                </div>

                <div class="flex items-center gap-1.5">
                    <button onclick="openEditModal({{ $cluster->id }})" class="p-1.5 text-slate-400 hover:text-slate-900 hover:bg-slate-50 rounded-lg transition-all" title="Edit Cluster">
                        <span class="material-icons-outlined text-lg block">edit</span>
                    </button>
                    <form id="form-delete-{{ $cluster->id }}" action="{{ route('koordinator_lapangan.cluster.destroy', $cluster->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="button"
                                @click="$dispatch('confirm-modal', { 
                                    title: 'Hapus Cluster', 
                                    message: 'Apakah Anda yakin ingin menghapus cluster <b>{{ $cluster->nama_cluster }}</b>? <br><br> Data cluster yang terhapus tidak dapat dikembalikan.', 
                                    confirmText: 'Ya, Hapus Cluster',
                                    type: 'danger',
                                    action: () => document.getElementById('form-delete-{{ $cluster->id }}').submit() 
                                })"
                                class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Hapus Cluster">
                            <span class="material-icons-outlined text-lg block">delete</span>
                        </button>
                    </form>
                </div>
            </div>

            <p class="text-[11px] font-medium text-slate-400 leading-relaxed mb-4 uppercase tracking-wide">
                {{ $cluster->deskripsi ?? 'No sector description available.' }}
            </p>

            <div class="grid grid-cols-3 gap-2 mb-6">
                <div class="bg-slate-50/50 p-2.5 rounded-xl text-center" title="Ready / Tersedia">
                    <p class="text-lg font-black text-slate-900 tracking-tighter">{{ $tersedia }}</p>
                    <p class="text-[8px] font-black text-slate-300 uppercase tracking-widest mt-0.5">Ready</p>
                </div>
                <div class="bg-indigo-50/30 p-2.5 rounded-xl text-center" title="Booked / Reservasi">
                    <p class="text-lg font-black text-indigo-600 tracking-tighter">{{ $dipesan }}</p>
                    <p class="text-[8px] font-black text-indigo-300 uppercase tracking-widest mt-0.5">Reservasi</p>
                </div>
                <div class="bg-[#800000] p-2.5 rounded-xl text-center" title="Used / Digunakan">
                    <p class="text-lg font-black text-white tracking-tighter">{{ $terpakai }}</p>
                    <p class="text-[8px] font-black text-white/70 uppercase tracking-widest mt-0.5">Digunakan</p>
                </div>
            </div>

            <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                <div class="flex -space-x-1.5">
                    @foreach($tipeList->take(3) as $tipe)
                        <div class="px-2.5 py-1 bg-white border border-slate-100 rounded-md text-[8px] font-black text-slate-500 uppercase tracking-widest shadow-sm">
                            {{ $tipe }}
                        </div>
                    @endforeach
                    @if($tipeList->count() > 3)
                        <div class="px-2 py-1 text-[8px] font-black text-slate-300 uppercase tracking-widest">+{{ $tipeList->count() - 3 }}</div>
                    @endif
                </div>
                <div class="text-right">
                    <p class="text-[8px] font-black text-slate-300 uppercase tracking-widest leading-none mb-1 italic">Total Capacity</p>
                    <p class="text-base font-black text-slate-900 tracking-tighter leading-none">{{ $totalKav }} Units</p>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-2 py-16 bg-white border border-slate-100 rounded-xl text-center shadow-inner">
        <p class="text-xl font-black text-slate-100 uppercase tracking-[0.3em] italic mb-2">No Sector Data</p>
        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">Database is currently empty</p>
    </div>
    @endforelse
</div>

@foreach($clusters as $cluster)
    @include('koordinator_lapangan.cluster.edit')
@endforeach

@include('koordinator_lapangan.cluster.create')

<script>
    function openModal() {
        document.getElementById('createModal').classList.remove('hidden');
    }
    function closeModal() {
        document.getElementById('createModal').classList.add('hidden');
    }
    function openEditModal(id) {
        document.getElementById('editModal' + id).classList.remove('hidden');
    }
    function closeEditModal(id) {
        document.getElementById('editModal' + id).classList.add('hidden');
    }

    // Search/filter card list
    function initClusterSearch() {
        const input = document.getElementById('cluster-search');
        const cards = document.querySelectorAll('#cluster-container > div');

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
