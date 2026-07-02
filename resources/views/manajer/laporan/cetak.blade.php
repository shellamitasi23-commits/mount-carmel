<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan - Mount Carmel</title>
    <link rel="stylesheet" href="{{ asset('css/report-print.css') }}">
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

    @php
        $type = request('type', 'reservasi');
        $periodeFrom = request('start_date') ?? 'Semua';
        $periodeTo = request('end_date') ?? 'Sekarang';
    @endphp

    <div class="judul-laporan">
        <h2>
            @if($type === 'lahan')
                Laporan Data Lahan / Digunakan
            @elseif($type === 'pembeli')
                Laporan Data Pembeli
            @elseif($type === 'cluster')
                Laporan Data Cluster
            @else
                Laporan Rekapitulasi Penjualan Lahan
            @endif
        </h2>
        <p>Periode: {{ $periodeFrom }} s/d {{ $periodeTo }}</p>
    </div>

    <table>
        <thead>
            @if($type === 'lahan')
                <tr>
                    <th>No</th>
                    <th>Nomor Lahan</th>
                    <th>Cluster</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    <th class="text-right">Harga (Rp)</th>
                </tr>
            @elseif($type === 'pembeli')
                <tr>
                    <th>No</th>
                    <th>Nama Pembeli</th>
                    <th>Email</th>
                    <th>Total Reservasi</th>
                    <th>Tanggal Daftar</th>
                </tr>
            @elseif($type === 'cluster')
                <tr>
                    <th>No</th>
                    <th>Nama Cluster</th>
                    <th>Kategori</th>
                    <th>Total Lahan</th>
                </tr>
            @elseif($type === 'jenazah')
                <tr>
                    <th>No</th>
                    <th>Nama Jenazah</th>
                    <th>Lokasi Lahan</th>
                    <th>Cluster</th>
                    <th>Ahli Waris</th>
                    <th class="text-right">Tgl Dimakamkan</th>
                </tr>
            @else
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Nama Pembeli</th>
                    <th>Lahan & Cluster</th>
                    <th>Nama Jenazah</th>
                    <th class="text-right">Harga (Rp)</th>
                </tr>
            @endif
        </thead>
        <tbody>
            @php $total = 0; @endphp

            @if($type === 'lahan')
                @forelse($lahans as $index => $k)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $k->nomor_lahan }}</td>
                        <td>{{ $k->cluster->nama_cluster ?? '-' }}</td>
                        <td>{{ $k->tipe_lahan }}</td>
                        <td>{{ $k->status }}</td>
                        <td class="text-right">{{ number_format($k->harga, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">Tidak ada data pada periode ini.</td>
                    </tr>
                @endforelse
            @elseif($type === 'pembeli')
                @forelse($pembelis as $index => $p)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->email }}</td>
                        <td>{{ $p->reservasis_count }}</td>
                        <td>{{ $p->created_at ? $p->created_at->format('d/m/Y') : '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center;">Tidak ada data pada periode ini.</td>
                    </tr>
                @endforelse
            @elseif($type === 'cluster')
                @forelse($clusters as $index => $c)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $c->nama_cluster }}</td>
                        <td>{{ $c->kategori }}</td>
                        <td>{{ $c->lahans_count }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center;">Tidak ada data pada periode ini.</td>
                    </tr>
                @endforelse
            @elseif($type === 'jenazah')
                @forelse($jenazahs as $index => $j)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $j->nama_jenazah }} (Slot {{ $j->nomor_slot }})</td>
                        <td>{{ $j->reservasi->lahan->nomor_lahan }}</td>
                        <td>{{ $j->reservasi->lahan->cluster->nama_cluster }}</td>
                        <td>{{ $j->reservasi->user->name }}</td>
                        <td class="text-right">{{ $j->tanggal_dimakamkan ? \Carbon\Carbon::parse($j->tanggal_dimakamkan)->format('d/m/Y') : '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">Tidak ada data pada periode ini.</td>
                    </tr>
                @endforelse
            @else
                @forelse($reservasis as $index => $rs)
                    @php $total += $rs->lahan->harga; @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $rs->created_at->format('d/m/Y') }}</td>
                        <td>{{ $rs->user->name }}</td>
                        <td>{{ $rs->lahan->cluster->nama_cluster }} - {{ $rs->lahan->nomor_lahan }}</td>
                        <td>Alm. {{ $rs->nama_semua_jenazah }}</td>
                        <td class="text-right">{{ number_format($rs->lahan->harga, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">Tidak ada data pada periode ini.</td>
                    </tr>
                @endforelse
            @endif
        </tbody>

        @if($type === 'reservasi')
            <tfoot>
                <tr class="font-bold" style="background-color: #fdfdfd;">
                    <td colspan="5" class="text-right">TOTAL PENDAPATAN</td>
                    <td class="text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        @endif
    </table>

    <div class="tanda-tangan">
        <p>Cirebon, {{ date('d F Y') }} <br> Mengetahui, <br> <strong>Pimpinan Mount Carmel</strong></p>
        <p class="nama-pimpinan">{{ auth()->user()->name }}</p>
    </div>

</body>
</html>
