<?php

namespace App\Http\Controllers\Kasir;
use App\Http\Controllers\Controller;

use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\Merchandise;
use App\Models\RoleUsers;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

use Imagick;

class TransaksiController extends Controller
{
    public function submit(Request $request)
    {
        $selectedProdukId = $request->input('produk');
        $selectedMerchandiseId = $request->input('merchandise');

        // Get complete data from database
        $selectedProduk = Produk::findOrFail($selectedProdukId);
        $selectedMerchandise = Merchandise::findOrFail($selectedMerchandiseId);

        // Store form data in session
        $request->session()->put('form_data', [
            'id_transaksi' => $request->id_transaksi,
            'nomor_telepon' => $request->nomor_telepon,
            'nama_pelanggan' => $request->nama_pelanggan,
            'aktivasi_tanggal' => $request->aktivasi_tanggal,
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'icon' => public_path('admin_asset/img/photos/icon_telkomsel.png'),
            'logo' => public_path('admin_asset/img/photos/logo_telkomsel.png'),
            'produk_nama' => $selectedProduk->produk_nama,
            'produk_harga' => $selectedProduk->produk_harga,
            'produk_harga_akhir' => $selectedProduk->produk_harga_akhir,
            'merch_nama' => $selectedMerchandise->merch_nama,
            'metode_pembayaran' => $request->metode_pembayaran,
            'nama_sales' => $request->nama_sales,
            'nomor_injeksi' => $request->nomor_injeksi,
            'telepon_pelanggan' => $request->telepon_pelanggan,
            'addon_perdana' => $request->has('addon_perdana') ? 1 : 0,
        ]);

        try {
            if ($selectedProduk->produk_stok <= 0) {
                throw new \Exception('Stok produk habis');
            }
            if ($selectedMerchandise->merch_stok <= 0) {
                throw new \Exception('Stok merchandise habis');
            }
            \DB::beginTransaction();

            // Update Stok Produk
            $selectedProduk->produk_stok -= 1;
            $selectedProduk->save();

            // Record Stock History for Product Sale
            \App\Models\StockHistory::create([
                'product_id' => $selectedProduk->id,
                'change_amount' => 1,
                'previous_stock' => $selectedProduk->produk_stok + 1,
                'current_stock' => $selectedProduk->produk_stok,
                'action' => 'Penjualan (Sales)',
            ]);

            // Update Stok Merchandise jika ada
            if ($request->merchandise) {
                $merch = \App\Models\Merchandise::find($request->merchandise);
                if ($merch) {
                    $oldMerchStock = $merch->merch_stok;
                    $merch->merch_stok -= 1;
                    $merch->save();

                    // Record Stock History for Merchandise Sale
                    \App\Models\StockHistory::create([
                        'merchandise_id' => $merch->id,
                        'change_amount' => 1,
                        'previous_stock' => $oldMerchStock,
                        'current_stock' => $merch->merch_stok,
                        'action' => 'Penjualan (Sales)',
                    ]);
                }
            }

            $selectedProduk->increment('produk_terjual', 1);
            $selectedMerchandise->increment('merch_terambil', 1);
            $history = json_decode($selectedProduk->produk_terjual_history ?? '[]', true);
            $history[] = [
                'tanggal' => Carbon::parse($request->tanggal_transaksi)->toDateTimeString(),
                'jumlah' => 1,
                'produk_nama' => $selectedProduk->produk_nama
            ];
            $selectedProduk->update([
                'produk_terjual_history' => json_encode($history)
            ]);
            $selectedProduk->refresh();
            $merchHistory = json_decode($selectedMerchandise->merch_terambil_history ?? '[]', true);
            $merchHistory[] = [
                'tanggal' => Carbon::parse($request->tanggal_transaksi)->toDateTimeString(),
                'jumlah' => 1,
                'merch_nama' => $selectedMerchandise->merch_nama
            ];
            $selectedMerchandise->update([
                'merch_terambil_history' => json_encode($merchHistory)
            ]);
            Transaksi::create([
                'id_transaksi' => $request->id_transaksi,
                'nomor_telepon' => $request->nomor_telepon,
                'nama_pelanggan' => $request->nama_pelanggan,
                'aktivasi_tanggal' => $request->aktivasi_tanggal,
                'telepon_pelanggan' => $request->telepon_pelanggan,
                'nama_sales' => $request->nama_sales,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'jenis_paket' => $selectedProduk->id,
                'produk_id' => $selectedProduk->id,
                'total_harga' => $selectedProduk->produk_harga_akhir,
                'merchandise' => $selectedMerchandise->merch_nama,
                'metode_pembayaran' => $request->metode_pembayaran ?? 'Tunai',
                'nomor_injeksi' => $request->nomor_injeksi,
                'is_paid' => true,
                'addon_perdana' => $request->has('addon_perdana') ? 1 : 0,
            ]);
            \DB::commit();
            return redirect()->route('sales.transaksi')->with('success', 'Transaksi berhasil disimpan!');
        } catch (\Exception $e) {
            \DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function index(Request $request)
    {
        // Determine user role
        $role = $request->user()->role; // Adjust if your role comes from a relationship
        $isKasir = $role === 'kasir';
        $iskasir = $role === 'kasir';
    
        $query = Transaksi::withTrashed()
            ->with([
                'produk' => fn($q) => $q->withTrashed(),
                'kasir'
            ])
             ->where('is_paid', true);
    
        // Apply role-based filter
        if ($isKasir) {
            $query->where('id_kasir', $request->user()->id);
        } elseif ($request->filled('id_kasir') && $iskasir) {
            $query->where('id_kasir', $request->id_kasir);
        }
    
        // === Apply filters if present ===
        if ($request->filled('id_kasir')) {
            $query->where('id_kasir', $request->id_kasir);
        }
    
        if ($request->filled('metode_pembayaran')) {
            $query->where('metode_pembayaran', $request->metode_pembayaran);
        }
    
        if ($request->filled('tanggal_transaksi')) {
            $query->whereDate('tanggal_transaksi', $request->tanggal_transaksi);
        }
    
        $transaksi = $query->get();

        // === Calculate totals ===
        $totalPenjualan = 0;
        $totalInsentif = 0;
    
        foreach ($transaksi as $item) {
            $sales = \App\Models\RoleUsers::where('name', $item->nama_sales)->first();
            $item->sales_bertugas = $sales?->bertugas;
            $item->sales_tempat = $sales?->tempat_tugas;
    
            if ($item->produk) {
                $totalPenjualan += $item->produk->produk_harga_akhir;
                $totalInsentif += $item->produk->produk_insentif;
            }
        }

        $methods = ['Mandiri', 'BNI', 'Tunai', 'BCA'];
        $paymentSums = [];
        
        // Handle listed methods
        foreach ($methods as $method) {
            $sumQuery = Transaksi::withTrashed()
                ->where('metode_pembayaran', $method)
                ->where('is_paid', true)
                ->with(['produk' => fn($q) => $q->withTrashed()]);
        
            if ($isKasir) {
                $sumQuery->where('id_kasir', $request->user()->id);
            } elseif ($request->filled('id_kasir') && $iskasir) {
                $sumQuery->where('id_kasir', $request->id_kasir);
            }
            
            if ($request->filled('tanggal_transaksi')) {
                $sumQuery->whereDate('tanggal_transaksi', $request->tanggal_transaksi);
            }
        
            $paymentSums[$method] = $sumQuery
                ->get()
                ->sum(fn($t) => optional($t->produk)->produk_harga_akhir ?? 0);
        }
        
        // Handle 'Others' (not in predefined methods or null)
        $othersQuery = Transaksi::withTrashed()
            ->where(function ($query) use ($methods) {
                $query->whereNotIn('metode_pembayaran', $methods)
                      ->orWhereNull('metode_pembayaran');
            })
            ->where('is_paid', true)
            ->with(['produk' => fn($q) => $q->withTrashed()]);
        
        if ($isKasir) {
            $othersQuery->where('id_kasir', $request->user()->id);
        } elseif ($request->filled('id_kasir') && $iskasir) {
            $othersQuery->where('id_kasir', $request->id_kasir);
        }
        
        if ($request->filled('tanggal_transaksi')) {
            $othersQuery->whereDate('tanggal_transaksi', $request->tanggal_transaksi);
        }   
        
        $paymentSums['Others'] = $othersQuery
            ->get()
            ->sum(fn($t) => optional($t->produk)->produk_harga_akhir ?? 0);

        return view('supvis.RiwayatTransaksi', compact('transaksi', 'totalPenjualan', 'totalInsentif', 'paymentSums'));
    }

    public function create()
    {
        $produks = Produk::with('merchandises')->get();
        return view('sales.transaksi', compact('produks'));
    }
    public function kwitansi(Request $request, $action = 'stream')
    {
        $formData = $request->session()->get('form_data', []);
        $pdf = Pdf::loadView('supvis.kwitansi', ['formData' => $formData])->setPaper('A6', 'portrait'); // Set A6 paper size in portrait orientation;

        // Simpan output PDF (ke memory)
        $pdfContent = $pdf->output();

        // Convert PDF ke gambar pakai Imagick (halaman pertama)
        $imagick = new Imagick();
        $imagick->setResolution(300, 300);
        $imagick->readImageBlob($pdfContent);
        $imagick->setImageFormat('png');

        // Simpan gambar ke storage publik
        $imagePath = "kwitansi/{$formData['id_transaksi']}.jpg";
        Storage::disk('public')->put($imagePath, $imagick);

        // Buat link publik ke gambar
        $imageUrl = asset("storage/$imagePath");

        // Kirim ke WhatsApp via redirect link
        $telepon = preg_replace('/[^0-9]/', '', $formData['telepon_pelanggan'] ?? '081234567890');
        if (substr($telepon, 0, 1) === '0') {
            $telepon = '62' . substr($telepon, 1);
        }
        $noWa = $telepon;
        $pesan = urlencode("Berikut kwitansi Anda:\n$imageUrl");
        $waLink = "https://wa.me/{$noWa}?text={$pesan}";

        // Hapus session agar aman
        $request->session()->forget('form_data');

        // Kirim PDF ke user (stream/download), lalu redirect ke WA
        if ($action === 'download') {
            return response($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "attachment; filename=\"{$formData['id_transaksi']}.pdf\""
            ])->header('Refresh', "0;url=$waLink");
        } else {
            return response($pdfContent, 200, [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => "inline; filename=\"{$formData['id_transaksi']}.pdf\""
            ])->header('Refresh', "0;url=$waLink");
        }
    }

    public function print($id, $action = 'stream')
    {
        $transaksi = Transaksi::withTrashed()->findOrFail($id);

        $selectedProduk = Produk::withTrashed()->findOrFail($transaksi->jenis_paket);
        $selectedMerchandise = Merchandise::withTrashed()
            ->where('merch_nama', $transaksi->merchandise)
            ->firstOrFail();

        // Simpan ke session form_data
        $formData = [
            'icon' => request()->ajax() ? asset('admin_asset/img/photos/icon_telkomsel.png') : public_path('admin_asset/img/photos/icon_telkomsel.png'),
            'logo' => request()->ajax() ? asset('admin_asset/img/photos/logo_telkomsel.png') : public_path('admin_asset/img/photos/logo_telkomsel.png'),
            'id_transaksi' => $transaksi->id_transaksi,
            'produk_nama' => $selectedProduk->produk_nama,
            'produk_harga' => $selectedProduk->produk_harga,
            'produk_harga_akhir' => $selectedProduk->produk_harga_akhir,
            'merch_nama' => $selectedMerchandise->merch_nama,
            'nama_pelanggan' => $transaksi->nama_pelanggan,
            'nama_sales' => $transaksi->nama_sales,
            'tanggal_transaksi' => $transaksi->tanggal_transaksi,
            'telepon_pelanggan' => $transaksi->telepon_pelanggan,
            'nomor_telepon' => $transaksi->nomor_telepon,
            'metode_pembayaran' => $transaksi->metode_pembayaran,
            'nomor_injeksi' => $transaksi->nomor_injeksi,
            'aktivasi_tanggal' => $transaksi->aktivasi_tanggal,
            'addon_perdana' => $transaksi->addon_perdana,
        ];

        if (request()->ajax()) {
            return view('pelanggan.nota-preview', ['formData' => $formData]);
        }

        if (request()->query('action') === 'print-html') {
            $formData['icon'] = asset('admin_asset/img/photos/icon_telkomsel.png');
            $formData['logo'] = asset('admin_asset/img/photos/logo_telkomsel.png');
            $view = view('supvis.kwitansi', ['formData' => $formData])->render();
            // Fix untuk Android: Jangan gunakan window.close() pada onafterprint karena akan membatalkan dialog print
            $view .= '<script>window.onload = function() { setTimeout(function() { window.print(); }, 500); }</script>';
            return response($view);
        }

        $pdf = Pdf::loadView('supvis.kwitansi', ['formData' => $formData])->setPaper('A6', 'portrait'); // Set A6 paper size in portrait orientation;

        // Simpan output PDF (ke memory)
        $pdfContent = $pdf->output();

        // Stream or download PDF without saving
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => $action === 'download'
                ? "attachment; filename=\"{$formData['id_transaksi']}.pdf\""
                : "inline; filename=\"{$formData['id_transaksi']}.pdf\""
        ];

        return response($pdfContent, 200, $headers);
    }

