<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;
use App\Models\Pembayaran;
use App\Models\Lahan;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $validPaymentStatuses = ['Lunas', 'Selesai', 'Disetujui', 'Diverifikasi', 'lunas', 'selesai', 'disetujui', 'diverifikasi'];

        $totalRevenue = Pembayaran::whereIn('status_pembayaran', $validPaymentStatuses)
            ->sum('jumlah_bayar');

        $pendingPayments = Pembayaran::whereIn('status_pembayaran', ['Menunggu Konfirmasi', 'menunggu konfirmasi', 'Pending', 'pending'])->count();

        // MoM changes
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

        // Revenue graph data
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

        // Latest financial activity
        $latestPayments = Pembayaran::with(['reservasi.user', 'reservasi.lahan.cluster'])
            ->latest()
            ->take(5)
            ->get();

        return view('accounting.dashboard', compact(
            'totalRevenue',
            'pendingPayments',
            'currentMonthRevenue',
            'revenueChange',
            'revenueData',
            'labels',
            'latestPayments'
        ));
    }
}
