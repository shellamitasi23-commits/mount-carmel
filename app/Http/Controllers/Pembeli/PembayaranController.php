<?php

namespace App\Http\Controllers\Pembeli;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Reservasi;

class PembayaranController extends Controller
{
    /**
     * index() = RIWAYAT pembayaran + tombol invoice
     * Dipanggil dari navbar klik "Pembayaran"
     * URL: GET /pembeli/pembayaran  (TANPA parameter)
     */
    public function index()
    {
        return redirect()->route('profil.index', ['tab' => 'pembayaran']);
    }

    /**
     * create() = FORM upload bukti transfer
     * Dipanggil setelah reservasi berhasil disimpan
     * URL: GET /pembeli/pembayaran/create?reservasi_id=3
     */
    public function create(Request $request)
    {
        $request->validate([
            'reservasi_id' => 'required|exists:reservasis,id',
        ]);

        // Pastikan reservasi milik user ini
        $reservasi = Reservasi::with(['lahan.cluster', 'user', 'pembayarans'])
            ->where('user_id', auth()->id())
            ->findOrFail($request->reservasi_id);

        // Cek jika ada pembayaran yang masih Menunggu Konfirmasi
        $hasPending = $reservasi->pembayarans->where('status_pembayaran', 'Menunggu Konfirmasi')->isNotEmpty();
        if ($hasPending) {
            return redirect()
                ->route('pembeli.pembayaran.index')
                ->with('error', 'Pembayaran Anda sebelumnya masih dalam verifikasi admin.');
        }

        $isTunai = $reservasi->jenis_pembayaran === 'tunai';
        $tenor = $reservasi->tenor_cicilan ?? 1;

        if ($isTunai) {
            // Cek apakah sudah pernah lunas
            $sudahLunas = $reservasi->pembayarans->where('status_pembayaran', 'Lunas')->isNotEmpty();
            if ($sudahLunas) {
                return redirect()
                    ->route('pembeli.pembayaran.index')
                    ->with('error', 'Pembayaran untuk reservasi ini sudah lunas.');
            }

            $pembayaranKe = 1;
            $totalCicilan = 1;
            $namaPembayaran = 'Pembayaran Penuh';
            $jumlahBayar = $reservasi->biaya_penuh;
        } else {
            $menggunakanDP = $reservasi->biaya_reservasi > 0;
            if ($menggunakanDP) {
                // Cek apakah DP sudah lunas
                $dpLunas = $reservasi->pembayarans->where('cicilan_ke', 0)->where('status_pembayaran', 'Lunas')->isNotEmpty();
                if (!$dpLunas) {
                    $pembayaranKe = 0;
                    $totalCicilan = $tenor;
                    $namaPembayaran = 'Uang Muka / DP';
                    $jumlahBayar = $reservasi->biaya_reservasi;
                } else {
                    // Cari cicilan tertinggi yang sudah lunas
                    $highestLunas = $reservasi->pembayarans->where('status_pembayaran', 'Lunas')
                        ->where('cicilan_ke', '>', 0)
                        ->max('cicilan_ke') ?? 0;

                    if ($highestLunas >= $tenor) {
                        return redirect()
                            ->route('pembeli.pembayaran.index')
                            ->with('error', 'Semua cicilan untuk reservasi ini sudah lunas.');
                    }

                    $pembayaranKe = $highestLunas + 1;
                    $totalCicilan = $tenor;
                    $namaPembayaran = "Cicilan Ke-{$pembayaranKe} dari {$totalCicilan}";
                    // sisa dibagi tenor
                    $jumlahBayar = ($reservasi->biaya_penuh - $reservasi->biaya_reservasi) / $tenor;
                }
            } else {
                // Cicilan langsung (tanpa DP)
                $highestLunas = $reservasi->pembayarans->where('status_pembayaran', 'Lunas')
                    ->where('cicilan_ke', '>', 0)
                    ->max('cicilan_ke') ?? 0;

                if ($highestLunas >= $tenor) {
                    return redirect()
                        ->route('pembeli.pembayaran.index')
                        ->with('error', 'Semua cicilan untuk reservasi ini sudah lunas.');
                }

                $pembayaranKe = $highestLunas + 1;
                $totalCicilan = $tenor;
                $namaPembayaran = "Cicilan Ke-{$pembayaranKe} dari {$totalCicilan}";
                $jumlahBayar = $reservasi->biaya_penuh / $tenor;
            }
        }

        $rekening = [
            ['bank' => 'BCA', 'nomor' => '8890123456', 'atas_nama' => 'PT Mount Carmel'],
            ['bank' => 'BNI', 'nomor' => '1234567890', 'atas_nama' => 'PT Mount Carmel'],
            ['bank' => 'Mandiri', 'nomor' => '1380012345678', 'atas_nama' => 'PT Mount Carmel'],
        ];

        return view('pembeli.pembayaran.create', compact('reservasi', 'rekening', 'jumlahBayar', 'pembayaranKe', 'namaPembayaran', 'isTunai'));
    }

