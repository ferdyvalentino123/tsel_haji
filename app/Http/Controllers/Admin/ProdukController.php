<?php

namespace App\Http\Controllers\Admin;

use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProdukController extends Controller
{
    public function index()
    {
        $produk = Produk::latest()->paginate(15);
        return view("admin.produk.index", compact("produk"));
    }

    public function create()
    {
        return view("admin.produk.form");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "produk_nama" => "required|string|max:255",
            "produk_harga" => "required|numeric|min:0",
            "produk_stok" => "required|integer|min:0",
            "produk_deskripsi" => "nullable|string",
            "produk_kategori" => "nullable|string",
        ]);

        Produk::create($validated);

        return redirect("/programhaji/admin/produk")->with("success", "Produk berhasil ditambahkan");
    }

    public function show(Produk $produk)
    {
        return view("admin.produk.show", compact("produk"));
    }

    public function edit(Produk $produk)
    {
        return view("admin.produk.form", compact("produk"));
    }

    public function update(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            "produk_nama" => "required|string|max:255",
            "produk_harga" => "required|numeric|min:0",
            "produk_stok" => "required|integer|min:0",
            "produk_deskripsi" => "nullable|string",
            "produk_kategori" => "nullable|string",
        ]);

        $produk->update($validated);

        return redirect("/programhaji/admin/produk")->with("success", "Produk berhasil diperbarui");
    }

    public function destroy(Produk $produk)
    {
        $produk->delete();
        return response()->json(["success" => true]);
    }
}
