<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kavling;
use App\Models\Cluster;

class HargaController extends Controller
{
    public function index()
    {
        $kavlings = Kavling::with('cluster')
            ->orderBy('cluster_id')
            ->orderBy('nomor_kavling')
            ->get();

        $clusters = Cluster::all();

        return view('accounting.harga.index', compact('kavlings', 'clusters'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'harga' => 'required|numeric|min:0',
        ]);

        $kavling = Kavling::findOrFail($id);
        $oldHarga = $kavling->harga;
        $kavling->update([
            'harga' => $request->harga
        ]);

        return redirect()->route('accounting.harga.index')
            ->with('success', 'Harga Lahan #' . $kavling->nomor_kavling . ' berhasil diubah dari Rp ' . number_format($oldHarga, 0, ',', '.') . ' menjadi Rp ' . number_format($request->harga, 0, ',', '.') . '!');
    }
}
