# INTEGRASI PAYMENT GATEWAY QRIS

## 📌 Overview

Sistem pembayaran QRIS untuk pelanggan Telkomsel Roamax Haji sudah diimplementasikan dengan fitur:
- ✅ Generate QRIS Code
- ✅ Countdown timer 15 menit
- ✅ Konfirmasi pembayaran
- ✅ Auto-update status transaksi

---

## 🏦 Pilihan Payment Gateway QRIS di Indonesia

### 1. **Midtrans (Recommended)**
- **Website:** https://midtrans.com
- **Fitur:** QRIS, Credit Card, GoPay, ShopeePay, OVO, Dana, dll
- **Biaya:** MDR 0.7% - 2%
- **Dokumentasi:** https://docs.midtrans.com

### 2. **Xendit**
- **Website:** https://www.xendit.co
- **Fitur:** QRIS, Virtual Account, E-wallet, Cards
- **Biaya:** MDR 0.7% - 2.5%
- **Dokumentasi:** https://developers.xendit.co

### 3. **Doku**
- **Website:** https://doku.com
- **Fitur:** QRIS, Virtual Account, E-wallet
- **Biaya:** MDR 1.5% - 2.5%
- **Dokumentasi:** https://docs.doku.com

### 4. **QRIS by Bank Indonesia (Melalui Bank)**
- **Melalui:** BCA, Mandiri, BRI, BNI, dll
- **Fitur:** QRIS langsung dari bank
- **Biaya:** Bervariasi per bank

---

## 🚀 CARA INTEGRASI MIDTRANS (RECOMMENDED)

### Step 1: Daftar Akun Midtrans

1. Buka https://midtrans.com
2. Klik "Sign Up" atau "Daftar"
3. Pilih "Get Started" untuk sandbox (testing) atau production
4. Isi data bisnis:
   - Nama Bisnis: Telkomsel Roamax Haji
   - Jenis Bisnis: Telecommunications
   - Email & Password

### Step 2: Dapatkan API Credentials

Setelah login, buka **Settings > Access Keys**:
- **Server Key:** `SB-Mid-server-xxxxxxxxxxxxx` (untuk server-side)
- **Client Key:** `SB-Mid-client-xxxxxxxxxxxxx` (untuk client-side)

**PENTING:** 
- Sandbox keys diawali dengan `SB-Mid-`
- Production keys diawali dengan `Mid-`

---

### Step 3: Install Midtrans PHP SDK

```bash
composer require midtrans/midtrans-php
```

---

### Step 4: Konfigurasi Midtrans di Laravel

#### A. Tambahkan di `.env`

