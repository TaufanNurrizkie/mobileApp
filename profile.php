<?php
session_start();
include 'connect.php'; // Include your database connection

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // If not logged in, save the target URL in session
    $_SESSION['redirect_url'] = $_SERVER['REQUEST_URI'];

    // Display confirmation page
    include 'confirm_login.php';

    // Process if user clicks one of the buttons
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['login'])) {
            // Redirect to login page with target URL
            $redirect_url = urlencode($_SESSION['redirect_url']);
            header("Location: login.php?redirect=$redirect_url");
            exit;
        } elseif (isset($_POST['cancel'])) {
            // Redirect to home page
            header("Location: index.php");
            exit;
        }
    }

    exit; // Stop further execution
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/profile.css">
</head>
<body>
    <div class="container">
        <a href="index.php"><img src="img/outLogo.png" alt="Logo" class="out"></a>
        
        <div class="profile-header">
            <?php if ($profile): ?>
                <img src="img/<?php echo htmlspecialchars($profile['photo']); ?>" alt="Profile Picture">
                <p>Name: <?php echo htmlspecialchars($profile['name']); ?></p>
                <p>Address: <?php echo htmlspecialchars($profile['alamat']); ?></p>
                <p>Email: <?php echo htmlspecialchars($profile['email']); ?></p>
                <p>Phone: <?php echo htmlspecialchars($profile['phone']); ?></p>
                <p>Gender: <?php echo htmlspecialchars($profile['gender']); ?></p>
                <br>
                <a href="update_profile.php">
                    <button>Update Profile</button>
                </a>
            <?php else: ?>
                <p>No profile information available.</p>
                <br>
                <a href="create_profile.php">
                    <button>Create Profile</button>
                </a>
            <?php endif; ?>
        </div>
        
        <div class="profile-menu">
            <button id="history-button">
                <img src="img/historyLogo.png" alt="history">
                <span>history</span>
            </button>
            <button id="voucher-button">
                <img src="img/voucherLogo.png" alt="Voucher">
                <span>Voucher</span>
            </button>
            <button id="maps-button">
                <img src="img/mapsLogo.png" alt="Maps">
                <span>MAPS</span>
            </button>
            <button id="trace-button">
                <img src="img/truckLogo.png" alt="Trace">
                <span>TRACE</span>
            </button>
        </div>
        
        <div class="grid-menu">
            <button id="message-button">
                <img src="img/messageLogo.png" alt="Message">
                <span>MESSAGE</span>
            </button>
            <button id="notification-button">
                <img src="img/notifLogo.png" alt="Notification">
                <span>NOTIFICATION</span>
            </button>
            <button id="cart-button">
                <a href="cart.php"><img src="img/cartLogo.png" alt="Cart"></a>
                <span>CART</span>
            </button>
            <button id="help-button">
                <img src="img/helpLogo.png" alt="Help">
                <span>HELP</span>
            </button>
            <button id="rating-button">
                <img src="img/starLogo.png" alt="Rating">
                <span>RATING</span>
            </button>
            <button id="logout-button" onclick="openLogoutModal()">
                <img src="img/outLogo.png" alt="Log Out">
                <span>LOG OUT</span>
            </button>
        </div>
    </div>

    <!-- Modal for logout confirmation -->
    <div id="logoutModal" class="modal">
        <div class="modal-content">
            <span class="close-button" onclick="closeLogoutModal()">&times;</span>
            <h2>Logout Confirmation</h2>
            <p>Are you sure you want to log out?</p>
            <button onclick="confirmLogout()">Yes</button>
            <button onclick="closeLogoutModal()">No</button>
        </div>
    </div>
    <script>
    function openLogoutModal() {
        document.getElementById('logoutModal').style.display = 'block';
    }

    function closeLogoutModal() {
        document.getElementById('logoutModal').style.display = 'none';
    }

    function confirmLogout() {
        // If user confirms, redirect to logout.php
        window.location.href = "logout.php";
    }
    </script>

</body>
</html>
