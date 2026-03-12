@extends('layouts.admin')

@section('title', 'Data Pembayaran')

@section('content')
<div class="mb-6">
    <h1 class="text-xl font-bold text-slate-800">Manajemen Pembayaran</h1>
    <p class="text-xs text-slate-500">Daftar reservasi yang telah disetujui dan memerlukan verifikasi pembayaran.</p>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <table class="w-full text-left text-xs">
        <thead class="bg-slate-50 text-slate-400 font-bold uppercase tracking-widest text-[10px]">
            <tr>
                <th class="px-6 py-4">Pembeli</th>
                <th class="px-6 py-4">Kavling</th>
                <th class="px-6 py-4">Total Harga</th>
                <th class="px-6 py-4">Status Bayar</th>
                <th class="px-6 py-4 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            @forelse($pembayarans as $p)
            <tr class="hover:bg-slate-50/50 transition-colors">
                <td class="px-6 py-4">
                    <div class="font-bold text-slate-700">{{ $p->user->name }}</div>
                    <div class="text-[10px] text-slate-400 italic">{{ $p->user->email }}</div>
                </td>
                <td class="px-6 py-4">
                    <div class="font-medium text-slate-600">{{ $p->kavling->nomor_kavling }}</div>
                    <div class="text-[10px] text-slate-400">{{ $p->kavling->cluster->nama_cluster }}</div>
                </td>
                <td class="px-6 py-4 font-bold text-slate-900">
                    Rp {{ number_format($p->kavling->harga, 0, ',', '.') }}
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded-md text-[9px] font-black uppercase {{ $p->status_pembayaran == 'Lunas' ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                        {{ $p->status_pembayaran ?? 'Belum Lunas' }}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    @if(auth()->user()->role == 'admin')
                    <form action="{{ route('admin.pembayaran.update', $p->id) }}" method="POST">
                        @csrf @method('PUT')
                        <input type="hidden" name="status_pembayaran" value="Lunas">
                        <button type="submit" class="bg-slate-900 text-white px-3 py-1.5 rounded-lg text-[10px] font-bold hover:bg-black transition-all">
                            Konfirmasi Lunas
                        </button>
                    </form>
                    @else
                    <span class="text-slate-300 italic text-[10px]">View Only</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-10 text-center text-slate-400 italic">Belum ada data pembayaran yang perlu diproses.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection