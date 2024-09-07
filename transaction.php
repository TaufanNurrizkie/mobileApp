<?php
session_start();
require_once 'connect.php';

// Extract data from the query string
$items = [];
$totalPrice = 0;

if (isset($_GET['name']) && isset($_GET['price']) && isset($_GET['quantity'])) {
    $names = $_GET['name'];
    $prices = $_GET['price'];
    $quantities = $_GET['quantity'];

    for ($i = 0; $i < count($names); $i++) {
        $items[] = [
            'name' => htmlspecialchars($names[$i]),
            'price' => floatval($prices[$i]),
            'quantity' => intval($quantities[$i])
        ];
    }

    // Calculate total price
    $totalPrice = array_sum(array_map(function ($item) {
        return $item['price'] * $item['quantity'];
    }, $items));
}

// Assume session 'username' is set after login
$username = $_SESSION['username'] ?? null;
$userInfo = [
    'username' => '',
    'email' => '',
    'alamat' => ''
];

// Get user info if logged in
if ($username) {
    $stmt = $pdo->prepare("SELECT username, email, alamat FROM user WHERE username = :username LIMIT 1");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $userInfo['username'] = htmlspecialchars($user['username']);
        $userInfo['email'] = htmlspecialchars($user['email']);
        $userInfo['alamat'] = htmlspecialchars($user['alamat']);
    } else {
        $userInfo['username'] = 'User not found';
        $userInfo['email'] = '-';
        $userInfo['alamat'] = '-';
    }
} else {
    $userInfo['username'] = 'You are not logged in.';
    $userInfo['email'] = '-';
    $userInfo['alamat'] = '-';
}

// Assume you have the profile ID from the session or another source
$profileId = $_SESSION['profile_id'] ?? null;

if ($profileId) {
    $stmt = $pdo->prepare("SELECT name, phone, gender FROM profile WHERE id = ?");
    $stmt->execute([$profileId]);

    $profile = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($profile) {
        $profileInfo = [
            'name' => htmlspecialchars($profile['name']),
            'phone' => htmlspecialchars($profile['phone']),
            'gender' => htmlspecialchars($profile['gender']),
        ];
    } else {
        $profileInfo = [
            'name' => 'Profile not found',
            'phone' => '-',
            'gender' => '-',
        ];
    }
} else {
    $profileInfo = [
        'name' => 'Profile ID not set',
        'phone' => '-',
        'gender' => '-',
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction</title>
    <link rel="stylesheet" href="css/transaction.css">
</head>
<body>
    <header>
        <a href="cart.php" class="back-button"><img src="img/outLogo2.png" alt="Back"></a>
        <h1>Order Summary</h1>
    </header>
    <main class="transaction-container">
    <h2>User Information</h2>
        <section class="user-info">
            <p><strong>Username:</strong> <?php echo $userInfo['username']; ?></p> 
            <p><strong>Name:</strong> <?php echo $profileInfo['name']; ?></p>
            <p><strong>Email:</strong> <?php echo $userInfo['email']; ?></p>    
            <p><strong>Address:</strong> <?php echo $userInfo['alamat']; ?></p>
        </section>
        <section class="order-summary">
            <h2>Order Summary</h2>
            <div class="order-details">
                <div id="item-list-container">
                    <strong>Items:</strong>
                    <?php foreach ($items as $item): ?>
                        <p> - <?php echo htmlspecialchars($item['name']); ?> (<?php echo htmlspecialchars($item['quantity']); ?> x IDR <?php echo number_format($item['price'], 0, ',', '.'); ?>)</p>
                    <?php endforeach; ?>
                </div>
                <p><strong>Order ID:</strong> <span id="order-id">123456</span></p>
                <p><strong>Total Price:</strong> <span id="transaction-total"> 
                    IDR <?php echo number_format($totalPrice, 0, ',', '.'); ?>
                </span></p>
            </div>
            <h2>Payment Information</h2>
            <section class="payment-info">
                <p><strong>Payment Method:</strong></p>
                <select id="payment-method">
                    <option value="credit-card">Credit Card</option>
                    <option value="bank-transfer">Bank Transfer</option>
                    <option value="e-wallet">E-Wallet</option>
                </select>
                <p><strong>Payment Status:</strong> <span id="payment-status">Pending</span></p>
            </section>
            <div class="actions">
                <button id="continue-shopping">Continue Shopping</button>
                <button id="bayar">Bayar</button>
            </div>
        </section>
    </main>

    <!-- Pop-up Password -->
    <div class="popup" id="popup-password">
        <div class="popup-content">
            <h3>Enter Password</h3>
            <input type="password" id="password" placeholder="Enter your password">
            <button id="submit-password">Submit</button>
            <button class="cancel" id="cancel-password">Cancel</button>
        </div>
    </div>

    <script>
document.addEventListener('DOMContentLoaded', () => {
    const orderId = 'ORD-' + Math.floor(Math.random() * 1000000);
    document.getElementById('order-id').textContent = orderId;

    document.getElementById('bayar').addEventListener('click', function() {
        document.getElementById('popup-password').style.display = 'flex';
    });

    document.getElementById('cancel-password').addEventListener('click', function() {
        document.getElementById('popup-password').style.display = 'none';
    });

    document.getElementById('submit-password').addEventListener('click', function() {
        const password = document.getElementById('password').value;
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'verify_password.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.valid) {
                    // Password is correct, submit the payment data
                    const orderId = document.getElementById('order-id').innerText;
                    const totalPrice = document.getElementById('transaction-total').innerText.replace('IDR ', '').replace(/\./g, '');
                    const paymentMethod = document.getElementById('payment-method').value;

                    // Collect items data
                    const items = [];
                    document.querySelectorAll('#item-list-container p').forEach((p) => {
                        const text = p.textContent;
                        const match = text.match(/ - (.+) \((\d+) x IDR (\d+)\)/);
                        if (match) {
                            items.push({
                                name: match[1],
                                quantity: parseInt(match[2]),
                                price: parseFloat(match[3].replace(/\./g, ''))
                            });
                        }
                    });

                    // Log the collected items
                    console.log('Collected items:', items);

                    const itemsJson = JSON.stringify(items);

                    const data = `username=${encodeURIComponent('<?php echo $userInfo['username']; ?>')}` +
                                 `&name=${encodeURIComponent('<?php echo $profileInfo['name']; ?>')}` +
                                 `&email=${encodeURIComponent('<?php echo $userInfo['email']; ?>')}` +
                                 `&address=${encodeURIComponent('<?php echo $userInfo['alamat']; ?>')}` +
                                 `&order_id=${encodeURIComponent(orderId)}` +
                                 `&total_price=${encodeURIComponent(totalPrice)}` +
                                 `&payment_method=${encodeURIComponent(paymentMethod)}` +
                                 `&payment_status=Completed` +
                                 `&items=${encodeURIComponent(itemsJson)}`;

                    // Log the data being sent
                    console.log('Sending data:', data);

                    const xhr2 = new XMLHttpRequest();
                    xhr2.open('POST', 'process_payment.php', true);
                    xhr2.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr2.onload = function() {
                        if (xhr2.status === 200) {
                            window.location.href = 'success.php'; // Redirect to success page
                        }
                    };
                    xhr2.send(data);
                } else {
                    alert('Invalid password');
                }
                document.getElementById('popup-password').style.display = 'none';
            }
        };
        xhr.send('password=' + encodeURIComponent(password));
    });
});

    </script>
</body>
</html>
