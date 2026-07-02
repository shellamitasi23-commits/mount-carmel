<?php

namespace App\Http\Controllers\KoordinatorLapangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lahan;
use App\Models\Cluster;

class LahanController extends Controller
{
    public function index(Request $request)
    {
        $query = Lahan::with(['cluster', 'reservasis' => function ($q) {
            $q->where('status_reservasi', '!=', 'Ditolak')->with('detailJenazahs')->latest();
        }]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_lahan', 'like', '%' . $search . '%')
                  ->orWhere('tipe_lahan', 'like', '%' . $search . '%')
                  ->orWhere('status', 'like', '%' . $search . '%')
                  ->orWhere('hadap', 'like', '%' . $search . '%')
                  ->orWhereHas('cluster', function($cq) use ($search) {
                      $cq->where('nama_cluster', 'like', '%' . $search . '%');
                  });
            });
        }

        $lahans = $query->orderBy('cluster_id')
            ->orderBy('nomor_lahan')
            ->paginate(50);

        $clusters = Cluster::all();

        // Daftar Harga & Hadap Resmi 2026
        $master_lahan = [
            'Single' => ['ukuran' => '1.5 x 4 m', 'kapasitas' => 1, 'harga' => 60000000, 'hadap_options' => ['Utara']],
            'Single Special' => ['ukuran' => '1.5 x 4 m', 'kapasitas' => 1, 'harga' => 65000000, 'hadap_options' => ['Utara']],
            'Double' => ['ukuran' => '3 x 4 m', 'kapasitas' => 2, 'harga' => 120000000, 'hadap_options' => ['Utara']],
            'Double Special' => ['ukuran' => '3 x 4 m', 'kapasitas' => 2, 'harga' => 130000000, 'hadap_options' => ['Utara']],
            'D. Deluxe' => ['ukuran' => '4 x 4.5 m', 'kapasitas' => 2, 'harga' => 140000000, 'hadap_options' => ['Utara', 'Barat', 'Timur']],
            'D. Deluxe Special' => ['ukuran' => '4 x 4.5 m', 'kapasitas' => 2, 'harga' => 155000000, 'hadap_options' => ['Utara', 'Barat', 'Timur']],
            'D. Special' => ['ukuran' => '8 x 4.5 m', 'kapasitas' => 4, 'harga' => 280000000, 'hadap_options' => ['Utara', 'Barat', 'Timur']],
            'Family' => ['ukuran' => '8 x 5 m', 'kapasitas' => 4, 'harga' => 400000000, 'hadap_options' => ['Utara', 'Selatan']],
            'Family Special' => ['ukuran' => '8 x 5 m', 'kapasitas' => 4, 'harga' => 425000000, 'hadap_options' => ['Utara', 'Selatan']],
            'Super Family' => ['ukuran' => '8 x 10 m', 'kapasitas' => 6, 'harga' => 800000000, 'hadap_options' => ['By Request']],
            'Super Family Special' => ['ukuran' => '8 x 10 m', 'kapasitas' => 6, 'harga' => 850000000, 'hadap_options' => ['By Request']],
            'Royal Family' => ['ukuran' => '16 x 20 m', 'kapasitas' => 10, 'harga' => 3500000000, 'hadap_options' => ['By Request']],
            'Royal Family Special' => ['ukuran' => '16 x 20 m', 'kapasitas' => 10, 'harga' => 3800000000, 'hadap_options' => ['By Request']],
            'VIP' => ['ukuran' => '26 x 36 m', 'kapasitas' => 18, 'harga' => 12800000000, 'hadap_options' => ['By Request']],
            'VIP Special' => ['ukuran' => '26 x 36 m', 'kapasitas' => 18, 'harga' => 13500000000, 'hadap_options' => ['By Request']],
            // Muslim
            'Barokah' => ['ukuran' => '1.5 x 2.5 m', 'kapasitas' => 1, 'harga' => 25000000, 'hadap_options' => ['A', 'B', 'C']],
            'Barokah Special' => ['ukuran' => '1.5 x 2.5 m', 'kapasitas' => 1, 'harga' => 27500000, 'hadap_options' => ['A', 'B', 'C']],
            'Fitrah' => ['ukuran' => '4 x 3 m', 'kapasitas' => 2, 'harga' => 85000000, 'hadap_options' => ['A', 'B']],
            'Fitrah Special' => ['ukuran' => '4 x 3 m', 'kapasitas' => 2, 'harga' => 90000000, 'hadap_options' => ['A', 'B']],
            'Shakinah' => ['ukuran' => '7 x 8 m', 'kapasitas' => 6, 'harga' => 425000000, 'hadap_options' => ['A']],
            'Shakinah Special' => ['ukuran' => '7 x 8 m', 'kapasitas' => 6, 'harga' => 450000000, 'hadap_options' => ['A']],
            'Khalifah' => ['ukuran' => '7 x 15 m', 'kapasitas' => 12, 'harga' => 750000000, 'hadap_options' => ['A']],
            'Khalifah Special' => ['ukuran' => '7 x 15 m', 'kapasitas' => 12, 'harga' => 800000000, 'hadap_options' => ['A']],
        ];

        return view('koordinator_lapangan.lahan.index', compact('lahans', 'clusters', 'master_lahan'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cluster_id' => 'required|exists:clusters,id',
            'nomor_lahan' => 'required|string|unique:lahans,nomor_lahan',
            'tipe_lahan' => 'required|string',
            'hadap' => 'nullable|string',
            'ukuran' => 'required|string',
            'kapasitas' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'status' => 'required|in:Tersedia,Reservasi (Lunas),Reservasi Cicilan dengan DP,Terjual,Digunakan',
        ]);

        Lahan::create($validated);

        return redirect()->route('koordinator_lapangan.lahan.index')
            ->with('success', 'Lahan #' . $validated['nomor_lahan'] . ' berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'cluster_id' => 'required|exists:clusters,id',
            'nomor_lahan' => 'required|string|unique:lahans,nomor_lahan,' . $id,
            'tipe_lahan' => 'required|string',
            'hadap' => 'nullable|string',
            'ukuran' => 'required|string',
            'kapasitas' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'status' => 'required|in:Tersedia,Reservasi (Lunas),Reservasi Cicilan dengan DP,Terjual,Digunakan',
        ]);

        $lahan = Lahan::findOrFail($id);

        // 1. Validasi status "Tersedia"
        if ($request->status === 'Tersedia') {
            $hasActiveReservasi = $lahan->reservasis()->where('status_reservasi', '!=', 'Ditolak')->exists();
            if ($hasActiveReservasi) {
                return back()->withErrors(['status' => 'Status Lahan tidak dapat diubah menjadi Tersedia karena memiliki reservasi aktif dari pembeli.']);
            }
        }

        // 2. Validasi status "Digunakan"
        if ($request->status === 'Digunakan') {
            $activeRes = $lahan->reservasis()->where('status_reservasi', '!=', 'Ditolak')->first();
            $hasJenazah = $activeRes && (
                !empty($activeRes->nama_jenazah) || 
                ($activeRes->detailJenazahs && $activeRes->detailJenazahs->where('status', '!=', 'Ditolak')->isNotEmpty())
            );
            if (!$hasJenazah) {
                return back()->withErrors(['status' => 'Status Lahan tidak dapat diubah menjadi Digunakan karena pembeli belum menginput data jenazah.']);
            }
        }

        $lahan->update($validated);

        return redirect()->route('koordinator_lapangan.lahan.index')
            ->with('success', 'Lahan #' . $lahan->nomor_lahan . ' berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $lahan = Lahan::findOrFail($id);

        if ($lahan->reservasis()->exists()) {
            return back()->withErrors(['error' => 'Lahan tidak dapat dihapus karena memiliki riwayat reservasi pembeli terikat.']);
        }

        $nomor = $lahan->nomor_lahan;
        $lahan->delete();

        return redirect()->route('koordinator_lapangan.lahan.index')
            ->with('success', 'Lahan #' . $nomor . ' berhasil dihapus!');
    }

    public function updateProgres(Request $request, $id)
    {
        $request->validate([
            'foto_progres' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'catatan_progres' => 'nullable|string'
        ]);

        $lahan = Lahan::findOrFail($id);

        if ($request->hasFile('foto_progres')) {
            if ($lahan->foto_progres && \Illuminate\Support\Facades\Storage::disk('public')->exists($lahan->foto_progres)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($lahan->foto_progres);
            }
            $path = $request->file('foto_progres')->store('progres_lahan', 'public');
            $lahan->foto_progres = $path;
        }

        if ($request->filled('catatan_progres')) {
            $lahan->catatan_progres = $request->catatan_progres;
        }
        
        $lahan->save();

        return redirect()->route('koordinator_lapangan.lahan.index')
            ->with('success', 'Foto progres bangunan lahan #' . $lahan->nomor_lahan . ' berhasil diperbarui!');
    }
}
