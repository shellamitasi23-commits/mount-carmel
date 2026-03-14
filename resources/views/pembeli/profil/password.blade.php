<div x-show="modalPass" 
     x-transition.opacity
     class="fixed inset-0 z-[1000] flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-sm" 
     style="display:none">
    
    <div @click.away="modalPass = false" 
         class="bg-white rounded-[3rem] w-full max-w-md p-10 shadow-2xl animate-scaleIn">
        
        <h2 class="text-2xl font-black text-slate-900 mb-8 font-poppins text-center">Keamanan</h2>

        <form action="{{ route('profil.password') }}" method="POST" class="space-y-6">
            @csrf @method('PUT')
            
            <div class="relative">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Password Baru</label>
                <input :type="showP ? 'text' : 'password'" name="password" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 font-bold text-sm focus:ring-2 focus:ring-primary/20 pr-14">
                <button type="button" @click="showP = !showP" class="absolute right-5 bottom-4 text-slate-300">
                    <span class="material-icons text-sm" x-text="showP ? 'visibility_off' : 'visibility'"></span>
                </button>
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white py-5 rounded-[1.5rem] font-black text-xs tracking-widest shadow-xl uppercase">Update Password</button>
        </form>
    </div>
</div>