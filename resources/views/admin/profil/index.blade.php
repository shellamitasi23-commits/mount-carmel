@extends('layouts.admin')

@section('title', 'Profil Saya - Mount Carmel')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@200..800&display=swap" rel="stylesheet">
<style>
    body { font-family: 'Plus Jakarta Sans', sans-serif !important; }
</style>
@endpush

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="mb-10">
        <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight uppercase">Pengaturan Profil</h1>
        <p class="text-sm text-slate-500 mt-1">Kelola informasi akun dan preferensi keamanan Anda.</p>
    </div>

    @if(session('success'))
    <div class="mb-8 bg-emerald-50 border border-emerald-100 text-emerald-700 px-6 py-4 rounded-2xl flex items-center gap-3">
        <span class="material-icons-outlined">check_circle</span>
        <span class="text-sm font-bold uppercase tracking-tight">{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        {{-- Kiri: Info Dasar --}}
        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white p-8 rounded-3xl shadow-sm border border-slate-100 text-center">
                <div class="relative inline-block mb-6">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0f172a&color=fff&size=200" 
                         class="w-32 h-32 rounded-full object-cover border-4 border-slate-50 shadow-xl mx-auto" alt="Avatar">
                </div>
                <h3 class="text-lg font-black text-slate-900 uppercase tracking-tight">{{ $user->name }}</h3>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] mt-1">{{ str_replace('_', ' ', $user->role) }}</p>
                
                <div class="mt-8 pt-8 border-t border-slate-50 space-y-4 text-left">
                    <div class="flex items-center gap-3 text-slate-500">
                        <span class="material-icons-outlined text-sm">email</span>
                        <span class="text-xs font-bold">{{ $user->email }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-slate-500">
                        <span class="material-icons-outlined text-sm">phone</span>
                        <span class="text-xs font-bold">{{ $user->no_telepon ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kanan: Forms --}}
        <div class="lg:col-span-2 space-y-8">
            {{-- Update Profil --}}
            <div class="bg-white p-10 rounded-3xl shadow-sm border border-slate-100">
                <div class="flex items-center gap-2 mb-8">
                    <span class="material-icons-outlined text-slate-400">badge</span>
                    <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest">Informasi Personal</h4>
                </div>
                <form action="{{ route('admin.profil.update') }}" method="POST" class="space-y-6">
                    @csrf @method('PATCH')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full bg-slate-50 border border-slate-100 rounded-xl px-5 py-3 text-sm font-bold focus:ring-4 focus:ring-slate-900/5 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full bg-slate-50 border border-slate-100 rounded-xl px-5 py-3 text-sm font-bold focus:ring-4 focus:ring-slate-900/5 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nomor Telepon</label>
                            <input type="text" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}"
                                   class="w-full bg-slate-50 border border-slate-100 rounded-xl px-5 py-3 text-sm font-bold focus:ring-4 focus:ring-slate-900/5 outline-none transition-all">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Alamat Rumah</label>
                            <input type="text" name="alamat" value="{{ old('alamat', $user->alamat) }}"
                                   class="w-full bg-slate-50 border border-slate-100 rounded-xl px-5 py-3 text-sm font-bold focus:ring-4 focus:ring-slate-900/5 outline-none transition-all">
                        </div>
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="bg-slate-900 text-white px-8 py-4 rounded-xl text-[10px] font-black uppercase tracking-[0.3em] hover:bg-black transition-all shadow-xl shadow-slate-200 active:scale-95">
                            Perbarui Profil
                        </button>
                    </div>
                </form>
            </div>

            {{-- Update Password --}}
            <div class="bg-white p-10 rounded-3xl shadow-sm border border-slate-100">
                <div class="flex items-center gap-2 mb-8">
                    <span class="material-icons-outlined text-slate-400">lock_reset</span>
                    <h4 class="text-xs font-black text-slate-800 uppercase tracking-widest">Keamanan Akun</h4>
                </div>
                <form action="{{ route('admin.profil.password') }}" method="POST" class="space-y-6" x-data="{ showCurr: false, showNew: false, showConf: false }">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kata Sandi Saat Ini</label>
                        <div class="relative">
                            <input :type="showCurr ? 'text' : 'password'" name="current_password" required
                                   class="w-full bg-slate-50 border border-slate-100 rounded-xl px-5 py-3 text-sm font-bold focus:ring-4 focus:ring-slate-900/5 outline-none transition-all pr-12">
                            <button type="button" @click="showCurr = !showCurr" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                                <span class="material-icons-outlined text-sm" x-text="showCurr ? 'visibility_off' : 'visibility'"></span>
                            </button>
                        </div>
                        @error('current_password') <p class="text-rose-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kata Sandi Baru</label>
                            <div class="relative">
                                <input :type="showNew ? 'text' : 'password'" name="password" required
                                       class="w-full bg-slate-50 border border-slate-100 rounded-xl px-5 py-3 text-sm font-bold focus:ring-4 focus:ring-slate-900/5 outline-none transition-all pr-12">
                                <button type="button" @click="showNew = !showNew" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                                    <span class="material-icons-outlined text-sm" x-text="showNew ? 'visibility_off' : 'visibility'"></span>
                                </button>
                            </div>
                            @error('password') <p class="text-rose-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Konfirmasi Kata Sandi</label>
                            <div class="relative">
                                <input :type="showConf ? 'text' : 'password'" name="password_confirmation" required
                                       class="w-full bg-slate-50 border border-slate-100 rounded-xl px-5 py-3 text-sm font-bold focus:ring-4 focus:ring-slate-900/5 outline-none transition-all pr-12">
                                <button type="button" @click="showConf = !showConf" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                                    <span class="material-icons-outlined text-sm" x-text="showConf ? 'visibility_off' : 'visibility'"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="bg-slate-900 text-white px-8 py-4 rounded-xl text-[10px] font-black uppercase tracking-[0.3em] hover:bg-black transition-all shadow-xl shadow-slate-200 active:scale-95">
                            Ganti Kata Sandi
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
