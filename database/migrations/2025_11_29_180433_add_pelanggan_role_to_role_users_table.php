<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('role_users', function (Blueprint $table) {
            // Mengubah kolom role untuk menambahkan 'pelanggan'
            DB::statement("ALTER TABLE role_users MODIFY COLUMN role ENUM('kasir', 'sales', 'admin', 'pelanggan') DEFAULT 'sales'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('role_users', function (Blueprint $table) {
            // Kembalikan ke enum sebelumnya
            DB::statement("ALTER TABLE role_users MODIFY COLUMN role ENUM('kasir', 'sales', 'admin') DEFAULT 'sales'");
        });
    }
};
