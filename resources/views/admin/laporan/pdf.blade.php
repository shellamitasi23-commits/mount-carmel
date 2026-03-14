<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #1a2332; padding-bottom: 10px; }
        .header h1 { margin: 0; color: #1a2332; font-size: 20px; }
        .header p { margin: 5px 0 0 0; color: #666; }
        /* TYPO DIPERBAIKI DI SINI (width: 100%) */
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #4a9fb5; color: white; font-weight: bold; }
        tr:nth-child(even) { background-color: #f9f9f9; }
    </style>
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
                <th>Tipe Kavling</th>
                <th>Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sales as $sale)
            <tr>
                <td>{{ $sale->created_at->format('d M Y') }}</td>
                <td>{{ $sale->no_invoice }}</td>
                <td>{{ $sale->reservasi->user->name ?? 'N/A' }}</td>
                <td>{{ $sale->reservasi->kavling->tipe_kavling ?? 'N/A' }}</td>
                <td>Rp {{ number_format($sale->jumlah_bayar, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>