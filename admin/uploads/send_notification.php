<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipientType = $_POST['recipient_type'];
    $message = $_POST['message'];

    try {
        if ($recipientType === 'all') {
            // Send notification to all users
            $stmt = $conn->prepare("SELECT id FROM user");
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_COLUMN);

            foreach ($users as $userId) {
                // Assuming you have a function sendNotification() to handle sending notifications
                sendNotification($userId, $message, $conn);
            }

        } else if ($recipientType === 'selected') {
            // Send notification to selected user
            $userId = $_POST['user_id'];
            // Assuming you have a function sendNotification() to handle sending notifications
            sendNotification($userId, $message, $conn);
        }

        echo 'Notification sent successfully.';
        
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
    
    $conn = null;
} else {
    echo 'Invalid request method.';
}

function sendNotification($userId, $message, $conn) {
    // Implement your notification sending logic here
    // Example:
    $stmt = $conn->prepare("INSERT INTO notifications (user_id, message) VALUES (:user_id, :message)");
    $stmt->execute(['user_id' => $userId, 'message' => $message]);
}
?>
