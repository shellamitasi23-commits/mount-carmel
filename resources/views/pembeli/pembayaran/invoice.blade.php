<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $pembayaran->no_invoice }} — Mount Carmel</title>
    
    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,700;1,600&display=swap" rel="stylesheet">
    
    {{-- Standalone Premium Invoice CSS --}}
    <link rel="stylesheet" href="{{ asset('css/invoice.css') }}"/>
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
            <div class="info-title">Detail Reservasi Lahan</div>
            <div class="info-text">
                <strong>No. Lahan: {{ $pembayaran->reservasi?->lahan?->nomor_lahan ?? '-' }}</strong>
                {{ $pembayaran->reservasi?->lahan?->cluster?->nama_cluster ?? '-' }}<br>
                Lahan {{ $pembayaran->reservasi?->lahan?->tipe_lahan ?? '-' }}<br>
                Ukuran {{ $pembayaran->reservasi?->lahan?->ukuran ?? '-' }} 
                (Max. {{ $pembayaran->reservasi?->lahan?->kapasitas ?? '-' }} org)
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
                        Hak guna lahan lahan di Mount Carmel Memorial Park. Biaya ini merupakan nilai total lahan.
                    </div>
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
                    Rp {{ number_format($pembayaran->reservasi?->lahan?->harga ?? 0, 0, ',', '.') }}
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
