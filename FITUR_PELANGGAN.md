# Fitur Role Pelanggan - Telkomsel Roamax Haji

## 📋 Deskripsi
Fitur role pelanggan adalah penambahan baru pada sistem Telkomsel Roamax Haji yang memungkinkan pelanggan untuk melakukan transaksi pembelian paket kuota haji secara mandiri melalui portal online yang menarik dan user-friendly.

## ✨ Fitur Utama

### 1. **Autentikasi Pelanggan**
- Login menggunakan email dan PIN 6 digit
- Akses khusus untuk role pelanggan
- Session management yang aman

### 2. **Dashboard Pelanggan**
- Tampilan welcome banner dengan gradient modern
- Grid display produk paket kuota haji
- Card design yang menarik dengan hover effects
- Informasi lengkap produk (harga, diskon, stok, masa aktif)

### 3. **Katalog Produk**
- Menampilkan semua produk aktif dengan stok tersedia
- Detail produk meliputi:
  - Nama paket
  - Harga (dengan/tanpa diskon)
  - Detail kuota
  - Masa aktif (30 hari)
  - Stok tersedia
- Badge untuk diskon dan status stok
- Filter otomatis produk yang stok habis

### 4. **Transaksi Pembelian**
- Form pembelian yang intuitif
- Quantity selector dengan tombol +/-
- Real-time calculation total harga
- Konfirmasi pembelian dengan SweetAlert2
- Validasi stok otomatis
- Status transaksi (pending, success, failed)

### 5. **Riwayat Transaksi**
- Dashboard riwayat lengkap
- Summary cards (Total, Pending, Success)
- Detail setiap transaksi
- Status tracking
- Informasi lengkap produk yang dibeli

## 🎨 Desain & UI/UX

### Warna Tema
- Primary Gradient: `linear-gradient(135deg, #21e23e 0%, #2575FC 100%)`
- Background: `linear-gradient(135deg, #f5f7fa 0%, #e8f0f7 100%)`
- Success Color: `#21e23e` (Green)
- Primary Color: `#2575FC` (Blue)

### Komponen UI
- **Navbar**: Gradient header dengan navigasi dan user info
- **Cards**: Rounded corners (20px) dengan shadow dan hover effects
- **Buttons**: Gradient buttons dengan smooth transitions
- **Icons**: Font Awesome 6.4.0 untuk visual yang menarik
- **Footer**: Informasi kontak dan sosial media

### Responsive Design
- Mobile-first approach
- Grid system yang adaptif
- Hamburger menu untuk mobile
- Touch-friendly buttons dan controls

## 🗂️ Struktur File

### Backend Files
```
app/
├── Http/
│   ├── Controllers/
│   │   └── PelangganController.php      # Controller utama pelanggan
│   └── Middleware/
│       └── PelangganMiddleware.php       # Middleware proteksi route
├── Models/
│   ├── Transaksi.php                     # Model transaksi (updated)
│   └── RoleUsers.php                     # Model user dengan role pelanggan
```

### Frontend Files
```
resources/
└── views/
    ├── components/
    │   └── pelanggan/
    │       └── layouts.blade.php         # Layout utama pelanggan
    └── pelanggan/
        ├── home.blade.php                # Dashboard & katalog produk
        ├── beli-produk.blade.php         # Form pembelian
        └── riwayat-transaksi.blade.php   # Riwayat transaksi
```

### Database Files
```
database/
├── migrations/
│   ├── 2025_11_29_180433_add_pelanggan_role_to_role_users_table.php
│   └── 2025_11_29_181155_add_pelanggan_fields_to_transaksis_table.php
└── seeders/
    └── PelangganSeeder.php               # Seeder data pelanggan test
```

### Routes
```
routes/
└── web.php                               # Routes pelanggan dengan middleware
```

### Config
```
bootstrap/
└── app.php                               # Registrasi middleware pelanggan
```

## 🔐 Akun Test Pelanggan

Berikut adalah akun pelanggan yang sudah dibuat untuk testing:

| Nama | Email | PIN | Deskripsi |
|------|-------|-----|-----------|
| Pelanggan Test | pelanggan@test.com | 123456 | Akun test umum |
| Ahmad Jamaah Haji | ahmad@haji.com | 123456 | Akun test jamaah haji |
| Siti Fatimah | siti@haji.com | 123456 | Akun test jamaah haji |

## 🚀 Cara Menggunakan

### Untuk Developer

1. **Jalankan Migration**
   ```bash
   php artisan migrate
   ```

