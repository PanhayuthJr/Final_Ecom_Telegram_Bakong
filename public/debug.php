
<?php
// Force show errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>🕵️ Deep Debugger</h1>";
echo "<pre style='background:#f4f4f4;padding:15px;border-radius:5px;'>";

// 1. Check File Structure

echo "<strong>1. Checking Files...</strong>\n";
$vendor = __DIR__ . '/../vendor/autoload.php'; // Adjusted for standard structure: public/debug.php -> vendor/
$vendor_flat = __DIR__ . '/vendor/autoload.php'; // Check flat structure too

$bootstrap = __DIR__ . '/../bootstrap/app.php';
$bootstrap_flat = __DIR__ . '/bootstrap/app.php';

$env = __DIR__ . '/../.env';
$env_flat = __DIR__ . '/.env';

// Check which structure we are using
$use_flat = false;
if (file_exists($vendor_flat)) {
    echo "ℹ️ Detected 'Flat' Structure (everything in public_html)\n";
    $vendor = $vendor_flat;
    $bootstrap = $bootstrap_flat;
    $env = $env_flat;
    $use_flat = true;
} else {
    echo "ℹ️ Assumed 'Standard' Structure (public/index.php separately)\n";
}

if (file_exists($vendor)) {
    echo "✅ Vendor folder found at: $vendor\n";
} else {
    echo "❌ CRITICAL: 'vendor' folder is missing! You need to upload it.\n";
    echo "   Checked path: $vendor\n";
    exit;
}

if (file_exists($bootstrap)) {
    echo "✅ Bootstrap file found.\n";
} else {
    echo "❌ CRITICAL: 'bootstrap/app.php' is missing!\n";
    echo "   Checked path: $bootstrap\n";
    exit;
}

if (file_exists($env)) {
    echo "✅ .env file found.\n";
} else {
    echo "❌ CRITICAL: '.env' file is missing!\n";
    echo "   Checked path: $env\n";
    exit;
}

// 2. Check Permissions
echo "\n<strong>2. Checking Permissions...</strong>\n";
$storage = $use_flat ? __DIR__ . '/storage' : __DIR__ . '/../storage';

if (is_dir($storage)) {
    if (is_writable($storage)) {
        echo "✅ Storage is writable.\n";
    } else {
        echo "❌ ERROR: 'storage' folder is NOT writable. Fix permissions to 775.\n";
        echo "   Path: $storage\n";
        echo "   Current Perms: " . substr(sprintf('%o', fileperms($storage)), -4) . "\n";
    }
} else {
    echo "❌ ERROR: 'storage' folder not found at $storage\n";
}

// 3. Try Load
echo "\n<strong>3. Attempting to Start Laravel...</strong>\n";
try {
    require $vendor;
    echo "✅ Composer Autoloader loaded successfully.\n";
    
    $app = require_once $bootstrap;
    
    // --- APPLY CONTROLLED FIX ---
    // This replicates what we did in index.php to verify it works.
    $app->bind('path.public', function() {
        return __DIR__;
    });
    // ---------------------------

    echo "✅ Laravel App instance created.\n";
    
    echo "<strong>Public Path Diagnosis:</strong>\n";
    echo "   - Current Dir (__DIR__): " . __DIR__ . "\n";
    echo "   - Laravel public_path(): " . public_path() . "\n";
    
    if (realpath(public_path()) === realpath(__DIR__)) {
        echo "✅ <strong>PATHS MATCH!</strong>\n";
        echo "   The fix is working in this test script.\n";
        echo "   👉 <strong>ACTION REQUIRED:</strong> You MUST upload the 'index.php' file to enable this fix for your real website.\n";
    } else {
         echo "⚠️ <strong>Mismatch:</strong> Fix did not apply.\n";
    }

    echo "\n🎉 <strong>SUCCESS!</strong> Core files are working.\n";
    echo "If you see this, the issue is likely in your .env configuration (DB credentials) or cache.\n";
    echo "Check your log file at: " . ($use_flat ? 'storage/logs/laravel.log' : '../storage/logs/laravel.log');
    
} catch (Throwable $e) {
    echo "\n❌ <strong>CRASH REPORT:</strong>\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " on line " . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString();
}

echo "</pre>";
