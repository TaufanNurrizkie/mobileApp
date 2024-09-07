<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $detail = $_POST['detail'];
    $foto = $_FILES['foto']['name'];
    $target = "../img/" . basename($foto); // Ubah target direktori ke img

    // Upload file
    if (move_uploaded_file($_FILES['foto']['tmp_name'], $target)) {
        $stmt = $conn->prepare("INSERT INTO produk (nama_produk, harga, detail, foto) VALUES (:nama_produk, :harga, :detail, :foto)");
        $stmt->bindParam(':nama_produk', $nama_produk);
        $stmt->bindParam(':harga', $harga);
        $stmt->bindParam(':detail', $detail);
        $stmt->bindParam(':foto', $foto);

        if ($stmt->execute()) {
            header("Location: index.php");
        } else {
            echo "Error: Could not add product.";
        }
    } else {
        echo "Error: Could not upload file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <link rel="stylesheet" href="../css/create.css">
</head>
<body>
    <div class="back-button">
        <img src="img/outLogo.png" alt="" id="out">
    </div>
    <h1>Add New Product</h1>
    <form action="create.php" method="POST" enctype="multipart/form-data">
        <label for="nama_produk">Name:</label>
        <input type="text" id="nama_produk" name="nama_produk" required>
        <label for="harga">Price:</label>
        <input type="number" id="harga" name="harga" required>
        <label for="detail">Detail:</label>
        <textarea id="detail" name="detail" required></textarea>
        <label for="foto">Photo:</label>
        <input type="file" id="foto" name="foto" required>
        <input type="submit" value="Add Product">
    </form>
</body>
</html>
