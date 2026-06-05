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
        <h1 class="text-2xl font-bold text-slate-800">Data Lahan</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola lahan per cluster. Madinah (Muslim) & Mount Carmel (Non-Muslim).</p>
    </div>
    @if(auth()->user()->role == 'marketing')
    <button onclick="openModal()"
            class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-2.5 rounded-xl font-semibold flex items-center gap-2 shadow-md text-sm hover:-translate-y-0.5 transition-all">
        <span class="material-icons-outlined text-sm">add</span> Tambah Lahan
    </button>
    @endif
</div>

{{-- Search --}}
<form action="{{ route('marketing.lahan.index') }}" method="GET" class="relative mb-6 group">
    @if(request('cluster_id'))
    <input type="hidden" name="cluster_id" value="{{ request('cluster_id') }}">
    @endif
    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
        <span class="material-icons-outlined text-slate-400 group-focus-within:text-slate-900 transition-colors">search</span>
    </div>
    <input type="text" name="search" id="lahan-search" 
           value="{{ request('search') }}"
           placeholder="Cari nomor lahan, tipe, cluster, atau status..." 
           class="w-full pl-11 pr-10 py-2 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all placeholder:text-slate-300">
    
    @if(request('search'))
    <a href="{{ route('marketing.lahan.index') }}" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
        <span class="material-icons-outlined text-xl">close</span>
    </a>
    @endif
</form>

{{-- Tab per Cluster --}}
<div x-data="{ activeCluster: '{{ request('cluster_id', 'semua') }}' }">

    {{-- Tab Nav --}}
    <div class="flex items-center gap-1.5 mb-6 p-1.5 bg-white border border-slate-100 rounded-xl w-full shadow-sm">
        <a href="{{ route('marketing.lahan.index', array_merge(request()->query(), ['cluster_id' => 'semua', 'page' => 1])) }}"
           class="flex-1 text-center px-4 py-2 rounded-lg text-xs font-bold transition-all {{ request('cluster_id', 'semua') === 'semua' ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
            Semua ({{ \App\Models\Lahan::count() }})
        </a>
        @foreach($clusters as $cl)
        <a href="{{ route('marketing.lahan.index', array_merge(request()->query(), ['cluster_id' => $cl->id, 'page' => 1])) }}"
           class="flex-1 text-center px-4 py-2 rounded-lg text-xs font-bold transition-all {{ request('cluster_id') == $cl->id ? 'bg-slate-900 text-white shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
            {{ $cl->nama_cluster }}
            <span class="text-[10px] opacity-70">({{ $cl->lahans()->count() }})</span>
        </a>
        @endforeach
    </div>
    {{-- Tabel --}}
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="text-slate-500 font-semibold bg-slate-50/80 border-b border-slate-100 uppercase tracking-wider text-[11px]">
                        <th class="px-4 py-2.5">Nomor</th>
                        <th class="px-4 py-2.5">Lahan & Cluster</th>
                        <th class="px-4 py-2.5">Hadap</th>
                        <th class="px-4 py-2.5">Ukuran & Kapasitas</th>
                        <th class="px-4 py-2.5">Harga</th>
                        <th class="px-4 py-2.5">Status</th>
                        @if(auth()->user()->role == 'marketing')
                        <th class="px-4 py-2.5 text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-slate-700">
                    @forelse($lahans as $lahan)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-4 py-2.5 font-bold text-slate-900">#{{ $lahan->nomor_lahan }}</td>
                        <td class="px-4 py-2.5">
                            <p class="font-bold text-slate-900">{{ $lahan->tipe_lahan }}</p>
                            <p class="text-xs mt-0.5 flex items-center gap-1
                                {{ $lahan->cluster->kategori === 'Muslim' ? 'text-teal-600' : 'text-blue-600' }}">
                                {{ $lahan->cluster->nama_cluster ?? '—' }}
                            </p>
                        </td>
                        <td class="px-4 py-2.5">
                            <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded text-[10px] font-bold uppercase">{{ $lahan->hadap ?? '—' }}</span>
                        </td>
                        <td class="px-4 py-2.5">
                            <p class="font-medium text-slate-800">{{ $lahan->ukuran }}</p>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $lahan->kapasitas }} Orang</p>
                        </td>
                        <td class="px-4 py-2.5 font-bold text-slate-900">
                            Rp {{ number_format($lahan->harga, 0, ',', '.') }}
                        </td>
                        <td class="px-4 py-2.5">
                            @if($lahan->status == 'Tersedia')
                                <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-md text-[11px] font-bold uppercase">Tersedia</span>
                            @elseif($lahan->status == 'Dipesan')
                                <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-md text-[11px] font-bold uppercase">Dipesan</span>
                            @else
                                <span class="px-3 py-1 bg-slate-200 text-slate-600 rounded-md text-[11px] font-bold uppercase">Terjual</span>
                            @endif
                        </td>
                        @if(auth()->user()->role == 'marketing')
                        <td class="px-4 py-2.5 text-center">
                            <div class="flex justify-center gap-2">
                                <button onclick="openEditModal({{ $lahan->id }})"
                                         class="text-slate-400 hover:text-slate-700 bg-white border border-slate-200 p-2 rounded-lg shadow-sm">
                                    <span class="material-icons-outlined text-lg">edit</span>
                                </button>
                                <form id="form-delete-{{ $lahan->id }}" action="{{ route('marketing.lahan.destroy', $lahan->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="button"
                                            @click="$dispatch('confirm-modal', { 
                                                title: 'Hapus Lahan', 
                                                message: 'Apakah Anda yakin ingin menghapus <b>Lahan #{{ $lahan->nomor_lahan }}</b>? <br><br> Data yang sudah dihapus tidak dapat dikembalikan.', 
                                                confirmText: 'Ya, Hapus Lahan',
                                                type: 'danger',
                                                action: () => document.getElementById('form-delete-{{ $lahan->id }}').submit() 
                                            })"
                                            class="text-slate-400 hover:text-red-600 bg-white border border-slate-200 hover:border-red-200 p-2 rounded-lg shadow-sm transition-all">
                                        <span class="material-icons-outlined text-lg">delete</span>
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @if(auth()->user()->role == 'marketing')
                    @include('marketing.lahan.edit')
                    @endif
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role=='admin'?'6':'5' }}" class="px-4 py-8 text-center text-slate-400">
                            <span class="material-icons-outlined text-4xl text-slate-200 block mb-2">crop_square</span>
                            <p class="font-medium">Belum ada Data Lahan.</p>
                            <p class="text-xs mt-1">
                                Tambah manual atau jalankan:
                                <code class="bg-slate-100 px-1.5 py-0.5 rounded text-slate-600">php artisan db:seed --class=ClusterLahanSeeder</code>
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($lahans,'hasPages') && $lahans->hasPages())
        <div class="px-4 py-3 border-t border-slate-50">{{ $lahans->appends(request()->query())->links() }}</div>
        @endif
    </div></div>

