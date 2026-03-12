<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Jalankan seeder database.
     */
    public function run(): void
    {
        // Kita gunakan updateOrCreate agar tidak terjadi error duplikat 
        // jika kamu menjalankan seeder ini berkali-kali.
        User::updateOrCreate(
            ['email' => 'admin@mountcarmel.id'], // Ini akan jadi email login
            [
                'name' => 'Super Admin',
                'password' => Hash::make('admin12345'), // Ini akan jadi kata sandi login

                // Catatan: Kalau nanti di tabel users kamu menambahkan kolom 'role', 
                // kamu bisa tambahkan di sini, misalnya: 'role' => 'admin'
            ]
        );
    }
}