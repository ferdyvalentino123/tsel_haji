<x-pelanggan.layouts>
    <style>
        .payment-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .payment-header {
            background: linear-gradient(135deg, #ec1c24 0%, #ff6b35 50%, #ffa726 100%);
            border-radius: 20px;
            padding: 30px;
            color: #fff;
            text-align: center;
            margin-bottom: 30px;
        }

        .payment-header h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .payment-card {
            background: #fff;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .payment-section-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #ec1c24;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }

        .order-summary {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #e0e0e0;
        }

        .order-item:last-child {
            border-bottom: none;
            padding-top: 15px;
            font-size: 1.2rem;
            font-weight: 700;
            color: #ec1c24;
        }

        .status-badge {
            background: #fff3cd;
            color: #856404;
            padding: 10px 20px;
            border-radius: 25px;
            font-weight: 600;
            display: inline-block;
        }

        .btn-pay-now {
            background: linear-gradient(135deg, #ec1c24 0%, #ff6b35 100%);
            color: #fff;
            border: none;
            padding: 18px 50px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1.2rem;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .btn-pay-now:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(255, 107, 53, 0.5);
            color: #fff;
        }

        .payment-info {
            background: #fdecea;
            border-left: 4px solid #ec1c24;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
        }

        .payment-info p {
            margin: 0;
            color: #b70f16;
        }
    </style>

    <div class="payment-container">
        <!-- Header -->
        <div class="payment-header">
            <h1><i class="fas fa-credit-card"></i> Pembayaran</h1>
            <p class="mb-0">Selesaikan pembayaran Anda dengan mudah dan aman</p>
        </div>

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Order Summary -->
        <div class="payment-card">
            <h3 class="payment-section-title">
                <i class="fas fa-shopping-cart"></i> Ringkasan Pesanan
            </h3>
            
            <div class="order-summary">
                <div class="order-item">
                    <span><strong>ID Transaksi:</strong></span>
                    <span>{{ $transaksi->id_transaksi }}</span>
                </div>
                <div class="order-item">
                    <span><strong>Produk:</strong></span>
                    <span>{{ $transaksi->produk->produk_nama }}</span>
                </div>
                <div class="order-item">
                    <span><strong>Jumlah:</strong></span>
                    <span>{{ $transaksi->jumlah }} Paket</span>
                </div>
                <div class="order-item">
                    <span><strong>Harga Satuan:</strong></span>
                    <span>Rp {{ number_format($transaksi->total_harga / $transaksi->jumlah, 0, ',', '.') }}</span>
                </div>
                <div class="order-item">
                    <span><strong>Total Pembayaran:</strong></span>
                    <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>

            <div class="text-center mt-3">
                <span class="status-badge">
                    <i class="fas fa-clock"></i> Menunggu Pembayaran
                </span>
            </div>
        </div>

        <!-- Payment Method -->
        <div class="payment-card">
            <h3 class="payment-section-title">
                <i class="fas fa-credit-card"></i> Pilih Metode Pembayaran
            </h3>

            <div class="payment-info">
                <p><i class="fas fa-info-circle"></i> <strong>Anda akan diarahkan ke halaman pembayaran Midtrans</strong></p>
                <p class="mt-2">Pilih metode pembayaran favorit Anda (GoPay, OVO, Dana, ShopeePay, LinkAja, dll)</p>
                <p class="mt-2"><i class="fas fa-clock"></i> <strong>Tenang!</strong> Jika Anda keluar dari halaman ini, Anda bisa lanjutkan pembayaran kapan saja dari menu <strong>Riwayat Transaksi</strong></p>
            </div>

            <button type="button" id="pay-button" class="btn btn-pay-now">
                <i class="fas fa-credit-card"></i> Bayar Sekarang
            </button>

            <div class="text-center mt-4">
                <a href="{{ route('pelanggan.riwayat-transaksi') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali ke Riwayat
                </a>
            </div>

            <div class="text-center mt-3">
                <small class="text-muted">
                    <i class="fas fa-shield-alt"></i> Pembayaran Anda aman dan terenkripsi dengan Midtrans
                </small>
            </div>
        </div>
    </div>

    <!-- Midtrans Snap.js -->
    <script src="@if(config('services.midtrans.is_production')){{ 'https://app.midtrans.com/snap/snap.js' }}@else{{ 'https://app.sandbox.midtrans.com/snap/snap.js' }}@endif" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    
    <script>
        const payButton = document.getElementById('pay-button');
        const snapToken = '{{ $snapToken }}';

        payButton.addEventListener('click', function() {
            if (!snapToken) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Token pembayaran tidak valid. Silakan coba lagi.',
                    confirmButtonColor: '#2575FC'
                });
                return;
            }

            // Disable button
            payButton.disabled = true;
            payButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

            // Open Midtrans Snap
            snap.pay(snapToken, {
                onSuccess: function(result) {
                    console.log('Payment success:', result);
                    Swal.fire({
                        icon: 'success',
                        title: 'Pembayaran Berhasil!',
                        text: 'Terima kasih atas pembayaran Anda.',
                        confirmButtonColor: '#21e23e'
                    }).then(() => {
                        window.location.href = '{{ route("pelanggan.pembayaran.callback", $transaksi->id) }}';
                    });
                },
                onPending: function(result) {
                    console.log('Payment pending:', result);
                    Swal.fire({
                        icon: 'info',
                        title: 'Pembayaran Pending',
                        text: 'Pembayaran Anda sedang diproses. Silakan selesaikan pembayaran.',
                        confirmButtonColor: '#2575FC'
                    }).then(() => {
                        window.location.href = '{{ route("pelanggan.riwayat-transaksi") }}';
                    });
                },
                onError: function(result) {
                    console.log('Payment error:', result);
                    Swal.fire({
                        icon: 'error',
                        title: 'Pembayaran Gagal',
                        text: 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.',
                        confirmButtonColor: '#d33'
                    });
                    
                    // Re-enable button
                    payButton.disabled = false;
                    payButton.innerHTML = '<i class="fas fa-credit-card"></i> Bayar Sekarang';
                },
                onClose: function() {
                    console.log('Payment popup closed');
                    
                    // Re-enable button
                    payButton.disabled = false;
                    payButton.innerHTML = '<i class="fas fa-credit-card"></i> Bayar Sekarang';
                    
                    Swal.fire({
                        icon: 'info',
                        title: 'Pembayaran Dibatalkan',
                        text: 'Anda menutup halaman pembayaran. Silakan coba lagi jika ingin melanjutkan.',
                        confirmButtonColor: '#2575FC'
                    });
                }
            });
        });
    </script>

</x-pelanggan.layouts>
