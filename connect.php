<?php
$host = 'localhost'; // Ganti dengan host database Anda
$db = 'marketplace'; // Nama database Anda
$user = 'root'; // Nama pengguna database Anda
$pass = ''; // Kata sandi database Anda

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
