<?php
// Mulai sesi
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

// Jika sudah login, tampilkan halaman detail produk
include 'connect.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=marketplace", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $conn->prepare("SELECT * FROM produk WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            $nama_produk = $product['nama_produk'];
            $harga = $product['harga'];
            $detail = $product['detail'];
            $foto = $product['foto'];
        } else {
            echo "Product not found.";
            exit;
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
} else {
    echo "Invalid product ID.";
    exit;
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($nama_produk); ?></title>
    <link rel="stylesheet" href="css/detail.css">
</head>
<body>
<div class="header">
    <a href="index.php"><img src="img/outLogo.png" alt=""></a>
    <a href="cart.php"><img src="img/cartLogo.png" alt=""></a>
</div>
<div class="container">
    <div class="image">
        <img src="img/<?php echo htmlspecialchars($foto); ?>" alt="<?php echo htmlspecialchars($nama_produk); ?>">
    </div>
    <div class="detail">
        <h1><?php echo htmlspecialchars($nama_produk); ?></h1>
        <p><?php echo htmlspecialchars($detail); ?></p>
        <p class="price">IDR <?php echo number_format($harga, 0, ',', '.'); ?></p>
        <div class="rating">
            <span>9.4</span>
            <div class="stars">
                <span>★★★★★</span>
            </div>
            <p>Like!! <span>73,289 Orang</span></p>
        </div>
        <div class="comments">
            <h2>Comment</h2>
            <div class="comment">
                <p>⭐⭐⭐⭐⭐</p>
                <p>Lorem ipsum dolor sit amet, cvolutpat ac porttitor at, euismod id neque. Curabitur id diam scelerisque eu, finibus pharetra dolor. Pellentesque luctus felis sit amet tellus blandit pharetra. Nullam quis turpis sagittis,</p>
            </div>
            <div class="comment">
                <p>⭐⭐⭐⭐⭐</p>
                <p>Lorem ipsum dolor sit amet, cvolutpat ac porttitor at, euismod id neque. Curabitur id diam scelerisque eu, finibus pharetra dolor.</p>
            </div>
        </div>
        <div class="buttons">
            <button class="add-cart">Masukan Keranjang</button>
            <button class="buy-now">Beli Sekarang</button>
        </div>
    </div>
</div>
<script src="js/detail.js"></script>
</body>
</html>
