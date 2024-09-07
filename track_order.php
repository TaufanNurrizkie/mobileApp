<?php
include 'connect.php';
session_start();

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Jika belum login, simpan URL tujuan dalam sesi
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

    // Tampilkan halaman konfirmasi
    include 'confirm_login.php';

    // Proses jika pengguna mengklik salah satu tombol
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['login'])) {
            // Redirect ke halaman login dengan URL tujuan
            $redirect_url = urlencode($_SESSION['redirect_url']);
            header("Location: login.php?redirect=$redirect_url");
            exit;
        } elseif (isset($_POST['cancel'])) {
            // Redirect ke halaman utama
            header("Location: index.php");
            exit;
        }
    }

    exit; // Hentikan eksekusi lebih lanjut
}

$username = $_SESSION['username'];

$query = "SELECT * FROM pembayaran WHERE username = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$username]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Pesanan</title>
    <link rel="stylesheet" href="css/track-order.css">
</head>
<body>
    <h1>Track Pesanan Anda</h1>
    <div class="order-cards-container">
        <?php foreach ($orders as $order): ?>
            <div class="order-card">
                <h3>Order ID: <?php echo htmlspecialchars($order['order_id']); ?></h3>
                <p>Total Harga: Rp <?php echo htmlspecialchars(number_format($order['total_price'], 2)); ?></p>
                <p>Metode Pembayaran: <?php echo htmlspecialchars($order['payment_method']); ?></p>
                <p>Status: <?php echo htmlspecialchars($order['order_status']); ?></p>
                <p>Waktu Pesan: <?php echo htmlspecialchars($order['created_at']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
