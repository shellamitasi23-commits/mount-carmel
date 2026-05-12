<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Reservasi;
use App\Models\Kavling;

class TransaksiController extends Controller
{
    public function pembayaran(Request $request)
    {
        $query = Pembayaran::with(['reservasi.user', 'reservasi.kavling.cluster']);

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

        $pembayaran = Pembayaran::with(['reservasi', 'reservasi.kavling'])->findOrFail($id);

        $pembayaran->update(['status_pembayaran' => $request->status_pembayaran]);

        Reservasi::where('id', $pembayaran->reservasi_id)
            ->update(['status_pembayaran' => $request->status_pembayaran]);

        if ($request->status_pembayaran === 'Lunas') {
            Kavling::where('id', $pembayaran->reservasi->kavling_id)
                ->update(['status' => 'Terjual']);

            Reservasi::where('id', $pembayaran->reservasi_id)
                ->update(['status_reservasi' => 'Selesai']);
        }

        if ($request->status_pembayaran === 'Ditolak') {
            Kavling::where('id', $pembayaran->reservasi->kavling_id)
                ->update(['status' => 'Tersedia']);

            Reservasi::where('id', $pembayaran->reservasi_id)
                ->update(['status_pembayaran' => 'Ditolak']);
        }

        return redirect()->back()->with('success', 'Status pembayaran berhasil dikonfirmasi oleh Accounting.');
    }
}
