# Script untuk Update Midtrans API Keys
# Jalankan script ini setelah mendapat API Keys dari Midtrans

Write-Host "================================================" -ForegroundColor Cyan
Write-Host "    UPDATE MIDTRANS API KEYS" -ForegroundColor Cyan
Write-Host "================================================" -ForegroundColor Cyan
Write-Host ""

# Pastikan di root project
$envFile = ".env"

if (-Not (Test-Path $envFile)) {
    Write-Host "ERROR: File .env tidak ditemukan!" -ForegroundColor Red
    Write-Host "Pastikan Anda menjalankan script ini di root folder project" -ForegroundColor Yellow
    exit 1
}

Write-Host "File .env ditemukan!" -ForegroundColor Green
Write-Host ""

# Minta input Server Key
Write-Host "Paste MIDTRANS_SERVER_KEY di sini:" -ForegroundColor Yellow
Write-Host "(Contoh: SB-Mid-server-abc123xyz456def789)" -ForegroundColor Gray
$serverKey = Read-Host "Server Key"

if ([string]::IsNullOrWhiteSpace($serverKey)) {
    Write-Host "ERROR: Server Key tidak boleh kosong!" -ForegroundColor Red
    exit 1
}

# Validasi Server Key format
if (-Not ($serverKey -like "SB-Mid-server-*" -or $serverKey -like "Mid-server-*")) {
    Write-Host "WARNING: Format Server Key tidak sesuai!" -ForegroundColor Yellow
    Write-Host "Server Key harus dimulai dengan 'SB-Mid-server-' (sandbox) atau 'Mid-server-' (production)" -ForegroundColor Yellow
    $continue = Read-Host "Lanjutkan? (y/n)"
    if ($continue -ne "y") {
        exit 1
    }
}

Write-Host ""

# Minta input Client Key
Write-Host "Paste MIDTRANS_CLIENT_KEY di sini:" -ForegroundColor Yellow
Write-Host "(Contoh: SB-Mid-client-abc123xyz456def789)" -ForegroundColor Gray
$clientKey = Read-Host "Client Key"

if ([string]::IsNullOrWhiteSpace($clientKey)) {
    Write-Host "ERROR: Client Key tidak boleh kosong!" -ForegroundColor Red
    exit 1
}

# Validasi Client Key format
if (-Not ($clientKey -like "SB-Mid-client-*" -or $clientKey -like "Mid-client-*")) {
    Write-Host "WARNING: Format Client Key tidak sesuai!" -ForegroundColor Yellow
    Write-Host "Client Key harus dimulai dengan 'SB-Mid-client-' (sandbox) atau 'Mid-client-' (production)" -ForegroundColor Yellow
    $continue = Read-Host "Lanjutkan? (y/n)"
    if ($continue -ne "y") {
        exit 1
    }
}

Write-Host ""
Write-Host "Updating .env file..." -ForegroundColor Cyan

# Backup .env
Copy-Item $envFile "$envFile.backup" -Force
Write-Host "Backup created: .env.backup" -ForegroundColor Green

# Read .env content
$envContent = Get-Content $envFile

# Replace Server Key
$envContent = $envContent -replace 'MIDTRANS_SERVER_KEY=.*', "MIDTRANS_SERVER_KEY=$serverKey"

# Replace Client Key
$envContent = $envContent -replace 'MIDTRANS_CLIENT_KEY=.*', "MIDTRANS_CLIENT_KEY=$clientKey"

# Write back to .env
$envContent | Set-Content $envFile

Write-Host ""
Write-Host "================================================" -ForegroundColor Green
Write-Host "    ✅ API KEYS BERHASIL DI-UPDATE!" -ForegroundColor Green
Write-Host "================================================" -ForegroundColor Green
Write-Host ""

# Tampilkan hasil
Write-Host "Server Key: " -NoNewline -ForegroundColor Yellow
Write-Host $serverKey -ForegroundColor White
Write-Host "Client Key: " -NoNewline -ForegroundColor Yellow
Write-Host $clientKey -ForegroundColor White
Write-Host ""

Write-Host "LANGKAH SELANJUTNYA:" -ForegroundColor Cyan
Write-Host "1. Restart Laravel server (Ctrl+C, lalu: php artisan serve)" -ForegroundColor White
Write-Host "2. Test pembayaran di browser" -ForegroundColor White
Write-Host ""

Write-Host "Jika masih error, cek:" -ForegroundColor Yellow
Write-Host "- API Keys sudah benar di dashboard Midtrans?" -ForegroundColor Gray
Write-Host "- Tidak ada spasi atau karakter aneh di keys?" -ForegroundColor Gray
Write-Host ""

Read-Host "Tekan Enter untuk keluar"
