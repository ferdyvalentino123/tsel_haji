<?php
require 'vendor/autoload.php';
\ = require_once 'bootstrap/app.php';
\->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

\ = DB::table('transaksis')
    ->orderBy('tanggal_transaksi', 'desc')
    ->limit(10)
    ->get();

echo "=== TOP 10 TRANSAKSI ===" . PHP_EOL;
foreach (\ as \) {
    echo "ID: {->id} | Nama: {->nama_pelanggan} | Total: Rp" . number_format(\->total_harga, 0, ',', '.') . " | Status: {->status} | Paid: " . (\->is_paid ? 'YES' : 'NO') . PHP_EOL;
}
