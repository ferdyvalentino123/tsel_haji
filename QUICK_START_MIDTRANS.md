# 🚀 QUICK START - Midtrans QRIS Payment

## ⚡ Langkah Cepat Testing

### 1️⃣ Dapatkan API Keys (5 menit)

1. **Buka browser**, kunjungi: https://dashboard.sandbox.midtrans.com/register
2. **Daftar akun** dengan email Anda
3. **Login**, lalu buka menu: **Settings** → **Access Keys**
4. **Copy** kedua keys yang muncul

### 2️⃣ Update .env (1 menit)

Buka file `.env` di root project, cari baris ini:

```env
MIDTRANS_SERVER_KEY=SB-Mid-server-YOUR_SERVER_KEY
MIDTRANS_CLIENT_KEY=SB-Mid-client-YOUR_CLIENT_KEY
```

**Replace** `YOUR_SERVER_KEY` dan `YOUR_CLIENT_KEY` dengan keys yang Anda copy tadi.

Contoh hasil:
```env
MIDTRANS_SERVER_KEY=SB-Mid-server-abc123xyz456
MIDTRANS_CLIENT_KEY=SB-Mid-client-def789uvw012
```

### 3️⃣ Restart Laravel Server (30 detik)

Tekan `Ctrl+C` di terminal yang menjalankan Laravel, lalu:

```bash
php artisan serve
```

### 4️⃣ Test Pembayaran! (2 menit)

1. **Login** sebagai pelanggan:
   - URL: http://localhost:8000/programhaji/pelanggan/home
   - Email: `pelanggan@test.com`
   - PIN: `123456`

2. **Pilih produk** yang ingin dibeli

3. **Klik "Beli Sekarang"**

4. **Isi jumlah paket**, klik "Proses Transaksi"

5. **Klik "Bayar Sekarang dengan QRIS"**
   - Akan muncul popup Midtrans Snap

6. **Di popup Midtrans**:
   - Pilih metode: **QRIS**
   - Klik tombol **"Success Payment"** (untuk simulasi sukses)

7. **Selesai!** Anda akan diredirect ke riwayat transaksi

---

## 🎯 Itu Saja!

**Tidak perlu ngrok** untuk testing awal. Ngrok hanya diperlukan jika Anda ingin test notifikasi webhook dari Midtrans ke server lokal Anda.

Untuk testing dasar (flow pembayaran, QRIS, callback), cukup 4 langkah di atas!

---

## 🔍 Jika Ada Masalah

### Error: "Snap token is invalid"
**Cek**: Apakah SERVER_KEY dan CLIENT_KEY sudah benar di `.env`?

### Popup Midtrans tidak muncul
**Solusi**: Buka browser console (F12), lihat error di tab Console

### Transaksi tidak update jadi "lunas"
**Cek**: 
1. Apakah Anda klik "Success Payment" di popup Midtrans?
2. Cek di riwayat transaksi, refresh halaman

---

## 📚 Dokumentasi Lengkap

Lihat file: **MIDTRANS_IMPLEMENTATION.md** untuk:
- Setup webhook dengan ngrok
- Testing advanced
- Production deployment
- Troubleshooting detail

---

**Happy Testing! 🎉**
