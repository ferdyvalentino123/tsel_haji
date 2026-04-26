# ✅ CHECKLIST - Siap Testing Midtrans QRIS

## 📋 Yang Sudah Selesai (Oleh AI)

- [x] Install package `midtrans/midtrans-php` via Composer
- [x] Buat konfigurasi di `config/services.php`
- [x] Template `.env` dengan placeholder untuk API keys
- [x] Update `PelangganController` dengan Midtrans integration
  - [x] Generate Snap Token
  - [x] Payment callback handler
  - [x] Webhook notification handler
- [x] Replace view `pembayaran.blade.php` dengan Midtrans Snap UI
- [x] Tambah route `/midtrans/notification` untuk webhook
- [x] Buat dokumentasi lengkap:
  - [x] MIDTRANS_IMPLEMENTATION.md
  - [x] QUICK_START_MIDTRANS.md
  - [x] IMPLEMENTATION_SUMMARY.md
  - [x] FILE INI (CHECKLIST.md)

---

## 🎯 Yang Perlu Kamu Lakukan

### Step 1: Dapatkan API Keys (5 menit)
- [ ] Buka browser, kunjungi: https://dashboard.sandbox.midtrans.com/register
- [ ] Isi form registrasi:
  - Email: ______________________
  - Password: ______________________
  - Business Name: Telkomsel Roamax Haji
  - Phone: ______________________
- [ ] Verifikasi email
- [ ] Login ke dashboard
- [ ] Buka menu: **Settings** → **Access Keys**
- [ ] Copy **Server Key**: `SB-Mid-server-____________________`
- [ ] Copy **Client Key**: `SB-Mid-client-____________________`

### Step 2: Update File .env (1 menit)
- [ ] Buka file `.env` di root project
- [ ] Cari baris yang ada `MIDTRANS_SERVER_KEY`
- [ ] Paste Server Key yang sudah di-copy
- [ ] Paste Client Key yang sudah di-copy
- [ ] Save file

**Contoh hasil:**
```env
MIDTRANS_SERVER_KEY=SB-Mid-server-abc123xyz456def789
MIDTRANS_CLIENT_KEY=SB-Mid-client-ghi012jkl345mno678
```

### Step 3: Restart Laravel Server (30 detik)
- [ ] Tekan `Ctrl+C` di terminal yang menjalankan `php artisan serve`
- [ ] Jalankan lagi: `php artisan serve`
- [ ] Tunggu sampai muncul: "Server started on http://localhost:8000"

### Step 4: Test Payment Flow (5 menit)
- [ ] Buka browser: http://localhost:8000
- [ ] Login sebagai pelanggan:
  - Email: `pelanggan@test.com`
  - PIN: `123456`
- [ ] Klik menu "Home" atau "Produk"
- [ ] Pilih salah satu produk
- [ ] Klik tombol **"Beli Sekarang"**
- [ ] Isi jumlah paket (contoh: 2)
- [ ] Klik **"Proses Transaksi"**
- [ ] Di halaman pembayaran, klik **"Bayar Sekarang dengan QRIS"**
- [ ] **POPUP MIDTRANS HARUS MUNCUL**
  - Jika tidak muncul, cek console browser (F12)
- [ ] Di popup Midtrans:
  - Pilih metode pembayaran: **QRIS**
  - Klik tombol **"Success Payment"** (untuk simulasi sukses)
- [ ] Anda akan diredirect ke halaman riwayat transaksi
- [ ] Cek status transaksi: Harus **"Lunas"** / **"Paid"**

---

## ✅ Verification Checklist

### Setelah Testing, Pastikan:
- [ ] Popup Midtrans muncul saat klik "Bayar Sekarang"
- [ ] QR Code QRIS tampil di popup
- [ ] Setelah klik "Success Payment", muncul alert success
- [ ] Redirect ke halaman riwayat transaksi
- [ ] Status transaksi berubah jadi "Lunas" di riwayat
- [ ] Total harga sesuai dengan yang dipilih
- [ ] Stok produk berkurang sesuai jumlah pembelian

---

## 🐛 Jika Ada Masalah

### Problem 1: Popup Midtrans tidak muncul
**Cek:**
1. Browser console (F12 → Console tab) ada error?
2. `.env` sudah di-update dengan API keys yang benar?
3. Laravel server sudah di-restart?

**Solusi:**
- Reload halaman (Ctrl+R)
- Clear browser cache
- Cek API keys di `.env` tidak ada spasi atau karakter aneh

### Problem 2: Error "Snap token is invalid"
**Cek:**
1. MIDTRANS_SERVER_KEY di `.env` benar?
2. MIDTRANS_CLIENT_KEY di `.env` benar?

**Solusi:**
- Re-copy keys dari dashboard Midtrans
- Paste ulang ke `.env`
- Restart server: `php artisan serve`

### Problem 3: Status transaksi tidak berubah jadi "Lunas"
**Cek:**
1. Apakah di popup Midtrans sudah klik "Success Payment"?
2. Refresh halaman riwayat transaksi

**Solusi Manual:**
Jika stuck, update manual via database:
```sql
UPDATE transaksis 
SET status = 'lunas', is_paid = 1, metode_pembayaran = 'QRIS'
WHERE id_transaksi = 'TRX-PLG-XXX';
```

### Problem 4: Error di Laravel logs
**Cek logs:**
```bash
tail -f storage/logs/laravel.log
```

Cari keyword: `Midtrans Error` atau `Midtrans Notification`

---

## 📞 Need Help?

### Documentation:
- **Quick Start**: Baca file `QUICK_START_MIDTRANS.md`
- **Full Guide**: Baca file `MIDTRANS_IMPLEMENTATION.md`
- **Summary**: Baca file `IMPLEMENTATION_SUMMARY.md`

### Midtrans Resources:
- Docs: https://docs.midtrans.com
- API Reference: https://api-docs.midtrans.com
- Dashboard Sandbox: https://dashboard.sandbox.midtrans.com

---

## 🎉 Success Criteria

**Anda berhasil jika:**
✅ Popup Midtrans muncul
✅ QR Code QRIS ditampilkan
✅ Bisa simulasi pembayaran sukses
✅ Status transaksi berubah jadi "Lunas"
✅ Muncul alert success setelah pembayaran

**Selamat! QRIS Payment sudah terintegrasi dengan sempurna! 🎊**

---

**Estimated Total Time:** 10-15 menit
**Difficulty Level:** ⭐⭐ (Easy-Medium)
