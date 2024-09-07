<?php
include 'db.php';

$id = $_GET['id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_produk = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $foto = $_FILES['foto']['name'];

    if ($foto) {
        $target = "../img/" . basename($foto);
        move_uploaded_file($_FILES['foto']['tmp_name'], $target);
        $stmt = $conn->prepare("UPDATE produk SET nama_produk = :nama_produk, harga = :harga, foto = :foto WHERE id = :id");
        $stmt->bindParam(':foto', $foto);
    } else {
        $stmt = $conn->prepare("UPDATE produk SET nama_produk = :nama_produk, harga = :harga WHERE id = :id");
    }

    $stmt->bindParam(':nama_produk', $nama_produk);
    $stmt->bindParam(':harga', $harga);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        header("Location: index.php");
    } else {
        echo "Error: Could not update product.";
    }
}

$stmt = $conn->prepare("SELECT * FROM produk WHERE id = :id");
$stmt->bindParam(':id', $id);
$stmt->execute();
$product = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../css/update.css">
</head>
<body>
    <h1>Edit Product</h1>
    <form action="update.php?id=<?php echo $product['id']; ?>" method="POST" enctype="multipart/form-data">
        <label for="nama_produk">Name:</label>
        <input type="text" id="nama_produk" name="nama_produk" value="<?php echo $product['nama_produk']; ?>" required>
        <label for="harga">Price:</label>
        <input type="text" id="harga" name="harga" value="<?php echo $product['harga']; ?>" required>
        <label for="foto">Photo:</label>
        <input type="file" id="foto" name="foto">
        <img src="img/<?php echo $product['foto']; ?>" width="100">
        <input type="submit" value="Update Product">
    </form>
    <a href="index.php">Back to List</a>
</body>
</html>