    public function dashboard(Request $request)
    {
        if ($request->user() && $request->user()->role == 'sales') {
            $nama_sales = $request->user()->name;

            // Ambil transaksi yang BELUM disetor sesuai nama sales yang login
            $transaksi = Transaksi::withTrashed()
                ->with([
                    'produk' => function ($query) {
                        $query->withTrashed(); // Memastikan produk yang terhapus tetap dimuat
                    }
                ])
                ->where('is_setor', false)
                ->where('nama_sales', $nama_sales) // Filter langsung dari query
                ->orderBy('tanggal_transaksi', 'desc')
                ->get();

            // Kelompokkan transaksi berdasarkan tanggal transaksi
            $groupedTransaksi = $transaksi->groupBy(function ($item) {
                return Carbon::parse($item->tanggal_transaksi)->format('Y-m-d');
            });

            // Hitung total penjualan dan insentif per tanggal
            $totalsPerDate = $groupedTransaksi->map(function ($items) {
                return [
                    'totalPenjualan' => $items->sum(fn($item) => $item->produk ? $item->produk->produk_harga_akhir : 0),
                    'totalInsentif' => $items->sum(fn($item) => $item->produk ? $item->produk->produk_insentif : 0),
                ];
            });

            // Total keseluruhan
            $totalPenjualan = $totalsPerDate->sum('totalPenjualan');
            $totalInsentif = $totalsPerDate->sum('totalInsentif');

            // Cek apakah semua transaksi dalam satu tanggal adalah voided (terhapus)
            $allVoided = $groupedTransaksi->map(fn($items) => $items->every->trashed());

            // Ambil transaksi yang sudah disetor untuk nama sales ini
            $setoranRaw = Transaksi::where('is_setor', true)
                ->where('nama_sales', $nama_sales)
                ->with('produk')
                ->orderBy('tanggal_transaksi', 'desc')
                ->get();

            // Kelompokkan setoran berdasarkan tanggal
            $groupedSetoran = $setoranRaw->groupBy(function ($item) {
                return Carbon::parse($item->tanggal_transaksi)->format('Y-m-d');
            });

            // Hitung total per tanggal untuk setoran
            $setoranTotals = $groupedSetoran->map(function ($items) {
                return [
                    'totalPenjualan' => $items->sum(fn($item) => $item->produk ? $item->produk->produk_harga_akhir : 0),
                    'totalInsentif' => $items->sum(fn($item) => $item->produk ? $item->produk->produk_insentif : 0),
                ];
            });

            return view('sales/rekap', compact(
                'groupedTransaksi', 
                'totalsPerDate', 
                'totalPenjualan', 
                'totalInsentif', 
                'allVoided', 
                'groupedSetoran',
                'setoranTotals'
            ));
        }

        return redirect()->route('login')->withErrors(['role' => 'Anda harus login sebagai sales untuk mengakses halaman ini.']);
    }

