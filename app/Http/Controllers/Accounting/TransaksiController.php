<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Reservasi;
use App\Models\Lahan;

class TransaksiController extends Controller
{
    public function pembayaran(Request $request)
    {
        $query = Pembayaran::with(['reservasi.user', 'reservasi.lahan.cluster']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('no_invoice', 'like', '%' . $search . '%')
                    ->orWhereHas('reservasi.user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('reservasi.lahan', function ($lahanQuery) use ($search) {
                        $lahanQuery->where('nomor_lahan', 'like', '%' . $search . '%')
                            ->orWhere('tipe_lahan', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('reservasi.lahan.cluster', function ($clusterQuery) use ($search) {
                        $clusterQuery->where('nama_cluster', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status_pembayaran', $request->status);
        }

        $sort = $request->input('sort', 'desc');
        if (!in_array($sort, ['asc', 'desc'])) {
            $sort = 'desc';
        }
        $query->orderBy('created_at', $sort);

        $pembayarans = $query->paginate(15)->appends($request->all());

        return view('accounting.transaksi.pembayaran', compact('pembayarans'));
    }

    public function konfirmasiPembayaran(Request $request, $id)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:Lunas,Ditolak',
        ]);

        $pembayaran = Pembayaran::with(['reservasi.lahan'])->findOrFail($id);
        $reservasi = $pembayaran->reservasi;

        $pembayaran->update([
            'status_pembayaran' => $request->status_pembayaran,
            'dikonfirmasi_oleh' => auth()->user()->name
        ]);

        if ($request->status_pembayaran === 'Lunas') {
            if ($reservasi->jenis_pembayaran === 'cicilan') {
                if ($pembayaran->cicilan_ke === 0) {
                    // Jika DP lunas, setujui reservasi secara otomatis
                    $reservasi->update([
                        'status_pembayaran' => 'DP Lunas',
                        'status_reservasi' => 'Disetujui'
                    ]);
                    if ($reservasi->lahan_id) {
                        $reservasi->lahan->update(['status' => 'Reservasi Cicilan dengan DP']);
                    }
                } else {
                    $tenor = $reservasi->tenor_cicilan ?? 1;
                    if ($pembayaran->cicilan_ke >= $tenor) {
                        // Jika cicilan terakhir lunas
                        $reservasi->update([
                            'status_pembayaran' => 'Lunas',
                            'status_reservasi' => 'Selesai'
                        ]);
                        if ($reservasi->lahan_id) {
                            $statusLahan = $reservasi->nama_jenazah ? 'Digunakan' : 'Terjual';
                            $reservasi->lahan->update(['status' => $statusLahan]);
                        }
                    } else {
                        // Jika cicilan antara lunas
                        $reservasi->update([
                            'status_pembayaran' => "Cicilan Ke-{$pembayaran->cicilan_ke} Lunas"
                        ]);
                        if ($reservasi->lahan_id) {
                            $reservasi->lahan->update(['status' => 'Reservasi Cicilan dengan DP']);
                        }
                    }
                }
            } else {
                // Jika tunai lunas
                $reservasi->update([
                    'status_pembayaran' => 'Lunas',
                    'status_reservasi' => 'Selesai'
                ]);
                if ($reservasi->lahan_id) {
                    $statusLahan = $reservasi->nama_jenazah ? 'Digunakan' : 'Terjual';
                    $reservasi->lahan->update(['status' => $statusLahan]);
                }
            }
        } else if ($request->status_pembayaran === 'Ditolak') {
            // Cari status lunas sebelumnya
            $hasDpLunas = Pembayaran::where('reservasi_id', $pembayaran->reservasi_id)
                ->where('cicilan_ke', 0)
                ->where('status_pembayaran', 'Lunas')
                ->exists();

            if ($reservasi->jenis_pembayaran === 'cicilan' && $hasDpLunas) {
                // Cari cicilan tertinggi yang disetujui sebelumnya
                $highestLunas = Pembayaran::where('reservasi_id', $pembayaran->reservasi_id)
                    ->where('status_pembayaran', 'Lunas')
                    ->where('cicilan_ke', '>', 0)
                    ->max('cicilan_ke');

                if ($highestLunas) {
                    $reservasi->update([
                        'status_pembayaran' => "Cicilan Ke-{$highestLunas} Lunas"
                    ]);
                } else {
                    $reservasi->update([
                        'status_pembayaran' => 'DP Lunas'
                    ]);
                }
            } else {
                // Jika tidak ada DP lunas sebelumnya, kembalikan status
                $reservasi->update([
                    'status_pembayaran' => 'Ditolak'
                ]);
                if ($reservasi->lahan_id) {
                    $reservasi->lahan->update(['status' => 'Tersedia']);
                }
            }
        }

        return redirect()->back()->with('success', 'Status pembayaran berhasil dikonfirmasi oleh Accounting.');
    }

    public function reservasi(Request $request)
    {
        $query = Reservasi::with(['user', 'lahan.cluster', 'pembayarans']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%');
                })
                ->orWhereHas('lahan', function ($lahanQuery) use ($search) {
                    $lahanQuery->where('nomor_lahan', 'like', '%' . $search . '%');
                });
            });
        }

        if ($request->filled('status')) {
            $query->where('status_reservasi', $request->status);
        }

        $sort = $request->input('sort', 'desc');
        if (!in_array($sort, ['asc', 'desc'])) {
            $sort = 'desc';
        }
        $query->orderBy('created_at', $sort);

        $reservasis = $query->paginate(15)->appends($request->all());

        return view('accounting.transaksi.reservasi', compact('reservasis'));
    }

    public function updateReservasiStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu Validasi,Disetujui,Ditolak,Selesai',
        ]);

        $reservasi = Reservasi::findOrFail($id);
        $reservasi->update([
            'status_reservasi' => $request->status,
            'disetujui_oleh' => auth()->user()->name
        ]);

        if ($request->status === 'Ditolak') {
            Lahan::where('id', $reservasi->lahan_id)->update(['status' => 'Tersedia']);
            $reservasi->update(['status_pembayaran' => 'Belum Bayar']);
        }

        if ($request->status === 'Selesai') {
            $statusLahan = $reservasi->nama_jenazah ? 'Digunakan' : 'Terjual';
            Lahan::where('id', $reservasi->lahan_id)->update(['status' => $statusLahan]);
        }

        return redirect()->back()->with('success', 'Status reservasi berhasil diperbarui oleh Accounting.');
    }

    public function createPembayaran(Request $request)
    {
        $reservasis = Reservasi::with(['user', 'lahan.cluster', 'pembayarans'])
            ->where('status_reservasi', '!=', 'Ditolak')
            ->where(function($q) {
                $q->whereNull('status_pembayaran')
                  ->orWhere('status_pembayaran', '!=', 'Lunas');
            })
            ->latest()
            ->get();

        $rekening = [
            ['bank' => 'BCA', 'nomor' => '8890123456', 'atas_nama' => 'PT Mount Carmel'],
            ['bank' => 'BNI', 'nomor' => '1234567890', 'atas_nama' => 'PT Mount Carmel'],
            ['bank' => 'Mandiri', 'nomor' => '1380012345678', 'atas_nama' => 'PT Mount Carmel'],
        ];

        return view('accounting.transaksi.pembayaran_create', compact('reservasis', 'rekening'));
    }

    public function storePembayaran(Request $request)
    {
        $request->validate([
            'reservasi_id' => 'required|exists:reservasis,id',
            'tanggal_bayar' => 'required|date',
            'nama_bank' => 'required|string|max:50',
            'rekening_tujuan' => 'required|string|max:50',
            'atas_nama_rekening' => 'required|string|max:100',
            'jumlah_bayar' => 'required|numeric|min:0',
            'catatan' => 'nullable|string|max:500',
        ]);

        $reservasi = Reservasi::with(['pembayarans'])->findOrFail($request->reservasi_id);

        $isTunai = $reservasi->jenis_pembayaran === 'tunai';
        $tenor = $reservasi->tenor_cicilan ?? 1;

        if ($isTunai) {
            $pembayaranKe = 1;
            $totalCicilan = 1;
        } else {
            $menggunakanDP = $reservasi->biaya_reservasi > 0;
            if ($menggunakanDP) {
                $dpLunas = $reservasi->pembayarans->where('cicilan_ke', 0)->where('status_pembayaran', 'Lunas')->isNotEmpty();
                if (!$dpLunas) {
                    $pembayaranKe = 0;
                    $totalCicilan = $tenor;
                } else {
                    $highestLunas = $reservasi->pembayarans->where('status_pembayaran', 'Lunas')
                        ->where('cicilan_ke', '>', 0)
                        ->max('cicilan_ke') ?? 0;
                    $pembayaranKe = $highestLunas + 1;
                    $totalCicilan = $tenor;
                }
            } else {
                $highestLunas = $reservasi->pembayarans->where('status_pembayaran', 'Lunas')
                    ->where('cicilan_ke', '>', 0)
                    ->max('cicilan_ke') ?? 0;
                $pembayaranKe = $highestLunas + 1;
                $totalCicilan = $tenor;
            }
        }

        // Generate invoice number
        $noInvoice = 'INV/' . now()->format('Ymd') . '/' . strtoupper(bin2hex(random_bytes(4)));

        $pembayaran = Pembayaran::create([
            'reservasi_id' => $reservasi->id,
            'no_invoice' => $noInvoice,
            'jumlah_bayar' => $request->jumlah_bayar,
            'tanggal_bayar' => $request->tanggal_bayar,
            'status_pembayaran' => 'Lunas', // Diinput langsung oleh Accounting, langsung Lunas
            'nama_bank' => $request->nama_bank,
            'rekening_tujuan' => $request->rekening_tujuan,
            'atas_nama_rekening' => $request->atas_nama_rekening,
            'catatan' => $request->catatan,
            'cicilan_ke' => $pembayaranKe,
            'total_cicilan' => $totalCicilan,
            'dibayar_oleh' => $reservasi->user->name,
            'dikonfirmasi_oleh' => auth()->user()->name,
        ]);

        // Update status reservasi & status lahan
        if ($reservasi->jenis_pembayaran === 'cicilan') {
            if ($pembayaranKe === 0) {
                $reservasi->update([
                    'status_pembayaran' => 'DP Lunas',
                    'status_reservasi' => 'Disetujui'
                ]);
                if ($reservasi->lahan_id) {
                    $reservasi->lahan->update(['status' => 'Reservasi Cicilan dengan DP']);
                }
            } else {
                if ($pembayaranKe >= $tenor) {
                    $reservasi->update([
                        'status_pembayaran' => 'Lunas',
                        'status_reservasi' => 'Selesai'
                    ]);
                    if ($reservasi->lahan_id) {
                        $statusLahan = $reservasi->nama_jenazah ? 'Digunakan' : 'Terjual';
                        $reservasi->lahan->update(['status' => $statusLahan]);
                    }
                } else {
                    $reservasi->update([
                        'status_pembayaran' => "Cicilan Ke-{$pembayaranKe} Lunas"
                    ]);
                    if ($reservasi->lahan_id) {
                        $reservasi->lahan->update(['status' => 'Reservasi Cicilan dengan DP']);
                    }
                }
            }
        } else {
            $reservasi->update([
                'status_pembayaran' => 'Lunas',
                'status_reservasi' => 'Selesai'
            ]);
            if ($reservasi->lahan_id) {
                $statusLahan = $reservasi->nama_jenazah ? 'Digunakan' : 'Terjual';
                $reservasi->lahan->update(['status' => $statusLahan]);
            }
        }

        return redirect()->route('accounting.pembayaran.index')
            ->with('success', 'Pembayaran berhasil diinput langsung oleh divisi Accounting.');
    }
}
