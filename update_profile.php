<?php
session_start();
include 'connect.php'; // Include your database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php'); // Redirect to login page if user is not logged in
    exit();
}

// Get user profile data
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("
    SELECT p.name, p.phone, p.gender, p.photo, u.alamat, u.email
    FROM profile p
    JOIN user u ON p.user_id = u.id
    WHERE p.user_id = :userId
");
$stmt->execute(['userId' => $user_id]);
$profile = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['username'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];

    // Handle photo upload
    if (!empty($_FILES['profilePicture']['name'])) {
        $photo = $_FILES['profilePicture']['name'];
        move_uploaded_file($_FILES['profilePicture']['tmp_name'], 'img/' . $photo);
    } else {
        $photo = $_POST['currentPhoto'];
    }

    // Update profile and user data in the database
    $stmt = $pdo->prepare("
        UPDATE profile p
        JOIN user u ON p.user_id = u.id
        SET p.name = :name, p.phone = :phone, p.gender = :gender, p.photo = :photo, u.alamat = :address, u.email = :email
        WHERE p.user_id = :userId
    ");
    $stmt->execute([
        'name' => $name,
        'phone' => $phone,
        'gender' => $gender,
        'photo' => $photo,
        'address' => $address,
        'email' => $email,
        'userId' => $user_id,
    ]);

    // Redirect to profile.php after updating
    header('Location: profile.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
    <div class="container">
        <h1>Update Profile</h1>
        <form action="update_profile.php" method="POST" enctype="multipart/form-data">
            <label for="profilePicture">Profile Photo:</label>
            <input type="file" name="profilePicture" id="profilePicture" accept="image/*"><br>
            <input type="hidden" name="currentPhoto" value="<?php echo htmlspecialchars($profile['photo']); ?>">

            <label for="username">Name:</label>
            <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($profile['name']); ?>" required><br>

            <label for="address">Address:</label>
            <input type="text" name="address" id="address" value="<?php echo htmlspecialchars($profile['alamat']); ?>" required><br>

            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" id="phone" value="<?php echo htmlspecialchars($profile['phone']); ?>" required><br>

            <label for="gender">Gender:</label>
            <select name="gender" id="gender" required>
                <option value="Male" <?php echo ($profile['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo ($profile['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
            </select><br>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($profile['email']); ?>" required><br>

            <button type="submit">Update Profile</button>
        </form>
    </div>
</body>
</html>
