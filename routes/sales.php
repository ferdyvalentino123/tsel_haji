<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Sales\DashboardController;

Route::middleware(['auth', 'sales'])->group(function () {
    Route::get('/programhaji/sales', [DashboardController::class, 'index'])->name('sales.home');
});