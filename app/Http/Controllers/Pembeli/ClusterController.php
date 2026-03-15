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
        $clusters = Cluster::with('kavlings')->get();

        return view('pembeli.cluster.index', compact('clusters'));
    }

    // Detail cluster + semua kavling di dalamnya — public
    public function show($id)
    {
        $cluster = Cluster::with([
            'kavlings' => function ($q) {
                $q->orderBy('nomor_kavling');
            }
        ])->findOrFail($id);

        return view('pembeli.cluster.show', compact('cluster'));
    }
}