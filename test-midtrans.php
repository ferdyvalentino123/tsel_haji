<?php
// Test Midtrans Configuration
require __DIR__ . '/vendor/autoload.php';

echo "=== MIDTRANS CONFIGURATION TEST ===\n\n";

// Load .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Get values
$serverKey = $_ENV['MIDTRANS_SERVER_KEY'] ?? 'NOT SET';
$clientKey = $_ENV['MIDTRANS_CLIENT_KEY'] ?? 'NOT SET';
$isProduction = $_ENV['MIDTRANS_IS_PRODUCTION'] ?? 'false';

echo "Server Key: " . $serverKey . "\n";
echo "Client Key: " . $clientKey . "\n";
echo "Is Production: " . $isProduction . "\n\n";

// Validasi format
$serverKeyValid = (strpos($serverKey, 'SB-Mid-server-') === 0 || strpos($serverKey, 'Mid-server-') === 0);
$clientKeyValid = (strpos($clientKey, 'SB-Mid-client-') === 0 || strpos($clientKey, 'Mid-client-') === 0);

echo "Server Key Format: " . ($serverKeyValid ? "✓ VALID" : "✗ INVALID") . "\n";
echo "Client Key Format: " . ($clientKeyValid ? "✓ VALID" : "✗ INVALID") . "\n\n";

// Test Midtrans Connection
echo "Testing Midtrans API Connection...\n";

\Midtrans\Config::$serverKey = $serverKey;
\Midtrans\Config::$isProduction = ($isProduction === 'true');
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

try {
    // Test dengan membuat dummy transaction
    $params = [
        'transaction_details' => [
            'order_id' => 'TEST-' . time(),
            'gross_amount' => 10000,
        ],
        'customer_details' => [
            'first_name' => 'Test',
            'email' => 'test@example.com',
        ],
        'item_details' => [
            [
                'id' => 'item1',
                'price' => 10000,
                'quantity' => 1,
                'name' => 'Test Item'
            ]
        ],
        'enabled_payments' => ['qris']
    ];
    
    $snapToken = \Midtrans\Snap::getSnapToken($params);
    
    echo "✓ SUCCESS! Snap Token berhasil dibuat: " . substr($snapToken, 0, 20) . "...\n";
    echo "\n=== TEST BERHASIL! API KEYS VALID ===\n";
    
} catch (Exception $e) {
    echo "✗ ERROR: " . $e->getMessage() . "\n";
    echo "\n=== TROUBLESHOOTING ===\n";
    echo "1. Pastikan Server Key dan Client Key benar dari dashboard Midtrans\n";
    echo "2. Login ke: https://dashboard.sandbox.midtrans.com\n";
    echo "3. Buka: Settings → Access Keys\n";
    echo "4. Copy ulang kedua keys dan paste ke .env\n";
    echo "5. Jangan ada spasi atau karakter aneh\n";
    echo "6. Restart Laravel: php artisan serve\n";
}
