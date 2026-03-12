<div id="createModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center transition-opacity">
    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl transform scale-100 transition-transform overflow-hidden m-4 max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50 sticky top-0 z-10">
            <h3 class="text-lg font-bold text-slate-800">Tambah Kavling Baru</h3>
            <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-red-500"><span class="material-icons-outlined">close</span></button>
        </div>
        <form action="{{ route('admin.kavling.store') }}" method="POST">
            @csrf
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Pilih Cluster <span class="text-red-500">*</span></label>
                    <select name="cluster_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:border-blue-600 outline-none text-sm">
                        <option value="" disabled selected>-- Pilih Cluster --</option>
                        @foreach($clusters as $cluster)
                            <option value="{{ $cluster->id }}">{{ $cluster->nama_cluster }} ({{ $cluster->kategori }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Nomor Kavling <span class="text-red-500">*</span></label>
                    <input type="text" name="nomor_kavling" required placeholder="Contoh: KV-M01" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:border-blue-600 outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Tipe Kavling <span class="text-red-500">*</span></label>
                    <input type="text" name="tipe_kavling" required placeholder="Contoh: Fitrah / VIP" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:border-blue-600 outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Ukuran <span class="text-red-500">*</span></label>
                    <input type="text" name="ukuran" required placeholder="Contoh: 4m x 3m" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:border-blue-600 outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Kapasitas (Orang) <span class="text-red-500">*</span></label>
                    <input type="number" name="kapasitas" required placeholder="Contoh: 2" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:border-blue-600 outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" name="harga" required placeholder="Contoh: 150000000" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:border-blue-600 outline-none text-sm">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Status <span class="text-red-500">*</span></label>
                    <select name="status" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:border-blue-600 outline-none text-sm">
                        <option value="Tersedia">Tersedia</option>
                        <option value="Dipesan">Dipesan</option>
                        <option value="Terjual">Terjual</option>
                    </select>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end gap-3 sticky bottom-0">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl">Batal</button>
                <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-slate-900 hover:bg-slate-800 rounded-xl shadow-md">Simpan Data</button>
            </div>
        </form>
    </div>
</div>