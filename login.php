

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="css/loginSignin.css">
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <img src="img/kucingLogo.png" alt="Cat Icon" class="cat-icon" style="width: 50px;">
            <h1>LOGIN</h1>
        </div>
        <form class="login-form" action="process_login.php" method="POST">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Type your username">
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Type your password">
            </div>
            <button type="submit" class="submit-btn">SUBMIT</button>
            <p style="font-weight: bold; color: #2FAD91;">or</p>
            <div class="social-login">
                <button type="button" class="google-btn">
                    <img src="img/googleLogo.png" alt="" style="width: 25px;">    
                    <span style="font-weight: bold" class="text">Google</span>
                </button>
                <button type="button" class="apple-btn">
                    <img src="img/appleLogo.png" alt="" style="width: 25px;">
                    <span style="font-weight: bold" class="text">Apple</span>
                </button>
            </div>
        </form>
        <div class="login-footer">
            <a href="#" class="login-link active-link">LOGIN</a>
            <a href="signIn.php" class="signin-link">SIGN IN</a>
        </div>
    </div>

    <script src="js/loginsign.js"> </script>
</body>
</html>
