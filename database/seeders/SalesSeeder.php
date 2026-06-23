<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Lahan;
use App\Models\Cluster;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SalesSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Definisikan pool nama asli Indonesia untuk pembeli dan jenazah
        $muslimMaleFirst = ['Ahmad', 'Muhammad', 'Yusuf', 'Abdul', 'Agung', 'Agus', 'Rian', 'Bambang', 'Joko', 'Yudi', 'Rudi', 'Adi', 'Hendra', 'Ridwan', 'Taufik', 'Fajar', 'Arif', 'Heri', 'Budi', 'Roni', 'Fauzan', 'Habib', 'Luqman', 'Zainal', 'Taqi', 'Imron', 'Lukman', 'Syamsul', 'Soleman', 'Hafiz', 'Akbar'];
        $muslimMaleLast = ['Fauzi', 'Hidayat', 'Rahman', 'Prasetyo', 'Wibowo', 'Sulistyo', 'Hermawan', 'Widodo', 'Hartono', 'Nugroho', 'Wijaya', 'Kurniawan', 'Santoso', 'Saputra', 'Setiawan', 'Anwar', 'Abidin', 'Muttaqin', 'Arifin', 'Basri', 'Subagyo', 'Saputro', 'Sudarsono', 'Pramono'];

        $muslimFemaleFirst = ['Siti', 'Fatimah', 'Tri', 'Dewi', 'Sri', 'Dian', 'Rini', 'Indah', 'Fitri', 'Aisyah', 'Kartika', 'Yanti', 'Wati', 'Nurul', 'Lestari', 'Anisa', 'Khofifah', 'Putri', 'Zahra', 'Ratih', 'Hasanah', 'Wardah', 'Safira', 'Laila', 'Rahma'];
        $muslimFemaleLast = ['Aminah', 'Zahra', 'Wahyuni', 'Lestari', 'Safitri', 'Astuti', 'Hidayah', 'Sari', 'Kusuma', 'Putri', 'Wulandari', 'Utami', 'Rahmawati', 'Anggraini', 'Solehah', 'Maimunah', 'Khasanah', 'Nasution', 'Larasati'];

        $nonMuslimMaleFirst = ['Yohanes', 'Andreas', 'David', 'Robert', 'Vincentius', 'Fransiscus', 'Stevanus', 'Martinus', 'Michael', 'Hendry', 'Kelvin', 'Albert', 'Daniel', 'Christian', 'Samuel', 'Jonathan', 'Richard', 'Thomas', 'Peter', 'Paul', 'Simon', 'Stefan', 'William', 'Alex', 'Edward', 'Bernard', 'Antonius', 'Ignatius', 'Gregory'];
        $nonMuslimMaleLast = ['Wijaya', 'Chandra', 'Susanto', 'Hartono', 'Lim', 'Tan', 'Lauw', 'Setiadi', 'Gunawan', 'Pratama', 'Haryono', 'Tanjung', 'Liem', 'Wong', 'Oey', 'Tio', 'Gozali', 'Sutanto', 'Lontoh', 'Manopo', 'Rorong', 'Siahaan', 'Panggabean'];

        $nonMuslimFemaleFirst = ['Maria', 'Elisabeth', 'Christine', 'Grace', 'Stella', 'Jessica', 'Linda', 'Natalia', 'Agnes', 'Veronica', 'Teresa', 'Angela', 'Sherly', 'Lani', 'Diana', 'Catherine', 'Monica', 'Irene', 'Juliana', 'Patricia', 'Clara', 'Silvia', 'Gabriela', 'Helena', 'Anastasia', 'Cecilia'];
        $nonMuslimFemaleLast = ['Tan', 'Lim', 'Natalia', 'Wijaya', 'Susanti', 'Hartono', 'Lauw', 'Chandra', 'Elisabeth', 'Teng', 'Go', 'Lie', 'Wong', 'Gozali', 'Liem', 'Katiandagho', 'Simanjuntak', 'Siregar', 'Wenas', 'Runtu'];

        // Helper closures untuk menghasilkan nama
        $getMuslimName = function($gender = null) use (&$muslimMaleFirst, &$muslimMaleLast, &$muslimFemaleFirst, &$muslimFemaleLast) {
            if ($gender === null) {
                $gender = rand(0, 1) ? 'male' : 'female';
            }
            if ($gender === 'male') {
                return $muslimMaleFirst[array_rand($muslimMaleFirst)] . ' ' . $muslimMaleLast[array_rand($muslimMaleLast)];
            } else {
                return $muslimFemaleFirst[array_rand($muslimFemaleFirst)] . ' ' . $muslimFemaleLast[array_rand($muslimFemaleLast)];
            }
        };

        $getNonMuslimName = function($gender = null) use (&$nonMuslimMaleFirst, &$nonMuslimMaleLast, &$nonMuslimFemaleFirst, &$nonMuslimFemaleLast) {
            if ($gender === null) {
                $gender = rand(0, 1) ? 'male' : 'female';
            }
            if ($gender === 'male') {
                return $nonMuslimMaleFirst[array_rand($nonMuslimMaleFirst)] . ' ' . $nonMuslimMaleLast[array_rand($nonMuslimMaleLast)];
            } else {
                return $nonMuslimFemaleFirst[array_rand($nonMuslimFemaleFirst)] . ' ' . $nonMuslimFemaleLast[array_rand($nonMuslimFemaleLast)];
            }
        };

        $getDeceasedMuslimName = function() use ($getMuslimName) {
            $gender = rand(0, 1) ? 'male' : 'female';
            $prefix = $gender === 'male' ? 'Alm. ' : 'Almh. ';
            return $prefix . $getMuslimName($gender);
        };

        $getDeceasedNonMuslimName = function() use ($getNonMuslimName) {
            $gender = rand(0, 1) ? 'male' : 'female';
            $prefix = $gender === 'male' ? 'Alm. ' : 'Almh. ';
            return $prefix . $getNonMuslimName($gender);
        };

        // 2. Kumpulkan atau buat tepat 20 User pembeli
        $jalan = ['Kartini', 'Siliwangi', 'Cipto Mangunkusumo', 'Wahidin', 'Tuparev', 'Tentara Pelajar', 'Sudarsono', 'Kesambi', 'Karanggetak', 'Pekalipan', 'Kanoman', 'Kalibaru', 'Lawanggada', 'Pemuda', 'Pekalangan', 'Sunyaragi', 'Ciremai'];
        $pembelis = User::where('role', 'pembeli')->get();
        $pembelisCount = $pembelis->count();

        if ($pembelisCount < 20) {
            $needed = 20 - $pembelisCount;
            for ($i = 0; $i < $needed; $i++) {
                $isMuslim = rand(0, 1) === 0;
                $name = $isMuslim ? $getMuslimName() : $getNonMuslimName();
                $email = str_replace(' ', '.', strtolower($name)) . ($i + 1 + $pembelisCount) . '@email.com';
                $jalanRandom = $jalan[array_rand($jalan)];

                User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make('password'),
                    'role' => 'pembeli',
                    'no_telepon' => '0812' . rand(10000000, 99999999),
                    'alamat' => 'Jl. ' . $jalanRandom . ' No. ' . rand(1, 150) . ', Cirebon, Jawa Barat',
                ]);
            }
            $pembelis = User::where('role', 'pembeli')->get();
        } elseif ($pembelisCount > 20) {
            // Jika lebih dari 20, kita ambil 20 saja
            $pembelis = $pembelis->take(20);
        }

        // Ambil Cluster Madinah & Mount Carmel
        $madinah = Cluster::where('nama_cluster', 'Cluster Madinah')->first();
        $mountCarmel = Cluster::where('nama_cluster', 'Cluster Mount Carmel')->first();

        if (!$madinah || !$mountCarmel) {
            $this->command->error('Cluster Madinah atau Mount Carmel tidak ditemukan. Pastikan ClusterLahanSeeder sudah dijalankan.');
            return;
        }

        // Ambil data lahan
        $muslimLahans = Lahan::where('cluster_id', $madinah->id)->get();
        $nonMuslimLahans = Lahan::where('cluster_id', $mountCarmel->id)->get();

        // Bagi data untuk Muslim (Total 3.000 Lahan)
        // target: 100 Digunakan, 400 Terjual, 25 Reservasi Lunas, 25 Reservasi Cicilan
        $muslimShuffled = $muslimLahans->shuffle();
        $muslimDigunakan = $muslimShuffled->slice(0, 100);
        $muslimTerjual = $muslimShuffled->slice(100, 400);
        $muslimResLunas = $muslimShuffled->slice(500, 25);
        $muslimResCicilan = $muslimShuffled->slice(525, 25);

        // Bagi data untuk Non-Muslim (Total 2.800 Lahan)
        // target: 200 Digunakan, 400 Terjual, 25 Reservasi Lunas, 25 Reservasi Cicilan
        $nonMuslimShuffled = $nonMuslimLahans->shuffle();
        $nonMuslimDigunakan = $nonMuslimShuffled->slice(0, 200);
        $nonMuslimTerjual = $nonMuslimShuffled->slice(200, 400);
        $nonMuslimResLunas = $nonMuslimShuffled->slice(600, 25);
        $nonMuslimResCicilan = $nonMuslimShuffled->slice(625, 25);

        // Batch Arrays
        $reservasis = [];
        $pembayarans = [];
        $detailJenazahs = [];

        // Lahan ID Grouping
        $lahanUpdates = [
            'Digunakan' => [],
            'Terjual' => [],
            'Reservasi (Lunas)' => [],
            'Reservasi Cicilan dengan DP' => [],
        ];

        $reservasiId = 1;
        $invoiceCounter = 10001;
        $now = Carbon::now();
        $banks = ['BCA', 'BNI', 'Mandiri', 'BRI'];
        $marketings = ['Marketing Rendi', 'Marketing Siska', 'Marketing Acha'];
        $accountings = ['Accounting Clara', 'Accounting Hendra', 'Accounting Budi'];

        // Helper untuk memproses seeder per grup status
        $processGroup = function ($lahansGroup, $statusLahan, $isMuslim) use (
            &$reservasis, &$pembayarans, &$detailJenazahs, &$lahanUpdates,
            &$reservasiId, &$invoiceCounter, $now, $pembelis, $banks, $marketings, $accountings,
            $getDeceasedMuslimName, $getDeceasedNonMuslimName
        ) {
            foreach ($lahansGroup as $lahan) {
                $pembeli = $pembelis->random();
                $date = $now->copy()->subDays(rand(0, 365))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
                $marketing = $marketings[array_rand($marketings)];
                $accounting = $accountings[array_rand($accountings)];
                $bank = $banks[array_rand($banks)];

                $kategoriKebutuhan = 'pre_need';
                $namaJenazah = null;
                $tanggalDimakamkan = null;
                $statusReservasi = 'Selesai';
                $statusPembayaran = 'Lunas';
                $jenisPembayaran = 'tunai';
                $tenor = 1;
                $biayaReservasi = $lahan->harga;
                $biayaPenuh = $lahan->harga;

                if ($statusLahan === 'Digunakan') {
                    $kategoriKebutuhan = 'end_user';
                    $namaJenazah = $isMuslim ? $getDeceasedMuslimName() : $getDeceasedNonMuslimName();
                    $tanggalDimakamkan = $date->copy()->addDays(rand(1, 2))->toDateString();
                } elseif ($statusLahan === 'Reservasi (Lunas)') {
                    $isPending = rand(0, 1) === 0;
                    if ($isPending) {
                        $statusPembayaran = 'Belum Bayar';
                        $statusReservasi = 'Menunggu Validasi';
                    } else {
                        $statusPembayaran = 'Menunggu Konfirmasi';
                        $statusReservasi = 'Disetujui';
                    }
                } elseif ($statusLahan === 'Reservasi Cicilan dengan DP') {
                    $jenisPembayaran = 'cicilan';
                    $tenor = 12;
                    $biayaReservasi = $lahan->harga * 0.2; // DP 20%
                    $statusReservasi = 'Disetujui';
                    $statusPembayaran = 'DP Lunas';
                } elseif ($statusLahan === 'Terjual') {
                    $isCicilan = rand(0, 1) === 0;
                    if ($isCicilan) {
                        $jenisPembayaran = 'cicilan';
                        $tenor = 12;
                        $biayaReservasi = $lahan->harga * 0.2;
                    }
                }

                // Add to Reservasis
                $reservasis[] = [
                    'id' => $reservasiId,
                    'user_id' => $pembeli->id,
                    'lahan_id' => $lahan->id,
                    'kategori_kebutuhan' => $kategoriKebutuhan,
                    'nama_jenazah' => $namaJenazah,
                    'tanggal_reservasi' => $date->toDateString(),
                    'alamat_pemesan' => $pembeli->alamat,
                    'tanggal_dimakamkan' => $tanggalDimakamkan,
                    'dokumen_ktp' => 'dokumen_reservasi/sample.pdf',
                    'status_pembayaran' => $statusPembayaran,
                    'status_reservasi' => $statusReservasi,
                    'jenis_pembayaran' => $jenisPembayaran,
                    'tenor_cicilan' => $tenor,
                    'biaya_reservasi' => $biayaReservasi,
                    'biaya_penuh' => $biayaPenuh,
                    'marketing_oleh' => $marketing,
                    'created_at' => $date,
                    'updated_at' => $date,
                ];

                // Add to Pembayarans
                if ($statusPembayaran !== 'Belum Bayar') {
                    if ($jenisPembayaran === 'tunai') {
                        $pembayarans[] = [
                            'reservasi_id' => $reservasiId,
                            'no_invoice' => 'INV-' . $date->format('Ymd') . '-' . ($invoiceCounter++),
                            'jumlah_bayar' => $biayaPenuh,
                            'tanggal_bayar' => $date,
                            'bukti_pembayaran' => 'bukti.png',
                            'status_pembayaran' => $statusPembayaran,
                            'nama_bank' => $bank,
                            'rekening_tujuan' => '1234567890',
                            'atas_nama_rekening' => $pembeli->name,
                            'cicilan_ke' => 1,
                            'total_cicilan' => 1,
                            'dikonfirmasi_oleh' => $statusPembayaran === 'Lunas' ? $accounting : null,
                            'created_at' => $date,
                            'updated_at' => $date,
                        ];
                    } else {
                        // Cicilan
                        // 1. DP (Cicilan ke-0)
                        $pembayarans[] = [
                            'reservasi_id' => $reservasiId,
                            'no_invoice' => 'INV-' . $date->format('Ymd') . '-' . ($invoiceCounter++),
                            'jumlah_bayar' => $biayaReservasi,
                            'tanggal_bayar' => $date,
                            'bukti_pembayaran' => 'bukti.png',
                            'status_pembayaran' => 'Lunas',
                            'nama_bank' => $bank,
                            'rekening_tujuan' => '1234567890',
                            'atas_nama_rekening' => $pembeli->name,
                            'cicilan_ke' => 0,
                            'total_cicilan' => 12,
                            'dikonfirmasi_oleh' => $accounting,
                            'created_at' => $date,
                            'updated_at' => $date,
                        ];

                        $sisaCicilan = ($biayaPenuh - $biayaReservasi) / 12;

                        if ($statusLahan === 'Terjual') {
                            // Cicilan Lunas 1..12
                            for ($c = 1; $c <= 12; $c++) {
                                $pembayarans[] = [
                                    'reservasi_id' => $reservasiId,
                                    'no_invoice' => 'INV-' . $date->copy()->addMonths($c)->format('Ymd') . '-' . ($invoiceCounter++),
                                    'jumlah_bayar' => $sisaCicilan,
                                    'tanggal_bayar' => $date->copy()->addMonths($c),
                                    'bukti_pembayaran' => 'bukti.png',
                                    'status_pembayaran' => 'Lunas',
                                    'nama_bank' => $bank,
                                    'rekening_tujuan' => '1234567890',
                                    'atas_nama_rekening' => $pembeli->name,
                                    'cicilan_ke' => $c,
                                    'total_cicilan' => 12,
                                    'dikonfirmasi_oleh' => $accounting,
                                    'created_at' => $date->copy()->addMonths($c),
                                    'updated_at' => $date->copy()->addMonths($c),
                                ];
                            }
                        } elseif ($statusLahan === 'Reservasi Cicilan dengan DP') {
                            // Cicilan Berjalan (DP Lunas, Cicilan 1 s/d X Lunas, Cicilan X+1 pending)
                            $X = rand(1, 5);
                            for ($c = 1; $c <= $X; $c++) {
                                $pembayarans[] = [
                                    'reservasi_id' => $reservasiId,
                                    'no_invoice' => 'INV-' . $date->copy()->addMonths($c)->format('Ymd') . '-' . ($invoiceCounter++),
                                    'jumlah_bayar' => $sisaCicilan,
                                    'tanggal_bayar' => $date->copy()->addMonths($c),
                                    'bukti_pembayaran' => 'bukti.png',
                                    'status_pembayaran' => 'Lunas',
                                    'nama_bank' => $bank,
                                    'rekening_tujuan' => '1234567890',
                                    'atas_nama_rekening' => $pembeli->name,
                                    'cicilan_ke' => $c,
                                    'total_cicilan' => 12,
                                    'dikonfirmasi_oleh' => $accounting,
                                    'created_at' => $date->copy()->addMonths($c),
                                    'updated_at' => $date->copy()->addMonths($c),
                                ];
                            }
                            // Tambah 1 cicilan pending
                            $pembayarans[] = [
                                'reservasi_id' => $reservasiId,
                                'no_invoice' => 'INV-' . $date->copy()->addMonths($X + 1)->format('Ymd') . '-' . ($invoiceCounter++),
                                'jumlah_bayar' => $sisaCicilan,
                                'tanggal_bayar' => $date->copy()->addMonths($X + 1),
                                'bukti_pembayaran' => 'bukti.png',
                                'status_pembayaran' => 'Menunggu Konfirmasi',
                                'nama_bank' => $bank,
                                'rekening_tujuan' => '1234567890',
                                'atas_nama_rekening' => $pembeli->name,
                                'cicilan_ke' => $X + 1,
                                'total_cicilan' => 12,
                                'dikonfirmasi_oleh' => null,
                                'created_at' => $date->copy()->addMonths($X + 1),
                                'updated_at' => $date->copy()->addMonths($X + 1),
                            ];
                        }
                    }
                }

                // Add to DetailJenazahs
                if ($statusLahan === 'Digunakan') {
                    // Isi detail_jenazahs slot 1
                    $detailJenazahs[] = [
                        'reservasi_id' => $reservasiId,
                        'nomor_slot' => 1,
                        'nama_jenazah' => $namaJenazah,
                        'tanggal_dimakamkan' => $tanggalDimakamkan,
                        'status' => 'Disetujui',
                        'created_at' => $date,
                        'updated_at' => $date,
                    ];
                    // Isi sisa slot jika kapasitas > 1
                    for ($slot = 2; $slot <= $lahan->kapasitas; $slot++) {
                        $detailJenazahs[] = [
                            'reservasi_id' => $reservasiId,
                            'nomor_slot' => $slot,
                            'nama_jenazah' => $isMuslim ? $getDeceasedMuslimName() : $getDeceasedNonMuslimName(),
                            'tanggal_dimakamkan' => $date->copy()->addDays(rand(3, 30))->toDateString(),
                            'status' => 'Disetujui',
                            'created_at' => $date,
                            'updated_at' => $date,
                        ];
                    }
                }

                $lahanUpdates[$statusLahan][] = $lahan->id;
                $reservasiId++;
            }
        };

        // Proses Grup Muslim
        $processGroup($muslimDigunakan, 'Digunakan', true);
        $processGroup($muslimTerjual, 'Terjual', true);
        $processGroup($muslimResLunas, 'Reservasi (Lunas)', true);
        $processGroup($muslimResCicilan, 'Reservasi Cicilan dengan DP', true);

        // Proses Grup Non-Muslim
        $processGroup($nonMuslimDigunakan, 'Digunakan', false);
        $processGroup($nonMuslimTerjual, 'Terjual', false);
        $processGroup($nonMuslimResLunas, 'Reservasi (Lunas)', false);
        $processGroup($nonMuslimResCicilan, 'Reservasi Cicilan dengan DP', false);

        // 3. Eksekusi Bulk Insert menggunakan DB Transaction
        DB::transaction(function () use ($reservasis, $pembayarans, $detailJenazahs, $lahanUpdates) {
            // Bulk insert reservasis
            foreach (array_chunk($reservasis, 200) as $chunk) {
                DB::table('reservasis')->insert($chunk);
            }

            // Bulk insert pembayarans
            foreach (array_chunk($pembayarans, 200) as $chunk) {
                DB::table('pembayarans')->insert($chunk);
            }

            // Bulk insert detail_jenazahs
            foreach (array_chunk($detailJenazahs, 200) as $chunk) {
                DB::table('detail_jenazahs')->insert($chunk);
            }

            // Update status lahan
            foreach ($lahanUpdates as $status => $ids) {
                if (!empty($ids)) {
                    Lahan::whereIn('id', $ids)->update(['status' => $status]);
                }
            }
        });
    }
}
