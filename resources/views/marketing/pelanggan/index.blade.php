@extends('layouts.admin')
@section('title', 'Data Pelanggan - Mount Carmel')

@section('content')

@if(session('success'))
<div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl flex items-center gap-3">
    <span class="material-icons-outlined">check_circle</span>
    <span class="font-medium text-sm">{{ session('success') }}</span>
</div>
@endif

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Data Pembeli</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola data pembeli lahan di Mount Carmel.</p>
    </div>
    @if(auth()->user()->role == 'marketing')
    <button onclick="openModal()" class="bg-slate-900 hover:bg-slate-800 text-white px-5 py-3 rounded-xl font-semibold text-sm transition-all shadow-md flex items-center gap-2">
        <span class="material-icons-outlined text-lg">add</span>
        Tambah Pembeli Baru
    </button>
    @endif
</div>

{{-- Search --}}
<div class="relative mb-10 group">
    <div class="absolute inset-y-0 left-0 pl-5 flex items-center pointer-events-none">
        <span class="material-icons-outlined text-slate-400 group-focus-within:text-slate-900 transition-colors">search</span>
    </div>
    <input type="text" id="pembeli-search" 
           placeholder="Cari nama pembeli, email, atau no. telepon..." 
           class="w-full pl-14 pr-6 py-4 bg-white border border-slate-100 rounded-[1.5rem] text-sm font-medium shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all placeholder:text-slate-300">
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm whitespace-nowrap">
            <thead>
                <tr class="text-slate-500 font-semibold bg-slate-50/80 border-b border-slate-100 uppercase tracking-wider text-[11px]">
                    <th class="px-6 py-4 text-center">ID</th>
                    <th class="px-6 py-4">Informasi Pembeli</th>
                    <th class="px-6 py-4">Kontak</th>
                    <th class="px-6 py-4">Alamat</th>
                    <th class="px-6 py-4">Tgl Terdaftar</th>
                    @if(auth()->user()->role == 'marketing')
                    <th class="px-6 py-4 text-center">Aksi</th>
                    @endif
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 text-slate-700">
                @forelse($pembelis as $pembeli)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-6 py-4 text-center text-slate-400 font-mono text-xs">#{{ $pembeli->id }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold text-sm">
                                {{ strtoupper(substr($pembeli->name, 0, 1)) }}
                            </div>
                            <p class="font-bold text-slate-900">{{ $pembeli->name }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-slate-800">{{ $pembeli->email }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $pembeli->no_telepon ?? '-' }}</p>
                    </td>
                    <td class="px-6 py-4 text-slate-500 truncate max-w-xs">{{ $pembeli->alamat ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $pembeli->created_at->format('d/m/Y') }}</td>
                    @if(auth()->user()->role == 'marketing')
                    <td class="px-6 py-4 text-center">
                        <form action="{{ route('marketing.pembeli.destroy', $pembeli->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pembeli ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-slate-400 hover:text-red-600 p-2 rounded-lg transition-all" title="Hapus">
                                <span class="material-icons-outlined text-lg block">delete</span>
                            </button>
                        </form>
                    </td>
                    @endif
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-10 text-center text-slate-500 font-medium">Belum ada data pembeli.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pembelis->hasPages())
    <div class="px-6 py-4 border-t border-slate-50">
        {{ $pembelis->links() }}
    </div>
    @endif
</div>

@if(auth()->user()->role == 'marketing')
    @include('marketing.pelanggan.create')
@endif

<script>
    function openModal() { document.getElementById('createModal').classList.remove('hidden'); }
    function closeModal() { document.getElementById('createModal').classList.add('hidden'); }

    // Live Search for Pembeli
    document.getElementById('pembeli-search')?.addEventListener('input', function(e) {
        const query = e.target.value.toLowerCase().trim();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            const matches = text.includes(query);
            row.style.display = matches ? '' : 'none';
        });
    });
</script>
@endsection
