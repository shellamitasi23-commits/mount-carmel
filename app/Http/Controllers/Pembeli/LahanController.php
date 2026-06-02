<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lahan;
use App\Models\Cluster;

class LahanController extends Controller
{
    /**
     * Tampilkan tipe-tipe lahan berdasarkan cluster yang dipilih
     * URL: /pembeli/lahan?cluster_id=1
     */
    public function index(Request $request)
    {
        // Wajib ada cluster_id dari cluster/index
        $cluster = Cluster::findOrFail($request->cluster_id ?? Cluster::first()->id);

        // Kelompokkan lahan tersedia berdasarkan tipe
        $tipeLahans = Lahan::where('cluster_id', $cluster->id)
            ->where('status', 'Tersedia')
            ->get()
            ->groupBy('tipe_lahan')
            ->map(function ($lahans, $tipe) {
                $sample = $lahans->first();
                return [
                    'tipe_lahan' => $tipe,
                    'ukuran' => $sample->ukuran,
                    'kapasitas' => $sample->kapasitas,
                    'harga_min' => $lahans->min('harga'),
                    'harga_max' => $lahans->max('harga'),
                    'tersedia' => $lahans->count(),
                ];
            })->values();

        // Semua cluster untuk dropdown/info
        $clusters = Cluster::all();

        return view('pembeli.lahan.index', compact('cluster', 'tipeLahans', 'clusters'));
    }

    /**
     * Tampilkan grid nomor lahan berdasarkan cluster + tipe
     * URL: /pembeli/lahan/nomor?cluster_id=1&tipe_lahan=Fitrah
     */
    public function nomorLahan(Request $request)
    {
        $request->validate([
            'cluster_id' => 'required|exists:clusters,id',
            'tipe_lahan' => 'required|string',
        ]);

        $cluster = Cluster::findOrFail($request->cluster_id);

        // Ambil SEMUA lahan tipe ini (tersedia, dipesan, terjual)
        // agar grid menampilkan status lengkap
        $lahans = Lahan::where('cluster_id', $request->cluster_id)
            ->where('tipe_lahan', $request->tipe_lahan)
            ->orderBy('nomor_lahan')
            ->get();

        // Sample untuk info tipe di panel kanan
        $sample = $lahans->firstWhere('status', 'Tersedia') ?? $lahans->first();

        return view('pembeli.lahan.nomorlahan', compact('cluster', 'lahans', 'sample'));
    }
}
