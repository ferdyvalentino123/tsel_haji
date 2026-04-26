@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold">Pelanggan Dashboard</h1>
    <p class="text-gray-600 mt-2">Selamat datang, {{ Auth::user()->name ?? 'Pelanggan' }}</p>
    
    @if(isset($produks) && $produks->count())
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
            @foreach($produks as $produk)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-bold">{{ $produk->nama_produk }}</h3>
                <p class="text-gray-600 mt-2">Rp {{ number_format($produk->produk_harga_akhir) }}</p>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection