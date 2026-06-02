<?php

namespace App\Http\Controllers\Manajer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Pembayaran;
use App\Models\Lahan;
use App\Models\Cluster;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Data Keuangan (Sinkron dengan Marketing)
        $validPaymentStatuses = ['Lunas', 'Selesai', 'Disetujui', 'Diverifikasi', 'lunas', 'selesai', 'disetujui', 'diverifikasi'];
        $totalRevenue = Pembayaran::whereIn('status_pembayaran', $validPaymentStatuses)->sum('jumlah_bayar');

        // MoM Revenue
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $lastMonth = Carbon::now()->subMonth()->month;
        $lastMonthYear = Carbon::now()->subMonth()->year;

        $currentMonthRevenue = Pembayaran::whereIn('status_pembayaran', $validPaymentStatuses)
            ->whereYear('tanggal_bayar', $currentYear)
            ->whereMonth('tanggal_bayar', $currentMonth)
            ->sum('jumlah_bayar');

        $lastMonthRevenue = Pembayaran::whereIn('status_pembayaran', $validPaymentStatuses)
            ->whereYear('tanggal_bayar', $lastMonthYear)
            ->whereMonth('tanggal_bayar', $lastMonth)
            ->sum('jumlah_bayar');

        $revenueChange = $lastMonthRevenue > 0
            ? (($currentMonthRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100
            : ($currentMonthRevenue > 0 ? 100 : 0);

        // Grafik 6 Bulan
        $revenueData = [];
        $labels = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $revenue = Pembayaran::whereIn('status_pembayaran', $validPaymentStatuses)
                ->whereYear('tanggal_bayar', $date->year)
                ->whereMonth('tanggal_bayar', $date->month)
                ->sum('jumlah_bayar') / 1000000;
            $revenueData[] = round($revenue, 1);
            $labels[] = $date->format('M');
        }

        // Recent Sales
        $recentSales = Reservasi::with(['user', 'lahan.cluster', 'pembayaran'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($reservasi) {
                $statusAsli = $reservasi->pembayaran->status_pembayaran ?? $reservasi->status_reservasi ?? 'Pending';
                $statusTextLower = strtolower($statusAsli);
                if (str_contains($statusTextLower, 'lunas') || str_contains($statusTextLower, 'setuju') || str_contains($statusTextLower, 'verifikasi') || str_contains($statusTextLower, 'selesai')) {
                    $statusColor = 'bg-emerald-100 text-emerald-700 border border-emerald-200';
                } elseif (str_contains($statusTextLower, 'tolak') || str_contains($statusTextLower, 'batal')) {
                    $statusColor = 'bg-rose-100 text-rose-700 border border-rose-200';
                } else {
                    $statusColor = 'bg-amber-100 text-amber-700 border border-amber-200';
                }

                return [
                    'name' => $reservasi->user->name ?? 'N/A',
                    'email' => $reservasi->user->email ?? 'N/A',
                    'type' => $reservasi->lahan ? ($reservasi->lahan->cluster->nama_cluster . ' - ' . $reservasi->lahan->tipe_lahan) : 'N/A',
                    'price' => $reservasi->lahan ? 'Rp ' . number_format($reservasi->lahan->harga, 0, ',', '.') : 'N/A',
                    'status' => $statusAsli,
                    'status_color' => $statusColor
                ];
            });

        // Lahan Stats (Baseline 5800)
        $totalLahan = 5800;
        $occupiedLahan = 1100;
        $availableLahan = 4700;

        $muslimStats = [
            'total' => 3000,
            'terjual' => 500,
            'used' => 100,
            'available' => 2500,
            'booked' => Lahan::whereHas('cluster', fn($q) => $q->where('kategori', 'Muslim'))->whereIn('status', ['Dipesan', 'dipesan'])->count(),
        ];

        $nonMuslimStats = [
            'total' => 2800,
            'terjual' => 600,
            'used' => 200,
            'available' => 2200,
            'booked' => Lahan::whereHas('cluster', fn($q) => $q->where('kategori', 'Non-Muslim'))->whereIn('status', ['Dipesan', 'dipesan'])->count(),
        ];

        return view('manajer.dashboard', compact(
            'totalRevenue',
            'currentMonthRevenue',
            'revenueChange',
            'revenueData',
            'labels',
            'recentSales',
            'totalLahan',
            'availableLahan',
            'occupiedLahan',
            'muslimStats',
            'nonMuslimStats'
        ));
    }
}
