<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Reservasi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservasi::with(['user', 'kavling.cluster']);

        // Logika Filter Berdasarkan Tanggal Dimakamkan
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_dimakamkan', [$request->start_date, $request->end_date]);
        }

        $reservasis = $query->latest()->get();

        return view('pimpinan.laporan.index', compact('reservasis'));
    }

    public function cetak(Request $request)
    {
        $query = Reservasi::with(['user', 'kavling.cluster']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_dimakamkan', [$request->start_date, $request->end_date]);
        }

        $reservasis = $query->get();

        // Kita gunakan view khusus untuk tampilan cetak/print
        return view('pimpinan.laporan.cetak', compact('reservasis'));
    }
}