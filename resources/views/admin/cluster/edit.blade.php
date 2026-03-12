<div id="editModal{{ $cluster->id }}" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center transition-opacity">
    
    <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl transform scale-100 transition-transform overflow-hidden m-4">
        
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50">
            <h3 class="text-lg font-bold text-slate-800">Edit Data Cluster</h3>
            <button type="button" onclick="closeEditModal({{ $cluster->id }})" class="text-slate-400 hover:text-red-500 transition-colors">
                <span class="material-icons-outlined">close</span>
            </button>
        </div>

        <form action="{{ route('admin.cluster.update', $cluster->id) }}" method="POST">
            @csrf
            @method('PUT') <div class="p-6 space-y-5">
                
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Nama Cluster <span class="text-red-500">*</span></label>
                    <input type="text" name="nama_cluster" value="{{ $cluster->nama_cluster }}" required 
                           class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition-all outline-none text-sm text-slate-700">
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Kategori Zona <span class="text-red-500">*</span></label>
                    <select name="kategori" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition-all outline-none text-sm text-slate-700 appearance-none">
                        <option value="Muslim" {{ $cluster->kategori == 'Muslim' ? 'selected' : '' }}>Muslim</option>
                        <option value="Non-Muslim" {{ $cluster->kategori == 'Non-Muslim' ? 'selected' : '' }}>Non-Muslim</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Deskripsi Fasilitas</label>
                    <textarea name="deskripsi" rows="3" 
                              class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-600/20 focus:border-blue-600 transition-all outline-none text-sm text-slate-700 resize-none">{{ $cluster->deskripsi }}</textarea>
                </div>

            </div>

            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end gap-3">
                <button type="button" onclick="closeEditModal({{ $cluster->id }})" class="px-5 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-200 bg-slate-100 rounded-xl transition-colors">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md transition-colors flex items-center gap-2">
                    <span class="material-icons-outlined text-sm">save</span> Simpan Perubahan
                </button>
            </div>
        </form>

    </div>
</div>