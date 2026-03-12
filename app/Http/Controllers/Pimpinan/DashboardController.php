<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Kavling;
use App\Models\Reservasi;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil data statistik dan masukkan ke dalam array $stats
        $stats = [
            'pembeli' => \App\Models\User::where('role', 'pembeli')->count(),
            'reservasi' => \App\Models\Reservasi::count(),
            'tersedia' => \App\Models\Kavling::where('status', 'Tersedia')->count(),
            'omzet' => \App\Models\Reservasi::where('status_reservasi', 'Disetujui')
                ->join('kavlings', 'reservasis.kavling_id', '=', 'kavlings.id')
                ->sum('kavlings.harga'),
        ];

        // Ambil 5 reservasi terbaru
        $latest_reservasi = \App\Models\Reservasi::with(['user', 'kavling.cluster'])
            ->latest()
            ->take(5)
            ->get();

        // KIRIM variabel $stats dan $latest_reservasi ke view
        return view('pimpinan.dashboard', compact('stats', 'latest_reservasi'));
    }
}