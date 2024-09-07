<?php
// File: products.php
include 'db.php';

?>
<link rel="stylesheet" href="../css/products.css">
<h1>Daftar Produk</h1>
<a href="create.php"><img src="../../img/plusLogo.png" alt="Add Product" class="add-product"></a>

<div class="product-cards">
    <?php
    try {
        $stmt = $conn->query("SELECT * FROM produk");
        while ($product = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='product-card'>";
            echo "<img src='../img/" . htmlspecialchars($product['foto']) . "' alt='" . htmlspecialchars($product['nama_produk']) . "'>";
            echo "<h2>" . htmlspecialchars($product['nama_produk']) . "</h2>";
            echo "<p>IDR " . htmlspecialchars(number_format($product['harga'], 0, ',', '.')) . "</p>";
            echo "<p>" . htmlspecialchars($product['detail']) . "</p>";
            echo "<div class='actions'>";
            echo "<a href='update.php?id=" . htmlspecialchars($product['id']) . "' class='edit'>Edit</a>";
            echo "<a href='delete.php?id=" . htmlspecialchars($product['id']) . "' class='delete'>Delete</a>";
            echo "</div>";
            echo "</div>";
        }
    } catch (PDOException $e) {
        echo 'Query failed: ' . $e->getMessage();
    }
    ?>
</div>
