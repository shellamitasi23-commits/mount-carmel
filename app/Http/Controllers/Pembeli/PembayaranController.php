<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Reservasi;

class PembayaranController extends Controller
{
    /**
     * index() = RIWAYAT pembayaran + tombol invoice
     * Dipanggil dari navbar klik "Pembayaran"
     * URL: GET /pembeli/pembayaran  (TANPA parameter)
     */
    public function index()
    {
        return redirect()->route('profil.index', ['tab' => 'pembayaran']);
    }

    /**
     * create() = FORM upload bukti transfer
     * Dipanggil setelah reservasi berhasil disimpan
     * URL: GET /pembeli/pembayaran/create?reservasi_id=3
     */
    public function create(Request $request)
    {
        $request->validate([
            'reservasi_id' => 'required|exists:reservasis,id',
        ]);

        // Pastikan reservasi milik user ini
        $reservasi = Reservasi::with(['lahan.cluster', 'user'])
            ->where('user_id', auth()->id())
            ->findOrFail($request->reservasi_id);

        // Kalau sudah pernah bayar, redirect ke index
        $sudahBayar = Pembayaran::where('reservasi_id', $reservasi->id)->exists();
        if ($sudahBayar) {
            return redirect()
                ->route('pembeli.pembayaran.index')
                ->with('error', 'Pembayaran untuk reservasi ini sudah pernah dikirim.');
        }

        $rekening = [
            ['bank' => 'BCA', 'nomor' => '8890123456', 'atas_nama' => 'PT Mount Carmel'],
            ['bank' => 'BNI', 'nomor' => '1234567890', 'atas_nama' => 'PT Mount Carmel'],
            ['bank' => 'Mandiri', 'nomor' => '1380012345678', 'atas_nama' => 'PT Mount Carmel'],
        ];

        return view('pembeli.pembayaran.create', compact('reservasi', 'rekening'));
    }

    /**
     * store() = SIMPAN bukti pembayaran
     * URL: POST /pembeli/pembayaran
     */
    public function store(Request $request)
    {
        $request->validate([
            'reservasi_id' => 'required|exists:reservasis,id',
            'jumlah_bayar' => 'required|numeric|min:1',
            'nama_bank' => 'required|string|max:50',
            'rekening_tujuan' => 'required|string|max:50',
            'atas_nama_rekening' => 'required|string|max:100',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'catatan' => 'nullable|string|max:500',
        ], [
            'nama_bank.required' => 'Pilih rekening tujuan terlebih dahulu.',
            'bukti_pembayaran.required' => 'Bukti transfer wajib diunggah.',
            'bukti_pembayaran.max' => 'Ukuran file maksimal 4MB.',
        ]);

        $reservasi = Reservasi::where('user_id', auth()->id())
            ->findOrFail($request->reservasi_id);

        // Cegah double submit
        $sudahBayar = Pembayaran::where('reservasi_id', $reservasi->id)->exists();
        if ($sudahBayar) {
            return redirect()
                ->route('pembeli.pembayaran.index')
                ->with('error', 'Pembayaran sudah pernah dikirim sebelumnya.');
        }

        $path = $request->file('bukti_pembayaran')->store('bukti_bayar', 'public');

        $noInvoice = 'INV-' . date('Ymd') . '-' . strtoupper(substr(md5($reservasi->id . time()), 0, 6));

        Pembayaran::create([
            'reservasi_id' => $reservasi->id,
            'no_invoice' => $noInvoice,
            'jumlah_bayar' => $request->jumlah_bayar,
            'tanggal_bayar' => now()->toDateString(),
            'nama_bank' => $request->nama_bank,
            'rekening_tujuan' => $request->rekening_tujuan,
            'atas_nama_rekening' => $request->atas_nama_rekening,
            'bukti_pembayaran' => $path,
            'catatan' => $request->catatan,
            'status_pembayaran' => 'Menunggu Konfirmasi',
        ]);

        $reservasi->update(['status_pembayaran' => 'Menunggu Konfirmasi']);

        return redirect()
            ->route('pembeli.pembayaran.index')
            ->with('success', 'Bukti pembayaran berhasil dikirim! Admin akan memverifikasi dalam 1×24 jam.');
    }

    /**
     * invoice() = Cetak invoice
     * URL: GET /pembeli/pembayaran/invoice/{id}
     */
    public function invoice($id)
    {
        $pembayaran = Pembayaran::with(['reservasi.lahan.cluster', 'reservasi.user'])->findOrFail($id);

        // Jika pembeli, pastikan hanya bisa lihat invoice miliknya sendiri
        if (auth()->user()->role === 'pembeli') {
            if ($pembayaran->reservasi->user_id !== auth()->id()) {
                abort(403, 'Anda tidak memiliki akses ke invoice ini.');
            }
        }

        return view('pembeli.pembayaran.invoice', compact('pembayaran'));
    }
}