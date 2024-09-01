<?php
require_once 'db.php'; // Correct path to db.php

// Your existing PDO connection setup
$dsn = 'mysql:host=localhost;dbname=ecommerce;charset=utf8';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}
?>
