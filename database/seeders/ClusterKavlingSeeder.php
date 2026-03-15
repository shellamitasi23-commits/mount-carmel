<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cluster;
use App\Models\Kavling;

class ClusterKavlingSeeder extends Seeder
{
    /**
     * Seeder data awal Mount Carmel sesuai proposal dan data asli.
     *
     * Cluster:
     *   1. Cluster Madinah       → Muslim    → 4 tipe kavling
     *   2. Cluster Mount Carmel  → Non-Muslim → 8 tipe kavling
     *
     * Jalankan: php artisan db:seed --class=ClusterKavlingSeeder
     */
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

        // 4 Tipe kavling Muslim sesuai proposal
        $kavlingMuslim = [
            [
                'tipe_kavling' => 'Barokah',
                'ukuran' => '1.5m x 2.5m',
                'kapasitas' => 1,
                'harga' => 25_000_000,
                'jumlah' => 30, // jumlah kavling yang di-generate
            ],
            [
                'tipe_kavling' => 'Fitrah',
                'ukuran' => '4m x 3m',
                'kapasitas' => 2,
                'harga' => 60_000_000,
                'jumlah' => 25,
            ],
            [
                'tipe_kavling' => 'Sakinah',
                'ukuran' => '7m x 8m',
                'kapasitas' => 6,
                'harga' => 300_000_000,
                'jumlah' => 20,
            ],
            [
                'tipe_kavling' => 'Khalifah',
                'ukuran' => '7m x 15m',
                'kapasitas' => 12,
                'harga' => 600_000_000,
                'jumlah' => 10,
            ],
        ];

        // Prefix nomor kavling Muslim: M-001, M-002, dst.
        $nomorMuslim = 1;
        foreach ($kavlingMuslim as $data) {
            for ($i = 1; $i <= $data['jumlah']; $i++) {
                Kavling::firstOrCreate(
                    [
                        'cluster_id' => $madinah->id,
                        'nomor_kavling' => 'M-' . str_pad($nomorMuslim, 3, '0', STR_PAD_LEFT),
                    ],
                    [
                        'tipe_kavling' => $data['tipe_kavling'],
                        'ukuran' => $data['ukuran'],
                        'kapasitas' => $data['kapasitas'],
                        'harga' => $data['harga'],
                        'status' => 'Tersedia',
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

        // 8 Tipe kavling Non-Muslim sesuai proposal
        $kavlingNonMuslim = [
            [
                'tipe_kavling' => 'Single',
                'ukuran' => '1.5m x 4m',
                'kapasitas' => 1,
                'harga' => 60_000_000,
                'jumlah' => 20,
            ],
            [
                'tipe_kavling' => 'Double',
                'ukuran' => '3m x 4m',
                'kapasitas' => 2,
                'harga' => 130_000_000,
                'jumlah' => 20,
            ],
            [
                'tipe_kavling' => 'Double Deluxe',
                'ukuran' => '4m x 4.5m',
                'kapasitas' => 2,
                'harga' => 150_000_000,
                'jumlah' => 15,
            ],
            [
                'tipe_kavling' => 'Double Special',
                'ukuran' => '8m x 4.5m',
                'kapasitas' => 4,
                'harga' => 300_000_000,
                'jumlah' => 15,
            ],
            [
                'tipe_kavling' => 'Family',
                'ukuran' => '8m x 5m',
                'kapasitas' => 4,
                'harga' => 500_000_000,
                'jumlah' => 12,
            ],
            [
                'tipe_kavling' => 'Super Family',
                'ukuran' => '8m x 10m',
                'kapasitas' => 6,
                'harga' => 1_000_000_000,
                'jumlah' => 10,
            ],
            [
                'tipe_kavling' => 'Royal Family',
                'ukuran' => '16m x 20m',
                'kapasitas' => 10,
                'harga' => 5_000_000_000,
                'jumlah' => 6,
            ],
            [
                'tipe_kavling' => 'VIP',
                'ukuran' => '26m x 36m',
                'kapasitas' => 18,
                'harga' => 12_000_000_000,
                'jumlah' => 4,
            ],
        ];

        // Prefix nomor kavling Non-Muslim: NM-001, NM-002, dst.
        $nomorNonMuslim = 1;
        foreach ($kavlingNonMuslim as $data) {
            for ($i = 1; $i <= $data['jumlah']; $i++) {
                Kavling::firstOrCreate(
                    [
                        'cluster_id' => $mountCarmel->id,
                        'nomor_kavling' => 'NM-' . str_pad($nomorNonMuslim, 3, '0', STR_PAD_LEFT),
                    ],
                    [
                        'tipe_kavling' => $data['tipe_kavling'],
                        'ukuran' => $data['ukuran'],
                        'kapasitas' => $data['kapasitas'],
                        'harga' => $data['harga'],
                        'status' => 'Tersedia',
                    ]
                );
                $nomorNonMuslim++;
            }
        }

        $this->command->info('✓ Cluster Madinah (Muslim) — 4 tipe, ' . ($nomorMuslim - 1) . ' kavling');
        $this->command->info('✓ Cluster Mount Carmel (Non-Muslim) — 8 tipe, ' . ($nomorNonMuslim - 1) . ' kavling');
        $this->command->info('Seeder selesai.');
    }
}