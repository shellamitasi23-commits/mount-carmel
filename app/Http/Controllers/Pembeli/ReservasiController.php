<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Kavling;

class ReservasiController extends Controller
{
    /**
     * index() = RIWAYAT semua reservasi milik user
     * Dipanggil dari navbar klik "Reservasi"
     * URL: GET /pembeli/reservasi  (TANPA parameter)
     */
    public function index(Request $request)
    {
        // Jika ada kavling_id di URL, redirect ke create form
        if ($request->has('kavling_id')) {
            return redirect()->route('pembeli.reservasi.create', ['kavling_id' => $request->kavling_id]);
        }

        $reservasis = Reservasi::with(['kavling.cluster', 'pembayaran'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('pembeli.reservasi.index', compact('reservasis'));
    }

    /**
     * create() = FORM isi data jenazah sebelum simpan
     * Dipanggil setelah klik "Pesan Kavling Ini" di halaman nomorkavling
     * URL: GET /pembeli/reservasi/create?kavling_id=5
     */
    public function create(Request $request)
    {
        $request->validate([
            'kavling_id' => 'required|exists:kavlings,id',
        ]);

        $kavling = Kavling::with('cluster')->findOrFail($request->kavling_id);

        // Cek kavling masih tersedia
        if ($kavling->status !== 'Tersedia') {
            return redirect()
                ->route('pembeli.kavling.nomor', [
                    'cluster_id' => $kavling->cluster_id,
                    'tipe_kavling' => $kavling->tipe_kavling,
                ])
                ->with('error', 'Kavling #' . $kavling->nomor_kavling . ' sudah tidak tersedia. Silakan pilih nomor lain.');
        }

        $user = auth()->user();

        return view('pembeli.reservasi.create', compact('kavling', 'user'));
    }

    /**
     * store() = SIMPAN data reservasi lalu redirect ke form pembayaran
     * URL: POST /pembeli/reservasi
     */
    public function store(Request $request)
    {
        $request->validate([
            'kavling_id' => 'required|exists:kavlings,id',
            'jenis_reservasi' => 'required|in:pre-need,at-need',
            'nama_jenazah' => 'nullable|string|max:255|required_if:jenis_reservasi,at-need',
            'tanggal_dimakamkan' => 'nullable|date|after_or_equal:today|required_if:jenis_reservasi,at-need',
            'alamat_pemesan' => 'required|string',
            'dokumen_ktp' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'nama_jenazah.required_if' => 'Nama jenazah wajib diisi untuk pemesanan langsung.',
            'tanggal_dimakamkan.required_if' => 'Tanggal dimakamkan wajib diisi untuk pemesanan langsung.',
            'alamat_pemesan.required' => 'Alamat pemesan wajib diisi.',
            'dokumen_ktp.required' => 'Dokumen KTP wajib diunggah.',
        ]);

        // Cek ulang kavling masih tersedia (cegah race condition)
        $kavling = Kavling::findOrFail($request->kavling_id);
        if ($kavling->status !== 'Tersedia') {
            return back()->with('error', 'Maaf, kavling ini baru saja dipesan orang lain. Silakan pilih nomor lain.');
        }

        // Upload KTP
        $ktpPath = $request->file('dokumen_ktp')->store('dokumen_reservasi', 'public');

        // Simpan reservasi
        $reservasi = Reservasi::create([
            'user_id' => auth()->id(),
            'kavling_id' => $request->kavling_id,
            'nama_jenazah' => $request->nama_jenazah ?? null,
            'tanggal_reservasi' => now()->toDateString(),
            'tanggal_dimakamkan' => $request->tanggal_dimakamkan ?? null,
            'alamat_pemesan' => $request->alamat_pemesan,
            'dokumen_ktp' => $ktpPath,
            'status_reservasi' => 'Menunggu Validasi',
            'status_pembayaran' => 'Belum Bayar',
        ]);

        // Kunci kavling agar tidak bisa dipesan orang lain
        $kavling->update(['status' => 'Dipesan']);

        // Redirect ke form pembayaran
        return redirect()
            ->route('pembeli.pembayaran.create', ['reservasi_id' => $reservasi->id])
            ->with('success', 'Reservasi berhasil dibuat! Silakan lanjutkan pembayaran.');
    }
}