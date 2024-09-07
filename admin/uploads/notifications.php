<?php
// File: notifications.php
include 'db.php';

?>

<link rel="stylesheet" href="../css/notifications.css">
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
