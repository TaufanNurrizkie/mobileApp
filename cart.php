<?php
include 'connect.php';

session_start();
// Assume you have a way to get the logged-in user's username
$username = $_SESSION['username'];

try {
    $conn = new PDO("mysql:host=localhost;dbname=marketplace", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Retrieve cart items for the logged-in user
    $stmt = $conn->prepare("SELECT * FROM cart WHERE username = ?");
    $stmt->execute([$username]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Output HTML with embedded PHP
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cart</title>
        <link rel="stylesheet" href="css/cart.css">
    </head>
    <body>
        <div class="back-button">
            <a href="index.php"><img src="img/outLogo2.png" alt="" id="out"></a>
        </div>
        <div class="container">
            <div class="cart-header">
                <h2>Shopping Cart</h2>
            </div>
            <div class="cart-items" id="cart-items">
                <?php if (count($cartItems) > 0): ?>
                    <?php foreach ($cartItems as $item): ?>
                        <div class="cart-item" data-price="<?php echo htmlspecialchars($item['harga_barang']); ?>" data-id="<?php echo htmlspecialchars($item['id']); ?>">
                            <input type="checkbox" class="select-item">
                            <img src="img/<?php echo htmlspecialchars($item['foto']); ?>" alt="<?php echo htmlspecialchars($item['nama_barang']); ?>">
                            <div class="item-details">
                                <h3><?php echo htmlspecialchars($item['nama_barang']); ?></h3>
                                <p>IDR <?php echo number_format($item['harga_barang'], 0, ',', '.'); ?></p>
                            </div>
                            <div class="item-quantity">
                                <button class="quantity-btn" onclick="updateQuantity(this, -1)">-</button>
                                <input type="text" class="quantity-input" value="1" readonly>
                                <button class="quantity-btn" onclick="updateQuantity(this, 1)">+</button>
                            </div>
                            <div class="remove btn">
                                <img src="img/trashLogo.png" style="width: 35px; height: 35px;" class="remove-btn" onclick="removeItem(<?php echo htmlspecialchars($item['id']); ?>)"></img src="img/trashLogo.png">
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No items in cart.</p>
                <?php endif; ?>
            </div>
        </div>
        <div class="cart-footer">
            <div class="total-price">
                <span>Total: </span><span id="total-price">IDR 0</span>
            </div>
            <button class="buy-button" onclick="proceedToCheckout()">Buy</button>
        </div>
        <script src="js/cart.js"></script>
        <script>
            // Assuming totalPrice is calculated in your PHP code and passed to JavaScript
            const totalPrice = <?php echo json_encode(number_format($totalPrice, 0, ',', '.')); ?>;
            saveTotalPriceToLocalStorage('IDR ' + totalPrice);
        </script>
    </body>
    </html>
    <?php
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
