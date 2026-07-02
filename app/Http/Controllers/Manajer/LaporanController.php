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
        return redirect()->route('manajer.laporan.reservasi', $request->query());
    }

    public function reservasi(Request $request)
    {
        $query = Reservasi::with(['user', 'lahan.cluster']);
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_dimakamkan', [$request->start_date, $request->end_date]);
        }
        if ($request->filled('status')) {
            $query->where('status_reservasi', $request->status);
        }
        $reservasis = $query->latest()->paginate(50);

        return view('manajer.laporan.reservasi', compact('reservasis'));
    }

    public function jenazah(Request $request)
    {
        $jenazahQuery = \App\Models\DetailJenazah::with(['reservasi.user', 'reservasi.lahan.cluster']);
        if ($request->filled('search')) {
            $search = $request->search;
            $jenazahQuery->where(function ($q) use ($search) {
                $q->where('nama_jenazah', 'like', "%{$search}%")
                    ->orWhereHas('reservasi.lahan', function ($lq) use ($search) {
                        $lq->where('nomor_lahan', 'like', "%{$search}%");
                    });
            });
        }
        $jenazahs = $jenazahQuery->latest()->paginate(50);

        return view('manajer.laporan.jenazah', compact('jenazahs'));
    }

    public function lahan(Request $request)
    {
        $lahanQuery = Lahan::with('cluster')->whereIn('status', ['Reservasi (Lunas)', 'Reservasi Cicilan dengan DP', 'Terjual', 'Digunakan']);
        if ($request->filled('status')) {
            if ($request->status === 'Reservasi (Lunas)') {
                $lahanQuery->whereIn('status', ['Reservasi (Lunas)', 'Terjual']);
            } else {
                $lahanQuery->where('status', $request->status);
            }
        }
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
        $lahans = $lahanQuery->latest()->paginate(50);

        return view('manajer.laporan.lahan', compact('lahans'));
    }

    public function pembeli(Request $request)
    {
        $pembeliQuery = User::where('role', 'pembeli')->withCount('reservasis');
        if ($request->filled('search')) {
            $search = $request->search;
            $pembeliQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }
        $pembelis = $pembeliQuery->latest()->paginate(50);

        return view('manajer.laporan.pembeli', compact('pembelis'));
    }

    public function cluster(Request $request)
    {
        $clusterQuery = Cluster::withCount('lahans');
        if ($request->filled('search')) {
            $clusterQuery->where('nama_cluster', 'like', "%{$request->search}%");
        }
        $clusters = $clusterQuery->latest()->paginate(50);

        return view('manajer.laporan.cluster', compact('clusters'));
    }

    public function cetak(Request $request)
    {
        $type = $request->get('type', 'reservasi');
        $data = ['type' => $type];

        switch ($type) {
            case 'lahan':
                $lahanQuery = Lahan::with('cluster')->whereIn('status', ['Reservasi (Lunas)', 'Reservasi Cicilan dengan DP', 'Terjual', 'Digunakan']);
                if ($request->filled('status')) {
                    if ($request->status === 'Reservasi (Lunas)') {
                        $lahanQuery->whereIn('status', ['Reservasi (Lunas)', 'Terjual']);
                    } else {
                        $lahanQuery->where('status', $request->status);
                    }
                }
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
                $jenazahQuery = \App\Models\DetailJenazah::with(['reservasi.user', 'reservasi.lahan.cluster']);
                if ($request->filled('search')) {
                    $search = $request->search;
                    $jenazahQuery->where(function ($q) use ($search) {
                        $q->where('nama_jenazah', 'like', "%{$search}%")
                            ->orWhereHas('reservasi.lahan', function ($lq) use ($search) {
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
