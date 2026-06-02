<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lahan;
use App\Models\Cluster;

class HargaController extends Controller
{
    public function index(Request $request)
    {
        $query = Lahan::with('cluster');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nomor_lahan', 'like', '%' . $search . '%')
                  ->orWhere('tipe_lahan', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('cluster_id')) {
            $query->where('cluster_id', $request->cluster_id);
        }

        $lahans = $query->orderBy('cluster_id')
            ->orderBy('nomor_lahan')
            ->paginate(50)
            ->appends($request->all());

        $clusters = Cluster::orderBy('nama_cluster')->get();

        return view('accounting.harga.index', compact('lahans', 'clusters'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'harga' => 'required|numeric|min:0',
        ]);

        $lahan = Lahan::findOrFail($id);
        $oldHarga = $lahan->harga;
        $lahan->update([
            'harga' => $request->harga
        ]);

        return redirect()->route('accounting.harga.index')
            ->with('success', 'Harga Lahan #' . $lahan->nomor_lahan . ' berhasil diubah dari Rp ' . number_format($oldHarga, 0, ',', '.') . ' menjadi Rp ' . number_format($request->harga, 0, ',', '.') . '!');
    }
}
