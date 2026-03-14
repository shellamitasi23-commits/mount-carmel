<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $pembayaran->id }} - Mount Carmel</title>
    <style>
        @page { size: A4; margin: 0; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #1a2332; margin: 0; padding: 0; background-color: #ffffff; }
        
        /* Layout Dasar */
        .invoice-box { max-width: 800px; margin: auto; padding: 40px; }
        
        /* Header Section */
        .header { display: table; width: 100%; border-bottom: 2px solid #f0f4f8; padding-bottom: 20px; }
        .brand { display: table-cell; vertical-align: middle; }
        .brand h1 { color: #1a2332; margin: 0; font-size: 24px; text-transform: uppercase; letter-spacing: 2px; }
        .brand p { color: #4a9fb5; margin: 5px 0 0; font-size: 12px; font-weight: bold; }
        .invoice-details { display: table-cell; text-align: right; vertical-align: middle; }
        .invoice-details h2 { color: #6b7a8d; margin: 0; font-size: 18px; }
        .invoice-details p { margin: 3px 0; font-size: 12px; color: #b0bcc8; }

        /* Information Section */
        .info-section { display: table; width: 100%; margin: 30px 0; }
        .info-box { display: table-cell; width: 50%; vertical-align: top; }
        .info-box h3 { font-size: 10px; text-transform: uppercase; color: #b0bcc8; letter-spacing: 1px; margin-bottom: 10px; }
        .info-box p { font-size: 13px; line-height: 1.6; margin: 0; font-weight: bold; }

        /* Table Section */
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table thead th { background-color: #1a2332; color: #ffffff; text-align: left; padding: 12px; font-size: 12px; text-transform: uppercase; }
        table tbody td { padding: 15px 12px; border-bottom: 1px solid #f0f4f8; font-size: 13px; }
        
        /* Total Section */
        .total-wrapper { text-align: right; margin-top: 30px; }
        .total-table { width: 40%; margin-left: auto; }
        .total-table td { padding: 8px 12px; border: none; }
        .total-amount { background-color: #4a9fb5; color: #ffffff; font-weight: bold; font-size: 16px !important; border-radius: 5px; }

        /* Status Badge */
        .badge { display: inline-block; padding: 4px 12px; border-radius: 15px; font-size: 11px; font-weight: bold; text-transform: uppercase; }
        .badge-success { background-color: #e8f6f3; color: #27ae60; border: 1px solid #27ae60; }
        .badge-pending { background-color: #fef9e7; color: #f1c40f; border: 1px solid #f1c40f; }

        /* Footer */
        .footer { margin-top: 50px; text-align: center; border-top: 1px solid #f0f4f8; padding-top: 20px; }
        .footer p { font-size: 11px; color: #b0bcc8; margin: 5px 0; }
        .watermark { position: absolute; top: 40%; left: 25%; font-size: 80px; color: rgba(26, 35, 50, 0.03); transform: rotate(-45deg); z-index: -1; }
    </style>
</head>
<body>

<div class="invoice-box">
    <div class="watermark">MOUNT CARMEL</div>

    <div class="header">
        <div class="brand">
            <h1>MOUNT CARMEL</h1>
            <p>MEMORIAL PARK & FUNERAL SERVICE</p>
        </div>
        <div class="invoice-details">
            <h2>INVOICE PEMBAYARAN</h2>
            <p>ID Transaksi: #TRX-{{ str_pad($pembayaran->id, 5, '0', STR_PAD_LEFT) }}</p>
            <p>Tanggal: {{ $pembayaran->created_at->format('d F Y') }}</p>
        </div>
    </div>

    <div class="info-section">
        <div class="info-box">
            <h3>DITAGIHKAN KEPADA:</h3>
            <p>{{ $pembayaran->user->name }}</p>
            <p style="font-weight: normal; color: #6b7a8d;">{{ $pembayaran->user->email }}</p>
            <p style="font-weight: normal; color: #6b7a8d;">{{ $pembayaran->user->no_telepon ?? '-' }}</p>
        </div>
        <div class="info-box" style="text-align: right;">
            <h3>LOKASI KAVLING:</h3>
            <p>Cluster {{ $pembayaran->reservasi->kavling->cluster->nama_cluster }}</p>
            <p>Nomor Kavling: {{ $pembayaran->reservasi->kavling->nomor_kavling }}</p>
            <p style="font-weight: normal; color: #6b7a8d;">Tipe: {{ $pembayaran->reservasi->kavling->tipe_kavling }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Deskripsi Layanan</th>
                <th>Nama Jenazah</th>
                <th style="text-align: right;">Harga</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>Reservasi Lahan Pemakaman</strong><br>
                    <small style="color: #6b7a8d;">Pemesanan lahan kavling eksklusif Mount Carmel</small>
                </td>
                <td>{{ $pembayaran->reservasi->nama_jenazah }}</td>
                <td style="text-align: right;">Rp {{ number_format($pembayaran->reservasi->kavling->harga, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="total-wrapper">
        <table class="total-table">
            <tr>
                <td style="color: #6b7a8d;">Subtotal</td>
                <td>Rp {{ number_format($pembayaran->reservasi->kavling->harga, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="color: #6b7a8d;">Status Pembayaran</td>
                <td>
                    <span class="badge {{ $pembayaran->status_pembayaran == 'Lunas' ? 'badge-success' : 'badge-pending' }}">
                        {{ $pembayaran->status_pembayaran }}
                    </span>
                </td>
            </tr>
            <tr class="total-amount">
                <td>TOTAL</td>
                <td>Rp {{ number_format($pembayaran->reservasi->kavling->harga, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <div style="margin-top: 40px; font-size: 11px; color: #6b7a8d; background: #f9fbfe; padding: 15px; border-radius: 10px;">
        <strong>Catatan Penting:</strong>
        <ul style="margin: 5px 0 0; padding-left: 15px;">
            <li>Invoice ini adalah bukti pembayaran yang sah setelah divalidasi oleh sistem.</li>
            <li>Harap simpan invoice ini untuk proses penerbitan Sertifikat Hak Guna Lahan.</li>
            <li>Layanan Mount Carmel tersedia 24 jam untuk bantuan operasional pemakaman.</li>
        </ul>
    </div>

    <div class="footer">
        <p>Terima kasih telah mempercayakan layanan kepada Mount Carmel Memorial Park.</p>
        <p>Jl. Raya Mount Carmel No. 01, Jawa Tengah | www.mountcarmel.co.id | (024) 123-4567</p>
    </div>
</div>

<script>
    // Otomatis memicu dialog cetak saat halaman dibuka (untuk demo)
    window.print();
</script>

</body>
</html>