<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kavling;
use App\Models\Cluster;

class KavlingController extends Controller
{
    public function index()
    {
        // Kavling + relasi cluster, urut nomor
        $kavlings = Kavling::with('cluster')
            ->orderBy('cluster_id')
            ->orderBy('nomor_kavling')
            ->get();

        // Cluster untuk dropdown form & tab filter
        $clusters = Cluster::all();

        // Tipe kavling unik untuk dropdown
        $tipe_kavlings = Kavling::distinct('tipe_kavling')->pluck('tipe_kavling');

        return view('admin.kavling.index', compact('kavlings', 'clusters', 'tipe_kavlings'));
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

        return redirect()->route('admin.kavling.index')
            ->with('success', 'Kavling #' . $validated['nomor_kavling'] . ' berhasil ditambahkan!');
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

        return redirect()->route('admin.kavling.index')
            ->with('success', 'Kavling #' . $kavling->nomor_kavling . ' berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kavling = Kavling::findOrFail($id);
        $nomor = $kavling->nomor_kavling;
        $kavling->delete();

        return redirect()->route('admin.kavling.index')
            ->with('success', 'Kavling #' . $nomor . ' berhasil dihapus!');
    }
}