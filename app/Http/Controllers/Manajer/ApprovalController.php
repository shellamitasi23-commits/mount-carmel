<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Lahan;
use App\Models\Pembayaran;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservasi::with(['user', 'lahan.cluster'])
            ->where('status_reservasi', 'Menunggu Validasi');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })
                ->orWhereHas('lahan', function ($lahanQuery) use ($search) {
                    $lahanQuery->where('nomor_lahan', 'like', '%' . $search . '%');
                });
            });
        }

        $reservasis = $query->latest()->paginate(15);
        return view('manajer.approval.index', compact('reservasis'));
    }

    public function approve(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update([
            'status_reservasi' => 'Disetujui',
            'disetujui_oleh' => auth()->user()->name
        ]);

        return redirect()->back()->with('success', 'Reservasi berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update([
            'status_reservasi' => 'Ditolak',
            'status_pembayaran' => 'Belum Bayar',
            'disetujui_oleh' => auth()->user()->name
        ]);

        if ($reservasi->lahan_id) {
            Lahan::where('id', $reservasi->lahan_id)->update(['status' => 'Tersedia']);
        }

        return redirect()->back()->with('success', 'Reservasi telah ditolak.');
    }
}
