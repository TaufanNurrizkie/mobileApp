<?php
require 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $_POST['username'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $password = $_POST['password'];
    $retype = $_POST['retype'];

    // Validasi sederhana
    if (empty($username) || empty($email) || empty($alamat) || empty($password) || empty($retype)) {
        die('Please fill in all fields.');
    } elseif ($password !== $retype) {
        die('Passwords do not match.');
    } else {
        // Hash password sebelum disimpan ke database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Masukkan data ke database
        try {
            $sql = "INSERT INTO user (username, password, email, alamat, status) VALUES (:username, :password, :email, :alamat, :status)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':username' => $username,
                ':password' => $hashed_password,
                ':email' => $email,
                ':alamat' => $alamat,
                ':status' => 'user',
            ]);
            // Redirect ke main.php setelah berhasil sign in
            header('Location: login.php');
            exit();
        } catch (PDOException $e) {
            die("Error: " . $e->getMessage());
        }
    }
}
?>
