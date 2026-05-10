<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\MerchandiseController;
use App\Http\Controllers\Admin\StockHistoryController;
use App\Http\Controllers\Admin\RoleUsersController;
use App\Http\Controllers\Admin\TransaksiController;

// Admin Routes group with auth and admin middleware
Route::middleware(['auth', 'admin'])->prefix('programhaji/admin')->group(function () {
    
    // Dashboard / Home
    Route::get('/home', [HomeController::class, 'index'])->name('admin.home');
    
    // Produk Management
    Route::resource('produk', ProdukController::class, ['as' => 'admin']);
    
    // Merchandise Management
    Route::resource('merchandise', MerchandiseController::class, ['as' => 'admin']);
    
    // Stock History
    Route::resource('stock-history', StockHistoryController::class, ['as' => 'admin']);
    
    // Transaksi Management
    Route::prefix('transaksi')->name('admin.transaksi.')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('index');
        Route::get('/export', [TransaksiController::class, 'exportExcel'])->name('export');
        Route::get('/{transaksi}', [TransaksiController::class, 'show'])->name('show');
        Route::patch('/{id}/roaming', [TransaksiController::class, 'updateRoaming'])->name('update-roaming');
        Route::post('/{id}/aktivasi', [TransaksiController::class, 'aktivasi'])->name('aktivasi');
    });

    // Users Management (mapped to RoleUsersController)
    Route::resource('users', RoleUsersController::class, ['as' => 'admin']);
    // Backup route name if needed
    Route::resource('role-users', RoleUsersController::class, ['as' => 'admin']);

    // Rekapan Insentif Sales
    Route::get('/insentif-summary', [HomeController::class, 'incentiveSummary'])->name('admin.insentif.summary');


    // Monitoring & Financial Audit
    Route::prefix('monitor')->name('admin.monitor.')->group(function () {
        Route::get('/setoran', [\App\Http\Controllers\Kasir\TransaksiController::class, 'monitorSetoran'])->name('setoran');
        Route::get('/void', [\App\Http\Controllers\Kasir\TransaksiController::class, 'supvisvoid'])->name('void');
        Route::delete('/void/{id}', [\App\Http\Controllers\Kasir\TransaksiController::class, 'supvisdestroy'])->name('destroy');
    });

});

