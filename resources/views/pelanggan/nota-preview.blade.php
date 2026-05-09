<div class="nota-paper">
    <!-- Header -->
    <div class="receipt-header">
        @if(isset($formData['logo']))
            <img src="{{ $formData['logo'] }}" alt="Telkomsel" class="receipt-logo">
        @endif
        <div class="receipt-title">STRUK PEMBELIAN</div>
        <div class="receipt-subtitle">RoaMAX Haji Telkomsel</div>
    </div>

    <div class="receipt-divider"></div>

    <!-- Main Content Box -->
    <div class="receipt-content-box">
        <div class="transaction-meta">
            <div class="meta-item">
                <span class="label">No. Transaksi</span>
                <span class="value">{{ $formData['id_transaksi'] }}</span>
            </div>
            <div class="meta-item">
                <span class="label">Tanggal</span>
                <span class="value">{{ \Carbon\Carbon::parse($formData['tanggal_transaksi'])->format('d/m/Y, H:i') }}</span>
            </div>
        </div>

        <div class="product-highlight">
            <div class="product-name">{{ $formData['produk_nama'] }}</div>
            
            @if(isset($formData['produk_harga']) && $formData['produk_harga'] > $formData['produk_harga_akhir'])
                <div class="product-old-price">Rp {{ number_format($formData['produk_harga'], 0, ',', '.') }}</div>
            @endif
            
            <div class="product-final-price">Rp {{ number_format($formData['produk_harga_akhir'], 0, ',', '.') }}</div>
            
            <div class="status-badge-container">
                <span class="badge-lunas">LUNAS</span>
            </div>
        </div>

        <div class="customer-info">
            <div class="info-row">
                <span>Nama Pelanggan</span>
                <strong>{{ $formData['nama_pelanggan'] }}</strong>
            </div>
            <div class="info-row">
                <span>Nomor Telepon</span>
                <strong>{{ $formData['telepon_pelanggan'] }}</strong>
            </div>
            @if(isset($formData['nomor_injeksi']) && $formData['nomor_injeksi'])
            {{-- <div class="info-row">
                <span>Nomor Injeksi</span>
                <strong style="color: #bc0007;">{{ $formData['nomor_injeksi'] }}</strong>
            </div> --}}
            @endif
            
            <div class="info-row">
                <span>Tanggal Aktivasi</span>
                <strong>{{ \Carbon\Carbon::parse($formData['aktivasi_tanggal'])->format('d M Y') }}</strong>
            </div>

            @if(isset($formData['addon_perdana']) && $formData['addon_perdana'])
            <div class="info-row">
                <span>Add-On</span>
                <strong style="color: #10b981;">Nomor Perdana Baru</strong>
            </div>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <div class="receipt-footer">
        <div class="thanks-text">Terima Kasih!</div>
        <p>Layanan Pelanggan Telkomsel</p>
        <div class="receipt-barcode">
            *** {{ substr($formData['id_transaksi'], -8) }} ***
        </div>
    </div>
</div>

<style>
    .nota-paper {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        color: #1a1c1c;
        padding: 30px;
        background: #fff;
        max-width: 450px;
        margin: 0 auto;
    }

    .receipt-header {
        text-align: center;
        margin-bottom: 20px;
    }

    .receipt-logo {
        max-height: 45px;
        margin-bottom: 12px;
    }

    .receipt-title {
        font-size: 1.25rem;
        font-weight: 800;
        color: #bc0007;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }

    .receipt-subtitle {
        font-size: 0.8rem;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .receipt-divider {
        height: 2px;
        background: #f0f0f0;
        margin: 15px 0;
    }

    .transaction-meta {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
        font-size: 0.85rem;
        background: #f8f9fa;
        padding: 10px 15px;
        border-radius: 8px;
    }

    .meta-item {
        display: flex;
        flex-direction: column;
    }

    .meta-item .label { color: #666; margin-bottom: 2px; }
    .meta-item .value { font-weight: 700; }

    .product-highlight {
        background: #fff;
        border: 2px solid #fecaca;
        border-radius: 16px;
        padding: 25px 20px;
        text-align: center;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(188, 0, 7, 0.05);
    }

    .product-name {
        font-weight: 800;
        font-size: 1.1rem;
        margin-bottom: 10px;
        color: #1a1c1c;
    }

    .product-old-price {
        font-size: 0.9rem;
        color: #a0aec0;
        text-decoration: line-through;
        margin-bottom: 5px;
    }

    .product-final-price {
        font-size: 2rem;
        font-weight: 900;
        color: #bc0007;
        margin-bottom: 15px;
    }

    .badge-lunas {
        background: #10b981;
        color: #fff;
        font-weight: 800;
        font-size: 0.8rem;
        padding: 6px 18px;
        border-radius: 50px;
        letter-spacing: 1px;
    }

    .customer-info {
        padding: 0 5px;
    }

    .info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 0.9rem;
        padding-bottom: 8px;
        border-bottom: 1px dashed #eee;
    }

    .info-row:last-child { border-bottom: none; }

    .info-row span { color: #666; }

    .receipt-footer {
        text-align: center;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 2px solid #f0f0f0;
    }

    .thanks-text {
        font-weight: 800;
        font-size: 1.1rem;
        margin-bottom: 5px;
    }

    .receipt-footer p { font-size: 0.85rem; color: #666; margin-bottom: 15px; }

    .receipt-barcode {
        font-family: 'Courier New', Courier, monospace;
        color: #ccc;
        letter-spacing: 4px;
        font-size: 0.85rem;
    }
</style>