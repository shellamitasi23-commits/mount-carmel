<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Reservasi;

class PembayaranController extends Controller
{
    /**
     * Menampilkan Halaman Riwayat & Form Pembayaran
     */
    public function index()
    {
        // 1. Ambil SEMUA ID reservasi yang dimiliki oleh user yang sedang login
        $user_reservasi_ids = Reservasi::where('user_id', auth()->id())->pluck('id');

        // 2. Cari dari ID reservasi tersebut, mana yang SUDAH pernah dibayar
        $reservasi_sudah_dibayar = Pembayaran::whereIn('reservasi_id', $user_reservasi_ids)->pluck('reservasi_id');

        // 3. Ambil data reservasi yang SIAP DIBAYAR (Status Disetujui & Belum ada di tabel pembayaran)
        $reservasis_siap_bayar = Reservasi::where('user_id', auth()->id())
            ->where('status_reservasi', 'Disetujui')
            ->whereNotIn('id', $reservasi_sudah_dibayar)
            ->get();

        // 4. Ambil Riwayat Pembayaran milik user ini (berdasarkan ID reservasinya)
        $riwayat_pembayaran = Pembayaran::whereIn('reservasi_id', $user_reservasi_ids)
            ->with('reservasi.kavling')
            ->latest()
            ->get();

        // Tampilkan halaman view
        return view('pembeli.pembayaran.index', compact('reservasis_siap_bayar', 'riwayat_pembayaran'));
    }

    /**
     * Menangani proses saat form Upload Bukti Bayar disubmit
     */
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'reservasi_id' => 'required|exists:reservasis,id',
            'jumlah_bayar' => 'required|numeric',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Upload file bukti bayar
        $path = $request->file('bukti_pembayaran')->store('bukti_bayar', 'public');

        // Simpan ke database (Catatan: user_id dihapus karena memang tidak ada di tabelmu)
        Pembayaran::create([
            'reservasi_id' => $request->reservasi_id,
            'jumlah_bayar' => $request->jumlah_bayar,
            'bukti_pembayaran' => $path,
            'status_pembayaran' => 'Menunggu Verifikasi',
        ]);

        return redirect()->route('pembeli.pembayaran.index')->with('success', 'Bukti pembayaran berhasil dikirim! Menunggu verifikasi admin.');
    }

    /**
     * Menampilkan/Mencetak Invoice
     */
    public function cetakInvoice($id)
    {
        $user_reservasi_ids = Reservasi::where('user_id', auth()->id())->pluck('id');
        $pembayaran = Pembayaran::whereIn('reservasi_id', $user_reservasi_ids)->findOrFail($id);

        return view('pembeli.pembayaran.invoice', compact('pembayaran'));
    }
}