2. **Jalankan Seeder**
   ```bash
   php artisan db:seed --class=PelangganSeeder
   ```

3. **Clear Cache (Opsional)**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan view:clear
   ```

### Untuk Pelanggan

1. **Login**
   - Buka halaman `/programhaji/login`
   - Masukkan email: `pelanggan@test.com`
   - Masukkan PIN: `123456`
   - Klik tombol angka di keypad untuk memasukkan PIN

2. **Lihat Produk**
   - Setelah login, Anda akan diarahkan ke dashboard pelanggan
   - Semua produk paket kuota haji yang tersedia akan ditampilkan
   - Lihat detail harga, diskon, dan stok masing-masing produk

3. **Beli Produk**
   - Klik tombol "Beli Sekarang" pada produk yang diinginkan
   - Atur jumlah pembelian dengan tombol + dan -
   - Total harga akan otomatis dihitung
   - Klik "Konfirmasi Pembelian"
   - Konfirmasi transaksi pada popup

4. **Lihat Riwayat**
   - Klik menu "Riwayat Transaksi" di navbar
   - Lihat semua transaksi yang pernah dilakukan
   - Summary statistik tersedia di bagian atas

## 🔧 Routes API

### Public Routes
- `GET /programhaji/login` - Halaman login

### Protected Routes (Middleware: pelanggan)
- `GET /programhaji/pelanggan/home` - Dashboard pelanggan
- `GET /programhaji/pelanggan/produk/{id}` - Detail produk
- `GET /programhaji/pelanggan/produk/{id}/beli` - Form beli produk
- `POST /programhaji/pelanggan/transaksi` - Process transaksi
- `GET /programhaji/pelanggan/riwayat-transaksi` - Riwayat transaksi

## 📊 Database Schema

### Tabel: role_users (Updated)
- Role enum ditambahkan: `'pelanggan'`

### Tabel: transaksis (Updated)
Kolom baru:
- `id_pelanggan` (FK to role_users)
- `produk_id` (FK to produks)
- `jumlah` (integer)
- `total_harga` (decimal 15,2)
- `status` (enum: pending, success, failed)

## 🎯 Fitur Keamanan

1. **Middleware Protection**
   - Route pelanggan dilindungi middleware `pelanggan`
   - Validasi role pada setiap request

2. **Transaction Safety**
   - Database transaction untuk konsistensi data
   - Stock validation sebelum transaksi
   - Rollback otomatis jika terjadi error

3. **Input Validation**
   - Validasi form menggunakan Laravel validation
   - Client-side validation dengan JavaScript
   - CSRF protection

## 🔄 Alur Transaksi

1. Pelanggan login
2. Browse katalog produk
3. Pilih produk dan klik "Beli Sekarang"
4. Atur jumlah pembelian
5. Konfirmasi transaksi
6. Sistem validasi stok
7. Sistem kurangi stok produk
8. Buat record transaksi dengan status "pending"
9. Redirect ke riwayat transaksi
10. Admin/supervisor dapat memproses lebih lanjut

## 📱 Responsive Breakpoints

- Desktop: > 1024px
- Tablet: 768px - 1024px
- Mobile: < 768px

## 🎨 Custom Styles

Semua styling menggunakan inline CSS di dalam blade files dengan class-class custom yang sudah disesuaikan dengan tema Telkomsel Roamax Haji. Tidak memerlukan file CSS eksternal tambahan.

## 🐛 Troubleshooting

### Login Tidak Bisa Masuk
- Pastikan migration sudah dijalankan
- Pastikan seeder sudah dijalankan
- Cek apakah PIN yang dimasukkan benar (123456)

### Produk Tidak Muncul
- Pastikan ada produk dengan `is_active = true` dan `produk_stok > 0`
- Cek di database tabel `produks`

### Error Saat Transaksi
- Cek log Laravel di `storage/logs/laravel.log`
- Pastikan foreign key constraints sudah benar
- Validasi data produk di database

## 📝 Notes

- Sistem ini sudah terintegrasi dengan sistem existing tanpa merusak fungsi yang sudah ada
- Role supervisor, sales, dan kasir tetap berfungsi normal
- Transaksi pelanggan dapat dipantau oleh supervisor melalui dashboard mereka
- Desain mengikuti color scheme yang sudah ada di sistem

## 👨‍💻 Developer

Fitur ini dikembangkan sebagai bagian dari Tugas Akhir - Program Haji Telkomsel.

## 📞 Support

Untuk pertanyaan atau bantuan, hubungi:
- Email: cs@telkomsel.co.id
- Phone: 188
- Layanan: 24/7
