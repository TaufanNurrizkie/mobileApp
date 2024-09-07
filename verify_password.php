<?php
session_start();
require_once 'connect.php';

$password = $_POST['password'] ?? '';
$username = $_SESSION['username'] ?? '';

if ($username) {
    // Check password in the database
    $stmt = $pdo->prepare("SELECT password FROM user WHERE username = :username LIMIT 1");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        echo json_encode(['valid' => true]);
    } else {
        echo json_encode(['valid' => false]);
    }
} else {
    echo json_encode(['valid' => false]);
}
