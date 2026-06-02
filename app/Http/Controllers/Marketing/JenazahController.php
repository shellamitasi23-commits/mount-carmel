<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;

class JenazahController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservasi::with(['user', 'lahan.cluster'])
            ->whereNotNull('nama_jenazah');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_jenazah', 'LIKE', "%$search%")
                  ->orWhereHas('lahan', function($l) use ($search) {
                      $l->where('nomor_lahan', 'LIKE', "%$search%");
                  })
                  ->orWhereHas('user', function($u) use ($search) {
                      $u->where('name', 'LIKE', "%$search%");
                  });
            });
        }

        $jenazahs = $query->latest('tanggal_dimakamkan')->paginate(50);

        return view('marketing.jenazah.index', compact('jenazahs'));
    }
}
