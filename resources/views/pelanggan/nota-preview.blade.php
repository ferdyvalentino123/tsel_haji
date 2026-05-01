<div class="nota-container p-4">
    <!-- Header -->
    <div class="text-center mb-4 pb-3" style="border-bottom: 2px solid #f0f0f0;">
        <img src="{{ $formData['logo'] }}" alt="Logo" style="max-height: 60px; margin-bottom: 10px;">
        <h5 class="mb-1" style="color: #bc0007; font-weight: bold;">{{ $formData['merch_nama'] }}</h5>
        <small style="color: #666;">Detail Nota Transaksi</small>
    </div>

    <!-- Info Transaksi -->
    <div class="mb-4">
        <div class="row mb-3">
            <div class="col-6">
                <small style="color: #999;">ID Transaksi</small>
                <p class="mb-0" style="font-weight: bold; font-size: 14px;">{{ $formData['id_transaksi'] }}</p>
            </div>
            <div class="col-6 text-end">
                <small style="color: #999;">Tanggal</small>
                <p class="mb-0" style="font-weight: bold; font-size: 14px;">{{ $formData['tanggal_transaksi'] }}</p>
            </div>
        </div>
    </div>

    <!-- Detail Pelanggan -->
    <div class="mb-4 p-3" style="background: #f9f9f9; border-radius: 6px;">
        <h6 style="color: #333; font-weight: bold; margin-bottom: 12px;">DATA PELANGGAN</h6>
        <div class="row mb-2">
            <div class="col-5"><small style="color: #999;">Nama</small></div>
            <div class="col-7"><small style="font-weight: bold;">{{ $formData['nama_pelanggan'] }}</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small style="color: #999;">Telepon</small></div>
            <div class="col-7"><small style="font-weight: bold;">{{ $formData['telepon_pelanggan'] }}</small></div>
        </div>
        <div class="row">
            <div class="col-5"><small style="color: #999;">Aktivasi</small></div>
            <div class="col-7"><small style="font-weight: bold;">{{ $formData['aktivasi_tanggal'] }}</small></div>
        </div>
    </div>

    <!-- Detail Produk -->
    <div class="mb-4 p-3" style="background: #f9f9f9; border-radius: 6px;">
        <h6 style="color: #333; font-weight: bold; margin-bottom: 12px;">DETAIL PRODUK</h6>
        <div class="row mb-2">
            <div class="col-5"><small style="color: #999;">Produk</small></div>
            <div class="col-7"><small style="font-weight: bold;">{{ $formData['produk_nama'] }}</small></div>
        </div>
        <div class="row mb-2">
            <div class="col-5"><small style="color: #999;">Harga Reguler</small></div>
            <div class="col-7"><small style="font-weight: bold;">Rp {{ number_format($formData['produk_harga'], 0, ',', '.') }}</small></div>
        </div>
        <div class="row">
            <div class="col-5"><small style="color: #999;">Harga Akhir</small></div>
            <div class="col-7"><small style="font-weight: bold; color: #bc0007;">Rp {{ number_format($formData['produk_harga_akhir'], 0, ',', '.') }}</small></div>
        </div>
    </div>

    <!-- Metode Pembayaran -->
    <div class="mb-4 p-3" style="background: #f9f9f9; border-radius: 6px;">
        <h6 style="color: #333; font-weight: bold; margin-bottom: 12px;">PEMBAYARAN</h6>
        <div class="row mb-2">
            <div class="col-5"><small style="color: #999;">Metode</small></div>
            <div class="col-7"><small style="font-weight: bold;">{{ $formData['metode_pembayaran'] }}</small></div>
        </div>
        <div class="row">
            <div class="col-5"><small style="color: #999;">Injeksi</small></div>
            <div class="col-7"><small style="font-weight: bold;">{{ $formData['nomor_injeksi'] }}</small></div>
        </div>
    </div>

    <!-- Footer -->
    <div class="text-center" style="border-top: 2px solid #f0f0f0; padding-top: 15px;">
        <small style="color: #999;">Terima kasih telah mempercayai kami</small>
        <p style="margin: 8px 0; font-size: 12px; color: #666;">PONDOK HAJI Telkomsel</p>
    </div>
</div>

<style>
.nota-container {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    max-width: 100%;
}

.nota-container small {
    display: block;
}

.nota-container h6 {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

@media print {
    .nota-container {
        padding: 0 !important;
    }
    
    body {
        margin: 0;
        padding: 0;
    }
}
</style>