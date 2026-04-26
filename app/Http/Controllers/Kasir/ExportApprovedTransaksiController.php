<?php
// App/Http/Controllers/ExportApprovedTransaksiController.php

namespace App\Http\Controllers\Kasir;
use App\Http\Controllers\Controller;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Transaksi; // Ganti dengan model yang sesuai
use Illuminate\Http\Request;

class ExportApprovedTransaksiController extends Controller
{
    public function exportPDF()
{
    // Ambil data transaksi yang statusnya approved
    $transactions = Transaksi::where('status', 'approved')
                             ->whereNull('deleted_at') // pastikan transaksi tidak dihapus
                             ->get();

    // Generate PDF dengan view yang benar
    $pdf = Pdf::loadView('pdf.approved_transaksi', compact('transactions'));

    // Mengunduh file PDF
    return $pdf->download('approved_transaksi.pdf');
}

}

