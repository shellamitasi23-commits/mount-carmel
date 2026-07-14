<?php

namespace App\Http\Controllers\KoordinatorLapangan;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservasi::with(['user', 'lahan.cluster', 'detailJenazahs']);

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

        $sort = $request->input('sort', 'desc');
        if (!in_array($sort, ['asc', 'desc'])) {
            $sort = 'desc';
        }
        $query->orderBy('created_at', $sort);

        $reservasis = $query->paginate(15)->appends($request->all());

        return view('koordinator_lapangan.reservasi.index', compact('reservasis'));
    }

    public function konfirmasiTersedia($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update([
            'konfirmasi_lahan' => 'Tersedia'
        ]);

        return redirect()->back()->with('success', 'Ketersediaan lahan berhasil dikonfirmasi TERSEDIA.');
    }

    public function konfirmasiTidakTersedia($id)
    {
        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update([
            'konfirmasi_lahan' => 'Tidak Tersedia',
            'status_reservasi' => 'Ditolak'
        ]);

        if ($reservasi->lahan) {
            $reservasi->lahan->update(['status' => 'Tersedia']);
        }

        return redirect()->back()->with('success', 'Ketersediaan lahan dikonfirmasi TIDAK TERSEDIA. Reservasi otomatis ditolak.');
    }
}
