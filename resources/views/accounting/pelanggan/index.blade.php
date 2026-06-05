@extends('layouts.admin')
@section('title', 'Data Pembeli')

@section('content')
<div class="flex justify-between items-start mb-6">
    <div>
        <h1 class="text-xl font-bold text-slate-800">Data Akun Pembeli</h1>
        <p class="text-xs text-slate-500 mt-1">Daftar lengkap pembeli yang terdaftar di Mount Carmel.</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead class="bg-slate-50 text-slate-400 font-bold uppercase tracking-widest text-[10px] border-b border-slate-100">
                <tr>
                    <th class="px-4 py-2.5">Pembeli</th>
                    <th class="px-4 py-2.5">Email</th>
                    <th class="px-4 py-2.5">No. Telepon</th>
                    <th class="px-4 py-2.5">Alamat</th>
                    <th class="px-4 py-2.5">Bergabung Pada</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($pembelis as $pembeli)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-4 py-2.5 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-700">
                            {{ strtoupper(substr($pembeli->name, 0, 1)) }}
                        </div>
                        <p class="font-bold text-slate-800">{{ $pembeli->name }}</p>
                    </td>
                    <td class="px-4 py-2.5 text-slate-600 font-medium">{{ $pembeli->email }}</td>
                    <td class="px-4 py-2.5 font-mono font-semibold text-slate-600">{{ $pembeli->no_telepon ?? 'Belum Diisi' }}</td>
                    <td class="px-4 py-2.5 text-slate-500 max-w-xs truncate">{{ $pembeli->alamat ?? 'Belum Diisi' }}</td>
                    <td class="px-4 py-2.5 text-slate-400 font-medium">{{ $pembeli->created_at->format('d M Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-slate-400 italic">
                        <span class="material-icons-outlined text-4xl text-slate-200 block mb-2">people_outline</span>
                        Belum ada data pembeli terdaftar.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
