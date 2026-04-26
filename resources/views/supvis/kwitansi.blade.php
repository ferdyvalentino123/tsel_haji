<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi Pembayaran - {{ $formData['id_transaksi'] }}</title>
    <style>
        @page {
            size: 80mm auto; /* Format printer thermal 80mm */
            margin: 0;
        }

        body {
            font-family: 'Helvetica Neue', 'Helvetica', Arial, sans-serif;
            width: 76mm; 
            margin: 0 auto;
            padding: 4mm 2mm;
            background: #fff;
            color: #1a1a1a;
            font-size: 14px;
            line-height: 1.4;
        }

        .receipt-container {
            width: 100%;
            margin: 0 auto;
            background: #fff;
        }

        .header {
            text-align: center;
            border-bottom: 2px dashed #cccccc;
            padding-bottom: 15px;
            margin-bottom: 12px;
        }

        .header img {
            max-width: 90px;
            margin-bottom: 8px;
        }

        .header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 800;
            color: #ec1c24; /* Merah Telkomsel */
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .header p {
            margin: 6px 0 0 0;
            font-size: 13px;
            color: #555;
            text-transform: uppercase;
            font-weight: bold;
        }

        .divider {
            border-bottom: 1px dashed #dddddd;
            margin: 12px 0;
        }

        /* Detail Table */
        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td {
            padding: 4px 0;
            vertical-align: top;
            font-size: 13px;
        }

        .info-table td.label {
            width: 40%;
            color: #666;
        }

        .info-table td.colon {
            width: 5%;
            text-align: center;
        }

        .info-table td.value {
            width: 55%;
            font-weight: bold;
            text-align: right;
            color: #2d3748;
        }

        /* Product Box */
        .product-box {
            background-color: #fdf2f2; /* Soft red tint */
            border: 1px solid #fecaca;
            border-radius: 8px;
            padding: 15px 10px;
            text-align: center;
            margin: 15px 0;
        }

        .product-title {
            font-size: 15px;
            font-weight: 800;
            color: #1a202c;
            margin-bottom: 6px;
        }

        .product-price-strike {
            font-size: 12px;
            color: #a0aec0;
            text-decoration: line-through;
            display: inline-block;
        }

        .product-price-final {
            font-size: 22px;
            font-weight: 900;
            color: #ec1c24;
            margin: 5px 0 10px 0;
            letter-spacing: -0.5px;
        }

        /* DomPDF Trick to center LUNAS badge */
        .badge-wrapper {
            text-align: center;
            margin-top: 5px;
        }

        .status-lunas {
            background-color: #10b981;
            color: #ffffff;
            font-weight: bold;
            font-size: 14px;
            padding: 6px 16px;
            border-radius: 15px;
            letter-spacing: 1px;
            display: inline-block;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px dashed #cccccc;
        }

        .footer .thanks {
            font-weight: 800;
            font-size: 16px;
            color: #1a202c;
            margin-bottom: 5px;
        }

        .footer p {
            margin: 3px 0;
            font-size: 13px;
            color: #718096;
        }

        .barcode-placeholder {
            margin-top: 15px;
            text-align: center;
            font-family: 'Courier New', Courier, monospace;
            font-size: 13px;
            letter-spacing: 1.5px;
            color: #a0aec0;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <!-- Header -->
        <div class="header">
            @if(isset($formData['logo']))
                <img src="{{ $formData['logo'] }}" alt="Telkomsel">
            @endif
            <h1>STRUK PEMBELIAN</h1>
            <p>RoaMAX Haji Telkomsel</p>
        </div>

        <!-- Transaction Details -->
        <table class="info-table">
            <tr>
                <td class="label">No. Transaksi</td>
                <td class="colon">:</td>
                <td class="value">{{ $formData['id_transaksi'] }}</td>
            </tr>
            <tr>
                <td class="label">Tanggal</td>
                <td class="colon">:</td>
                <td class="value">{{ \Carbon\Carbon::parse($formData['tanggal_transaksi'])->format('d/m/Y - H:i') }}</td>
            </tr>
            <tr>
                <td class="label">Metode Bayar</td>
                <td class="colon">:</td>
                <td class="value">{{ $formData['metode_pembayaran'] }}</td>
            </tr>
        </table>

        <div class="divider"></div>

        <!-- Customer Details -->
        <table class="info-table">
            <tr>
                <td class="label">Pelanggan</td>
                <td class="colon">:</td>
                <td class="value">{{ $formData['nama_pelanggan'] }}</td>
            </tr>
            <tr>
                <td class="label">No. Telepon</td>
                <td class="colon">:</td>
                <td class="value">{{ $formData['telepon_pelanggan'] }}</td>
            </tr>
            <tr>
                <td class="label">Nomor Injeksi</td>
                <td class="colon">:</td>
                <td class="value">{{ $formData['nomor_injeksi'] ?? '-' }}</td>
            </tr>
        </table>

        <!-- Product Highlight Box -->
        <div class="product-box">
            <div class="product-title">{{ $formData['produk_nama'] }}</div>
            
            @if(isset($formData['produk_harga']) && $formData['produk_harga'] > $formData['produk_harga_akhir'])
                <div class="product-price-strike">Rp {{ number_format($formData['produk_harga'], 0, ',', '.') }}</div>
            @endif
            
            <div class="product-price-final">Rp {{ number_format($formData['produk_harga_akhir'], 0, ',', '.') }}</div>
            
            <div class="badge-wrapper">
                <span class="status-lunas">LUNAS</span>
            </div>
        </div>

        <!-- Extra Info -->
        <table class="info-table">
            <tr>
                <td class="label">Merchandise</td>
                <td class="colon">:</td>
                <td class="value">{{ $formData['merch_nama'] ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Masa Aktif</td>
                <td class="colon">:</td>
                <td class="value">{{ $formData['aktivasi_tanggal'] ?? '-' }}</td>
            </tr>
        </table>

        <!-- Footer -->
        <div class="footer">
            <div class="thanks">Terima Kasih!</div>
            <p>Layanan Pelanggan Telkomsel</p>
            <p>Admin: {{ $formData['nama_sales'] }}</p>
            @if(isset($formData['nomor_telepon']) && $formData['nomor_telepon'])
                <p>CS: {{ $formData['nomor_telepon'] }}</p>
            @endif
        </div>
        
        <div class="barcode-placeholder">
            *** {{ substr($formData['id_transaksi'], -8) }} ***
        </div>
    </div>
</body>
</html>
