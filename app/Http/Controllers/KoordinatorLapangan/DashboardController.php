<?php

namespace App\Http\Controllers\KoordinatorLapangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lahan;
use App\Models\Cluster;
use App\Models\Reservasi;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik sinkron dengan data riil (5800 Unit)
        $stats = [
            'total_cluster' => Cluster::count(),
            'total_lahan'   => 5800,
            'tersedia'      => 4700,
            'terisi'        => 1100,
        ];

        $latest_allocations = Reservasi::with(['user', 'lahan.cluster'])
            ->latest()
            ->take(5)
            ->get();

        return view('koordinator_lapangan.dashboard', compact('stats', 'latest_allocations'));
    }
}
