<?php

namespace App\Http\Controllers\Sales;
use App\Http\Controllers\Controller;

use App\Models\BudgetInsentif;
use App\Models\Transaksi;
use App\Models\BudgetHistory;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class BudgetInsentifController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::all();
        $totalInsentif = 0;
        foreach ($transaksi as $item) {
            if ($item->produk && $item->produk->produk_insentif !== null) {
                $totalInsentif += $item->produk->produk_insentif;
            }
        }
        $budgetInsentif = BudgetInsentif::first();
        $totalBudget = $budgetInsentif ? $budgetInsentif->total_insentif : 0;
        $sisaBudget = $totalBudget - $totalInsentif;
        return view('supvis.budget_insentif.index', compact('totalInsentif', 'sisaBudget', 'totalBudget'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'total_insentif' => 'required|numeric|min:0',
            'action' => 'required|in:tambah,ganti',
        ]);

        $budgetInsentif = BudgetInsentif::firstOrCreate([], ['total_insentif' => 0]);

        $previousBudget = $budgetInsentif->total_insentif;
        $changeAmount = $request->input('total_insentif');

        if ($request->input('action') == 'tambah') {
            $budgetInsentif->increment('total_insentif', $changeAmount);
            $actionType = 'add';
        } else {
            $budgetInsentif->update(['total_insentif' => $changeAmount]);
            $actionType = 'update';
        }

        BudgetHistory::create([
            'budget_insentif_id' => $budgetInsentif->id,
            'change_amount' => $changeAmount,
            'previous_budget' => $previousBudget,
            'current_budget' => $budgetInsentif->total_insentif,
            'action' => $actionType,
        ]);

        return redirect()->route('supvis.budget_insentif.index')->with('status', 'Budget Insentif berhasil diperbarui!');
    }

    public function pantau()
{
    // Ambil total anggaran saat ini
    $budgetInsentif = BudgetInsentif::first();
    $totalBudget = $budgetInsentif ? $budgetInsentif->total_insentif : 0;

    // Hitung total insentif yang telah digunakan
    $transaksi = Transaksi::all();
    $totalInsentif = 0;
    foreach ($transaksi as $item) {
        if ($item->produk && $item->produk->produk_insentif !== null) {
            $totalInsentif += $item->produk->produk_insentif;
        }
    }

    // Hitung sisa anggaran
    $sisaBudget = $totalBudget - $totalInsentif;

    // Ambil riwayat anggaran dengan urutan waktu
    $budgetHistories = BudgetHistory::orderBy('created_at', 'asc')->get();

    // Variabel untuk menyimpan nilai anggaran sebelumnya
    $previousBudget = 0;

    // Perbarui nilai `previous_budget` untuk setiap riwayat berdasarkan urutan perubahan
    foreach ($budgetHistories as $index => $history) {
        if ($index == 0) {
            // Jika ini adalah entri pertama, gunakan nilai awal anggaran
            $history->previous_budget = 0;
        } else {
            // Ambil previous_budget dari riwayat sebelumnya
            $history->previous_budget = $budgetHistories[$index - 1]->current_budget;
        }

        // Simpan perubahan pada `previous_budget`
        $history->save();
    }

    return view('supvis.budget_insentif.pantau', compact('totalBudget', 'totalInsentif', 'sisaBudget', 'budgetHistories'));
}

}

