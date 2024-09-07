<?php
// Mulai sesi
session_start();

require 'connect.php';

// Periksa apakah form login sudah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validasi sederhana
    if (empty($username) || empty($password)) {
        echo '<script>alert("Please fill in both fields."); window.location.href = "login.php";</script>';
        exit;
    }

    // Cek data di database
    try {
        $sql = "SELECT * FROM user WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Simpan informasi login di sesi
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user['id']; // Menyimpan user_id untuk keperluan lain
            $_SESSION['status'] = $user['status'];

            // Regenerasi ID sesi untuk keamanan
            session_regenerate_id(true);

            // Arahkan pengguna berdasarkan status atau redirect URL
            if (isset($_GET['redirect']) && !empty($_GET['redirect'])) {
                $redirect_url = urldecode($_GET['redirect']);
                header("Location: $redirect_url");
            } else if ($user['status'] == 'admin') {
                header('Location: admin/uploads/index.php');
            } else {
                header('Location: index.php');
            }
            exit();
        } else {
            echo '<script>alert("Invalid username or password."); window.location.href = "login.php";</script>';
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
