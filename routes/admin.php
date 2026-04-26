<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\ProdukController;
use App\Http\Controllers\Admin\MerchandiseController;
use App\Http\Controllers\Admin\RoleUsersController;
use App\Http\Controllers\Admin\StockHistoryController;
use App\Http\Controllers\Admin\TransaksiController;

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('programhaji/admin')->name('admin.')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    
    // Produk
    Route::prefix('produk')->name('produk.')->group(function () {
        Route::get('/', [ProdukController::class, 'index'])->name('index');
        Route::get('/create', [ProdukController::class, 'create'])->name('create');
        Route::post('/', [ProdukController::class, 'store'])->name('store');
        Route::get('/{produk}', [ProdukController::class, 'show'])->name('show');
        Route::get('/{produk}/edit', [ProdukController::class, 'edit'])->name('edit');
        Route::put('/{produk}', [ProdukController::class, 'update'])->name('update');
        Route::delete('/{produk}', [ProdukController::class, 'destroy'])->name('destroy');
    });
    
    // Merchandise
    Route::prefix('merchandise')->name('merchandise.')->group(function () {
        Route::get('/', [MerchandiseController::class, 'index'])->name('index');
        Route::get('/create', [MerchandiseController::class, 'create'])->name('create');
        Route::post('/', [MerchandiseController::class, 'store'])->name('store');
        Route::get('/{merchandise}', [MerchandiseController::class, 'show'])->name('show');
        Route::get('/{merchandise}/edit', [MerchandiseController::class, 'edit'])->name('edit');
        Route::put('/{merchandise}', [MerchandiseController::class, 'update'])->name('update');
        Route::delete('/{merchandise}', [MerchandiseController::class, 'destroy'])->name('destroy');
    });
    
    // Role Users
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [RoleUsersController::class, 'index'])->name('index');
        Route::get('/create', [RoleUsersController::class, 'create'])->name('create');
        Route::post('/', [RoleUsersController::class, 'store'])->name('store');
        Route::get('/{user}', [RoleUsersController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [RoleUsersController::class, 'edit'])->name('edit');
        Route::put('/{user}', [RoleUsersController::class, 'update'])->name('update');
        Route::delete('/{user}', [RoleUsersController::class, 'destroy'])->name('destroy');
    });
    
    // Stock History
    Route::prefix('stock-history')->name('stock-history.')->group(function () {
        Route::get('/', [StockHistoryController::class, 'index'])->name('index');
    });

    // Transaksi
    Route::prefix('transaksi')->name('transaksi.')->group(function () {
        Route::get('/', [TransaksiController::class, 'index'])->name('index');
        Route::get('/{transaksi}', [TransaksiController::class, 'show'])->name('show');
    });
});


