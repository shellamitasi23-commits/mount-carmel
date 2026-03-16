<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Kavling;
use App\Models\Pembayaran;
use App\Models\User;

class TransaksiController extends Controller
{
    // ─── RESERVASI ─────────────────────────────────────────────

    public function reservasi(Request $request)
    {
        $query = Reservasi::with(['user', 'kavling.cluster']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('kavling', function ($kavlingQuery) use ($search) {
                        $kavlingQuery->where('nomor_kavling', 'like', '%' . $search . '%')
                            ->orWhere('tipe_kavling', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('kavling.cluster', function ($clusterQuery) use ($search) {
                        $clusterQuery->where('nama_cluster', 'like', '%' . $search . '%');
                    })
                    ->orWhere('nama_jenazah', 'like', '%' . $search . '%')
                    ->orWhere('status_reservasi', 'like', '%' . $search . '%');
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_reservasi', $request->status);
        }

        $reservasis = $query->latest()->paginate(15);
        $pembelis = User::where('role', 'pembeli')->get();
        $kavlings = Kavling::where('status', 'Tersedia')->get();

        return view('admin.transaksi.reservasi', compact('reservasis', 'pembelis', 'kavlings'));
    }

    public function storeReservasi(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'kavling_id' => 'required|exists:kavlings,id',
            'nama_jenazah' => 'nullable|string',
            'tanggal_dimakamkan' => 'nullable|date',
        ]);

        Reservasi::create([
            'user_id' => $request->user_id,
            'kavling_id' => $request->kavling_id,
            'nama_jenazah' => $request->nama_jenazah,
            'tanggal_reservasi' => now()->toDateString(),
            'tanggal_dimakamkan' => $request->tanggal_dimakamkan,
            'status_reservasi' => 'Menunggu Validasi',
            'status_pembayaran' => 'Belum Bayar',
        ]);

        Kavling::where('id', $request->kavling_id)->update(['status' => 'Dipesan']);

        return redirect()->back()->with('success', 'Reservasi berhasil ditambahkan!');
    }

    public function updateStatus(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update(['status_reservasi' => $request->status]);

        if ($request->status === 'Ditolak') {
            Kavling::where('id', $reservasi->kavling_id)->update(['status' => 'Tersedia']);
            $reservasi->update(['status_pembayaran' => 'Belum Bayar']);
        }

        if ($request->status === 'Selesai') {
            Kavling::where('id', $reservasi->kavling_id)->update(['status' => 'Terjual']);
        }

        return redirect()->back()->with('success', 'Status reservasi diperbarui.');
    }

    // ─── PEMBAYARAN ────────────────────────────────────────────

    public function pembayaran(Request $request)
    {
        $query = Pembayaran::with(['reservasi.user', 'reservasi.kavling.cluster']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_invoice', 'like', '%' . $search . '%')
                    ->orWhereHas('reservasi.user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('reservasi.kavling', function ($kavlingQuery) use ($search) {
                        $kavlingQuery->where('nomor_kavling', 'like', '%' . $search . '%')
                            ->orWhere('tipe_kavling', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('reservasi.kavling.cluster', function ($clusterQuery) use ($search) {
                        $clusterQuery->where('nama_cluster', 'like', '%' . $search . '%');
                    });
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status_pembayaran', $request->status);
        }

        $pembayarans = $query->latest()->paginate(15);

        return view('admin.transaksi.pembayaran', compact('pembayarans'));
    }

    /**
     * FIX: Eager load 'reservasi' sebelum update agar tidak null
     */
    public function konfirmasiPembayaran(Request $request, $id)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:Lunas,Ditolak',
        ]);

        // PENTING: load relasi 'reservasi' dan 'reservasi.kavling' dulu
        $pembayaran = Pembayaran::with(['reservasi', 'reservasi.kavling'])->findOrFail($id);

        // Update status di tabel pembayarans
        $pembayaran->update(['status_pembayaran' => $request->status_pembayaran]);

        // FIX: Gunakan ID untuk update, bukan lewat relasi yang bisa null
        Reservasi::where('id', $pembayaran->reservasi_id)
            ->update(['status_pembayaran' => $request->status_pembayaran]);

        if ($request->status_pembayaran === 'Lunas') {
            // Kavling jadi Terjual
            Kavling::where('id', $pembayaran->reservasi->kavling_id)
                ->update(['status' => 'Terjual']);

            // Reservasi jadi Selesai
            Reservasi::where('id', $pembayaran->reservasi_id)
                ->update(['status_reservasi' => 'Selesai']);
        }

        if ($request->status_pembayaran === 'Ditolak') {
            // Kembalikan kavling ke Tersedia
            Kavling::where('id', $pembayaran->reservasi->kavling_id)
                ->update(['status' => 'Tersedia']);

            // Reset status pembayaran reservasi
            Reservasi::where('id', $pembayaran->reservasi_id)
                ->update(['status_pembayaran' => 'Ditolak']);
        }

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    public function updatePembayaran(Request $request, $id)
    {
        return $this->konfirmasiPembayaran($request, $id);
    }
}