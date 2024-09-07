<?php
include 'connect.php';

session_start();
$username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

// Check if username is available
if (empty($username)) {
    echo "You need to be logged in to add items to the cart.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($id > 0) {
        try {
            $conn = new PDO("mysql:host=localhost;dbname=marketplace", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Retrieve product details
            $stmt = $conn->prepare("SELECT nama_produk, harga, foto FROM produk WHERE id = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($product) {
                // Check if product is already in cart for the user
                $stmt = $conn->prepare("SELECT COUNT(*) FROM cart WHERE nama_barang = :nama_produk AND username = :username");
                $stmt->bindParam(':nama_produk', $product['nama_produk']);
                $stmt->bindParam(':username', $username);
                $stmt->execute();
                $count = $stmt->fetchColumn();

                if ($count > 0) {
                    echo "Barang sudah ada di dalam keranjang.";
                } else {
                    // Insert into cart
                    $stmt = $conn->prepare("INSERT INTO cart (nama_barang, harga_barang, foto, username) VALUES (:nama_produk, :harga, :foto, :username)");
                    $stmt->bindParam(':nama_produk', $product['nama_produk']);
                    $stmt->bindParam(':harga', $product['harga']);
                    $stmt->bindParam(':foto', $product['foto']);
                    $stmt->bindParam(':username', $username);
                    $stmt->execute();

                    echo "Product added to cart.";
                }
            } else {
                echo "Product not found.";
            }
        } catch(PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Invalid product ID.";
    }
    $conn = null;
}
?>
