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
    Route::prefix('programhaji/supervisor/transactions')->name('supvis.transactions.')->group(function () {
        Route::get('/riwayat', [TransaksiController::class, 'index'])->name('index');
    });

    // Sales & User Management (Managed by Supervisor/Admin)
    Route::get('/programhaji/tambah-sales', fn() => view('supvis.add_sales'))->name('add_sales');
    Route::get('/programhaji/tambah-supvis', fn() => view('supvis.add_supvis'))->name('add_supvis');
    Route::get('/programhaji/superuser/roleusers/sales', [DashboardController::class, 'tampilsales'])->name('role-users.sales');
    Route::post('/role-users/mass-update', [DashboardController::class, 'massUpdate'])->name('role-users.mass-update');
    Route::get('/programhaji/superuser/role-users/{id}/edit', [DashboardController::class, 'edit'])->name('role-users.edit');
    Route::put('/programhaji/superuser/role-users/{id}', [DashboardController::class, 'update'])->name('role-users.update');

    // Checklist & History Setoran
    Route::get('/programhaji/history-setoran', [\App\Http\Controllers\Kasir\DashboardController::class, 'showHistorySetoran'])->name('history-setoran');
    Route::post('/programhaji/update-setoran-sales', [\App\Http\Controllers\Kasir\DashboardController::class, 'updateSetoranSales'])->name('update.setoran.sales');
    Route::post('/programhaji/update-setoran-status', [\App\Http\Controllers\Kasir\DashboardController::class, 'updateSetoranStatus'])->name('update.setoran.status');

    // Budget Insentif
    Route::get('/programhaji/supervisor/budget-insentif', [\App\Http\Controllers\Sales\BudgetInsentifController::class, 'index'])->name('supvis.budget_insentif.index');
    Route::get('/programhaji/supervisor/budget-insentif/pantau', [\App\Http\Controllers\Sales\BudgetInsentifController::class, 'pantau'])->name('supvis.budget_insentif.pantau');

    // Store User Routes
    Route::post('/programhaji/sales/store', [DashboardController::class, 'store'])->name('sales.store');
    Route::post('/programhaji/supvis/store', [\App\Http\Controllers\Kasir\DashboardController::class, 'store'])->name('supvis.store');
});