<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pelanggan\PelangganController;

Route::middleware(['pelanggan'])->group(function () {
    // Dashboard Pelanggan - Lihat Produk
    Route::get('/programhaji/pelanggan/home', [PelangganController::class, 'index'])
        ->name('pelanggan.home');
    
    // Detail Produk
    Route::get('/programhaji/pelanggan/produk/{id}', [PelangganController::class, 'showProduk'])
        ->name('pelanggan.produk.detail');
    
    // Form Beli Produk
    Route::get('/programhaji/pelanggan/produk/{id}/beli', [PelangganController::class, 'beliProduk'])
        ->name('pelanggan.produk.beli');
    
    // Process Transaksi
    Route::post('/programhaji/pelanggan/transaksi', [PelangganController::class, 'processTransaksi'])
        ->name('pelanggan.transaksi.process');
    
    // Halaman Pembayaran QRIS
    Route::get('/programhaji/pelanggan/pembayaran/{id}', [PelangganController::class, 'pembayaran'])
        ->name('pelanggan.pembayaran');
    
    // Callback Pembayaran
    Route::match(['get', 'post'], '/programhaji/pelanggan/pembayaran/{id}/callback', [PelangganController::class, 'callbackPembayaran'])
        ->name('pelanggan.pembayaran.callback');
    
    // Riwayat Transaksi
    Route::get('/programhaji/pelanggan/riwayat-transaksi', [PelangganController::class, 'riwayatTransaksi'])
        ->name('pelanggan.riwayat-transaksi');
    
    // Batalkan Transaksi
    Route::post('/programhaji/pelanggan/transaksi/{id}/batalkan', [PelangganController::class, 'batalkanTransaksi'])
        ->name('pelanggan.transaksi.batalkan');
    
    // Profil Pelanggan
    Route::get('/programhaji/pelanggan/profil', [PelangganController::class, 'profil'])
        ->name('pelanggan.profil');
    Route::post('/programhaji/pelanggan/profil/update', [PelangganController::class, 'updateProfil'])
        ->name('pelanggan.profil.update');

    // Download Nota/Struk
    Route::get('/programhaji/pelanggan/transaksi/{id}/nota', [PelangganController::class, 'downloadNota'])
        ->name('pelanggan.transaksi.nota');
});

// Webhook Midtrans (No Middleware - untuk external call)
Route::post('/midtrans/notification', [PelangganController::class, 'notificationHandler'])
    ->name('midtrans.notification');