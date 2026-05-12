<?php

namespace App\Http\Controllers\KoordinatorLapangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cluster;

class ClusterController extends Controller
{
    public function index()
    {
        $clusters = Cluster::withCount('kavlings')->latest()->get();

        return view('koordinator_lapangan.cluster.index', compact('clusters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_cluster' => 'required|string|max:255',
            'kategori' => 'required|in:Muslim,Non-Muslim',
            'deskripsi' => 'nullable|string',
        ]);

        Cluster::create($request->only('nama_cluster', 'kategori', 'deskripsi'));

        return redirect()->route('koordinator_lapangan.cluster.index')
            ->with('success', 'Data Cluster berhasil ditambahkan oleh Koordinator Lapangan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_cluster' => 'required|string|max:255',
            'kategori' => 'required|in:Muslim,Non-Muslim',
            'deskripsi' => 'nullable|string',
        ]);

        $cluster = Cluster::findOrFail($id);
        $cluster->update($request->only('nama_cluster', 'kategori', 'deskripsi'));

        return redirect()->route('koordinator_lapangan.cluster.index')
            ->with('success', 'Data Cluster berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $cluster = Cluster::findOrFail($id);
        $cluster->delete();

        return redirect()->route('koordinator_lapangan.cluster.index')
            ->with('success', 'Data Cluster berhasil dihapus!');
    }
}
