<div id="progresModal{{ $lahan->id }}" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm hidden flex items-center justify-center z-50 p-6">
    <div class="bg-white rounded-xl w-full max-w-lg shadow-2xl overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <div>
                <h3 class="text-lg font-black text-slate-800 tracking-tight">Update Progres Bangunan</h3>
                <p class="text-xs text-slate-500 font-medium">Lahan #{{ $lahan->nomor_lahan }} ({{ $lahan->cluster->nama_cluster }})</p>
            </div>
            <button onclick="closeProgresModal({{ $lahan->id }})" class="text-slate-400 hover:text-rose-500 transition-colors">
                <span class="material-icons-outlined">close</span>
            </button>
        </div>

        <form action="{{ route('koordinator_lapangan.lahan.updateProgres', $lahan->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            @csrf
            @method('PUT')

            @if($lahan->foto_progres)
            <div class="mb-4 border border-slate-200 rounded-xl overflow-hidden">
                <img src="{{ asset('storage/' . $lahan->foto_progres) }}" alt="Progres Lahan" class="w-full h-48 object-cover">
                <div class="p-2 bg-slate-50 text-center text-xs font-medium text-slate-500">
                    Foto Progres Saat Ini
                </div>
            </div>
            @endif

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Upload Foto Terbaru <span class="text-rose-500">*</span></label>
                <input type="file" name="foto_progres" accept="image/*" required
                       class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-slate-900/5 outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#800000] file:text-white hover:file:bg-[#800000]/90">
                <p class="text-[10px] text-slate-400 mt-1">Maksimal 5MB. Format JPG/PNG.</p>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Catatan Progres <span class="text-slate-300 font-normal">(Opsional)</span></label>
                <textarea name="catatan_progres" rows="3" placeholder="Deskripsikan pekerjaan yang sedang dilakukan..."
                          class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-slate-900/5 outline-none">{{ $lahan->catatan_progres }}</textarea>
            </div>

            <div class="pt-2 flex gap-3">
                <button type="button" onclick="closeProgresModal({{ $lahan->id }})" class="flex-1 px-5 py-2.5 bg-slate-100 text-slate-600 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">
                    Batal
                </button>
                <button type="submit" class="flex-1 bg-[#800000] text-white px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-[#800000]/90 transition-all shadow-md">
                    Simpan Progres
                </button>
            </div>
        </form>
    </div>
</div>
