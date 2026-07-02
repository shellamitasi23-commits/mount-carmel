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
            ['email' => 'marketingrendi@mountcarmel.id'],
            [
                'name' => 'Marketing Rendi',
                'password' => Hash::make('rendi123'),
                'role' => 'marketing',
                'no_telepon' => '081234560003'
            ]
        );

        User::updateOrCreate(
            ['email' => 'marketingsiska@mountcarmel.id'],
            [
                'name' => 'Marketing Siska',
                'password' => Hash::make('siska123'),
                'role' => 'marketing',
                'no_telepon' => '081234560013'
            ]
        );

        User::updateOrCreate(
            ['email' => 'marketingacha@mountcarmel.id'],
            [
                'name' => 'Marketing Acha',
                'password' => Hash::make('acha123'),
                'role' => 'marketing',
                'no_telepon' => '081234560033'
            ]
        );

        // Seeding 3 Accounting Staff
        User::updateOrCreate(
            ['email' => 'accountingclara@mountcarmel.id'],
            [
                'name' => 'Accounting Clara',
                'password' => Hash::make('clara123'),
                'role' => 'accounting',
                'no_telepon' => '081234560004'
            ]
        );

        User::updateOrCreate(
            ['email' => 'accountinghendra@mountcarmel.id'],
            [
                'name' => 'Accounting Hendra',
                'password' => Hash::make('hendra123'),
                'role' => 'accounting',
                'no_telepon' => '081234560014'
            ]
        );

        User::updateOrCreate(
            ['email' => 'accountingbudi@mountcarmel.id'],
            [
                'name' => 'Accounting Budi',
                'password' => Hash::make('budi123'),
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
        
        foreach (['sapira' => 'sapira@email.com', 'rizky' => 'rizky@email.com', 'ali' => 'ali@email.com'] as $name => $email) {
            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => ucfirst($name),
                    'password' => Hash::make('password'),
                    'role' => 'pembeli',
                    'no_telepon' => '0812' . rand(10000000, 99999999),
                    'alamat' => 'Semarang, Jawa Tengah'
                ]
            );
        }
    }
}