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

        // Seeding 3 Marketing Staff
        User::updateOrCreate(
            ['email' => 'marketing@mountcarmel.id'],
            [
                'name' => 'Marketing Rendi',
                'password' => Hash::make('marketing123'),
                'role' => 'marketing',
                'no_telepon' => '081234560003'
            ]
        );

        User::updateOrCreate(
            ['email' => 'marketing2@mountcarmel.id'],
            [
                'name' => 'Marketing Siska',
                'password' => Hash::make('marketing123'),
                'role' => 'marketing',
                'no_telepon' => '081234560013'
            ]
        );

        User::updateOrCreate(
            ['email' => 'marketing3@mountcarmel.id'],
            [
                'name' => 'Marketing Adi',
                'password' => Hash::make('marketing123'),
                'role' => 'marketing',
                'no_telepon' => '081234560023'
            ]
        );

        // Seeding 3 Accounting Staff
        User::updateOrCreate(
            ['email' => 'accounting@mountcarmel.id'],
            [
                'name' => 'Accounting Clara',
                'password' => Hash::make('accounting123'),
                'role' => 'accounting',
                'no_telepon' => '081234560004'
            ]
        );

        User::updateOrCreate(
            ['email' => 'accounting2@mountcarmel.id'],
            [
                'name' => 'Accounting Hendra',
                'password' => Hash::make('accounting123'),
                'role' => 'accounting',
                'no_telepon' => '081234560014'
            ]
        );

        User::updateOrCreate(
            ['email' => 'accounting3@mountcarmel.id'],
            [
                'name' => 'Accounting Budi',
                'password' => Hash::make('accounting123'),
                'role' => 'accounting',
                'no_telepon' => '081234560024'
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