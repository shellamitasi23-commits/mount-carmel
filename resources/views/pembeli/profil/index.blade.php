@extends('layouts.master')

@section('content')
<div x-data="{ tab: '{{ request('tab', 'data') }}', modalEdit: {{ $errors->hasAny('name', 'email', 'no_telepon', 'alamat') ? 'true' : 'false' }}, modalPass: {{ $errors->hasAny('current_password', 'password') ? 'true' : 'false' }}, showP: false }" class="min-h-screen bg-gray-50 pt-32 pb-16 px-6">
    <div class="max-w-5xl mx-auto">

        {{-- Flash Message --}}
        @if(session('success'))
        <div class="mb-10 bg-emerald-50 border-l-4 border-emerald-600 p-6 shadow-sm">
            <p class="text-emerald-800 font-black text-xs uppercase tracking-widest">Berhasil</p>
            <p class="text-emerald-700 text-sm font-medium mt-1">{{ session('success') }}</p>
        </div>
        @endif

        {{-- Header Profil --}}
        <div class="bg-white rounded-[3rem] p-12 border border-slate-100 shadow-2xl shadow-slate-200/40 flex flex-col md:flex-row items-center gap-12 mb-12">
            {{-- Avatar Container --}}
            <div class="relative group w-32 h-32 shrink-0">
                <form action="{{ route('profil.avatar.update') }}" method="POST" enctype="multipart/form-data" id="avatar-form">
                    @csrf
                    @method('PATCH')
                    <input type="file" name="avatar" id="avatar-input" class="hidden" accept="image/*" onchange="document.getElementById('avatar-form').submit()">
                </form>
                
                {{-- Avatar Clickable Circle --}}
                <button type="button" onclick="document.getElementById('avatar-input').click()" 
                        class="w-full h-full rounded-[2.5rem] overflow-hidden bg-[#800000] flex items-center justify-center font-black text-5xl text-white shadow-2xl shadow-slate-300 relative focus:outline-none group">
                    @if($user->avatar)
                        <img src="{{ asset('storage/avatars/' . $user->avatar) }}" class="w-full h-full object-cover" alt="Foto Profil">
                    @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    @endif
                    
                    {{-- Premium Glassmorphism Hover Overlay --}}
                    <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col items-center justify-center gap-1.5 rounded-[2.5rem]">
                        <span class="material-icons text-white text-2xl animate-pulse">photo_camera</span>
                        <span class="text-[8px] font-black text-white uppercase tracking-widest leading-none">Ganti Foto</span>
                    </div>
                </button>
                @error('avatar')
                <p class="text-rose-500 text-[10px] font-bold mt-2 uppercase tracking-wider text-center whitespace-nowrap">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex-1 text-center md:text-left">
                <h1 class="text-5xl font-black text-slate-900 leading-none tracking-tighter mb-2">{{ $user->name }}</h1>
                <p class="text-xl text-slate-400 font-medium mb-8">{{ $user->email }}</p>
                <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                    <button @click.stop="modalEdit = true" class="bg-[#800000] text-white px-10 py-5 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] shadow-2xl shadow-slate-300 hover:bg-[#800000]/90 transition-all active:scale-95">EDIT PROFIL</button>
                    <button @click.stop="modalPass = true" class="bg-slate-100 text-slate-600 px-10 py-5 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] hover:bg-slate-200 transition-all active:scale-95">GANTI PASSWORD</button>
                </div>
            </div>
        </div>

        {{-- Tab Navigasi --}}
        <div class="flex flex-wrap gap-3 mb-12">
            <button @click="tab = 'data'" 
                    :class="tab === 'data' ? 'bg-[#800000] text-white shadow-2xl shadow-slate-200' : 'bg-white text-slate-400 hover:text-slate-900 border border-slate-100'" 
                    class="px-10 py-4 rounded-2xl font-black text-[11px] transition-all uppercase tracking-[0.2em]">Data Diri</button>
            <button @click="tab = 'riwayat'" 
                    :class="tab === 'riwayat' ? 'bg-[#800000] text-white shadow-2xl shadow-slate-200' : 'bg-white text-slate-400 hover:text-slate-900 border border-slate-100'" 
                    class="px-10 py-4 rounded-2xl font-black text-[11px] transition-all uppercase tracking-[0.2em]">Riwayat</button>
            <button @click="tab = 'sertifikat'" 
                    :class="tab === 'sertifikat' ? 'bg-[#800000] text-white shadow-2xl shadow-slate-200' : 'bg-white text-slate-400 hover:text-slate-900 border border-slate-100'" 
                    class="px-10 py-4 rounded-2xl font-black text-[11px] transition-all uppercase tracking-[0.2em] flex items-center gap-3">
                Sertifikat
                @if($sertifikats->count() > 0)
                <span class="bg-emerald-500 text-white text-[10px] font-black px-2 py-1 rounded-lg">{{ $sertifikats->count() }}</span>
                @endif
            </button>
            <button @click="tab = 'pembayaran'" 
                    :class="tab === 'pembayaran' ? 'bg-[#800000] text-white shadow-2xl shadow-slate-200' : 'bg-white text-slate-400 hover:text-slate-900 border border-slate-100'" 
                    class="px-10 py-4 rounded-2xl font-black text-[11px] transition-all uppercase tracking-[0.2em] flex items-center gap-3">
                Pembayaran
                @if($reservasiSiapBayar->count() > 0)
                <span class="bg-amber-500 text-white text-[10px] font-black px-2 py-1 rounded-lg">{{ $reservasiSiapBayar->count() }}</span>
                @endif
            </button>
        </div>

        {{-- Tab: Data Diri --}}
        <div x-show="tab === 'data'" x-transition class="bg-white rounded-[2.5rem] p-12 border border-slate-50 shadow-2xl shadow-slate-200/30">
            <h3 class="text-xs font-black text-slate-300 uppercase tracking-[0.3em] mb-12">Informasi Akun</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4">Nama Lengkap</label>
                    <p class="text-lg font-bold text-slate-900 border-b-2 border-slate-50 pb-4">{{ $user->name }}</p>
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4">Alamat Email</label>
                    <p class="text-lg font-bold text-slate-900 border-b-2 border-slate-50 pb-4">{{ $user->email }}</p>
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4">No. Telepon</label>
                    <p class="text-lg font-bold text-slate-900 border-b-2 border-slate-50 pb-4">{{ $user->no_telepon ?? '—' }}</p>
                </div>
                <div>
                    <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-4">Alamat Domisili</label>
                    <p class="text-lg font-bold text-slate-900 border-b-2 border-slate-50 pb-4">{{ $user->alamat ?? '—' }}</p>
                </div>
            </div>
        </div>

        {{-- Tab: Riwayat --}}
        <div x-show="tab === 'riwayat'" style="display:none" x-transition class="bg-white rounded-[2.5rem] border border-slate-50 shadow-2xl shadow-slate-200/30 overflow-hidden">
            @if($riwayat->isEmpty())
            <div class="py-24 text-center">
                <p class="text-slate-300 font-black text-xs uppercase tracking-[0.2em]">Belum ada riwayat reservasi</p>
            </div>
            @else
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50 text-[11px] font-black uppercase text-slate-400 tracking-[0.2em]">
                        <tr>
                            <th class="px-10 py-8">Lahan</th>
                            <th class="px-10 py-8">Jenazah</th>
                            <th class="px-10 py-8">Status</th>
                            <th class="px-10 py-8 text-right">Pembayaran</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($riwayat as $r)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-10 py-8">
                                <p class="text-xl font-black text-slate-900 tracking-tight">#{{ $r->lahan->nomor_lahan }}</p>
                                <p class="text-xs font-bold text-slate-400 uppercase mt-1">{{ $r->lahan->cluster->nama_cluster ?? '-' }}</p>
                            </td>
                            <td class="px-10 py-8">
                                <p class="text-sm font-bold text-slate-600">
                                    {{ $r->nama_jenazah ? 'ALM. '.strtoupper($r->nama_jenazah) : '—' }}
                                </p>
                            </td>
                            <td class="px-10 py-8">
                                <span class="text-[10px] font-black uppercase tracking-widest {{ $r->status_reservasi === 'Ditolak' ? 'text-rose-600' : ($r->status_reservasi === 'Disetujui' ? 'text-blue-600' : 'text-slate-900') }}">
                                    {{ $r->status_reservasi }}
                                </span>
                            </td>
                            <td class="px-10 py-8 text-right">
                                <span class="text-[10px] font-black uppercase tracking-widest {{ $r->status_pembayaran === 'Lunas' ? 'text-emerald-600' : 'text-slate-400' }}">
                                    {{ $r->status_pembayaran }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        {{-- Tab: Sertifikat --}}
        <div x-show="tab === 'sertifikat'" style="display:none" x-transition>
            @if($sertifikats->isEmpty())
            <div class="py-24 text-center bg-white border-2 border-dashed border-slate-100 rounded-[3rem]">
                <h3 class="text-xs font-black text-slate-300 uppercase tracking-[0.3em]">Belum Ada Sertifikat Terbit</h3>
            </div>
            @else
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach($sertifikats as $s)
                <div class="bg-white p-12 rounded-[3rem] border border-slate-50 shadow-2xl shadow-slate-200/30 hover:-translate-y-1 transition-all duration-500">
                    <p class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.3em] mb-6">Sertifikat Hak Guna</p>
                    <h3 class="text-4xl font-black text-slate-900 tracking-tighter mb-2">LAHAN #{{ $s->lahan->nomor_lahan }}</h3>
                    <p class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-8">{{ $s->lahan->cluster->nama_cluster ?? '-' }} &middot; {{ $s->lahan->tipe_lahan }}</p>
                    
                    <div class="flex flex-col gap-3">
                        <a href="{{ asset('storage/sertifikat/' . $s->file_sertifikat) }}" target="_blank"
                           class="w-full py-5 bg-[#800000] text-white rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] text-center hover:bg-[#800000]/90 transition-all">LIHAT DOKUMEN</a>
                        <a href="{{ asset('storage/sertifikat/' . $s->file_sertifikat) }}" download
                           class="w-full py-5 bg-slate-100 text-slate-600 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] text-center hover:bg-slate-200 transition-all">UNDUH BERKAS</a>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>

        {{-- Tab: Pembayaran --}}
        <div x-show="tab === 'pembayaran'" style="display:none" x-transition class="space-y-12">
            
            {{-- Tagihan Aktif --}}
            @if($reservasiSiapBayar->count() > 0)
            <div class="bg-white rounded-[3rem] p-12 border-l-8 border-amber-500 shadow-2xl shadow-slate-200/40">
                <h3 class="text-[11px] font-black text-amber-600 uppercase tracking-[0.3em] mb-10">Menunggu Pembayaran</h3>
                <div class="space-y-6">
                    @foreach($reservasiSiapBayar as $res)
                    <div class="bg-amber-50/50 rounded-[2.5rem] p-10 flex flex-col md:flex-row md:items-center justify-between gap-8 border border-amber-100/50">
                        <div>
                            <p class="text-3xl font-black text-slate-900 tracking-tighter">Lahan #{{ $res->lahan->nomor_lahan }}</p>
                            <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mt-2">{{ $res->lahan->cluster->nama_cluster }} &middot; {{ $res->lahan->tipe_lahan }}</p>
                        </div>
                        <div class="flex flex-col md:items-end gap-6">
                            <div class="text-right">
                                <p class="text-[11px] font-black text-slate-400 uppercase tracking-widest mb-1">Harus Dibayar</p>
                                <p class="text-3xl font-black text-slate-900 tracking-tight">Rp {{ number_format($res->lahan->harga, 0, ',', '.') }}</p>
                            </div>
                            <a href="{{ route('pembeli.pembayaran.create', ['reservasi_id' => $res->id]) }}"
                               class="bg-amber-500 text-white px-12 py-5 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] shadow-2xl shadow-amber-200 hover:bg-amber-600 transition-all active:scale-95">BAYAR SEKARANG</a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- Riwayat --}}
            <div class="bg-white rounded-[3rem] p-12 border border-slate-50 shadow-2xl shadow-slate-200/30">
                <h3 class="text-xs font-black text-slate-300 uppercase tracking-[0.3em] mb-12">Riwayat Transaksi</h3>
                @if($pembayarans->isEmpty())
                <p class="text-center py-12 text-slate-300 font-black text-xs uppercase tracking-widest">Belum ada riwayat pembayaran</p>
                @else
                <div class="space-y-6">
                    @foreach($pembayarans as $bayar)
                    <div class="p-10 border border-slate-50 rounded-[2.5rem] bg-slate-50/30 hover:bg-white hover:shadow-2xl hover:shadow-slate-200/50 transition-all duration-500">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
                            <div>
                                <div class="flex items-center gap-4 mb-4">
                                    <p class="text-lg font-black text-slate-900 tracking-tight">{{ $bayar->no_invoice }}</p>
                                    <span class="px-4 py-2 rounded-full text-[10px] font-black uppercase tracking-widest
                                        {{ $bayar->status_pembayaran === 'Lunas' ? 'bg-emerald-100 text-emerald-700' :
                                           ($bayar->status_pembayaran === 'Ditolak' ? 'bg-rose-100 text-rose-700' : 'bg-amber-100 text-amber-700') }}">
                                        {{ $bayar->status_pembayaran }}
                                    </span>
                                </div>
                                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">
                                    Lahan #{{ $bayar->reservasi->lahan->nomor_lahan }} &middot;
                                    {{ $bayar->reservasi->lahan->cluster->nama_cluster }}
                                </p>
                                <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest mt-2">{{ $bayar->created_at->translatedFormat('d M Y, H:i') }}</p>
                            </div>
                            <div class="flex flex-col md:items-end gap-6">
                                <p class="text-3xl font-black text-slate-900 tracking-tight">Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}</p>
                                <div class="flex gap-3">
                                    @if($bayar->status_pembayaran === 'Lunas')
                                    <a href="{{ route('pembeli.pembayaran.invoice', $bayar->id) }}"
                                       class="px-8 py-4 bg-[#800000] text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-[#800000]/90 transition-all">INVOICE</a>
                                    @endif
                                    @if($bayar->status_pembayaran === 'Ditolak')
                                    <a href="{{ route('pembeli.pembayaran.create', ['reservasi_id' => $bayar->reservasi_id]) }}"
                                       class="px-8 py-4 bg-rose-600 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-rose-700 transition-all">KIRIM ULANG</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>

    </div>

    {{-- Modal Edit Profil --}}
    @include('pembeli.profil.edit')
    {{-- Modal Ganti Password --}}
    @include('pembeli.profil.password')
</div>
@endsection
