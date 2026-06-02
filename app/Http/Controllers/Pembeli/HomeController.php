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
        // Ambil data cluster dengan lahan terkait (hanya kolom yang diperlukan untuk peta)
        $clusters = Cluster::with(['lahans' => function($query) {
            $query->select('id', 'cluster_id', 'nomor_lahan', 'status', 'tipe_lahan', 'ukuran', 'harga', 'kapasitas');
        }])->get();

        // Pisahkan data untuk kemudahan di Blade
        $lahanMuslim = $clusters->where('kategori', 'Muslim')->first()->lahans ?? collect();
        $lahanNonMuslim = $clusters->where('kategori', 'Non-Muslim')->first()->lahans ?? collect();

        $data = [
            'clusters' => $clusters,
            'lahanMuslim' => $lahanMuslim,
            'lahanNonMuslim' => $lahanNonMuslim,
            'reservedLahans' => $lahanMuslim->where('status', '!=', 'Tersedia')
                                ->pluck('nomor_lahan')
                                ->merge($lahanNonMuslim->where('status', '!=', 'Tersedia')->pluck('nomor_lahan'))
                                ->toArray()
        ];

        return view('pembeli.home', $data);
    }
}