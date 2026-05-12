<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Pembayaran;
use App\Models\Kavling;
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
        $recentSales = Reservasi::with(['user', 'kavling.cluster', 'pembayaran'])
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
                    'type' => $reservasi->kavling ? ($reservasi->kavling->cluster->nama_cluster . ' - ' . $reservasi->kavling->tipe_kavling) : 'N/A',
                    'price' => $reservasi->kavling ? 'Rp ' . number_format($reservasi->kavling->harga, 0, ',', '.') : 'N/A',
                    'status' => $statusAsli,
                    'status_color' => $statusColor
                ];
            });

        // 5. Kavling premium
        $premiumKavlings = Kavling::with('cluster')
            ->whereIn('status', ['Tersedia', 'tersedia'])
            ->orderBy('harga', 'desc')
            ->take(2)
            ->get();

        // 6. Statistik kavling keseluruhan
        $totalKavling = Kavling::count();
        $availableKavling = Kavling::whereIn('status', ['Tersedia', 'tersedia'])->count();
        $occupiedKavling = Kavling::whereIn('status', ['Terjual', 'terjual', 'Dipesan', 'dipesan', 'Terisi', 'terisi'])->count();

        return view('marketing.dashboard', compact(
            'totalRevenue',
            'maintenanceCost',
            'currentMonthRevenue',
            'revenueChange',
            'revenueData',
            'labels',
            'recentSales',
            'premiumKavlings',
            'totalKavling',
            'availableKavling',
            'occupiedKavling'
        ));
    }
}
