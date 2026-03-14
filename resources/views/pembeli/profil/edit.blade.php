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
                    <input type="text" name="name" value="{{ $user->name }}" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 font-bold text-sm focus:ring-2 focus:ring-primary/20">
                </div>
                <div class="field">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">No. Telepon</label>
                    <input type="text" name="no_telepon" value="{{ $user->no_telepon }}" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 font-bold text-sm focus:ring-2 focus:ring-primary/20">
                </div>
            </div>

            <div class="field">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Alamat Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 font-bold text-sm focus:ring-2 focus:ring-primary/20">
            </div>

            <div class="field">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-1">Alamat Domisili</label>
                <textarea name="alamat" rows="3" class="w-full bg-slate-50 border-none rounded-2xl px-5 py-4 font-bold text-sm focus:ring-2 focus:ring-primary/20 resize-none">{{ $user->alamat }}</textarea>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-1 bg-primary text-white py-5 rounded-2xl font-black text-xs tracking-widest uppercase shadow-xl shadow-primary/30">SIMPAN</button>
                <button type="button" @click="modalEdit = false" class="px-8 py-5 bg-slate-100 text-slate-500 rounded-2xl font-black text-xs uppercase tracking-widest">BATAL</button>
            </div>
        </form>
    </div>
</div>