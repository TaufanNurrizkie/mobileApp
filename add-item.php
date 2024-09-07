<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
    <link rel="stylesheet" href="css/add-item.css">
</head>
<body>
    <header>
        <a href="profile.php" class="back-button"><img src="img/outLogo.png" alt=""></a>
        <h1>Add New Item</h1>
    </header>
    <main class="input-container">
        <form id="add-item-form">
            <div class="form-group">
                <label for="item-image">Item Image:</label>
                <input type="file" id="item-image" name="item-image" accept="image/*" required>
            </div>
            <div class="form-group">
                <label for="item-name">Item Name:</label>
                <input type="text" id="item-name" name="item-name" required>
            </div>
            <div class="form-group">
                <label for="item-details">Item Details:</label>
                <textarea id="item-details" name="item-details" required></textarea>
            </div>
            <div class="form-group">
                <label for="item-price">Item Price (IDR):</label>
                <input type="number" id="item-price" name="item-price" required>
            </div>
            <button type="submit">Add Item</button>
        </form>
    </main>
    <script src="js/add-item.js"></script>
</body>
</html>
