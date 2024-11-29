<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Parametreler</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            flex: 1;
            margin-top: 20px;
        }

        .navbar-custom {
            background-color: #1b0565;
        }

        .navbar-custom .nav-link,
        .navbar-custom .navbar-brand {
            color: white !important;
        }

        .navbar-brand {
            text-align: center;
        }

        footer {
            background-color: #1b0565;
            color: white;
        }

        .btn-custom {
            background-color: #1b0565;
            color: white;
        }

        .btn {
            background-color: #1b0565;
            color: white;
        }


        td {
            word-wrap: break-word;
            word-break: break-word;
            max-width: 250px;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand mx-auto" href="index.php">
                <img src="platform-logo.svg" alt="Ödeme Sistemi" style="height: 40px;">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Anasayfa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="parameters.php">Parametreler</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Entegrasyonlar
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

    <div class="container">
        <div class="row table-container">
            <div class="col-md-6">
                <h2>2D Ödeme Parametreleri</h2>
                <table class="table">
                    <tr>
                        <td>Fatura ID:</td>
                        <td><input type="text" name="invoice_id" value="Test9861" required class="form-control"></td>
                    </tr>
                    <tr>
                        <td>Kart Sahibi Adı:</td>
                        <td><input type="text" class="form-control" name="cc_holder_name" value="John Dao" required></td>
                    </tr>
                    <tr>
                        <td>Kart Numarası:</td>
                        <td><input type="text" class="form-control" name="cc_no" value="4155141122223339" required></td>
                    </tr>
                    <tr>
                        <td>Son Kullanım Ayı:</td>
                        <td><input type="text" class="form-control" name="expiry_month" value="12" required></td>
                    </tr>
                    <tr>
                        <td>Son Kullanım Yılı:</td>
                        <td><input type="text" class="form-control" name="expiry_year" value="2025" required></td>
                    </tr>
                    <tr>
                        <td>CVV:</td>
                        <td><input type="text" name="cvv" class="form-control" value="555" required></td>
                    </tr>
                    <tr>
                        <td>Para Birimi:</td>
                        <td><input type="text" name="currency_code" value="TRY" required></td>
                    </tr>
                    <tr>
                        <td>Items:</td>
                        <td><input type="text" name="items" class="form-control" value='[{"name":"Item3","price":22,"quantity":1,"description":"item3 description"}]' required></td>
                    </tr>
                    <tr>
                        <td>MerchantKey:</td>
                        <td><input type="text" name="merchantKey" class="form-control" value="$2y$10$LApDyMV5TCB8uFiNnHl5QOyFfxY3.sGZgivBfLFUbk0PjUs4g25EK" required></td>
                    </tr>
                    <tr>
                        <td>Installments:</td>
                        <td><input type="text" class="form-control" name="installments_number" value="1" required></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6">
                <h2>3D Ödeme Parametreleri</h2>
                <table class="table">
                    <tr>
                        <td>Fatura ID:</td>
                        <td><input type="text" class="form-control" name="invoice_id" value="Test9861" required></td>
                    </tr>
                    <tr>
                        <td>Kart Sahibi Adı:</td>
                        <td><input type="text" class="form-control" name="cc_holder_name" value="John Dao" required></td>
                    </tr>
                    <tr>
                        <td>Kart Numarası:</td>
                        <td><input type="text" class="form-control" name="cc_no" value="4155141122223339" required></td>
                    </tr>
                    <tr>
                        <td>Son Kullanım Ayı:</td>
                        <td><input type="text" class="form-control" name="expiry_month" value="12" required></td>
                    </tr>
                    <tr>
                        <td>Son Kullanım Yılı:</td>
                        <td><input type="text" class="form-control" name="expiry_year" value="2025" required></td>
                    </tr>
                    <tr>
                        <td>CVV:</td>
                        <td><input type="text" name="cvv" class="form-control" value="555" required></td>
                    </tr>
                    <tr>
                        <td>Para Birimi:</td>
                        <td><input type="text" class="form-control" name="currency_code" value="TRY" required></td>
                    </tr>
                    <tr>
                        <td>Items:</td>
                        <td><input type="text" name="items" class="form-control" value='[{"name":"Item3","price":22,"quantity":1,"description":"item3 description"}]' required></td>
                    </tr>
                    <tr>
                        <td>MerchantKey:</td>
                        <td><input type="text" class="form-control" name="merchantKey" value="$2y$10$LApDyMV5TCB8uFiNnHl5QOyFfxY3.sGZgivBfLFUbk0PjUs4g25EK" required></td>
                    </tr>
                    <tr>
                        <td>Installments:</td>
                        <td><input type="text" class="form-control" name="installments_number" value="1" required></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>


    <?php include 'footer.php'; ?>

</body>

</html>