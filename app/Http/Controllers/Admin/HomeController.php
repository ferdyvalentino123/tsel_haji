<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Transaksi;

class HomeController extends Controller
{
    public function index()
    {
        // Get statistics
        $totalProducts = Produk::count();
        $totalTransactions = Transaksi::count(); // Tetap menghitung semua transaksi (niat beli)
        
        // Pendapatan Total HANYA memperhitungkan transaksi yang sudah lunas/berhasil
        $totalRevenue = Transaksi::where(function($q) {
            $q->whereIn('status', ['lunas', 'success'])
              ->orWhere('is_paid', true)
              ->orWhere('is_paid', 1);
        })->sum('total_harga') ?? 0;
        $totalStock = Produk::sum('produk_stok') ?? 0;

        // Get recent products (last 8)
        $recentProducts = Produk::latest('created_at')
            ->take(8)
            ->get();

        // Get recent transactions (last 8)
        $recentTransactions = Transaksi::latest('tanggal_transaksi')
            ->take(8)
            ->get();

        return view('admin.dashboard', [
            'totalProducts' => $totalProducts,
            'totalTransactions' => $totalTransactions,
            'totalRevenue' => $totalRevenue,
            'totalStock' => $totalStock,
            'recentProducts' => $recentProducts,
            'recentTransactions' => $recentTransactions,
        ]);
    }
}