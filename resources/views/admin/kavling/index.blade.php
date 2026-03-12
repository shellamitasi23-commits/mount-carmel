@extends('layouts.admin')
@section('title', 'Data Kavling - Mount Carmel')

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
        <p class="text-sm text-slate-500 mt-1">Kelola data, harga, dan ketersediaan kavling per cluster.</p>
    </div>
    @if(auth()->user()->role == 'admin')
    <div class="flex gap-3 w-full md:w-auto">
        <button onclick="openModal()" class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-2.5 rounded-xl font-semibold flex items-center gap-2 transition-all shadow-md text-sm hover:shadow-lg hover:-translate-y-0.5">
            <span class="material-icons-outlined text-sm">add</span> Tambah Kavling
        </button>
    </div>
    @endif
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="text-slate-500 font-semibold bg-slate-50/80 border-b border-slate-100 uppercase tracking-wider text-[11px]">
                    <th class="px-6 py-4">ID / Nomor</th>
                    <th class="px-6 py-4">Tipe & Cluster</th>
                    <th class="px-6 py-4">Spesifikasi</th>
                    <th class="px-6 py-4">Harga</th>
                    <th class="px-6 py-4">Status</th>
                    @if(auth()->user()->role == 'admin')
                    <th class="px-6 py-4 text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 text-slate-700">
                
                @forelse($kavlings as $kavling)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-6 py-4 font-bold text-slate-900">#{{ $kavling->nomor_kavling }}</td>
                    <td class="px-6 py-4">
                        <p class="font-bold text-slate-900">{{ $kavling->tipe_kavling }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $kavling->cluster->nama_cluster ?? 'Tanpa Cluster' }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-slate-800">{{ $kavling->ukuran }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">Kapasitas: {{ $kavling->kapasitas }} Orang</p>
                    </td>
                    <td class="px-6 py-4 font-bold text-slate-900">Rp {{ number_format($kavling->harga, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        @if($kavling->status == 'Tersedia')
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-md text-[11px] font-bold uppercase tracking-wide">Tersedia</span>
                        @elseif($kavling->status == 'Dipesan')
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-md text-[11px] font-bold uppercase tracking-wide">Dipesan</span>
                        @else
                            <span class="px-3 py-1 bg-slate-200 text-slate-600 rounded-md text-[11px] font-bold uppercase tracking-wide">Terjual</span>
                        @endif
                    </td>
                    @if(auth()->user()->role == 'admin')
                    <td class="px-6 py-4 text-center flex justify-center gap-2">
                        <button type="button" onclick="openEditModal({{ $kavling->id }})" class="text-slate-400 hover:text-blue-600 bg-white border border-slate-200 hover:border-blue-200 p-2 rounded-lg transition-all shadow-sm">
                            <span class="material-icons-outlined text-lg block">edit</span>
                        </button>
                        <form action="{{ route('admin.kavling.destroy', $kavling->id) }}" method="POST" onsubmit="return confirm('Yakin hapus kavling ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-slate-400 hover:text-red-600 bg-white border border-slate-200 hover:border-red-200 p-2 rounded-lg transition-all shadow-sm">
                                <span class="material-icons-outlined text-lg block">delete</span>
                            </button>
                        </form>
                    </td>
                    @endif
                </tr>
                
                @if(auth()->user()->role == 'admin')
                @include('admin.kavling.edit')
                @endif

                @empty
                <tr>
                    <td colspan="{{ auth()->user()->role == 'admin' ? '6' : '5' }}" class="px-6 py-10 text-center text-slate-500">
                        <div class="flex flex-col items-center justify-center">
                            <span class="material-icons-outlined text-4xl text-slate-300 mb-2">crop_square</span>
                            <p class="font-medium">Belum ada data kavling.</p>
                            <p class="text-xs mt-1">Klik tombol "Tambah Kavling" untuk memulai.</p>
                        </div>
                    </td>
                </tr>
                @endforelse

            </tbody>
        </table>
    </div>
</div>

@if(auth()->user()->role == 'admin')
@include('admin.kavling.create')
@endif

<script>
    function openModal() { document.getElementById('createModal').classList.remove('hidden'); }
    function closeModal() { document.getElementById('createModal').classList.add('hidden'); }
    function openEditModal(id) { document.getElementById('editModal' + id).classList.remove('hidden'); }
    function closeEditModal(id) { document.getElementById('editModal' + id).classList.add('hidden'); }
</script>
@endsection