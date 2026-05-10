<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Transaksi;

class HomeController extends Controller
{
    public function index()
    {
        $totalProducts = Produk::count();
        $totalTransactions = Transaksi::count();
        
        $totalRevenue = Transaksi::where(function($q) {
            $q->whereIn('status', ['lunas', 'success'])
              ->orWhere('is_paid', true)
              ->orWhere('is_paid', 1);
        })->sum('total_harga') ?? 0;
        $totalStock = Produk::sum('produk_stok') ?? 0;

        $recentProducts = Produk::latest('created_at')
            ->take(8)
            ->get();

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

    public function incentiveSummary()
    {
        $insentifData = Transaksi::with('produk')
            ->where(function($q) {
                $q->whereIn('status', ['lunas', 'success'])
                  ->orWhere('is_paid', true)
                  ->orWhere('is_paid', 1);
            })
            ->whereNotNull('nama_sales')
            ->where('nama_sales', '!=', '')
            ->get()
            ->groupBy('nama_sales')
            ->map(function($transactions) {
                $totalHarga = $transactions->sum('total_harga');
                $totalInsentif = $transactions->sum(function($t) {
                    return ($t->produk?->produk_insentif ?? 0) * ($t->jumlah ?? 1);
                });
                
                return [
                    'nama_sales' => $transactions->first()->nama_sales,
                    'total_transaksi' => $transactions->count(),
                    'total_penjualan' => $totalHarga,
                    'total_insentif' => $totalInsentif,
                ];
            })
            ->values()
            ->sortByDesc('total_insentif');

        return view('admin.insentif.index', [
            'insentifData' => $insentifData,
            'totalSeluruhInsentif' => $insentifData->sum('total_insentif'),
        ]);
    }
}
