<div x-show="modalEdit" 
     x-transition.opacity
     class="fixed inset-0 z-[1000] flex items-center justify-center p-6 bg-slate-900/60 backdrop-blur-sm" 
     style="display:none">
    
    <div @click.away="modalEdit = false" 
         class="bg-white rounded-[3rem] w-full max-w-xl p-10 shadow-2xl animate-scaleIn">
        
        <h2 class="text-2xl font-black text-slate-900 mb-8 font-poppins">Update Profil</h2>

        <form action="{{ route('profil.update') }}" method="POST" class="space-y-5">
            @csrf @method('PATCH')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="field">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 font-bold text-sm focus:ring-2 focus:ring-primary/20">
                    @error('name')
                        <p class="text-rose-500 text-[10px] mt-2 font-bold ml-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="field">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">No. Telepon</label>
                    <input type="text" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 font-bold text-sm focus:ring-2 focus:ring-primary/20">
                    @error('no_telepon')
                        <p class="text-rose-500 text-[10px] mt-2 font-bold ml-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="field">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 font-bold text-sm focus:ring-2 focus:ring-primary/20">
                @error('email')
                    <p class="text-rose-500 text-[10px] mt-2 font-bold ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="field">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Alamat Domisili</label>
                <textarea name="alamat" rows="3" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 font-bold text-sm focus:ring-2 focus:ring-primary/20 resize-none">{{ old('alamat', $user->alamat) }}</textarea>
                @error('alamat')
                    <p class="text-rose-500 text-[10px] mt-2 font-bold ml-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-1 bg-[#800000] text-white py-5 rounded-2xl font-black text-xs tracking-widest uppercase shadow-xl shadow-primary/30">SIMPAN</button>
                <button type="button" @click="modalEdit = false" class="px-8 py-5 bg-slate-100 text-slate-500 rounded-2xl font-black text-xs uppercase tracking-widest">BATAL</button>
            </div>
        </form>
    </div>
</div>
