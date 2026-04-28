<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Tampilkan daftar transaksi dengan filter tanggal.
     */
    public function index(Request $request)
    {
        $query = Transaksi::with('produk')->latest();

        if ($request->filled('date')) {
            $query->where(function ($q) use ($request) {
                $q->whereDate('tanggal_transaksi', $request->date)
                  ->orWhereDate('created_at', $request->date);
            });
        }

        $transaksi = $query->paginate(20);

        return view("admin.transaksi.index", compact("transaksi"));
    }

    /**
     * Export rekap transaksi ke CSV (Excel-compatible).
     */
    public function exportExcel(Request $request)
    {
        $query = Transaksi::with('produk')->latest();

        if ($request->filled('date')) {
            $query->where(function ($q) use ($request) {
                $q->whereDate('tanggal_transaksi', $request->date)
                  ->orWhereDate('created_at', $request->date);
            });
        }

        $transaksis = $query->get();

        $filename = 'rekap-transaksi';
        if ($request->filled('date')) {
            $filename .= '-' . $request->date;
        }
        $filename .= '.csv';

        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma'              => 'no-cache',
            'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
            'Expires'             => '0',
        ];

        $callback = function () use ($transaksis) {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'No', 'ID Transaksi', 'Nama Pelanggan', 'No. Roaming', 'Nama Produk', 
                'Total Harga (Rp)', 'Tanggal Transaksi', 'Status', 'Metode Pembayaran'
            ]);

            foreach ($transaksis as $i => $t) {
                if ($t->status === 'lunas' || $t->status === 'success' || $t->is_paid) {
                    $status = 'Lunas';
                } elseif ($t->status === 'pending' || !$t->status) {
                    $status = 'Pending';
                } else {
                    $status = ucfirst($t->status);
                }

                fputcsv($handle, [
                    $i + 1,
                    $t->id_transaksi ?? $t->id,
                    $t->nama_pelanggan ?? '-',
                    $t->nomor_roaming  ?? '-',
                    $t->produk?->produk_nama ?? '-',
                    number_format($t->total_harga ?? 0, 0, ',', '.'),
                    $t->tanggal_transaksi ? Carbon::parse($t->tanggal_transaksi)->format('d/m/Y H:i') : '-',
                    $status,
                    $t->metode_pembayaran ?? '-',
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Tampilkan detail transaksi (jika diperlukan via route show).
     */
    public function show($id)
    {
        $transaksi = Transaksi::with('produk')->findOrFail($id);
        return view('admin.transaksi.show', compact('transaksi'));
    }

    /**
     * Update nomor roaming secara manual via AJAX.
     */
    public function updateRoaming(Request $request, $id)
    {
        $request->validate([
            'nomor_roaming' => 'nullable|string|max:20|regex:/^[0-9+\- ]+$/',
        ], [
            'nomor_roaming.regex' => 'Format nomor roaming tidak valid. Gunakan angka, +, -, atau spasi.',
            'nomor_roaming.max'   => 'Nomor roaming maksimal 20 karakter.',
        ]);

        try {
            $transaksi = Transaksi::findOrFail($id);
            $transaksi->nomor_roaming = $request->nomor_roaming;
            $transaksi->save();

            return response()->json([
                'success' => true,
                'message' => 'Nomor roaming berhasil diperbarui.',
                'nomor_roaming' => $transaksi->nomor_roaming
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui nomor roaming: ' . $e->getMessage()
            ], 500);
        }
    }
}
