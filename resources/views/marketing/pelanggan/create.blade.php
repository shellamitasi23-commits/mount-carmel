<div id="createModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-sm flex items-center justify-center transition-opacity">
    <div class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl transform scale-100 transition-transform overflow-hidden m-4 max-h-[90vh] overflow-y-auto">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50 sticky top-0 z-10">
            <h3 class="text-lg font-bold text-slate-800">Tambah Akun Pembeli</h3>
            <button type="button" onclick="closeModal()" class="text-slate-400 hover:text-red-500"><span class="material-icons-outlined">close</span></button>
        </div>
        <form action="{{ route('marketing.pembeli.store') }}" method="POST">
            @csrf
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required placeholder="Contoh: Budi Santoso" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none text-sm focus:border-blue-500 focus:ring-2">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Alamat Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" required placeholder="budi@example.com" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none text-sm focus:border-blue-500 focus:ring-2">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Nomor WhatsApp/Telepon</label>
                    <input type="text" name="no_telepon" placeholder="Contoh: 081234567890" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none text-sm focus:border-blue-500 focus:ring-2">
                </div>
                <div class="md:col-span-2" x-data="{ showP: false }">
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Password <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input :type="showP ? 'text' : 'password'" name="password" required placeholder="Minimal 8 karakter" 
                               class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl outline-none text-sm focus:border-blue-500 focus:ring-2 pr-12">
                        <button type="button" @click="showP = !showP" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors">
                            <span class="material-icons-outlined text-sm" x-text="showP ? 'visibility_off' : 'visibility'"></span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-slate-100 bg-slate-50 flex justify-end gap-3 sticky bottom-0">
                <button type="button" onclick="closeModal()" class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">Batal</button>
                <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-[#800000] hover:bg-[#800000]/80 rounded-xl shadow-md transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-user-plus text-xs"></i> Simpan Pembeli
                </button>
            </div>
        </form>
    </div>
</div>
