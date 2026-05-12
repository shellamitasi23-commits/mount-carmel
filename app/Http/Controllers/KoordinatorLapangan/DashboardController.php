<?php

namespace App\Http\Controllers\KoordinatorLapangan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kavling;
use App\Models\Cluster;
use App\Models\Reservasi;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_cluster' => Cluster::count(),
            'total_lahan' => Kavling::count(),
            'tersedia' => Kavling::whereIn('status', ['Tersedia', 'tersedia'])->count(),
            'terisi' => Kavling::whereIn('status', ['Terjual', 'terjual', 'Dipesan', 'dipesan', 'Terisi', 'terisi'])->count(),
        ];

        $latest_allocations = Reservasi::with(['user', 'kavling.cluster'])
            ->latest()
            ->take(5)
            ->get();

        return view('koordinator_lapangan.dashboard', compact('stats', 'latest_allocations'));
    }
}
