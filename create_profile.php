<?php
session_start();
include 'connect.php'; // Include your database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if user is not logged in
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);
    $gender = $_POST['gender'];

    // Validate inputs
    if (empty($name) || empty($phone) || empty($gender)) {
        echo "Please fill all required fields.";
        exit();
    }

    // Sanitize inputs
    $name = htmlspecialchars($name);
    $phone = htmlspecialchars($phone);
    $gender = htmlspecialchars($gender);

    // Handle photo upload
    if (!empty($_FILES['photo']['name'])) {
        $photo = $_FILES['photo']['name'];
        $photoTmp = $_FILES['photo']['tmp_name'];
        $photoPath = 'img/' . basename($photo);

        // Check if file is an image
        $check = getimagesize($photoTmp);
        if ($check === false) {
            echo "File is not an image.";
            exit();
        }

        // Move the uploaded file to the appropriate directory
        if (move_uploaded_file($photoTmp, $photoPath)) {
            // Insert profile data into the database
            $stmt = $pdo->prepare("INSERT INTO profile (user_id, name, phone, gender, photo) VALUES (:userId, :name, :phone, :gender, :photo)");
            $stmt->execute([
                'userId' => $_SESSION['user_id'],
                'name' => $name,
                'phone' => $phone,
                'gender' => $gender,
                'photo' => $photo,
            ]);

            // Redirect to profile.php after creation
            header('Location: profile.php');
            exit();
        } else {
            echo "Failed to upload photo.";
        }
    } else {
        echo "Please upload a photo.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Profile</title>
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
    <div class="container">
        <h1>Create Profile</h1>
        <form action="create_profile.php" method="POST" enctype="multipart/form-data">
            <label for="photo">Profile Photo:</label>
            <input type="file" name="photo" id="photo" accept="image/*" required><br>
            
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required><br>
            
            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" id="phone" required><br>
            
            <label for="gender">Gender:</label>
            <select name="gender" id="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select><br>

            <button type="submit">Create Profile</button>
        </form>
    </div>
</body>
</html>
