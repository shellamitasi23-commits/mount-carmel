<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cluster; // Import Model Cluster

class ClusterController extends Controller
{
    // 1. READ: Menampilkan halaman index beserta data dari database
    public function index()
    {
        // Ambil semua data cluster dari database, urutkan dari yang terbaru
        $clusters = Cluster::latest()->get();

        return view('admin.cluster.index', compact('clusters'));
    }

    // 2. CREATE: Menyimpan data cluster baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_cluster' => 'required|string|max:255',
            'kategori' => 'required|in:Muslim,Non-Muslim',
            'deskripsi' => 'nullable|string'
        ]);

        Cluster::create($request->all());

        return redirect()->route('admin.cluster.index')->with('success', 'Data Cluster berhasil ditambahkan!');
    }

    // 3. UPDATE: Menyimpan perubahan data cluster
    public function update(Request $request, $id)
    {
        $cluster = Cluster::findOrFail($id);
        $cluster->update($request->all());
        return redirect()->route('admin.cluster.index')->with('success', 'Data Cluster berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $cluster = Cluster::findOrFail($id);
        $cluster->delete();
        return redirect()->route('admin.cluster.index')->with('success', 'Data Cluster berhasil dihapus!');
    }
}