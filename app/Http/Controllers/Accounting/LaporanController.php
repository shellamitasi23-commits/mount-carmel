<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Lahan;
use App\Models\User;
use App\Models\Cluster;
use App\Models\Pembayaran;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        return redirect()->route('accounting.laporan.pembayaran', $request->query());
    }

    public function pembayaran(Request $request)
    {
        $query = Pembayaran::with(['reservasi.user', 'reservasi.lahan.cluster']);
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_bayar', [$request->start_date, $request->end_date]);
        }
        if ($request->filled('status')) {
            $query->where('status_pembayaran', $request->status);
        }
        $pembayarans = $query->latest()->paginate(50);

        return view('accounting.laporan.pembayaran', compact('pembayarans'));
    }

    public function reservasi(Request $request)
    {
        $query = Reservasi::with(['user', 'lahan.cluster', 'pembayarans']);
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }
        if ($request->filled('status')) {
            $query->where('status_reservasi', $request->status);
        }
        $reservasis = $query->latest()->paginate(50);

        return view('accounting.laporan.reservasi', compact('reservasis'));
    }

    public function exportPdf(Request $request)
    {
        $type = $request->get('type', 'pembayaran');
        $date = now()->format('d F Y');
        $title = 'LAPORAN KEUANGAN MOUNT CARMEL';

        $data = ['type' => $type, 'date' => $date, 'title' => $title];

        switch ($type) {
            case 'reservasi':
                $query = Reservasi::with(['user', 'lahan.cluster', 'pembayarans']);
                if ($request->filled('start_date') && $request->filled('end_date')) {
                    $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
                }
                if ($request->filled('status')) {
                    $query->where('status_reservasi', $request->status);
                }
                $data['reservasis'] = $query->latest()->get();
                break;

            default: // pembayaran
                $query = Pembayaran::with(['reservasi.user', 'reservasi.lahan.cluster']);
                if ($request->filled('start_date') && $request->filled('end_date')) {
                    $query->whereBetween('tanggal_bayar', [$request->start_date, $request->end_date]);
                }
                if ($request->filled('status')) {
                    $query->where('status_pembayaran', $request->status);
                }
                $data['pembayarans'] = $query->latest()->get();
                break;
        }

        $pdf = Pdf::loadView('manajer.laporan.cetak', $data);
        return $pdf->download('laporan-' . $type . '-' . date('Y-m-d') . '.pdf');
    }
}
