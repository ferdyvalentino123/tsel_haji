<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/programhaji/travel', function () {
        return view('travel.dashboard');
    })->name('travel.home');
});