    public function toggleVoid(Request $request, $id)
    {
        $transaksi = Transaksi::withTrashed()->findOrFail($id);

        if ($request->is_void) {
            $transaksi->delete(); // Soft delete
        } else {
            $transaksi->restore(); // Restore from soft delete
        }

        return response()->json(['message' => 'Transaction status updated successfully']);
    }

    public function supvisvoid(Request $request)
    {
        $transaksi = Transaksi::onlyTrashed()
            ->with('produk')
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();
        $totalPenjualan = $transaksi->sum(function ($item) {
            return $item->produk ? $item->produk->produk_harga_akhir : 0;
        });
        $totalInsentif = $transaksi->sum(function ($item) {
            return $item->produk ? $item->produk->produk_insentif : 0;
        });
        $groupedTransaksi = $transaksi->groupBy(function ($item) {
            return Carbon::parse($item->tanggal_transaksi)->format('Y-m-d');
        });
        $totalsPerDate = $groupedTransaksi->map(function ($items) {
            $totalPenjualan = $items->sum(function ($item) {
                return $item->produk ? $item->produk->produk_harga_akhir : 0;
            });
            $totalInsentif = $items->sum(function ($item) {
                return $item->produk ? $item->produk->produk_insentif : 0;
            });

            return [
                'totalPenjualan' => $totalPenjualan,
                'totalInsentif' => $totalInsentif,
            ];
        });

        $totalPenjualan = $totalsPerDate->sum('totalPenjualan');
        $totalInsentif = $totalsPerDate->sum('totalInsentif');

        return view('admin.void.index', compact('groupedTransaksi', 'totalsPerDate', 'totalPenjualan', 'totalInsentif'));

    }

