@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Kasir Dashboard</h1>
            <p class="text-gray-600 mt-2">Selamat datang, {{ Auth::user()->name ?? 'Kasir' }}</p>
        </div>
        <!-- Admin Link -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-blue-900">Admin Panel</h3>
                    <p class="text-blue-700 text-sm">Akses dashboard admin untuk manajemen sistem</p>
                </div>
                <a href="/programhaji/admin/home" class="inline-block px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                    <i class="fas fa-cogs"></i> Admin Dashboard
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Total Transaksi Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-medium">Total Transaksi</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalTransaksi ?? 0 }}</p>
                    </div>
                    <div class="text-4xl text-blue-500 opacity-20">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                </div>
            </div>

            <!-- Total Sales Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-medium">Total Sales</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalSales ?? 0 }}</p>
                    </div>
                    <div class="text-4xl text-green-500 opacity-20">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

            <!-- Status Card -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-medium">Status</p>
                        <p class="text-lg font-bold text-green-600 mt-2">
                            <i class="fas fa-check-circle"></i> Aktif
                        </p>
                    </div>
                    <div class="text-4xl text-yellow-500 opacity-20">
                        <i class="fas fa-cog"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-900 mb-4">Informasi Kasir</h2>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-gray-600 text-sm">Nama</p>
                    <p class="text-gray-900 font-medium">{{ Auth::user()->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Email</p>
                    <p class="text-gray-900 font-medium">{{ Auth::user()->email ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Role</p>
                    <p class="text-gray-900 font-medium">{{ Auth::user()->role ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-gray-600 text-sm">Login Terakhir</p>
                    <p class="text-gray-900 font-medium">{{ Auth::user()->updated_at?->format('d-m-Y H:i') ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection