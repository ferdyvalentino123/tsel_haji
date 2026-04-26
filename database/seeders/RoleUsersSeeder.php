<?php

namespace Database\Seeders;

use App\Models\RoleUsers;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;



class RoleUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = ['manage tasks', 'view tasks', 'assign tasks'];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $roles = [
            'admin' => ['manage tasks', 'view tasks', 'assign tasks'],
            'supervisor' => ['manage tasks', 'view tasks', 'assign tasks'],
            'sales' => ['view tasks']
        ];

        foreach ($roles as $roleName => $rolePermissions) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($rolePermissions);
        }

        // Create users and assign roles
        DB::table('role_users')->insert([
            [
                'name' => 'Admin',
                'email' => 'admin@test.com',
                'pin' => Hash::make('123456'),
                'role' => 'admin',
                'is_superuser' => true,
                'is_setoran' => false,
                'phone' => "081231780991",
            ],
            [
                'name' => 'Kasir',
                'email' => 'supervisor@test.com',
                'pin' => Hash::make('123456'),
                'role' => 'supervisor',
                'is_superuser' => false,
                'is_setoran' => false,
                'phone' => "081231780991",
            ],
            [
                'name' => 'Kasir Utama',
                'email' => 'kasir@test.com',
                'pin' => Hash::make('123456'),
                'role' => 'supervisor',
                'is_superuser' => true,
                'is_setoran' => false,
                'phone' => "081231780991",
            ],
            [
                'name' => 'Sales',
                'email' => 'sales@test.com',
                'pin' => Hash::make('123456'),
                'role' => 'sales',
                'is_superuser' => false,
                'is_setoran' => true,
                'phone' => "081231780991",
            ],
        ]);
    }
}