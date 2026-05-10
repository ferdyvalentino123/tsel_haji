@extends('admin.layout')

@section('title', 'Rekapan Insentif Sales')

@section('content')

<style>
    /* Mobile responsiveness for insentif table */
    .table-responsive {
        border-radius: 0;
        margin-bottom: 0;
    }

    .table-custom {
        margin-bottom: 0;
        min-width: 100%;
    }

    /* Ensure columns have minimum width for better mobile scrolling */
    .table-custom th,
    .table-custom td {
        white-space: nowrap;
        min-width: 120px;
        padding: 0.75rem;
    }

    /* Adjust first column */
    .table-custom th:first-child,
    .table-custom td:first-child {
        min-width: 50px;
    }

    /* Adjust nama sales column */
    .table-custom th:nth-child(2),
    .table-custom td:nth-child(2) {
        min-width: 150px;
        white-space: normal;
    }

    /* Mobile view */
    @media (max-width: 768px) {
        .table-custom th,
        .table-custom td {
            font-size: 0.85rem;
            padding: 0.5rem;
            min-width: 100px;
        }

        .table-custom th:nth-child(2),
        .table-custom td:nth-child(2) {
            min-width: 130px;
        }

        .stat-card {
            margin-bottom: 1rem;
        }

        .page-title {
            font-size: 1.5rem;
        }
    }

    /* Extra small devices */
    @media (max-width: 480px) {
        .table-custom th,
        .table-custom td {
            font-size: 0.75rem;
            padding: 0.4rem;
            min-width: 85px;
        }

        .stat-value {
            font-size: 1.2rem;
        }
    }
</style>
<div class="row mb-4">
    <div class="col-12">
        <h1 class="page-title">Rekapan Insentif Sales</h1>
    </div>
</div>

<!-- Summary Stats -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Sales</div>
                <div class="stat-value">{{ count($insentifData) }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Transaksi</div>
                <div class="stat-value">{{ $insentifData->sum('total_transaksi') }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-money-bill-trend-up"></i>
            </div>
            <div class="stat-info">
                <div class="stat-label">Total Insentif</div>
                <div class="stat-value">Rp {{ number_format($totalSeluruhInsentif, 0, ',', '.') }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Main Table -->
<div class="content-card">
    <div class="card-header">
        <h5>Detail Insentif Per Sales</h5>
    </div>
    <div class="table-responsive" style="overflow-x: auto; -webkit-overflow-scrolling: touch;">
    <table class="table-custom">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Sales</th>
                <th>Total Transaksi</th>
                <th>Total Penjualan</th>
                <th>Total Insentif</th>
                <th>Rata-rata Per Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @if ($insentifData->isEmpty())
            <tr>
                <td colspan="6" class="text-center text-muted py-4">Belum ada data transaksi yang lunas</td>
            </tr>
            @else
                @foreach ($insentifData as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item['nama_sales'] ?? 'N/A' }}</strong>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-info">{{ $item['total_transaksi'] }}</span>
                    </td>
                    <td>
                        Rp {{ number_format($item['total_penjualan'], 0, ',', '.') }}
                    </td>
                    <td>
                        <strong class="text-success">Rp {{ number_format($item['total_insentif'], 0, ',', '.') }}</strong>
                    </td>
                    <td>
                        Rp {{ number_format($item['total_transaksi'] > 0 ? $item['total_insentif'] / $item['total_transaksi'] : 0, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    </div>
</div>

<!-- Summary Footer -->
@if ($insentifData->isNotEmpty())
<div class="row mt-4">
    <div class="col-12">
        <div class="alert alert-info border-0">
            <strong> !! Total insentif yang harus dibayarkan kepada seluruh sales adalah 
            <strong>Rp {{ number_format($totalSeluruhInsentif, 0, ',', '.') }}</strong>
            dari {{ $insentifData->sum('total_transaksi') }} transaksi yang lunas.
        </div>
    </div>
</div>
@endif

@endsection
