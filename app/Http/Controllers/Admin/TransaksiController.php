<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Kavling;
use App\Models\User;

class TransaksiController extends Controller
{
    public function reservasi()
    {
        // Ambil semua data reservasi dengan relasi pembeli dan kavling
        $reservasis = Reservasi::with(['user', 'kavling.cluster'])->latest()->get();

        // Data untuk dropdown di Modal Tambah
        $pembelis = User::where('role', 'pembeli')->get();
        $kavlings = Kavling::where('status', 'Tersedia')->get();

        return view('admin.transaksi.reservasi', compact('reservasis', 'pembelis', 'kavlings'));
    }

    public function storeReservasi(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'kavling_id' => 'required',
            'nama_jenazah' => 'required|string',
            'tanggal_dimakamkan' => 'required|date',
        ]);

        // 1. Simpan Data Reservasi
        Reservasi::create([
            'user_id' => $request->user_id,
            'kavling_id' => $request->kavling_id,
            'nama_jenazah' => $request->nama_jenazah,
            'tanggal_dimakamkan' => $request->tanggal_dimakamkan,
            'status_reservasi' => 'Menunggu', // Status awal sesuai proposal
        ]);

        // 2. Update Status Kavling menjadi 'Dipesan' agar tidak dipilih orang lain
        Kavling::where('id', $request->kavling_id)->update(['status' => 'Dipesan']);

        return redirect()->back()->with('success', 'Reservasi berhasil ditambahkan!');
    }

    public function updateStatus(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update(['status_reservasi' => $request->status]);

        // Jika reservasi Ditolak, kembalikan status kavling ke 'Tersedia'
        if ($request->status == 'Ditolak') {
            Kavling::where('id', $reservasi->kavling_id)->update(['status' => 'Tersedia']);
        }

        return redirect()->back()->with('success', 'Status reservasi diperbarui.');
    }
    public function pembayaran()
    {
        // Mengambil data reservasi yang sudah disetujui untuk diproses pembayarannya
        // Sesuai alur: Reservasi Disetujui -> Bayar
        $pembayarans = Reservasi::with(['user', 'kavling.cluster'])
            ->where('status_reservasi', 'Disetujui')
            ->latest()
            ->get();

        return view('admin.transaksi.pembayaran', compact('pembayarans'));
    }

    /**
     * Fungsi untuk update status pembayaran (jika diperlukan)
     */
    public function updatePembayaran(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);

        // Logika simpan atau update status bayar
        // Contoh: kita asumsikan ada kolom status_pembayaran di tabel reservasis
        $reservasi->update([
            'status_pembayaran' => $request->status_pembayaran // 'Lunas' atau 'Belum Lunas'
        ]);

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui!');
    }
}