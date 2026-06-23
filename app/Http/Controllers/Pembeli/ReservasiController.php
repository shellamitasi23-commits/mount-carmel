<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Lahan;

class ReservasiController extends Controller
{
    /**
     * index() = RIWAYAT semua reservasi milik user
     * Dipanggil dari navbar klik "Reservasi"
     * URL: GET /pembeli/reservasi  (TANPA parameter)
     */
    public function index(Request $request)
    {
        // Jika ada lahan_id di URL, redirect ke create form
        if ($request->has('lahan_id')) {
            return redirect()->route('pembeli.reservasi.create', ['lahan_id' => $request->lahan_id]);
        }

        $reservasis = Reservasi::with(['lahan.cluster', 'pembayaran', 'pembayarans', 'detailJenazahs'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('pembeli.reservasi.index', compact('reservasis'));
    }

    /**
     * create() = FORM isi data jenazah sebelum simpan
     * Dipanggil setelah klik "Pesan Lahan Ini" di halaman nomorlahan
     * URL: GET /pembeli/reservasi/create?lahan_id=5
     */
    public function create(Request $request)
    {
        $request->validate([
            'lahan_id' => 'required|exists:lahans,id',
        ]);

        $lahan = Lahan::with('cluster')->findOrFail($request->lahan_id);

        // Cek lahan masih tersedia
        if ($lahan->status !== 'Tersedia') {
            return redirect()
                ->route('pembeli.lahan.nomor', [
                    'cluster_id' => $lahan->cluster_id,
                    'tipe_lahan' => $lahan->tipe_lahan,
                ])
                ->with('error', 'Lahan #' . $lahan->nomor_lahan . ' sudah tidak tersedia. Silakan pilih nomor lain.');
        }

        $user = auth()->user();
        $marketingStaff = \App\Models\User::where('role', 'marketing')->orderBy('name')->get();

        return view('pembeli.reservasi.create', compact('lahan', 'user', 'marketingStaff'));
    }

    /**
     * store() = SIMPAN data reservasi lalu redirect ke form pembayaran
     * URL: POST /pembeli/reservasi
     */
    public function store(Request $request)
    {
        $request->validate([
            'lahan_id' => 'required|exists:lahans,id',
            'kategori_kebutuhan' => 'required|in:end_user,pre_need',
            'nama_jenazah' => 'required_if:kategori_kebutuhan,end_user|nullable|string|max:255',
            'tanggal_dimakamkan' => 'required_if:kategori_kebutuhan,end_user|nullable|date|after_or_equal:today',
            'alamat_pemesan' => 'required|string',
            'dokumen_ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'metode_pembayaran' => 'required|in:tunai,cicilan_dp',
            'nominal_dp' => 'required_if:metode_pembayaran,cicilan_dp|nullable|numeric',
            'kontak_kerabat' => 'nullable|string|max:255',
            'request_tambahan' => 'nullable|string',
            'biaya_tambahan' => 'nullable|numeric|min:0',
            'marketing_oleh' => 'nullable|string|max:255',
        ], [
            'alamat_pemesan.required' => 'Alamat pemesan wajib diisi.',
            'dokumen_ktp.required' => 'Dokumen KTP wajib diunggah.',
            'metode_pembayaran.required' => 'Metode pembayaran wajib dipilih.',
            'nama_jenazah.required_if' => 'Nama lengkap jenazah wajib diisi untuk kebutuhan segera.',
            'tanggal_dimakamkan.required_if' => 'Rencana tanggal pemakaman wajib diisi untuk kebutuhan segera.',
            'nominal_dp.required_if' => 'Nominal DP wajib diisi untuk metode cicilan dengan DP.',
        ]);

        // Cek ulang lahan masih tersedia (cegah race condition)
        $lahan = Lahan::findOrFail($request->lahan_id);
        if ($lahan->status !== 'Tersedia') {
            return back()->with('error', 'Maaf, lahan ini baru saja dipesan orang lain. Silakan pilih nomor lain.');
        }

        // Kategori kebutuhan & metode pembayaran rule check
        if ($request->kategori_kebutuhan === 'end_user' && $request->metode_pembayaran !== 'tunai') {
            return back()->withErrors(['metode_pembayaran' => 'Pembayaran untuk kebutuhan segera (end-user) wajib menggunakan metode Tunai.'])->withInput();
        }

        // Hitung biaya tambahan & biaya penuh
        $biayaTambahan = 0;
        $requestTambahan = null;
        if (str_contains(strtolower($lahan->tipe_lahan), 'special')) {
            $biayaTambahan = floatval($request->input('biaya_tambahan', 0));
            $requestTambahan = $request->input('request_tambahan');
        }
        $biayaPenuh = $lahan->harga + $biayaTambahan;

        // Tentukan tenor & DP
        $metode = $request->metode_pembayaran;
        if ($metode === 'tunai') {
            $tenor = 1;
            $biayaReservasi = $biayaPenuh;
            $jenisPembayaran = 'tunai';
            $statusLahan = 'Reservasi (Lunas)';
        } else { // cicilan_dp
            $tenor = 12; // Jangka panjang pre-need = 12 bulan
            $biayaReservasi = $lahan->harga * 0.2; // DP otomatis 20% dari harga lahan cash
            $jenisPembayaran = 'cicilan';
            $statusLahan = 'Reservasi Cicilan dengan DP';
        }

        // Upload KTP
        $ktpPath = $request->file('dokumen_ktp')->store('dokumen_reservasi', 'public');

        // Simpan reservasi
        $reservasi = Reservasi::create([
            'user_id' => auth()->id(),
            'lahan_id' => $request->lahan_id,
            'kategori_kebutuhan' => $request->kategori_kebutuhan,
            'nama_jenazah' => $request->nama_jenazah ?? null,
            'tanggal_reservasi' => now()->toDateString(),
            'tanggal_dimakamkan' => $request->tanggal_dimakamkan ?? null,
            'alamat_pemesan' => $request->alamat_pemesan,
            'dokumen_ktp' => $ktpPath,
            'status_reservasi' => 'Menunggu Validasi',
            'status_pembayaran' => 'Belum Bayar',
            'jenis_pembayaran' => $jenisPembayaran,
            'tenor_cicilan' => $tenor,
            'biaya_reservasi' => $biayaReservasi,
            'biaya_penuh' => $biayaPenuh,
            'kontak_kerabat' => $request->kontak_kerabat,
            'request_tambahan' => $requestTambahan,
            'biaya_tambahan' => $biayaTambahan,
            'marketing_oleh' => $request->marketing_oleh,
        ]);

        // Kunci lahan agar tidak bisa dipesan orang lain
        $lahan->update(['status' => $statusLahan]);

        // Redirect ke konfirmasi pesanan
        return redirect()
            ->route('pembeli.reservasi.konfirmasi', ['id' => $reservasi->id])
            ->with('success', 'Data reservasi berhasil disimpan! Silakan periksa kembali detail pesanan Anda.');
    }

    /**
     * Tampilkan halaman konfirmasi pesanan (review) sebelum lanjut ke transfer pembayaran
     * URL: GET /pembeli/reservasi/{id}/konfirmasi
     */
    public function konfirmasi($id)
    {
        $reservasi = Reservasi::with(['lahan.cluster', 'user'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('pembeli.reservasi.konfirmasi', compact('reservasi'));
    }

    /**
     * Tampilkan form untuk mengisi data diri pada slot tertentu
     */
    public function isiSlotForm($reservasi_id, $nomor_slot)
    {
        $reservasi = Reservasi::with(['lahan.cluster', 'detailJenazahs'])
            ->where('user_id', auth()->id())
            ->findOrFail($reservasi_id);

        $lahan = $reservasi->lahan;
        $kapasitas = $lahan->kapasitas;

        // Validasi nomor slot
        if ($nomor_slot < 1 || $nomor_slot > $kapasitas) {
            return redirect()->route('pembeli.reservasi.index')->with('error', 'Nomor slot tidak valid.');
        }

        // Cek status reservasi & pembayaran
        $statusBayar = $reservasi->status_pembayaran;
        $statusRes = $reservasi->status_reservasi;
        $isPaid = ($statusBayar === 'Lunas' || $statusBayar === 'DP Lunas' || str_contains($statusBayar, 'Lunas'));
        
        if (($statusRes !== 'Disetujui' && $statusRes !== 'Selesai') || !$isPaid) {
            return redirect()->route('pembeli.reservasi.index')->with('error', 'Data slot hanya dapat diisi setelah reservasi disetujui dan pembayaran terverifikasi.');
        }

        // Cek apakah slot sudah terisi (kecuali jika statusnya Ditolak)
        $slotTerisi = $reservasi->detailJenazahs->where('nomor_slot', $nomor_slot)->first();
        if ($slotTerisi && $slotTerisi->status !== 'Ditolak') {
            return redirect()->route('pembeli.reservasi.index')->with('error', 'Slot #' . $nomor_slot . ' sudah terisi.');
        }

        $existingDetail = $slotTerisi;

        return view('pembeli.reservasi.isi_slot', compact('reservasi', 'lahan', 'nomor_slot', 'existingDetail'));
    }

    /**
     * Simpan data diri jenazah ke detail_jenazahs
     */
    public function simpanSlot(Request $request, $reservasi_id, $nomor_slot)
    {
        $reservasi = Reservasi::with(['lahan', 'detailJenazahs'])
            ->where('user_id', auth()->id())
            ->findOrFail($reservasi_id);

        $lahan = $reservasi->lahan;
        $kapasitas = $lahan->kapasitas;

        // Validasi nomor slot
        if ($nomor_slot < 1 || $nomor_slot > $kapasitas) {
            return redirect()->route('pembeli.reservasi.index')->with('error', 'Nomor slot tidak valid.');
        }

        // Cek status reservasi & pembayaran
        $statusBayar = $reservasi->status_pembayaran;
        $statusRes = $reservasi->status_reservasi;
        $isPaid = ($statusBayar === 'Lunas' || $statusBayar === 'DP Lunas' || str_contains($statusBayar, 'Lunas'));
        
        if (($statusRes !== 'Disetujui' && $statusRes !== 'Selesai') || !$isPaid) {
            return redirect()->route('pembeli.reservasi.index')->with('error', 'Data slot hanya dapat diisi setelah reservasi disetujui dan pembayaran terverifikasi.');
        }

        // Cek apakah slot sudah terisi (kecuali jika statusnya Ditolak)
        $slotTerisi = $reservasi->detailJenazahs->where('nomor_slot', $nomor_slot)->first();
        if ($slotTerisi && $slotTerisi->status !== 'Ditolak') {
            return redirect()->route('pembeli.reservasi.index')->with('error', 'Slot #' . $nomor_slot . ' sudah terisi.');
        }

        $request->validate([
            'nama_jenazah' => 'required|string|max:255',
            'tanggal_dimakamkan' => 'nullable|date|after_or_equal:today',
        ], [
            'nama_jenazah.required' => 'Nama lengkap jenazah wajib diisi.',
            'tanggal_dimakamkan.after_or_equal' => 'Rencana tanggal pemakaman tidak boleh di masa lalu.',
        ]);

        if ($slotTerisi) {
            // Edit data yang ditolak
            $slotTerisi->update([
                'nama_jenazah' => $request->nama_jenazah,
                'tanggal_dimakamkan' => $request->tanggal_dimakamkan,
                'status' => 'Menunggu Validasi', // Reset status kembali ke pending
            ]);
        } else {
            // Simpan baru
            \App\Models\DetailJenazah::create([
                'reservasi_id' => $reservasi->id,
                'nomor_slot' => $nomor_slot,
                'nama_jenazah' => $request->nama_jenazah,
                'tanggal_dimakamkan' => $request->tanggal_dimakamkan,
                'status' => 'Menunggu Validasi',
            ]);
        }

        // Sinkronisasi ke tabel reservasis jika nomor_slot == 1 (untuk backward compatibility,
        // kita set ke null dulu di reservasi utama agar admin tahu ini sedang dalam status pending validasi baru)
        if ($nomor_slot == 1) {
            $reservasi->update([
                'nama_jenazah' => null,
                'tanggal_dimakamkan' => null,
            ]);
        }

        // Jika semua slot sudah terisi penuh
        $totalTerisi = \App\Models\DetailJenazah::where('reservasi_id', $reservasi->id)->count();
        if ($totalTerisi >= $kapasitas) {
            $lahan->update(['status' => 'Digunakan']);
        }

        return redirect()->route('pembeli.reservasi.index')->with('success', 'Data diri jenazah untuk slot #' . $nomor_slot . ' berhasil dikirimkan ke Marketing untuk divalidasi.');
    }
}