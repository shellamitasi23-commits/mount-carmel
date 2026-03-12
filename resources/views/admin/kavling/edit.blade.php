<div id="editModal{{ $kavling->id }}" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center transition-opacity">
    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl transform scale-100 transition-transform overflow-hidden m-4 max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50 sticky top-0 z-10">
            <h3 class="text-lg font-bold text-slate-800">Edit Data Kavling</h3>
            <button type="button" onclick="closeEditModal({{ $kavling->id }})" class="text-slate-400 hover:text-red-500"><span class="material-icons-outlined">close</span></button>
        </div>
        <form action="{{ route('admin.kavling.update', $kavling->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Pilih Cluster <span class="text-red-500">*</span></label>
                    <select name="cluster_id" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:border-blue-600 outline-none text-sm">
                        @foreach($clusters as $cluster)
                            <option value="{{ $cluster->id }}" {{ $kavling->cluster_id == $cluster->id ? 'selected' : '' }}>{{ $cluster->nama_cluster }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Nomor Kavling</label>
                    <input type="text" name="nomor_kavling" value="{{ $kavling->nomor_kavling }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:border-blue-600 outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Tipe Kavling</label>
                    <input type="text" name="tipe_kavling" value="{{ $kavling->tipe_kavling }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:border-blue-600 outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Ukuran</label>
                    <input type="text" name="ukuran" value="{{ $kavling->ukuran }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:border-blue-600 outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Kapasitas</label>
                    <input type="number" name="kapasitas" value="{{ $kavling->kapasitas }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:border-blue-600 outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Harga (Rp)</label>
                    <input type="number" name="harga" value="{{ $kavling->harga }}" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:border-blue-600 outline-none text-sm">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Status</label>
                    <select name="status" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:border-blue-600 outline-none text-sm">
                        <option value="Tersedia" {{ $kavling->status == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="Dipesan" {{ $kavling->status == 'Dipesan' ? 'selected' : '' }}>Dipesan</option>
                        <option value="Terjual" {{ $kavling->status == 'Terjual' ? 'selected' : '' }}>Terjual</option>
                    </select>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end gap-3 sticky bottom-0">
                <button type="button" onclick="closeEditModal({{ $kavling->id }})" class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl">Batal</button>
                <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>