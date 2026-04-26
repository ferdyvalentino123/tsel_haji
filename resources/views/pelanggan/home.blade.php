<x-pelanggan.layouts>
    <style>
        :root {
            --tsel-primary: #bc0007;      /* Dari login page */
            --tsel-primary-light: #e2241d; /* Dari login page */
            --tsel-dark: #1a1c1c;         /* Text dark */
            --tsel-gray: #f9f9f9;         /* Surface */
            --tsel-border: #e2e2e2;       /* Surface variant */
            --tsel-text-muted: #5d5e60;   /* Secondary */
        }

        body {
            background-color: var(--tsel-gray);
        }

        .welcome-banner {
            background: linear-gradient(135deg, var(--tsel-primary) 0%, var(--tsel-primary-light) 100%);
            border-radius: 16px;
            padding: 40px;
            color: #fff;
            margin-bottom: 40px;
            box-shadow: 0 10px 30px rgba(188, 0, 7, 0.2);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
        }

        /* Subtle Islamic Pattern overlay for banner */
        .welcome-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M30 0l2.5 12.5L45 15l-12.5 2.5L30 30l-2.5-12.5L15 15l12.5-2.5L30 0zm0 30l2.5 12.5L45 45l-12.5 2.5L30 60l-2.5-12.5L15 45l12.5-2.5L30 30z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
            z-index: 0;
            pointer-events: none;
        }

        .welcome-banner-content {
            position: relative;
            z-index: 1;
            flex: 1;
        }

        .welcome-banner h1 {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 12px;
            color: #ffffff;
            letter-spacing: -0.5px;
        }

        .welcome-banner p {
            font-size: 1.1rem;
            margin-bottom: 0;
            opacity: 0.9;
            font-weight: 400;
            line-height: 1.6;
        }

        .welcome-icon {
            font-size: 5rem;
            color: #fff;
            opacity: 0.1;
            position: absolute;
            right: 40px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 0;
        }

        .section-title {
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--tsel-dark);
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title i {
            color: var(--tsel-primary);
        }

        .category-wrapper {
            margin-bottom: 40px;
        }

        .category-title {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--tsel-border);
        }

        .category-title h3 {
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--tsel-dark);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .category-title h3 i {
            color: var(--tsel-primary);
            font-size: 1.2rem;
        }

        .badge-count {
            background: #f1f1f1;
            color: var(--tsel-text-muted);
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 600;
            margin-left: 15px;
            border: 1px solid var(--tsel-border);
        }

        .product-card {
            background: #fff;
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
            border: 1px solid var(--tsel-border);
            height: 100%;
            display: flex;
            flex-direction: column;
            position: relative;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(188, 0, 7, 0.08);
            border-color: var(--tsel-primary-light);
        }

        .product-icon {
            width: 56px;
            height: 56px;
            background: rgba(188, 0, 7, 0.05);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            font-size: 1.8rem;
            color: var(--tsel-primary);
        }

        .product-title {
            font-size: 1.15rem;
            font-weight: 700;
            color: var(--tsel-dark);
            margin-bottom: 15px;
            line-height: 1.4;
            min-height: 48px;
            display: flex;
            align-items: flex-start;
        }

        .product-detail {
            background: var(--tsel-gray);
            border-radius: 10px;
            padding: 16px;
            margin-bottom: 20px;
            flex-grow: 1;
            border: 1px solid var(--tsel-border);
        }

        .product-detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
        }

        .product-detail-item:not(:last-child) {
            border-bottom: 1px dashed #d1d5db;
        }

        .product-detail-label {
            font-weight: 500;
            color: var(--tsel-text-muted);
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.9rem;
        }

        .product-detail-value {
            font-weight: 700;
            color: var(--tsel-dark);
            font-size: 0.95rem;
            text-align: right;
        }

        .product-price-section {
            margin-bottom: 20px;
        }

        .product-price-original {
            font-size: 0.9rem;
            color: #999;
            text-decoration: line-through;
            margin-bottom: 4px;
            font-weight: 500;
        }

        .price-current {
            font-size: 1.6rem;
            font-weight: 800;
            color: var(--tsel-primary);
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            line-height: 1;
        }

        .discount-badge {
            display: inline-block;
            background: var(--tsel-primary-light);
            color: #fff;
            padding: 4px 10px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.75rem;
        }

        .stock-badge-container {
            position: absolute;
            top: 24px;
            right: 24px;
        }

        .stock-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #e8f5e9;
            color: #2e7d32;
            padding: 4px 10px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .stock-badge.low-stock {
            background: #ffebee;
            color: var(--tsel-primary);
        }

        .btn-buy {
            background: var(--tsel-primary);
            color: #fff;
            border: none;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-buy:hover {
            background: #93000a;
            color: #fff;
        }

        .btn-buy:disabled, .btn-buy.disabled {
            background: #e2e2e2;
            color: #a0a0a0;
            cursor: not-allowed;
            pointer-events: none;
        }

        .info-banner {
            background: #fff;
            border: 1px solid var(--tsel-border);
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            margin-top: 40px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            position: relative;
            overflow: hidden;
        }

        .info-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--tsel-primary) 0%, var(--tsel-primary-light) 100%);
        }

        .info-banner h3 {
            font-weight: 700;
            margin-bottom: 12px;
            font-size: 1.4rem;
            color: var(--tsel-dark);
        }

        .info-banner p {
            font-size: 1rem;
            margin-bottom: 0;
            line-height: 1.6;
            color: var(--tsel-text-muted);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: #fff;
            border-radius: 16px;
            border: 1px dashed #ccc;
            margin-bottom: 30px;
        }

        .empty-state i {
            font-size: 4rem;
            color: #e0e0e0;
            margin-bottom: 15px;
        }

        .empty-state h3 {
            color: var(--tsel-dark);
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .empty-state p {
            color: var(--tsel-text-muted);
        }

        @media (max-width: 768px) {
            .welcome-banner {
                padding: 20px;
                text-align: center;
                margin-bottom: 25px;
                border-radius: 12px;
            }
            .welcome-icon {
                display: none;
            }
            .welcome-banner h1 {
                font-size: 1.35rem;
                margin-bottom: 10px;
            }
            .welcome-banner p {
                font-size: 0.9rem;
                line-height: 1.4;
            }
            .section-title {
                font-size: 1.2rem;
                margin-bottom: 20px;
            }
            .category-title {
                margin-bottom: 15px;
            }
            .category-title h3 {
                font-size: 1.1rem;
            }
            .product-card {
                padding: 16px;
            }
            .product-icon {
                width: 44px;
                height: 44px;
                font-size: 1.3rem;
                margin-bottom: 15px;
            }
            .product-title {
                font-size: 0.95rem;
                min-height: auto;
                margin-bottom: 10px;
            }
            .product-detail {
                padding: 12px;
            }
            .product-detail-label, .product-detail-value {
                font-size: 0.8rem;
            }
            .price-current {
                font-size: 1.2rem;
            }
            .discount-badge {
                font-size: 0.7rem;
                padding: 3px 8px;
            }
            .btn-buy {
                padding: 10px 15px;
                font-size: 0.9rem;
            }
            .stock-badge {
                font-size: 0.75rem;
            }
            .stock-badge-container {
                position: relative;
                top: 0;
                right: 0;
                margin-bottom: 15px;
                display: flex;
                justify-content: flex-start;
            }
            .info-banner {
                padding: 20px;
                margin-top: 25px;
            }
            .info-banner h3 {
                font-size: 1.1rem;
            }
            .info-banner p {
                font-size: 0.85rem;
            }
        }

        /* Background Decorations */
        .bg-decorations {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
            pointer-events: none;
        }

        .bg-icon {
            position: absolute;
            color: var(--tsel-primary);
            opacity: 0.03;
            animation: float-icon 8s ease-in-out infinite;
        }

        .icon-1 { top: 15%; left: 5%; font-size: 8rem; animation-delay: 0s; }
        .icon-2 { top: 60%; right: 5%; font-size: 16rem; animation-delay: -2s; }
        .icon-3 { bottom: 10%; left: 15%; font-size: 6rem; animation-delay: -4s; }
        .icon-4 { top: 25%; right: 20%; font-size: 5rem; animation-delay: -1s; }
        .icon-5 { top: 45%; left: 30%; font-size: 4rem; animation-delay: -3s; }

        @keyframes float-icon {
            0% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
            100% { transform: translateY(0px) rotate(0deg); }
        }
    </style>

    <!-- Background Decorations -->
    <div class="bg-decorations">
        <i class="fas fa-plane-departure bg-icon icon-1"></i>
        <i class="fas fa-kaaba bg-icon icon-2"></i>
        <i class="fas fa-moon bg-icon icon-3"></i>
        <i class="fas fa-star bg-icon icon-4"></i>
        <i class="fas fa-cloud bg-icon icon-5"></i>
    </div>

    <!-- Welcome Banner -->
    <div class="welcome-banner">
        <div class="welcome-banner-content">
            <h1><i class="fas fa-kaaba"></i> Assalamu'alaikum, {{ Auth::user()->name }}</h1>
            <p>Portal Pelanggan <strong>Telkomsel RoaMAX Haji</strong>. Tersedia berbagai pilihan paket kuota untuk kebutuhan komunikasi Anda di Tanah Suci.</p>
        </div>
        <i class="fas fa-mosque welcome-icon"></i>
    </div>

    <!-- Products Section -->
    <h2 class="section-title">
        <i class="fas fa-box"></i> Pilihan Paket RoaMAX Haji
    </h2>

    @if($produks->count() > 0)
    @php
        // Kelompokkan produk berdasarkan kategori
        $kategoris = [
            'SHAFIRA' => [],
            'TAKHOBAR' => [],
            'MUHAMMADIYAH' => []
        ];
        
        foreach($produks as $produk) {
            if(str_starts_with($produk->produk_nama, 'SHAFIRA')) {
                $kategoris['SHAFIRA'][] = $produk;
            } elseif(str_starts_with($produk->produk_nama, 'TAKHOBAR')) {
                $kategoris['TAKHOBAR'][] = $produk;
            } elseif(str_starts_with($produk->produk_nama, 'MUHAMMADIYAH') || str_starts_with($produk->produk_nama, 'MUHAMMDIYAH')) {
                $kategoris['MUHAMMADIYAH'][] = $produk;
            }
        }
    @endphp

    @foreach($kategoris as $kategori => $produkList)
        @if(count($produkList) > 0)
        <!-- Kategori Ditampilkan Secara Elegan -->
        <div class="category-wrapper">
            <div class="category-title">
                <h3>
                    <i class="fas fa-layer-group"></i> 
                    Paket {{ ucfirst($kategori) }}
                </h3>
                <span class="badge-count">{{ count($produkList) }} Pilihan</span>
            </div>
            
            <div class="row">
                @foreach($produkList as $produk)
                <div class="col-lg-4 col-md-6 mb-4 d-flex align-items-stretch">
                    <div class="product-card w-100">


                        <div class="product-icon">
                            <i class="fas fa-sim-card"></i>
                        </div>
                        


                        <h3 class="product-title">{{ str_replace($kategori.'_', '', $produk->produk_nama) }}</h3>

                        <div class="product-detail">
                            <div class="product-detail-item">
                                <span class="product-detail-label">
                                    <i class="fas fa-database"></i> Kuota
                                </span>
                                <span class="product-detail-value">
                                    {{ $produk->produk_detail ?? 'Lihat detail' }}
                                </span>
                            </div>
                            <div class="product-detail-item">
                                <span class="product-detail-label">
                                    <i class="fas fa-calendar-check"></i> Masa Aktif
                                </span>
                                <span class="product-detail-value">
                                    30 Hari
                                </span>
                            </div>
                        </div>

                        <div class="product-price-section">
                            @if($produk->produk_diskon > 0)
                                <span class="product-price-original">
                                    Rp {{ number_format($produk->produk_harga, 0, ',', '.') }}
                                </span>
                                @php
                                    $harga_setelah_diskon = $produk->produk_harga - $produk->produk_diskon;
                                @endphp
                                <div class="price-current">
                                    Rp {{ number_format($harga_setelah_diskon, 0, ',', '.') }}
                                    <span class="discount-badge">
                                        Hemat Rp {{ number_format($produk->produk_diskon / 1000, 0) }}k
                                    </span>
                                </div>
                            @else
                                <div class="price-current">Rp {{ number_format($produk->produk_harga, 0, ',', '.') }}</div>
                            @endif
                        </div>

                        @if($produk->produk_stok > 0)
                            <a href="{{ route('pelanggan.produk.beli', $produk->id) }}" class="btn-buy mt-auto">
                                <i class="fas fa-shopping-cart"></i> Pilih Paket
                            </a>
                        @else
                            <button class="btn-buy disabled mt-auto" disabled>
                                <i class="fas fa-times-circle"></i> Stok Habis
                            </button>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    @endforeach

    @else
    <div class="empty-state">
        <i class="fas fa-box-open"></i>
        <h3>Belum ada produk</h3>
        <p>Silakan cek kembali halaman ini nanti untuk produk paket RoaMAX Haji terbaru.</p>
    </div>
    @endif

    <!-- Info Banner -->
    <div class="info-banner">
        <h3><i class="fas fa-headset" style="color: var(--tsel-primary);"></i> Pusat Bantuan</h3>
        <p>Hubungi CS kami di <strong>188</strong> (Bebas Pulsa) atau email ke <strong>cs@telkomsel.co.id</strong>.<br>Kami siap membantu Anda 24 jam penuh.</p>
    </div>

</x-pelanggan.layouts>
