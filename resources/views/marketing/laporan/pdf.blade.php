<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan PDF</title>
    <link rel="stylesheet" href="{{ public_path('css/report-pdf.css') }}">
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>Tanggal Cetak: {{ $date }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>No. Invoice</th>
                <th>Pelanggan</th>
                <th>Tipe Lahan</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td>{{ $sale->created_at->format('d M Y') }}</td>
                <td>{{ $sale->no_invoice }}</td>
                <td>{{ $sale->reservasi->user->name ?? 'N/A' }}</td>
                <td>{{ $sale->reservasi->lahan->tipe_lahan ?? 'N/A' }}</td>
                <td>Rp {{ number_format($sale->jumlah_bayar, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
