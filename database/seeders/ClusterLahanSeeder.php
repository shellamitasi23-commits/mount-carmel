<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cluster;
use App\Models\Lahan;
use Illuminate\Support\Facades\DB;

class ClusterLahanSeeder extends Seeder
{
    public function run(): void
    {
        // Nonaktifkan foreign key checks untuk MySQL
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('lahans')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Cluster Madinah (Muslim) - Total 3000 Unit
        $madinah = Cluster::firstOrCreate(['nama_cluster' => 'Cluster Madinah'], ['kategori' => 'Muslim']);
        
        $muslimTypes = [
            ['tipe' => 'Barokah', 'ukuran' => '1.5 x 2.5 m', 'kapasitas' => 1, 'harga' => 25_000_000, 'ratio' => 0.4],
            ['tipe' => 'Barokah Special', 'ukuran' => '1.5 x 2.5 m', 'kapasitas' => 1, 'harga' => 27_500_000, 'ratio' => 0.2],
            ['tipe' => 'Fitrah', 'ukuran' => '4 x 3 m', 'kapasitas' => 2, 'harga' => 85_000_000, 'ratio' => 0.15],
            ['tipe' => 'Fitrah Special', 'ukuran' => '4 x 3 m', 'kapasitas' => 2, 'harga' => 90_000_000, 'ratio' => 0.1],
            ['tipe' => 'Shakinah', 'ukuran' => '7 x 8 m', 'kapasitas' => 6, 'harga' => 425_000_000, 'ratio' => 0.07],
            ['tipe' => 'Shakinah Special', 'ukuran' => '7 x 8 m', 'kapasitas' => 6, 'harga' => 450_000_000, 'ratio' => 0.03],
            ['tipe' => 'Khalifah', 'ukuran' => '7 x 15 m', 'kapasitas' => 12, 'harga' => 750_000_000, 'ratio' => 0.03],
            ['tipe' => 'Khalifah Special', 'ukuran' => '7 x 15 m', 'kapasitas' => 12, 'harga' => 800_000_000, 'ratio' => 0.02],
        ];

        $this->command->info('Seeding 3,000 Muslim Units...');
        $muslimCounter = 1;
        foreach ($muslimTypes as $t) {
            $count = 3000 * $t['ratio'];
            for ($i = 1; $i <= $count; $i++) {
                $prefix = ['A', 'B', 'C'][rand(0, 2)];
                Lahan::create([
                    'cluster_id' => $madinah->id,
                    'nomor_lahan' => $prefix . '-' . str_pad($muslimCounter++, 4, '0', STR_PAD_LEFT),
                    'tipe_lahan' => $t['tipe'],
                    'hadap' => $prefix,
                    'ukuran' => $t['ukuran'],
                    'kapasitas' => $t['kapasitas'],
                    'harga' => $t['harga'],
                    'status' => 'Tersedia',
                ]);
            }
        }

        // 2. Cluster Mount Carmel (Non-Muslim) - Total 2800 Unit
        $mountCarmel = Cluster::firstOrCreate(['nama_cluster' => 'Cluster Mount Carmel'], ['kategori' => 'Non-Muslim']);
        
        $nonMuslimTypes = [
            ['tipe' => 'Single', 'ukuran' => '1.5 x 4 m', 'kapasitas' => 1, 'harga' => 60_000_000, 'ratio' => 0.3],
            ['tipe' => 'Single Special', 'ukuran' => '1.5 x 4 m', 'kapasitas' => 1, 'harga' => 65_000_000, 'ratio' => 0.15],
            ['tipe' => 'Double', 'ukuran' => '3 x 4 m', 'kapasitas' => 2, 'harga' => 120_000_000, 'ratio' => 0.15],
            ['tipe' => 'Double Special', 'ukuran' => '3 x 4 m', 'kapasitas' => 2, 'harga' => 130_000_000, 'ratio' => 0.1],
            ['tipe' => 'D. Deluxe', 'ukuran' => '4 x 4.5 m', 'kapasitas' => 2, 'harga' => 140_000_000, 'ratio' => 0.1],
            ['tipe' => 'D. Deluxe Special', 'ukuran' => '4 x 4.5 m', 'kapasitas' => 2, 'harga' => 155_000_000, 'ratio' => 0.05],
            ['tipe' => 'D. Special', 'ukuran' => '8 x 4.5 m', 'kapasitas' => 4, 'harga' => 280_000_000, 'ratio' => 0.05],
            ['tipe' => 'Family', 'ukuran' => '8 x 5 m', 'kapasitas' => 4, 'harga' => 400_000_000, 'ratio' => 0.03],
            ['tipe' => 'Family Special', 'ukuran' => '8 x 5 m', 'kapasitas' => 4, 'harga' => 425_000_000, 'ratio' => 0.02],
            ['tipe' => 'Super Family', 'ukuran' => '8 x 10 m', 'kapasitas' => 6, 'harga' => 800_000_000, 'ratio' => 0.02],
            ['tipe' => 'Super Family Special', 'ukuran' => '8 x 10 m', 'kapasitas' => 6, 'harga' => 850_000_000, 'ratio' => 0.01],
            ['tipe' => 'Royal Family', 'ukuran' => '16 x 20 m', 'kapasitas' => 10, 'harga' => 3_500_000_000, 'ratio' => 0.01],
            ['tipe' => 'Royal Family Special', 'ukuran' => '16 x 20 m', 'kapasitas' => 10, 'harga' => 3_800_000_000, 'ratio' => 0.005],
            ['tipe' => 'VIP', 'ukuran' => '26 x 36 m', 'kapasitas' => 18, 'harga' => 12_800_000_000, 'ratio' => 0.003],
            ['tipe' => 'VIP Special', 'ukuran' => '26 x 36 m', 'kapasitas' => 18, 'harga' => 13_500_000_000, 'ratio' => 0.002],
        ];

        $this->command->info('Seeding 2,800 Non-Muslim Units...');
        $nmCounter = 1;
        foreach ($nonMuslimTypes as $t) {
            $count = 2800 * $t['ratio'];
            for ($i = 1; $i <= $count; $i++) {
                $hadap = ['Utara', 'Selatan', 'Barat', 'Timur'][rand(0, 3)];
                $prefix = strtoupper(substr($hadap, 0, 2));
                Lahan::create([
                    'cluster_id' => $mountCarmel->id,
                    'nomor_lahan' => $prefix . '-' . str_pad($nmCounter++, 4, '0', STR_PAD_LEFT),
                    'tipe_lahan' => $t['tipe'],
                    'hadap' => $hadap,
                    'ukuran' => $t['ukuran'],
                    'kapasitas' => $t['kapasitas'],
                    'harga' => $t['harga'],
                    'status' => 'Tersedia',
                ]);
            }
        }

        $this->command->info('Seeder Berhasil! Total 5.800 Lahan telah dibuat.');
    }
}
