<?php
namespace App\Http\Controllers\Admin;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::latest();

        // Jika ada filter tanggal, aplikasikan ke query
        if ($request->filled('date')) {
            $query->where(function($q) use ($request) {
                $q->whereDate('tanggal_transaksi', $request->date)
                  ->orWhereDate('created_at', $request->date);
            });
        }

        // Tambahkan withQueryString() agar saat pindah di Pagination halamannya (pilih page 2, 3), filternya tidak hilang
        $transaksi = $query->paginate(20)->withQueryString();
        
        return view("admin.transaksi.index", compact("transaksi"));
    }

    public function show($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        // Placeholder view (prevent crash until show view exists)
        return back()->with('info', 'Transaksi detail view coming soon.');
    }
}
