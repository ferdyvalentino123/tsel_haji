# FIX LOGIN PELANGGAN - PANDUAN LENGKAP

## ✅ Masalah yang Diperbaiki

PIN pelanggan sudah diupdate dan diperbaiki. Sekarang login harus berfungsi dengan baik.

---

## 🔍 Cara Test Login Pelanggan

### Step 1: Test Data Pelanggan
Buka di browser:
```
http://localhost/test-login-pelanggan
```

Anda harus melihat output seperti:
```json
{
    "user": {
        "id": 38,
        "name": "Pelanggan Test",
        "email": "pelanggan@test.com",
        "role": "pelanggan"
    },
    "pin_test": "123456",
    "pin_valid": true,
    "pin_hash": "$2y$12$wlU.iOcK004W..."
}
```

**Penting:** `pin_valid` harus `true`!

---

### Step 2: Login Manual

1. Buka browser: `http://localhost/programhaji/login`

2. Masukkan:
   - **Email:** `pelanggan@test.com`
   - **PIN:** Klik angka `1-2-3-4-5-6` di keypad

3. Klik tombol area submit (bisa jadi tombol submit atau area form)

4. Jika berhasil, Anda akan diarahkan ke: `/programhaji/pelanggan/home`

---

## 🔧 Command untuk Fix PIN

Jika masih tidak bisa login, jalankan command ini:

```bash
php artisan check:pelanggan
```

Command ini akan:
- ✓ Cek apakah data pelanggan ada
- ✓ Validasi PIN
- ✓ Update PIN jika tidak valid
- ✓ Tampilkan semua pelanggan

---

## 📋 Akun Pelanggan yang Tersedia

### Akun 1 - Pelanggan Test ✅ (SUDAH DIPERBAIKI)
- Email: `pelanggan@test.com`
- PIN: `123456`
- Status: **READY**

### Akun 2 - Ahmad Jamaah Haji
- Email: `ahmad@haji.com`
- PIN: `123456`
- Status: **READY**

### Akun 3 - Siti Fatimah
- Email: `siti@haji.com`
- PIN: `123456`
- Status: **READY**

---

## 🐛 Troubleshooting

### Masalah 1: PIN Tidak Valid
**Solusi:**
```bash
php artisan check:pelanggan
```

### Masalah 2: Email Tidak Ditemukan
**Solusi:**
```bash
php artisan db:seed --class=PelangganSeeder
```

### Masalah 3: Error "Role tidak valid"
**Cek migration:**
```bash
php artisan migrate:status
```

Pastikan migration ini sudah running:
- ✅ `add_pelanggan_role_to_role_users_table`

### Masalah 4: Redirect Error
**Clear cache:**
```bash
php artisan route:clear
php artisan cache:clear
php artisan config:clear
```

---

## 📊 Check Log

Sekarang LoginController sudah dilengkapi dengan logging. 

Jika login gagal, cek file log:
```
storage/logs/laravel.log
```

Anda akan melihat log seperti:
```
[timestamp] local.INFO: Login attempt {"email":"pelanggan@test.com","user_found":"yes","user_role":"pelanggan"}
[timestamp] local.INFO: PIN valid, role: pelanggan
[timestamp] local.INFO: Pelanggan logged in, redirecting to pelanggan.home
```

---

## ✅ Checklist Before Login

Pastikan hal-hal ini sudah beres:

- [x] Migration `add_pelanggan_role_to_role_users_table` sudah running
- [x] Migration `add_pelanggan_fields_to_transaksis_table` sudah running
- [x] Seeder `PelangganSeeder` sudah running
- [x] Data pelanggan ada di database
- [x] PIN pelanggan valid (sudah di-hash dengan benar)
- [x] Middleware `pelanggan` sudah terdaftar
- [x] Routes pelanggan sudah terdaftar

---

## 🎯 Test Flow Lengkap

### 1. Test Data
```bash
# Cek data pelanggan
php artisan check:pelanggan
```

### 2. Test di Browser
```
# Test API endpoint
http://localhost/test-login-pelanggan
```

### 3. Login Manual
```
# Halaman login
http://localhost/programhaji/login

Email: pelanggan@test.com
PIN: 123456
```

### 4. Setelah Login Berhasil
Anda akan melihat:
- ✅ Dashboard pelanggan dengan welcome banner
- ✅ List produk paket kuota haji
- ✅ Menu navbar: Beranda, Riwayat Transaksi
- ✅ Nama user di navbar
- ✅ Tombol Logout

---

## 🔥 Quick Fix Commands

Jalankan semua command ini jika masih ada masalah:

```bash
# 1. Update PIN pelanggan
php artisan check:pelanggan

# 2. Clear semua cache
php artisan cache:clear
php artisan route:clear
php artisan config:clear
php artisan view:clear

# 3. Re-run migrations (HATI-HATI: akan reset data!)
# php artisan migrate:fresh --seed

# 4. Atau hanya seed ulang pelanggan
php artisan db:seed --class=PelangganSeeder
```

---

## 📞 Jika Masih Tidak Bisa Login

1. **Buka terminal dan jalankan:**
   ```bash
   php artisan check:pelanggan
   ```

2. **Buka browser dan test:**
   ```
   http://localhost/test-login-pelanggan
   ```

3. **Cek log Laravel:**
   ```
   storage/logs/laravel.log
   ```

4. **Screenshot error dan share:**
   - Screenshot halaman login
   - Screenshot output dari `php artisan check:pelanggan`
   - Screenshot output dari `/test-login-pelanggan`
   - Copy paste error dari `laravel.log`

---

## ✨ Yang Sudah Diperbaiki

✅ PIN pelanggan sudah diupdate ke format yang benar
✅ LoginController sudah dilengkapi logging
✅ Added test route untuk debugging
✅ Created command `php artisan check:pelanggan`
✅ Verified data pelanggan di database

---

## 🎉 Selamat Mencoba!

Login sekarang harus berfungsi dengan baik. Silakan coba login dengan:
- Email: `pelanggan@test.com`
- PIN: `123456`

Jika masih ada masalah, jalankan `php artisan check:pelanggan` dan test di `/test-login-pelanggan`.
