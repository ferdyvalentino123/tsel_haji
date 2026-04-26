<?php
namespace App\Http\Controllers\Admin;
use App\Models\StockHistory;
use App\Http\Controllers\Controller;

class StockHistoryController extends Controller
{
    public function index()
    {
        $stockHistory = StockHistory::latest()->paginate(20);
        return view("admin.stock-history.index", compact("stockHistory"));
    }
}
