<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('produks')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        
        DB::table('produks')->insert([
            // SHAFIRA - Blue Category
            [
                'produk_nama' => 'SHAFIRA_COMBO 15GB 20HARI',
                'produk_detail' => '15 GB - COMBO INTERNET - 20 HARI',
                'produk_stok' => 50,
                'produk_harga' => 450000,
                'produk_diskon' => 0,
                'produk_insentif' => 10000,
            ],
            [
                'produk_nama' => 'SHAFIRA_COMBO 23GB 30HARI',
                'produk_detail' => '23 GB - COMBO INTERNET - 30 HARI',
                'produk_stok' => 50,
                'produk_harga' => 650000,
                'produk_diskon' => 0,
                'produk_insentif' => 15000,
            ],
            [
                'produk_nama' => 'SHAFIRA_COMBO 30GB 45HARI',
                'produk_detail' => '30 GB - COMBO INTERNET - 45 HARI',
                'produk_stok' => 50,
                'produk_harga' => 850000,
                'produk_diskon' => 0,
                'produk_insentif' => 20000,
            ],
            [
                'produk_nama' => 'SHAFIRA_INTERNET 15GB 20HARI',
                'produk_detail' => '15 GB - INTERNET ONLY - 20 HARI',
                'produk_stok' => 100,
                'produk_harga' => 350000,
                'produk_diskon' => 0,
                'produk_insentif' => 5000,
            ],
            // TAKHOBAR - Yellow Category
            [
                'produk_nama' => 'TAKHOBAR_COMBO 15GB 20HARI',
                'produk_detail' => '15 GB - COMBO INTERNET - 20 HARI',
                'produk_stok' => 40,
                'produk_harga' => 450000,
                'produk_diskon' => 5,
                'produk_insentif' => 12000,
            ],
            [
                'produk_nama' => 'TAKHOBAR_COMBO 23GB 30HARI',
                'produk_detail' => '23 GB - COMBO INTERNET - 30 HARI',
                'produk_stok' => 40,
                'produk_harga' => 650000,
                'produk_diskon' => 5,
                'produk_insentif' => 18000,
            ],
            [
                'produk_nama' => 'TAKHOBAR_INTERNET 15GB 20HARI',
                'produk_detail' => '15 GB - INTERNET ONLY - 20 HARI',
                'produk_stok' => 80,
                'produk_harga' => 350000,
                'produk_diskon' => 0,
                'produk_insentif' => 7000,
            ],
            // MUHAMMADIYAH - Orange Category
            [
                'produk_nama' => 'MUHAMMADIYAH_COMBO 15GB 20HARI',
                'produk_detail' => '15 GB - COMBO INTERNET - 20 HARI',
                'produk_stok' => 60,
                'produk_harga' => 440000,
                'produk_diskon' => 0,
                'produk_insentif' => 11000,
            ],
            [
                'produk_nama' => 'MUHAMMADIYAH_COMBO 23GB 30HARI',
                'produk_detail' => '23 GB - COMBO INTERNET - 30 HARI',
                'produk_stok' => 60,
                'produk_harga' => 640000,
                'produk_diskon' => 0,
                'produk_insentif' => 16000,
            ],
            [
                'produk_nama' => 'MUHAMMADIYAH_INTERNET 15GB 20HARI',
                'produk_detail' => '15 GB - INTERNET ONLY - 20 HARI',
                'produk_stok' => 120,
                'produk_harga' => 340000,
                'produk_diskon' => 0,
                'produk_insentif' => 6000,
            ],
        ]);
    }
}