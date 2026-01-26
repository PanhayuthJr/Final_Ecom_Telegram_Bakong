<?php
$host = '127.0.0.1';
$user = 'root';
$pass = '';
$db   = 'laptopshop_db';

try {
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database `$db` checked/created successfully.\n";
} catch (PDOException $e) {
    die("Error: " . $e->getMessage() . "\n");
}
