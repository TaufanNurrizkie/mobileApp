<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Warung Kopi Nanana</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f4f4f4;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .header {
            background-color: #007bff;
            color: white;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .header input {
            border: none;
            border-radius: 25px;
            padding: 10px;
            font-size: 16px;
            width: 60%;
            max-width: 300px;
            background-color: #fff;
            outline: none;
        }

        .header .icons {
            display: flex;
            gap: 15px;
        }

        .header .icons i {
            font-size: 24px;
            color: #fff;
        }

        .banner {
            background-color: #007bff;
            color: white;
            text-align: center;
            padding: 20px;
            border-bottom: 5px solid #0056b3;
        }

        .banner .discount-text {
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }

        .banner .discount-percentage {
            font-size: 60px;
            font-weight: bold;
            margin: 10px 0;
        }

        .carousel-inner img {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        .banner .button {
            background-color: #fff;
            color: #007bff;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            margin: 20px 0;
            transition: background-color 0.3s, color 0.3s;
        }

        .banner .button:hover {
            background-color: #0056b3;
            color: #fff;
        }

        .features {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            padding: 20px;
            background-color: #fff;
        }

        .features .feature {
            width: 45%;
            max-width: 120px;
            text-align: center;
            margin-bottom: 15px;
        }

        .features .feature-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background-color: #007bff;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 28px;
            margin: 0 auto 10px;
            transition: transform 0.3s;
        }

        .features .feature-icon:hover {
            transform: scale(1.1);
        }

        .features .feature-text {
            font-size: 14px;
            color: #333;
        }

        .flash-sale, .popular-products {
            background-color: #fff;
            padding: 20px;
            margin: 10px 0;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
        }

        .flash-sale h2, .popular-products h2 {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 15px;
            text-align: center;
        }

        .flash-sale .sale-items, .popular-products .products {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
        }

        .flash-sale .sale-item, .popular-products .product {
            background-color: #fff;
            border: 1px solid #e0e0e0;
            border-radius: 15px;
            padding: 15px;
            text-align: center;
            margin: 10px;
            flex: 1 0 30%;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            transition: transform 0.3s;
        }

        .flash-sale .sale-item:hover, .popular-products .product:hover {
            transform: scale(1.05);
        }

        .flash-sale .sale-item img, .popular-products .product img {
            width: 100%;
            height: auto;
            border-radius: 12px;
        }

        .flash-sale .sale-item .discount, .popular-products .product .title {
            font-size: 18px;
            font-weight: bold;
            color: #ff0000;
            margin: 10px 0;
        }

        .flash-sale .sale-item .price {
            font-size: 16px;
            font-weight: bold;
            color: #007bff;
            margin: 5px 0;
        }

        .flash-sale .sale-item .sold, .popular-products .product .description {
            font-size: 14px;
            color: #888;
        }

        .footer {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            padding: 15px 0;
            display: flex;
            justify-content: space-around;
            align-items: center;
            box-shadow: 0 -2px 4px rgba(0,0,0,0.1);
            position: sticky;
            bottom: 0;
            width: 100%;
        }

        .footer .footer-button {
            background-color: #fff;
            color: #007bff;
            border: none;
            border-radius: 5px;
            padding: 12px 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            font-size: 16px;
            font-weight: bold;
            transition: background-color 0.3s, color 0.3s;
        }

        .footer .footer-button:hover {
            background-color: #0056b3;
            color: #fff;
        }

        .footer .footer-button i {
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="icons">
            <i class="fas fa-camera"></i>
            <i class="fas fa-wallet"></i>
        </div>
        <input type="text" placeholder="Cari produk...">
    </header>

    <div class="banner">
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="diskon_kopi.jpg" class="d-block w-100" alt="Kopi 1">
                </div>
                <div class="carousel-item">
                    <img src="diskon.jpg" class="d-block w-100" alt="Kopi 2">
                </div>
                <div class="carousel-item">
                    <img src="diskon1.jpg" class="d-block w-100" alt="Kopi 3">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <h2 class="discount-text">DISCO DISCOUNT REVOLUTION</h2>
        <div class="discount-percentage">40%</div>
        <button class="button">BELI SEKARANG ></button>
    </div>

    <div class="features">
        <a href="menu.php" class="feature">
            <div class="feature-icon">
                <i class="fas fa-store"></i>
            </div>
            <div class="feature-text">Menu</div>
        </a>
        <a href="" class="feature">
            <div class="feature-icon">
                <i class="fas fa-upload"></i>
            </div>
            <div class="feature-text">Pulsa & eVouchers</div>
        </a>
        <a href="keranjang.php" class="feature">
            <div class="feature-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="feature-text">Keranjang</div>
        </a>
        <div class="feature">
            <div class="feature-icon">
                <i class="fas fa-truck"></i>
            </div>
            <div class="feature-text">Belanja Untung</div>
        </div>
        <div class="feature">
            <div class="feature-icon">
                <i class="fas fa-credit-card"></i>
            </div>
            <div class="feature-text">Credit</div>
        </div>
        <a href="trace.php" class="feature">
            <div class="feature-icon">
                <i class="fas fa-bell"></i>
            </div>
            <div class="feature-text">Trace</div>
        </a>
    </div>
<a href="belanja.php">
    <div class="flash-sale">
        <h2>Warung Kopi Nanana</h2>
        <div class="sale-items">
            <div class="sale-item">
                <img src="kopi.jpeg" alt="Item 1">
                <div class="discount">Kopi HITAM</div>
                <div class="price">Rp 10.000</div>
                <div class="sold">Habis Terjual: 90</div>
            </div>
    </a>
            <div class="sale-item">
                <img src="martabak red.jpg" alt="Item 2">
                <div class="discount">Martabak Manis Emyu</div>
                <div class="price">Rp 30.000</div>
                <div class="sold">Habis Terjual: 120</div>
            </div>
            <div class="sale-item">
                <img src="chesee.jpg" alt="Item 3">
                <div class="discount">Roti Bakar Chesee</div>
                <div class="price">Rp 24.000</div>
                <div class="sold">Habis Terjual: 75</div>
            </div>
        </div>
    </div>

    <div class="popular-products">
        <h2>POPULER</h2>
        <div class="products">
            <div class="product">
                <img src="kopi_cup.jpg" alt="Product 1">
                <div class="title">Coffee Cup Purple</div>
                <div class="description">Habis Terjual: 4.4K</div>
            </div>
            <div class="product">
                <img src="latte.jpg" alt="Product 2">
                <div class="title">Coffee Latte</div>
                <div class="description">Habis Terjual: 3.2K</div>
            </div>
            <div class="product">
                <img src="martabak.jpeg" alt="Product 3">
                <div class="title">Martabak Manis</div>
                <div class="description">Habis Terjual: 2.68K</div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <button class="footer-button">
            <i class="fas fa-home"></i> Home
        </button>

        <button class="footer-button" onclick="window.location.href='keranjang.php'">
            <i class="fas fa-shopping-cart"></i> Cart
        </button>
        <button class="footer-button" onclick="window.location.href='profil.php'">
            <i class="fas fa-user"></i> Profile
        </button>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>
</html>