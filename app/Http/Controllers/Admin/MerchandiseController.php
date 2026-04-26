<?php
namespace App\Http\Controllers\Admin;
use App\Models\Merchandise;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MerchandiseController extends Controller
{
    public function index()
    {
        $merchandise = Merchandise::paginate(15);
        return view("admin.merchandise.index", compact("merchandise"));
    }
    public function create() { return view("admin.merchandise.form"); }
    public function store(Request $request) { return redirect("/programhaji/admin/merchandise"); }
    public function edit(Merchandise $merchandise) { return view("admin.merchandise.form", compact("merchandise")); }
}
