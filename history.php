<?php
session_start();
require 'connect.php';

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['username'];

// Ambil data dari tabel history berdasarkan username
$stmt = $pdo->prepare('SELECT * FROM history WHERE username = ? ORDER BY created_at DESC');
$stmt->execute([$username]);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History</title>
    <link rel="stylesheet" href="css/history.css"> <!-- Sesuaikan dengan path CSS Anda -->
</head>
<body>
    <div class="container">
        <h1>Order History</h1>
        <?php if (count($orders) > 0): ?>
            <?php foreach ($orders as $order): ?>
                <div class="order-card">
                    <h2>Order ID: <?= htmlspecialchars($order['id']) ?></h2>
                    <p>Total Price: <?= htmlspecialchars($order['total_price']) ?></p>
                    <p>Payment Method: <?= htmlspecialchars($order['payment_method']) ?></p>
                    <p>Status: <?= htmlspecialchars($order['order_status']) ?></p>
                    <p>Ordered on: <?= htmlspecialchars($order['created_at']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No order history found.</p>
        <?php endif; ?>

        <!-- Tombol Back -->
        <button onclick="window.history.back();" class="back-button">Back</button>
    </div>
</body>
</html>
