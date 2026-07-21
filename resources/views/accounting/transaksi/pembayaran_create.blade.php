@extends('layouts.admin')
@section('title', 'Input Pembayaran Langsung - Mount Carmel')

@section('content')
<div class="mb-8">
    <div class="flex items-center gap-3">
        <a href="{{ route('accounting.pembayaran.index') }}" class="text-slate-400 hover:text-slate-900 transition-colors">
            <span class="material-icons-outlined text-2xl">arrow_back</span>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Input Pembayaran Langsung</h1>
            <p class="text-sm text-slate-500 mt-1">Catat transaksi pembayaran baru secara langsung ke dalam sistem.</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="paymentInput()">
    <!-- Form Input -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm p-6 md:p-8">
        <form action="{{ route('accounting.pembayaran.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <div>
                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Pilih Reservasi Pembeli <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <select name="reservasi_id" required x-model="selectedReservasiId" @change="calculatePaymentDetails()"
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none text-sm font-bold appearance-none transition-all cursor-pointer">
                        <option value="" disabled selected>-- Pilih Reservasi --</option>
                        @foreach($reservasis as $rs)
                            <option value="{{ $rs->id }}">
                                {{ $rs->user->name }} — Unit #{{ $rs->lahan->nomor_lahan }} ({{ $rs->lahan->cluster->nama_cluster }})
                            </option>
                        @endforeach
                    </select>
                    <span class="material-icons-outlined absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">expand_more</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Tanggal Pembayaran <span class="text-rose-500">*</span></label>
                    <input type="date" name="tanggal_bayar" required value="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none text-sm font-bold transition-all">
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Nominal Pembayaran (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" name="jumlah_bayar" required x-model="jumlahBayar" placeholder="Contoh: 15000000"
                           class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none text-sm font-bold transition-all">
                </div>
            </div>

            <div class="border-t border-slate-50 pt-6">
                <h3 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Detail Rekening Penerima</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    @foreach($rekening as $idx => $rek)
                    <label class="border border-slate-200 rounded-xl p-4 flex flex-col justify-between cursor-pointer hover:bg-slate-50/50 transition-all relative">
                        <input type="radio" name="rekening_tujuan_select" value="{{ $rek['bank'] }}|{{ $rek['nomor'] }}" 
                               @change="selectRekening('{{ $rek['bank'] }}', '{{ $rek['nomor'] }}')"
                               class="absolute top-4 right-4 text-[#800000] focus:ring-[#800000]">
                        <div>
                            <p class="font-bold text-slate-800 uppercase text-xs">{{ $rek['bank'] }} Account</p>
                            <p class="text-xs font-black text-slate-900 tracking-tight mt-1">{{ $rek['nomor'] }}</p>
                        </div>
                        <p class="text-[10px] text-slate-400 font-medium mt-2">a.n. {{ $rek['atas_nama'] }}</p>
                    </label>
                    @endforeach
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Bank Penerima</label>
                        <input type="text" name="nama_bank" x-model="namaBank" required placeholder="Contoh: BCA"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none text-sm font-bold transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Nomor Rekening Penerima</label>
                        <input type="text" name="rekening_tujuan" x-model="rekeningTujuan" required placeholder="Contoh: 8890123456"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none text-sm font-bold transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Atas Nama Pengirim <span class="text-rose-500">*</span></label>
                        <input type="text" name="atas_nama_rekening" required x-model="atasNama" placeholder="Nama pemilik rekening pengirim"
                               class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none text-sm font-bold transition-all">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2">Catatan Internal (Opsional)</label>
                <textarea name="catatan" rows="3" placeholder="Masukkan catatan khusus atau keterangan pembayaran..."
                          class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-4 focus:ring-slate-900/5 focus:border-slate-900 outline-none text-sm font-medium resize-none transition-all"></textarea>
            </div>

            <div class="border-t border-slate-50 pt-6 flex justify-end gap-3">
                <a href="{{ route('accounting.pembayaran.index') }}" 
                   class="px-6 py-3 text-[10px] font-black uppercase tracking-widest text-slate-500 bg-slate-100 hover:bg-slate-200 rounded-xl transition-all">
                    Batal
                </a>
                <button type="submit" 
                        class="px-6 py-3 text-[10px] font-black uppercase tracking-widest text-white bg-[#800000] hover:bg-[#800000]/90 rounded-xl shadow-lg active:scale-95 transition-all">
                    Simpan Pembayaran
                </button>
            </div>
        </form>
    </div>

    <!-- Informasi / Keterangan Tagihan -->
    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex flex-col justify-between h-fit sticky top-6">
        <div>
            <h3 class="text-sm font-bold text-slate-800 mb-4 border-b border-slate-50 pb-2">Informasi Tagihan Reservasi</h3>
            
            <template x-if="!selectedReservasi">
                <div class="py-12 text-center text-slate-350">
                    <span class="material-icons-outlined text-4xl mb-2">info</span>
                    <p class="text-xs font-bold uppercase tracking-wider">Pilih Reservasi Dahulu</p>
                </div>
            </template>

            <template x-if="selectedReservasi">
                <div class="space-y-4">
                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Pembeli / Pemesan</p>
                        <p class="text-sm font-bold text-slate-800 mt-0.5" x-text="selectedReservasi.user.name"></p>
                        <p class="text-[10px] text-slate-400 font-bold" x-text="selectedReservasi.user.email"></p>
                    </div>

                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Detail Lahan</p>
                        <p class="text-sm font-bold text-slate-800 mt-0.5" x-text="'UNIT #' + selectedReservasi.lahan.nomor_lahan"></p>
                        <p class="text-[10px] text-slate-400 font-bold" x-text="selectedReservasi.lahan.cluster.nama_cluster + ' (' + selectedReservasi.lahan.tipe_lahan + ')'"></p>
                    </div>

                    <div>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Metode Pembayaran</p>
                        <span class="inline-block px-2.5 py-0.5 rounded text-[8px] font-black uppercase tracking-wider mt-1"
                              :class="selectedReservasi.jenis_pembayaran === 'tunai' ? 'bg-indigo-50 text-indigo-600' : 'bg-amber-50 text-amber-600'"
                              x-text="selectedReservasi.jenis_pembayaran === 'tunai' ? 'Tunai / Full' : 'Cicilan (' + selectedReservasi.tenor_cicilan + 'x)'">
                        </span>
                    </div>

                    <div class="border-t border-slate-50 pt-4 space-y-2">
                        <div class="flex justify-between text-xs">
                            <span class="text-slate-400 font-semibold">Total Biaya Unit</span>
                            <span class="font-bold text-slate-800" x-text="formatRupiah(selectedReservasi.biaya_penuh || selectedReservasi.lahan.harga)"></span>
                        </div>
                        <template x-if="selectedReservasi.jenis_pembayaran === 'cicilan'">
                            <div class="flex justify-between text-xs">
                                <span class="text-slate-400 font-semibold">Uang Muka / DP</span>
                                <span class="font-bold text-slate-800" x-text="formatRupiah(selectedReservasi.biaya_reservasi)"></span>
                            </div>
                        </template>
                        <div class="flex justify-between text-xs border-b border-slate-50 pb-2">
                            <span class="text-slate-400 font-semibold">Total Terbayar</span>
                            <span class="font-bold text-emerald-600" x-text="formatRupiah(totalTerbayar)"></span>
                        </div>
                        <div class="flex justify-between text-xs pt-1">
                            <span class="text-slate-400 font-bold uppercase tracking-wide">Sisa Tagihan</span>
                            <span class="font-black text-[#800000]" x-text="formatRupiah(sisaTagihan)"></span>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <template x-if="selectedReservasi">
            <div class="mt-6 bg-[#800000]/5 border border-[#800000]/10 rounded-xl p-4">
                <p class="text-[9px] font-black text-[#800000] uppercase tracking-widest leading-none mb-1">Target Transaksi Ini</p>
                <p class="text-xs font-black text-slate-800" x-text="tipePembayaranText"></p>
                <p class="text-[10px] text-slate-400 font-bold mt-1" x-text="'Nominal default: ' + formatRupiah(jumlahBayar)"></p>
            </div>
        </template>
    </div>
</div>

<script>
    const reservasisData = @json($reservasis);

    function paymentInput() {
        return {
            selectedReservasiId: '',
            selectedReservasi: null,
            jumlahBayar: '',
            namaBank: '',
            rekeningTujuan: '',
            atasNama: '',
            totalTerbayar: 0,
            sisaTagihan: 0,
            tipePembayaranText: '',

            calculatePaymentDetails() {
                this.selectedReservasi = reservasisData.find(r => r.id == this.selectedReservasiId);
                if (!this.selectedReservasi) return;

                const res = this.selectedReservasi;
                this.atasNama = res.user.name;

                // Hitung total terbayar sebelumnya
                this.totalTerbayar = res.pembayarans
                    .filter(p => p.status_pembayaran === 'Lunas')
                    .reduce((sum, p) => sum + parseFloat(p.jumlah_bayar), 0);

                const totalBiaya = parseFloat(res.biaya_penuh || res.lahan.harga);
                this.sisaTagihan = totalBiaya - this.totalTerbayar;

                const isTunai = res.jenis_pembayaran === 'tunai';
                const tenor = parseInt(res.tenor_cicilan) || 1;
                const dp = parseFloat(res.biaya_reservasi) || 0;

                if (isTunai) {
                    this.jumlahBayar = totalBiaya;
                    this.tipePembayaranText = 'Pembayaran Penuh / Pelunasan Tunai';
                } else {
                    const menggunakanDP = dp > 0;
                    if (menggunakanDP) {
                        const dpLunas = res.pembayarans.some(p => p.cicilan_ke === 0 && p.status_pembayaran === 'Lunas');
                        if (!dpLunas) {
                            this.jumlahBayar = dp;
                            this.tipePembayaranText = 'Pembayaran Uang Muka / DP';
                        } else {
                            const highestLunas = res.pembayarans
                                .filter(p => p.status_pembayaran === 'Lunas' && p.cicilan_ke > 0)
                                .reduce((max, p) => Math.max(max, parseInt(p.cicilan_ke)), 0);
                            const nextCicilan = highestLunas + 1;
                            this.jumlahBayar = (totalBiaya - dp) / tenor;
                            this.tipePembayaranText = `Cicilan Ke-${nextCicilan} dari ${tenor}`;
                        }
                    } else {
                        const highestLunas = res.pembayarans
                            .filter(p => p.status_pembayaran === 'Lunas' && p.cicilan_ke > 0)
                            .reduce((max, p) => Math.max(max, parseInt(p.cicilan_ke)), 0);
                        const nextCicilan = highestLunas + 1;
                        this.jumlahBayar = totalBiaya / tenor;
                        this.tipePembayaranText = `Cicilan Ke-${nextCicilan} dari ${tenor}`;
                    }
                }
            },

            selectRekening(bank, nomor) {
                this.namaBank = bank;
                this.rekeningTujuan = nomor;
            },

            formatRupiah(value) {
                return 'Rp ' + parseFloat(value).toLocaleString('id-ID');
            }
        }
    }
</script>
@endsection