```env
# Midtrans Configuration
MIDTRANS_SERVER_KEY=SB-Mid-server-xxxxxxxxxxxxx
MIDTRANS_CLIENT_KEY=SB-Mid-client-xxxxxxxxxxxxx
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

#### B. Tambahkan di `config/services.php`

```php
'midtrans' => [
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),
    'is_sanitized' => env('MIDTRANS_IS_SANITIZED', true),
    'is_3ds' => env('MIDTRANS_IS_3DS', true),
],
```

---

### Step 5: Update PelangganController

Ganti method `pembayaran()` dengan kode berikut:

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Notification;

class PelangganController extends Controller
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    // ... method lainnya tetap sama ...

    /**
     * Show halaman pembayaran QRIS dengan Midtrans
     */
    public function pembayaran($id)
    {
        $transaksi = Transaksi::where('id', $id)
            ->where('id_pelanggan', Auth::id())
            ->with('produk')
            ->firstOrFail();
        
        // Jika sudah dibayar, redirect ke riwayat
        if ($transaksi->status == 'lunas' || $transaksi->is_paid) {
            return redirect()->route('pelanggan.riwayat-transaksi')
                ->with('info', 'Transaksi ini sudah dibayar.');
        }
        
        // Prepare transaction data for Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => $transaksi->id_transaksi,
                'gross_amount' => (int) $transaksi->total_harga,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => Auth::user()->phone,
            ],
            'item_details' => [
                [
                    'id' => $transaksi->produk->id,
                    'price' => (int) ($transaksi->total_harga / $transaksi->jumlah),
                    'quantity' => (int) $transaksi->jumlah,
                    'name' => $transaksi->produk->produk_nama,
                ]
            ],
            'enabled_payments' => ['qris'], // Hanya QRIS
        ];

        try {
            // Get Snap Payment Token
            $snapToken = Snap::getSnapToken($params);
            
            return view('pelanggan.pembayaran', compact('transaksi', 'snapToken'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat pembayaran: ' . $e->getMessage());
        }
    }

    /**
     * Webhook callback dari Midtrans
     */
    public function notificationHandler(Request $request)
    {
        try {
            $notification = new Notification();

            $transaction = $notification->transaction_status;
            $type = $notification->payment_type;
            $order_id = $notification->order_id;
            $fraud = $notification->fraud_status;

            // Cari transaksi berdasarkan order_id
            $transaksi = Transaksi::where('id_transaksi', $order_id)->first();

            if (!$transaksi) {
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            // Handle transaction status
            if ($transaction == 'capture') {
                if ($type == 'credit_card') {
                    if ($fraud == 'challenge') {
                        $transaksi->status = 'pending';
                    } else {
                        $transaksi->status = 'lunas';
                        $transaksi->is_paid = true;
                    }
                }
            } elseif ($transaction == 'settlement') {
                $transaksi->status = 'lunas';
                $transaksi->is_paid = true;
            } elseif ($transaction == 'pending') {
                $transaksi->status = 'pending';
            } elseif ($transaction == 'deny') {
                $transaksi->status = 'failed';
            } elseif ($transaction == 'expire') {
                $transaksi->status = 'expired';
            } elseif ($transaction == 'cancel') {
                $transaksi->status = 'cancelled';
            }

            $transaksi->metode_pembayaran = strtoupper($type);
            $transaksi->save();

            return response()->json(['message' => 'Notification handled']);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Callback setelah pembayaran (redirect dari Midtrans)
     */
    public function callbackPembayaran(Request $request, $id)
    {
        $transaksi = Transaksi::where('id', $id)
            ->where('id_pelanggan', Auth::id())
            ->firstOrFail();
        
        // Cek status pembayaran dari Midtrans
        try {
            $status = \Midtrans\Transaction::status($transaksi->id_transaksi);
            
            if ($status->transaction_status == 'settlement' || $status->transaction_status == 'capture') {
                $transaksi->status = 'lunas';
                $transaksi->is_paid = true;
                $transaksi->metode_pembayaran = strtoupper($status->payment_type);
                $transaksi->save();
                
                return redirect()->route('pelanggan.riwayat-transaksi')
                    ->with('success', 'Pembayaran berhasil! Terima kasih atas pembelian Anda.');
            } else {
                return redirect()->route('pelanggan.riwayat-transaksi')
                    ->with('warning', 'Pembayaran masih dalam proses. Status: ' . $status->transaction_status);
            }
        } catch (\Exception $e) {
            return redirect()->route('pelanggan.riwayat-transaksi')
                ->with('error', 'Gagal memeriksa status pembayaran.');
        }
    }
}
```

---

### Step 6: Update View Pembayaran

Ganti file `resources/views/pelanggan/pembayaran.blade.php` dengan:

```blade
<x-pelanggan.layouts>
    <style>
        /* ... style tetap sama ... */
    </style>

    <div class="payment-container">
        <!-- Payment Header -->
        <div class="payment-header">
            <h1><i class="fas fa-credit-card"></i> Pembayaran QRIS</h1>
            <p>Scan kode QRIS untuk menyelesaikan pembayaran</p>
        </div>

        <!-- Transaction Summary -->
        <div class="payment-card">
            <h3 class="payment-section-title">
                <i class="fas fa-shopping-cart"></i> Ringkasan Pesanan
            </h3>
            
            <div class="order-summary">
                <div class="order-item">
                    <span><strong>Produk:</strong></span>
                    <span>{{ $transaksi->produk->produk_nama }}</span>
                </div>
                <div class="order-item">
                    <span><strong>Jumlah:</strong></span>
                    <span>{{ $transaksi->jumlah }} Paket</span>
                </div>
                <div class="order-item">
                    <span><strong>Total:</strong></span>
                    <span>Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <!-- Midtrans Snap Payment -->
        <div class="payment-card">
            <button id="pay-button" class="btn btn-confirm-payment">
                <i class="fas fa-qrcode"></i> Bayar dengan QRIS
            </button>
        </div>
    </div>

    <!-- Midtrans Snap Script -->
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    
    <script>
        const payButton = document.getElementById('pay-button');
        
        payButton.addEventListener('click', function () {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    window.location.href = '{{ route("pelanggan.pembayaran.callback", $transaksi->id) }}';
                },
                onPending: function(result) {
                    window.location.href = '{{ route("pelanggan.pembayaran.callback", $transaksi->id) }}';
                },
                onError: function(result) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Pembayaran Gagal',
                        text: 'Terjadi kesalahan saat memproses pembayaran.',
                        confirmButtonColor: '#21e23e'
                    });
                }
            });
        });
    </script>
</x-pelanggan.layouts>
```

