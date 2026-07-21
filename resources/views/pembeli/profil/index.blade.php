@extends('layouts.master')

@section('content')
@php
    $lunasReservasis = $riwayat->where('status_reservasi', 'Selesai');
@endphp


<div x-data="{ tab: '{{ request('tab', 'data') }}' }" class="min-h-screen bg-[#FAFAFA] pt-28 pb-20 px-4 md:px-8 font-inter">
    <div class="max-w-6xl mx-auto">

        <!-- Elegant Dashboard Header -->
        <div class="bg-gradient-to-r from-[#800000] to-[#4a0000] rounded-[2rem] p-6 md:p-8 text-white mb-8 relative overflow-hidden shadow-[0_10px_35px_rgba(128,0,0,0.15)] animate-fade-in">
            <div class="absolute -right-10 -top-10 w-44 h-44 bg-white/5 rounded-full blur-xl"></div>
            <div class="absolute -left-10 -bottom-10 w-52 h-52 bg-white/5 rounded-full blur-2xl"></div>
            
            <div class="flex flex-col md:flex-row items-center gap-6 relative z-10">
                <div class="relative w-24 h-24 shrink-0 rounded-2xl border-4 border-white/20 overflow-hidden bg-white/10 flex items-center justify-center font-bold text-4xl shadow-md">
                    @if($user->avatar)
                        <img src="{{ asset('storage/avatars/' . $user->avatar) }}" class="w-full h-full object-cover" alt="Foto Profil">
                    @else
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    @endif
                </div>
                <div class="text-center md:text-left space-y-1.5 flex-1">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-[9px] font-bold tracking-widest uppercase mb-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-450 animate-pulse"></span>
                        Akun Pembeli
                    </span>
                    <h2 class="text-2xl font-bold tracking-tight font-poppins">{{ $user->name }}</h2>
                    <p class="text-white/70 text-xs font-medium">{{ $user->email }}</p>
                </div>
                @if($riwayat->count() > 0)
                <div class="flex items-center gap-6 bg-white/10 backdrop-blur-md px-6 py-4 rounded-2xl border border-white/10 shrink-0">
                    <div class="text-center">
                        <p class="text-[10px] text-white/60 font-bold uppercase tracking-wider">Total Reservasi</p>
                        <p class="text-2xl font-black mt-0.5">{{ $riwayat->count() }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
        
        @if(session('success'))
        <div class="mb-8 bg-emerald-50/80 backdrop-blur-sm border-l-4 border-emerald-500 p-4 rounded-r-2xl shadow-[0_4px_20px_rgba(16,185,129,0.06)] flex items-center gap-3">
            <div class="w-7 h-7 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-600 shrink-0">
                <span class="material-icons text-sm">check_circle</span>
            </div>
            <div>
                <p class="text-emerald-800 font-bold text-xs">Berhasil</p>
                <p class="text-emerald-700 text-[11px] font-semibold mt-0.5">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-8 bg-rose-50/80 backdrop-blur-sm border-l-4 border-rose-500 p-4 rounded-r-2xl shadow-[0_4px_20px_rgba(244,63,94,0.06)] flex items-start gap-3">
            <div class="w-7 h-7 rounded-full bg-rose-500/10 flex items-center justify-center text-rose-600 shrink-0 mt-0.5">
                <span class="material-icons text-sm">error</span>
            </div>
            <div>
                <p class="text-rose-800 text-xs font-bold">Terdapat Kesalahan</p>
                <ul class="text-[11px] text-rose-700 list-disc list-inside space-y-0.5 mt-1 font-semibold">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            
            <div class="lg:col-span-4 space-y-6">
                
                
                <div class="bg-white rounded-[2rem] border border-slate-100 p-4 shadow-[0_10px_30px_rgba(0,0,0,0.015)] space-y-1.5">
                    
                    
                    <button @click="tab = 'data'"
                            :class="tab === 'data' ? 'border-l-4 border-[#800000] bg-slate-50 text-slate-900 font-semibold shadow-[inset_0_1px_2px_rgba(0,0,0,0.01)]' : 'border-l-4 border-transparent text-slate-500 hover:bg-slate-50/60'"
                            class="w-full flex items-center gap-4 px-4 py-3.5 rounded-r-2xl transition-all duration-300 text-left group">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors duration-300"
                             :class="tab === 'data' ? 'bg-[#800000]/10 text-[#800000]' : 'bg-slate-100 text-slate-400 group-hover:bg-slate-200 group-hover:text-slate-655'">
                            <span class="material-icons text-lg">person</span>
                        </div>
                        <div>
                            <p class="text-xs font-bold tracking-tight">Informasi Akun</p>
                            <p class="text-[9px] text-slate-400 font-medium mt-0.5">Ubah detail profil & data diri</p>
                        </div>
                    </button>

                    
                    <button @click="tab = 'password'"
                            :class="tab === 'password' ? 'border-l-4 border-[#800000] bg-slate-50 text-slate-900 font-semibold shadow-[inset_0_1px_2px_rgba(0,0,0,0.01)]' : 'border-l-4 border-transparent text-slate-500 hover:bg-slate-50/60'"
                            class="w-full flex items-center gap-4 px-4 py-3.5 rounded-r-2xl transition-all duration-300 text-left group">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors duration-300"
                             :class="tab === 'password' ? 'bg-[#800000]/10 text-[#800000]' : 'bg-slate-100 text-slate-400 group-hover:bg-slate-200 group-hover:text-slate-655'">
                            <span class="material-icons text-lg">lock</span>
                        </div>
                        <div>
                            <p class="text-xs font-bold tracking-tight">Keamanan</p>
                            <p class="text-[9px] text-slate-400 font-medium mt-0.5">Perbarui kata sandi akun Anda</p>
                        </div>
                    </button>

                    
                    <button @click="tab = 'riwayat'"
                            :class="tab === 'riwayat' ? 'border-l-4 border-[#800000] bg-slate-50 text-slate-900 font-semibold shadow-[inset_0_1px_2px_rgba(0,0,0,0.01)]' : 'border-l-4 border-transparent text-slate-500 hover:bg-slate-50/60'"
                            class="w-full flex items-center gap-4 px-4 py-3.5 rounded-r-2xl transition-all duration-300 text-left group">
                        <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors duration-300"
                             :class="tab === 'riwayat' ? 'bg-[#800000]/10 text-[#800000]' : 'bg-slate-100 text-slate-400 group-hover:bg-slate-200 group-hover:text-slate-655'">
                            <span class="material-icons text-lg">assignment</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-xs font-bold tracking-tight">Riwayat Reservasi</p>
                            <p class="text-[9px] text-slate-400 font-medium mt-0.5">Daftar pemesanan & slot lahan</p>
                        </div>
                    </button>

                    
                    <button @click="tab = 'sertifikat'"
                            :class="tab === 'sertifikat' ? 'border-l-4 border-[#800000] bg-slate-50 text-slate-900 font-semibold shadow-[inset_0_1px_2px_rgba(0,0,0,0.01)]' : 'border-l-4 border-transparent text-slate-500 hover:bg-slate-50/60'"
                            class="w-full flex items-center justify-between px-4 py-3.5 rounded-r-2xl transition-all duration-300 text-left group">
                        <div class="flex items-center gap-4 flex-1">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors duration-300"
                                 :class="tab === 'sertifikat' ? 'bg-[#800000]/10 text-[#800000]' : 'bg-slate-100 text-slate-400 group-hover:bg-slate-200 group-hover:text-slate-655'">
                                <span class="material-icons text-lg">workspace_premium</span>
                            </div>
                            <div>
                                <p class="text-xs font-bold tracking-tight">Sertifikat</p>
                                <p class="text-[9px] text-slate-400 font-medium mt-0.5">Unduh sertifikat lahan makam</p>
                            </div>
                        </div>
                        @if($lunasReservasis->count() > 0)
                            <span class="bg-[#800000] text-white text-[9px] font-bold px-2 py-0.5 rounded-full shadow-sm">{{ $lunasReservasis->count() }}</span>
                        @endif
                    </button>

                    
                    <button @click="tab = 'pembayaran'"
                            :class="tab === 'pembayaran' ? 'border-l-4 border-[#800000] bg-slate-50 text-slate-900 font-semibold shadow-[inset_0_1px_2px_rgba(0,0,0,0.01)]' : 'border-l-4 border-transparent text-slate-500 hover:bg-slate-50/60'"
                            class="w-full flex items-center justify-between px-4 py-3.5 rounded-r-2xl transition-all duration-300 text-left group">
                        <div class="flex items-center gap-4 flex-1">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center transition-colors duration-300"
                                 :class="tab === 'pembayaran' ? 'bg-[#800000]/10 text-[#800000]' : 'bg-slate-100 text-slate-400 group-hover:bg-slate-200 group-hover:text-slate-655'">
                                <span class="material-icons text-lg">payments</span>
                            </div>
                            <div>
                                <p class="text-xs font-bold tracking-tight">Pembayaran</p>
                                <p class="text-[9px] text-slate-400 font-medium mt-0.5">Tagihan aktif & riwayat transaksi</p>
                            </div>
                        </div>
                        @if($reservasiSiapBayar->count() > 0)
                            <span class="bg-amber-500 text-white text-[9px] font-bold px-2 py-0.5 rounded-full shadow-sm animate-pulse">{{ $reservasiSiapBayar->count() }}</span>
                        @endif
                    </button>

                </div>
            </div>

            
            <div class="lg:col-span-8">
                
                
                <div x-show="tab === 'data'" x-transition class="bg-white rounded-[2rem] border border-slate-100 p-6 md:p-8 shadow-[0_10px_30px_rgba(0,0,0,0.015)]">
                    <div class="mb-6 border-b border-slate-50 pb-4">
                        <h3 class="text-base font-bold text-slate-800">Informasi Pribadi</h3>
                        <p class="text-[10px] text-slate-400 mt-0.5">Kelola informasi kontak dan alamat domisili terdaftar Anda.</p>
                    </div>
                    
                    
                    <div class="flex flex-col sm:flex-row items-center gap-6 mb-8 border-b border-slate-100 pb-6">
                        <div class="relative w-24 h-24 shrink-0 group">
                            <div class="absolute inset-0 rounded-3xl bg-gradient-to-tr from-[#800000] to-[#c70000] p-[3px] shadow-md transition-transform duration-300 group-hover:scale-105">
                                <div class="w-full h-full rounded-[21px] overflow-hidden bg-slate-100 flex items-center justify-center font-bold text-4xl text-slate-800 relative">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/avatars/' . $user->avatar) }}" class="w-full h-full object-cover" alt="Foto Profil">
                                    @else
                                        <span class="text-[#800000]">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    @endif
                                </div>
                            </div>
                            <button type="button" onclick="document.getElementById('avatar-input').click()" 
                                    class="absolute -bottom-1 -right-1 w-8 h-8 rounded-xl bg-white text-slate-655 hover:text-[#800000] hover:bg-slate-50 shadow-md flex items-center justify-center transition-all border border-slate-100 active:scale-90">
                                <span class="material-icons text-base">photo_camera</span>
                            </button>
                        </div>
                        <div class="text-center sm:text-left space-y-2 flex-1">
                            <h4 class="text-xs font-bold text-slate-800">Foto Profil</h4>
                            <p class="text-[10px] text-slate-400 leading-relaxed max-w-[240px]">Format gambar yang didukung adalah JPEG atau PNG dengan kapasitas maksimal 2 MB.</p>
                            <div class="flex flex-wrap gap-2 justify-center sm:justify-start">
                                <button type="button" onclick="document.getElementById('avatar-input').click()" class="px-3.5 py-1.5 bg-[#800000] hover:bg-[#800000]/90 text-white rounded-xl text-xs font-bold transition-all shadow-sm">Upload Baru</button>
                                @if($user->avatar)
                                <button type="button" onclick="document.getElementById('delete-avatar-submit').click()" class="px-3.5 py-1.5 bg-white border border-slate-200 text-slate-650 hover:bg-slate-50 rounded-xl text-xs font-bold transition-all shadow-sm">Hapus</button>
                                @endif
                            </div>
                        </div>
                    </div>

                    
                    <form action="{{ route('profil.update') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('PATCH')
                        
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Nama Lengkap</label>
                            <div class="relative group">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-[#800000] transition-colors">
                                    <span class="material-icons text-base">person_outline</span>
                                </div>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-11 pr-12 py-3.5 text-xs text-slate-700 font-semibold focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all">
                                <span class="material-icons absolute right-4 top-1/2 -translate-y-1/2 text-slate-350 text-base">edit</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Alamat Email</label>
                            <div class="relative group">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-[#800000] transition-colors">
                                    <span class="material-icons text-base">mail_outline</span>
                                </div>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-11 pr-12 py-3.5 text-xs text-slate-700 font-semibold focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all">
                                <span class="material-icons absolute right-4 top-1/2 -translate-y-1/2 text-slate-350 text-base">edit</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">No. Telepon / WhatsApp</label>
                            <div class="relative group">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-[#800000] transition-colors">
                                    <span class="material-icons text-base">phone_iphone</span>
                                </div>
                                <input type="text" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}" placeholder="Belum diisi"
                                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-11 pr-12 py-3.5 text-xs text-slate-700 font-semibold focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all">
                                <span class="material-icons absolute right-4 top-1/2 -translate-y-1/2 text-slate-350 text-base">edit</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Alamat Domisili</label>
                            <div class="relative group">
                                <div class="absolute left-4 top-4 text-slate-400 group-focus-within:text-[#800000] transition-colors">
                                    <span class="material-icons text-base">place</span>
                                </div>
                                <textarea name="alamat" rows="3" placeholder="Belum diisi"
                                          class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-11 pr-12 py-3.5 text-xs text-slate-700 font-semibold focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all resize-none">{{ old('alamat', $user->alamat) }}</textarea>
                                <span class="material-icons absolute right-4 top-6 text-slate-350 text-base">edit</span>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full bg-gradient-to-r from-[#800000] to-[#990000] hover:shadow-lg text-white py-3.5 rounded-2xl font-bold text-xs tracking-wider uppercase transition-all shadow-md hover:-translate-y-0.5 active:translate-y-0 active:scale-[0.99]">
                                Perbarui Profil
                            </button>
                        </div>
                    </form>
                </div>

                
                <div x-show="tab === 'password'" style="display:none" x-transition class="bg-white rounded-[2rem] border border-slate-100 p-6 md:p-8 shadow-[0_10px_30px_rgba(0,0,0,0.015)]">
                    <div class="mb-6 border-b border-slate-50 pb-4">
                        <h3 class="text-base font-bold text-slate-800">Keamanan Akun</h3>
                        <p class="text-[10px] text-slate-400 mt-0.5">Ubah kata sandi Anda secara berkala untuk menjaga keamanan akun.</p>
                    </div>
                    
                    <form action="{{ route('profil.password') }}" method="POST" class="space-y-5" x-data="{ showCurr: false, showNew: false, showConf: false }">
                        @csrf
                        @method('PUT')

                        @if($user->password)
                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Password Saat Ini</label>
                            <div class="relative group">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-[#800000] transition-colors">
                                    <span class="material-icons text-base">lock_open</span>
                                </div>
                                <input :type="showCurr ? 'text' : 'password'" name="current_password" required
                                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-11 pr-12 py-3.5 text-xs text-slate-700 font-semibold focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all">
                                <button type="button" @click="showCurr = !showCurr" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-655 transition-colors">
                                    <span class="material-icons text-sm" x-text="showCurr ? 'visibility_off' : 'visibility'"></span>
                                </button>
                            </div>
                        </div>
                        @else
                        <div class="bg-amber-50/60 border border-amber-100 text-amber-800 p-4 rounded-2xl text-[11px] leading-relaxed font-semibold flex gap-2">
                            <span class="material-icons text-sm mt-0.5">info</span>
                            <div>
                                Anda terhubung menggunakan Google. Silakan langsung buat password baru di bawah ini untuk mengamankan login manual akun Anda.
                            </div>
                        </div>
                        @endif

                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Password Baru</label>
                            <div class="relative group">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-[#800000] transition-colors">
                                    <span class="material-icons text-base">lock_outline</span>
                                </div>
                                <input :type="showNew ? 'text' : 'password'" name="password" required
                                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-11 pr-12 py-3.5 text-xs text-slate-700 font-semibold focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all">
                                <button type="button" @click="showNew = !showNew" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-655 transition-colors">
                                    <span class="material-icons text-sm" x-text="showNew ? 'visibility_off' : 'visibility'"></span>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Konfirmasi Password Baru</label>
                            <div class="relative group">
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-[#800000] transition-colors">
                                    <span class="material-icons text-base">verified_user</span>
                                </div>
                                <input :type="showConf ? 'text' : 'password'" name="password_confirmation" required
                                       class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-11 pr-12 py-3.5 text-xs text-slate-700 font-semibold focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all">
                                <button type="button" @click="showConf = !showConf" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-655 transition-colors">
                                    <span class="material-icons text-sm" x-text="showConf ? 'visibility_off' : 'visibility'"></span>
                                </button>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full bg-gradient-to-r from-[#800000] to-[#990000] hover:shadow-lg text-white py-3.5 rounded-2xl font-bold text-xs tracking-wider uppercase transition-all shadow-md hover:-translate-y-0.5 active:translate-y-0 active:scale-[0.99]">
                                Update Password
                            </button>
                        </div>
                    </form>
                </div>

                
                <div x-show="tab === 'riwayat'" style="display:none" x-transition class="bg-white rounded-[2rem] border border-slate-100 shadow-[0_10px_30px_rgba(0,0,0,0.015)] overflow-hidden">
                    <div class="p-6 border-b border-slate-50">
                        <h3 class="text-base font-bold text-slate-800">Riwayat Reservasi</h3>
                        <p class="text-[10px] text-slate-400 mt-0.5">Pantau status reservasi lahan makam dan lengkapi data jenazah.</p>
                    </div>
                    
                    @if($riwayat->isEmpty())
                    <div class="py-16 text-center">
                        <span class="material-icons text-4xl text-slate-250 mb-2">assignment_late</span>
                        <p class="text-slate-400 font-bold text-xs">Belum ada riwayat reservasi</p>
                        <p class="text-[10px] text-slate-400 mt-1">Lakukan pemesanan lahan makam di halaman Masterplan.</p>
                    </div>
                    @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead class="bg-slate-50 text-[10px] font-bold uppercase text-slate-400 tracking-widest">
                                <tr>
                                    <th class="px-6 py-4">Lahan</th>
                                    <th class="px-6 py-4">Jenazah / Slot</th>
                                    <th class="px-6 py-4">Status Reservasi</th>
                                    <th class="px-6 py-4 text-right">Pembayaran</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-xs">
                                @foreach($riwayat as $r)
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-[#800000]/5 flex items-center justify-center text-[#800000] font-bold text-xs shrink-0">
                                                #{{ $r->lahan->nomor_lahan }}
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold text-slate-800">{{ $r->lahan->cluster->nama_cluster ?? '-' }}</p>
                                                <p class="text-[9px] font-semibold text-slate-400 mt-0.5">{{ $r->lahan->tipe_lahan }}</p>
                                            </div>
                                        </div>
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
                                                        <span class="px-1.5 py-0.5 bg-slate-100 text-slate-500 rounded-md text-[8px] font-bold">Slot {{ $slot }}</span>
                                                    @endif
                                                    @if($detail)
                                                        <span class="font-semibold text-slate-700">Alm. {{ ucwords(strtolower($detail->nama_jenazah)) }}</span>
                                                        @if($detail->status === 'Menunggu Validasi')
                                                            <span class="px-2 py-0.5 bg-amber-50 text-amber-700 border border-amber-200 rounded-md text-[9px] font-bold uppercase tracking-wider scale-95">Pending</span>
                                                        @elseif($detail->status === 'Disetujui')
                                                            <span class="px-2 py-0.5 bg-emerald-50 text-emerald-700 border border-emerald-250 rounded-md text-[9px] font-bold uppercase tracking-wider scale-95">Disetujui</span>
                                                        @elseif($detail->status === 'Ditolak')
                                                            <span class="px-2 py-0.5 bg-rose-50 text-rose-700 border border-rose-250 rounded-md text-[9px] font-bold uppercase tracking-wider scale-95">Ditolak</span>
                                                            <a href="{{ route('pembeli.reservasi.isi_slot_form', ['reservasi_id' => $r->id, 'nomor_slot' => $slot]) }}"
                                                               class="text-[#800000] hover:text-[#800000]/80 font-bold underline transition-colors text-[10px] ml-1">
                                                               Edit
                                                            </a>
                                                        @endif
                                                    @else
                                                        @if($canFill)
                                                            <a href="{{ route('pembeli.reservasi.isi_slot_form', ['reservasi_id' => $r->id, 'nomor_slot' => $slot]) }}"
                                                               class="inline-flex items-center gap-1 text-[#800000] hover:text-[#800000]/80 font-bold transition-colors text-[10px] border border-[#800000]/20 hover:border-[#800000] px-2.5 py-0.5 rounded-full bg-[#800000]/5 hover:bg-[#800000]/10">
                                                                <span class="material-icons text-[10px]">edit</span> Isi Data Diri
                                                            </a>
                                                        @else
                                                            <span class="text-slate-400 italic text-[10px] font-medium flex items-center gap-1">
                                                                <span class="material-icons text-[12px] text-slate-350">lock_outline</span> Belum terisi
                                                            </span>
                                                        @endif
                                                    @endif
                                                </div>
                                            @endfor
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                            @if($r->status_reservasi === 'Disetujui' || $r->status_reservasi === 'Selesai')
                                                bg-emerald-50 text-emerald-700 border border-emerald-200
                                            @elseif($r->status_reservasi === 'Ditolak')
                                                bg-rose-50 text-rose-700 border border-rose-200
                                            @else
                                                bg-slate-50 text-slate-600 border border-slate-200
                                            @endif">
                                            <span class="w-1.5 h-1.5 rounded-full 
                                                @if($r->status_reservasi === 'Disetujui' || $r->status_reservasi === 'Selesai')
                                                    bg-emerald-500
                                                @elseif($r->status_reservasi === 'Ditolak')
                                                    bg-rose-500
                                                @else
                                                    bg-slate-400
                                                @endif"></span>
                                            {{ $r->status_reservasi }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                            @if($r->status_pembayaran === 'Lunas')
                                                bg-emerald-50 text-emerald-700 border border-emerald-200
                                            @elseif($r->status_pembayaran === 'Belum Bayar')
                                                bg-amber-50 text-amber-700 border border-amber-200
                                            @else
                                                bg-blue-50 text-blue-700 border border-blue-200
                                            @endif">
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

                
                <div x-show="tab === 'sertifikat'" style="display:none" x-transition class="bg-white rounded-[2rem] border border-slate-100 p-6 md:p-8 shadow-[0_10px_30px_rgba(0,0,0,0.015)]">
                    <div class="mb-6 border-b border-slate-50 pb-4">
                        <h3 class="text-base font-bold text-slate-800">Sertifikat Hak Guna Lahan</h3>
                        <p class="text-[10px] text-slate-400 mt-0.5">Unduh dokumen sertifikat lahan pemakaman Anda yang telah diterbitkan oleh Marketing.</p>
                    </div>
                    
                    @if($lunasReservasis->isEmpty())
                    <div class="py-16 text-center border border-dashed border-slate-200 rounded-3xl bg-slate-50/50 p-8 max-w-lg mx-auto">
                        <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-amber-100">
                            <span class="material-icons text-2xl">workspace_premium</span>
                        </div>
                        <h3 class="text-xs font-bold text-slate-800 tracking-tight">Belum Ada Sertifikat Tersedia</h3>
                        <p class="text-[10px] text-slate-405 mt-2 leading-relaxed">
                            Sertifikat Hak Guna Lahan pemakaman akan diterbitkan di sini setelah reservasi Anda disetujui dan status pembayaran dikonfirmasi <strong>Lunas</strong> oleh tim Accounting.
                        </p>
                    </div>
                    @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($lunasReservasis as $r)
                        <div class="relative overflow-hidden bg-gradient-to-br from-slate-50 to-white p-6 rounded-2xl border border-slate-150 shadow-sm hover:shadow-md transition-all duration-300 flex flex-col justify-between group">
                            <!-- Medal icon watermark decoration in background -->
                            <div class="absolute -right-4 -bottom-4 text-slate-105 group-hover:text-slate-200 transition-colors pointer-events-none">
                                <span class="material-icons text-[120px] opacity-40">workspace_premium</span>
                            </div>
                            <div class="relative z-10">
                                <div class="flex items-center justify-between gap-2 mb-3">
                                    <span class="px-2 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider
                                        @if($r->file_sertifikat)
                                            bg-emerald-50 text-emerald-700 border border-emerald-250
                                        @else
                                            bg-amber-50 text-amber-700 border border-amber-250
                                        @endif">
                                        {{ $r->file_sertifikat ? 'Telah Diterbitkan' : 'Sedang Diproses' }}
                                    </span>
                                </div>
                                <h3 class="text-sm font-bold text-slate-800 tracking-tight mb-1">
                                    Lahan #{{ $r->lahan->nomor_lahan }}
                                </h3>
                                <p class="text-[10px] font-semibold text-slate-450 mb-4">
                                    {{ $r->lahan->cluster->nama_cluster ?? '-' }} &middot; {{ $r->lahan->tipe_lahan }}
                                </p>
                                <div class="bg-white/80 backdrop-blur-sm p-3 rounded-xl border border-slate-100/80 mb-4 text-[10px]">
                                    <div class="flex justify-between py-0.5">
                                        <span class="text-slate-450 font-semibold">Tipe:</span>
                                        <span class="text-slate-700 font-bold">{{ $r->lahan->tipe_lahan }}</span>
                                    </div>
                                    <div class="flex justify-between py-0.5">
                                        <span class="text-slate-455 font-semibold">
                                            @if($r->nama_jenazah) Jenazah: @else Pemegang Hak: @endif
                                        </span>
                                        <span class="text-slate-700 font-bold">
                                            @if($r->nama_jenazah) Alm. {{ ucwords(strtolower($r->nama_jenazah)) }} @else {{ ucwords(strtolower($user->name)) }} @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="relative z-10 mt-auto">
                                @if($r->file_sertifikat)
                                    <div class="grid grid-cols-2 gap-2">
                                        <a href="{{ route('document.sertifikat', $r->id) }}" target="_blank"
                                           class="w-full py-2 bg-[#800000] hover:bg-[#800000]/90 text-white rounded-xl font-bold text-[10px] text-center transition-all shadow-sm active:scale-95">Lihat Dokumen</a>
                                        <a href="{{ route('document.sertifikat', $r->id) }}?download=1"
                                           class="w-full py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 rounded-xl font-bold text-[10px] text-center transition-all shadow-sm active:scale-95">Unduh PDF</a>
                                    </div>
                                @else
                                    <div class="bg-amber-50/50 border border-amber-100/60 text-amber-800 p-3 rounded-xl text-[10px] font-semibold leading-relaxed text-center flex items-center gap-1.5 justify-center">
                                        <span class="material-icons text-sm text-amber-500 animate-spin">hourglass_top</span>
                                        Sertifikat sedang dalam proses penerbitan oleh tim Admin.
                                    </div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                
                <div x-show="tab === 'pembayaran'" style="display:none" x-transition class="space-y-6">
                    
                    
                    @if($reservasiSiapBayar->count() > 0)
                    <div class="bg-white rounded-[2rem] p-6 md:p-8 border-l-4 border-amber-500 shadow-[0_10px_30px_rgba(0,0,0,0.015)]">
                        <div class="flex items-center gap-2 mb-6">
                            <span class="material-icons text-amber-500 text-lg">warning_amber</span>
                            <h3 class="text-xs font-bold text-amber-600 uppercase tracking-widest">Tagihan Menunggu Pembayaran</h3>
                        </div>
                        <div class="space-y-4">
                            @foreach($reservasiSiapBayar as $res)
                            <div class="bg-amber-50/40 rounded-2xl p-4 flex flex-col md:flex-row md:items-center justify-between gap-4 border border-amber-100 shadow-[0_4px_12px_rgba(245,158,11,0.03)]">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-600 shrink-0">
                                        <span class="material-icons">receipt</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800">Lahan #{{ $res->lahan->nomor_lahan }}</p>
                                        <p class="text-[10px] font-semibold text-slate-450 mt-0.5">{{ $res->lahan->cluster->nama_cluster }} &middot; {{ $res->lahan->tipe_lahan }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-col md:flex-row md:items-center gap-4">
                                    <div class="md:text-right">
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">{{ $res->tipe_tagihan ?? 'Harus Dibayar' }}</p>
                                        <p class="text-base font-black text-[#800000] tracking-tight">Rp {{ number_format($res->nominal_tagihan ?? $res->lahan->harga, 0, ',', '.') }}</p>
                                    </div>
                                    <a href="{{ route('pembeli.pembayaran.create', ['reservasi_id' => $res->id]) }}"
                                       class="bg-gradient-to-r from-amber-500 to-amber-600 hover:shadow-lg text-white px-5 py-2.5 rounded-xl font-bold text-[10px] tracking-wider uppercase shadow-sm hover:-translate-y-0.5 active:translate-y-0 active:scale-95 text-center whitespace-nowrap transition-all">BAYAR SEKARANG</a>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    
                    <div class="bg-white rounded-[2rem] p-6 md:p-8 border border-slate-100 shadow-[0_10px_30px_rgba(0,0,0,0.015)]">
                        <div class="mb-6 border-b border-slate-50 pb-4">
                            <h3 class="text-base font-bold text-slate-800">Riwayat Pembayaran</h3>
                            <p class="text-[10px] text-slate-400 mt-0.5">Daftar seluruh transaksi pembayaran yang pernah diajukan.</p>
                        </div>
                        
                        @if($pembayarans->isEmpty())
                        <div class="py-12 text-center">
                            <span class="material-icons text-4xl text-slate-200 mb-2">payments</span>
                            <p class="text-slate-400 font-bold text-xs">Belum ada riwayat pembayaran</p>
                        </div>
                        @else
                        <div class="space-y-4">
                            @foreach($pembayarans as $bayar)
                            <div class="p-5 border border-slate-100 rounded-2xl bg-slate-50/20 hover:bg-white hover:shadow-md transition-all duration-300 relative group overflow-hidden">
                                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <p class="text-xs font-bold text-slate-800 tracking-tight">{{ $bayar->no_invoice }}</p>
                                            <span class="px-2 py-0.5 rounded text-[8px] font-bold uppercase tracking-wider
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
                                        <p class="text-[10px] font-semibold text-slate-500">
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
                                        <p class="text-[8px] font-semibold text-slate-400 flex items-center gap-1 mt-1">
                                            <span class="material-icons text-[10px]">schedule</span>
                                            {{ $bayar->created_at->translatedFormat('d M Y, H:i') }}
                                        </p>
                                    </div>
                                    <div class="flex flex-col sm:flex-row sm:items-center justify-between md:justify-end gap-4 shrink-0">
                                        <p class="text-sm font-black text-slate-800 tracking-tight text-right sm:min-w-[120px]">Rp {{ number_format($bayar->jumlah_bayar, 0, ',', '.') }}</p>
                                        <div class="flex gap-2">
                                            @if($bayar->status_pembayaran === 'Lunas')
                                            <a href="{{ route('pembeli.pembayaran.invoice', $bayar->id) }}"
                                               class="px-3.5 py-1.5 bg-[#800000] text-white rounded-lg font-bold text-[9px] tracking-wide uppercase hover:bg-[#800000]/90 transition-all text-center shadow-sm">Invoice</a>
                                            @endif
                                            @if($bayar->status_pembayaran === 'Ditolak')
                                            <a href="{{ route('pembeli.pembayaran.create', ['reservasi_id' => $bayar->reservasi_id]) }}"
                                               class="px-3.5 py-1.5 bg-rose-600 text-white rounded-lg font-bold text-[9px] tracking-wide uppercase hover:bg-rose-700 transition-all text-center shadow-sm">Kirim Ulang</a>
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
    

</script>
@endsection
