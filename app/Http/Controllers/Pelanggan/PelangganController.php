<?php

namespace App\Http\Controllers\Pelanggan;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;
use Barryvdh\DomPDF\Facade\Pdf;

class PelangganController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    public function index()
    {
        $produks = Produk::where('produk_stok', '>', 0)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('pelanggan.home', compact('produks'));
    }

    public function showProduk($id)
    {
        $produk = Produk::findOrFail($id);
        return view('pelanggan.detail-produk', compact('produk'));
    }

    public function beliProduk($id)
    {
        $produk = Produk::findOrFail($id);
        return view('pelanggan.beli-produk', compact('produk'));
    }

    public function processTransaksi(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'nomor_telepon' => 'required|regex:/^[0-9]{10,13}$/'
        ]);

        $produk = Produk::findOrFail($request->produk_id);
        
        if ($produk->produk_stok < 1) {
            return back()->with('error', 'Stok tidak mencukupi!');
        }

        DB::beginTransaction();
        try {
            $harga_setelah_diskon = $produk->produk_harga - ($produk->produk_harga * $produk->produk_diskon / 100);
            $total = $harga_setelah_diskon * 1;

            $id_transaksi = 'TRX-PLG-' . Auth::id() . '-' . time() . '-' . rand(1000, 9999);

            $transaksi = new Transaksi();
            $transaksi->id_transaksi = $id_transaksi;
            $transaksi->id_pelanggan = Auth::id();
            $transaksi->produk_id = $produk->id;
            $transaksi->jumlah = 1;
            $transaksi->total_harga = $total;
            $transaksi->status = 'pending';
            $transaksi->nama_pelanggan = Auth::user()->name;
            $transaksi->telepon_pelanggan = $request->nomor_telepon;
            $transaksi->nomor_roaming = $request->nomor_telepon; // Nomor yang akan di-roaming
            $transaksi->tanggal_transaksi = now();
            $transaksi->save();

            $produk->produk_stok -= 1;
            $produk->save();

            DB::commit();

            return redirect()->route('pelanggan.pembayaran', $transaksi->id)
                ->with('success', 'Transaksi berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function riwayatTransaksi()
    {
        $transaksis = Transaksi::where('id_pelanggan', Auth::id())
            ->whereIn('status', ['pending', 'lunas', 'success'])
            ->with('produk')
            ->orderByDesc('id')
            ->get();
        
        return view('pelanggan.riwayat-transaksi', compact('transaksis'));
    }

    public function profil()
    {
        $user = Auth::user();
        return view('pelanggan.profil', compact('user'));
    }

    public function updateProfil(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:role_users,email,' . Auth::id(),
            'tempat_tugas' => 'nullable|string|max:500',
        ], [
            'name.required' => 'Nama harus diisi',
            'phone.required' => 'Nomor telepon harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
        ]);

        try {
            $user = Auth::user();
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->tempat_tugas = $request->tempat_tugas;
            $user->save();

            return back()->with('success', 'Profil berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error update profil: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }

    public function pembayaran($id)
    {
        $transaksi = Transaksi::where('id', $id)
            ->where('id_pelanggan', Auth::id())
            ->with('produk')
            ->firstOrFail();
        
        if ($transaksi->status == 'lunas' || $transaksi->is_paid) {
            return redirect()->route('pelanggan.riwayat-transaksi')
                ->with('info', 'Transaksi ini sudah dibayar.');
        }

        try {
            // Cek apakah sudah ada snap token untuk transaksi ini
            if (!empty($transaksi->snap_token)) {
                $snapToken = $transaksi->snap_token;
            } else {
                $params = [
                    'transaction_details' => [
                        'order_id' => $transaksi->id_transaksi,
                        'gross_amount' => (int) $transaksi->total_harga,
                    ],
                    'customer_details' => [
                        'first_name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                        'phone' => Auth::user()->phone ?? '081234567890',
                    ],
                    'item_details' => [
                        [
                            'id' => $transaksi->produk_id,
                            'price' => (int) $transaksi->produk->produk_harga,
                            'quantity' => $transaksi->jumlah,
                            'name' => $transaksi->produk->produk_nama,
                        ]
                    ],
                    'callbacks' => [
                        'finish' => route('pelanggan.pembayaran.callback', $transaksi->id)
                    ]
                ];

                $snapToken = Snap::getSnapToken($params);
                $transaksi->snap_token = $snapToken;
                $transaksi->save();
            }
            
            return view('pelanggan.pembayaran', compact('transaksi', 'snapToken'));

        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal membuat pembayaran: ' . $e->getMessage());
        }
    }

    public function callbackPembayaran(Request $request, $id)
    {
        $transaksi = Transaksi::where('id', $id)
            ->where('id_pelanggan', Auth::id())
            ->firstOrFail();
        
        try {
            $status = \Midtrans\Transaction::status($transaksi->id_transaksi);
            
            if ($status->transaction_status == 'settlement' || $status->transaction_status == 'capture') {
                $transaksi->status = 'lunas';
                $transaksi->is_paid = true;
                $transaksi->metode_pembayaran = ($status->payment_type ?? 'QRIS');
                $transaksi->save();
                
                return redirect()->route('pelanggan.riwayat-transaksi')
                    ->with('success', 'Pembayaran berhasil! Terima kasih atas pembelian Anda.');
            } else {
                return redirect()->route('pelanggan.riwayat-transaksi')
                    ->with('warning', 'Pembayaran belum selesai. Status: ' . $status->transaction_status);
            }
            
        } catch (\Exception $e) {
            Log::error('Midtrans Callback Error: ' . $e->getMessage());
            return redirect()->route('pelanggan.riwayat-transaksi')
                ->with('error', 'Gagal verifikasi pembayaran.');
        }
    }

    public function notificationHandler(Request $request)
    {
        try {
            $notification = new Notification();
            
            $transactionStatus = $notification->transaction_status;
            $orderId = $notification->order_id;
            $fraudStatus = $notification->fraud_status ?? 'accept';

            Log::info('Midtrans Notification: ' . json_encode([
                'order_id' => $orderId,
                'status' => $transactionStatus,
                'fraud' => $fraudStatus
            ]));

            $transaksi = Transaksi::where('id_transaksi', $orderId)->first();

            if (!$transaksi) {
                return response()->json(['status' => 'error', 'message' => 'Transaction not found'], 404);
            }

            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $transaksi->status = 'lunas';
                    $transaksi->is_paid = true;
                }
            } else if ($transactionStatus == 'settlement') {
                $transaksi->status = 'lunas';
                $transaksi->is_paid = true;
            } else if ($transactionStatus == 'pending') {
                $transaksi->status = 'pending';
            } else if ($transactionStatus == 'deny' || $transactionStatus == 'expire' || $transactionStatus == 'cancel') {
                $transaksi->status = 'batal';
            }

            $transaksi->save();

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Midtrans Notification Error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function batalkanTransaksi($id)
    {
        try {
            DB::beginTransaction();

            $transaksi = Transaksi::where('id', $id)
                ->where('id_pelanggan', Auth::id())
                ->where('status', 'pending')
                ->firstOrFail();

            $produk = Produk::find($transaksi->produk_id);
            if ($produk) {
                $produk->produk_stok += $transaksi->jumlah;
                $produk->save();
            }

            $transaksi->status = 'batal';
            $transaksi->save();

            DB::commit();

            return redirect()->route('pelanggan.riwayat-transaksi')
                ->with('success', 'Transaksi berhasil dibatalkan. Stok produk telah dikembalikan.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error membatalkan transaksi: ' . $e->getMessage());
            
            return back()->with('error', 'Gagal membatalkan transaksi: ' . $e->getMessage());
        }
    }

    public function downloadNota($id)
    {
        $transaksi = Transaksi::where('id', $id)
            ->where('id_pelanggan', Auth::id())
            ->firstOrFail();

        $produk = $transaksi->produk;
        if (!$produk) {
            return back()->with('error', 'Produk tidak ditemukan.');
        }

        $formData = [
            'icon' => public_path('admin_asset/img/photos/icon_telkomsel.png'),
            'logo' => public_path('admin_asset/img/photos/logo_telkomsel.png'),
            'id_transaksi' => $transaksi->id_transaksi,
            'produk_nama' => $produk->produk_nama,
            'produk_harga' => $produk->produk_harga,
            'produk_harga_akhir' => $produk->produk_harga - ($produk->produk_harga * $produk->produk_diskon / 100),
            'merch_nama' => 'Paket Haji',
            'nama_pelanggan' => $transaksi->nama_pelanggan,
            'nama_sales' => 'Admin',
            'tanggal_transaksi' => $transaksi->tanggal_transaksi,
            'telepon_pelanggan' => $transaksi->telepon_pelanggan,
            'nomor_telepon' => $transaksi->telepon_pelanggan,
            'metode_pembayaran' => 'QRIS/Midtrans',
            'nomor_injeksi' => $transaksi->id_transaksi,
            'aktivasi_tanggal' => $transaksi->created_at->format('d/m/Y'),
        ];

        // Return HTML untuk AJAX request (modal)
        if (request()->ajax()) {
            return view('pelanggan.nota-preview', ['formData' => $formData]);
        }

        $pdf = Pdf::loadView('supvis.kwitansi', ['formData' => $formData])
            ->setPaper('A6', 'portrait');

        $filename = 'nota-' . $transaksi->id_transaksi . '.pdf';
        
        if (request()->has('preview')) {
            return $pdf->stream($filename);
        }

        return $pdf->download($filename);
    }
}








