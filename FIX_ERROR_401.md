# 🚨 FIX ERROR 401 - Unauthorized Transaction

## ❌ Error yang Muncul:
```
Gagal membuat pembayaran: Midtrans API is returning API error. 
HTTP status code: 401 
API response: {"error_messages":["Access denied due to unauthorized transaction, 
please check client or server key"]}
```

## ✅ Penyebab:
API Keys di file `.env` masih placeholder (belum diisi dengan keys asli dari Midtrans)

---

## 🔧 SOLUSI CEPAT (2 Cara)

### **Cara 1: Gunakan Script PowerShell** (Termudah!)

#### 1. Dapatkan API Keys dari Midtrans
- Daftar di: https://dashboard.sandbox.midtrans.com/register
- Login, buka: **Settings** → **Access Keys**
- Copy **Server Key** dan **Client Key**

#### 2. Jalankan Script Update
```powershell
# Di folder project, jalankan:
.\update-midtrans-keys.ps1
```

Script akan meminta:
1. Paste Server Key → Enter
2. Paste Client Key → Enter
3. Selesai! File .env akan ter-update otomatis

#### 3. Restart Laravel
```bash
# Ctrl+C (stop server), lalu:
php artisan serve
```

---

### **Cara 2: Edit Manual File .env**

#### 1. Dapatkan API Keys dari Midtrans
- Daftar di: https://dashboard.sandbox.midtrans.com/register
- Login, buka: **Settings** → **Access Keys**
- Copy **Server Key** dan **Client Key**

#### 2. Edit File .env
Buka file `.env`, cari baris ini:

```env
MIDTRANS_SERVER_KEY=SB-Mid-server-YOUR_SERVER_KEY
MIDTRANS_CLIENT_KEY=SB-Mid-client-YOUR_CLIENT_KEY
```

Ganti menjadi (gunakan keys yang kamu copy):

```env
MIDTRANS_SERVER_KEY=SB-Mid-server-abc123xyz456def789
MIDTRANS_CLIENT_KEY=SB-Mid-client-ghi012jkl345mno678
```

**PENTING:** 
- Hapus `YOUR_SERVER_KEY` dan `YOUR_CLIENT_KEY` sepenuhnya
- Paste keys yang asli dari Midtrans
- Tidak boleh ada spasi sebelum atau sesudah keys
- Server Key dimulai dengan: `SB-Mid-server-`
- Client Key dimulai dengan: `SB-Mid-client-`

#### 3. Save File & Restart Laravel
```bash
# Ctrl+C (stop server), lalu:
php artisan serve
```

---

## 🧪 Test Lagi

1. **Login** sebagai pelanggan:
   - Email: `pelanggan@test.com`
   - PIN: `123456`

2. **Pilih produk** → Klik "Beli Sekarang"

3. **Isi jumlah** → Klik "Proses Transaksi"

4. **Klik "Bayar Sekarang dengan QRIS"**
   - ✅ **Popup Midtrans harus muncul sekarang!**

5. **Di popup:** Pilih QRIS → Klik "Success Payment"

6. **Selesai!** Status transaksi jadi "Lunas"

---

## 🔍 Masih Error?

### Cek Ini:

#### 1. **Keys sudah benar?**
```bash
# Cek isi .env (jangan tampilkan ke orang lain!)
cat .env | Select-String "MIDTRANS"
```

Harus menampilkan:
```
MIDTRANS_SERVER_KEY=SB-Mid-server-XXXXXXX (bukan YOUR_SERVER_KEY)
MIDTRANS_CLIENT_KEY=SB-Mid-client-XXXXXXX (bukan YOUR_CLIENT_KEY)
```

#### 2. **Laravel sudah restart?**
Server harus di-restart setelah update .env!
```bash
# Stop: Ctrl+C
# Start: php artisan serve
```

#### 3. **Keys dari dashboard yang benar?**
- Login ke: https://dashboard.sandbox.midtrans.com
- Settings → Access Keys
- **Production** atau **Sandbox**? (Gunakan Sandbox untuk testing!)

#### 4. **Cache Laravel?**
Kadang Laravel cache config, clear dengan:
```bash
php artisan config:clear
php artisan cache:clear
```

---

## 📸 Screenshot Dashboard Midtrans

Lokasi API Keys di dashboard:

```
Dashboard Midtrans
├── Settings (⚙️)
│   └── Access Keys
│       ├── 🔑 Server Key: SB-Mid-server-XXXXX (COPY INI)
│       └── 🔑 Client Key: SB-Mid-client-XXXXX (COPY INI)
```

---

## ✅ Success Indicators

Setelah fix, kamu akan lihat:
- ✅ Popup Midtrans muncul (tidak ada error 401)
- ✅ QR Code QRIS ditampilkan
- ✅ Bisa klik "Success Payment"
- ✅ Redirect ke riwayat dengan status "Lunas"

---

## 🆘 Masih Butuh Bantuan?

### Debug Mode:
Cek log Laravel untuk detail error:
```bash
tail -f storage/logs/laravel.log
```

Cari keyword: `Midtrans Error`

### Contact:
- Docs Midtrans: https://docs.midtrans.com
- Support: https://midtrans.com/contact-us

---

**Good Luck! 🚀**
