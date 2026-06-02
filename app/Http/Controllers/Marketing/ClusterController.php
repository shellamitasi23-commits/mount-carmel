<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cluster;

class ClusterController extends Controller
{
    public function index(Request $request)
    {
        $query = Cluster::withCount('lahans');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('nama_cluster', 'like', '%' . $search . '%')
                  ->orWhere('kategori', 'like', '%' . $search . '%');
        }

        $clusters = $query->latest()->paginate(12);

        return view('marketing.cluster.index', compact('clusters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_cluster' => 'required|string|max:255',
            'kategori' => 'required|in:Muslim,Non-Muslim',
            'deskripsi' => 'nullable|string',
        ]);

        Cluster::create($request->only('nama_cluster', 'kategori', 'deskripsi'));

        return redirect()->route('marketing.cluster.index')
            ->with('success', 'Data Cluster berhasil ditambahkan!');
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

        return redirect()->route('marketing.cluster.index')
            ->with('success', 'Data Cluster berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $cluster = Cluster::findOrFail($id);
        $cluster->delete();

        return redirect()->route('marketing.cluster.index')
            ->with('success', 'Data Cluster berhasil dihapus!');
    }
}
