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

        .page-header>* {
            position: relative;
            z-index: 1;
        }

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

        .product-info-card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--tsel-border);
        }

        .product-showcase {
            text-align: center;
            padding: 24px;
            background: var(--tsel-gray);
            border-radius: 12px;
            margin-bottom: 24px;
            border: 1px solid var(--tsel-border);
        }

        .product-icon-large {
            width: 90px;
            height: 90px;
            background: rgba(188, 0, 7, 0.05);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
            font-size: 3rem;
            color: var(--tsel-primary);
        }

        .product-name-large {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--tsel-dark);
            margin-bottom: 10px;
        }

        .product-price-large {
            font-size: 2rem;
            font-weight: 800;
            color: var(--tsel-primary);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 15px;
        }

        .info-item {
            background: #fff;
            padding: 15px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid var(--tsel-border);
        }

        .info-item i {
            font-size: 2rem;
            color: var(--tsel-primary);
            margin-bottom: 8px;
        }

        .info-item-label {
            font-size: 0.85rem;
            color: #666;
            margin-bottom: 5px;
        }

        .info-item-value {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--tsel-dark);
        }

        .purchase-form {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.04);
            border: 1px solid var(--tsel-border);
        }

        .form-label {
            font-weight: 600;
            color: var(--tsel-dark);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
        }

        .form-label i {
            color: var(--tsel-primary);
        }

        .form-control {
            border: 1px solid var(--tsel-border);
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: var(--tsel-gray);
        }

        .form-control:focus {
            border-color: var(--tsel-primary);
            box-shadow: 0 0 0 0.2rem rgba(188, 0, 7, 0.1);
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .btn-quantity {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            border: 1px solid var(--tsel-border);
            background: #fff;
            color: var(--tsel-dark);
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-quantity:hover {
            background: var(--tsel-gray);
            border-color: var(--tsel-primary);
            color: var(--tsel-primary);
        }

        .quantity-display {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--tsel-dark);
            min-width: 60px;
            text-align: center;
        }

        .total-section {
            background: var(--tsel-gray);
            border-radius: 12px;
            padding: 20px;
            margin: 24px 0;
            border: 1px solid var(--tsel-border);
        }

        .total-label {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 5px;
        }

        .total-amount {
            font-size: 2.2rem;
            font-weight: 800;
            color: var(--tsel-primary);
            line-height: 1;
        }

        .btn-submit {
            background: linear-gradient(135deg, var(--tsel-primary) 0%, var(--tsel-primary-light) 100%);
            color: #fff;
            border: none;
            padding: 15px 30px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 1.1rem;
            width: 100%;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(188, 0, 7, 0.2);
            color: #fff;
        }

        .btn-back {
            background: #fff;
            color: var(--tsel-dark);
            border: 1px solid var(--tsel-border);
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            margin-top: 12px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-back:hover {
            background: var(--tsel-gray);
            color: var(--tsel-dark);
            border-color: #ccc;
        }

        .alert-info-custom {
            background: rgba(188, 0, 7, 0.03);
            color: var(--tsel-dark);
            border: 1px solid rgba(188, 0, 7, 0.1);
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 24px;
            font-size: 0.95rem;
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .alert-info-custom i {
            font-size: 1.2rem;
            color: var(--tsel-primary);
            margin-top: 2px;
        }

        /* Mobile specific styling to make it compact */
        @media (max-width: 768px) {
            .page-header {
                padding: 20px 15px;
                border-radius: 12px;
            }

            .page-header h1 {
                font-size: 1.4rem;
            }

            .page-header p {
                font-size: 0.85rem;
            }

            .product-info-card {
                padding: 15px;
                border-radius: 12px;
            }

            .product-showcase {
                padding: 15px;
                margin-bottom: 15px;
            }

            .product-icon-large {
                width: 60px;
                height: 60px;
                font-size: 2rem;
                margin-bottom: 10px;
            }

            .product-name-large {
                font-size: 1.25rem;
                margin-bottom: 5px;
            }

            .product-price-large {
                font-size: 1.6rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .info-item {
                padding: 12px;
                display: flex;
                align-items: center;
                text-align: left;
                gap: 15px;
                border-radius: 10px;
            }

            .info-item i {
                font-size: 1.6rem;
                margin-bottom: 0;
            }

            .info-item div {
                flex: 1;
            }

            .info-item-label {
                margin-bottom: 0;
                font-size: 0.8rem;
            }

            .info-item-value {
                font-size: 1rem;
            }

            .purchase-form {
                padding: 15px;
                border-radius: 12px;
            }

            .form-control {
                padding: 10px 12px;
                font-size: 0.95rem;
            }

            .quantity-controls {
                justify-content: center;
            }

            .total-section {
                padding: 15px;
                margin: 20px 0;
            }

            .total-label {
                font-size: 0.95rem;
            }

            .total-amount {
                font-size: 1.8rem;
            }

            .btn-submit {
                padding: 12px 20px;
                font-size: 1rem;
            }

            .btn-back {
                padding: 10px 20px;
                font-size: 0.95rem;
            }
        }
    </style>

    <!-- Page Header -->
    <div class="page-header">
        <h1><i class="fas fa-shopping-cart"></i> Beli Paket Kuota</h1>
        <p>Lengkapi informasi pembelian di bawah ini</p>
    </div>

    <!-- Product Info -->
    <div class="product-info-card">
        <div class="product-showcase">
            <div class="product-icon-large">
                <i class="fas fa-sim-card"></i>
            </div>
            <h2 class="product-name-large">{{ $produk->produk_nama }}</h2>
            <div class="product-price-large">
                Rp {{ number_format($produk->produk_harga, 0, ',', '.') }}
            </div>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <i class="fas fa-database"></i>
                <div class="info-item-label">Detail Paket</div>
                <div class="info-item-value">{{ $produk->produk_detail ?? 'Lihat detail' }}</div>
            </div>
            <div class="info-item">
                <i class="fas fa-calendar-check"></i>
                <div class="info-item-label">Masa Aktif</div>
                <div class="info-item-value">30 Hari</div>
            </div>
        </div>
    </div>

    <!-- Purchase Form -->
    <div class="purchase-form">
        <div class="alert-info-custom">
            <i class="fas fa-info-circle"></i>
            <strong>Informasi:</strong> Pastikan pembelian sesuai kebutuhan Anda. Setelah transaksi diproses, tim kami
            akan menghubungi Anda untuk konfirmasi paket telah aktif.
        </div>

        <form action="{{ route('pelanggan.transaksi.process') }}" method="POST" id="purchaseForm">
            @csrf
            <input type="hidden" name="produk_id" value="{{ $produk->id }}">

            <div class="mb-4">
                <label class="form-label">
                    <i class="fas fa-user"></i> Nama Pelanggan
                </label>
                <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
            </div>

            <div class="mb-4">
                <label class="form-label">
                    <i class="fas fa-envelope"></i> Email
                </label>
                <input type="email" class="form-control" value="{{ Auth::user()->email }}" readonly>
            </div>

            <div class="form-group mb-4">
                <label for="nomor_telepon" class="form-label">
                    <i class="fas fa-phone"></i> Nomor Telepon (Target Injeksi)
                </label>
                <input type="tel" name="nomor_telepon" id="nomor_telepon" class="form-control"
                    value="{{ Auth::user()->phone }}" readonly required>
                <small class="text-muted">Paket data akan langsung dikirim ke nomor profil Anda.</small>
            </div>

            <div class="form-group mb-4">
                <label for="aktivasi_tanggal" class="form-label">
                    <i class="fas fa-calendar-alt"></i> Tanggal Aktivasi Paket
                </label>
                <input type="date" name="aktivasi_tanggal" id="aktivasi_tanggal" class="form-control"
                    min="{{ date('Y-m-d') }}" value="{{ date('Y-m-d') }}" required>
                <small class="text-muted">Pilih tanggal kapan paket RoaMAX Anda ingin mulai diaktifkan.</small>
            </div>
            {{-- <div class="mb-4">
                <label class="form-label">
                    <i class="fas fa-shopping-basket"></i> Jumlah Pembelian
                </label>
                <div class="quantity-controls">
                    <button type="button" class="btn-quantity" onclick="decreaseQuantity()">
                        <i class="fas fa-minus"></i>
                    </button>
                    <div class="quantity-display" id="quantityDisplay">1</div>
                    <button type="button" class="btn-quantity" onclick="increaseQuantity()">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                <input type="hidden" name="jumlah" id="jumlahInput" value="1">
                <small class="text-muted">Maksimal pembelian: {{ $produk->produk_stok }} paket</small>
            </div> --}}

            <div class="total-section text-center">
                <div class="total-label">Total Pembayaran</div>
                <div class="total-amount" id="totalAmount">
                    Rp {{ number_format($produk->produk_harga, 0, ',', '.') }}
                </div>
            </div>

            <button type="submit" class="btn btn-submit">
                <i class="fas fa-check-circle"></i> Konfirmasi Pembelian
            </button>
            <a href="{{ route('pelanggan.home') }}" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </form>
    </div>

    <script>
        const maxStock = {{ $produk->produk_stok }};
        const basePrice = {{ $produk->produk_harga }};
        let currentQuantity = 1;

        function updateDisplay() {
            document.getElementById('quantityDisplay').textContent = currentQuantity;
            document.getElementById('jumlahInput').value = currentQuantity;

            const totalPrice = basePrice * currentQuantity;
            document.getElementById('totalAmount').textContent =
                'Rp ' + totalPrice.toLocaleString('id-ID');
        }

        function increaseQuantity() {
            if (currentQuantity < maxStock) {
                currentQuantity++;
                updateDisplay();
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Stok Terbatas',
                    text: 'Jumlah pembelian tidak boleh melebihi stok yang tersedia',
                    confirmButtonColor: '#bc0007'
                });
            }
        }

        function decreaseQuantity() {
            if (currentQuantity > 1) {
                currentQuantity--;
                updateDisplay();
            }
        }

        document.getElementById('purchaseForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const activationDate = document.getElementById('aktivasi_tanggal').value;
            const formattedDate = new Date(activationDate).toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

            Swal.fire({
                title: 'Konfirmasi Pembelian',
                html: `
                    <p>Anda akan membeli:</p>
                    <strong>{{ $produk->produk_nama }}</strong><br>
                    <strong>Tanggal Aktivasi: ${formattedDate}</strong><br>
                    <strong>Total Bayar: Rp ${basePrice.toLocaleString('id-ID')}</strong>
                `,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#bc0007',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Beli Sekarang!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    </script>

</x-pelanggan.layouts>
