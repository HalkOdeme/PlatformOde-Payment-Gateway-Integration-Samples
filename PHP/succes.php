<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İşlem Sonucu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding-top: 50px;
        }

        .container {
            max-width: 600px;
            background-color: #1b0565;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            color: #f8f9fa;
        }

        h1 {
            text-align: center;
            color: green;
        }

        .result-item {
            font-size: 16px;
            margin-bottom: 10px;
            color: #f8f9fa;
        }

        .result-item span {
            font-weight: bold;
            color: white;
        }

        footer {
            text-align: center;
            margin-top: 30px;
            color: white;
            background-color: #1b0565;

            padding: 20px;
        }

        .navbar-custom {
            background-color: #1b0565;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .navbar-custom .nav-link,
        .navbar-custom .navbar-brand {
            color: white;
            background-color: #1b0565;
        }

        .navbar-custom .navbar-toggler-icon {
            background-color: #1b0565;
        }

        .navbar-brand {
            text-align: center;
            background-color: #1b0565;
        }

        .navbar-collapse {
            background-color: #1b0565;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brands mx-auto" href="index.php">
                <img src="platform-logo.svg" alt="Ödeme Sistemi" style="height: 40px;">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Anasayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="3d.php">3D Entegrasyonu</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Ekstra İşlemler
                        </a>
                        <div class='dropdown-menu' aria-labelledby='navbarDropdown'>

                            <a class='dropdown-item' href='2d.php'>2D Entegrasyonu</a>
                            <a class='dropdown-item' href='3d.php'>3D Entegrasyonu</a>
                            <a class='dropdown-item' href='purchaselink.php'>Link ile Ödeme Entegrasyonu</a>
                            <a class='dropdown-item' href='refund.php'>İade Entegrasyonu</a><!-- refund -->
                            <a class='dropdown-item' href='checkstatus.php'>Ödeme Sorgulama</a> <!-- checkstatus -->
                            <div class="dropdown-divider"></div>
                            <a class='dropdown-item' href='installement.php'>Taksit Sayısı</a><!-- get installement -->
                            <a class='dropdown-item' href='getpost.php'>Taksit Gösterme Entegrasyonu</a><!-- taksit gösterme -->
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- İçerik Alanı -->
    <div class="container mt-5">
        <h1>İşlem Başarılı!</h1>

        <div class="result-item">
            <span>order_no:</span> <?php echo htmlspecialchars($_GET['order_no']); ?>
        </div>
        <div class="result-item">
            <span>order_id:</span> <?php echo htmlspecialchars($_GET['order_id']); ?>
        </div>
        <div class="result-item">
            <span>invoice_id:</span> <?php echo htmlspecialchars($_GET['invoice_id']); ?>
        </div>
        <div class="result-item">
            <span>status_code:</span> <?php echo htmlspecialchars($_GET['status_code']); ?>
        </div>
        <div class="result-item">
            <span>transaction_type:</span> <?php echo htmlspecialchars($_GET['transaction_type']); ?>
        </div>
        <div class="result-item">
            <span>payment_status:</span> <?php echo htmlspecialchars($_GET['payment_status']); ?>
        </div>
        <div class="result-item">
            <span>md_status:</span> <?php echo htmlspecialchars($_GET['md_status']); ?>
        </div>
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 Platformode</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>