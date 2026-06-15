<div x-show="modalPass" 
     x-transition.opacity
     class="fixed inset-0 z-[1000] flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-sm" 
     style="display:none">
    
    <div @click.away="modalPass = false" 
         class="bg-white rounded-[3rem] w-full max-w-md p-10 shadow-2xl animate-scaleIn">
        
        <h2 class="text-2xl font-black text-slate-900 mb-8 font-poppins text-center">Keamanan</h2>

        <form action="{{ route('profil.password') }}" method="POST" class="space-y-6" x-data="{ showCurr: false, showNew: false, showConf: false }">
            @csrf @method('PUT')
            
            @if($user->password)
            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Password Saat Ini</label>
                <div class="relative">
                    <input :type="showCurr ? 'text' : 'password'" name="current_password" required
                           class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 font-bold text-sm focus:ring-2 focus:ring-primary/20 pr-14">
                    <button type="button" @click="showCurr = !showCurr" class="absolute right-5 bottom-4 text-slate-300">
                        <span class="material-icons text-sm" x-text="showCurr ? 'visibility_off' : 'visibility'"></span>
                    </button>
                </div>
                @error('current_password') <p class="text-rose-500 text-[10px] mt-2 font-bold">{{ $message }}</p> @enderror
            </div>
            @else
            <div class="bg-amber-50 border border-amber-200 text-amber-800 p-6 rounded-2xl text-xs font-bold leading-relaxed mb-4">
                Anda terhubung menggunakan Google. Silakan langsung buat password baru di bawah ini untuk mengamankan login manual akun Anda.
            </div>
            @endif

            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Password Baru</label>
                <div class="relative">
                    <input :type="showNew ? 'text' : 'password'" name="password" required
                           class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 font-bold text-sm focus:ring-2 focus:ring-primary/20 pr-14">
                    <button type="button" @click="showNew = !showNew" class="absolute right-5 bottom-4 text-slate-300">
                        <span class="material-icons text-sm" x-text="showNew ? 'visibility_off' : 'visibility'"></span>
                    </button>
                </div>
                @error('password') <p class="text-rose-500 text-[10px] mt-2 font-bold">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Konfirmasi Password Baru</label>
                <div class="relative">
                    <input :type="showConf ? 'text' : 'password'" name="password_confirmation" required
                           class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 font-bold text-sm focus:ring-2 focus:ring-primary/20 pr-14">
                    <button type="button" @click="showConf = !showConf" class="absolute right-5 bottom-4 text-slate-300">
                        <span class="material-icons text-sm" x-text="showConf ? 'visibility_off' : 'visibility'"></span>
                    </button>
                </div>
            </div>

            <button type="submit" class="w-full bg-[#800000] text-white py-5 rounded-[1.5rem] font-black text-xs tracking-widest shadow-xl uppercase">Update Password</button>
        </form>
    </div>
</div>
