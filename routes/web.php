<?php

use Illuminate\Support\Facades\Route;

// Root landing page
Route::get('/', function () {
    return view('welcome');
});

// Programhaji landing page redirect
Route::get('/programhaji/', function () {
    return redirect('/programhaji/login');
});

// ────────────────────────────────────────────────────────────
// IMPORT ALL ROUTE FILES
// ────────────────────────────────────────────────────────────

// Auth Routes (login, register, OAuth)
require __DIR__ . '/auth.php';

// Admin Routes (auth + role:admin)
require __DIR__ . '/admin.php';

// Supervisor Routes (auth + role:supervisor)
require __DIR__ . '/supervisor.php';

// Kasir Routes (auth + role:kasir)
require __DIR__ . '/kasir.php';

// Sales Routes (auth + role:sales)
require __DIR__ . '/sales.php';

// Pelanggan Routes (auth + role:pelanggan)
require __DIR__ . '/pelanggan.php';

// Travel Routes (auth + role:travel)
require __DIR__ . '/travel.php';

// Add this to routes/web.php temporarily
Route::get('/check-admin', function () {
    $admin = \App\Models\RoleUsers::where('email', 'admin@test.com')->first();
    
    if (!$admin) {
        return "User not found";
    }
    
    return "Email: {$admin->email}<br>Role: {$admin->role}<br>ID: {$admin->id}";
});