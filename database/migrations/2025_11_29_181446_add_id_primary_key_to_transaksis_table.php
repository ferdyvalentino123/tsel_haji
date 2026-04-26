<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Jika tabel belum punya kolom id auto-increment, tambahkan
            // Ini untuk support transaksi pelanggan
            if (!Schema::hasColumn('transaksis', 'id')) {
                $table->id()->first();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Jangan drop id karena mungkin sudah ada dari awal
            // Migration ini hanya menambahkan jika belum ada
        });
    }
};
