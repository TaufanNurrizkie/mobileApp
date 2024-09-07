<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Page</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <div class="header">
        <div class="search-bar">
            <input type="text" placeholder="Cari di TIX ID">
        </div>
        <div class="profile-icon">
            <a href="https://wa.me/6283100471963?text=Hello%2C%20I%20would%20like%20to%20know%20more%20about%20your%20services%21">
                <img src="img/messageLogo2.png" alt="Chat Icon">
            </a>
        </div>
        <div class="profile-icon">
            <a href="profile.php"><img src="img/profileLogo2.png" alt="Profile Icon"></a>
        </div>
    </div>
    
    <div class="content" id="content">
        <!-- Dynamic content will be loaded here -->
    </div>
    
    <div class="bottom-bar">
        <div class="bar">
            <a href="#" class="bottom-bar-item" onclick="loadPage('detail.php')">
                <img src="img/truckLogo.png" alt="Track Order">
                <span>Trace</span>
            </a>
        </div>
        <div class="bar">
            <a href="#" class="bottom-bar-item" onclick="loadPage('product.php')">
                <img src="img/homeLogo.png" alt="Home">
                <span>Beranda</span>
            </a>
        </div>
        <div class="bar">
            <a href="#" class="bottom-bar-item" onclick="loadPage('notif.php')">
                <img src="img/notifLogo.png" alt="Notifications">
                <span>Notif</span>
            </a>
        </div>
    </div>
    
    <script>
        function loadPage(page) {
            fetch(page)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('content').innerHTML = data;
                })
                .catch(error => console.error('Error loading page:', error));
        }
    </script>
</body>
</html>
