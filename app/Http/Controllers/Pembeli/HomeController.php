<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservasi;
use App\Models\Cluster;

class HomeController extends Controller
{
    public function index()
    {
        // Data default (Publik)
        $data = [
            // $cluster = Cluster::all(), (Opsional jika mau panggil dari database)
        ];

        // Ambil kavling yang sudah dipesan
        $reservedKavlings = Reservasi::join('kavlings', 'reservasis.kavling_id', '=', 'kavlings.id')
            ->pluck('kavlings.nomor_kavling')
            ->toArray();
        $data['reservedKavlings'] = $reservedKavlings;

        // Ambil data cluster dan kavling
        $clusters = Cluster::with('kavlings')->get();
        $data['clusters'] = $clusters;

        // Jika user login, ambil data transaksinya untuk dimunculkan di Landing Page
        if (Auth::check() && Auth::user()->role == 'pembeli') {
            // Contoh memanggil relasi:
            // $data['riwayat_reservasi'] = Reservasi::where('user_id', Auth::id())->get();
        }

        return view('pembeli.home', $data);
    }
}