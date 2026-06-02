<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Lahan;
use App\Models\Pembayaran;
use App\Models\User;

class TransaksiController extends Controller
{
    // ─── RESERVASI ─────────────────────────────────────────────

    public function reservasi(Request $request)
    {
        $query = Reservasi::with(['user', 'lahan.cluster']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('lahan', function ($lahanQuery) use ($search) {
                        $lahanQuery->where('nomor_lahan', 'like', '%' . $search . '%')
                            ->orWhere('tipe_lahan', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('lahan.cluster', function ($clusterQuery) use ($search) {
                        $clusterQuery->where('nama_cluster', 'like', '%' . $search . '%');
                    })
                    ->orWhere('nama_jenazah', 'like', '%' . $search . '%')
                    ->orWhere('status_reservasi', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status_reservasi', $request->status);
        }

        $reservasis = $query->latest()->paginate(15);
        $pembelis = User::where('role', 'pembeli')->get();
        $lahans = Lahan::where('status', 'Tersedia')->get();

        return view('marketing.transaksi.reservasi', compact('reservasis', 'pembelis', 'lahans'));
    }

    public function storeReservasi(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'lahan_id' => 'required|exists:lahans,id',
            'nama_jenazah' => 'nullable|string',
            'tanggal_dimakamkan' => 'nullable|date',
        ]);

        Reservasi::create([
            'user_id' => $request->user_id,
            'lahan_id' => $request->lahan_id,
            'nama_jenazah' => $request->nama_jenazah,
            'tanggal_reservasi' => now()->toDateString(),
            'tanggal_dimakamkan' => $request->tanggal_dimakamkan,
            'status_reservasi' => 'Menunggu Validasi',
            'status_pembayaran' => 'Belum Bayar',
        ]);

        Lahan::where('id', $request->lahan_id)->update(['status' => 'Dipesan']);

        return redirect()->back()->with('success', 'Reservasi berhasil ditambahkan!');
    }

    public function updateStatus(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update(['status_reservasi' => $request->status]);

        if ($request->status === 'Ditolak') {
            Lahan::where('id', $reservasi->lahan_id)->update(['status' => 'Tersedia']);
            $reservasi->update(['status_pembayaran' => 'Belum Bayar']);
        }

        if ($request->status === 'Selesai') {
            Lahan::where('id', $reservasi->lahan_id)->update(['status' => 'Terjual']);
        }

        return redirect()->back()->with('success', 'Status reservasi diperbarui.');
    }

    // ─── PEMBAYARAN ────────────────────────────────────────────

    public function pembayaran(Request $request)
    {
        $query = Pembayaran::with(['reservasi.user', 'reservasi.lahan.cluster']);

        // Sesuai instruksi: cuma bisa lihat data yang sudah bayar (status 'Lunas' atau 'Selesai')
        $query->whereIn('status_pembayaran', ['Lunas', 'Selesai', 'lunas', 'selesai']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_invoice', 'like', '%' . $search . '%')
                    ->orWhereHas('reservasi.user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('reservasi.lahan', function ($lahanQuery) use ($search) {
                        $lahanQuery->where('nomor_lahan', 'like', '%' . $search . '%')
                            ->orWhere('tipe_lahan', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('reservasi.lahan.cluster', function ($clusterQuery) use ($search) {
                        $clusterQuery->where('nama_cluster', 'like', '%' . $search . '%');
                    });
            });
        }

        $pembayarans = $query->latest()->paginate(15);

        return view('marketing.transaksi.pembayaran', compact('pembayarans'));
    }
}
