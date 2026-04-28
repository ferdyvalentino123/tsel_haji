<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambahkan kolom nomor_roaming ke tabel transaksis.
     * Kolom ini diisi secara manual oleh tim internal admin
     * karena data paket roaming dari Telkomsel belum tersedia via API.
     */
    public function up(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->string('nomor_roaming')->nullable()->after('nomor_injeksi')
                  ->comment('Nomor roaming pelanggan, diisi manual oleh tim internal');
        });
    }

    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropColumn('nomor_roaming');
        });
    }
};
