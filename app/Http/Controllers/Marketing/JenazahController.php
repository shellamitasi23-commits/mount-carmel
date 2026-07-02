<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;

class JenazahController extends Controller
{
    public function index(Request $request)
    {
        $query = \App\Models\DetailJenazah::with(['reservasi.user', 'reservasi.lahan.cluster']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_jenazah', 'LIKE', "%$search%")
                  ->orWhereHas('reservasi.lahan', function($l) use ($search) {
                      $l->where('nomor_lahan', 'LIKE', "%$search%");
                  })
                  ->orWhereHas('reservasi.user', function($u) use ($search) {
                      $u->where('name', 'LIKE', "%$search%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $jenazahs = $query->latest('tanggal_dimakamkan')->paginate(50);

        return view('marketing.jenazah.index', compact('jenazahs'));
    }

    public function setujui($id)
    {
        $detail = \App\Models\DetailJenazah::with('reservasi')->findOrFail($id);
        $detail->update(['status' => 'Disetujui']);

        // Sinkronisasi ke tabel reservasis jika nomor_slot == 1 (untuk backward compatibility)
        if ($detail->nomor_slot == 1) {
            $detail->reservasi->update([
                'nama_jenazah' => $detail->nama_jenazah,
                'tanggal_dimakamkan' => $detail->tanggal_dimakamkan,
            ]);
        }

        return redirect()->back()->with('success', 'Data diri jenazah untuk slot #' . $detail->nomor_slot . ' berhasil disetujui.');
    }

    public function tolak($id)
    {
        $detail = \App\Models\DetailJenazah::with('reservasi')->findOrFail($id);
        $detail->update(['status' => 'Ditolak']);

        // Sinkronisasi ke tabel reservasis jika nomor_slot == 1 (untuk backward compatibility)
        if ($detail->nomor_slot == 1) {
            $detail->reservasi->update([
                'nama_jenazah' => null,
                'tanggal_dimakamkan' => null,
            ]);
        }

        return redirect()->back()->with('success', 'Data diri jenazah untuk slot #' . $detail->nomor_slot . ' telah ditolak.');
    }
}
