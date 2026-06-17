<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Lahan;
use App\Models\Reservasi;
use App\Models\Pembayaran;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class SalesSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create mock buyers if they don't exist
        $buyerData = [
            ['name' => 'Budi Santoso', 'email' => 'budi.santoso@example.com'],
            ['name' => 'Siti Aminah', 'email' => 'siti.aminah@example.com'],
            ['name' => 'Joko Susilo', 'email' => 'joko.susilo@example.com'],
            ['name' => 'Rini Astuti', 'email' => 'rini.astuti@example.com'],
            ['name' => 'Dewi Lestari', 'email' => 'dewi.lestari@example.com'],
            ['name' => 'Andi Wijaya', 'email' => 'andi.wijaya@example.com'],
            ['name' => 'Slamet Rahardjo', 'email' => 'slamet.r@example.com'],
            ['name' => 'Sri Wahyuni', 'email' => 'sri.wahyuni@example.com'],
            ['name' => 'Hendra Kurniawan', 'email' => 'hendra.k@example.com'],
            ['name' => 'Megawati', 'email' => 'megawati@example.com'],
        ];

        $buyers = [];
        foreach ($buyerData as $data) {
            $buyers[] = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role' => 'pembeli',
                    'no_telepon' => '0812' . rand(10000000, 99999999),
                    'alamat' => 'Semarang, Jawa Tengah',
                ]
            );
        }

        // Add existing regular users
        $existingBuyers = User::whereIn('id', [8, 9])->get();
        foreach ($existingBuyers as $buyer) {
            $buyers[] = $buyer;
        }

        // 2. Fetch available Lahans
        $lahans = Lahan::where('status', 'Tersedia')->get();

        if ($lahans->isEmpty()) {
            return;
        }

        // We want a nice up-and-down pattern for the last 6 months (5, 4, 3, 2, 1, 0 months ago)
        // Let's specify the count of payments/sales per month:
        // Month 5 ago: 3 sales
        // Month 4 ago: 7 sales
        // Month 3 ago: 2 sales
        // Month 2 ago: 8 sales
        // Month 1 ago: 4 sales
        // Month 0 (current month): 9 sales
        $salesPerMonth = [
            5 => 3,
            4 => 7,
            3 => 2,
            2 => 8,
            1 => 4,
            0 => 9,
        ];

        $lahanIndex = 0;
        $invoiceCounter = 1001;

        foreach ($salesPerMonth as $monthsAgo => $count) {
            $monthDate = Carbon::now()->subMonths($monthsAgo);
            
            for ($j = 0; $j < $count; $j++) {
                if ($lahanIndex >= $lahans->count()) {
                    break;
                }
                
                $lahan = $lahans[$lahanIndex++];
                $buyer = $buyers[array_rand($buyers)];
                
                // Randomize days within that month
                $day = rand(1, 28);
                $saleDate = Carbon::create($monthDate->year, $monthDate->month, $day, rand(9, 17), rand(0, 59), rand(0, 59));
                
                // Create Reservasi
                $reservasi = Reservasi::create([
                    'user_id' => $buyer->id,
                    'lahan_id' => $lahan->id,
                    'nama_jenazah' => 'Alm. ' . ['Prabowo', 'Sudirman', 'Suharto', 'Habibie', 'Gus Dur', 'Megawati', 'Yudhoyono', 'Kartini', 'Diponegoro', 'Gajah Mada'][rand(0, 9)],
                    'tanggal_reservasi' => $saleDate,
                    'status_reservasi' => 'Disetujui',
                    'status_pembayaran' => 'Lunas',
                    'alamat_pemesan' => $buyer->alamat ?? 'Semarang',
                    'jenis_pembayaran' => 'tunai',
                    'biaya_reservasi' => 1000000,
                    'biaya_penuh' => $lahan->harga,
                    'marketing_oleh' => ['Marketing Rendi', 'Marketing Siska', 'Marketing Adi'][rand(0, 2)],
                    'disetujui_oleh' => 'Manajer Mount Carmel',
                ]);

                // Create Pembayaran
                Pembayaran::create([
                    'reservasi_id' => $reservasi->id,
                    'no_invoice' => 'INV-' . $saleDate->format('Ymd') . '-' . ($invoiceCounter++),
                    'jumlah_bayar' => $lahan->harga,
                    'tanggal_bayar' => $saleDate,
                    'bukti_pembayaran' => 'bukti.png',
                    'status_pembayaran' => 'Lunas',
                    'nama_bank' => ['BCA', 'Mandiri', 'BNI', 'BRI'][rand(0, 3)],
                    'rekening_tujuan' => '1234567890',
                    'atas_nama_rekening' => $buyer->name,
                    'dikonfirmasi_oleh' => ['Accounting Clara', 'Accounting Hendra', 'Accounting Budi'][rand(0, 2)],
                ]);

                // Update Lahan status to Terjual
                $lahan->update(['status' => 'Terjual']);
            }
        }
    }
}
