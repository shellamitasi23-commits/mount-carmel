<?php

namespace App\Http\Controllers\Pimpinan;

use App\Http\Controllers\Controller;
use App\Models\Cluster;
use App\Models\Kavling;
use App\Models\Reservasi;
use App\Models\User;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type', 'reservasi');

        $data = [
            'type' => $type,
        ];

        switch ($type) {
            case 'kavling':
                $kavlingQuery = Kavling::with('cluster');

                if ($request->filled('search')) {
                    $search = $request->search;
                    $kavlingQuery->where(function ($q) use ($search) {
                        $q->where('nomor_kavling', 'like', "%{$search}%")
                            ->orWhere('tipe_kavling', 'like', "%{$search}%")
                            ->orWhereHas('cluster', function ($cq) use ($search) {
                                $cq->where('nama_cluster', 'like', "%{$search}%");
                            });
                    });
                }

                if ($request->filled('status')) {
                    $kavlingQuery->where('status', $request->status);
                }

                $data['kavlings'] = $kavlingQuery->get();
                break;

            case 'pembeli':
                $pembeliQuery = User::where('role', 'pembeli')->withCount('reservasis');

                if ($request->filled('search')) {
                    $search = $request->search;
                    $pembeliQuery->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
                }

                $data['pembelis'] = $pembeliQuery->get();
                break;

            case 'cluster':
                $clusterQuery = Cluster::withCount('kavlings');

                if ($request->filled('search')) {
                    $clusterQuery->where('nama_cluster', 'like', "%{$request->search}%");
                }

                $data['clusters'] = $clusterQuery->get();
                break;

            default:
                $query = Reservasi::with(['user', 'kavling.cluster']);

                // Logika Filter Berdasarkan Tanggal Dimakamkan
                if ($request->filled('start_date') && $request->filled('end_date')) {
                    $query->whereBetween('tanggal_dimakamkan', [$request->start_date, $request->end_date]);
                }

                if ($request->filled('status')) {
                    $query->where('status_reservasi', $request->status);
                }

                $data['reservasis'] = $query->latest()->get();
                break;
        }

        return view('pimpinan.laporan.index', $data);
    }

    public function cetak(Request $request)
    {
        $type = $request->get('type', 'reservasi');
        $data = ['type' => $type];

        switch ($type) {
            case 'kavling':
                $kavlingQuery = Kavling::with('cluster');

                if ($request->filled('search')) {
                    $search = $request->search;
                    $kavlingQuery->where(function ($q) use ($search) {
                        $q->where('nomor_kavling', 'like', "%{$search}%")
                            ->orWhere('tipe_kavling', 'like', "%{$search}%")
                            ->orWhereHas('cluster', function ($cq) use ($search) {
                                $cq->where('nama_cluster', 'like', "%{$search}%");
                            });
                    });
                }

                if ($request->filled('status')) {
                    $kavlingQuery->where('status', $request->status);
                }

                $data['kavlings'] = $kavlingQuery->get();
                break;

            case 'pembeli':
                $pembeliQuery = User::where('role', 'pembeli')->withCount('reservasis');

                if ($request->filled('search')) {
                    $search = $request->search;
                    $pembeliQuery->where(function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
                }

                $data['pembelis'] = $pembeliQuery->get();
                break;

            case 'cluster':
                $clusterQuery = Cluster::withCount('kavlings');

                if ($request->filled('search')) {
                    $clusterQuery->where('nama_cluster', 'like', "%{$request->search}%");
                }

                $data['clusters'] = $clusterQuery->get();
                break;

            default:
                $query = Reservasi::with(['user', 'kavling.cluster']);

                if ($request->filled('start_date') && $request->filled('end_date')) {
                    $query->whereBetween('tanggal_dimakamkan', [$request->start_date, $request->end_date]);
                }

                if ($request->filled('status')) {
                    $query->where('status_reservasi', $request->status);
                }

                $data['reservasis'] = $query->get();
                break;
        }

        return view('pimpinan.laporan.cetak', $data);
    }
}