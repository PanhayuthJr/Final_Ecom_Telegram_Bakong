<?php
/**
 * Laravel cPanel Installation Checker
 * Upload this to your public_html folder and visit it in your browser
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laravel Installation Check</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 900px; margin: 50px auto; padding: 20px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #e74c3c; border-bottom: 3px solid #e74c3c; padding-bottom: 10px; }
        h2 { color: #3498db; margin-top: 30px; }
        .check { margin: 15px 0; padding: 10px; border-left: 4px solid #ccc; background: #f9f9f9; }
        .success { border-left-color: #27ae60; background: #d4edda; }
        .error { border-left-color: #e74c3c; background: #f8d7da; }
        .warning { border-left-color: #f39c12; background: #fff3cd; }
        .info { border-left-color: #3498db; background: #d1ecf1; }
        code { background: #2c3e50; color: #ecf0f1; padding: 2px 6px; border-radius: 3px; font-size: 12px; }
        pre { background: #2c3e50; color: #ecf0f1; padding: 15px; border-radius: 5px; overflow-x: auto; }
        .label { font-weight: bold; display: inline-block; min-width: 200px; }
        .value { color: #555; }
        .section { margin: 20px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Laravel Installation Diagnostic Report</h1>
        <p><strong>Time:</strong> <?php echo date('Y-m-d H:i:s'); ?></p>
        <p><strong>Domain:</strong> <?php echo $_SERVER['HTTP_HOST'] ?? 'Unknown'; ?></p>

        <?php
        $errors = [];
        $warnings = [];
        $success = [];

        // 1. PHP Version Check
        echo '<h2>1. PHP Environment</h2>';
        $phpVersion = phpversion();
        if (version_compare($phpVersion, '8.2.0', '>=')) {
            echo "<div class='check success'><span class='label'>✅ PHP Version:</span> <span class='value'>$phpVersion (Good!)</span></div>";
            $success[] = 'PHP version is compatible';
        } elseif (version_compare($phpVersion, '8.1.0', '>=')) {
            echo "<div class='check warning'><span class='label'>⚠️ PHP Version:</span> <span class='value'>$phpVersion (Works, but 8.2+ recommended)</span></div>";
            $warnings[] = 'PHP version should be upgraded to 8.2+';
        } else {
            echo "<div class='check error'><span class='label'>❌ PHP Version:</span> <span class='value'>$phpVersion (Too old! Need 8.2+)</span></div>";
            $errors[] = 'PHP version is too old. Laravel 12 requires PHP 8.2+';
        }

        // 2. Required Extensions
        echo '<h2>2. Required PHP Extensions</h2>';
        $requiredExtensions = [
            'openssl' => 'OpenSSL',
            'pdo' => 'PDO',
            'pdo_mysql' => 'PDO MySQL',
            'mbstring' => 'Mbstring',
            'tokenizer' => 'Tokenizer',
            'xml' => 'XML',
            'ctype' => 'Ctype',
            'json' => 'JSON',
            'bcmath' => 'BCMath',
            'fileinfo' => 'Fileinfo',
            'curl' => 'cURL',
        ];

        foreach ($requiredExtensions as $ext => $name) {
            if (extension_loaded($ext)) {
                echo "<div class='check success'><span class='label'>✅ $name:</span> <span class='value'>Enabled</span></div>";
            } else {
                echo "<div class='check error'><span class='label'>❌ $name:</span> <span class='value'>Missing</span></div>";
                $errors[] = "$name extension is required";
            }
        }

        // 3. File Structure Check
        echo '<h2>3. File Structure</h2>';
        $currentDir = __DIR__;
        echo "<div class='check info'><span class='label'>📁 Current Directory:</span> <span class='value'><code>$currentDir</code></span></div>";

        // Check for Laravel files
        $laravelFiles = [
            'index.php' => 'Entry Point',
            '../vendor/autoload.php' => 'Composer Autoloader',
            '../bootstrap/app.php' => 'Laravel Bootstrap',
            '../.env' => 'Environment File',
            '../artisan' => 'Artisan CLI',
        ];

        foreach ($laravelFiles as $file => $description) {
            $fullPath = realpath(__DIR__ . '/' . $file);
            if (file_exists(__DIR__ . '/' . $file)) {
                echo "<div class='check success'><span class='label'>✅ $description:</span> <span class='value'><code>$fullPath</code></span></div>";
            } else {
                echo "<div class='check error'><span class='label'>❌ $description:</span> <span class='value'>Not found at <code>" . __DIR__ . "/$file</code></span></div>";
                $errors[] = "$description is missing";
            }
        }

        // 4. Permissions Check
        echo '<h2>4. Directory Permissions</h2>';
        $writableDirs = [
            '../storage' => 'Storage',
            '../storage/framework' => 'Storage Framework',
            '../storage/logs' => 'Storage Logs',
            '../bootstrap/cache' => 'Bootstrap Cache',
        ];

        foreach ($writableDirs as $dir => $name) {
            $fullPath = __DIR__ . '/' . $dir;
            if (is_dir($fullPath)) {
                if (is_writable($fullPath)) {
                    $perms = substr(sprintf('%o', fileperms($fullPath)), -4);
                    echo "<div class='check success'><span class='label'>✅ $name:</span> <span class='value'>Writable (Permissions: $perms)</span></div>";
                } else {
                    $perms = substr(sprintf('%o', fileperms($fullPath)), -4);
                    echo "<div class='check error'><span class='label'>❌ $name:</span> <span class='value'>Not writable (Permissions: $perms)</span></div>";
                    $errors[] = "$name directory is not writable";
                }
            } else {
                echo "<div class='check error'><span class='label'>❌ $name:</span> <span class='value'>Directory not found</span></div>";
                $errors[] = "$name directory does not exist";
            }
        }

        // 5. .env File Check
        echo '<h2>5. Environment Configuration</h2>';
        $envPath = __DIR__ . '/../.env';
        if (file_exists($envPath)) {
            echo "<div class='check success'><span class='label'>✅ .env File:</span> <span class='value'>Found</span></div>";
            
            $envContent = file_get_contents($envPath);
            $envLines = explode("\n", $envContent);
            
            $envChecks = [
                'APP_KEY' => 'Application Key',
                'APP_ENV' => 'Environment',
                'APP_DEBUG' => 'Debug Mode',
                'DB_CONNECTION' => 'Database Connection',
                'DB_HOST' => 'Database Host',
                'DB_DATABASE' => 'Database Name',
                'DB_USERNAME' => 'Database User',
            ];

            foreach ($envChecks as $key => $description) {
                $found = false;
                $value = '';
                foreach ($envLines as $line) {
                    if (strpos(trim($line), $key . '=') === 0) {
                        $found = true;
                        $parts = explode('=', $line, 2);
                        $value = isset($parts[1]) ? trim($parts[1]) : '';
                        break;
                    }
                }

                if ($found) {
                    if ($key === 'APP_KEY' && (empty($value) || $value === 'base64:')) {
                        echo "<div class='check error'><span class='label'>❌ $description:</span> <span class='value'>Empty! Run: php artisan key:generate</span></div>";
                        $errors[] = "APP_KEY is not set";
                    } elseif ($key === 'APP_DEBUG' && $value === 'true') {
                        echo "<div class='check warning'><span class='label'>⚠️ $description:</span> <span class='value'>Enabled (Should be false in production)</span></div>";
                        $warnings[] = "APP_DEBUG should be false in production";
                    } elseif ($key === 'APP_ENV' && $value !== 'production') {
                        echo "<div class='check warning'><span class='label'>⚠️ $description:</span> <span class='value'>$value (Should be 'production')</span></div>";
                        $warnings[] = "APP_ENV should be 'production'";
                    } else {
                        $displayValue = in_array($key, ['DB_PASSWORD', 'APP_KEY']) ? '***hidden***' : $value;
                        echo "<div class='check success'><span class='label'>✅ $description:</span> <span class='value'>$displayValue</span></div>";
                    }
                } else {
                    echo "<div class='check error'><span class='label'>❌ $description:</span> <span class='value'>Not set</span></div>";
                    $errors[] = "$description is not configured";
                }
            }
        } else {
            echo "<div class='check error'><span class='label'>❌ .env File:</span> <span class='value'>Not found!</span></div>";
            $errors[] = ".env file is missing";
        }

        // 6. Test Autoloader
        echo '<h2>6. Composer Autoloader Test</h2>';
        $autoloadPath = __DIR__ . '/../vendor/autoload.php';
        if (file_exists($autoloadPath)) {
            try {
                require_once $autoloadPath;
                echo "<div class='check success'><span class='label'>✅ Autoloader:</span> <span class='value'>Loaded successfully</span></div>";
            } catch (Exception $e) {
                echo "<div class='check error'><span class='label'>❌ Autoloader:</span> <span class='value'>Error: " . htmlspecialchars($e->getMessage()) . "</span></div>";
                $errors[] = "Composer autoloader failed to load";
            }
        } else {
            echo "<div class='check error'><span class='label'>❌ Autoloader:</span> <span class='value'>vendor/autoload.php not found</span></div>";
            $errors[] = "Composer dependencies not installed";
        }

        // 7. Summary
        echo '<h2>📊 Summary</h2>';
        
        if (empty($errors)) {
            echo "<div class='check success'>";
            echo "<h3 style='margin-top:0;'>✅ All Critical Checks Passed!</h3>";
            echo "<p>Your Laravel installation looks good. If you're still seeing errors, check:</p>";
            echo "<ul>";
            echo "<li>Database connection (verify credentials in .env)</li>";
            echo "<li>Error logs in cPanel or storage/logs/laravel.log</li>";
            echo "<li>Temporarily set APP_DEBUG=true to see detailed errors</li>";
            echo "</ul>";
            echo "</div>";
        } else {
            echo "<div class='check error'>";
            echo "<h3 style='margin-top:0;'>❌ Critical Issues Found</h3>";
            echo "<ol>";
            foreach ($errors as $error) {
                echo "<li>" . htmlspecialchars($error) . "</li>";
            }
            echo "</ol>";
            echo "</div>";
        }

        if (!empty($warnings)) {
            echo "<div class='check warning'>";
            echo "<h3 style='margin-top:0;'>⚠️ Warnings</h3>";
            echo "<ol>";
            foreach ($warnings as $warning) {
                echo "<li>" . htmlspecialchars($warning) . "</li>";
            }
            echo "</ol>";
            echo "</div>";
        }

        // 8. Next Steps
        echo '<h2>🎯 Next Steps</h2>';
        echo "<div class='check info'>";
        echo "<ol>";
        echo "<li><strong>Fix any errors listed above</strong></li>";
        echo "<li><strong>Check your .env file</strong> - Verify database credentials</li>";
        echo "<li><strong>Set permissions:</strong> storage/ and bootstrap/cache/ to 775</li>";
        echo "<li><strong>Clear cache:</strong> Delete files in bootstrap/cache/ and storage/framework/</li>";
        echo "<li><strong>Check error logs:</strong> Look at storage/logs/laravel.log</li>";
        echo "<li><strong>Test database:</strong> Try connecting with the credentials in your .env</li>";
        echo "</ol>";
        echo "</div>";

        // 9. System Info
        echo '<h2>💻 System Information</h2>';
        echo "<div class='section'>";
        echo "<div class='check info'><span class='label'>Server Software:</span> <span class='value'>" . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown') . "</span></div>";
        echo "<div class='check info'><span class='label'>Document Root:</span> <span class='value'><code>" . ($_SERVER['DOCUMENT_ROOT'] ?? 'Unknown') . "</code></span></div>";
        echo "<div class='check info'><span class='label'>Script Filename:</span> <span class='value'><code>" . ($_SERVER['SCRIPT_FILENAME'] ?? 'Unknown') . "</code></span></div>";
        echo "<div class='check info'><span class='label'>PHP SAPI:</span> <span class='value'>" . php_sapi_name() . "</span></div>";
        echo "</div>";

        ?>

        <div style="margin-top: 30px; padding: 15px; background: #fff3cd; border-left: 4px solid #f39c12; border-radius: 4px;">
            <strong>⚠️ Security Note:</strong> Delete this file after diagnosing your issue!
        </div>
    </div>
</body>
</html>
