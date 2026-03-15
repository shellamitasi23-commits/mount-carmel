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
    @if(auth()->user()->role == 'admin')
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

{{-- Ringkasan 2 cluster --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">
    @forelse($clusters as $cluster)
    @php
        $isMuslim    = $cluster->kategori === 'Muslim';
        $totalKav    = $cluster->kavlings()->count();
        $tersedia    = $cluster->kavlings()->where('status','Tersedia')->count();
        $dipesan     = $cluster->kavlings()->where('status','Dipesan')->count();
        $terjual     = $cluster->kavlings()->where('status','Terjual')->count();
        $tipeList    = $cluster->kavlings()->pluck('tipe_kavling')->unique()->sort()->values();
    @endphp
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
        {{-- Header warna --}}
        <div class="h-2 w-full {{ $isMuslim ? 'bg-teal-500' : 'bg-blue-500' }}"></div>
        <div class="p-6">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl {{ $isMuslim ? 'bg-teal-50 text-teal-600' : 'bg-blue-50 text-blue-600' }} flex items-center justify-center shrink-0">
                        <span class="material-icons-outlined text-2xl">{{ $isMuslim ? 'mosque' : 'church' }}</span>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-lg leading-tight">{{ $cluster->nama_cluster }}</h3>
                        <span class="text-[11px] font-bold px-2 py-0.5 rounded {{ $isMuslim ? 'bg-teal-100 text-teal-700' : 'bg-blue-100 text-blue-700' }} uppercase tracking-wide">
                            {{ $cluster->kategori }}
                        </span>
                    </div>
                </div>
                @if(auth()->user()->role == 'admin')
                <div class="flex gap-2 shrink-0">
                    <button onclick="openEditModal({{ $cluster->id }})"
                            class="text-slate-400 hover:text-slate-700 bg-white border border-slate-200 p-2 rounded-lg shadow-sm transition-all" title="Edit">
                        <span class="material-icons-outlined text-lg">edit</span>
                    </button>
                    <form action="{{ route('admin.cluster.destroy', $cluster->id) }}" method="POST"
                          onsubmit="return confirm('Yakin hapus cluster ini? Semua kavling di dalamnya juga terhapus.')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="text-slate-400 hover:text-red-600 bg-white border border-slate-200 hover:border-red-200 p-2 rounded-lg shadow-sm transition-all" title="Hapus">
                            <span class="material-icons-outlined text-lg">delete</span>
                        </button>
                    </form>
                </div>
                @endif
            </div>

            {{-- Deskripsi --}}
            <p class="text-xs text-slate-500 leading-relaxed mb-5">
                {{ $cluster->deskripsi ?? 'Tidak ada deskripsi.' }}
            </p>

            {{-- Statistik Kavling --}}
            <div class="grid grid-cols-3 gap-3 mb-5">
                <div class="bg-slate-50 rounded-xl p-3 text-center">
                    <p class="text-xl font-black text-slate-800">{{ $tersedia }}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wide mt-0.5">Tersedia</p>
                </div>
                <div class="bg-yellow-50 rounded-xl p-3 text-center">
                    <p class="text-xl font-black text-yellow-700">{{ $dipesan }}</p>
                    <p class="text-[10px] font-bold text-yellow-400 uppercase tracking-wide mt-0.5">Dipesan</p>
                </div>
                <div class="bg-slate-100 rounded-xl p-3 text-center">
                    <p class="text-xl font-black text-slate-600">{{ $terjual }}</p>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wide mt-0.5">Terjual</p>
                </div>
            </div>

            {{-- Tipe Kavling --}}
            <div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">
                    {{ $tipeList->count() }} Tipe Kavling
                </p>
                <div class="flex flex-wrap gap-1.5">
                    @foreach($tipeList as $tipe)
                    <span class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg text-[11px] font-semibold">
                        {{ $tipe }}
                    </span>
                    @endforeach
                    @if($tipeList->isEmpty())
                    <span class="text-xs text-slate-400 italic">Belum ada kavling</span>
                    @endif
                </div>
            </div>

            {{-- Total --}}
            <div class="mt-4 pt-4 border-t border-slate-50 flex items-center justify-between">
                <span class="text-xs text-slate-400">Total kavling terdaftar</span>
                <span class="font-black text-slate-800">{{ $totalKav }} Unit</span>
            </div>
        </div>
    </div>
    @if(auth()->user()->role == 'admin')
    @include('admin.cluster.edit')
    @endif
    @empty
    <div class="col-span-2 py-16 bg-white border border-slate-100 rounded-2xl text-center">
        <span class="material-icons-outlined text-4xl text-slate-200 block mb-2">map</span>
        <p class="font-medium text-slate-500">Belum ada data cluster.</p>
        <p class="text-xs text-slate-400 mt-1">Klik "Tambah Cluster" atau jalankan <code class="bg-slate-100 px-1 rounded">php artisan db:seed --class=ClusterKavlingSeeder</code></p>
    </div>
    @endforelse
</div>

@if(auth()->user()->role == 'admin')
@include('admin.cluster.create')
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