<?php

namespace App\Http\Controllers\Sales;
use App\Http\Controllers\Controller;

use App\Models\Insentif;
use App\Models\Produk;
use Illuminate\Http\Request;

class InsentifController extends Controller
{
    public function index(){

        $insentif = Insentif::all();
        return view ('insentif.index',compact('insentif'));
    }

    public function create()
    {
        $produks = Produk::all();
        return view('insentif.create', compact('produks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipe_insentif' => 'required|in:persen,harga',
            'nilai_insentif' => 'required|numeric',
            'produk_id' => 'required|exists:produks,id',
        ]);

        Insentif::create($validated);
        return redirect()->route('insentif.index')->with('success', 'Insentif berhasil ditambahkan!');
    }
    public function show(Insentif $insentif)
    {

        return view('insentif.show', compact('insentif'));
    }

    public function edit(Insentif $insentif)
    {
        return view('insentif.edit', compact('insentif'));
    }

    public function update(Request $request, Insentif $insentif)
    {
        $request->validate([
            'tipe_insentif' => 'required|in:persen,harga',
            'nilai_insentif' => 'required|numeric',
            'produk_id' => 'required|exists:produks,id',
        ]);

       $insentif->update($request->all());

        return redirect()->route('insentif.index')->with('success', 'Insentif berhasil diperbarui!');
    }

    public function destroy(Insentif $insentif)
    {
        $insentif->delete();

        return redirect()->route('insentif.index')->with('success', 'Insentif berhasil dihapus!');
    }
}

