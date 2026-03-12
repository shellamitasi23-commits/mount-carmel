<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - Mount Carmel</title>
    <style>
        body { font-family: 'Arial', sans-serif; color: #333; line-height: 1.6; }
        @media print {
            @page { margin: 2cm; }
            .no-print { display: none; }
        }
        
        /* Gaya Kop Surat */
        .kop-surat { border-bottom: 3px double #000; padding-bottom: 10px; margin-bottom: 20px; display: flex; align-items: center; }
        .logo { width: 80px; height: 80px; background-color: #f0f0f0; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 20px; }
        .info-instansi { flex: 1; text-align: center; }
        .info-instansi h1 { margin: 0; font-size: 24px; text-transform: uppercase; color: #1a1a1a; }
        .info-instansi p { margin: 5px 0 0; font-size: 12px; color: #666; }

        .judul-laporan { text-align: center; margin-bottom: 30px; }
        .judul-laporan h2 { text-transform: uppercase; font-size: 18px; border-bottom: 1px solid #eee; display: inline-block; padding-bottom: 5px; }
        .judul-laporan p { font-size: 11px; color: #777; margin-top: 5px; }

        /* Gaya Tabel */
        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; font-size: 12px; }
        table th { background-color: #f8f9fa; border: 1px solid #ddd; padding: 10px; text-align: left; }
        table td { border: 1px solid #ddd; padding: 10px; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }

        /* Tanda Tangan */
        .tanda-tangan { margin-top: 50px; float: right; width: 250px; text-align: center; }
        .tanda-tangan p { margin-bottom: 80px; }
        .nama-pimpinan { font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body onload="window.print()"> <div class="no-print" style="background: #fff3cd; padding: 10px; text-align: center; margin-bottom: 20px; border: 1px solid #ffeeba; font-size: 13px;">
        Tombol Cetak otomatis muncul. Jika tidak, tekan <b>Ctrl + P</b> untuk mencetak. 
        <a href="javascript:window.close()" style="color: #856404; font-weight: bold; margin-left: 20px;">[Tutup Halaman]</a>
    </div>

    <div class="kop-surat">
        <div class="logo">
            <img src="https://ui-avatars.com/api/?name=Mount+Carmel&background=1e293b&color=fff&size=128" alt="Logo" style="width: 100%; border-radius: 8px;">
        </div>
        <div class="info-instansi">
            <h1>Taman Pemakaman Mount Carmel</h1>
            <p>Jl. Utama Mount Carmel No. 01, Kawasan Bukit Doa, Cirebon, Jawa Barat</p>
            <p>Telp: (0231) 123456 | Email: info@mountcarmel.com | Web: www.mountcarmel.com</p>
        </div>
    </div>

    <div class="judul-laporan">
        <h2>Laporan Rekapitulasi Penjualan Kavling</h2>
        <p>Periode: {{ request('start_date') ?? 'Semua' }} s/d {{ request('end_date') ?? 'Sekarang' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Pembeli</th>
                <th>Kavling & Cluster</th>
                <th>Nama Jenazah</th>
                <th class="text-right">Harga (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @forelse($reservasis as $index => $rs)
                @php $total += $rs->kavling->harga; @endphp
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $rs->created_at->format('d/m/Y') }}</td>
                    <td>{{ $rs->user->name }}</td>
                    <td>{{ $rs->kavling->cluster->nama_cluster }} - {{ $rs->kavling->nomor_kavling }}</td>
                    <td>Alm. {{ $rs->nama_jenazah }}</td>
                    <td class="text-right">{{ number_format($rs->kavling->harga, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="font-bold" style="background-color: #fdfdfd;">
                <td colspan="5" class="text-right">TOTAL PENDAPATAN</td>
                <td class="text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="tanda-tangan">
        <p>Cirebon, {{ date('d F Y') }} <br> Mengetahui, <br> <strong>Pimpinan Mount Carmel</strong></p>
        <p class="nama-pimpinan">{{ auth()->user()->name }}</p>
    </div>

</body>
</html>