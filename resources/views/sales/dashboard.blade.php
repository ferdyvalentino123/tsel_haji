@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold">Sales Dashboard</h1>
    <p class="text-gray-600 mt-2">Selamat datang, {{ Auth::user()->name ?? 'Sales' }}</p>
</div>
@endsection