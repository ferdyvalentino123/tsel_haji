# QUICK START - Role Pelanggan

## 🚀 Akses Cepat Login Pelanggan

### URL Login
```
http://localhost/programhaji/login
```

### Akun Test Pelanggan

#### Akun 1 - Pelanggan Test
- **Email:** `pelanggan@test.com`
- **PIN:** `123456`

#### Akun 2 - Ahmad Jamaah Haji  
- **Email:** `ahmad@haji.com`
- **PIN:** `123456`

#### Akun 3 - Siti Fatimah
- **Email:** `siti@haji.com`
- **PIN:** `123456`

---

## 📋 Checklist Setup

- [x] Migration database (role pelanggan)
- [x] Migration database (field transaksi)
- [x] Migration database (id primary key)
- [x] Seeder data pelanggan
- [x] PelangganController
- [x] PelangganMiddleware
- [x] Routes pelanggan
- [x] Layout pelanggan
- [x] Halaman home pelanggan
- [x] Halaman beli produk
- [x] Halaman riwayat transaksi

---

## 🎯 Fitur yang Tersedia

### ✅ Halaman Utama Pelanggan
- Katalog produk paket kuota haji
- Card design dengan gradient modern
- Badge diskon dan stok
- Filter produk aktif

### ✅ Form Pembelian
- Quantity selector (+/-)
- Real-time total calculation
- Konfirmasi dengan SweetAlert2
- Validasi stok otomatis

### ✅ Riwayat Transaksi
- Dashboard statistik transaksi
- Detail setiap transaksi
- Status tracking (pending/success)
- Summary cards

---

## 🎨 Tema Warna

```css
/* Primary Gradient */
background: linear-gradient(135deg, #21e23e 0%, #2575FC 100%);

/* Background Gradient */
background: linear-gradient(135deg, #f5f7fa 0%, #e8f0f7 100%);

/* Success Color */
color: #21e23e;

/* Primary Color */
color: #2575FC;
```

---

## 🔧 Command Terminal yang Sudah Dijalankan

```bash
# 1. Membuat migration role pelanggan
php artisan make:migration add_pelanggan_role_to_role_users_table

# 2. Membuat migration field transaksi pelanggan
php artisan make:migration add_pelanggan_fields_to_transaksis_table

# 3. Membuat migration id primary key
php artisan make:migration add_id_primary_key_to_transaksis_table

# 4. Membuat controller pelanggan
php artisan make:controller PelangganController

# 5. Membuat middleware pelanggan
php artisan make:middleware PelangganMiddleware

# 6. Membuat seeder pelanggan
php artisan make:seeder PelangganSeeder

# 7. Menjalankan semua migration
php artisan migrate

# 8. Menjalankan seeder pelanggan
php artisan db:seed --class=PelangganSeeder
```

---

## 📂 File-file yang Dibuat/Dimodifikasi

### ✨ File Baru
1. `app/Http/Controllers/PelangganController.php`
2. `app/Http/Middleware/PelangganMiddleware.php`
3. `resources/views/components/pelanggan/layouts.blade.php`
4. `resources/views/pelanggan/home.blade.php`
5. `resources/views/pelanggan/beli-produk.blade.php`
6. `resources/views/pelanggan/riwayat-transaksi.blade.php`
7. `database/migrations/2025_11_29_180433_add_pelanggan_role_to_role_users_table.php`
8. `database/migrations/2025_11_29_181155_add_pelanggan_fields_to_transaksis_table.php`
9. `database/migrations/2025_11_29_181446_add_id_primary_key_to_transaksis_table.php`
10. `database/seeders/PelangganSeeder.php`
11. `FITUR_PELANGGAN.md`
12. `QUICK_START_PELANGGAN.md`

### 🔄 File yang Dimodifikasi
1. `app/Http/Controllers/LoginController.php` - Tambah case pelanggan
2. `app/Models/Transaksi.php` - Tambah field dan relasi pelanggan
3. `bootstrap/app.php` - Register middleware pelanggan
4. `routes/web.php` - Tambah routes pelanggan

---

## 🧪 Testing

### Test Login Pelanggan
1. Buka browser: `http://localhost/programhaji/login`
2. Masukkan email: `pelanggan@test.com`
3. Klik angka PIN: `1-2-3-4-5-6`
4. Klik Login
5. ✅ Harus redirect ke `/programhaji/pelanggan/home`

### Test Lihat Produk
1. Login sebagai pelanggan
2. ✅ Harus melihat list produk dengan card design
3. ✅ Harus melihat harga, diskon, stok
4. ✅ Tombol "Beli Sekarang" aktif jika stok > 0

### Test Beli Produk
1. Klik "Beli Sekarang" pada salah satu produk
2. ✅ Harus melihat form pembelian
3. Klik tombol + untuk tambah quantity
4. ✅ Total harga harus update otomatis
5. Klik "Konfirmasi Pembelian"
6. ✅ Harus muncul SweetAlert konfirmasi
7. Klik "Ya, Beli Sekarang!"
8. ✅ Harus redirect ke riwayat transaksi
9. ✅ Stok produk harus berkurang

### Test Riwayat Transaksi
1. Klik menu "Riwayat Transaksi"
2. ✅ Harus melihat list transaksi
3. ✅ Harus melihat summary cards
4. ✅ Status transaksi harus "Menunggu Konfirmasi"

---

## 💡 Tips

### Clear Cache Jika Ada Masalah
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

### Check Routes Pelanggan
```bash
php artisan route:list --name=pelanggan
```

### Check Middleware
```bash
php artisan route:list --middleware=pelanggan
```

---

## 🎓 Untuk Presentasi Tugas Akhir

### Demo Flow yang Direkomendasikan

1. **Intro** - Jelaskan masalah dan solusi
2. **Login** - Tunjukkan proses login pelanggan
3. **Dashboard** - Tunjukkan tampilan produk yang menarik
4. **Pembelian** - Demo proses beli produk
5. **Konfirmasi** - Tunjukkan SweetAlert konfirmasi
6. **Riwayat** - Tunjukkan riwayat transaksi
7. **Responsive** - Tunjukkan tampilan mobile
8. **Code Review** - Jelaskan struktur code

### Poin Penting yang Harus Ditekankan

✅ **User Experience**
- Tampilan modern dan menarik
- Mudah digunakan
- Responsive untuk semua device

✅ **Keamanan**
- Middleware protection
- Input validation
- CSRF protection
- Transaction safety

✅ **Integrasi**
- Tidak merusak sistem yang sudah ada
- Terintegrasi dengan role supervisor/sales/kasir
- Database relasi yang proper

✅ **Scalability**
- Code yang rapi dan terstruktur
- Mudah di-maintain
- Mudah ditambahkan fitur baru

---

## 📞 Support

Jika ada pertanyaan atau masalah:
1. Cek file `FITUR_PELANGGAN.md` untuk dokumentasi lengkap
2. Cek Laravel log di `storage/logs/laravel.log`
3. Test dengan akun pelanggan yang berbeda

---

**Good Luck dengan Tugas Akhir Anda! 🚀**
