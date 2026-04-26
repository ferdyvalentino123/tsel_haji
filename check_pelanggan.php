<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\RoleUsers;

// Cek apakah role pelanggan ada
echo "Checking role_users table...\n";

$pelanggan = RoleUsers::where('email', 'pelanggan@test.com')->first();

if ($pelanggan) {
    echo "✓ Data pelanggan ditemukan!\n";
    echo "  ID: " . $pelanggan->id . "\n";
    echo "  Name: " . $pelanggan->name . "\n";
    echo "  Email: " . $pelanggan->email . "\n";
    echo "  Role: " . $pelanggan->role . "\n";
    echo "  Phone: " . $pelanggan->phone . "\n";
    
    // Test PIN
    if (Hash::check('123456', $pelanggan->pin)) {
        echo "✓ PIN valid!\n";
    } else {
        echo "✗ PIN tidak valid! Updating PIN...\n";
        $pelanggan->pin = Hash::make('123456');
        $pelanggan->save();
        echo "✓ PIN berhasil diupdate!\n";
    }
} else {
    echo "✗ Data pelanggan tidak ditemukan. Membuat data baru...\n";
    
    RoleUsers::create([
        'name' => 'Pelanggan Test',
        'email' => 'pelanggan@test.com',
        'pin' => Hash::make('123456'),
        'phone' => '081234567890',
        'role' => 'pelanggan',
        'is_superuser' => false,
        'is_setoran' => false,
    ]);
    
    echo "✓ Data pelanggan berhasil dibuat!\n";
}

// Cek semua pelanggan
echo "\n=== Semua Pelanggan ===\n";
$allPelanggan = RoleUsers::where('role', 'pelanggan')->get(['id', 'name', 'email', 'role']);
foreach ($allPelanggan as $p) {
    echo "- {$p->name} ({$p->email}) - Role: {$p->role}\n";
}

echo "\n✓ Selesai!\n";
