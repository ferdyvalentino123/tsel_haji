<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

// Public Auth Routes (tidak perlu login)
Route::get('/programhaji/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/programhaji/login', [LoginController::class, 'login']); // No name - form uses route('login') for GET
Route::post('/programhaji/register', [LoginController::class, 'register'])->name('register');

// Google OAuth
Route::get('/programhaji/auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/programhaji/auth/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('auth.google.callback');

// Logout (perlu login)
Route::middleware(['auth'])->group(function () {
    Route::post('/programhaji/logout', [LoginController::class, 'logout'])->name('logout');
});