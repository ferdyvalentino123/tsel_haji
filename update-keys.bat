@echo off
echo ================================================
echo    UPDATE MIDTRANS API KEYS
echo ================================================
echo.

set /p serverkey="Paste Server Key (SB-Mid-server-xxx): "
set /p clientkey="Paste Client Key (SB-Mid-client-xxx): "

echo.
echo Updating .env file...

powershell -Command "(Get-Content .env) -replace 'MIDTRANS_SERVER_KEY=.*', 'MIDTRANS_SERVER_KEY=%serverkey%' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace 'MIDTRANS_CLIENT_KEY=.*', 'MIDTRANS_CLIENT_KEY=%clientkey%' | Set-Content .env"

echo.
echo ================================================
echo    KEYS UPDATED SUCCESSFULLY!
echo ================================================
echo.
echo Server Key: %serverkey%
echo Client Key: %clientkey%
echo.
echo NEXT STEPS:
echo 1. Clear cache: php artisan config:clear
echo 2. Test connection: php test-midtrans.php
echo 3. Restart Laravel: php artisan serve
echo.
pause
