# 🔐 Setup Google OAuth untuk Login Pelanggan

## ✅ Yang Sudah Selesai
- ✅ Laravel Socialite terinstall
- ✅ Routes untuk Google OAuth sudah dibuat
- ✅ LoginController sudah ada method untuk Google OAuth
- ✅ Login page sudah ada tombol "Masuk dengan Google"
- ✅ Configuration sudah siap di `config/services.php`

---

## 📋 Langkah Setup Google Cloud Console

### **Step 1: Buat Project di Google Cloud Console**

1. Buka [Google Cloud Console](https://console.cloud.google.com/)
2. Login dengan akun Google kamu
3. Klik **"Select a project"** → **"New Project"**
4. Isi nama project: **"TSEL Hajii"**
5. Klik **"Create"**

---

### **Step 2: Enable Google+ API**

1. Di menu kiri, pilih **"APIs & Services"** → **"Library"**
2. Cari **"Google+ API"**
3. Klik dan tekan **"Enable"**

---

### **Step 3: Setup OAuth Consent Screen**

1. Di menu kiri, pilih **"APIs & Services"** → **"OAuth consent screen"**
2. Pilih **"External"** → Klik **"Create"**
3. Isi informasi aplikasi:
   - **App name**: TSEL Hajii Program
   - **User support email**: email kamu
   - **Developer contact email**: email kamu
4. Klik **"Save and Continue"**
5. Di **"Scopes"**, klik **"Add or Remove Scopes"**
   - Centang: `userinfo.email`
   - Centang: `userinfo.profile`
   - Centang: `openid`
6. Klik **"Update"** → **"Save and Continue"**
7. Di **"Test users"**, tambahkan email yang mau kamu pakai untuk testing
8. Klik **"Save and Continue"** → **"Back to Dashboard"**

---

### **Step 4: Buat OAuth 2.0 Credentials**

1. Di menu kiri, pilih **"APIs & Services"** → **"Credentials"**
2. Klik **"Create Credentials"** → **"OAuth client ID"**
3. Pilih **"Web application"**
4. Isi informasi:
   - **Name**: TSEL Hajii Web App
   - **Authorized JavaScript origins**:
     ```
     http://localhost:8000
     http://127.0.0.1:8000
     ```
   - **Authorized redirect URIs**:
     ```
     http://localhost:8000/programhaji/auth/google/callback
     http://127.0.0.1:8000/programhaji/auth/google/callback
     ```
5. Klik **"Create"**
6. Copy **Client ID** dan **Client Secret** yang muncul

---

### **Step 5: Update .env dengan Credentials**

Buka file `.env` di project Laravel, update bagian Google OAuth:

```env
# Google OAuth Configuration
GOOGLE_CLIENT_ID=isi-dengan-client-id-dari-google
GOOGLE_CLIENT_SECRET=isi-dengan-client-secret-dari-google
GOOGLE_REDIRECT_URI=http://localhost:8000/programhaji/auth/google/callback
```

**Contoh:**
```env
GOOGLE_CLIENT_ID=123456789-abcdefghijklmnop.apps.googleusercontent.com
GOOGLE_CLIENT_SECRET=GOCSPX-abcd1234efgh5678ijkl
GOOGLE_REDIRECT_URI=http://localhost:8000/programhaji/auth/google/callback
```

---

### **Step 6: Clear Cache Laravel**

Jalankan command ini di terminal:

```bash
php artisan config:clear
php artisan cache:clear
```

---

## 🧪 Testing Google OAuth

1. Jalankan server Laravel:
   ```bash
   php artisan serve
   ```

2. Buka browser: `http://localhost:8000/programhaji/login`

3. Klik tombol **"Masuk dengan Google"**

4. Pilih akun Google (gunakan email yang sudah ditambahkan di Test Users)

5. Setelah berhasil, kamu akan diarahkan ke halaman pelanggan

---

## ✨ Fitur yang Sudah Tersedia

### **Login dengan Google:**
- ✅ Auto-create akun jika email belum terdaftar
- ✅ Auto-login jika email sudah terdaftar
- ✅ Email dijamin valid karena dari Google
- ✅ Foto profil otomatis dari Google avatar
- ✅ Hanya role `pelanggan` yang bisa login via Google
- ✅ Sales/Supervisor/Kasir tetap pakai PIN

### **Keamanan:**
- ✅ Email terverifikasi oleh Google
- ✅ Role-based access control
- ✅ Logging semua aktivitas OAuth
- ✅ Error handling untuk kasus gagal

### **User Experience:**
- ✅ One-click login
- ✅ Tidak perlu mengingat PIN
- ✅ Data auto-fill dari Google
- ✅ Redirect otomatis setelah login

---

## 🚀 Deploy ke Production

Saat deploy ke production (domain asli), update:

1. **Google Cloud Console** → Tambah domain production di:
   - Authorized JavaScript origins: `https://yourdomain.com`
   - Authorized redirect URIs: `https://yourdomain.com/programhaji/auth/google/callback`

2. **`.env` Production**:
   ```env
   GOOGLE_REDIRECT_URI=https://yourdomain.com/programhaji/auth/google/callback
   ```

3. **OAuth Consent Screen** → Publish app (tidak lagi di Testing mode)

---

## 📞 Troubleshooting

### **Error: "redirect_uri_mismatch"**
- Pastikan URL di Google Console sama persis dengan di `.env`
- Cek tidak ada trailing slash
- Case-sensitive!

### **Error: "This app isn't verified"**
- Normal untuk testing mode
- Klik "Advanced" → "Go to TSEL Hajii (unsafe)"
- Untuk production, harus verify app di Google

### **User tidak bisa login**
- Pastikan email sudah ditambahkan di Test Users (untuk testing mode)
- Atau publish app ke production

---

## 📝 Notes

- PIN tetap diperlukan untuk user yang daftar manual (bukan via Google)
- User yang daftar via Google mendapat random PIN (tidak digunakan)
- Phone dan tempat_tugas bisa dilengkapi di halaman profil nanti
- Email dari Google dijamin valid dan terverifikasi

---

**✅ Setup sudah selesai! Tinggal isi credentials dari Google Cloud Console.**
