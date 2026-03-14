<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Kavling;
use App\Models\Pembayaran;
use App\Models\Reservasi;
use App\Models\User;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Tentukan rentang waktu (Default: bulan ini)
        $startDate = $request->query('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->query('end_date', Carbon::now()->endOfMonth());

        // 2. Kalkulasi Widget Utama
        $totalPendapatan = Pembayaran::where('status_pembayaran', 'Lunas')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('jumlah_bayar');

        $kavlingTerjual = Pembayaran::where('status_pembayaran', 'Lunas')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        $pendapatanTertunda = Pembayaran::where('status_pembayaran', 'Menunggu Konfirmasi')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('jumlah_bayar');

        // 3. Data Grafik Bar (6 Bulan Terakhir)
        $enamBulanLalu = Carbon::now()->subMonths(5)->startOfMonth();
        $grafik = Pembayaran::select(
            DB::raw('SUM(jumlah_bayar) as total'),
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year')
        )
            ->where('status_pembayaran', 'Lunas')
            ->where('created_at', '>=', $enamBulanLalu)
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $chartLabels = [];
        $chartData = [];
        foreach ($grafik as $g) {
            $chartLabels[] = Carbon::create()->month($g->month)->translatedFormat('M y');
            $chartData[] = $g->total / 1000000000; // Konversi ke Miliar untuk UI Grafik
        }

        // 4. Data Tipe Kavling Terlaris
        $tipeTerlaris = Pembayaran::with('reservasi.kavling')
            ->where('status_pembayaran', 'Lunas')
            ->get()
            ->groupBy('reservasi.kavling.tipe_kavling')
            ->map(function ($row) {
                return $row->count();
            })
            ->sortByDesc(function ($count) {
                return $count;
            })->take(3);

        $totalTerjualSemuaTipe = $tipeTerlaris->sum() ?: 1; // Hindari division by zero

        // 5. Rincian Transaksi Selesai (Eager Loading untuk performa)
        $transaksi = Pembayaran::with(['reservasi.user', 'reservasi.kavling'])
            ->where('status_pembayaran', 'Lunas')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.laporan.index', compact(
            'totalPendapatan',
            'kavlingTerjual',
            'pendapatanTertunda',
            'chartLabels',
            'chartData',
            'tipeTerlaris',
            'totalTerjualSemuaTipe',
            'transaksi'
        ));
    }

    public function exportPdf(Request $request)
    {
        // Tarik data asli untuk PDF
        $transactions = Pembayaran::with(['reservasi.user', 'reservasi.kavling'])
            ->where('status_pembayaran', 'Lunas')
            ->orderBy('created_at', 'desc')
            ->get();

        $data = [
            'title' => 'Laporan Penjualan Kavling Mount Carmel',
            'date' => Carbon::now()->translatedFormat('d F Y'),
            'sales' => $transactions // Parsing object asli, bukan array dummy
        ];

        $pdf = Pdf::loadView('admin.laporan.pdf', $data);
        return $pdf->stream('Laporan_Penjualan_Mount_Carmel.pdf');
    }
}