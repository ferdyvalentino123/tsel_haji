<?php
namespace App\Http\Controllers\Admin;
use App\Models\Merchandise;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MerchandiseController extends Controller
{
    public function index()
    {
        $merchandise = Merchandise::paginate(10);
        return view("admin.merchandise.index", compact("merchandise"));
    }

    public function create()
    {
        return view("admin.merchandise.form");
    }

    public function store(Request $request)
    {
        $request->validate([
            'merch_nama' => 'required|string|max:255',
            'merch_detail' => 'required|string',
            'merch_stok' => 'required|integer|min:0',
        ]);

        $merchandise = Merchandise::create($request->all());

        // Record History
        \App\Models\StockHistory::create([
            'merchandise_id' => $merchandise->id,
            'change_amount' => $merchandise->merch_stok,
            'previous_stock' => 0,
            'current_stock' => $merchandise->merch_stok,
            'action' => 'Tambah (Initial)',
        ]);

        return redirect()->route('admin.merchandise.index')->with('success', 'Merchandise berhasil ditambahkan!');
    }

    public function edit(Merchandise $merchandise)
    {
        return view("admin.merchandise.form", compact("merchandise"));
    }

    public function update(Request $request, Merchandise $merchandise)
    {
        $request->validate([
            'merch_nama' => 'required|string|max:255',
            'merch_detail' => 'required|string',
            'merch_stok' => 'required|integer|min:0',
        ]);

        $oldStock = $merchandise->merch_stok;
        $newStock = $request->merch_stok;

        $merchandise->update($request->all());

        if ($oldStock != $newStock) {
            \App\Models\StockHistory::create([
                'merchandise_id' => $merchandise->id,
                'change_amount' => abs($newStock - $oldStock),
                'previous_stock' => $oldStock,
                'current_stock' => $newStock,
                'action' => $newStock > $oldStock ? 'Tambah (Update)' : 'Kurang (Update)',
            ]);
        }

        return redirect()->route('admin.merchandise.index')->with('success', 'Merchandise berhasil diperbarui!');
    }

    public function destroy(Merchandise $merchandise)
    {
        $merchandise->delete();
        return redirect()->route('admin.merchandise.index')->with('success', 'Merchandise berhasil dihapus!');
    }
}
