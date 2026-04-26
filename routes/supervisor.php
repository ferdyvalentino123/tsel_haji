<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Kasir\DashboardController;
use App\Http\Controllers\Kasir\ExportApprovedTransaksiController;
use App\Http\Controllers\Kasir\ExportRiwayatTransaksiController;
use App\Http\Controllers\Kasir\TransaksiController;

// Supervisor Routes (require auth and supervisor role)
Route::middleware(['auth', 'supervisor'])->group(function () {
    Route::get('/programhaji/supervisor', [DashboardController::class, 'index'])->name('supvis.home');
    Route::post('/programhaji/supervisor/export-approved', [ExportApprovedTransaksiController::class, 'export'])->name('supvis.export-approved');
    Route::post('/programhaji/supervisor/export-riwayat', [ExportRiwayatTransaksiController::class, 'export'])->name('supvis.export-riwayat');
    Route::get('/programhaji/supervisor/approvetransaksi', [TransaksiController::class, 'approveTransaksi'])->name('supvis.transaksi.approve');
    
    // Transaction Management Routes
    Route::prefix('transactions')->name('supvis.transactions.')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('index');
    });
});