<?php

namespace App\Http\Controllers\KoordinatorLapangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kavling;
use App\Models\Cluster;

class KavlingController extends Controller
{
    public function index()
    {
        $kavlings = Kavling::with('cluster')
            ->orderBy('cluster_id')
            ->orderBy('nomor_kavling')
            ->get();

        $clusters = Cluster::all();

        $tipe_kavlings = Kavling::distinct('tipe_kavling')->pluck('tipe_kavling');

        return view('koordinator_lapangan.kavling.index', compact('kavlings', 'clusters', 'tipe_kavlings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cluster_id' => 'required|exists:clusters,id',
            'nomor_kavling' => 'required|string|unique:kavlings,nomor_kavling',
            'tipe_kavling' => 'required|string',
            'ukuran' => 'required|string',
            'kapasitas' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'status' => 'required|in:Tersedia,Dipesan,Terjual',
        ]);

        Kavling::create($validated);

        return redirect()->route('koordinator_lapangan.kavling.index')
            ->with('success', 'Lahan #' . $validated['nomor_kavling'] . ' berhasil ditambahkan oleh Koordinator Lapangan!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'cluster_id' => 'required|exists:clusters,id',
            'nomor_kavling' => 'required|string|unique:kavlings,nomor_kavling,' . $id,
            'tipe_kavling' => 'required|string',
            'ukuran' => 'required|string',
            'kapasitas' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'status' => 'required|in:Tersedia,Dipesan,Terjual',
        ]);

        $kavling = Kavling::findOrFail($id);
        $kavling->update($validated);

        return redirect()->route('koordinator_lapangan.kavling.index')
            ->with('success', 'Lahan #' . $kavling->nomor_kavling . ' berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kavling = Kavling::findOrFail($id);
        $nomor = $kavling->nomor_kavling;
        $kavling->delete();

        return redirect()->route('koordinator_lapangan.kavling.index')
            ->with('success', 'Lahan #' . $nomor . ' berhasil dihapus!');
    }
}
