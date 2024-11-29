<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Link ile Ödeme Entegrasyonu</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .container {
            flex: 1;

        }

        .navbar-custom {
            background-color: #1b0565;
        }

        .navbar-custom .nav-link {
            color: white !important;
        }

        .navbar-brand {
            flex-grow: 1;
            text-align: center;
        }

        .navbar-nav {
            flex-direction: row;
            justify-content: center;
            width: 100%;
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
            margin-bottom: 10px;
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
                        <a class="nav-link" href="purchaselink.php">Link ile Ödeme Entegrasyonu</a>
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
        <h2 class="mt-5">Link ile Ödeme Entegrasyonu</h2>

        <form method="post">
            <div class="form-group">
                <label for="invoice_id" class="mt-2">Fatura ID:</label>
                <input type="text" class="form-control" id="invoice_id" name="invoice_id" required>

            </div>

            <div class="form-row">
                <div class="form-group col-md-6 mt-2">
                    <label for="name">Kart Sahibi Adı:</label>
                    <input type="text" id="name" name="name" class="form-control" value="" required>
                </div>
                <div class="form-group col-md-6 mt-2">
                    <label for="surname">Kart Sahibi Soyadı:</label>
                    <input type="text" id="surname" name="surname" class="form-control" value="" required>
                </div>

                <div class="form-group col-md-6 mt-2">
                    <label for="total">Tutar:</label>
                    <input type="text" id="total" name="total" class="form-control" value="" required>
                </div>
            </div>

            <button type="submit" name="process_payment" class="btn">Ödemeyi Test Et</button>
        </form>


        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $apiUrl = "https://testapp.platformode.com.tr/ccpayment/purchase/link";
            $app_id = "6a2837927bd20097840c985c144c8399";
            $appSecret = "ef987418d46cad78b60c1f645780f3f4";
            $merchantKey = '$2y$10$LApDyMV5TCB8uFiNnHl5QOyFfxY3.sGZgivBfLFUbk0PjUs4g25EK';
            $invoice_id = $_POST['invoice_id'];
            $currency_code = "TRY";
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $total = $_POST['total'];

            $requestData = [
                "merchant_key" => $merchantKey,
                "currency_code" => $currency_code,
                "invoice" => "{\"invoice_id\":\"$invoice_id\",\"invoice_description\":\"Testdescription\",\"total\":$total,\"return_url\":\"https://google.com.tr\",\"cancel_url\":\"https://github.com.tr\",\"items\":[{\"name\":\"Item1\",\"price\":$total,\"quantity\":1,\"description\":\"Test\"}]}",
                "name" => $name,
                "surname" => $surname
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_URL, $apiUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($requestData));

            $response = curl_exec($ch);
            print($response);

            if (curl_errno($ch)) {
                $error_message = 'cURL Error: ' . curl_error($ch);
                curl_close($ch);
                exit($error_message);
            }

            curl_close($ch);

            $responseData = json_decode($response, true);
        ?>

            <h1>API Test Sonuçları</h1>

            <h2>Gönderilen Parametreler</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Parametre</th>
                        <th>Değer</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Merchant Key</strong></td>
                        <td><?php echo htmlspecialchars($merchantKey); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Fatura ID</strong></td>
                        <td><?php echo htmlspecialchars($invoice_id); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Para Birimi</strong></td>
                        <td><?php echo htmlspecialchars($currency_code); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Ad</strong></td>
                        <td><?php echo htmlspecialchars($name); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Soyad</strong></td>
                        <td><?php echo htmlspecialchars($surname); ?></td>
                    </tr>
                </tbody>
            </table>

            <h2>API Cevap Sonuçları</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Parametre</th>
                        <th>Değer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($responseData as $key => $value) {
                        // Eğer değer bir URL içeriyorsa tıklanabilir hale getir
                        if (filter_var($value, FILTER_VALIDATE_URL)) {
                            echo "<tr><td><strong>$key</strong></td><td><a href=\"" . htmlspecialchars($value) . "\" target=\"_blank\">" . htmlspecialchars($value) . "</a></td></tr>";
                        } else {
                            echo "<tr><td><strong>$key</strong></td><td>" . htmlspecialchars(print_r($value, true)) . "</td></tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>

        <?php } ?>

    </div>

    <?php include 'footer.php'; ?>

</body>

</html>