---

### Step 7: Tambahkan Route untuk Notification Handler

Di `routes/web.php`:

```php
// Midtrans Notification Handler (tanpa middleware karena dipanggil dari Midtrans)
Route::post('/midtrans/notification', [App\Http\Controllers\PelangganController::class, 'notificationHandler'])
    ->name('midtrans.notification');
```

---

### Step 8: Set Notification URL di Midtrans Dashboard

1. Login ke Midtrans Dashboard
2. Buka **Settings > Configuration**
3. Set **Notification URL:** `https://your-domain.com/midtrans/notification`
4. Set **Finish Redirect URL:** `https://your-domain.com/programhaji/pelanggan/riwayat-transaksi`
5. Save

---

## 🔐 Security Best Practices

1. **Jangan expose Server Key** di client-side
2. **Validasi Notification** dari Midtrans menggunakan signature
3. **Gunakan HTTPS** untuk production
4. **Set IP Whitelist** di Midtrans dashboard
5. **Store payment logs** untuk audit trail

---

## 🧪 Testing

### Test dengan Sandbox

Midtrans menyediakan test credentials:

**QRIS Test:**
- Scan QR Code yang muncul
- Akan muncul simulator pembayaran
- Pilih "Success" untuk simulate sukses

**Test Cards:**
- Card Number: `4811 1111 1111 1114`
- CVV: `123`
- Exp: `01/25`

---

## 📱 Supported E-Wallets via QRIS

Semua e-wallet yang support QRIS:
- ✅ GoPay
- ✅ OVO
- ✅ Dana
- ✅ ShopeePay
- ✅ LinkAja
- ✅ Jenius
- ✅ Bank Apps (BCA Mobile, Livin' by Mandiri, dll)

---

## 💰 Fee Structure

**Midtrans QRIS:**
- MDR: 0.7% per transaksi
- No setup fee
- No monthly fee

**Contoh:**
- Transaksi Rp 1.000.000
- Fee: Rp 7.000 (0.7%)
- Received: Rp 993.000

---

## 🔄 Flow Diagram

```
Pelanggan → Pilih Produk → Checkout
    ↓
Generate Order ID → Create Midtrans Transaction
    ↓
Get Snap Token → Show Payment Page
    ↓
User Scan QRIS → Payment via E-Wallet
    ↓
Midtrans Webhook → Update Transaction Status
    ↓
Redirect → Success Page
```

---

## 📞 Support

**Midtrans Support:**
- Email: support@midtrans.com
- Docs: https://docs.midtrans.com
- Status: https://status.midtrans.com

---

## ✅ Checklist Implementasi

- [x] Install Midtrans SDK
- [x] Setup credentials di .env
- [x] Update PelangganController
- [x] Update view pembayaran
- [x] Tambah route notification
- [ ] Setup notification URL di Midtrans
- [ ] Test di sandbox
- [ ] Switch ke production

---

## 🎯 Next Steps

1. Daftar akun Midtrans
2. Install SDK: `composer require midtrans/midtrans-php`
3. Copy code di atas ke PelangganController
4. Update .env dengan credentials
5. Test dengan sandbox
6. Deploy dan switch ke production

**Ready untuk integrasi! 🚀**
