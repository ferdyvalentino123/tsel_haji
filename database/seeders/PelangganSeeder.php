<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RoleUsers;
use Illuminate\Support\Facades\Hash;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat akun pelanggan test
        RoleUsers::create([
            'name' => 'Pelanggan Test',
            'email' => 'pelanggan@test.com',
            'pin' => Hash::make('123456'),
            'phone' => '081234567890',
            'role' => 'pelanggan',
            'is_superuser' => false,
            'is_setoran' => false,
        ]);

        RoleUsers::create([
            'name' => 'Ahmad Jamaah Haji',
            'email' => 'ahmad@haji.com',
            'pin' => Hash::make('123456'),
            'phone' => '081234567891',
            'role' => 'pelanggan',
            'is_superuser' => false,
            'is_setoran' => false,
        ]);

        RoleUsers::create([
            'name' => 'Siti Fatimah',
            'email' => 'siti@haji.com',
            'pin' => Hash::make('123456'),
            'phone' => '081234567892',
            'role' => 'pelanggan',
            'is_superuser' => false,
            'is_setoran' => false,
        ]);
    }
}
