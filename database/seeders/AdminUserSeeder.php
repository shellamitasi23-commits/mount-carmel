<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'manajer@mountcarmel.id'],
            [
                'name' => 'Manajer Mount Carmel',
                'password' => Hash::make('manajer123'),
                'role' => 'manajer',
                'no_telepon' => '081234560002'
            ]
        );

        User::updateOrCreate(
            ['email' => 'marketing@mountcarmel.id'],
            [
                'name' => 'Marketing Mount Carmel',
                'password' => Hash::make('marketing123'),
                'role' => 'marketing',
                'no_telepon' => '081234560003'
            ]
        );

        User::updateOrCreate(
            ['email' => 'accounting@mountcarmel.id'],
            [
                'name' => 'Accounting Mount Carmel',
                'password' => Hash::make('accounting123'),
                'role' => 'accounting',
                'no_telepon' => '081234560004'
            ]
        );

        User::updateOrCreate(
            ['email' => 'koordinator@mountcarmel.id'],
            [
                'name' => 'Koordinator Lapangan Mount Carmel',
                'password' => Hash::make('koordinator123'),
                'role' => 'koordinator_lapangan',
                'no_telepon' => '081234560005'
            ]
        );
    }
}