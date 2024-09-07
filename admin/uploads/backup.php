<?php
include 'db.php';
session_start();

// Periksa apakah admin telah login
if (!isset($_SESSION['loggedin']) || $_SESSION['status'] !== 'admin') {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'])) {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['order_status'];

    try {
        // Update order status
        $updateQuery = "UPDATE pembayaran SET order_status = ? WHERE id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->execute([$newStatus, $orderId]);

        echo "<script>alert('Status pesanan berhasil diperbarui');</script>";
    } catch (PDOException $e) {
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Kirim Notifikasi</h1>
    <form action="send_notification.php" method="POST">
        <label for="recipient">Pilih Penerima:</label>
        <select name="recipient_type" id="recipient" required>
            <option value="all">Semua Pengguna</option>
            <option value="selected">Pengguna Terpilih</option>
        </select>
        
        <div id="selected-users" style="display: none;">
            <label for="user">Pilih Pengguna:</label>
            <select name="user_id" id="user">
                <?php
                try {
                    $stmt = $conn->query("SELECT id, username FROM user");
                    while ($user = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        echo "<option value='{$user['id']}'>{$user['username']}</option>";
                    }
                } catch (PDOException $e) {
                    echo '<option disabled>Gagal memuat pengguna</option>';
                }
                ?>
            </select>
        </div>
        
        <label for="message">Pesan:</label>
        <textarea name="message" id="message" rows="4" required></textarea>
        
        <button type="submit">Kirim Notifikasi</button>
    </form>

    <h1>Daftar Produk</h1>
    <a href="create.php"><img src="../../img/plusLogo.png" alt="Add Product"></a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Detail</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            try {
                $stmt = $conn->query("SELECT * FROM produk");
                while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($product['id']) . "</td>";
                    echo "<td>" . htmlspecialchars($product['nama_produk']) . "</td>";
                    echo "<td>IDR " . htmlspecialchars(number_format($product['harga'], 0, ',', '.')) . "</td>";
                    echo "<td>" . htmlspecialchars($product['detail']) . "</td>";
                    echo "<td><img src='../img/" . htmlspecialchars($product['foto']) . "' alt='" . htmlspecialchars($product['nama_produk']) . "' width='100'></td>";
                    echo "<td>
                           <button class='edit'><a href='update.php?id=" . htmlspecialchars($product['id']) . "'>Edit</a></button> |
                           <button class='delete'><a href='delete.php?id=" . htmlspecialchars($product['id']) . "'>Delete</a></button>
                          </td>";
                    echo "</tr>";
                }
            } catch (PDOException $e) {
                echo 'Query failed: ' . $e->getMessage();
            }
            ?>
        </tbody>
    </table>
    
    <h1>Daftar Pesanan</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Total Harga</th>
                <th>Metode Pembayaran</th>
                <th>Status Pesanan</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['id']); ?></td>
                    <td><?php echo htmlspecialchars($order['username']); ?></td>
                    <td>IDR <?php echo htmlspecialchars(number_format($order['total_price'], 0, ',', '.')); ?></td>
                    <td><?php echo htmlspecialchars($order['payment_method']); ?></td>
                    <td><?php echo htmlspecialchars($order['order_status']); ?></td>
                    <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                    <td>
                        <form action="index.php" method="POST">
                            <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['id']); ?>">
                            <select name="order_status" required>
                                <option value="dikemas" <?php echo $order['order_status'] === 'dikemas' ? 'selected' : ''; ?>>Dikemas</option>
                                <option value="dikirim" <?php echo $order['order_status'] === 'dikirim' ? 'selected' : ''; ?>>Dikirim</option>
                                <option value="selesai" <?php echo $order['order_status'] === 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                            </select>
                            <button type="submit">Update Status</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script>
        document.getElementById('recipient').addEventListener('change', function() {
            var selectedValue = this.value;
            var selectedUsersDiv = document.getElementById('selected-users');
            if (selectedValue === 'selected') {
                selectedUsersDiv.style.display = 'block';
            } else {
                selectedUsersDiv.style.display = 'none';
            }
        });
    </script>
</body>
</html>
