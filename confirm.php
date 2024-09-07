<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Payment</title>
    <link rel="stylesheet" href="css/confirm.css">
</head>
<body>
    <header>
       <img src="img/outLogo.png" alt="Back" id="backButton">
        <h1>Confirm Payment</h1>
    </header>
    <main class="confirm-container">
        <h2>Please enter your password to confirm the payment:</h2>
        <form id="confirm-form">
            <input type="password" id="password-input" placeholder="Enter your password" required>
            <input type="hidden" id="order-id">
            <input type="hidden" id="total-price">
            <input type="hidden" id="item-name">
            <button type="submit">Confirm</button>
        </form>
    </main>
    <script src="js/confirm.js"></script>
</body>
</html>
