<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            display: flex;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        #sidebar {
            width: 200px;
            background-color: #333;
            color: #fff;
            height: 100vh;
            padding-top: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }
        #sidebar button, #sidebar a {
            display: block;
            width: 100%;
            padding: 10px;
            background: none;
            border: none;
            color: #fff;
            text-align: left;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none; /* Ensure no underline on links */
        }
        #sidebar button:hover, #sidebar a:hover {
            background-color: #444;
        }
        #content {
            flex-grow: 1;
            padding: 20px;
            background-color: #f4f4f4;
            min-height: 100vh; /* Ensure content area covers the full height */
        }
        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
        }
        .modal button {
            padding: 10px 20px;
            margin: 5px;
            border: none;
            cursor: pointer;
        }
        .modal button.confirm {
            background: #2FAD91;
            color: #fff;
        }
        .modal button.cancel {
            background: #f44;
            color: #fff;
        }
    </style>
</head>
<body>
    <div id="sidebar">
        <button onclick="loadContent('notifications.php')">Kirim Notifikasi</button>
        <button onclick="loadContent('products.php')">Daftar Produk</button>
        <button onclick="loadContent('orders.php')">Daftar Pesanan</button>
        <a href="#" onclick="showModal()">Log out</a>
    </div>
    <div id="content">
        <h2>Selamat Datang di Admin Panel</h2>
        <p>Silakan pilih salah satu opsi di sidebar untuk menampilkan konten.</p>
    </div>

    <!-- Modal HTML -->
    <div id="logoutModal" class="modal">
        <div class="modal-content">
            <h2>Konfirmasi Log Out</h2>
            <p>Apakah Anda yakin ingin log out?</p>
            <button class="confirm" onclick="logout()">Log out</button>
            <button class="cancel" onclick="closeModal()">Batal</button>
        </div>
    </div>

    <script>
        function loadContent(page) {
            const xhttp = new XMLHttpRequest();
            xhttp.onload = function() {
                document.getElementById('content').innerHTML = this.responseText;
            }
            xhttp.open("GET", page, true);
            xhttp.send();
        }

        function showModal() {
            document.getElementById('logoutModal').style.display = 'flex';
        }

        function closeModal() {
            document.getElementById('logoutModal').style.display = 'none';
        }

        function logout() {
            window.location.href = "logout.php";
        }
    </script>
</body>
</html>
