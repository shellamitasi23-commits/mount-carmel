@extends('layouts.admin')
@section('title', 'Data Kavling — Mount Carmel')

@section('content')

@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
    <span class="material-icons-outlined">check_circle</span>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Data Kavling</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola kavling per cluster. Madinah (Muslim) & Mount Carmel (Non-Muslim).</p>
    </div>
    @if(auth()->user()->role == 'admin')
    <button onclick="openModal()"
            class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-2.5 rounded-xl font-semibold flex items-center gap-2 shadow-md text-sm hover:-translate-y-0.5 transition-all">
        <span class="material-icons-outlined text-sm">add</span> Tambah Kavling
    </button>
    @endif
</div>

{{-- Search --}}
<div class="mb-6">
    <input id="kavling-search" type="text" placeholder="Cari kavling (nomor, tipe, cluster, status, harga)..." 
        class="w-full md:w-1/2 px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:border-blue-600 outline-none text-sm" />
</div>

{{-- Tab per Cluster --}}
<div x-data="{ activeCluster: 'semua' }">

    {{-- Tab Nav --}}
    <div class="flex flex-wrap gap-1.5 mb-6 p-1.5 bg-white border border-slate-100 rounded-xl w-fit shadow-sm">
        <button @click="activeCluster='semua'"
                :class="activeCluster==='semua'?'bg-slate-900 text-white shadow-sm':'text-slate-500 hover:text-slate-800'"
                class="px-4 py-2 rounded-lg text-xs font-bold transition-all">
            Semua ({{ $kavlings->count() }})
        </button>
        @foreach($clusters as $cl)
        <button @click="activeCluster='{{ $cl->id }}'"
                :class="activeCluster==='{{ $cl->id }}'?'bg-slate-900 text-white shadow-sm':'text-slate-500 hover:text-slate-800'"
                class="px-4 py-2 rounded-lg text-xs font-bold transition-all flex items-center gap-1.5">
            <span class="material-icons-outlined text-xs">{{ $cl->kategori==='Muslim'?'mosque':'church' }}</span>
            {{ $cl->nama_cluster }}
            <span class="text-[10px] opacity-70">({{ $cl->kavlings()->count() }})</span>
        </button>
        @endforeach
    </div>

    {{-- Tabel --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="text-slate-500 font-semibold bg-slate-50/80 border-b border-slate-100 uppercase tracking-wider text-[11px]">
                        <th class="px-6 py-4">Nomor</th>
                        <th class="px-6 py-4">Tipe & Cluster</th>
                        <th class="px-6 py-4">Ukuran & Kapasitas</th>
                        <th class="px-6 py-4">Harga</th>
                        <th class="px-6 py-4">Status</th>
                        @if(auth()->user()->role == 'admin')
                        <th class="px-6 py-4 text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-slate-700">
                    @forelse($kavlings as $kavling)
                    <tr class="hover:bg-slate-50/50 transition-colors"
                        x-show="activeCluster==='semua' || activeCluster==='{{ $kavling->cluster_id }}'">
                        <td class="px-6 py-4 font-bold text-slate-900">#{{ $kavling->nomor_kavling }}</td>
                        <td class="px-6 py-4">
                            <p class="font-bold text-slate-900">{{ $kavling->tipe_kavling }}</p>
                            <p class="text-xs mt-0.5 flex items-center gap-1
                                {{ $kavling->cluster->kategori==='Muslim' ? 'text-teal-600' : 'text-blue-600' }}">
                                <span class="material-icons-outlined text-xs">{{ $kavling->cluster->kategori==='Muslim'?'mosque':'church' }}</span>
                                {{ $kavling->cluster->nama_cluster ?? '—' }}
                            </p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-slate-800">{{ $kavling->ukuran }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $kavling->kapasitas }} Orang</p>
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-900">
                            Rp {{ number_format($kavling->harga, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                            @if($kavling->status == 'Tersedia')
                                <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-md text-[11px] font-bold uppercase">Tersedia</span>
                            @elseif($kavling->status == 'Dipesan')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-md text-[11px] font-bold uppercase">Dipesan</span>
                            @else
                                <span class="px-3 py-1 bg-slate-200 text-slate-600 rounded-md text-[11px] font-bold uppercase">Terjual</span>
                            @endif
                        </td>
                        @if(auth()->user()->role == 'admin')
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center gap-2">
                                <button onclick="openEditModal({{ $kavling->id }})"
                                        class="text-slate-400 hover:text-slate-700 bg-white border border-slate-200 p-2 rounded-lg shadow-sm">
                                    <span class="material-icons-outlined text-lg">edit</span>
                                </button>
                                <form action="{{ route('admin.kavling.destroy', $kavling->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin hapus kavling #{{ $kavling->nomor_kavling }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="text-slate-400 hover:text-red-600 bg-white border border-slate-200 hover:border-red-200 p-2 rounded-lg shadow-sm">
                                        <span class="material-icons-outlined text-lg">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @if(auth()->user()->role == 'admin')
                    @include('admin.kavling.edit')
                    @endif
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role=='admin'?'6':'5' }}" class="px-6 py-14 text-center text-slate-400">
                            <span class="material-icons-outlined text-4xl text-slate-200 block mb-2">crop_square</span>
                            <p class="font-medium">Belum ada data kavling.</p>
                            <p class="text-xs mt-1">
                                Tambah manual atau jalankan:
                                <code class="bg-slate-100 px-1.5 py-0.5 rounded text-slate-600">php artisan db:seed --class=ClusterKavlingSeeder</code>
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination jika ada --}}
        @if(method_exists($kavlings,'hasPages') && $kavlings->hasPages())
        <div class="px-6 py-4 border-t border-slate-50">{{ $kavlings->links() }}</div>
        @endif
    </div>

</div>{{-- end x-data --}}

@if(auth()->user()->role == 'admin')
@include('admin.kavling.create')
@endif

<script>
    function openModal()        { document.getElementById('createModal').classList.remove('hidden'); }
    function closeModal()       { document.getElementById('createModal').classList.add('hidden'); }
    function openEditModal(id)  { document.getElementById('editModal'+id).classList.remove('hidden'); }
    function closeEditModal(id) { document.getElementById('editModal'+id).classList.add('hidden'); }

    // Search/filter kavling table
    function initKavlingSearch() {
        const input = document.getElementById('kavling-search');
        const rows = document.querySelectorAll('tbody tr');

        if (!input) return;

        input.addEventListener('input', () => {
            const query = input.value.trim().toLowerCase();

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                const matches = query === '' || text.includes(query);
                row.classList.toggle('hidden', !matches);
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initKavlingSearch);
    } else {
        initKavlingSearch();
    }
</script>
@endsection