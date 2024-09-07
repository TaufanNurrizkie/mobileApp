<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In Page</title>
    <link rel="stylesheet" href="css/loginSignin.css">
</head>
<body>
    <div class="signin-container">
        <div class="signin-header">
            <img src="img/anjingLogo.png" alt="Dog Icon" class="dog-icon" style="width: 50px;">
            <h1>SIGN IN</h1>
        </div>
        <form class="signin-form" action="process_signin.php" method="POST">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Type your username">
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Type your email">
            </div>
            <div class="input-group">
                <label for="alamat">Alamat</label>
                <input type="text" id="alamat" name="alamat" placeholder="Type your alamat">
            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Type your password">
            </div>
            <div class="input-group">
                <label for="retype">Retype</label>
                <input type="password" id="retype" name="retype" placeholder="Type your password">
            </div>
            <button type="submit" class="submit-btn">SUBMIT</button>
        </form>
        <div class="signin-footer">
            <a href="login.php" class="login-link">LOGIN</a>
            <a href="#" class="signin-link active-link">SIGN IN</a>
        </div>
    </div>

    <script src="js/loginsign.js"></script>
</body>
</html>
