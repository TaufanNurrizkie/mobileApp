
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Login</title>

        <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .confirm-box {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .confirm-box button {
            padding: 10px 20px;
            margin: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .confirm-box .login-button {
            background-color: #4CAF50;
            color: white;
        }
        .confirm-box .cancel-button {
            background-color: #f44336;
            color: white;
        }
    </style>
   
</head>
<body>
    <div class="confirm-box">
        <h2>Anda harus login untuk melihat halaman ini.</h2>
        <p>Apakah Anda ingin login sekarang?</p>
        <form method="post" action="handle_login_redirect.php">
            <button type="submit" name="action" value="login" class="login-button">Login</button>
            <button type="submit" name="action" value="cancel" class="cancel-button">Kembali ke Halaman Utama</button>
        </form>
    </div>
</body>
</html>
