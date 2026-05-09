<x-Sales.SalesLayouts>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if (session('alert'))
        <script>
            Swal.fire({
                title: 'Akses Ditolak!',
                text: "{{ session('alert') }}",
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

    <style>
        .welcome-banner {
            background: linear-gradient(135deg, #bc0007 0%, #ec1d24 100%);
            border-radius: 15px;
            padding: 30px;
            color: white;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 10px 20px rgba(188, 0, 7, 0.2);
            position: relative;
            overflow: hidden;
        }
        .welcome-banner::after {
            content: '';
            position: absolute;
            right: -50px;
            top: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            border: none;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
            height: 100%;
        }
        .stat-card:hover {
            transform: translateY(-5px);
        }
        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }
        .bg-red-light { background-color: rgba(188, 0, 7, 0.1); color: #bc0007; }
        .bg-gold-light { background-color: rgba(255, 215, 0, 0.1); color: #d4af37; }
        .bg-blue-light { background-color: rgba(37, 117, 252, 0.1); color: #2575fc; }

        .progress {
            height: 10px;
            border-radius: 5px;
            background-color: #f0f0f0;
        }
        .progress-bar {
            background-color: #bc0007;
            border-radius: 5px;
        }
        .recent-item {
            padding: 12px;
            border-bottom: 1px solid #f8f9fa;
            transition: background 0.2s;
        }
        .recent-item:hover {
            background-color: #fcfcfc;
        }
        .recent-item:last-child {
            border-bottom: none;
        }
        .badge-tsel {
            background-color: rgba(188, 0, 7, 0.1);
            color: #bc0007;
            font-weight: 600;
            font-size: 0.75rem;
        }

        @media (max-width: 768px) {
            .welcome-banner {
                padding: 20px;
                margin-bottom: 20px;
                flex-direction: column;
                text-align: center;
            }
            .welcome-banner h1 {
                font-size: 1.5rem;
            }
            .welcome-banner p {
                font-size: 0.85rem;
            }
            .stat-card {
                padding: 15px;
            }
            .stat-card h3 {
                font-size: 1.25rem;
            }
        }
    </style>


        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <div>
                <h1 class="text-white fw-bold mb-2">Semangat Pagi, {{ Auth::user()->name }}! 👋</h1>
                <p class="mb-0 opacity-75">Ayo capai targetmu hari ini. Setiap langkah kecil adalah kunci sukses!</p>
            </div>
            <div class="d-none d-md-block">
                <img src="{{ asset('admin_asset/img/photos/icon_sales.png') }}" alt="Sales Icon" style="width: 120px; filter: drop-shadow(0 5px 15px rgba(0,0,0,0.2));">
            </div>
        </div>

        <!-- Summary Statistics -->
        <div class="row g-4 mb-4">
            <div class="col-12 col-md-4">
                <div class="stat-card">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-red-light me-3">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <h6 class="text-muted mb-0">Total Penjualanmu</h6>
                    </div>
                    <h3 class="fw-bold mb-0">Rp {{ number_format($totalPenjualan, 0, ',', '.') }}</h3>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="stat-card">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-gold-light me-3">
                            <i class="fas fa-coins"></i>
                        </div>
                        <h6 class="text-muted mb-0">Total Insentif</h6>
                    </div>
                    <h3 class="fw-bold mb-0">Rp {{ number_format($totalInsentif, 0, ',', '.') }}</h3>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="stat-card">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stat-icon bg-blue-light me-3">
                            <i class="fas fa-history"></i>
                        </div>
                        <h6 class="text-muted mb-0">Transaksi Hari Ini</h6>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $groupedTransaksi->has(date('Y-m-d')) ? $groupedTransaksi->get(date('Y-m-d'))->count() : 0 }}</h3>
                </div>
            </div>
        </div>

        <!-- Main Layout Grid -->
        <div class="row g-4">
            <!-- Left Column: Recent Activity -->
            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0"><i class="fas fa-history text-danger me-2"></i> Transaksi Terakhir</h5>
                        <a href="{{ route('sales/rekap') }}" class="btn btn-sm btn-link text-danger text-decoration-none fw-bold">Lihat Semua</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="px-2">
                            @forelse($transaksi->take(6) as $item)
                                <div class="recent-item d-flex align-items-center justify-content-between px-3">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                                            <i class="fas fa-user text-muted"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">{{ $item->nama_pelanggan }}</h6>
                                            <small class="text-muted">{{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d M, H:i') }}</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <div class="fw-bold text-danger">Rp {{ number_format($item->produk ? $item->produk->produk_harga_akhir : 0, 0, ',', '.') }}</div>
                                        <span class="badge badge-tsel">Sukses</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <img src="https://illustrations.popsy.co/red/empty-folder.svg" alt="Empty" style="width: 150px; opacity: 0.5;">
                                    <p class="text-muted mt-3">Belum ada transaksi hari ini.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Target & Quick Actions -->
            <div class="col-12 col-lg-4">
                <!-- Top Selling Products -->
                <div class="card border-0 shadow-sm rounded-4 mb-4" style="background: linear-gradient(135deg, #ffffff 0%, #fffafa 100%); border: 1px solid rgba(188, 0, 7, 0.05) !important;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4"><i class="fas fa-crown text-warning me-2"></i> <i>Top Selling</i></h5>
                        
                        @php
                            $topSelling = $transaksi->whereNotNull('produk_id')
                                ->groupBy('produk_id')
                                ->map(function($items) {
                                    $produk = $items->first()->produk;
                                    return [
                                        'name' => $produk ? $produk->produk_nama : 'Paket Tidak Diketahui',
                                        'count' => $items->count()
                                    ];
                                })
                                ->sortByDesc('count')
                                ->take(3);
                        @endphp

                        <div class="top-selling-list">
                            @forelse($topSelling as $item)
                                <div class="d-flex align-items-center justify-content-between p-3 rounded-3 bg-white border border-light mb-3 shadow-sm transition-all hover-shadow" style="transition: all 0.3s ease;">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-red-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; min-width: 40px; overflow: hidden; padding: 8px;">
                                            <img src="{{ asset('admin_asset/img/photos/icon_telkomsel.png') }}" alt="Tsel" style="width: 100%; height: 100%; object-fit: contain;">
                                        </div>
                                        <div>
                                            <div class="fw-bold small text-dark">{{ $item['name'] }}</div>
                                            <div class="text-muted" style="font-size: 0.75rem;">{{ $item['count'] }} Kali Terjual</div>
                                        </div>
                                    </div>
                                    <div class="badge rounded-pill bg-danger bg-opacity-10 text-danger border-0 px-3 py-2" style="font-size: 0.7rem;">
                                        Top {{ $loop->iteration }}
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-4">
                                    <img src="https://illustrations.popsy.co/red/falling.svg" alt="No Data" style="width: 80px; opacity: 0.5; margin-bottom: 15px;">
                                    <p class="text-muted small">Belum ada data penjualan paket.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Aksi Cepat</h5>
                        <div class="d-grid gap-3">
                            <a href="{{ route('sales.transaksi') }}" class="btn btn-danger py-3 rounded-3 d-flex align-items-center justify-content-center fw-bold shadow-sm">
                                <i class="fas fa-plus-circle me-2"></i>
                                <span>Input Transaksi Baru</span>
                            </a>
                            <a href="{{ route('sales/rekap') }}" class="btn btn-outline-danger py-3 rounded-3 d-flex align-items-center justify-content-center fw-bold">
                                <i class="fas fa-list-alt me-2"></i>
                                <span>Riwayat Penjualan</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

</x-Sales.SalesLayouts>
