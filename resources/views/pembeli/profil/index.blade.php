@extends('layouts.master')

@section('content')
<div x-data="{ tab: 'data', modalEdit: false, modalPass: false, showP: false }" class="min-h-screen bg-gray-50 pt-32 pb-16 px-6">
    <div class="max-w-5xl mx-auto">

        {{-- Flash Message --}}
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-xl text-sm font-medium flex items-center gap-2">
            <span class="material-icons text-sm">check_circle</span> {{ session('success') }}
        </div>
        @endif

        {{-- Header Profil --}}
        <div class="bg-white rounded-[2.5rem] p-8 border border-gray-100 shadow-sm flex flex-col md:flex-row items-center gap-8 mb-8">
            <div class="w-24 h-24 bg-primary/10 rounded-3xl flex items-center justify-center font-black text-3xl text-primary shadow-inner">
                {{ strtoupper(substr($user->name, 0, 1)) }}
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

        {{-- Tab Navigasi --}}
        <div class="flex gap-2 p-1 bg-slate-200/50 rounded-2xl mb-8 w-max">
            <button @click="tab = 'data'" :class="tab === 'data' ? 'bg-white shadow-sm text-primary' : 'text-slate-500'" class="px-8 py-3 rounded-xl font-black text-xs transition-all uppercase tracking-widest">Data Diri</button>
            <button @click="tab = 'riwayat'" :class="tab === 'riwayat' ? 'bg-white shadow-sm text-primary' : 'text-slate-500'" class="px-8 py-3 rounded-xl font-black text-xs transition-all uppercase tracking-widest">Riwayat</button>
            <button @click="tab = 'sertifikat'" :class="tab === 'sertifikat' ? 'bg-white shadow-sm text-emerald-600' : 'text-slate-500'" class="px-8 py-3 rounded-xl font-black text-xs transition-all uppercase tracking-widest flex items-center gap-2">
                Sertifikat
                @if($sertifikats->count() > 0)
                <span class="bg-emerald-500 text-white text-[9px] font-black px-1.5 py-0.5 rounded-full">{{ $sertifikats->count() }}</span>
                @endif
            </button>
        </div>

        {{-- Tab: Data Diri --}}
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
                    <p class="text-sm font-bold text-slate-700 bg-slate-50 px-5 py-4 rounded-2xl border border-slate-100 italic">{{ $user->no_telepon ?? 'Belum diisi' }}</p>
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-2">Alamat Domisili</label>
                    <p class="text-sm font-bold text-slate-700 bg-slate-50 px-5 py-4 rounded-2xl border border-slate-100 italic">{{ $user->alamat ?? 'Belum diisi' }}</p>
                </div>
            </div>
        </div>

        {{-- Tab: Riwayat --}}
        <div x-show="tab === 'riwayat'" style="display:none" x-transition class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
            @if($riwayat->isEmpty())
            <div class="py-16 text-center text-slate-300">
                <span class="material-icons text-4xl block mb-2">inbox</span>
                <p class="font-bold text-sm">Belum ada riwayat reservasi.</p>
            </div>
            @else
            <table class="w-full text-left">
                <thead class="bg-slate-50 text-[10px] font-black uppercase text-slate-400 tracking-widest">
                    <tr>
                        <th class="px-8 py-5">Kavling</th>
                        <th class="px-8 py-5">Jenazah</th>
                        <th class="px-8 py-5">Status Reservasi</th>
                        <th class="px-8 py-5">Status Bayar</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($riwayat as $r)
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-8 py-5">
                            <p class="font-bold text-slate-800">{{ $r->kavling->nomor_kavling }}</p>
                            <p class="text-xs text-slate-400">{{ $r->kavling->cluster->nama_cluster ?? '-' }}</p>
                        </td>
                        <td class="px-8 py-5 text-slate-500 font-medium text-sm">
                            {{ $r->nama_jenazah ? 'Alm. '.$r->nama_jenazah : 'Pre-Need' }}
                        </td>
                        <td class="px-8 py-5">
                            @php
                                $badgeRes = match($r->status_reservasi) {
                                    'Selesai'          => 'bg-emerald-50 text-emerald-600',
                                    'Disetujui'        => 'bg-blue-50 text-blue-600',
                                    'Ditolak'          => 'bg-red-50 text-red-600',
                                    default            => 'bg-amber-50 text-amber-600',
                                };
                            @endphp
                            <span class="{{ $badgeRes }} px-3 py-1 rounded-lg font-black text-[9px] uppercase">
                                {{ $r->status_reservasi }}
                            </span>
                        </td>
                        <td class="px-8 py-5">
                            <span class="{{ $r->status_pembayaran === 'Lunas' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-100 text-slate-500' }} px-3 py-1 rounded-lg font-black text-[9px] uppercase">
                                {{ $r->status_pembayaran }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>

        {{-- Tab: Sertifikat --}}
        <div x-show="tab === 'sertifikat'" style="display:none" x-transition>

            @if($sertifikats->isEmpty())
            {{-- Kosong --}}
            <div class="py-20 text-center bg-white border-2 border-dashed border-slate-200 rounded-[2.5rem]">
                <span class="material-icons text-5xl text-slate-200 block mb-3">workspace_premium</span>
                <h3 class="text-lg font-black text-slate-400 mb-2">Belum Ada Sertifikat</h3>
                <p class="text-sm text-slate-400 max-w-sm mx-auto">
                    Sertifikat hak guna lahan akan diterbitkan oleh admin setelah pembayaran Anda dikonfirmasi lunas.
                </p>
            </div>
            @else
            {{-- Ada sertifikat --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($sertifikats as $s)
                <div class="bg-white p-8 rounded-[2.5rem] border border-emerald-100 shadow-sm relative overflow-hidden hover:shadow-md transition-all">

                    {{-- Dekorasi background --}}
                    <div class="absolute -right-6 -top-6 w-24 h-24 bg-emerald-50 rounded-full opacity-60"></div>
                    <div class="absolute -right-3 -top-3 w-12 h-12 bg-emerald-100 rounded-full opacity-60"></div>

                    <div class="relative z-10">
                        {{-- Icon --}}
                        <div class="w-12 h-12 bg-emerald-100 rounded-2xl flex items-center justify-center mb-4">
                            <span class="material-icons text-emerald-600">workspace_premium</span>
                        </div>

                        {{-- Info --}}
                        <h3 class="text-xl font-black text-slate-900 mb-1">
                            Kavling #{{ $s->kavling->nomor_kavling }}
                        </h3>
                        <p class="text-xs text-slate-400 mb-1">{{ $s->kavling->cluster->nama_cluster ?? '-' }} &middot; {{ $s->kavling->tipe_kavling }}</p>
                        @if($s->nama_jenazah)
                        <p class="text-xs text-slate-500 font-medium mb-4">Alm. {{ $s->nama_jenazah }}</p>
                        @else
                        <p class="text-xs text-slate-400 italic mb-4">Pre-Need</p>
                        @endif

                        {{-- Badge --}}
                        <div class="flex items-center gap-2 mb-6">
                            <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider">
                                ✓ Sertifikat Terbit
                            </span>
                        </div>

                        {{-- Tombol Download --}}
                        <div class="flex gap-3">
                            <a href="{{ asset('storage/sertifikat/' . $s->file_sertifikat) }}" target="_blank"
                               class="btn-press flex-1 flex items-center justify-center gap-2 px-5 py-3 bg-slate-900 text-white rounded-2xl font-bold text-xs hover:bg-slate-800 transition-all">
                                <span class="material-icons text-sm">open_in_new</span> Lihat
                            </a>
                            <a href="{{ asset('storage/sertifikat/' . $s->file_sertifikat) }}" download
                               class="btn-press flex-1 flex items-center justify-center gap-2 px-5 py-3 bg-emerald-600 text-white rounded-2xl font-bold text-xs hover:bg-emerald-700 transition-all">
                                <span class="material-icons text-sm">download</span> Download
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

        </div>

    </div>

    {{-- Modal Edit Profil --}}
    @include('pembeli.profil.edit')
    {{-- Modal Ganti Password --}}
    @include('pembeli.profil.password')
</div>

<style>
    @keyframes scaleIn { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
    .animate-scaleIn { animation: scaleIn 0.2s ease-out; }
</style>
@endsection