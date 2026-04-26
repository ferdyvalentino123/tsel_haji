<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Kasir\DashboardController;
use App\Http\Controllers\Kasir\ExportApprovedTransaksiController;
use App\Http\Controllers\Kasir\ExportRiwayatTransaksiController;
use App\Http\Controllers\Kasir\TransaksiController;

// Kasir Routes (require auth and kasir role)
Route::middleware(['auth', 'kasir'])->group(function () {
    Route::get('/programhaji/kasir', [DashboardController::class, 'index'])->name('kasir.home');
    Route::post('/programhaji/kasir/export-approved', [ExportApprovedTransaksiController::class, 'export'])->name('kasir.export-approved');
    Route::post('/programhaji/kasir/export-riwayat', [ExportRiwayatTransaksiController::class, 'export'])->name('kasir.export-riwayat');
    Route::get('/programhaji/kasir/approvetransaksi', [TransaksiController::class, 'approveTransaksi'])->name('transaksi.approve');
    
    // Transaction Management Routes
    Route::prefix('transactions')->name('transactions.')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('index');
    });
});
