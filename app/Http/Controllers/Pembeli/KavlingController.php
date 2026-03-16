<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kavling;
use App\Models\Cluster;

class KavlingController extends Controller
{
    /**
     * Tampilkan tipe-tipe kavling berdasarkan cluster yang dipilih
     * URL: /pembeli/kavling?cluster_id=1
     */
    public function index(Request $request)
    {
        // Wajib ada cluster_id dari cluster/index
        $cluster = Cluster::findOrFail($request->cluster_id ?? Cluster::first()->id);

        // Kelompokkan kavling tersedia berdasarkan tipe
        $tipeKavlings = Kavling::where('cluster_id', $cluster->id)
            ->where('status', 'Tersedia')
            ->get()
            ->groupBy('tipe_kavling')
            ->map(function ($kavlings, $tipe) {
                $sample = $kavlings->first();
                return [
                    'tipe_kavling' => $tipe,
                    'ukuran' => $sample->ukuran,
                    'kapasitas' => $sample->kapasitas,
                    'harga_min' => $kavlings->min('harga'),
                    'harga_max' => $kavlings->max('harga'),
                    'tersedia' => $kavlings->count(),
                ];
            })->values();

        // Semua cluster untuk dropdown/info
        $clusters = Cluster::all();

        return view('pembeli.kavling.index', compact('cluster', 'tipeKavlings', 'clusters'));
    }

    /**
     * Tampilkan grid nomor kavling berdasarkan cluster + tipe
     * URL: /pembeli/kavling/nomor?cluster_id=1&tipe_kavling=Fitrah
     */
    public function nomorKavling(Request $request)
    {
        $request->validate([
            'cluster_id' => 'required|exists:clusters,id',
            'tipe_kavling' => 'required|string',
        ]);

        $cluster = Cluster::findOrFail($request->cluster_id);

        // Ambil SEMUA kavling tipe ini (tersedia, dipesan, terjual)
        // agar grid menampilkan status lengkap
        $kavlings = Kavling::where('cluster_id', $request->cluster_id)
            ->where('tipe_kavling', $request->tipe_kavling)
            ->orderBy('nomor_kavling')
            ->get();

        // Sample untuk info tipe di panel kanan
        $sample = $kavlings->firstWhere('status', 'Tersedia') ?? $kavlings->first();

        return view('pembeli.kavling.nomorkavling', compact('cluster', 'kavlings', 'sample'));
    }
}