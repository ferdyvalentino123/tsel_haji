<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RoleUsers;
class CreateSuperUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        RoleUsers::create([
            'name' => 'Super Super',
            'email' =>'supersuper@example.com',
            'pin' => bcrypt('123456'),
            'role' => 'kasir',
            'is_superuser' => true,
        ]);
    }
}
