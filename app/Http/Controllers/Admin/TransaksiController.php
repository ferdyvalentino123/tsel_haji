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

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pelanggan', 'LIKE', "%{$search}%")
                  ->orWhere('nama_sales', 'LIKE', "%{$search}%")
                  ->orWhere('id_transaksi', 'LIKE', "%{$search}%");
            });
        }

        // Clone query for totals calculation before pagination
        $totalTransaksi = (clone $query)->count();
        $totalPendapatan = (clone $query)->where(function($q) {
            $q->where('is_paid', 1)->orWhereIn('status', ['lunas', 'success']);
        })->sum('total_harga');
        $totalDibayar = (clone $query)->where(function($q) {
            $q->where('is_paid', 1)->orWhereIn('status', ['lunas', 'success']);
        })->count();

        $transaksi = $query->get();

        return view("admin.transaksi.index", compact("transaksi", "totalTransaksi", "totalPendapatan", "totalDibayar"));
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

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_pelanggan', 'LIKE', "%{$search}%")
                  ->orWhere('nama_sales', 'LIKE', "%{$search}%")
                  ->orWhere('id_transaksi', 'LIKE', "%{$search}%");
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
            // Menambahkan BOM untuk UTF-8 dan instruksi separator agar Excel otomatis membagi kolom
            fwrite($handle, "\xEF\xBB\xBF");
            fwrite($handle, "sep=,\n");

            fputcsv($handle, [
                'No', 
                'ID Transaksi', 
                'Nama Pelanggan', 
                'Nomor Telepon', 
                'Nama Produk', 
                'Total Bayar (Rp)', 
                'Tanggal Transaksi', 
                'Status Pembayaran', 
                'Metode Pembayaran'
            ]);

            foreach ($transaksis as $i => $t) {
                // Status mapping yang lebih rapi
                if ($t->status === 'lunas' || $t->status === 'success' || $t->is_paid) {
                    $status = 'LUNAS';
                } elseif ($t->status === 'pending' || !$t->status) {
                    $status = 'PENDING';
                } elseif ($t->status === 'batal') {
                    $status = 'DIBATALKAN';
                } else {
                    $status = strtoupper($t->status);
                }

                // Ambil nomor telepon dari transaksi atau profil
                $nomorTelepon = $t->telepon_pelanggan ?: ($t->pelanggan->phone ?? '-');

                fputcsv($handle, [
                    $i + 1,
                    $t->id_transaksi ?? $t->id,
                    $t->nama_pelanggan ?? '-',
                    $nomorTelepon,
                    $t->produk?->produk_nama ?? '-',
                    $t->total_harga ?? 0, // Raw number lebih baik untuk perhitungan di Excel
                    $t->tanggal_transaksi ? Carbon::parse($t->tanggal_transaksi)->format('d/m/Y H:i') : '-',
                    $status,
                    strtoupper($t->metode_pembayaran ?? '-'),
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
    /**
     * Aktivasi paket oleh tim internal dengan mengunggah bukti injeksi.
     */
    public function aktivasi(Request $request, $id)
    {
        $request->validate([
            'bukti_injeksi' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        try {
            $transaksi = Transaksi::findOrFail($id);

            if ($request->hasFile('bukti_injeksi')) {
                $file = $request->file('bukti_injeksi');
                // Simpan di folder public/bukti_injeksi agar mudah diakses
                $path = $file->store('bukti_injeksi', 'public');
                
                $transaksi->bukti_injeksi = $path;
                $transaksi->is_activated = 1;
                $transaksi->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Paket berhasil diaktifkan dan bukti telah diunggah.'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'File bukti injeksi tidak ditemukan.'
            ], 400);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
