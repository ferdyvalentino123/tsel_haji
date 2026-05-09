<x-pelanggan.layouts>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --tsel-red: #bc0007;
            --tsel-red-light: #ff2b2b;
            --tsel-dark: #121212;
            --tsel-glass: rgba(255, 255, 255, 0.95);
            --tsel-shadow: rgba(188, 0, 7, 0.15);
        }

        body {
            font-family: 'Outfit', sans-serif;
            background-color: #fcfcfc;
            background-image: 
                radial-gradient(at 0% 0%, rgba(188, 0, 7, 0.03) 0, transparent 50%), 
                radial-gradient(at 100% 100%, rgba(188, 0, 7, 0.05) 0, transparent 50%);
            min-height: 100vh;
        }

        .payment-container {
            max-width: 550px;
            margin: 0 auto;
            padding: 40px 20px;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .payment-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .tsel-logo-container {
            width: 70px;
            height: 70px;
            background: #fff;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border: 1px solid #f0f0f0;
        }

        .payment-header h1 {
            font-size: 2rem;
            font-weight: 800;
            color: var(--tsel-dark);
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .payment-header p {
            color: #666;
            font-size: 1rem;
            font-weight: 400;
        }

        .glass-card {
            background: var(--tsel-glass);
            backdrop-filter: blur(10px);
            border-radius: 28px;
            padding: 30px;
            border: 1px solid rgba(255, 255, 255, 0.7);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
            margin-bottom: 25px;
            position: relative;
            overflow: hidden;
        }

        .glass-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(90deg, var(--tsel-red), var(--tsel-red-light));
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(245, 127, 23, 0.1);
            color: #f57f17;
            padding: 6px 14px;
            border-radius: 100px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 20px;
        }

        .info-group {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .info-tile {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .info-tile .label {
            color: #888;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .info-tile .value {
            color: var(--tsel-dark);
            font-weight: 600;
            font-size: 1rem;
        }

        .package-badge {
            background: #fdf2f2;
            color: var(--tsel-red);
            padding: 4px 12px;
            border-radius: 8px;
            font-weight: 700;
        }

        .price-showcase {
            margin-top: 30px;
            padding: 25px;
            background: linear-gradient(135deg, #fdfdfd 0%, #f7f7f7 100%);
            border-radius: 20px;
            border: 1px solid #eee;
            text-align: center;
        }

        .price-showcase .label {
            color: #999;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }

        .price-showcase .amount {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--tsel-red);
            line-height: 1;
        }

        .btn-pay {
            background: linear-gradient(135deg, var(--tsel-red) 0%, var(--tsel-red-light) 100%);
            color: #fff;
            border: none;
            width: 100%;
            padding: 20px;
            border-radius: 20px;
            font-size: 1.15rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 25px rgba(188, 0, 7, 0.3);
            text-decoration: none;
        }

        .btn-pay:hover {
            transform: scale(1.03) translateY(-3px);
            box-shadow: 0 15px 35px rgba(188, 0, 7, 0.4);
            color: #fff;
        }

        .btn-pay:active {
            transform: scale(0.98);
        }

        .security-footer {
            text-align: center;
            margin-top: 30px;
        }

        .security-footer p {
            font-size: 0.85rem;
            color: #aaa;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #999;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s;
        }

        .back-link:hover {
            color: var(--tsel-red);
        }

        /* Mobile Optimization */
        @media (max-width: 480px) {
            .payment-container {
                padding: 20px 15px;
            }
            
            .tsel-logo-container {
                width: 50px;
                height: 50px;
                border-radius: 15px;
                margin-bottom: 15px;
            }

            .tsel-logo-container img {
                width: 30px;
            }

            .payment-header h1 {
                font-size: 1.3rem;
            }

            .payment-header p {
                font-size: 0.8rem;
            }

            .glass-card {
                padding: 18px;
                border-radius: 20px;
                margin-bottom: 15px;
            }

            .info-tile {
                flex-direction: row;
                align-items: flex-start;
                gap: 12px;
            }

            .info-tile .label {
                font-size: 0.75rem;
                flex-shrink: 0;
                width: 35%;
            }

            .info-tile .value {
                font-size: 0.85rem;
                text-align: right;
                word-break: break-word;
                line-height: 1.3;
            }

            .package-badge {
                padding: 1px 6px;
                display: inline-block;
                font-size: 0.8rem;
            }

            .price-showcase {
                margin-top: 15px;
                padding: 12px;
            }

            .price-showcase .amount {
                font-size: 1.6rem;
            }

            .btn-pay {
                padding: 14px;
                font-size: 0.95rem;
                border-radius: 15px;
            }
            
            .status-pill {
                padding: 4px 10px;
                font-size: 0.7rem;
                margin-bottom: 15px;
            }
        }
    </style>

    <div class="payment-container">
        <!-- Header -->
        <div class="payment-header">
            <div class="tsel-logo-container">
                <img src="{{ asset('admin_asset/img/photos/icon_telkomsel.png') }}" alt="Tsel" width="40">
            </div>
            <h1>Konfirmasi Checkout</h1>
            <p>Selesaikan pembayaran untuk mengaktifkan paket</p>
        </div>

        @if(session('error'))
        <div class="alert alert-danger rounded-4 border-0 shadow-sm mb-4" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
        </div>
        @endif

        <!-- Main Card -->
        <div class="glass-card">
            <div class="text-center">
                <div class="status-pill">
                    <i class="fas fa-clock"></i> Menunggu Pembayaran
                </div>
            </div>

            <div class="info-group">
                <div class="info-tile">
                    <span class="label">ID Transaksi</span>
                    <span class="value text-muted">#{{ $transaksi->id_transaksi }}</span>
                </div>
                <div class="info-tile">
                    <span class="label">Paket Data</span>
                    <span class="value"><span class="package-badge">{{ $transaksi->produk->produk_nama }}</span></span>
                </div>
                <div class="info-tile">
                    <span class="label">Nomor Tujuan</span>
                    <span class="value">{{ $transaksi->telepon_pelanggan }}</span>
                </div>
                <div class="info-tile">
                    <span class="label">Tanggal Aktivasi</span>
                    <span class="value">{{ \Carbon\Carbon::parse($transaksi->aktivasi_tanggal)->translatedFormat('d F Y') }}</span>
                </div>
            </div>

            <div class="price-showcase">
                <div class="label">Total Tagihan</div>
                <div class="amount">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Action Button -->
        <button type="button" id="pay-button" class="btn-pay">
            <i class="fas fa-shield-check"></i> Bayar Sekarang
        </button>

        <div class="text-center">
            <a href="{{ route('pelanggan.riwayat-transaksi') }}" class="back-link">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Riwayat
            </a>
        </div>

        <!-- Security Footer -->
        <div class="security-footer">
            <p>
                <i class="fas fa-lock"></i>
                Pembayaran aman & terenkripsi oleh <strong>Midtrans</strong>
            </p>
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
                    confirmButtonColor: '#bc0007'
                });
                return;
            }

            // Disable button
            payButton.disabled = true;
            payButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';

            // Open Midtrans Snap
            snap.pay(snapToken, {
                onSuccess: function(result) {
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
                    Swal.fire({
                        icon: 'info',
                        title: 'Pembayaran Pending',
                        text: 'Pembayaran Anda sedang diproses. Silakan selesaikan pembayaran.',
                        confirmButtonColor: '#bc0007'
                    }).then(() => {
                        window.location.href = '{{ route("pelanggan.riwayat-transaksi") }}';
                    });
                },
                onError: function(result) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Pembayaran Gagal',
                        text: 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.',
                        confirmButtonColor: '#d33'
                    });
                    payButton.disabled = false;
                    payButton.innerHTML = '<i class="fas fa-shield-check"></i> Bayar Sekarang';
                },
                onClose: function() {
                    payButton.disabled = false;
                    payButton.innerHTML = '<i class="fas fa-shield-check"></i> Bayar Sekarang';
                    Swal.fire({
                        icon: 'info',
                        title: 'Pembayaran Dibatalkan',
                        text: 'Anda menutup halaman pembayaran.',
                        confirmButtonColor: '#bc0007'
                    });
                }
            });
        });
    </script>
</x-pelanggan.layouts>
