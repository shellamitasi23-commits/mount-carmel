<?php

namespace App\Http\Controllers\Marketing;

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
        // 1. Total Pendapatan
        $validPaymentStatuses = ['Lunas', 'Selesai', 'Disetujui', 'Diverifikasi', 'lunas', 'selesai', 'disetujui', 'diverifikasi'];

        $totalRevenue = Pembayaran::whereIn('status_pembayaran', $validPaymentStatuses)
            ->sum('jumlah_bayar');

        $maintenanceCost = 582000000; // Rp 582 Jt

        // 2. Statistik bulan ini vs bulan lalu
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

        // 3. Data untuk grafik pendapatan (6 bulan terakhir)
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

        // 4. Laporan penjualan terbaru
        $recentSales = Reservasi::with(['user', 'lahan.cluster', 'pembayaran'])
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($reservasi) {
                if ($reservasi->pembayaran) {
                    $statusAsli = $reservasi->pembayaran->status_pembayaran;
                } else {
                    $statusAsli = $reservasi->status_reservasi ?? 'Pending';
                }

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

        // 5. Lahan premium
        $premiumLahans = Lahan::with('cluster')
            ->whereIn('status', ['Tersedia', 'tersedia'])
            ->orderBy('harga', 'desc')
            ->take(2)
            ->get();

        // 6. Statistik lahan mendalam (Sesuai Data Asli User)
        $muslimStats = [
            'total'     => 3000,
            'terjual'   => 500,
            'used'      => 100,
            'available' => 3000 - 500, // Sisa Lahan
            'booked'    => Lahan::whereHas('cluster', fn($q) => $q->where('kategori', 'Muslim'))->whereIn('status', ['Dipesan', 'dipesan'])->count(), // Live data tetap dipantau
        ];

        $nonMuslimStats = [
            'total'     => 2800,
            'terjual'   => 600,
            'used'      => 200,
            'available' => 2800 - 600, // Sisa Lahan
            'booked'    => Lahan::whereHas('cluster', fn($q) => $q->where('kategori', 'Non-Muslim'))->whereIn('status', ['Dipesan', 'dipesan'])->count(),
        ];

        $totalLahan = 5800; // Total 3000 + 2800
        $occupiedLahan = 500 + 600; // Total Terjual
        $availableLahan = $totalLahan - $occupiedLahan;

        return view('marketing.dashboard', compact(
            'totalRevenue',
            'maintenanceCost',
            'currentMonthRevenue',
            'revenueChange',
            'revenueData',
            'labels',
            'recentSales',
            'premiumLahans',
            'totalLahan',
            'availableLahan',
            'occupiedLahan',
            'muslimStats',
            'nonMuslimStats'
        ));
    }
}
