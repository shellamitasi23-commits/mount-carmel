<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use App\Models\Cluster;
use App\Models\Lahan;
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
            case 'lahan':
                $lahanQuery = Lahan::with('cluster')->where('status', 'Terjual');
                if ($request->filled('search')) {
                    $search = $request->search;
                    $lahanQuery->where(function ($q) use ($search) {
                        $q->where('nomor_lahan', 'like', "%{$search}%")
                            ->orWhere('tipe_lahan', 'like', "%{$search}%")
                            ->orWhereHas('cluster', function ($cq) use ($search) {
                                $cq->where('nama_cluster', 'like', "%{$search}%");
                            });
                    });
                }
                if ($request->filled('status')) {
                    $lahanQuery->where('status', $request->status);
                }
                $data['lahans'] = $lahanQuery->get();
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
                $clusterQuery = Cluster::withCount('lahans');
                if ($request->filled('search')) {
                    $clusterQuery->where('nama_cluster', 'like', "%{$request->search}%");
                }
                $data['clusters'] = $clusterQuery->get();
                break;

            case 'jenazah':
                $jenazahQuery = Reservasi::with(['user', 'lahan.cluster'])->whereNotNull('nama_jenazah');
                if ($request->filled('search')) {
                    $search = $request->search;
                    $jenazahQuery->where(function ($q) use ($search) {
                        $q->where('nama_jenazah', 'like', "%{$search}%")
                            ->orWhereHas('lahan', function ($lq) use ($search) {
                                $lq->where('nomor_lahan', 'like', "%{$search}%");
                            });
                    });
                }
                $data['jenazahs'] = $jenazahQuery->get();
                break;

            default:
                $query = Reservasi::with(['user', 'lahan.cluster']);
                if ($request->filled('start_date') && $request->filled('end_date')) {
                    $query->whereBetween('tanggal_dimakamkan', [$request->start_date, $request->end_date]);
                }
                if ($request->filled('status')) {
                    $query->where('status_reservasi', $request->status);
                }
                $data['reservasis'] = $query->latest()->get();
                break;
        }

        return view('manajer.laporan.index', $data);
    }

    public function cetak(Request $request)
    {
        $type = $request->get('type', 'reservasi');
        $data = ['type' => $type];

        switch ($type) {
            case 'lahan':
                $lahanQuery = Lahan::with('cluster')->where('status', 'Terjual');
                if ($request->filled('search')) {
                    $search = $request->search;
                    $lahanQuery->where(function ($q) use ($search) {
                        $q->where('nomor_lahan', 'like', "%{$search}%")
                            ->orWhere('tipe_lahan', 'like', "%{$search}%")
                            ->orWhereHas('cluster', function ($cq) use ($search) {
                                $cq->where('nama_cluster', 'like', "%{$search}%");
                            });
                    });
                }
                if ($request->filled('status')) {
                    $lahanQuery->where('status', $request->status);
                }
                $data['lahans'] = $lahanQuery->get();
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
                $clusterQuery = Cluster::withCount('lahans');
                if ($request->filled('search')) {
                    $clusterQuery->where('nama_cluster', 'like', "%{$request->search}%");
                }
                $data['clusters'] = $clusterQuery->get();
                break;

            case 'jenazah':
                $jenazahQuery = Reservasi::with(['user', 'lahan.cluster'])->whereNotNull('nama_jenazah');
                if ($request->filled('search')) {
                    $search = $request->search;
                    $jenazahQuery->where(function ($q) use ($search) {
                        $q->where('nama_jenazah', 'like', "%{$search}%")
                            ->orWhereHas('lahan', function ($lq) use ($search) {
                                $lq->where('nomor_lahan', 'like', "%{$search}%");
                            });
                    });
                }
                $data['jenazahs'] = $jenazahQuery->get();
                break;

            default:
                $query = Reservasi::with(['user', 'lahan.cluster']);
                if ($request->filled('start_date') && $request->filled('end_date')) {
                    $query->whereBetween('tanggal_dimakamkan', [$request->start_date, $request->end_date]);
                }
                if ($request->filled('status')) {
                    $query->where('status_reservasi', $request->status);
                }
                $data['reservasis'] = $query->get();
                break;
        }

        return view('manajer.laporan.cetak', $data);
    }
}
