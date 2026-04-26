<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@mountcarmel.id'],
            [
                'name' => 'Admin Mount Carmel',
                'password' => Hash::make('admin123454'),
                'role' => 'admin', 
                'no_telepon' => '081234567890'
            ]
        );

        // 2. Buat Akun Pimpinan 
        User::updateOrCreate(
            ['email' => 'pimpinan@mountcarmel.id'],
            [
                'name' => 'Pimpinan Mount Carmel',
                'password' => Hash::make('pimpinan123'),
                'role' => 'pimpinan', 
                'no_telepon' => '081111222333'
            ]
        );
    }
}