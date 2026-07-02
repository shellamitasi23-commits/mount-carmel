<div x-show="modalEdit" 
     x-transition.opacity
     class="fixed inset-0 z-[1000] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" 
     style="display:none">
    
    <div @click.away="modalEdit = false" 
         class="bg-white rounded-3xl w-full max-w-lg p-6 md:p-8 shadow-xl animate-scaleIn">
        
        <h2 class="text-xl font-bold text-slate-850 mb-6">Update Profil</h2>

        <form action="{{ route('profil.update') }}" method="POST" class="space-y-4">
            @csrf @method('PATCH')
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="text-xs font-medium text-slate-500 mb-1.5 block">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                           class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all">
                    @error('name')
                        <p class="text-rose-500 text-[10px] mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="text-xs font-medium text-slate-500 mb-1.5 block">No. Telepon</label>
                    <input type="text" name="no_telepon" value="{{ old('no_telepon', $user->no_telepon) }}" 
                           class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all">
                    @error('no_telepon')
                        <p class="text-rose-500 text-[10px] mt-1.5 font-medium">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label class="text-xs font-medium text-slate-500 mb-1.5 block">Alamat Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" 
                       class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all">
                @error('email')
                    <p class="text-rose-500 text-[10px] mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="text-xs font-medium text-slate-500 mb-1.5 block">Alamat Domisili</label>
                <textarea name="alamat" rows="3" 
                          class="w-full bg-slate-50/50 border border-slate-200 rounded-xl px-4 py-2.5 text-sm text-slate-700 focus:bg-white focus:border-[#800000] focus:ring-4 focus:ring-[#800000]/5 outline-none transition-all resize-none">{{ old('alamat', $user->alamat) }}</textarea>
                @error('alamat')
                    <p class="text-rose-500 text-[10px] mt-1.5 font-medium">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 bg-[#800000] text-white py-2.5 rounded-xl font-semibold text-xs shadow-sm hover:bg-[#800000]/90 transition-all">Simpan</button>
                <button type="button" @click="modalEdit = false" class="px-6 py-2.5 bg-slate-100 text-slate-500 hover:bg-slate-200 rounded-xl font-semibold text-xs transition-all">Batal</button>
            </div>
        </form>
    </div>
</div>
