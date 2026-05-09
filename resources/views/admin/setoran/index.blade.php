@extends('admin.layout')
@section('title', 'Monitor Setoran Sales')
@section('content')
    <div class="container-fluid" style="background: #f8f9fa;">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="background: linear-gradient(135deg, #bc0007 0%, #ff4d4d 100%);">
                    <div class="card-body p-4 text-white d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="fw-bold mb-1"><i class="fas fa-monument me-2"></i> Monitor Setoran Sales</h4>
                            <p class="mb-0 opacity-75">Pantau arus kas dan status setoran seluruh tim sales per tanggal.</p>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-white text-danger px-3 py-2 rounded-pill fw-bold shadow-sm">
                                <i class="fas fa-calendar-day me-1"></i> {{ date('d M Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monitoring List -->
        <div class="row">
            <div class="col-12">
                @forelse($groupedData as $tanggal => $salesList)
                    <div class="mb-5">
                        <div class="d-flex align-items-center mb-3">
                            <div class="bg-danger rounded-circle d-flex align-items-center justify-content-center text-white me-3" style="width: 40px; height: 40px;">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <h5 class="fw-bold mb-0">{{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</h5>
                            <hr class="flex-grow-1 ms-3 opacity-25">
                        </div>

                        <div class="row g-4">
                            @foreach($salesList as $namaSales => $data)
                                <div class="col-12 col-md-6 col-xl-4">
                                    <div class="card border-0 shadow-sm rounded-4 h-100 transition-all hover-shadow" style="border-left: 5px solid {{ $data['is_all_setor'] ? '#28a745' : '#ffc107' }} !important;">
                                        <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div>
                                                    <h6 class="text-muted small fw-bold text-uppercase mb-1">Sales Person</h6>
                                                    <h5 class="fw-bold text-dark mb-0">{{ $namaSales }}</h5>
                                                </div>
                                                <span class="badge {{ $data['is_all_setor'] ? 'bg-success' : 'bg-warning text-dark' }} rounded-pill px-3">
                                                    {{ $data['is_all_setor'] ? 'Selesai' : 'Pending' }}
                                                </span>
                                            </div>

                                            <div class="row g-3 mb-4">
                                                <div class="col-6">
                                                    <div class="bg-light p-3 rounded-3">
                                                        <span class="text-muted small d-block mb-1">Total Penjualan</span>
                                                        <span class="fw-bold text-dark">Rp {{ number_format($data['total_sales'], 0, ',', '.') }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="bg-light p-3 rounded-3">
                                                        <span class="text-muted small d-block mb-1">Jumlah Item</span>
                                                        <span class="fw-bold text-dark">{{ $data['count'] }} Transaksi</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="progress mb-3" style="height: 8px; border-radius: 10px;">
                                                @php 
                                                    $percent = $data['total_sales'] > 0 ? ($data['total_setor'] / $data['total_sales']) * 100 : 0;
                                                @endphp
                                                <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>

                                            <div class="d-flex justify-content-between small">
                                                <span class="text-success"><i class="fas fa-check-circle me-1"></i> Setor: Rp {{ number_format($data['total_setor'], 0, ',', '.') }}</span>
                                                <span class="text-danger"><i class="fas fa-clock me-1"></i> Sisa: Rp {{ number_format($data['total_pending'], 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <img src="https://illustrations.popsy.co/red/searching.svg" alt="Empty" style="width: 250px; opacity: 0.5;">
                        <h4 class="text-muted mt-4">Belum ada data setoran ditemukan.</h4>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <style>
        .hover-shadow:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        }
        .transition-all {
            transition: all 0.3s ease;
        }
    </style>
@endsection
