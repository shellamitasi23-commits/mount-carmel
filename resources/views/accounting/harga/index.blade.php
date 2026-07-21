@extends('layouts.admin')
@section('title', 'Kelola Harga Lahan - Mount Carmel')

@section('content')

@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
    <span class="material-icons-outlined">check_circle</span>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

@if($errors->any())
<div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
    <div class="flex items-center gap-3 mb-1.5">
        <span class="material-icons-outlined">error</span>
        <span class="font-bold text-sm">Terjadi Kesalahan:</span>
    </div>
    <ul class="list-disc list-inside text-xs font-semibold pl-6 space-y-1">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Kelola Harga Lahan</h1>
        <p class="text-sm text-slate-500 mt-1">Atur harga per meter atau total untuk setiap unit lahan.</p>
    </div>
    <button onclick="openModal('createModal')"
            class="bg-[#800000] hover:bg-[#800000]/80 text-white px-5 py-2.5 rounded-xl font-bold flex items-center gap-2 shadow-md text-xs uppercase tracking-widest transition-all active:scale-95">
        <span class="material-icons-outlined text-sm">add</span> Tambah Lahan
    </button>
</div>

<div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 mb-6">
    <form action="{{ route('accounting.harga.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div class="md:col-span-2">
            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1.5">Cari Nomor Lahan</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 material-icons-outlined text-slate-400 text-sm">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Contoh: A-01" 
                       class="w-full pl-11 pr-4 py-2 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all placeholder:text-slate-300">
            </div>
        </div>

        <div>
            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1.5">Cluster Filter</label>
            <div class="relative">
                <select name="cluster_id" onchange="this.form.submit()" class="w-full px-4 py-2 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all appearance-none cursor-pointer">
                    <option value="">SEMUA CLUSTER</option>
                    @foreach($clusters as $cluster)
                        <option value="{{ $cluster->id }}" {{ request('cluster_id') == $cluster->id ? 'selected' : '' }}>
                            {{ strtoupper($cluster->nama_cluster) }}
                        </option>
                    @endforeach
                </select>
                <span class="material-icons-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 text-sm">expand_more</span>
            </div>
        </div>

        <div class="flex">
            @if(request('search') || request('cluster_id'))
            <a href="{{ route('accounting.harga.index') }}" class="w-full px-5 py-2 bg-slate-100 text-slate-500 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-200 transition-all text-center flex items-center justify-center">
                Reset
            </a>
            @endif
        </div>
    </form>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="text-slate-500 font-semibold bg-slate-50/80 border-b border-slate-100 uppercase tracking-wider text-[11px]">
                    <th class="px-4 py-2.5 text-center">ID</th>
                    <th class="px-4 py-2.5">Nomor Lahan</th>
                    <th class="px-4 py-2.5">Cluster</th>
                    <th class="px-4 py-2.5">Tipe & Hadap</th>
                    <th class="px-4 py-2.5">Harga Lahan</th>
                    <th class="px-4 py-2.5 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 text-slate-700">
                @forelse($lahans as $lahan)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-4 py-2.5 text-center text-slate-400 font-mono text-xs">#{{ $lahan->id }}</td>
                    <td class="px-4 py-2.5">
                        <p class="font-bold text-slate-900">Lahan {{ $lahan->nomor_lahan }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5 uppercase tracking-tighter italic font-bold">Status: {{ $lahan->status }}</p>
                    </td>
                    <td class="px-4 py-2.5">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">
                            {{ $lahan->cluster?->nama_cluster ?? '-' }}
                        </span>
                    </td>
                    <td class="px-4 py-2.5">
                        <p class="font-bold text-slate-700">{{ $lahan->tipe_lahan }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5 font-bold">Hadap: {{ $lahan->hadap ?? '—' }}</p>
                    </td>
                    <td class="px-4 py-2.5">
                        <p class="font-bold text-slate-900">Rp {{ number_format($lahan->harga, 0, ',', '.') }}</p>
                        <p class="text-[10px] text-slate-400 mt-0.5">Terakhir diupdate: {{ $lahan->updated_at->format('d/m/Y') }}</p>
                    </td>
                    <td class="px-4 py-2.5 text-center">
                        <div class="flex justify-center gap-2 items-center">
                            <button onclick="openModal('modal-edit-{{ $lahan->id }}')" class="bg-white border border-slate-200 text-slate-600 hover:text-slate-900 hover:border-slate-400 p-2 rounded-lg transition-all shadow-sm" title="Edit Lahan">
                                <span class="material-icons-outlined text-lg block">edit</span>
                            </button>
                            <form id="form-delete-{{ $lahan->id }}" action="{{ route('accounting.harga.destroy', $lahan->id) }}" method="POST" class="inline">
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
                                    <span class="material-icons-outlined text-lg block">delete</span>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-4 py-8 text-center text-slate-400 font-medium">Belum ada data lahan yang tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($lahans->hasPages())
    <div class="px-4 py-3 border-t border-slate-50">
        {{ $lahans->links() }}
    </div>
    @endif
</div>

@foreach($lahans as $lahan)
<div id="modal-edit-{{ $lahan->id }}" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center transition-opacity text-left">
    <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-y-auto max-h-[90vh] m-4 border border-slate-100">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50 sticky top-0">
            <h3 class="text-lg font-bold text-slate-800">Edit Data Lahan & Harga</h3>
            <button type="button" onclick="closeModal('modal-edit-{{ $lahan->id }}')" class="text-slate-400 hover:text-red-500 transition-colors">
                <span class="material-icons-outlined">close</span>
            </button>
        </div>
        <form action="{{ route('accounting.harga.update', $lahan->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pilih Cluster <span class="text-red-500">*</span></label>
                    <select name="cluster_id" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm outline-none text-slate-700 font-bold transition-all">
                        @foreach($clusters as $cl)
                            <option value="{{ $cl->id }}" {{ $lahan->cluster_id == $cl->id ? 'selected' : '' }}>
                                {{ $cl->nama_cluster }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nomor Lahan <span class="text-red-500">*</span></label>
                    <input type="text" name="nomor_lahan" value="{{ $lahan->nomor_lahan }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm outline-none text-slate-700 font-bold">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tipe Lahan <span class="text-red-500">*</span></label>
                        <input type="text" name="tipe_lahan" value="{{ $lahan->tipe_lahan }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm outline-none text-slate-700 font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Hadap Lahan</label>
                        <input type="text" name="hadap" value="{{ $lahan->hadap }}" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm outline-none text-slate-700 font-bold">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ukuran <span class="text-red-500">*</span></label>
                        <input type="text" name="ukuran" value="{{ $lahan->ukuran }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm outline-none text-slate-700 font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kapasitas (Orang) <span class="text-red-500">*</span></label>
                        <input type="number" name="kapasitas" value="{{ $lahan->kapasitas }}" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm outline-none text-slate-700 font-bold">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Harga Lahan (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" name="harga" value="{{ $lahan->harga }}" required placeholder="Contoh: 15000000" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all font-bold">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Status Lahan <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm outline-none text-slate-700 font-bold transition-all">
                        <option value="Tersedia" {{ $lahan->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="Reservasi (Lunas)" {{ $lahan->status == 'Reservasi (Lunas)' ? 'selected' : '' }}>Reservasi (Lunas)</option>
                        <option value="Reservasi Cicilan dengan DP" {{ $lahan->status == 'Reservasi Cicilan dengan DP' ? 'selected' : '' }}>Reservasi Cicilan dengan DP</option>
                        <option value="Terjual" {{ $lahan->status == 'Terjual' ? 'selected' : '' }}>Terjual</option>
                        <option value="Digunakan" {{ $lahan->status == 'Digunakan' ? 'selected' : '' }}>Digunakan</option>
                    </select>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end gap-3 sticky bottom-0">
                <button type="button" onclick="closeModal('modal-edit-{{ $lahan->id }}')" class="px-4 py-2 text-xs font-bold uppercase tracking-widest text-slate-500 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">Batal</button>
                <button type="submit" class="px-4 py-2 text-xs font-bold uppercase tracking-widest text-white bg-slate-900 hover:bg-slate-800 rounded-xl shadow-lg transition-all font-black">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

@include('accounting.harga.create')

<script>
    function openModal(id) {
        document.getElementById(id).classList.remove('hidden');
    }
    function closeModal(id) {
        document.getElementById(id).classList.add('hidden');
    }
</script>
@endsection