</div>{{-- end x-data --}}

@if(auth()->user()->role == 'marketing')
@include('marketing.lahan.create')
@endif

<script>
    function openModal()        { document.getElementById('createModal').classList.remove('hidden'); }
    function closeModal()       { document.getElementById('createModal').classList.add('hidden'); }
    function openEditModal(id)  { document.getElementById('editModal'+id).classList.remove('hidden'); }
    function closeEditModal(id) { document.getElementById('editModal'+id).classList.add('hidden'); }


    // --- LOGIC CENTRAL UNTUK EDIT MODALS ---
    const masterLahan = @json($master_lahan);
    
    document.querySelectorAll('[id^="edit_tipe_lahan_"]').forEach(select => {
        const id = select.id.replace('edit_tipe_lahan_', '');
        
        select.addEventListener('change', function() {
            const selected = this.value;
            const hadapSelect = document.getElementById('edit_hadap_' + id);
            const ukuranInput = document.getElementById('edit_ukuran_' + id);
            const kapasitasInput = document.getElementById('edit_kapasitas_' + id);
            const hargaInput = document.getElementById('edit_harga_' + id);
            const nomorInput = document.getElementById('edit_nomor_lahan_' + id);
            
            if (selected && masterLahan[selected]) {
                const data = masterLahan[selected];
                ukuranInput.value = data.ukuran;
                kapasitasInput.value = data.kapasitas;
                hargaInput.value = data.harga;
                
                // Reset & Isi Hadap
                hadapSelect.innerHTML = '';
                data.hadap_options.forEach(opt => {
                    const o = document.createElement('option');
                    o.value = opt;
                    o.textContent = opt;
                    hadapSelect.appendChild(o);
                });

                // Auto-suggest nomor prefix
                if (data.hadap_options.length === 1) {
                    const prefix = data.hadap_options[0].charAt(0).toUpperCase();
                    if (!nomorInput.value.startsWith(prefix + '-')) {
                        nomorInput.value = prefix + '-';
                    }
                }
            }
        });
    });
</script>
@endsection
