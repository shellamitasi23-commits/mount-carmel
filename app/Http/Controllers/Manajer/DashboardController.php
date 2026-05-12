<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\Kavling;
use App\Models\Reservasi;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pembeli' => User::where('role', 'pembeli')->count(),
            'reservasi' => Reservasi::count(),
            'tersedia' => Kavling::whereIn('status', ['Tersedia', 'tersedia'])->count(),
            'terisi' => Kavling::whereIn('status', ['Terjual', 'terjual', 'Dipesan', 'dipesan', 'Terisi', 'terisi'])->count(),
            'total' => Kavling::count(),
            'omzet' => Reservasi::where('status_reservasi', 'Selesai')
                ->join('kavlings', 'reservasis.kavling_id', '=', 'kavlings.id')
                ->sum('kavlings.harga'),
        ];

        $latest_reservasi = Reservasi::with(['user', 'kavling.cluster'])
            ->latest()
            ->take(5)
            ->get();

        return view('manajer.dashboard', compact('stats', 'latest_reservasi'));
    }
}
