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
    <style>
        .badge.partial {
            background: #EFF6FF;
            color: #1D4ED8;
            border: 1px solid #BFDBFE;
        }

        /* Animations */
        @keyframes slideUpFade {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideDownFade {
            from {
                opacity: 0;
                transform: translateY(-20px) translateX(-50%);
            }
            to {
                opacity: 1;
                transform: translateY(0) translateX(-50%);
            }
        }

        .print-btn-container {
            animation: slideUpFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .invoice-box {
            animation: slideUpFade 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Success Toast Styles */
        .success-toast {
            position: fixed;
            top: 24px;
            left: 50%;
            transform: translateX(-50%);
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-left: 4px solid #10b981;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
            border-radius: 16px;
            padding: 16px 20px;
            display: flex;
            align-items: center;
            gap: 16px;
            z-index: 9999;
            width: 90%;
            max-width: 480px;
            animation: slideDownFade 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            font-family: 'Inter', sans-serif;
        }
        
        .toast-icon {
            background: #ecfdf5;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .toast-content {
            flex-grow: 1;
        }
        
        .toast-content h4 {
            margin: 0 0 2px 0;
            font-size: 13px;
            font-weight: 700;
            color: #065f46;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .toast-content p {
            margin: 0;
            font-size: 11px;
            color: #4b5563;
            line-height: 1.4;
        }
        
        .toast-close {
            background: none;
            border: none;
            font-size: 20px;
            color: #9ca3af;
            cursor: pointer;
            padding: 0 4px;
            font-weight: 300;
            transition: color 0.2s;
        }
        
        .toast-close:hover {
            color: #374151;
        }

        /* Hide toast when printing */
        @media print {
            .success-toast {
                display: none !important;
            }
        }
    </style>
</head>
<body>

@if(session('success'))
<div class="success-toast" id="successToast">
    <div class="toast-icon">
        <svg style="width: 20px; height: 20px; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path>
        </svg>
    </div>
    <div class="toast-content">
        <h4>Bukti Pembayaran Terkirim</h4>
        <p>{{ session('success') }}</p>
    </div>
    <button class="toast-close" onclick="document.getElementById('successToast').style.display='none'">×</button>
</div>
@endif

{{-- Pembungkus Tombol --}}
<div class="print-btn-container">
    <a href="{{ route('pembeli.reservasi.index') }}" class="btn btn-back">
        Kembali ke Reservasi
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
                $isPartial = $pembayaran->status_pembayaran === 'Lunas' && $pembayaran->reservasi?->jenis_pembayaran === 'cicilan' && ($pembayaran->cicilan_ke === 0 || $pembayaran->cicilan_ke < $pembayaran->total_cicilan);
                
                $statusClass = match(true) {
                    $pembayaran->status_pembayaran === 'Lunas' && !$isPartial => 'lunas',
                    $pembayaran->status_pembayaran === 'Lunas' && $isPartial => 'partial',
                    $pembayaran->status_pembayaran === 'Ditolak' => 'ditolak',
                    default => 'menunggu',
                };
            @endphp
            <div class="badge {{ $statusClass }}">{{ $pembayaran->status_label }}</div>
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
                    <div class="item-desc" style="line-height: 1.6; margin-top: 6px;">
                        @if($pembayaran->reservasi?->jenis_pembayaran === 'cicilan')
                            Metode: Cicilan (Tenor {{ $pembayaran->total_cicilan }} Bulan)<br>
                            Tahap: 
                            @if($pembayaran->cicilan_ke === 0)
                                <strong>Uang Muka / DP Awal (20%)</strong>
                            @else
                                <strong>Cicilan Ke-{{ $pembayaran->cicilan_ke }} dari {{ $pembayaran->total_cicilan }}</strong>
                            @endif
                        @else
                            Metode: Tunai / Lunas Sekaligus
                        @endif
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
                    Rp {{ number_format($pembayaran->jumlah_bayar ?? 0, 0, ',', '.') }}
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
                <span>Harga Lahan</span>
                <span style="font-weight: 600;">Rp {{ number_format($pembayaran->reservasi?->biaya_penuh ?? $pembayaran->reservasi?->lahan?->harga, 0, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span>Subtotal Tahap Ini</span>
                <span style="font-weight: 600;">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</span>
            </div>
            <div class="total-row">
                <span>Diskon / Potongan</span>
                <span style="font-weight: 600;">Rp 0</span>
            </div>
            <div class="total-row grand-total">
                <span>Total Bayar Tahap Ini</span>
                <span>Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</span>
            </div>
            
            {{-- Pesan Status di bawah Total --}}
            <div style="text-align: right; margin-top: 15px; font-size: 11px; color: #6B7280;">
                @if($pembayaran->status_pembayaran === 'Lunas')
                    @if($pembayaran->cicilan_ke === 0)
                        <span style="color: #1D4ED8; font-weight: 700;">✓ DP SELESAI</span>
                    @elseif($isPartial)
                        <span style="color: #1D4ED8; font-weight: 700;">✓ CICILAN KE-{{ $pembayaran->cicilan_ke }} SELESAI</span>
                    @else
                        <span style="color: #059669; font-weight: 700;">✓ PEMBAYARAN LUNAS SELESAI</span>
                    @endif
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

    {{-- Tanda Tangan / Verifikasi --}}
    <div style="margin-top: 50px; border-top: 1px solid #E5E7EB; padding-top: 20px; display: flex; justify-content: space-between; font-size: 11px; color: #4B5563;">
        <div>
            @if($pembayaran->reservasi?->marketing_oleh)
                <p style="margin-bottom: 30px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #9CA3AF;">Staf Marketing</p>
                <p style="font-weight: 700; color: #111827; margin: 0;">{{ $pembayaran->reservasi->marketing_oleh }}</p>
                <p style="font-size: 9px; color: #9CA3AF; margin: 0;">Penerima Pesanan</p>
            @endif
        </div>
        <div style="text-align: center;">
            @if($pembayaran->reservasi?->disetujui_oleh)
                <p style="margin-bottom: 30px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #9CA3AF;">Manajer Validasi</p>
                <p style="font-weight: 700; color: #111827; margin: 0;">{{ $pembayaran->reservasi->disetujui_oleh }}</p>
                <p style="font-size: 9px; color: #9CA3AF; margin: 0;">Menyetujui Reservasi</p>
            @endif
        </div>
        <div style="text-align: right;">
            @if($pembayaran->dikonfirmasi_oleh)
                <p style="margin-bottom: 30px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #9CA3AF;">Staf Accounting</p>
                <p style="font-weight: 700; color: #111827; margin: 0;">{{ $pembayaran->dikonfirmasi_oleh }}</p>
                <p style="font-size: 9px; color: #9CA3AF; margin: 0;">Verifikator Pembayaran</p>
            @else
                <p style="margin-bottom: 30px; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: #9CA3AF;">Staf Accounting</p>
                <p style="font-style: italic; color: #9CA3AF; margin: 0;">Belum Terverifikasi</p>
            @endif
        </div>
    </div>

</div>

</body>
</html>
