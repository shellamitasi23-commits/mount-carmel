<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $pembayaran->no_invoice }} — Mount Carmel</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,700;1,600&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #E5E7EB;
            color: #1F2937;
            padding: 40px 20px;
            display: flex;
            flex-direction: column; /* Mengatur elemen berbaris ke bawah */
            align-items: center;    /* Memastikan semuanya berada di tengah */
            min-height: 100vh;
        }

        /* ── PRINT BUTTON (Tepat di atas kertas) ── */
        .print-btn-container {
            width: 100%;
            max-width: 210mm; /* Mengikuti lebar kertas A4 */
            display: flex;
            justify-content: flex-end; /* Tombol rata kanan */
            gap: 10px;
            margin-bottom: 20px; /* Jarak antara tombol dan kertas */
        }
        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
        }
        .btn-print { background: #111827; color: white; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        .btn-print:hover { background: #374151; transform: translateY(-2px); box-shadow: 0 6px 10px rgba(0,0,0,0.15); }
        .btn-back { background: white; color: #111827; border: 1px solid #D1D5DB; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
        .btn-back:hover { background: #F3F4F6; }

        /* ── KERTAS INVOICE (A4) ── */
        .invoice-box {
            background: #FFFFFF;
            width: 100%;
            max-width: 210mm; /* Lebar standar A4 */
            min-height: 297mm; /* Tinggi standar A4 */
            padding: 50px 60px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08); /* Bayangan sedikit dipertebal agar kertas lebih 'muncul' */
            display: flex;
            flex-direction: column;
            border-radius: 4px; /* Sedikit membulat agar lebih manis di web */
        }

        /* ── HEADER ── */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #111827;
            padding-bottom: 25px;
            margin-bottom: 35px;
        }
        .brand {
            font-family: 'Playfair Display', serif;
            font-size: 28px;
            font-weight: 700;
            color: #111827;
            letter-spacing: -0.02em;
        }
        .brand-sub {
            font-family: 'Inter', sans-serif;
            font-size: 10px;
            font-weight: 600;
            color: #6B7280;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            margin-top: 4px;
        }
        .invoice-details {
            text-align: right;
        }
        .invoice-title {
            font-size: 24px;
            font-weight: 800;
            color: #111827;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }
        .invoice-no {
            font-size: 13px;
            font-weight: 600;
            color: #6B7280;
            margin-top: 4px;
        }

        /* ── STATUS BADGE ── */
        .badge {
            display: inline-block;
            padding: 5px 14px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 10px;
        }
        .badge.lunas { background: #F0FDF4; color: #16A34A; border: 1px solid #BBF7D0; }
        .badge.menunggu { background: #FFFBEB; color: #D97706; border: 1px solid #FDE68A; }
        .badge.ditolak { background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; }

        /* ── BILING INFO ── */
        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
        }
        .info-col { width: 48%; }
        .info-title {
            font-size: 10px;
            font-weight: 700;
            color: #9CA3AF;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 12px;
        }
        .info-text {
            font-size: 13px;
            color: #4B5563;
            line-height: 1.6;
        }
        .info-text strong {
            color: #111827;
            font-size: 15px;
            display: block;
            margin-bottom: 4px;
        }

        /* ── TABLE ── */
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        .table th {
            background: #F9FAFB;
            font-size: 10px;
            font-weight: 700;
            color: #6B7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 14px 16px;
            text-align: left;
            border-top: 1px solid #E5E7EB;
            border-bottom: 1px solid #E5E7EB;
        }
        .table td {
            padding: 20px 16px;
            font-size: 13px;
            color: #111827;
            border-bottom: 1px solid #F3F4F6;
            vertical-align: top;
        }
        .item-title { font-weight: 700; margin-bottom: 6px; }
        .item-desc { font-size: 12px; color: #6B7280; line-height: 1.5; }
        .text-right { text-align: right !important; }

        .tag-need {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: 700;
            margin-top: 10px;
        }
        .tag-preneed { background: #F3F4F6; color: #4B5563; }
        .tag-atneed { background: #EFF6FF; color: #1D4ED8; }

        /* ── FOOTER SPLIT (REKENING & TOTAL) ── */
        .footer-split {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-top: auto;
            padding-top: 20px;
        }
        
        .footer-left { width: 55%; }
        .bank-box {
            background: #F9FAFB;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 24px;
        }
        .bank-title {
            font-size: 10px;
            font-weight: 700;
            color: #9CA3AF;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            margin-bottom: 10px;
        }
        .bank-name { font-size: 13px; font-weight: 700; color: #111827; }
        .bank-acc { font-family: monospace; font-size: 15px; font-weight: 700; color: #374151; margin: 4px 0; }
        .bank-owner { font-size: 12px; color: #6B7280; }

        .notes {
            font-size: 11px;
            color: #6B7280;
            line-height: 1.7;
        }
        .notes strong { color: #374151; }

        .footer-right { width: 38%; }
        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            font-size: 13px;
            color: #4B5563;
        }
        .total-row.grand-total {
            border-top: 2px solid #111827;
            margin-top: 10px;
            padding-top: 16px;
            font-size: 18px;
            font-weight: 800;
            color: #111827;
        }

        /* ── PRINT MEDIA QUERY ── */
        @media print {
            body { background: white; padding: 0; margin: 0; display: block; }
            .print-btn-container { display: none; }
            .invoice-box { 
                box-shadow: none; 
                max-width: 100%; 
                min-height: auto; 
                padding: 0; 
                border-radius: 0;
            }
            @page { margin: 15mm; size: A4 portrait; }
        }
    </style>
</head>
<body>

{{-- Pembungkus Tombol (Sekarang ada di DALAM aliran dokumen, di atas kertas) --}}
<div class="print-btn-container">
    <a href="{{ route('pembeli.pembayaran.index') }}" class="btn btn-back">
        Kembali
    </a>
    <button class="btn btn-print" onclick="window.print()">
        Cetak Invoice
    </button>
</div>

{{-- Kertas Invoice --}}
<div class="invoice-box">

    {{-- Header --}}
    <div class="header">
        <div>
            <div class="brand">Mount Carmel</div>
            <div class="brand-sub">Memorial Park & Funeral Service</div>
        </div>
        <div class="invoice-details">
            <div class="invoice-title">INVOICE</div>
            <div class="invoice-no">#{{ $pembayaran->no_invoice }}</div>
            <div class="invoice-no" style="font-weight: 400;">{{ $pembayaran->created_at->translatedFormat('d F Y') }}</div>
            
            @php
                $statusClass = match($pembayaran->status_pembayaran) {
                    'Lunas'  => 'lunas',
                    'Ditolak' => 'ditolak',
                    default  => 'menunggu',
                };
            @endphp
            <div class="badge {{ $statusClass }}">{{ $pembayaran->status_pembayaran }}</div>
        </div>
    </div>

    {{-- Billing Info --}}
    <div class="info-section">
        <div class="info-col">
            <div class="info-title">Ditagihkan Kepada</div>
            <div class="info-text">
                <strong>{{ $pembayaran->reservasi?->user?->name ?? 'Pemesan' }}</strong>
                {{ $pembayaran->reservasi?->user?->email ?? '-' }}<br>
                {{ $pembayaran->reservasi?->user?->no_telepon ?? '-' }}<br>
                @if($pembayaran->reservasi?->alamat_pemesan)
                    <span style="display:inline-block; margin-top:6px; font-size:12px; color:#6B7280; line-height:1.5;">
                        {{ $pembayaran->reservasi->alamat_pemesan }}
                    </span>
                @endif
            </div>
        </div>
        <div class="info-col" style="text-align: right;">
            <div class="info-title">Detail Reservasi Kavling</div>
            <div class="info-text">
                <strong>No. Kavling: {{ $pembayaran->reservasi?->kavling?->nomor_kavling ?? '-' }}</strong>
                {{ $pembayaran->reservasi?->kavling?->cluster?->nama_cluster ?? '-' }}<br>
                Tipe {{ $pembayaran->reservasi?->kavling?->tipe_kavling ?? '-' }}<br>
                Ukuran {{ $pembayaran->reservasi?->kavling?->ukuran ?? '-' }} 
                (Max. {{ $pembayaran->reservasi?->kavling?->kapasitas ?? '-' }} org)
            </div>
        </div>
    </div>

    {{-- Tabel Layanan --}}
    <table class="table">
        <thead>
            <tr>
                <th style="width: 45%;">Deskripsi Layanan</th>
                <th style="width: 20%;">Info Jenazah</th>
                <th style="width: 20%;">Tgl. Makam</th>
                <th style="width: 15%;" class="text-right">Harga</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div class="item-title">Reservasi Lahan Pemakaman</div>
                    <div class="item-desc">
                        Hak guna lahan kavling di Mount Carmel Memorial Park. Biaya ini merupakan nilai total kavling.
                    </div>
                    @if(!$pembayaran->reservasi?->nama_jenazah)
                        <span class="tag-need tag-preneed">PRE-NEED</span>
                    @else
                        <span class="tag-need tag-atneed">AT-NEED</span>
                    @endif
                </td>
                <td>
                    @if($pembayaran->reservasi?->nama_jenazah)
                        <span style="font-weight:600">Alm. {{ $pembayaran->reservasi->nama_jenazah }}</span>
                    @else
                        <span style="color:#9CA3AF; font-style:italic; font-size:12px">Belum diisi</span>
                    @endif
                </td>
                <td>
                    @if($pembayaran->reservasi?->tanggal_dimakamkan)
                        {{ \Carbon\Carbon::parse($pembayaran->reservasi->tanggal_dimakamkan)->translatedFormat('d M Y') }}
                    @else
                        <span style="color:#9CA3AF; font-style:italic; font-size:12px">Menyusul</span>
                    @endif
                </td>
                <td class="text-right item-title">
                    Rp {{ number_format($pembayaran->reservasi?->kavling?->harga ?? 0, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    {{-- Bagian Bawah: Split Kiri (Note & Bank) & Kanan (Total) --}}
    <div class="footer-split">
        
        <div class="footer-left">
            @if($pembayaran->nama_bank && $pembayaran->rekening_tujuan)
            <div class="bank-box">
                <div class="bank-title">Informasi Transfer Bank</div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div class="bank-name">{{ $pembayaran->nama_bank }}</div>
                        <div class="bank-acc">{{ $pembayaran->rekening_tujuan }}</div>
                        <div class="bank-owner">a.n {{ $pembayaran->atas_nama_rekening }}</div>
                    </div>
                    <div style="text-align: right; font-size: 11px; color: #6B7280;">
                        Tgl Transfer:<br>
                        <strong style="color: #111827; font-size: 12px;">
                            {{ $pembayaran->tanggal_bayar ? \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->translatedFormat('d M Y') : '-' }}
                        </strong>
                    </div>
                </div>
            </div>
            @endif

            <div class="notes">
                <strong>Catatan Penting:</strong><br>
                1. Invoice ini adalah bukti pembayaran yang sah setelah diverifikasi.<br>
                2. Harap simpan invoice ini untuk penerbitan Sertifikat Hak Guna Lahan.<br>
                @if(!$pembayaran->reservasi?->nama_jenazah)
                3. Berstatus <strong>Pre-Need</strong> (Data jenazah dapat dilengkapi nanti).<br>
                @endif
                @if($pembayaran->catatan)
                <br>Catatan Pemesan: <em>"{{ $pembayaran->catatan }}"</em>
                @endif
            </div>
        </div>

        <div class="footer-right">
            <div class="total-row">
                <span>Subtotal Harga</span>
                <span style="font-weight: 600;">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span>Diskon / Potongan</span>
                <span style="font-weight: 600;">Rp 0</span>
            </div>
            <div class="total-row grand-total">
                <span>Total Bayar</span>
                <span>Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</span>
            </div>
            
            {{-- Pesan Status di bawah Total --}}
            <div style="text-align: right; margin-top: 15px; font-size: 11px; color: #6B7280;">
                @if($pembayaran->status_pembayaran === 'Lunas')
                    <span style="color: #059669; font-weight: 700;">✓ PEMBAYARAN SELESAI</span>
                @elseif($pembayaran->status_pembayaran === 'Ditolak')
                    <span style="color: #DC2626; font-weight: 700;">✗ PEMBAYARAN DITOLAK</span>
                @else
                    <span style="color: #D97706; font-weight: 700;">⏳ MENUNGGU KONFIRMASI</span>
                @endif
                <br>
                Terakhir diperbarui: <br>{{ $pembayaran->updated_at->translatedFormat('d M Y, H:i') }}
            </div>
        </div>

    </div>

</div>

</body>
</html>