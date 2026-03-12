@extends('layouts.admin')
@section('title', 'Data Reservasi')

@section('content')
<div class="space-y-8 animate-fade-in-up">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-xl font-black text-slate-800 tracking-tight">Data Reservasi Pemakaman</h1>
            <p class="text-xs text-slate-500 mt-1 italic">Kelola permohonan pemakaman dan status ketersediaan kavling.</p>
        </div>
        
        @if(auth()->user()->role == 'admin')
        <button onclick="document.getElementById('modalTambah').classList.remove('hidden')" 
                class="bg-slate-900 hover:bg-black text-white px-5 py-2.5 rounded-xl text-xs font-bold shadow-xl shadow-slate-200 transition-all hover:-translate-y-1 flex items-center gap-2">
            <span class="material-icons-outlined text-sm">add_circle</span>
            Input Reservasi Baru
        </button>
        @endif
    </div>

    <div class="bg-white rounded-[1.5rem] shadow-2xl shadow-slate-100/50 border border-slate-50 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] border-b border-slate-100">
                        <th class="px-8 py-5">Informasi Pembeli</th>
                        <th class="px-8 py-5">Kavling & Area</th>
                        <th class="px-8 py-5 text-center">Nama Jenazah</th>
                        <th class="px-8 py-5 text-center">Status Verifikasi</th>
                        @if(auth()->user()->role == 'admin')
                        <th class="px-8 py-5 text-right">Tindakan</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($reservasis as $rs)
                    <tr class="group hover:bg-slate-50/30 transition-colors">
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-extrabold text-slate-800">{{ $rs->user->name }}</span>
                                <span class="text-[10px] text-slate-400 font-medium lowercase italic">{{ $rs->user->email }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-slate-700">{{ $rs->kavling->nomor_kavling }}</span>
                                <span class="text-[9px] font-bold text-blue-500 uppercase tracking-widest">{{ $rs->kavling->cluster->nama_cluster }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center italic text-slate-600 font-medium text-xs">
                            Alm. {{ $rs->nama_jenazah }}
                        </td>
                        <td class="px-8 py-6 text-center">
                            <span class="px-3 py-1.5 rounded-lg text-[9px] font-black uppercase tracking-wider
                                {{ $rs->status_reservasi == 'Menunggu' ? 'bg-amber-50 text-amber-600 border border-amber-100' : '' }}
                                {{ $rs->status_reservasi == 'Disetujui' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : '' }}
                                {{ $rs->status_reservasi == 'Ditolak' ? 'bg-rose-50 text-rose-600 border border-rose-100' : '' }}">
                                {{ $rs->status_reservasi }}
                            </span>
                        </td>
                        @if(auth()->user()->role == 'admin')
                        <td class="px-8 py-6 text-right">
                            <form action="{{ route('admin.reservasi.updateStatus', $rs->id) }}" method="POST">
                                @csrf @method('PUT')
                                <select name="status" onchange="this.form.submit()" 
                                        class="bg-white border border-slate-200 text-[10px] font-bold text-slate-700 rounded-lg px-2 py-1.5 outline-none focus:ring-2 focus:ring-slate-900/5 focus:border-slate-900 transition-all cursor-pointer shadow-sm">
                                    <option value="Menunggu" {{ $rs->status_reservasi == 'Menunggu' ? 'selected' : '' }}>Verifikasi</option>
                                    <option value="Disetujui" {{ $rs->status_reservasi == 'Disetujui' ? 'selected' : '' }}>Setujui</option>
                                    <option value="Ditolak" {{ $rs->status_reservasi == 'Ditolak' ? 'selected' : '' }}>Tolak</option>
                                </select>
                            </form>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@if(auth()->user()->role == 'admin')
<div id="modalTambah" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-[2rem] w-full max-w-md p-8 shadow-2xl animate-fade-in-up">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-black text-slate-800 tracking-tight">Input Reservasi</h3>
            <button onclick="document.getElementById('modalTambah').classList.add('hidden')" class="text-slate-400 hover:text-rose-500">
                <span class="material-icons-outlined">cancel</span>
            </button>
        </div>

        <form action="{{ route('admin.reservasi.store') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Pilih Pembeli</label>
                <select name="user_id" required class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-semibold outline-none focus:ring-4 focus:ring-slate-900/5 transition-all">
                    @foreach($pembelis as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Kavling Tersedia</label>
                <select name="kavling_id" required class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-semibold outline-none focus:ring-4 focus:ring-slate-900/5 transition-all">
                    @foreach($kavlings as $k)
                        <option value="{{ $k->id }}">{{ $k->nomor_kavling }} - {{ $k->cluster->nama_cluster }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Nama Jenazah</label>
                <input type="text" name="nama_jenazah" required placeholder="Contoh: Alm. Fulan bin Fulan" 
                       class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-semibold outline-none focus:ring-4 focus:ring-slate-900/5 transition-all">
            </div>

            <div>
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1.5 ml-1">Tanggal Dimakamkan</label>
                <input type="date" name="tanggal_dimakamkan" required 
                       class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-xs font-semibold outline-none focus:ring-4 focus:ring-slate-900/5 transition-all">
            </div>

            <div class="pt-4 flex gap-3">
                <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" 
                        class="flex-1 bg-slate-100 text-slate-500 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-200 transition-all">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 bg-slate-900 text-white py-3 rounded-xl text-[10px] font-black uppercase tracking-widest shadow-xl shadow-slate-200 hover:bg-black transition-all">
                    Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>
@endif
@endsection