    public function supvisdestroy($id)
    {
        try {
            // Find the transaction
            $transaksi = Transaksi::withTrashed()->findOrFail($id);

            // Perform the hard delete
            $transaksi->forceDelete();

            return redirect()
                ->back()
                ->with('success', 'Transaksi berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $produks = Produk::all();
        $merchandises = Merchandise::all();
        $merchandises->each(function ($merchandise) {
            $merchandise->produk_ids = $merchandise->produks->pluck('id')->toArray();
        });
        return view('supvis.edittransaksi', compact(
            'transaksi',
            'produks',
            'merchandises'
        ));
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        // Validasi input
        $validator = Validator::make($request->all(), [
            'nomor_telepon' => 'required|string',
            'nama_pelanggan' => 'required|string',
            'aktivasi_tanggal' => 'required|date',
            'tanggal_transaksi' => 'required|date',
            'produk' => 'required|exists:produks,id',
            'merchandise' => 'required|exists:merchandises,id',
            'metode_pembayaran' => 'required|string',
            'nama_sales' => 'required|string',
            'nomor_injeksi' => 'nullable|string',
            'telepon_pelanggan' => 'required|string',
            'addon_perdana' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            $request->session()->put('form_data', $request->all());
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $selectedProduk = Produk::findOrFail($request->produk);
            $selectedMerchandise = Merchandise::findOrFail($request->merchandise);

            // Simpan form_data ke session
            $formData = $request->all();
            $formData['icon'] = public_path('admin_asset/img/photos/icon_telkomsel.png');
            $formData['logo'] = public_path('admin_asset/img/photos/logo_telkomsel.png');
            $formData['id_transaksi'] = $transaksi->id_transaksi;
            $formData['produk_nama'] = $selectedProduk->produk_nama;
            $formData['produk_harga'] = $selectedProduk->produk_harga;
            $formData['produk_harga_akhir'] = $selectedProduk->produk_harga_akhir;
            $formData['merch_nama'] = $selectedMerchandise->merch_nama;
            $formData['nama_pelanggan'] = $transaksi->nama_pelanggan;
            $formData['nama_sales'] = $transaksi->nama_sales;
            $formData['tanggal_transaksi'] = $transaksi->tanggal_transaksi;
            $formData['telepon_pelanggan'] = $transaksi->telepon_pelanggan;
            $formData['nomor_telepon'] = $transaksi->nomor_telepon;
            $formData['nomor_injeksi'] = $transaksi->nomor_injeksi;
            $request->session()->put('form_data', $formData);

            DB::beginTransaction();

            // Update stok produk jika berubah
            if ($transaksi->jenis_paket != $selectedProduk->id) {
                Produk::where('id', $transaksi->jenis_paket)->increment('produk_stok', 1);
                Produk::where('id', $transaksi->jenis_paket)->decrement('produk_terjual', 1);

                if ($selectedProduk->produk_stok <= 0) {
                    throw new \Exception('Stok produk habis');
                }

                $selectedProduk->decrement('produk_stok', 1);
                $selectedProduk->increment('produk_terjual', 1);
            }

            // Update stok merchandise jika berubah
            if ($transaksi->merchandise != $selectedMerchandise->merch_nama) {
                Merchandise::where('merch_nama', $transaksi->merchandise)->increment('merch_stok', 1);
                Merchandise::where('merch_nama', $transaksi->merchandise)->decrement('merch_terambil', 1);

                if ($selectedMerchandise->merch_stok <= 0) {
                    throw new \Exception('Stok merchandise habis');
                }

                $selectedMerchandise->decrement('merch_stok', 1);
                $selectedMerchandise->increment('merch_terambil', 1);
            }

            // Update data transaksi
            $transaksi->update([
                'nomor_telepon' => $request->nomor_telepon,
                'nama_pelanggan' => $request->nama_pelanggan,
                'aktivasi_tanggal' => $request->aktivasi_tanggal,
                'tanggal_transaksi' => $request->tanggal_transaksi,
                'jenis_paket' => $selectedProduk->id,
                'merchandise' => $selectedMerchandise->merch_nama,
                'metode_pembayaran' => $request->metode_pembayaran,
                'nama_sales' => $request->nama_sales,
                'nomor_injeksi' => $request->nomor_injeksi,
                'telepon_pelanggan' => $request->telepon_pelanggan,
                'addon_perdana' => $request->has('addon_perdana') ? 1 : 0,
            ]);
            $kasir = RoleUsers::findOrFail($transaksi->id_kasir);
            $transaksi->bertugas = $kasir->bertugas;
            $transaksi->tempat_tugas = $kasir->tempat_tugas;
            $transaksi->save();

            DB::commit();
            return redirect()->route('kasir.home')->with('success', 'Transaksi berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function approveTransaksi()
    {
        $userId = auth()->user()->id;

        $transaksi = Transaksi::withTrashed()
            ->with([
                'produk' => function ($query) {
                    $query->withTrashed(); // Include trashed products
                }
            ])
            ->get();

        $totalPenjualan = 0;
        // ini ambil based on id if ($item->id_kasir == $userId && $item->produk)
        foreach ($transaksi as $item) {
            if ($item->id_kasir == $userId && $item->produk) {
                $totalPenjualan += $item->produk->produk_harga_akhir;
            }
            $sales = \App\Models\RoleUsers::where('name', $item->nama_sales)->first();
            $item->sales_bertugas = $sales?->bertugas;
            $item->sales_tempat = $sales?->tempat_tugas;
        }

        return view('supvis.approvetransaksi', compact('transaksi', 'totalPenjualan'));
    }

    public function bayar(Request $request, $id)
    {
        $transaksi = Transaksi::findOrFail($id);

        // Validasi input metode pembayaran
        $validator = Validator::make($request->all(), [
            'metode_pembayaran' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Ambil produk & merchandise dari data transaksi lama
            $selectedProduk = Produk::findOrFail($transaksi->jenis_paket);
            $selectedMerchandise = Merchandise::where('merch_nama', $transaksi->merchandise)->firstOrFail();

            // Simpan ke session form_data
            $formData = [
                'icon' => public_path('admin_asset/img/photos/icon_telkomsel.png'),
                'logo' => public_path('admin_asset/img/photos/logo_telkomsel.png'),
                'id_transaksi' => $transaksi->id_transaksi,
                'produk_nama' => $selectedProduk->produk_nama,
                'produk_harga' => $selectedProduk->produk_harga,
                'produk_harga_akhir' => $selectedProduk->produk_harga_akhir,
                'merch_nama' => $selectedMerchandise->merch_nama,
                'nama_pelanggan' => $transaksi->nama_pelanggan,
                'nama_sales' => $transaksi->nama_sales,
                'tanggal_transaksi' => $transaksi->tanggal_transaksi,
                'telepon_pelanggan' => $transaksi->telepon_pelanggan,
                'nomor_telepon' => $transaksi->nomor_telepon,
                'metode_pembayaran' => $transaksi->metode_pembayaran,
                'nomor_injeksi' => $request->nomor_injeksi,
                'aktivasi_tanggal' => $transaksi->aktivasi_tanggal,
            ];

            $request->session()->put('form_data', $formData);

            // Update metode pembayaran saja
            $transaksi->update([
                'metode_pembayaran' => $request->metode_pembayaran,
                'is_paid' => 1,
                'nomor_injeksi' => $request->nomor_injeksi,
                'id_kasir' => Auth::user()->id,
            ]);
            
            $pdf = Pdf::loadView('supvis.kwitansi', ['formData' => $formData])->setPaper('A6', 'portrait'); // Set A6 paper size in portrait orientation;

            // Simpan output PDF (ke memory)
            $pdfContent = $pdf->output();
    
            // Save PDF file to storage
            $storagePath = storage_path('app/public/kwitansi');
            $filePath = $storagePath . '/' . $formData['id_transaksi'] . '.pdf';
            file_put_contents($filePath, $pdfContent);
            
            return redirect()->route('transaksi.approve')
            ->with('success', 'Transaksi berhasil dibayar');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function editBayar($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $produks = Produk::all();
        $merchandises = Merchandise::all();

        return view('supvis.bayartransaksi', compact('transaksi', 'produks', 'merchandises'));
    }

    public function whatsapp($id)
    {
        $transaksi = Transaksi::withTrashed()->findOrFail($id);

        $selectedProduk = Produk::withTrashed()->findOrFail($transaksi->jenis_paket);
        $selectedMerchandise = Merchandise::withTrashed()
            ->where('merch_nama', $transaksi->merchandise)
            ->firstOrFail();

        // Simpan ke session form_data
        $formData = [
            'icon' => public_path('admin_asset/img/photos/icon_telkomsel.png'),
            'logo' => public_path('admin_asset/img/photos/logo_telkomsel.png'),
            'id_transaksi' => $transaksi->id_transaksi,
            'produk_nama' => $selectedProduk->produk_nama,
            'produk_harga' => $selectedProduk->produk_harga,
            'produk_harga_akhir' => $selectedProduk->produk_harga_akhir,
            'merch_nama' => $selectedMerchandise->merch_nama,
            'nama_pelanggan' => $transaksi->nama_pelanggan,
            'nama_sales' => $transaksi->nama_sales,
            'tanggal_transaksi' => $transaksi->tanggal_transaksi,
            'telepon_pelanggan' => $transaksi->telepon_pelanggan,
            'nomor_telepon' => $transaksi->nomor_telepon,
            'metode_pembayaran' => $transaksi->metode_pembayaran,
            'nomor_injeksi' => $transaksi->nomor_injeksi,
            'aktivasi_tanggal' => $transaksi->aktivasi_tanggal,
        ];
        $pdf = Pdf::loadView('supvis.kwitansi', ['formData' => $formData])->setPaper('A6', 'portrait'); // Set A6 paper size in portrait orientation;
        // Simpan output PDF (ke memory)
        $pdfContent = $pdf->output();

        // Convert PDF ke gambar pakai Imagick (halaman pertama)
        $imagick = new Imagick();
        $imagick->setResolution(300, 300);
        $imagick->readImageBlob($pdfContent);
        $imagick->setImageFormat('png');

        // Simpan gambar ke storage publik
        $imagePath = "kwitansi/{$formData['id_transaksi']}.jpg";
        Storage::disk('public')->put($imagePath, $imagick);

        // Buat link publik ke gambar
        $imageUrl = asset("storage/$imagePath");

        // Kirim ke WhatsApp via redirect link
        $telepon = preg_replace('/[^0-9]/', '', $formData['telepon_pelanggan'] ?? '081234567890');
        if (substr($telepon, 0, 1) === '0') {
            $telepon = '62' . substr($telepon, 1);
        }
        $noWa = $telepon;
        $pesan = urlencode("Berikut kwitansi Anda:\n$imageUrl");
        $waLink = "https://wa.me/{$noWa}?text={$pesan}";

        return response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => "inline; filename=\"{$formData['id_transaksi']}.pdf\""
        ])->header('Refresh', "0;url=$waLink");
    }

    public function unlunas($id)
    {
        $transaksi = Transaksi::findOrFail($id);

        $transaksi->update([
            'is_paid' => 0,
            'id_kasir' => null,
        ]);

        return redirect()->route('transaksi.approve');

    }
    
    public function forcedelete($id){
        $transaksi = Transaksi::withTrashed()->findOrFail($id);
        
        $selectedProduk = Produk::withTrashed()->findOrFail($transaksi->jenis_paket);
        if ($selectedProduk) {
            $selectedProduk->increment('produk_stok', 1);
            $selectedProduk->decrement('produk_terjual', 1);
        }
        
        // kalo di delete, stok masih error
        $selectedMerchandise = Merchandise::withTrashed()
            ->where('merch_nama', $transaksi->merchandise)
            ->firstOrFail();        
        if ($selectedMerchandise) {
            $selectedMerchandise->increment('merch_stok', 1);
            $selectedMerchandise->decrement('merch_terambil', 1);
        }
        
        $transaksi->forceDelete();

        return response()->json(['success' => true]);
    }

    public function refresh(Request $request)
    {
        $transaksi = Transaksi::withTrashed()
            ->with([
                'produk' => function ($query) {
                    $query->withTrashed(); // Include trashed products
                },
                'kasir',
                'sales',
            ])
            ->orderBy('id_transaksi', 'asc')
            ->get();

        if($request->ajax()){
            return response()->json(array('transaksi'=>$transaksi));
            }
        return route('transaksi.approve', compact('transaksi'));        
    }

    public function setor(Request $request)
    {
        $date = $request->date;
        $nama_sales = auth()->user()->name;

        Transaksi::whereDate('tanggal_transaksi', $date)
            ->where('nama_sales', $nama_sales)
            ->where('is_setor', false)
            ->update(['is_setor' => true]);

        return response()->json(['success' => true]);       
    }
    
    public function monitorSetoran(Request $request)
    {
        $transaksi = Transaksi::with(['produk', 'sales'])
            ->whereHas('sales', function($query) {
                $query->where('role', 'sales');
            })
            ->orderBy('tanggal_transaksi', 'desc')
            ->get();

        $groupedData = $transaksi->groupBy(function ($item) {
            return Carbon::parse($item->tanggal_transaksi)->format('Y-m-d');
        })->map(function ($dateItems) {
            return $dateItems->groupBy('nama_sales')->map(function ($salesItems) {
                return [
                    'total_sales' => $salesItems->sum(fn($i) => $i->produk ? $i->produk->produk_harga_akhir : 0),
                    'total_insentif' => $salesItems->sum(fn($i) => $i->produk ? $i->produk->produk_insentif : 0),
                    'total_setor' => $salesItems->where('is_setor', true)->sum(fn($i) => $i->produk ? $i->produk->produk_harga_akhir : 0),
                    'total_pending' => $salesItems->where('is_setor', false)->sum(fn($i) => $i->produk ? $i->produk->produk_harga_akhir : 0),
                    'count' => $salesItems->count(),
                    'is_all_setor' => $salesItems->every('is_setor', true)
                ];
            });
        });

        return view('admin.setoran.index', compact('groupedData'));
    }

}

