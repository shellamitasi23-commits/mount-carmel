<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cluster;

class ClusterController extends Controller
{
    // READ
    public function index()
    {
        $clusters = Cluster::withCount('kavlings')->latest()->get();

        return view('admin.cluster.index', compact('clusters'));
    }

    // CREATE
    public function store(Request $request)
    {
        $request->validate([
            'nama_cluster' => 'required|string|max:255',
            'kategori' => 'required|in:Muslim,Non-Muslim',
            'deskripsi' => 'nullable|string',
        ]);

        Cluster::create($request->only('nama_cluster', 'kategori', 'deskripsi'));

        return redirect()->route('admin.cluster.index')
            ->with('success', 'Data Cluster berhasil ditambahkan!');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_cluster' => 'required|string|max:255',
            'kategori' => 'required|in:Muslim,Non-Muslim',
            'deskripsi' => 'nullable|string',
        ]);

        $cluster = Cluster::findOrFail($id);
        $cluster->update($request->only('nama_cluster', 'kategori', 'deskripsi'));

        return redirect()->route('admin.cluster.index')
            ->with('success', 'Data Cluster berhasil diperbarui!');
    }

    // DELETE
    public function destroy($id)
    {
        $cluster = Cluster::findOrFail($id);
        $cluster->delete();

        return redirect()->route('admin.cluster.index')
            ->with('success', 'Data Cluster berhasil dihapus!');
    }
}