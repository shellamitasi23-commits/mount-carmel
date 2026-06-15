<div id="createModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center transition-opacity">
    <div class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl transform scale-100 transition-transform overflow-hidden m-4 max-h-[90vh] overflow-y-auto border border-slate-100">
        <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50 sticky top-0 z-10">
            <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Tambah Lahan Baru</h3>
            <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-red-500 transition-colors">
                <span class="material-icons-outlined">close</span>
            </button>
        </div>
        <form action="{{ route('marketing.lahan.store') }}" method="POST">
            @csrf
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Pilih Cluster <span class="text-red-500">*</span></label>
                    <select name="cluster_id" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-4 focus:ring-slate-900/5 outline-none text-sm font-bold appearance-none transition-all">
                        <option value="" disabled selected>-- Pilih Cluster --</option>
                        @foreach($clusters as $cluster)
                            <option value="{{ $cluster->id }}">{{ $cluster->nama_cluster }} ({{ $cluster->kategori }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Tipe Lahan <span class="text-red-500">*</span></label>
                    <select id="create_tipe_lahan" name="tipe_lahan" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-4 focus:ring-slate-900/5 outline-none text-sm font-bold appearance-none transition-all">
                        <option value="" disabled selected>-- Pilih Tipe Lahan --</option>
                        @foreach($master_lahan as $tipe => $data)
                            <option value="{{ $tipe }}">{{ $tipe }}</option>
                        @endforeach
                        <option value="Custom">-- Tipe Lain (Manual) --</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Hadap Lahan <span class="text-red-500">*</span></label>
                    <select id="create_hadap" name="hadap" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-4 focus:ring-slate-900/5 outline-none text-sm font-bold appearance-none transition-all">
                        <option value="" disabled selected>-- Pilih Tipe Dahulu --</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Nomor Lahan <span class="text-red-500">*</span></label>
                    <input type="text" id="create_nomor_lahan" name="nomor_lahan" required placeholder="Contoh: A-001" 
                           class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-4 focus:ring-slate-900/5 outline-none text-sm font-bold transition-all">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Ukuran <span class="text-red-500">*</span></label>
                    <input type="text" id="create_ukuran" name="ukuran" required placeholder="Contoh: 4m x 3m" 
                           class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-4 focus:ring-slate-900/5 outline-none text-sm font-bold transition-all">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Kapasitas (Orang) <span class="text-red-500">*</span></label>
                    <input type="number" id="create_kapasitas" name="kapasitas" required placeholder="Contoh: 2" 
                           class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-4 focus:ring-slate-900/5 outline-none text-sm font-bold transition-all">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" id="create_harga" name="harga" required placeholder="Contoh: 60000000" 
                           class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-4 focus:ring-slate-900/5 outline-none text-sm font-bold transition-all">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2">Status <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full px-5 py-3 bg-slate-50 border border-slate-100 rounded-xl focus:ring-4 focus:ring-slate-900/5 outline-none text-sm font-bold appearance-none transition-all">
                        <option value="Tersedia">Tersedia</option>
                        <option value="Dipesan">Dipesan</option>
                        <option value="Terjual">Terjual</option>
                    </select>
                </div>
            </div>
            <div class="px-8 py-6 border-t border-slate-100 bg-slate-50 flex justify-end gap-3 sticky bottom-0">
                <button type="button" onclick="closeModal()" class="px-6 py-3 text-[10px] font-black uppercase tracking-widest text-slate-500 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">Batal</button>
                <button type="submit" class="px-6 py-3 text-[10px] font-black uppercase tracking-widest text-white bg-[#800000] hover:bg-[#800000]/90 rounded-xl shadow-lg active:scale-95 transition-all">Simpan Lahan</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const masterLahan = @json($master_lahan);
    const tipeSelect = document.getElementById('create_tipe_lahan');
    const hadapSelect = document.getElementById('create_hadap');
    const nomorInput = document.getElementById('create_nomor_lahan');
    const ukuranInput = document.getElementById('create_ukuran');
    const kapasitasInput = document.getElementById('create_kapasitas');
    const hargaInput = document.getElementById('create_harga');

    if (tipeSelect) {
        tipeSelect.addEventListener('change', function() {
            const selected = this.value;
            hadapSelect.innerHTML = '<option value="" disabled selected>-- Pilih Hadap --</option>';
            
            if (selected && masterLahan[selected]) {
                const data = masterLahan[selected];
                ukuranInput.value = data.ukuran;
                kapasitasInput.value = data.kapasitas;
                hargaInput.value = data.harga;
                
                data.hadap_options.forEach(opt => {
                    const o = document.createElement('option');
                    o.value = opt;
                    o.textContent = opt;
                    hadapSelect.appendChild(o);
                });

                if (data.hadap_options.length === 1) {
                    hadapSelect.value = data.hadap_options[0];
                    updateNomorSuggestion(data.hadap_options[0]);
                }
            } else if (selected === 'Custom') {
                hadapSelect.innerHTML = '<option value="Custom">Custom</option>';
                ukuranInput.value = '';
                kapasitasInput.value = '';
                hargaInput.value = '';
                nomorInput.value = '';
            }
        });

        hadapSelect.addEventListener('change', function() {
            updateNomorSuggestion(this.value);
        });
    }

    function updateNomorSuggestion(hadap) {
        if (!hadap) return;
        let prefix = hadap.charAt(0).toUpperCase(); 
        nomorInput.value = prefix + '-';
        nomorInput.focus();
    }
});
</script>
