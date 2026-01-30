<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

echo "<h1>🖼️ Image Diagnostic Tool</h1>";
echo "<pre style='background:#f4f4f4;padding:15px;border-radius:5px;'>";

// 1. Check Path Binding
echo "<strong>1. Path Check</strong>\n";
echo "Current Directory (__DIR__): " . __DIR__ . "\n";
if (function_exists('public_path')) {
    echo "Laravel public_path():       " . public_path() . "\n";
    
    if (realpath(__DIR__) == realpath(public_path())) {
         echo "✅ STATUS: PATHS MATCH (The index.php fix is working!)\n";
    } else {
         echo "❌ STATUS: MISMATCH (index.php fix NOT working or not loaded)\n";
    }
} else {
    // Try to bootstrap laravel just to check
    echo "Laravel not loaded via web request. Attempting manual load...\n";
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    
    // Apply the fix MANUALLY to test
    $app->bind('path.public', function() { return __DIR__; });
    
    echo "Laravel public_path() [Simulated]: " . public_path() . "\n";
}

// 2. Check Directory
echo "\n<strong>2. File System Check</strong>\n";
$imgDir = __DIR__ . '/img/products';

if (is_dir($imgDir)) {
    echo "✅ Directory found: $imgDir\n";
    echo "Permissions: " . substr(sprintf('%o', fileperms($imgDir)), -4) . "\n";
    
    // List files
    $files = scandir($imgDir);
    $files = array_diff($files, ['.', '..']);
    
    echo "<strong>Files found (" . count($files) . "):</strong>\n";
    if (count($files) > 0) {
        foreach ($files as $file) {
            $path = $imgDir . '/' . $file;
            $size = round(filesize($path) / 1024, 2);
            $time = date("Y-m-d H:i:s", filemtime($path));
            echo " - $file ($size KB) - Last Modified: $time\n";
        }
    } else {
        echo "⚠️ Directory is empty!\n";
    }
} else {
    echo "❌ Directory NOT found: $imgDir\n";
    echo "   (This means images are not saving here)\n";
}

echo "</pre>";

// 3. Visual Test
if (is_dir($imgDir) && count($files) > 0) {
    echo "<h3>Visual Test</h3>";
    echo "<div style='display:flex;flex-wrap:wrap;gap:10px;'>";
    foreach ($files as $file) {
        $url = '/img/products/' . $file;
        echo "<div style='border:1px solid #ccc;padding:5px;'>";
        echo "<img src='$url' style='height:100px;width:auto;display:block;' alt='Image broken'>";
        echo "<small>$file</small>";
        echo "</div>";
    }
    echo "</div>";
}
?>
