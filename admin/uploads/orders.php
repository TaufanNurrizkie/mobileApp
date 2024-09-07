<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['order_status'];

    try {
        // Start transaction
        $conn->beginTransaction();

        if ($newStatus === 'selesai') {
            // Fetch the order data from pembayaran
            $stmt = $conn->prepare("SELECT * FROM pembayaran WHERE id = :id");
            $stmt->bindParam(':id', $orderId);
            $stmt->execute();
            $order = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($order) {
                // Insert data into history
                $insertQuery = "INSERT INTO history (id, username, total_price, payment_method, order_status, created_at) VALUES (:id, :username, :total_price, :payment_method, :order_status, :created_at)";
                $stmt = $conn->prepare($insertQuery);
                $stmt->bindParam(':id', $order['id']);
                $stmt->bindParam(':username', $order['username']);
                $stmt->bindParam(':total_price', $order['total_price']);
                $stmt->bindParam(':payment_method', $order['payment_method']);
                $stmt->bindParam(':order_status', $order['order_status']);
                $stmt->bindParam(':created_at', $order['created_at']);
                $stmt->execute();

                // Delete from pembayaran
                $deleteQuery = "DELETE FROM pembayaran WHERE id = :id";
                $stmt = $conn->prepare($deleteQuery);
                $stmt->bindParam(':id', $orderId);
                $stmt->execute();
            }
        } else {
            // Update order status
            $updateQuery = "UPDATE pembayaran SET order_status = :order_status WHERE id = :id";
            $stmt = $conn->prepare($updateQuery);
            $stmt->bindParam(':order_status', $newStatus);
            $stmt->bindParam(':id', $orderId);
            $stmt->execute();
        }

        // Commit transaction
        $conn->commit();

        // Redirect to index.php with a query parameter to load orders
        header("Location: index.php");
        exit();
    } catch (PDOException $e) {
        // Rollback transaction on error
        $conn->rollBack();
        echo "<script>alert('Terjadi kesalahan: " . $e->getMessage() . "');</script>";
    }
}

try {
    // Ambil semua data dari tabel pembayaran
    $stmt = $conn->query("SELECT * FROM pembayaran");
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Query failed: ' . $e->getMessage();
}
?>
<link rel="stylesheet" href="../css/orders.css">

<h1>Daftar Pesanan</h1>

<div class="order-cards">
    <?php foreach ($orders as $order): ?>
        <div class="order-card">
            <h2>ID Pesanan: <?php echo htmlspecialchars($order['id']); ?></h2>
            <p><strong>Username:</strong> <?php echo htmlspecialchars($order['username']); ?></p>
            <p><strong>Total Harga:</strong> IDR <?php echo htmlspecialchars(number_format($order['total_price'], 0, ',', '.')); ?></p>
            <p><strong>Metode Pembayaran:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></p>
            <p><strong>Status Pesanan:</strong> <?php echo htmlspecialchars($order['order_status']); ?></p>
            <p><strong>Tanggal:</strong> <?php echo htmlspecialchars($order['created_at']); ?></p>
            <form action="orders.php" method="POST">
                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['id']); ?>">
                <select name="order_status" required>
                    <option value="dikemas" <?php echo $order['order_status'] === 'dikemas' ? 'selected' : ''; ?>>Dikemas</option>
                    <option value="dikirim" <?php echo $order['order_status'] === 'dikirim' ? 'selected' : ''; ?>>Dikirim</option>
                    <option value="selesai" <?php echo $order['order_status'] === 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                </select>
                <button type="submit">Update Status</button>
            </form>
        </div>
    <?php endforeach; ?>
</div>
