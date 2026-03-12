@extends('layouts.admin')

@section('title', 'Data Cluster - Mount Carmel')

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
        <p class="text-sm text-slate-500 mt-1">Kelola zona dan blok pemakaman (Muslim & Non-Muslim).</p>
    </div>
    @if(auth()->user()->role == 'admin')
    <div class="flex gap-3 w-full md:w-auto">
        <button onclick="openModal()" class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-2.5 rounded-xl font-semibold flex items-center gap-2 transition-all shadow-md text-sm hover:shadow-lg hover:-translate-y-0.5">
            <span class="material-icons-outlined text-sm">add</span>
            Tambah Cluster
        </button>
    </div>
    @endif
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="text-slate-500 font-semibold bg-slate-50/80 border-b border-slate-100 uppercase tracking-wider text-[11px]">
                    <th class="px-6 py-4">Nama Cluster</th>
                    <th class="px-6 py-4">Kategori Zona</th>
                    <th class="px-6 py-4">Deskripsi</th>
                    @if(auth()->user()->role == 'admin')
                    <th class="px-6 py-4 text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 text-slate-700">
                
                @forelse($clusters as $cluster)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg {{ $cluster->kategori == 'Muslim' ? 'bg-teal-50 text-teal-600' : 'bg-blue-50 text-blue-600' }} flex items-center justify-center">
                                <span class="material-icons-outlined">{{ $cluster->kategori == 'Muslim' ? 'mosque' : 'church' }}</span>
                            </div>
                            <div>
                                <p class="font-bold text-slate-900 text-base">{{ $cluster->nama_cluster }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 {{ $cluster->kategori == 'Muslim' ? 'bg-teal-100 text-teal-700' : 'bg-blue-100 text-blue-700' }} rounded-md text-[11px] font-bold uppercase tracking-wide">
                            {{ $cluster->kategori }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-slate-500 whitespace-normal min-w-[200px] text-xs leading-relaxed">
                        {{ $cluster->deskripsi ?? 'Tidak ada deskripsi.' }}
                    </td>
                    @if(auth()->user()->role == 'admin')
                    <td class="px-6 py-4 text-center flex justify-center gap-2">
                        
                        <button type="button" onclick="openEditModal({{ $cluster->id }})" class="text-slate-400 hover:text-blue-600 bg-white border border-slate-200 hover:border-blue-200 p-2 rounded-lg transition-all shadow-sm" title="Edit Data">
                            <span class="material-icons-outlined text-lg block">edit</span>
                        </button>

                        <form action="{{ route('admin.cluster.destroy', $cluster->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus cluster ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-slate-400 hover:text-red-600 bg-white border border-slate-200 hover:border-red-200 p-2 rounded-lg transition-all shadow-sm" title="Hapus Data">
                                <span class="material-icons-outlined text-lg block">delete</span>
                            </button>
                        </form>
                    </td>
                    @endif
                </tr>

                @if(auth()->user()->role == 'admin')
                @include('admin.cluster.edit')
                @endif

                @empty
                <tr>
                    <td colspan="{{ auth()->user()->role == 'admin' ? '4' : '3' }}" class="px-6 py-10 text-center text-slate-500">
                        <div class="flex flex-col items-center justify-center">
                            <span class="material-icons-outlined text-4xl text-slate-300 mb-2">inventory_2</span>
                            <p class="font-medium">Belum ada data cluster.</p>
                            <p class="text-xs mt-1">Klik tombol "Tambah Cluster" untuk memulai.</p>
                        </div>
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>

@if(auth()->user()->role == 'admin')
@include('admin.cluster.create')
@endif

<script>
    // Modal Tambah
    function openModal() {
        document.getElementById('createModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('createModal').classList.add('hidden');
    }

    // Modal Edit
    function openEditModal(id) {
        document.getElementById('editModal' + id).classList.remove('hidden');
    }

    function closeEditModal(id) {
        document.getElementById('editModal' + id).classList.add('hidden');
    }
</script>

@endsection