    /**
     * store() = SIMPAN bukti pembayaran
     * URL: POST /pembeli/pembayaran
     */
    public function store(Request $request)
    {
        $request->validate([
            'reservasi_id' => 'required|exists:reservasis,id',
            'nama_bank' => 'required|string|max:50',
            'rekening_tujuan' => 'required|string|max:50',
            'atas_nama_rekening' => 'required|string|max:100',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
            'catatan' => 'nullable|string|max:500',
        ], [
            'nama_bank.required' => 'Pilih rekening tujuan terlebih dahulu.',
            'bukti_pembayaran.required' => 'Bukti transfer wajib diunggah.',
            'bukti_pembayaran.max' => 'Ukuran file maksimal 4MB.',
        ]);

        $reservasi = Reservasi::with(['pembayarans'])
            ->where('user_id', auth()->id())
            ->findOrFail($request->reservasi_id);

        // Cegah double submit
        $hasPending = $reservasi->pembayarans->where('status_pembayaran', 'Menunggu Konfirmasi')->isNotEmpty();
        if ($hasPending) {
            return redirect()
                ->route('pembeli.pembayaran.index')
                ->with('error', 'Pembayaran Anda sebelumnya masih dalam verifikasi admin.');
        }

        $isTunai = $reservasi->jenis_pembayaran === 'tunai';
        $tenor = $reservasi->tenor_cicilan ?? 1;

        if ($isTunai) {
            $sudahLunas = $reservasi->pembayarans->where('status_pembayaran', 'Lunas')->isNotEmpty();
            if ($sudahLunas) {
                return redirect()
                    ->route('pembeli.pembayaran.index')
                    ->with('error', 'Pembayaran untuk reservasi ini sudah lunas.');
            }

            $cicilanKe = 1;
            $totalCicilan = 1;
            $jumlahBayar = $reservasi->biaya_penuh;
        } else {
            $menggunakanDP = $reservasi->biaya_reservasi > 0;
            if ($menggunakanDP) {
                $dpLunas = $reservasi->pembayarans->where('cicilan_ke', 0)->where('status_pembayaran', 'Lunas')->isNotEmpty();
                if (!$dpLunas) {
                    $cicilanKe = 0;
                    $totalCicilan = $tenor;
                    $jumlahBayar = $reservasi->biaya_reservasi;
                } else {
                    $highestLunas = $reservasi->pembayarans->where('status_pembayaran', 'Lunas')
                        ->where('cicilan_ke', '>', 0)
                        ->max('cicilan_ke') ?? 0;

                    if ($highestLunas >= $tenor) {
                        return redirect()
                            ->route('pembeli.pembayaran.index')
                            ->with('error', 'Semua cicilan untuk reservasi ini sudah lunas.');
                    }

                    $cicilanKe = $highestLunas + 1;
                    $totalCicilan = $tenor;
                    $jumlahBayar = ($reservasi->biaya_penuh - $reservasi->biaya_reservasi) / $tenor;
                }
            } else {
                // Cicilan langsung (tanpa DP)
                $highestLunas = $reservasi->pembayarans->where('status_pembayaran', 'Lunas')
                    ->where('cicilan_ke', '>', 0)
                    ->max('cicilan_ke') ?? 0;

                if ($highestLunas >= $tenor) {
                    return redirect()
                        ->route('pembeli.pembayaran.index')
                        ->with('error', 'Semua cicilan untuk reservasi ini sudah lunas.');
                }

                $cicilanKe = $highestLunas + 1;
                $totalCicilan = $tenor;
                $jumlahBayar = $reservasi->biaya_penuh / $tenor;
            }
        }

        $path = $request->file('bukti_pembayaran')->store('bukti_bayar', 'public');

        $noInvoice = 'INV-' . date('Ymd') . '-' . strtoupper(substr(md5($reservasi->id . time()), 0, 6));

        $pembayaran = Pembayaran::create([
            'reservasi_id' => $reservasi->id,
            'no_invoice' => $noInvoice,
            'jumlah_bayar' => $jumlahBayar,
            'tanggal_bayar' => now()->toDateString(),
            'nama_bank' => $request->nama_bank,
            'rekening_tujuan' => $request->rekening_tujuan,
            'atas_nama_rekening' => $request->atas_nama_rekening,
            'bukti_pembayaran' => $path,
            'catatan' => $request->catatan,
            'status_pembayaran' => 'Menunggu Konfirmasi',
            'cicilan_ke' => $cicilanKe,
            'total_cicilan' => $totalCicilan,
        ]);

        $reservasi->update(['status_pembayaran' => 'Menunggu Konfirmasi']);

        return redirect()
            ->route('pembeli.pembayaran.invoice', $pembayaran->id)
            ->with('success', 'Bukti pembayaran berhasil dikirim! Admin akan memverifikasi dalam 1×24 jam.');
    }

    /**
     * invoice() = Cetak invoice
     * URL: GET /pembeli/pembayaran/invoice/{id}
     */
    public function invoice($id)
    {
        $pembayaran = Pembayaran::with(['reservasi.lahan.cluster', 'reservasi.user'])->findOrFail($id);

        // Jika pembeli, pastikan hanya bisa lihat invoice miliknya sendiri
        if (auth()->user()->role === 'pembeli') {
            if ($pembayaran->reservasi->user_id !== auth()->id()) {
                abort(403, 'Anda tidak memiliki akses ke invoice ini.');
            }
        }

        return view('pembeli.pembayaran.invoice', compact('pembayaran'));
    }
}