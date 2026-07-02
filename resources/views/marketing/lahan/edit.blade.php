<div id="editModal{{ $lahan->id }}" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center transition-opacity">
    <div class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl transform scale-100 transition-transform overflow-hidden m-4 max-h-[90vh] overflow-y-auto border border-slate-100">
        <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50 sticky top-0 z-10">
            <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Edit Data Lahan</h3>
            <button type="button" onclick="closeEditModal({{ $lahan->id }})" class="text-slate-400 hover:text-red-500 transition-colors">
                <span class="material-icons-outlined">close</span>
            </button>
        </div>
        <form action="{{ route('marketing.lahan.update', $lahan->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Pilih Cluster <span class="text-red-500">*</span></label>
                    <select name="cluster_id" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-4 focus:ring-slate-900/5 outline-none text-sm font-bold appearance-none transition-all">
                        @foreach($clusters as $cluster)
                            <option value="{{ $cluster->id }}" {{ $lahan->cluster_id == $cluster->id ? 'selected' : '' }}>{{ $cluster->nama_cluster }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tipe Lahan <span class="text-red-500">*</span></label>
                    <select id="edit_tipe_lahan_{{ $lahan->id }}" name="tipe_lahan" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-4 focus:ring-slate-900/5 outline-none text-sm font-bold appearance-none transition-all">
                        @foreach($master_lahan as $tipe => $data)
                            <option value="{{ $tipe }}" {{ $lahan->tipe_lahan == $tipe ? 'selected' : '' }}>{{ $tipe }}</option>
                        @endforeach
                        <option value="Custom" {{ !array_key_exists($lahan->tipe_lahan, $master_lahan) ? 'selected' : '' }}>-- Tipe Lain (Manual) --</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Hadap Lahan <span class="text-red-500">*</span></label>
                    <select id="edit_hadap_{{ $lahan->id }}" name="hadap" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-4 focus:ring-slate-900/5 outline-none text-sm font-bold appearance-none transition-all">
                        @php 
                            $options = $master_lahan[$lahan->tipe_lahan]['hadap_options'] ?? [$lahan->hadap]; 
                        @endphp
                        @foreach($options as $opt)
                            <option value="{{ $opt }}" {{ $lahan->hadap == $opt ? 'selected' : '' }}>{{ $opt }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nomor Lahan <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_nomor_lahan_{{ $lahan->id }}" name="nomor_lahan" value="{{ $lahan->nomor_lahan }}" required 
                           class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-4 focus:ring-slate-900/5 outline-none text-sm font-bold transition-all">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Ukuran <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_ukuran_{{ $lahan->id }}" name="ukuran" value="{{ $lahan->ukuran }}" required 
                           class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-4 focus:ring-slate-900/5 outline-none text-sm font-bold transition-all">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kapasitas (Orang) <span class="text-red-500">*</span></label>
                    <input type="number" id="edit_kapasitas_{{ $lahan->id }}" name="kapasitas" value="{{ $lahan->kapasitas }}" required 
                           class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-4 focus:ring-slate-900/5 outline-none text-sm font-bold transition-all">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" id="edit_harga_{{ $lahan->id }}" name="harga" value="{{ (int)$lahan->harga }}" required 
                           class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-4 focus:ring-slate-900/5 outline-none text-sm font-bold transition-all">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Status <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-4 focus:ring-slate-900/5 outline-none text-sm font-bold appearance-none transition-all">
                        <option value="Tersedia" {{ $lahan->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="Reservasi (Lunas)" {{ $lahan->status == 'Reservasi (Lunas)' ? 'selected' : '' }}>Reservasi (Lunas)</option>
                        <option value="Reservasi Cicilan dengan DP" {{ $lahan->status == 'Reservasi Cicilan dengan DP' ? 'selected' : '' }}>Reservasi Cicilan dengan DP</option>
                        <option value="Digunakan" {{ $lahan->status == 'Digunakan' ? 'selected' : '' }}>Digunakan</option>
                    </select>
                </div>
            </div>
            <div class="px-8 py-6 border-t border-slate-100 bg-slate-50 flex justify-end gap-3 sticky bottom-0">
                <button type="button" onclick="closeEditModal({{ $lahan->id }})" class="px-6 py-3 text-[10px] font-black uppercase tracking-widest text-slate-500 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">Batal</button>
                <button type="submit" class="px-6 py-3 text-[10px] font-black uppercase tracking-widest text-white bg-[#800000] hover:bg-[#800000]/90 rounded-xl shadow-lg active:scale-95 transition-all">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
