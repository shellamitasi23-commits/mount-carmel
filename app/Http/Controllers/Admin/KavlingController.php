<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kavling;
use App\Models\Cluster; // Wajib di-import agar bisa milih cluster saat tambah data

class KavlingController extends Controller
{
    public function index()
    {
        // Ambil data kavling beserta nama clusternya (Eager Loading)
        $kavlings = Kavling::with('cluster')->latest()->get();

        // Ambil semua data cluster untuk pilihan Dropdown di form Tambah/Edit
        $clusters = Cluster::all();

        return view('admin.kavling.index', compact('kavlings', 'clusters'));
    }

    public function store(Request $request)
    {
        // 1. Tampung hasil validasi ke dalam variabel $validated
        $validated = $request->validate([
            'cluster_id' => 'required|exists:clusters,id',
            'nomor_kavling' => 'required|string|unique:kavlings,nomor_kavling',
            'tipe_kavling' => 'required|string',
            'ukuran' => 'required|string',
            'kapasitas' => 'required|integer',
            'harga' => 'required|numeric',
            'status' => 'required|in:Tersedia,Dipesan,Terjual'
        ]);

        // 2. Gunakan $validated, jangan $request->all()
        Kavling::create($validated);

        return redirect()->route('admin.kavling.index')->with('success', 'Data Kavling berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        // 1. Tampung hasil validasi ke dalam variabel $validated
        $validated = $request->validate([
            'cluster_id' => 'required|exists:clusters,id',
            'nomor_kavling' => 'required|string|unique:kavlings,nomor_kavling,' . $id,
            'tipe_kavling' => 'required|string',
            'ukuran' => 'required|string',
            'kapasitas' => 'required|integer',
            'harga' => 'required|numeric',
            'status' => 'required|in:Tersedia,Dipesan,Terjual'
        ]);

        $kavling = Kavling::findOrFail($id);

        // 2. Gunakan $validated, jangan $request->all()
        $kavling->update($validated);

        return redirect()->route('admin.kavling.index')->with('success', 'Data Kavling berhasil diperbarui!');
    }
    public function destroy($id)
    {
        $kavling = Kavling::findOrFail($id);
        $kavling->delete();

        return redirect()->route('admin.kavling.index')->with('success', 'Data Kavling berhasil dihapus!');
    }
}