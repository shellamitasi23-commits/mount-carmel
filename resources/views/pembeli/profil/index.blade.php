@extends('layouts.master')

@section('content')

<div x-data="{ tab: '{{ request('tab', 'data') }}' }" class="min-h-screen bg-[#FAFAFA] pt-28 pb-20 px-4 md:px-8 font-inter">
    <div class="max-w-6xl mx-auto">

        {{-- Flash Message --}}
        @if(session('success'))
        <div class="mb-8 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-xl shadow-sm">
            <p class="text-emerald-800 font-semibold text-xs">Berhasil</p>
            <p class="text-emerald-700 text-[11px] font-medium mt-0.5">{{ session('success') }}</p>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-8 bg-rose-50 border-l-4 border-rose-500 p-4 rounded-r-xl shadow-sm">
            <p class="text-rose-800 text-xs font-semibold">Terdapat Kesalahan</p>
            <ul class="text-[11px] text-rose-700 list-disc list-inside space-y-0.5 mt-1 font-medium">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Main Grid Layout --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            {{-- COLUMN KIRI - NAVIGATION --}}
            <div class="lg:col-span-4 space-y-6">
                
                {{-- Navigation List Card --}}
                <div class="bg-white rounded-3xl border border-slate-100 p-5 shadow-[0_10px_30px_rgba(0,0,0,0.015)] space-y-1">
                    
                    {{-- Item: Data Diri --}}
                    <button @click="tab = 'data'"
                            :class="tab === 'data' ? 'bg-[#800000]/5 text-[#800000]' : 'text-slate-500 hover:bg-slate-50'"
                            class="w-full flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-200 text-left">
                        <span class="material-icons text-xl" :class="tab === 'data' ? 'text-[#800000]' : 'text-slate-400'">person</span>
                        <div>
                            <p class="text-xs font-semibold">Informasi Akun</p>
                            <p class="text-[9px] text-slate-400 mt-0.5">Ubah detail profil & data diri</p>
                        </div>
                    </button>

                    {{-- Item: Keamanan --}}
                    <button @click="tab = 'password'"
                            :class="tab === 'password' ? 'bg-[#800000]/5 text-[#800000]' : 'text-slate-500 hover:bg-slate-50'"
                            class="w-full flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-200 text-left">
                        <span class="material-icons text-xl" :class="tab === 'password' ? 'text-[#800000]' : 'text-slate-400'">lock</span>
                        <div>
                            <p class="text-xs font-semibold">Keamanan</p>
                            <p class="text-[9px] text-slate-400 mt-0.5">Perbarui kata sandi akun Anda</p>
                        </div>
                    </button>

                    {{-- Item: Riwayat --}}
                    <button @click="tab = 'riwayat'"
                            :class="tab === 'riwayat' ? 'bg-[#800000]/5 text-[#800000]' : 'text-slate-500 hover:bg-slate-50'"
                            class="w-full flex items-center gap-4 px-4 py-3 rounded-2xl transition-all duration-200 text-left">
                        <span class="material-icons text-xl" :class="tab === 'riwayat' ? 'text-[#800000]' : 'text-slate-400'">assignment</span>
                        <div>
                            <p class="text-xs font-semibold">Riwayat Reservasi</p>
                            <p class="text-[9px] text-slate-400 mt-0.5">Daftar pemesanan & slot lahan</p>
                        </div>
                    </button>

                    {{-- Item: Sertifikat --}}
                    <button @click="tab = 'sertifikat'"
                            :class="tab === 'sertifikat' ? 'bg-[#800000]/5 text-[#800000]' : 'text-slate-500 hover:bg-slate-50'"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-2xl transition-all duration-200 text-left">
                        <div class="flex items-center gap-4">
                            <span class="material-icons text-xl" :class="tab === 'sertifikat' ? 'text-[#800000]' : 'text-slate-400'">workspace_premium</span>
                            <div>
                                <p class="text-xs font-semibold">Sertifikat</p>
                                <p class="text-[9px] text-slate-400 mt-0.5">Unduh sertifikat lahan makam</p>
                            </div>
                        </div>
                        @if($sertifikats->count() > 0)
                            <span class="bg-emerald-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded">{{ $sertifikats->count() }}</span>
                        @endif
                    </button>

                    {{-- Item: Pembayaran --}}
                    <button @click="tab = 'pembayaran'"
                            :class="tab === 'pembayaran' ? 'bg-[#800000]/5 text-[#800000]' : 'text-slate-500 hover:bg-slate-50'"
                            class="w-full flex items-center justify-between px-4 py-3 rounded-2xl transition-all duration-200 text-left">
                        <div class="flex items-center gap-4">
                            <span class="material-icons text-xl" :class="tab === 'pembayaran' ? 'text-[#800000]' : 'text-slate-400'">payments</span>
                            <div>
                                <p class="text-xs font-semibold">Pembayaran</p>
                                <p class="text-[9px] text-slate-400 mt-0.5">Tagihan aktif & riwayat transaksi</p>
                            </div>
                        </div>
                        @if($reservasiSiapBayar->count() > 0)
                            <span class="bg-amber-500 text-white text-[9px] font-bold px-1.5 py-0.5 rounded">{{ $reservasiSiapBayar->count() }}</span>
                        @endif
                    </button>

                </div>
            </div>

            {{-- COLUMN KANAN - CONTENT CARD --}}
            <div class="lg:col-span-8">
                
                {{-- TAB CONTENT: DATA DIRI --}}
                <div x-show="tab === 'data'" x-transition class="bg-white rounded-3xl border border-slate-100 p-6 md:p-8 shadow-[0_10px_30px_rgba(0,0,0,0.015)]">
                    <h3 class="text-base font-bold text-slate-800 mb-6">Informasi Pribadi</h3>
                    
                    {{-- Avatar Section --}}
                    <div class="flex flex-col sm:flex-row items-center gap-5 mb-8 border-b border-slate-50 pb-6">
                        <div class="relative w-20 h-20 shrink-0">
                            <button type="button" onclick="document.getElementById('avatar-input').click()" 
                                    class="w-full h-full rounded-2xl overflow-hidden bg-[#800000] flex items-center justify-center font-bold text-3xl text-white shadow-sm relative group">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/avatars/' . $user->avatar) }}" class="w-full h-full object-cover" alt="Foto Profil">
                                @else
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                @endif
                                <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-[2px] opacity-0 group-hover:opacity-100 transition-all duration-300 flex items-center justify-center rounded-2xl">
                                    <span class="material-icons text-white text-base">photo_camera</span>
                                </div>
                            </button>
                        </div>
                        <div class="text-center sm:text-left space-y-2">
                            <h4 class="text-xs font-semibold text-slate-500">Foto Profil Utama</h4>
                            <div class="flex flex-wrap gap-2 justify-center sm:justify-start">
                                <button type="button" onclick="document.getElementById('avatar-input').click()" class="px-3.5 py-2 bg-[#800000] hover:bg-[#800000]/90 text-white rounded-xl text-xs font-semibold transition-all">Upload foto baru</button>
                                @if($user->avatar)
                                <button type="button" onclick="document.getElementById('delete-avatar-submit').click()" class="px-3.5 py-2 bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 rounded-xl text-xs font-semibold transition-all">Hapus</button>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Form Data Diri --}}
                    <form action="{{ route('profil.update') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PATCH')
                        
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Nama Lengkap</label>
                            <div class="relative">
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                       class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-4 pr-12 py-3.5 text-xs text-slate-700 focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all">
                                <span class="material-icons absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-base">edit</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Alamat Email</label>
                            <div class="relative">
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                       class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-4 pr-12 py-3.5 text-xs text-slate-700 focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all">
                                <span class="material-icons absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-base">edit</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2">No. Telepon / WhatsApp</label>
                            <div class="relative">
                                <input type="text" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}" placeholder="Belum diisi"
                                       class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-4 pr-12 py-3.5 text-xs text-slate-700 focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all">
                                <span class="material-icons absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 text-base">edit</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Alamat Domisili</label>
                            <div class="relative">
                                <textarea name="alamat" rows="3" placeholder="Belum diisi"
                                          class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-4 pr-12 py-3.5 text-xs text-slate-700 focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all resize-none">{{ old('alamat', $user->alamat) }}</textarea>
                                <span class="material-icons absolute right-4 top-6 text-slate-400 text-base">edit</span>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full bg-[#800000] hover:bg-[#800000]/90 text-white py-3 rounded-2xl font-semibold text-xs transition-all shadow-sm">Perbarui Profil</button>
                        </div>
                    </form>
                </div>

                {{-- TAB CONTENT: KEAMANAN / GANTI PASSWORD --}}
                <div x-show="tab === 'password'" style="display:none" x-transition class="bg-white rounded-3xl border border-slate-100 p-6 md:p-8 shadow-[0_10px_30px_rgba(0,0,0,0.015)]">
                    <h3 class="text-base font-bold text-slate-800 mb-6">Keamanan Akun</h3>
                    
                    <form action="{{ route('profil.password') }}" method="POST" class="space-y-5" x-data="{ showCurr: false, showNew: false, showConf: false }">
                        @csrf
                        @method('PUT')

                        @if($user->password)
                        <div>
                            <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Password Saat Ini</label>
                            <div class="relative">
                                <input :type="showCurr ? 'text' : 'password'" name="current_password" required
                                       class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-4 pr-12 py-3.5 text-xs text-slate-700 focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all">
                                <button type="button" @click="showCurr = !showCurr" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-650 transition-colors">
                                    <span class="material-icons text-sm" x-text="showCurr ? 'visibility_off' : 'visibility'"></span>
                                </button>
                            </div>
                        </div>
                        @else
                        <div class="bg-amber-50 border border-amber-200 text-amber-800 p-4 rounded-2xl text-xs leading-relaxed font-medium">
                            Anda terhubung menggunakan Google. Silakan langsung buat password baru di bawah ini untuk mengamankan login manual akun Anda.
                        </div>
                        @endif

                        <div>
                            <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Password Baru</label>
                            <div class="relative">
                                <input :type="showNew ? 'text' : 'password'" name="password" required
                                       class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-4 pr-12 py-3.5 text-xs text-slate-700 focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all">
                                <button type="button" @click="showNew = !showNew" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-650 transition-colors">
                                    <span class="material-icons text-sm" x-text="showNew ? 'visibility_off' : 'visibility'"></span>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-semibold text-slate-400 uppercase tracking-wider mb-2">Konfirmasi Password Baru</label>
                            <div class="relative">
                                <input :type="showConf ? 'text' : 'password'" name="password_confirmation" required
                                       class="w-full bg-slate-50 border border-slate-100 rounded-2xl pl-4 pr-12 py-3.5 text-xs text-slate-700 focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all">
                                <button type="button" @click="showConf = !showConf" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-650 transition-colors">
                                    <span class="material-icons text-sm" x-text="showConf ? 'visibility_off' : 'visibility'"></span>
                                </button>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full bg-[#800000] hover:bg-[#800000]/90 text-white py-3 rounded-2xl font-semibold text-xs transition-all shadow-sm">Update Password</button>
                        </div>
                    </form>
                </div>

                {{-- TAB CONTENT: RIWAYAT RESERVASI --}}
                <div x-show="tab === 'riwayat'" style="display:none" x-transition class="bg-white rounded-3xl border border-slate-100 shadow-[0_10px_30px_rgba(0,0,0,0.015)] overflow-hidden">
                    <h3 class="text-base font-bold text-slate-800 p-6 border-b border-slate-50">Riwayat Reservasi</h3>
                    
                    @if($riwayat->isEmpty())
                    <div class="py-16 text-center">
                        <p class="text-slate-400 font-medium text-xs">Belum ada riwayat reservasi</p>
                    </div>
                    @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-slate-50 text-[10px] font-semibold uppercase text-slate-400 tracking-wider">
                                <tr>
                                    <th class="px-6 py-4">Lahan</th>
                                    <th class="px-6 py-4">Jenazah</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4 text-right">Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs">
                                @foreach($riwayat as $r)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <p class="text-sm font-semibold text-slate-800">#{{ $r->lahan->nomor_lahan }}</p>
                                        <p class="text-[10px] font-medium text-slate-400 mt-0.5">{{ $r->lahan->cluster->nama_cluster ?? '-' }}</p>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="space-y-1.5 py-1">
                                            @php
                                                $kapasitas = $r->lahan->kapasitas;
                                                $statusBayar = $r->status_pembayaran;
                                                $statusRes = $r->status_reservasi;
                                                $isApproved = $statusRes === 'Disetujui' || $statusRes === 'Selesai';
                                                $isPaid = ($statusBayar === 'Lunas' || $statusBayar === 'DP Lunas' || str_contains($statusBayar, 'Lunas'));
                                                $canFill = $isApproved && $isPaid;
                                            @endphp
                                            @for($slot = 1; $slot <= $kapasitas; $slot++)
                                                @php
                                                    $detail = $r->detailJenazahs->where('nomor_slot', $slot)->first();
                                                @endphp
                                                <div class="flex flex-wrap items-center gap-1.5 text-[11px]">
                                                    @if($kapasitas > 1)
                                                        <span class="px-1 py-0.5 bg-slate-100 text-slate-400 rounded text-[8px] font-medium">Slot #{{ $slot }}</span>
                                                    @endif
                                                    @if($detail)
                                                        <span class="font-medium text-slate-700">Alm. {{ ucwords(strtolower($detail->nama_jenazah)) }}</span>
                                                        @if($detail->status === 'Menunggu Validasi')
                                                            <span class="px-1.5 py-0.2 bg-amber-50 text-amber-700 border border-amber-200 rounded text-[8px] font-medium">Pending</span>
                                                        @elseif($detail->status === 'Disetujui')
                                                            <span class="px-1.5 py-0.2 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded text-[8px] font-medium">Disetujui</span>
                                                        @elseif($detail->status === 'Ditolak')
                                                            <span class="px-1.5 py-0.2 bg-red-50 text-red-700 border border-red-200 rounded text-[8px] font-medium">Ditolak</span>
                                                            <a href="{{ route('pembeli.reservasi.isi_slot_form', ['reservasi_id' => $r->id, 'nomor_slot' => $slot]) }}"
                                                               class="text-[#800000] hover:text-[#800000]/80 font-semibold underline transition-colors text-[9px] ml-1">
                                                               Edit
                                                            </a>
                                                        @endif
                                                    @else
                                                        @if($canFill)
                                                            <a href="{{ route('pembeli.reservasi.isi_slot_form', ['reservasi_id' => $r->id, 'nomor_slot' => $slot]) }}"
                                                               class="text-[#800000] hover:text-[#800000]/80 font-semibold underline transition-colors text-[10px]">
                                                               Isi Data Diri
                                                            </a>
                                                        @else
                                                            <span class="text-slate-400 italic text-[10px]">Belum terisi</span>
                                                        @endif
                                                    @endif
                                                </div>
                                            @endfor
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-semibold {{ $r->status_reservasi === 'Ditolak' ? 'text-rose-600' : ($r->status_reservasi === 'Disetujui' || $r->status_reservasi === 'Selesai' ? 'text-blue-600' : 'text-slate-600') }}">
                                            {{ $r->status_reservasi }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="font-semibold {{ $r->status_pembayaran === 'Lunas' ? 'text-emerald-600' : 'text-slate-500' }}">
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

                {{-- TAB CONTENT: SERTIFIKAT --}}
                <div x-show="tab === 'sertifikat'" style="display:none" x-transition class="bg-white rounded-3xl border border-slate-100 p-6 md:p-8 shadow-[0_10px_30px_rgba(0,0,0,0.015)]">
                    <h3 class="text-base font-bold text-slate-800 mb-6">Sertifikat Kepemilikan</h3>
                    
                    @if($sertifikats->isEmpty())
                    <div class="py-16 text-center bg-slate-50/50 border border-dashed border-slate-200 rounded-3xl">
                        <span class="material-icons text-4xl text-slate-300 mb-2">workspace_premium</span>
                        <h3 class="text-xs font-semibold text-slate-400">Belum Ada Sertifikat Terbit</h3>
                    </div>
                    @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($sertifikats as $s)
                        <div class="bg-slate-50/40 p-5 rounded-2xl border border-slate-100 hover:shadow-sm transition-all duration-300">
                            <p class="text-[9px] font-semibold text-emerald-600 uppercase tracking-wider mb-2">Sertifikat Hak Guna</p>
                            <h3 class="text-sm font-bold text-slate-800 tracking-tight mb-1">Lahan #{{ $s->lahan->nomor_lahan }}</h3>
                            <p class="text-[10px] font-medium text-slate-400 mb-5">{{ $s->lahan->cluster->nama_cluster ?? '-' }} &middot; {{ $s->lahan->tipe_lahan }}</p>
                            
                            <div class="grid grid-cols-2 gap-2">
                                <a href="{{ asset('storage/sertifikat/' . $s->file_sertifikat) }}" target="_blank"
                                   class="w-full py-2 bg-[#800000] text-white rounded-lg font-semibold text-[10px] text-center hover:bg-[#800000]/90 transition-all">Lihat Dokumen</a>
                                <a href="{{ asset('storage/sertifikat/' . $s->file_sertifikat) }}" download
                                   class="w-full py-2 bg-white border border-slate-200 text-slate-600 rounded-lg font-semibold text-[10px] text-center hover:bg-slate-50 transition-all">Unduh Berkas</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- TAB CONTENT: PEMBAYARAN --}}
                <div x-show="tab === 'pembayaran'" style="display:none" x-transition class="space-y-6">
                    
                    {{-- Tagihan Aktif --}}
                    @if($reservasiSiapBayar->count() > 0)
                    <div class="bg-white rounded-3xl p-6 md:p-8 border-l-4 border-amber-500 shadow-[0_10px_30px_rgba(0,0,0,0.015)]">
                        <h3 class="text-xs font-semibold text-amber-600 uppercase tracking-wider mb-6">Menunggu Pembayaran</h3>
                        <div class="space-y-4">
                            @foreach($reservasiSiapBayar as $res)
                            <div class="bg-amber-50/50 rounded-2xl p-4 flex flex-col md:flex-row md:items-center justify-between gap-4 border border-amber-100/50 shadow-sm">
                                <div>
                                    <p class="text-base font-semibold text-slate-800">Lahan #{{ $res->lahan->nomor_lahan }}</p>
                                    <p class="text-[10px] font-medium text-slate-400 mt-0.5">{{ $res->lahan->cluster->nama_cluster }} &middot; {{ $res->lahan->tipe_lahan }}</p>
                                </div>
                                <div class="flex flex-col md:flex-row md:items-center gap-4">
                                    <div class="md:text-right">
                                        <p class="text-[9px] font-semibold text-slate-400 uppercase tracking-wider mb-0.5">{{ $res->tipe_tagihan ?? 'Harus Dibayar' }}</p>
                                        <p class="text-base font-bold text-[#800000] tracking-tight">Rp {{ number_format($res->nominal_tagihan ?? $res->lahan->harga, 0, ',', '.') }}</p>
                                    </div>
                                    <a href="{{ route('pembeli.pembayaran.create', ['reservasi_id' => $res->id]) }}"
                                       class="bg-amber-500 text-white px-4 py-2 rounded-lg font-semibold text-[10px] tracking-wider shadow-sm hover:bg-amber-600 transition-all active:scale-95 text-center whitespace-nowrap">BAYAR SEKARANG</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Riwayat Transaksi --}}
                    <div class="bg-white rounded-3xl p-6 md:p-8 border border-slate-100 shadow-[0_10px_30px_rgba(0,0,0,0.015)]">
                        <h3 class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-6">Riwayat Transaksi</h3>
                        @if($pembayarans->isEmpty())
                        <p class="text-center py-8 text-slate-400 font-medium text-xs">Belum ada riwayat pembayaran</p>
                        @else
                        <div class="space-y-4">
                            @foreach($pembayarans as $bayar)
                            <div class="p-4 border border-slate-100 rounded-2xl bg-slate-50/20 hover:bg-white hover:shadow-sm transition-all duration-300">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1.5">
                                            <p class="text-sm font-semibold text-slate-800 tracking-tight">{{ $bayar->no_invoice }}</p>
                                            <span class="px-2 py-0.5 rounded-full text-[8px] font-medium
                                                @if($bayar->status_pembayaran === 'Lunas')
                                                    @if($bayar->reservasi?->jenis_pembayaran === 'cicilan' && ($bayar->cicilan_ke === 0 || $bayar->cicilan_ke < $bayar->total_cicilan))
                                                        bg-blue-50 text-blue-700 border border-blue-200
                                                    @else
                                                        bg-emerald-50 text-emerald-700 border border-emerald-200
                                                    @endif
                                                @elseif($bayar->status_pembayaran === 'Ditolak')
                                                    bg-rose-50 text-rose-700 border border-rose-200
                                                @else
                                                    bg-amber-50 text-amber-700 border border-amber-200
                                                @endif">
                                                {{ $bayar->status_label }}
                                            </span>
                                        </div>
                                        <p class="text-[10px] font-medium text-slate-500">
                                            Lahan #{{ $bayar->reservasi->lahan->nomor_lahan }} &middot;
                                            {{ $bayar->reservasi->lahan->cluster->nama_cluster }} &middot;
                                            @if($bayar->reservasi?->jenis_pembayaran === 'cicilan')
                                                @if($bayar->cicilan_ke === 0)
                                                    Uang Muka / DP Awal (20%)
                                                @else
                                                    Cicilan Ke-{{ $bayar->cicilan_ke }} dari {{ $bayar->total_cicilan }}
                                                @endif
                                            @else
                                                Pembayaran Penuh
                                            @endif
                                        </p>
                                        <p class="text-[8px] font-medium text-slate-350 mt-1">{{ $bayar->created_at->translatedFormat('d M Y, H:i') }}</p>
                                    </div>
                                    <div class="flex flex-row items-center justify-between md:justify-end gap-6">
                                        <p class="text-base font-bold text-slate-850 tracking-tight">Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}</p>
                                        <div class="flex gap-2">
                                            @if($bayar->status_pembayaran === 'Lunas')
                                            <a href="{{ route('pembeli.pembayaran.invoice', $bayar->id) }}"
                                               class="px-3 py-1.5 bg-[#800000] text-white rounded-md font-semibold text-[9px] hover:bg-[#800000]/90 transition-all text-center">Invoice</a>
                                            @endif
                                            @if($bayar->status_pembayaran === 'Ditolak')
                                            <a href="{{ route('pembeli.pembayaran.create', ['reservasi_id' => $bayar->reservasi_id]) }}"
                                               class="px-3 py-1.5 bg-rose-600 text-white rounded-md font-semibold text-[9px] hover:bg-rose-700 transition-all text-center">Kirim Ulang</a>
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
        </div>

    </div>
    
    {{-- Hidden forms for Avatar actions --}}
    <form action="{{ route('profil.avatar.update') }}" method="POST" enctype="multipart/form-data" id="avatar-form" class="hidden">
        @csrf
        @method('PATCH')
        <input type="file" name="avatar" id="avatar-input" accept="image/*" onchange="document.getElementById('avatar-form').submit()">
    </form>
    
    @if($user->avatar)
    <form action="{{ route('profil.avatar.update') }}" method="POST" id="delete-avatar-form" class="hidden">
        @csrf
        @method('PATCH')
        <input type="hidden" name="remove_avatar" value="1">
        <button type="submit" id="delete-avatar-submit"></button>
    </form>
    @endif
</div>
@endsection
