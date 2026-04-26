<?php
namespace App\Http\Controllers\Kasir;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\RoleUsers;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
class DashboardController extends Controller
{
    public function index()
    {
        // Get dashboard data for kasir
        $totalTransaksi = Transaksi::count();
        $totalSales = RoleUsers::where('role', 'sales')->count();
        
        return view('kasir.dashboard', [
            'totalTransaksi' => $totalTransaksi,
            'totalSales' => $totalSales,
        ]);
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:role_users,email',
            'photo' => 'image|mimes:jpeg,png,jpg|max:2048',
            'pin' => 'required|digits_between:4,6',
            'role' => 'required|string',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('profile_photos', 'public');
        }

        RoleUsers::create([
            'name' => $request->name,
            'email' => $request->email,
            'photo' => $photoPath,
            'pin' => $request->pin,
            'role' => $request->role,
        ]);
        return redirect()->route('add_supvis')->with('success', 'Sales berhasil ditambahkan!');

    }

    // Mengambil setoran & menangani void transaksi berdasarkan transaksi/tanggal yang dipilih
    public function setoran(Request $request)
    {
        Log::info('Request data for setoran:', $request->all());

        // Validasi input
        $request->validate([
            'ids' => 'array|nullable',
            'date' => 'date|nullable',
            'is_void' => 'boolean|nullable',
        ]);

        $ids = $request->input('ids');
        $tanggal = $request->input('date');
        $isVoid = $request->input('is_void');

        if (!$ids && !$tanggal) {
            return response()->json(['error' => 'Tidak ada transaksi atau tanggal yang dipilih.'], 400);
        }

        try {
            if ($ids) {
                $transaksis = Transaksi::withTrashed()
                    ->with(['produk' => function ($query) {
                        $query->withTrashed();
                    }])
                    ->whereIn('id_transaksi', $ids)
                    ->get();
            } elseif ($tanggal) {
                $transaksis = Transaksi::withTrashed()
                    ->with(['produk' => function ($query) {
                        $query->withTrashed();
                    }])
                    ->whereDate('tanggal_transaksi', $tanggal)
                    ->get();
            } else {
                return response()->json(['error' => 'Data tidak valid.'], 400);
            }

            if ($transaksis->isEmpty()) {
                return response()->json(['error' => 'Transaksi tidak ditemukan.'], 404);
            }

            $groupedTransaksi = $transaksis->groupBy(function ($item) {
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

            $totalHarga = $totalsPerDate->sum('totalPenjualan');
            $totalInsentif = $totalsPerDate->sum('totalInsentif');

            $namaSales = auth()->user()->name ?? 'Unknown Sales';

            foreach ($transaksis as $transaksi) {
                if ($isVoid !== null) {
                    if ($isVoid) {
                        $transaksi->delete();
                    } else {
                        $transaksi->restore();
                    }
                }

                $history_setoran = $transaksi->history_setoran;

                if (is_string($history_setoran)) {
                    $history = json_decode($history_setoran, true);
                } elseif (is_array($history_setoran)) {
                    $history = $history_setoran;
                } else {
                    $history = [];
                }

                $history[] = [
                    'nama_sales' => $namaSales,
                    'tanggal' => now()->toDateTimeString(),
                    'total_harga' => $transaksi->produk->produk_harga_akhir ?? 0,
                    'total_insentif' => $transaksi->produk->produk_insentif ?? 0,
                ];

                // Simpan kembali history ke database
                $transaksi->history_setoran = json_encode($history);
                $transaksi->save();
            }

            $historyData = Transaksi::withTrashed()
                ->whereNotNull('history_setoran')
                ->get(['id_transaksi', 'history_setoran'])
                ->map(function ($transaksi) {
                    return [
                        'id_transaksi' => $transaksi->id_transaksi,
                        'history' => json_decode($transaksi->history_setoran, true),
                    ];
                });

            return response()->json([
                'message' => 'Data setoran berhasil diproses.',
                'historyData' => $historyData,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Gagal mengambil data setoran: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function showHistorySetoran()
    {
        // Ambil semua sales dari RoleUsers yang memiliki role 'sales'
        $sales = RoleUsers::where('role', 'sales')->get();

        // Ambil transaksi yang belum disetor dan kelompokkan berdasarkan nama_sales
        $transaksiBelumSetor = Transaksi::where('is_setor', false)
            ->whereNotNull('history_setoran') // Pastikan hanya transaksi dengan history_setoran
            ->get()
            ->groupBy('nama_sales');

        // Ambil transaksi yang sudah disetor
        $transaksiSudahSetor = Transaksi::where('is_setor', true)->get();

        return view('supvis.izin_sales', compact(
            'transaksiBelumSetor',
            'transaksiSudahSetor',
            'sales'
        ));
    }

    public function updateSetoranSales(Request $request)
    {
        Log::info('Request masuk:', $request->all()); // Debugging

        if (!$request->has('sales')) {
            return response()->json(['success' => false, 'message' => 'Data tidak ditemukan'], 400);
        }

        $salesData = $request->input('sales');

        foreach ($salesData as $sales) {
            Log::info("Update ID {$sales['id']} -> is_setoran: {$sales['is_setoran']}"); // Debugging

            RoleUsers::where('id', $sales['id'])->update(['is_setoran' => $sales['is_setoran']]);
        }
        return;
    }

    public function updateSetoranStatus(Request $request)
    {
        // Ambil data transaksi yang dipilih dari form
        $ids = array_unique($request->input('setoran_data', []));

        // Cek apakah ada data yang dikirim
        if (empty($ids)) {
            return redirect()->back()->with('error', 'Tidak ada transaksi yang dipilih.');
        }

        try {
            // Update status setoran pada transaksi yang dipilih
            Transaksi::whereIn('id_transaksi', $ids)->update(['is_setor' => 1]);

            return redirect()->back()->with('success', 'Status setoran berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui status.');
        }
    }
}

