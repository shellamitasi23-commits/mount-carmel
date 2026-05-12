<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cluster;
use App\Models\Kavling;

class ClusterKavlingSeeder extends Seeder
{

    public function run(): void
    {
        // ============================================================
        // CLUSTER 1: MADINAH — MUSLIM
        // ============================================================
        $madinah = Cluster::firstOrCreate(
            ['nama_cluster' => 'Cluster Madinah'],
            [
                'kategori' => 'Muslim',
                'deskripsi' => 'Kawasan pemakaman Muslim eksklusif dengan orientasi kiblat terverifikasi. '
                    . 'Dilengkapi mushola internal, area wudu, dan petugas kebersihan harian.',
            ]
        );

        $kavlingMuslim = [
            [
                'tipe_kavling' => 'Barokah',
                'ukuran' => '1.5m x 2.5m',
                'kapasitas' => 1,
                'harga' => 25_000_000,
                'jumlah' => 1050,
            ],
            [
                'tipe_kavling' => 'Fitrah',
                'ukuran' => '4m x 3m',
                'kapasitas' => 2,
                'harga' => 85_000_000,
                'jumlah' => 875,
            ],
            [
                'tipe_kavling' => 'Sakinah',
                'ukuran' => '7m x 8m',
                'kapasitas' => 6,
                'harga' => 425_000_000,
                'jumlah' => 700,
            ],
            [
                'tipe_kavling' => 'Khalifah',
                'ukuran' => '7m x 15m',
                'kapasitas' => 12,
                'harga' => 750_000_000,
                'jumlah' => 350,
            ],
        ];

        $nomorMuslim = 1;
        $totalMuslim = 2975;
        $soldMuslim = 500;
        $usedMuslim = 100;
        foreach ($kavlingMuslim as $data) {
            for ($i = 1; $i <= $data['jumlah']; $i++) {
                $status = 'Tersedia';
                if ($nomorMuslim <= $soldMuslim) {
                    $status = 'Terjual';
                } elseif ($nomorMuslim <= $soldMuslim + $usedMuslim) {
                    $status = 'Dipesan';
                }
                Kavling::firstOrCreate(
                    [
                        'cluster_id' => $madinah->id,
                        'nomor_kavling' => 'M-' . str_pad($nomorMuslim, 4, '0', STR_PAD_LEFT),
                    ],
                    [
                        'tipe_kavling' => $data['tipe_kavling'],
                        'ukuran' => $data['ukuran'],
                        'kapasitas' => $data['kapasitas'],
                        'harga' => $data['harga'],
                        'status' => $status,
                    ]
                );
                $nomorMuslim++;
            }
        }

        // ============================================================
        // CLUSTER 2: MOUNT CARMEL — NON-MUSLIM
        // ============================================================
        $mountCarmel = Cluster::firstOrCreate(
            ['nama_cluster' => 'Cluster Mount Carmel'],
            [
                'kategori' => 'Non-Muslim',
                'deskripsi' => 'Kawasan pemakaman Non-Muslim eksklusif dengan desain universal. '
                    . 'Tersedia berbagai ukuran mulai dari kavling individu hingga kavling keluarga VIP.',
            ]
        );

        $kavlingNonMuslim = [
            [
                'tipe_kavling' => 'Single',
                'ukuran' => '1.5m x 4m',
                'kapasitas' => 1,
                'harga' => 60_000_000,
                'jumlah' => 540,
            ],
            [
                'tipe_kavling' => 'Double',
                'ukuran' => '3m x 4m',
                'kapasitas' => 2,
                'harga' => 120_000_000,
                'jumlah' => 540,
            ],
            [
                'tipe_kavling' => 'Double Deluxe',
                'ukuran' => '4m x 4.5m',
                'kapasitas' => 2,
                'harga' => 140_000_000,
                'jumlah' => 405,
            ],
            [
                'tipe_kavling' => 'Double Special',
                'ukuran' => '8m x 4.5m',
                'kapasitas' => 4,
                'harga' => 280_000_000,
                'jumlah' => 405,
            ],
            [
                'tipe_kavling' => 'Family',
                'ukuran' => '8m x 5m',
                'kapasitas' => 4,
                'harga' => 400_000_000,
                'jumlah' => 324,
            ],
            [
                'tipe_kavling' => 'Super Family',
                'ukuran' => '8m x 10m',
                'kapasitas' => 6,
                'harga' => 800_000_000,
                'jumlah' => 270,
            ],
            [
                'tipe_kavling' => 'Royal Family',
                'ukuran' => '16m x 20m',
                'kapasitas' => 10,
                'harga' => 3_500_000_000,
                'jumlah' => 162,
            ],
            [
                'tipe_kavling' => 'VIP',
                'ukuran' => '26m x 36m',
                'kapasitas' => 18,
                'harga' => 12_800_000_000,
                'jumlah' => 108,
            ],
        ];

        $nomorNonMuslim = 1;
        $totalNonMuslim = 2754;
        $soldNonMuslim = 600;
        $usedNonMuslim = 200;
        foreach ($kavlingNonMuslim as $data) {
            for ($i = 1; $i <= $data['jumlah']; $i++) {
                $status = 'Tersedia';
                if ($nomorNonMuslim <= $soldNonMuslim) {
                    $status = 'Terjual';
                } elseif ($nomorNonMuslim <= $soldNonMuslim + $usedNonMuslim) {
                    $status = 'Dipesan';
                }
                Kavling::firstOrCreate(
                    [
                        'cluster_id' => $mountCarmel->id,
                        'nomor_kavling' => 'NM-' . str_pad($nomorNonMuslim, 4, '0', STR_PAD_LEFT),
                    ],
                    [
                        'tipe_kavling' => $data['tipe_kavling'],
                        'ukuran' => $data['ukuran'],
                        'kapasitas' => $data['kapasitas'],
                        'harga' => $data['harga'],
                        'status' => $status,
                    ]
                );
                $nomorNonMuslim++;
            }
        }

        $this->command->info('✓ Cluster Madinah (Muslim) — 4 tipe, ' . ($nomorMuslim - 1) . ' kavling (Terjual: ' . $soldMuslim . ', Dipesan: ' . $usedMuslim . ', Tersedia: ' . ($totalMuslim - $soldMuslim - $usedMuslim) . ')');
        $this->command->info('✓ Cluster Mount Carmel (Non-Muslim) — 8 tipe, ' . ($nomorNonMuslim - 1) . ' kavling (Terjual: ' . $soldNonMuslim . ', Dipesan: ' . $usedNonMuslim . ', Tersedia: ' . ($totalNonMuslim - $soldNonMuslim - $usedNonMuslim) . ')');
        $this->command->info('Seeder selesai.');
    }
}