<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Import class PDF

class LaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }
    public function exportPdf()
    {
        $data = [
            'title' => 'Laporan Penjualan Kavling Mount Carmel',
            'date' => date('d M Y'),
            'sales' => [
                ['tanggal' => '12 Nov 2023', 'invoice' => 'INV-202311-001', 'nama' => 'Budi Santoso', 'tipe' => 'Muslim - Fitrah', 'nominal' => 'Rp 150.000.000'],
                ['tanggal' => '10 Nov 2023', 'invoice' => 'INV-202311-002', 'nama' => 'Keluarga Lee', 'tipe' => 'Non-Muslim - VIP', 'nominal' => 'Rp 1.250.000.000'],
            ]
        ];

        $pdf = Pdf::loadView('admin.laporan.pdf', $data);
        return $pdf->stream('Laporan_Penjualan_Mount_Carmel.pdf');
    }
}