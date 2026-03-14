@extends('layouts.master')

@section('content')
<div x-data="{ tab: 'data', modalEdit: false, modalPass: false, showP: false }" class="min-h-screen bg-gray-50 pt-32 pb-16 px-6">
    <div class="max-w-5xl mx-auto">
        
        {{-- ── 1. HEADER PROFIL ── --}}
        <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm flex flex-col md:flex-row items-center gap-8 mb-8">
            <div class="w-24 h-24 bg-primary/10 rounded-3xl flex items-center justify-center font-black text-3xl text-primary shadow-inner">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div class="flex-1 text-center md:text-left">
                <h1 class="text-3xl font-black text-slate-900 leading-tight">{{ $user->name }}</h1>
                <p class="text-slate-400 font-medium mb-6">{{ $user->email }}</p>
                <div class="flex flex-wrap gap-3 justify-center md:justify-start">
                    <button @click="modalEdit = true" class="bg-primary text-white px-6 py-3 rounded-2xl font-bold text-xs shadow-lg shadow-primary/20 hover:scale-[1.02] transition-all">EDIT PROFIL</button>
                    <button @click="modalPass = true" class="bg-slate-100 text-slate-600 px-6 py-3 rounded-2xl font-bold text-xs hover:bg-slate-200 transition-all">GANTI PASSWORD</button>
                </div>
            </div>
        </div>

        {{-- ── 2. NAVIGASI TAB ── --}}
        <div class="flex gap-2 p-1 bg-slate-200/50 rounded-2xl mb-8 w-max">
            <button @click="tab = 'data'" :class="tab === 'data' ? 'bg-white shadow-sm text-primary' : 'text-slate-500'" class="px-8 py-3 rounded-xl font-black text-xs transition-all uppercase tracking-widest">Data Diri</button>
            <button @click="tab = 'riwayat'" :class="tab === 'riwayat' ? 'bg-white shadow-sm text-primary' : 'text-slate-500'" class="px-8 py-3 rounded-xl font-black text-xs transition-all uppercase tracking-widest">Riwayat</button>
            <button @click="tab = 'sertifikat'" :class="tab === 'sertifikat' ? 'bg-white shadow-sm text-emerald-600' : 'text-slate-500'" class="px-8 py-3 rounded-xl font-black text-xs transition-all uppercase tracking-widest">Sertifikat</button>
        </div>

        {{-- ── 3. KONTEN TAB: DATA DIRI (Terintegrasi Register) ── --}}
        <div x-show="tab === 'data'" x-transition class="bg-white rounded-[2rem] p-8 border border-slate-100 shadow-sm">
            <h3 class="text-sm font-black text-slate-400 uppercase tracking-widest mb-8">Informasi Akun</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Nama Lengkap</label>
                    <p class="text-sm font-bold text-slate-700 bg-slate-50 px-5 py-4 rounded-2xl border border-slate-100 italic">{{ $user->name }}</p>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Alamat Email</label>
                    <p class="text-sm font-bold text-slate-700 bg-slate-50 px-5 py-4 rounded-2xl border border-slate-100 italic">{{ $user->email }}</p>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">No. Telepon</label>
                    <p class="text-sm font-bold text-slate-700 bg-slate-50 px-5 py-4 rounded-2xl border border-slate-100 italic">{{ $user->no_telepon ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Alamat Domisili</label>
                    <p class="text-sm font-bold text-slate-700 bg-slate-50 px-5 py-4 rounded-2xl border border-slate-100 italic">{{ $user->alamat ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        {{-- ── 4. KONTEN TAB: RIWAYAT ── --}}
        <div x-show="tab === 'riwayat'" style="display:none" x-transition class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-[10px] font-black uppercase text-slate-400 tracking-widest">
                    <tr><th class="px-8 py-5">Kavling</th><th class="px-8 py-5">Jenazah</th><th class="px-8 py-5">Status Bayar</th></tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($riwayat as $r)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-8 py-5 font-bold text-slate-800">{{ $r->kavling->nomor_kavling }}</td>
                        <td class="px-8 py-5 text-slate-500 font-medium">{{ $r->nama_jenazah }}</td>
                        <td class="px-8 py-5"><span class="bg-emerald-50 text-emerald-600 px-3 py-1 rounded-lg font-black text-[9px] uppercase">{{ $r->status_pembayaran }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- ── 5. KONTEN TAB: SERTIFIKAT ── --}}
        <div x-show="tab === 'sertifikat'" style="display:none" x-transition class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($sertifikats as $s)
            <div class="bg-white p-8 rounded-[2.5rem] border border-amber-100 shadow-sm relative overflow-hidden">
                <h3 class="text-xl font-black text-slate-800">Kavling {{ $s->kavling->nomor_kavling }}</h3>
                <p class="text-[10px] font-bold text-amber-600 mb-6 uppercase tracking-widest">Sertifikat Hak Guna Lahan</p>
                <a href="{{ asset('storage/sertifikat/'.$s->file_sertifikat) }}" class="inline-block bg-slate-900 text-white px-8 py-3 rounded-xl font-bold text-[10px] tracking-widest uppercase hover:bg-black transition-all">UNDUH PDF</a>
            </div>
            @empty
            <div class="col-span-2 py-20 text-center text-slate-300 font-bold border-2 border-dashed border-slate-200 rounded-[2.5rem]">Belum ada sertifikat terbit.</div>
            @endforelse
        </div>
    </div>

    {{-- PEMANGGILAN FILE MODAL TERPISAH --}}
    @include('pembeli.profil.edit')
    @include('pembeli.profil.password')
</div>

<style>
    @keyframes scaleIn { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
    .animate-scaleIn { animation: scaleIn 0.2s ease-out; }
</style>
@endsection