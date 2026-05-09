<x-pelanggan.layouts>
    <style>
        :root {
            --tsel-primary: #bc0007;
            --tsel-primary-light: #e2241d;
            --tsel-dark: #1a1c1c;
            --tsel-gray: #f9f9f9;
            --tsel-border: #e2e2e2;
        }

        .page-header {
            background: linear-gradient(135deg, var(--tsel-primary) 0%, var(--tsel-primary-light) 100%);
            border-radius: 16px;
            padding: 24px;
            color: #fff;
            margin-bottom: 24px;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(188, 0, 7, 0.15);
        }

        .page-header::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 0l2.5 12.5L45 15l-12.5 2.5L30 30l-2.5-12.5L15 15l12.5-2.5L30 0zm0 30l2.5 12.5L45 45l-12.5 2.5L30 60l-2.5-12.5L15 45l12.5-2.5L30 30z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
            z-index: 0;
            pointer-events: none;
        }

        .page-header > * { position: relative; z-index: 1; }

        .page-header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .page-header p {
            margin-bottom: 0;
            font-size: 1rem;
            opacity: 0.9;
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 16px;
            margin-bottom: 24px;
        }

        .summary-card {
            background: #fff;
            border-radius: 16px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            text-align: center;
            border: 1px solid var(--tsel-border);
        }

        .summary-card i {
            font-size: 2.5rem;
            margin-bottom: 12px;
        }

        .summary-card.total i { color: var(--tsel-primary); }
        .summary-card.pending i { color: #f39c12; }
        .summary-card.success i { color: #2e7d32; }

        .summary-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
            color: var(--tsel-dark);
        }

        .summary-label {
            font-size: 0.9rem;
            color: #666;
            font-weight: 500;
        }

        .transaction-card {
            background: #fff;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
            border: 1px solid var(--tsel-border);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            border-left: 4px solid var(--tsel-primary);
            transition: all 0.3s ease;
        }

        .transaction-card.pending-transaction {
            border-left: 4px solid #f39c12;
            background: linear-gradient(to right, rgba(243, 156, 18, 0.02) 0%, #ffffff 100%);
        }
        .transaction-card.success {
            border-left: 4px solid #2e7d32;
        }

        .transaction-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--tsel-border);
        }

        .transaction-id {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--tsel-dark);
        }

        .transaction-date {
            color: #666;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .transaction-body {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }

        .transaction-info {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--tsel-gray);
            padding: 12px;
            border-radius: 10px;
            border: 1px solid var(--tsel-border);
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: rgba(188, 0, 7, 0.05);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--tsel-primary);
            font-size: 1.2rem;
        }

        .info-content { flex: 1; }

        .info-label {
            font-size: 0.8rem;
            color: #666;
            margin-bottom: 2px;
        }

        .info-value {
            font-size: 1rem;
            font-weight: 700;
            color: var(--tsel-dark);
        }

        .transaction-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 15px;
            border-top: 1px solid var(--tsel-border);
        }

        .total-price-label {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 2px;
        }

        .total-price {
            font-size: 1.4rem;
            font-weight: 800;
            color: var(--tsel-primary);
            line-height: 1;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .status-pending { background: #fff8e1; color: #f39c12; border: 1px solid #ffecb3; }
        .status-success { background: #e8f5e9; color: #2e7d32; border: 1px solid #c8e6c9; }
        .status-failed { background: #ffebee; color: var(--tsel-primary); border: 1px solid #ffcdd2; }

        .btn-pay-now {
            background: linear-gradient(135deg, var(--tsel-primary) 0%, var(--tsel-primary-light) 100%);
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: none;
            cursor: pointer;
        }

        .btn-pay-now:hover { background: #93000a; color: #fff; }

        .btn-cancel {
            background: #fff;
            color: var(--tsel-dark);
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            border: 1px solid #ccc;
            cursor: pointer;
            font-size: 0.85rem;
        }

        .btn-cancel:hover { background: #f5f5f5; color: var(--tsel-dark); border-color: #999; }

        .btn-download-nota {
            background: #fff;
            color: var(--tsel-dark);
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            border: 1px solid var(--tsel-primary);
            cursor: pointer;
            font-size: 0.85rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .btn-download-nota:hover {
            background: var(--tsel-primary);
            color: #fff;
            border-color: var(--tsel-primary);
            text-decoration: none;
        }



        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: #fff;
            border-radius: 16px;
            border: 1px dashed #ccc;
        }

        .empty-state i { font-size: 4rem; color: #e0e0e0; margin-bottom: 15px; }

        .empty-state h3 { color: var(--tsel-dark); font-weight: 600; font-size: 1.2rem; margin-bottom: 10px; }

        .empty-state p { color: #666; font-size: 0.95rem; margin-bottom: 20px; }

        .btn-shop-now {
            background: var(--tsel-primary);
            color: #fff;
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .footer-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        /* Mobile specific styling to make it compact */
        @media (max-width: 768px) {
            .page-header { padding: 20px 15px; border-radius: 12px; }
            .page-header h1 { font-size: 1.4rem; }
            .page-header p { font-size: 0.85rem; }

            .summary-cards { grid-template-columns: 1fr; gap: 10px; margin-bottom: 15px; }
            .summary-card { padding: 12px 15px; display: flex; align-items: center; text-align: left; gap: 15px; }
            .summary-card i { font-size: 2rem; margin-bottom: 0; }
            .summary-value { font-size: 1.5rem; margin-bottom: 0px; }
            .summary-card div.label-container { flex: 1; }

            .transaction-card { padding: 15px; border-radius: 12px; border-left-width: 3px; }
            .transaction-card.pending-transaction { border-left-width: 3px; }

            .transaction-header { flex-direction: column; align-items: flex-start; gap: 5px; }
            .transaction-id { font-size: 1rem; }
            .transaction-date { font-size: 0.8rem; }
            
            .transaction-body { grid-template-columns: 1fr; gap: 10px; }
            .transaction-info { padding: 10px; gap: 10px; }
            .info-icon { width: 35px; height: 35px; font-size: 1rem; }
            .info-value { font-size: 0.9rem; }

            .transaction-footer { flex-direction: column; align-items: flex-start; gap: 12px; }
            .total-price { font-size: 1.25rem; }
            
            .footer-actions { width: 100%; display: grid; grid-template-columns: 1fr; gap: 8px; }
            .btn-pay-now { width: 100%; }
            .btn-cancel { width: 100%; }
            .status-badge { width: 100%; }
        }

        /* Premium Modal Receipt Styles */
        .modal-receipt .modal-content {
            border-radius: 20px;
            border: none;
            overflow: hidden;
            box-shadow: 0 25px 80px rgba(0,0,0,0.25);
        }

        .modal-receipt .modal-header {
            background: linear-gradient(135deg, var(--tsel-primary) 0%, var(--tsel-primary-light) 100%);
            color: #fff;
            border: none;
            padding: 20px 25px;
        }

        .modal-receipt .modal-title {
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .modal-receipt .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.8;
        }

        .modal-receipt .modal-body {
            background: #f4f6f8;
            padding: 25px;
        }

        #notaContent {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            position: relative;
            min-height: 300px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .modal-receipt .modal-footer {
            border-top: 1px solid #eee;
            padding: 15px 25px;
            background: #fff;
        }

        .btn-print-nota {
            background: #f8f9fa;
            color: #333;
            border: 1px solid #ddd;
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-print-nota:hover {
            background: #eee;
            color: #000;
        }
    </style>

    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-history"></i> Riwayat Transaksi</h1>
        <p>Lihat semua transaksi pembelian paket kuota Anda</p>
    </div>

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($transaksis->count() > 0)
        <!-- Summary Cards -->
        <div class="summary-cards">
            <div class="summary-card total">
                <i class="fas fa-shopping-cart"></i>
                <div class="summary-value">{{ $transaksis->count() }}</div>
                <div class="summary-label">Total Transaksi</div>
            </div>
            <div class="summary-card pending">
                <i class="fas fa-clock"></i>
                <div class="summary-value">{{ $transaksis->where('status', 'pending')->count() }}</div>
                <div class="summary-label">Menunggu Pembayaran</div>
            </div>
            <div class="summary-card success">
                <i class="fas fa-check-circle"></i>
                <div class="summary-value">{{ $transaksis->whereIn('status', ['success', 'lunas'])->count() }}</div>
                <div class="summary-label">Berhasil</div>
            </div>
        </div>

        <!-- Transaction List -->
        @foreach($transaksis as $transaksi)
        <div class="transaction-card {{ $transaksi->status == 'pending' ? 'pending-transaction' : '' }}">
            <div class="transaction-header">
                <div class="transaction-id">
                    <i class="fas fa-receipt"></i> Transaksi #{{ $transaksi->id }}
                </div>
                <div class="transaction-date">
                    <i class="far fa-calendar-alt"></i>
                    {{ \Carbon\Carbon::parse($transaksi->created_at)->format('d M Y, H:i') }} WIB
                </div>
            </div>

            <div class="transaction-body">
                <div class="transaction-info">
                    <div class="info-icon">
                        <i class="fas fa-sim-card"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Paket</div>
                        <div class="info-value">{{ $transaksi->produk->produk_nama ?? 'Produk Tidak Ditemukan' }}</div>
                        <div class="info-label mt-1" style="font-size: 0.7rem; opacity: 0.8;">
                            <i class="fas fa-calendar-check me-1"></i> Aktivasi: {{ \Carbon\Carbon::parse($transaksi->aktivasi_tanggal)->translatedFormat('d M Y') }}
                        </div>
                    </div>
                </div>

                <div class="transaction-info">
                    <div class="info-icon">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <div class="info-content">
                        <div class="info-label">Nomor Injeksi</div>
                        <div class="info-value">{{ $transaksi->telepon_pelanggan }}</div>
                    </div>
                </div>
            </div>

            <div class="transaction-footer">
                <div>
                    <div class="total-price-label">Total Pembayaran</div>
                    <div class="total-price">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</div>
                </div>
                
                <div style="display: flex; align-items: center; gap: 15px; flex-wrap: wrap;">
                    @if($transaksi->status == 'pending')
                        <span class="status-badge status-pending">
                            <i class="fas fa-clock"></i> Menunggu Pembayaran
                        </span>
                        <a href="{{ route('pelanggan.pembayaran', $transaksi->id) }}" class="btn-pay-now">
                            <i class="fas fa-qrcode"></i> Lanjutkan Pembayaran
                        </a>
                        <form action="{{ route('pelanggan.transaksi.batalkan', $transaksi->id) }}" method="POST" 
                              class="cancel-form" 
                              data-id="{{ $transaksi->id }}"
                              data-produk="{{ $transaksi->produk->produk_nama ?? 'Produk' }}"
                              data-jumlah="{{ $transaksi->jumlah }}"
                              style="margin: 0;">
                            @csrf
                            <button type="button" class="btn-cancel btn-cancel-transaction">
                                <i class="fas fa-times-circle"></i> Batalkan
                            </button>
                        </form>
                    @elseif($transaksi->status == 'success' || $transaksi->status == 'lunas')
                        <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
                            @if(!$transaksi->is_activated)
                                <div class="d-flex flex-column align-items-end">
                                    <span class="status-badge" style="background: #fff3cd; color: #856404; border: 1px solid #ffeeba;">
                                        <i class="fas fa-hourglass-half"></i> Menunggu Aktivasi
                                    </span>
                                    <small class="text-muted" style="font-size: 0.65rem; margin-top: 2px;">
                                        <i class="fas fa-info-circle"></i> Proses tim 1x24 jam
                                    </small>
                                </div>
                            @else
                                <span class="status-badge status-success">
                                    <i class="fas fa-check-circle"></i> Berhasil
                                </span>
                            @endif

                            <div class="d-flex gap-2">
                                <button type="button" class="btn-download-nota btn-lihat-modal" data-transaksi-id="{{ $transaksi->id }}" title="Lihat Nota">
                                    <i class="fas fa-receipt"></i> Detail Nota
                                </button>
                                
                                @if($transaksi->is_activated && $transaksi->bukti_injeksi)
                                <button type="button" class="btn-download-nota" style="background: #e3f2fd; color: #0d47a1;" onclick="viewBuktiInjeksi('{{ asset('storage/' . $transaksi->bukti_injeksi) }}')">
                                    <i class="fas fa-file-invoice"></i> Bukti Injeksi
                                </button>
                                @endif
                            </div>
                        </div>
                    @else
                        <span class="status-badge status-failed">
                            <i class="fas fa-times-circle"></i> {{ ucfirst($transaksi->status) }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach

    @else
        <!-- Empty State -->
        <div class="empty-state">
            <i class="fas fa-receipt"></i>
            <h3>Belum Ada Transaksi</h3>
            <p>Anda belum melakukan transaksi pembelian. Yuk mulai belanja paket kuota haji sekarang!</p>
            <a href="{{ route('pelanggan.home') }}" class="btn-shop-now">
                <i class="fas fa-shopping-cart"></i> Mulai Belanja
            </a>
        </div>
    @endif

    <!-- Modal Lihat Nota -->
    <div class="modal fade" id="notaModal" tabindex="-1" aria-labelledby="notaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-receipt">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notaModalLabel">
                        <i class="fas fa-receipt"></i> Detail Nota Transaksi
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="notaContent">
                        <!-- Content will be loaded here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <a href="#" id="btnDownloadPDF" class="btn btn-print-nota text-danger" title="Download PDF">
                        <i class="fas fa-file-pdf"></i> Download
                    </a>
                    <!-- <button type="button" class="btn btn-print-nota" onclick="window.print()">
                        <i class="fas fa-print"></i> Cetak
                    </button> -->
                </div>
            </div>
        </div>
    </div>

    <script>
        // Handle Lihat Modal
        let notaModalInstance = null;
        
        document.querySelectorAll('.btn-lihat-modal').forEach(button => {
            button.addEventListener('click', function() {
                const transaksiId = this.dataset.transaksiId;
                const modalElement = document.getElementById('notaModal');
                const notaContent = document.getElementById('notaContent');
                const btnDownloadPDF = document.getElementById('btnDownloadPDF');
                
                // Set download URL
                const downloadUrl = `{{ route('pelanggan.transaksi.nota', ':id') }}`.replace(':id', transaksiId);
                btnDownloadPDF.href = downloadUrl;
                
                if (!notaModalInstance) {
                    notaModalInstance = new bootstrap.Modal(modalElement);
                }
                
                // Loading state
                notaContent.innerHTML = `
                    <div class="d-flex flex-column align-items-center justify-content-center py-5">
                        <div class="spinner-border text-danger mb-3" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="text-muted">Menyiapkan nota Anda...</p>
                    </div>
                `;
                
                notaModalInstance.show();
                
                // Fetch nota content
                const notaUrl = `{{ route('pelanggan.transaksi.nota', ':id') }}`.replace(':id', transaksiId);
                fetch(notaUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.text();
                })
                .then(html => {
                    notaContent.innerHTML = html;
                })
                .catch(error => {
                    notaContent.innerHTML = `
                        <div class="alert alert-danger m-4 text-center">
                            <i class="fas fa-exclamation-circle d-block mb-2" style="font-size: 2rem;"></i>
                            Gagal memuat nota. Silakan coba lagi nanti.
                        </div>
                    `;
                    console.error('Error:', error);
                });
            });
        });

        // Konfirmasi batalkan transaksi dengan SweetAlert
        document.querySelectorAll('.btn-cancel-transaction').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                const form = this.closest('.cancel-form');
                const produk = form.dataset.produk;
                const jumlah = form.dataset.jumlah;
                
                Swal.fire({
                    title: 'Batalkan Transaksi?',
                    html: `
                        <p>Anda akan membatalkan pembelian:</p>
                        <strong>${jumlah} paket ${produk}</strong>
                        <p class="mt-3" style="color: #28a745;">
                            <i class="fas fa-undo"></i> Stok produk akan dikembalikan
                        </p>
                    `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Batalkan!',
                    cancelButtonText: 'Tidak',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        function viewBuktiInjeksi(url) {
            Swal.fire({
                title: 'Bukti Injeksi Paket',
                imageUrl: url,
                imageAlt: 'Bukti Injeksi',
                width: 'auto',
                padding: '1em',
                showCloseButton: true,
                showConfirmButton: false,
                customClass: {
                    popup: 'rounded-4 shadow-lg',
                    image: 'img-fluid rounded-3 border'
                }
            });
        }
    </script>
</x-pelanggan.layouts>



