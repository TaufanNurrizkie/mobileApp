<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemId = isset($_POST['id']) ? (int)$_POST['id'] : 0;

    if ($itemId > 0) {
        try {
            $conn = new PDO("mysql:host=localhost;dbname=marketplace", "root", "");
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $stmt = $conn->prepare("DELETE FROM cart WHERE id = :id");
            $stmt->bindParam(':id', $itemId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo 'success';
            } else {
                echo 'failure';
            }
        } catch(PDOException $e) {
            echo 'failure';
        }
    } else {
        echo 'failure';
    }
} else {
    echo 'failure';
}
?>
