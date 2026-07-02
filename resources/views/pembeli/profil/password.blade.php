<div x-show="modalPass" 
     x-transition.opacity
     class="fixed inset-0 z-[1000] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" 
     style="display:none">
    
    <div @click.away="modalPass = false" 
         class="bg-white rounded-3xl w-full max-w-md p-6 md:p-8 shadow-xl animate-scaleIn">
        
        <h2 class="text-xl font-bold text-slate-850 mb-6 text-center">Ganti Password</h2>

        <form action="{{ route('profil.password') }}" method="POST" class="space-y-4" x-data="{ showCurr: false, showNew: false, showConf: false }">
            @csrf @method('PUT')
            
            @if($user->password)
            <div>
                <label class="text-xs font-medium text-slate-500 mb-1.5 block">Password Saat Ini</label>
                <div class="relative">
                    <input :type="showCurr ? 'text' : 'password'" name="current_password" required
                           class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all pr-12">
                    <button type="button" @click="showCurr = !showCurr" class="absolute right-4 bottom-3 text-slate-300 hover:text-slate-500">
                        <span class="material-icons text-sm" x-text="showCurr ? 'visibility_off' : 'visibility'"></span>
                    </button>
                </div>
                @error('current_password') <p class="text-rose-500 text-[10px] mt-1.5 font-medium">{{ $message }}</p> @enderror
            </div>
            @else
            <div class="bg-amber-50 border border-amber-200 text-amber-800 p-4 rounded-xl text-xs leading-relaxed mb-4 font-medium">
                Anda terhubung menggunakan Google. Silakan langsung buat password baru di bawah ini untuk mengamankan login manual akun Anda.
            </div>
            @endif

            <div>
                <label class="text-xs font-medium text-slate-500 mb-1.5 block">Password Baru</label>
                <div class="relative">
                    <input :type="showNew ? 'text' : 'password'" name="password" required
                           class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all pr-12">
                    <button type="button" @click="showNew = !showNew" class="absolute right-4 bottom-3 text-slate-300 hover:text-slate-500">
                        <span class="material-icons text-sm" x-text="showNew ? 'visibility_off' : 'visibility'"></span>
                    </button>
                </div>
                @error('password') <p class="text-rose-500 text-[10px] mt-1.5 font-medium">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-xs font-medium text-slate-500 mb-1.5 block">Konfirmasi Password Baru</label>
                <div class="relative">
                    <input :type="showConf ? 'text' : 'password'" name="password_confirmation" required
                           class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all pr-12">
                    <button type="button" @click="showConf = !showConf" class="absolute right-4 bottom-3 text-slate-300 hover:text-slate-500">
                        <span class="material-icons text-sm" x-text="showConf ? 'visibility_off' : 'visibility'"></span>
                    </button>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="flex-1 bg-[#800000] text-white py-2.5 rounded-xl font-semibold text-xs shadow-sm hover:bg-[#800000]/90 transition-all">Update Password</button>
                <button type="button" @click="modalPass = false" class="px-6 py-2.5 bg-slate-100 text-slate-500 hover:bg-slate-200 rounded-xl font-semibold text-xs transition-all">Batal</button>
            </div>
        </form>
    </div>
</div>
