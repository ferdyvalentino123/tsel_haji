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
            // Menambahkan field untuk transaksi pelanggan
            $table->unsignedBigInteger('id_pelanggan')->nullable()->after('id_supervisor');
            $table->unsignedBigInteger('produk_id')->nullable()->after('id_pelanggan');
            $table->integer('jumlah')->nullable()->after('produk_id');
            $table->decimal('total_harga', 15, 2)->nullable()->after('jumlah');
            
            // Menambahkan foreign key
            $table->foreign('id_pelanggan')->references('id')->on('role_users')->onDelete('set null');
            $table->foreign('produk_id')->references('id')->on('produks')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            // Drop foreign keys first
            $table->dropForeign(['id_pelanggan']);
            $table->dropForeign(['produk_id']);
            
            // Drop columns
            $table->dropColumn(['id_pelanggan', 'produk_id', 'jumlah', 'total_harga']);
        });
    }
};
