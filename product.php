<div class="header">
        <div class="search-bar">
            <input type="text" placeholder="Cari di TIX ID">
        </div>
        <div class="profile-icon">
            <a href="https://wa.me/6283100471963?text=Hello%2C%20I%20would%20like%20to%20know%20more%20about%20your%20services%21
"><img src="img/messageLogo2.png" alt="Chat Icon"></a>
        </div>
        <div class="profile-icon">
            <a href="profile.php" ><img src="img/profileLogo2.png" alt="Profile Icon"></a>
        </div>
</div>

<div class="carousel">
    <div class="carousel-images">
        <img src="img/promo1.webp" alt="Slide 1">
        <img src="img/promo2.webp" alt="Slide 2">
        <img src="img/promo3.webp" alt="Slide 3">
        <img src="img/promo4.webp" alt="Slide 3">
        <img src="img/promo5.webp" alt="Slide 3">
        <img src="img/promo6.webp" alt="Slide 3">
        <img src="img/promo7.webp" alt="Slide 3">
    </div>
    <button class="carousel-control prev" onclick="moveSlide(-1)">&#10094;</button>
    <button class="carousel-control next" onclick="moveSlide(1)">&#10095;</button>
</div>

<div class="section-title">Most Like</div>
<div class="products" id="products">
    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "marketplace";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch products with most_like = 1
        $stmt = $conn->prepare("SELECT id, nama_produk, harga, foto FROM produk WHERE most_like = 1");
        $stmt->execute();

        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            // echo "<a href='detail.php?id=" . $row['id'] . "' class='product-card'>";
            echo '<a href="#" onclick="loadPage(\'detail.php?id=' . $row['id'] . '\')" class="product-card">';
            echo "<img src='img/" . $row['foto'] . "' alt='" . $row['nama_produk'] . "'>";
            echo "<div class='product-title'>" . $row['nama_produk'] . "</div>";
            echo "<div class='product-price'>IDR " . number_format($row['harga'], 0, ',', '.') . "</div>";
            echo "</a>";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
    ?>
</div>

<div class="section-title">MAPS</div>
<div class="maps">
    <img src="img/maps.png" alt="Map" style="width: 100%; border-radius: 10px;">
</div>

<div class="section-title">Product</div>
<div class="button-bar">
        <a href="#" onclick="loadPage('figure.php')">Figure</a>
        <a href="#" onclick="loadPage('manga.php')">Manga</a>
        <a href="#" onclick="loadPage('merchandise.php')">Merchandise</a>
    </div>
<div class="products-two-columns">
    <?php
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Fetch all products (no filter for this section)
        $stmt = $conn->prepare("SELECT id, nama_produk, harga, foto FROM produk");
        $stmt->execute();

        $result = $stmt->fetchAll();

        foreach ($result as $row) {
            echo "<a href='detail.php?id=" . $row['id'] . "' class='product-card'>";
            echo "<img src='img/" . $row['foto'] . "' alt='" . $row['nama_produk'] . "'>";
            echo "<div class='product-title'>" . $row['nama_produk'] . "</div>";
            echo "<div class='product-price'>IDR " . number_format($row['harga'], 0, ',', '.') . "</div>";
            echo "</a>";
        }
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
    ?>
</div>
<script src="js/main.js"></script>
