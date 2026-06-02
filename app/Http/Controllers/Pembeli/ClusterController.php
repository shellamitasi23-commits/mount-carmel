<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cluster;

class ClusterController extends Controller
{
    // Daftar semua cluster — public
    public function index()
    {
        $clusters = Cluster::with('lahans')->get();

        return view('pembeli.cluster.index', compact('clusters'));
    }

    // Detail cluster + semua lahan di dalamnya — public
    public function show($id)
    {
        $cluster = Cluster::with([
            'lahans' => function ($q) {
                $q->orderBy('nomor_lahan');
            }
        ])->findOrFail($id);

        return view('pembeli.cluster.show', compact('cluster'));
    }
}