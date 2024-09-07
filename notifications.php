<?php
session_start();
include 'connect.php';

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

$user_id = $_SESSION['user_id']; // Dapatkan user_id dari session

// Ambil notifikasi dari database
try {
    $stmt = $pdo->prepare('SELECT * FROM notifications WHERE user_id = :user_id ORDER BY created_at DESC');
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Query failed: ' . $e->getMessage();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi Saya</title>
    <link rel="stylesheet" href="css/notif.css">
</head>
<body>
    <div class="notification-container">
        <h1>Notifikasi Saya</h1>
        <?php if (count($notifications) > 0): ?>
            <ul class="notifications-list">
                <?php foreach ($notifications as $notification): ?>
                    <li class="<?= $notification['is_read'] ? 'read' : 'unread' ?>" data-id="<?= htmlspecialchars($notification['id'], ENT_QUOTES, 'UTF-8') ?>">
                        <p><?= htmlspecialchars($notification['message'], ENT_QUOTES, 'UTF-8') ?></p>
                        <small><?= date('d M Y, H:i', strtotime($notification['created_at'])) ?></small>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Tidak ada notifikasi.</p>
        <?php endif; ?>
    </div>

    <script>
        document.querySelectorAll('.unread').forEach(item => {
            item.addEventListener('click', () => {
                const listItem = item;
                const notificationId = listItem.dataset.id;
                fetch('mark-as-read.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        'id': notificationId
                    }).toString()
                })
                .then(response => response.text())
                .then(result => {
                    if (result === 'success') {
                        listItem.classList.remove('unread');
                        listItem.classList.add('read');
                    } else {
                        console.error('Failed to mark notification as read.');
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    </script>
</body>
</html>
<?php
$pdo = null; // Tutup koneksi PDO
?>
