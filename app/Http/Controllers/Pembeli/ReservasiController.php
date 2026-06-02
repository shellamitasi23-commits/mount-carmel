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

        $reservasis = Reservasi::with(['lahan.cluster', 'pembayaran'])
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

        return view('pembeli.reservasi.create', compact('lahan', 'user'));
    }

    /**
     * store() = SIMPAN data reservasi lalu redirect ke form pembayaran
     * URL: POST /pembeli/reservasi
     */
    public function store(Request $request)
    {
        $request->validate([
            'lahan_id' => 'required|exists:lahans,id',
            'nama_jenazah' => 'nullable|string|max:255',
            'tanggal_dimakamkan' => 'nullable|date|after_or_equal:today',
            'alamat_pemesan' => 'required|string',
            'dokumen_ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'metode_pembayaran' => 'required|in:tunai,cicilan',
            'tenor_cicilan' => 'required_if:metode_pembayaran,cicilan|nullable|integer|min:1|max:24',
            'kontak_kerabat' => 'nullable|string|max:255',
        ], [
            'alamat_pemesan.required' => 'Alamat pemesan wajib diisi.',
            'dokumen_ktp.required' => 'Dokumen KTP wajib diunggah.',
            'metode_pembayaran.required' => 'Metode pembayaran wajib dipilih.',
            'tenor_cicilan.required_if' => 'Tenor cicilan wajib dipilih jika Anda memilih metode cicilan.',
        ]);

        // Cek ulang lahan masih tersedia (cegah race condition)
        $lahan = Lahan::findOrFail($request->lahan_id);
        if ($lahan->status !== 'Tersedia') {
            return back()->with('error', 'Maaf, lahan ini baru saja dipesan orang lain. Silakan pilih nomor lain.');
        }

        // Hitung biaya
        $biayaPenuh = $lahan->harga ?? 10000000;
        
        // Jika tunai, tenor = 1, DP = harga penuh. Jika cicilan, DP = 20%
        $isTunai = $request->metode_pembayaran === 'tunai';
        $tenor = $isTunai ? 1 : $request->tenor_cicilan;
        $biayaReservasi = $isTunai ? $biayaPenuh : ($biayaPenuh * 0.2);

        // Upload KTP
        $ktpPath = $request->file('dokumen_ktp')->store('dokumen_reservasi', 'public');

        // Simpan reservasi
        $reservasi = Reservasi::create([
            'user_id' => auth()->id(),
            'lahan_id' => $request->lahan_id,
            'nama_jenazah' => $request->nama_jenazah ?? null,
            'tanggal_reservasi' => now()->toDateString(),
            'tanggal_dimakamkan' => $request->tanggal_dimakamkan ?? null,
            'alamat_pemesan' => $request->alamat_pemesan,
            'dokumen_ktp' => $ktpPath,
            'status_reservasi' => 'Menunggu Validasi',
            'status_pembayaran' => 'Belum Bayar',
            'jenis_pembayaran' => $request->metode_pembayaran,
            'tenor_cicilan' => $tenor,
            'biaya_reservasi' => $biayaReservasi,
            'biaya_penuh' => $biayaPenuh,
            'kontak_kerabat' => $request->kontak_kerabat,
        ]);

        // Kunci lahan agar tidak bisa dipesan orang lain
        $lahan->update(['status' => 'Dipesan']);

        // Redirect ke form pembayaran
        return redirect()
            ->route('pembeli.pembayaran.create', ['reservasi_id' => $reservasi->id])
            ->with('success', 'Reservasi berhasil dibuat! Silakan lanjutkan pembayaran DP.');
    }
}