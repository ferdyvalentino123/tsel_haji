<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RoleUsers;
use Illuminate\Support\Facades\Hash;

class CheckPelanggan extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:pelanggan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check dan fix data pelanggan untuk login';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking data pelanggan...');
        $this->newLine();

        // Cek pelanggan test
        $pelanggan = RoleUsers::where('email', 'pelanggan@test.com')->first();

        if ($pelanggan) {
            $this->info('✓ Data pelanggan ditemukan!');
            $this->line("  ID: {$pelanggan->id}");
            $this->line("  Name: {$pelanggan->name}");
            $this->line("  Email: {$pelanggan->email}");
            $this->line("  Role: {$pelanggan->role}");
            $this->line("  Phone: {$pelanggan->phone}");
            
            // Test PIN
            if (Hash::check('123456', $pelanggan->pin)) {
                $this->info('✓ PIN valid (123456)');
            } else {
                $this->warn('✗ PIN tidak valid! Updating PIN...');
                $pelanggan->pin = '123456'; // Ini akan otomatis di-hash oleh setPinAttribute
                $pelanggan->save();
                $this->info('✓ PIN berhasil diupdate menjadi 123456');
            }
        } else {
            $this->warn('✗ Data pelanggan tidak ditemukan!');
            
            if ($this->confirm('Apakah Anda ingin membuat data pelanggan baru?', true)) {
                try {
                    RoleUsers::create([
                        'name' => 'Pelanggan Test',
                        'email' => 'pelanggan@test.com',
                        'pin' => '123456', // Akan di-hash otomatis
                        'phone' => '081234567890',
                        'role' => 'pelanggan',
                        'is_superuser' => false,
                        'is_setoran' => false,
                    ]);
                    
                    $this->info('✓ Data pelanggan berhasil dibuat!');
                } catch (\Exception $e) {
                    $this->error('✗ Error: ' . $e->getMessage());
                }
            }
        }

        $this->newLine();
        $this->info('=== Semua Pelanggan ===');
        $allPelanggan = RoleUsers::where('role', 'pelanggan')->get(['id', 'name', 'email', 'role']);
        
        if ($allPelanggan->count() > 0) {
            foreach ($allPelanggan as $p) {
                $this->line("- {$p->name} ({$p->email}) - Role: {$p->role}");
            }
        } else {
            $this->warn('Tidak ada data pelanggan ditemukan!');
        }

        $this->newLine();
        $this->info('Selesai!');
        
        return 0;
    }
}
