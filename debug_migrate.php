<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

try {
    $status = $kernel->call('migrate:fresh', ['--seed' => true, '--force' => true]);
    file_put_contents('artisan_error.txt', $kernel->output());
} catch (Exception $e) {
    file_put_contents('artisan_error.txt', $e->getMessage() . "\n" . $e->getTraceAsString());
}


