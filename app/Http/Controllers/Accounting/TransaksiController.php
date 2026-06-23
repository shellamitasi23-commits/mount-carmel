<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Reservasi;
use App\Models\Lahan;

class TransaksiController extends Controller
{
    public function pembayaran(Request $request)
    {
        $query = Pembayaran::with(['reservasi.user', 'reservasi.lahan.cluster']);

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

        if ($request->filled('status')) {
            $query->where('status_pembayaran', $request->status);
        }

        $pembayarans = $query->latest()->paginate(15);

        return view('accounting.transaksi.pembayaran', compact('pembayarans'));
    }

    public function konfirmasiPembayaran(Request $request, $id)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:Lunas,Ditolak',
        ]);

        $pembayaran = Pembayaran::with(['reservasi.lahan'])->findOrFail($id);
        $reservasi = $pembayaran->reservasi;

        if ($request->status_pembayaran === 'Lunas' && $reservasi && $reservasi->status_reservasi === 'Menunggu Validasi') {
            return redirect()->back()->with('error', 'Pembayaran tidak dapat disetujui karena reservasi pembeli belum divalidasi oleh Marketing.');
        }

        $pembayaran->update([
            'status_pembayaran' => $request->status_pembayaran,
            'dikonfirmasi_oleh' => auth()->user()->name
        ]);

        if ($request->status_pembayaran === 'Lunas') {
            if ($reservasi->jenis_pembayaran === 'cicilan') {
                if ($pembayaran->cicilan_ke === 0) {
                    // Jika DP lunas, setujui reservasi secara otomatis
                    $reservasi->update([
                        'status_pembayaran' => 'DP Lunas',
                        'status_reservasi' => 'Disetujui'
                    ]);
                    if ($reservasi->lahan_id) {
                        $reservasi->lahan->update(['status' => 'Reservasi Cicilan dengan DP']);
                    }
                } else {
                    $tenor = $reservasi->tenor_cicilan ?? 1;
                    if ($pembayaran->cicilan_ke >= $tenor) {
                        // Jika cicilan terakhir lunas
                        $reservasi->update([
                            'status_pembayaran' => 'Lunas',
                            'status_reservasi' => 'Selesai'
                        ]);
                        if ($reservasi->lahan_id) {
                            $statusLahan = $reservasi->nama_jenazah ? 'Digunakan' : 'Terjual';
                            $reservasi->lahan->update(['status' => $statusLahan]);
                        }
                    } else {
                        // Jika cicilan antara lunas
                        $reservasi->update([
                            'status_pembayaran' => "Cicilan Ke-{$pembayaran->cicilan_ke} Lunas"
                        ]);
                        if ($reservasi->lahan_id) {
                            $reservasi->lahan->update(['status' => 'Reservasi Cicilan dengan DP']);
                        }
                    }
                }
            } else {
                // Jika tunai lunas
                $reservasi->update([
                    'status_pembayaran' => 'Lunas',
                    'status_reservasi' => 'Selesai'
                ]);
                if ($reservasi->lahan_id) {
                    $statusLahan = $reservasi->nama_jenazah ? 'Digunakan' : 'Terjual';
                    $reservasi->lahan->update(['status' => $statusLahan]);
                }
            }
        } else if ($request->status_pembayaran === 'Ditolak') {
            // Cari status lunas sebelumnya
            $hasDpLunas = Pembayaran::where('reservasi_id', $pembayaran->reservasi_id)
                ->where('cicilan_ke', 0)
                ->where('status_pembayaran', 'Lunas')
                ->exists();

            if ($reservasi->jenis_pembayaran === 'cicilan' && $hasDpLunas) {
                // Cari cicilan tertinggi yang disetujui sebelumnya
                $highestLunas = Pembayaran::where('reservasi_id', $pembayaran->reservasi_id)
                    ->where('status_pembayaran', 'Lunas')
                    ->where('cicilan_ke', '>', 0)
                    ->max('cicilan_ke');

                if ($highestLunas) {
                    $reservasi->update([
                        'status_pembayaran' => "Cicilan Ke-{$highestLunas} Lunas"
                    ]);
                } else {
                    $reservasi->update([
                        'status_pembayaran' => 'DP Lunas'
                    ]);
                }
            } else {
                // Jika tidak ada DP lunas sebelumnya, kembalikan status
                $reservasi->update([
                    'status_pembayaran' => 'Ditolak'
                ]);
                if ($reservasi->lahan_id) {
                    $reservasi->lahan->update(['status' => 'Tersedia']);
                }
            }
        }

        return redirect()->back()->with('success', 'Status pembayaran berhasil dikonfirmasi oleh Accounting.');
    }
}
