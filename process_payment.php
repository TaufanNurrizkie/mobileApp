<?php
session_start();
require_once 'connect.php';

// Extract POST data
$username = $_POST['username'] ?? '';
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$address = $_POST['address'] ?? '';
$order_id = $_POST['order_id'] ?? '';
$total_price = $_POST['total_price'] ?? '';
$payment_method = $_POST['payment_method'] ?? '';
$payment_status = $_POST['payment_status'] ?? '';
$items = $_POST['items'] ?? ''; // JSON encoded items

// Log received items
error_log('Received items: ' . $items);

// Decode items JSON
$items = json_decode($items, true);

if (json_last_error() !== JSON_ERROR_NONE) {
    error_log('JSON decode error: ' . json_last_error_msg());
    die('Invalid JSON format');
}

// Ensure order status is valid
$order_status = 'dikemas'; // Or other valid values like 'dikemas' or 'dikirim'

// Insert data into `pembayaran` table
try {
    $stmt = $pdo->prepare("
        INSERT INTO pembayaran (username, name, email, address, order_id, total_price, payment_method, payment_status, order_status, items, created_at)
        VALUES (:username, :name, :email, :address, :order_id, :total_price, :payment_method, :payment_status, :order_status, :items, NOW())
    ");
    
    $stmt->execute([
        'username' => $username,
        'name' => $name,
        'email' => $email,
        'address' => $address,
        'order_id' => $order_id,
        'total_price' => $total_price,
        'payment_method' => $payment_method,
        'payment_status' => $payment_status,
        'order_status' => $order_status, // Set to 'selesai', 'dikemas', or 'dikirim'
        'items' => $items, // Use the decoded array directly
    ]);

    echo json_encode(['success' => true]);
} catch (PDOException $e) {
    error_log('PDO Exception: ' . $e->getMessage());
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
