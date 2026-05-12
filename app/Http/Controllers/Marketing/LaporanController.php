<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Kavling;
use App\Models\User;
use App\Models\Cluster;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'reservasi');

        $data = [];
        if ($type === 'reservasi') {
            $data = Reservasi::with(['user', 'kavling.cluster'])->latest()->get();
        } elseif ($type === 'kavling') {
            $data = Kavling::with('cluster')->orderBy('cluster_id')->get();
        } elseif ($type === 'pembeli') {
            $data = User::where('role', 'pembeli')->latest()->get();
        } elseif ($type === 'cluster') {
            $data = Cluster::withCount('kavlings')->get();
        }

        return view('marketing.laporan.index', compact('data', 'type'));
    }

    public function exportPdf(Request $request)
    {
        $type = $request->get('type', 'reservasi');

        $data = [];
        if ($type === 'reservasi') {
            $data = Reservasi::with(['user', 'kavling.cluster'])->latest()->get();
        } elseif ($type === 'kavling') {
            $data = Kavling::with('cluster')->orderBy('cluster_id')->get();
        } elseif ($type === 'pembeli') {
            $data = User::where('role', 'pembeli')->latest()->get();
        } elseif ($type === 'cluster') {
            $data = Cluster::withCount('kavlings')->get();
        }

        $pdf = Pdf::loadView('marketing.laporan.pdf', compact('data', 'type'));
        return $pdf->download('laporan-' . $type . '-' . date('Y-m-d') . '.pdf');
    }
}
