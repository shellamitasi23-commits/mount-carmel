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

</div>

{{-- Filtering System --}}
<div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 mb-6">
    <form method="GET" action="{{ route(auth()->user()->role . '.pembeli.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
        <div class="md:col-span-2">
            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1.5">Cari Pembeli</label>
            <div class="relative">
                <span class="absolute left-4 top-1/2 -translate-y-1/2 material-icons-outlined text-slate-400 text-sm">search</span>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama pembeli, email, atau no. telepon..."
                       class="w-full pl-11 pr-4 py-2 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all placeholder:text-slate-300">
            </div>
        </div>
        <div>
            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-1.5">Urutan Terdaftar</label>
            <div class="relative">
                <select name="sort" onchange="this.form.submit()" class="w-full px-4 py-2 bg-white border border-slate-100 rounded-xl text-sm font-medium shadow-sm focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none transition-all appearance-none cursor-pointer">
                    <option value="desc" {{ request('sort', 'desc') === 'desc' ? 'selected' : '' }}>Terbaru (Desc)</option>
                    <option value="asc" {{ request('sort') === 'asc' ? 'selected' : '' }}>Terlama (Asc)</option>
                </select>
                <span class="material-icons-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 text-sm">swap_vert</span>
            </div>
        </div>
        <div class="flex">
            @if(request('search') || request('sort'))
            <a href="{{ route(auth()->user()->role . '.pembeli.index') }}" class="w-full px-5 py-2 bg-slate-100 text-slate-500 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-200 transition-all text-center flex items-center justify-center">
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
                    <th class="px-4 py-2.5">Informasi Pembeli</th>
                    <th class="px-4 py-2.5">Kontak</th>
                    <th class="px-4 py-2.5">Alamat</th>
                    <th class="px-4 py-2.5">Tgl Terdaftar</th>

                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50 text-slate-700">
                @forelse($pembelis as $pembeli)
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-4 py-2.5 text-center text-slate-400 font-mono text-xs">#{{ $pembeli->id }}</td>
                    <td class="px-4 py-2.5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold text-sm">
                                {{ strtoupper(substr($pembeli->name, 0, 1)) }}
                            </div>
                            <p class="font-bold text-slate-900">{{ $pembeli->name }}</p>
                        </div>
                    </td>
                    <td class="px-4 py-2.5">
                        <p class="font-medium text-slate-800">{{ $pembeli->email }}</p>
                        <p class="text-xs text-slate-400 mt-0.5">{{ $pembeli->no_telepon ?? '-' }}</p>
                    </td>
                    <td class="px-4 py-2.5 text-slate-500 truncate max-w-xs">{{ $pembeli->alamat ?? '-' }}</td>
                    <td class="px-4 py-2.5">{{ $pembeli->created_at->format('d/m/Y') }}</td>

                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-slate-500 font-medium">Belum ada data pembeli.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($pembelis->hasPages())
    <div class="px-4 py-3 border-t border-slate-50">
        {{ $pembelis->appends(request()->query())->links() }}
    </div>
    @endif
</div>


@endsection
