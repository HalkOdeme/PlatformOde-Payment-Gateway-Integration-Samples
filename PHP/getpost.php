<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>Taksit Gösterme Entegrasyonu</title>
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
                        <a class="nav-link" href="getpost.php">Taksit Gösterme Entegrasyonu</a>
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
        <h2 class="mt-5">Taksit Gösterme Entegrasyonu</h2>

        <!-- HTML Form for User Input -->
        <form method="post">

            <label for="credit_card" class="mt-5">Kredi Kartı Numarası:</label>
            <input type="text" id="credit_card" name="credit_card" value="" class="form-control" required><br><br>

            <label for="amount">Miktar:</label>
            <input type="number" id="amount" name="amount" value="" class="form-control" step="0.01" required><br><br>

            <button type="submit" name="process_payment" class="btn mb-5 mt-2">Ödemeyi Test Et</button>
        </form>

        <?php
        if (isset($_POST['process_payment'])) {
            // Temel değişkenleri tanımla
            $baseUrl = "https://testapp.platformode.com.tr/ccpayment/api/getpos";
            $app_id = "6a2837927bd20097840c985c144c8399";
            $appSecret = "ef987418d46cad78b60c1f645780f3f4";
            $merchantKey = '$2y$10$LApDyMV5TCB8uFiNnHl5QOyFfxY3.sGZgivBfLFUbk0PjUs4g25EK';

            $credit_card = $_POST['credit_card'];
            $amount = $_POST['amount'];
            $currencyCode = "TRY";

            // Token isteği
            $tokenResponse = getToken($app_id, $appSecret);
            $decodedTokenResponse = json_decode($tokenResponse, true);

            if ($decodedTokenResponse['status_code'] == 100) {
                $token = $decodedTokenResponse['data']['token'];
            } else {
                echo "<p><strong>Hata:</strong> Token alınamadı. Lütfen bilgilerinizi kontrol ediniz.</p>";
                return;
            }

            // Formdan verileri topla
            $data = array(

                "merchant_key" => $merchantKey,
                "credit_card" => $credit_card,
                "amount" => $amount,
                "currency_code" => $currencyCode,
            );

            // Gönderilen verileri göster
            echo "<h3>Gönderilen Veriler</h3>";
            echo "<pre>" . htmlspecialchars(json_encode($data, JSON_PRETTY_PRINT)) . "</pre>";

            // Ödeme isteğini göndermek için CURL
            $ch = curl_init($baseUrl);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                "Authorization: Bearer $token"
            ));
            $jsonData = json_encode($data);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            // Yanıtı göster
            echo "<h3>Yanıt</h3><pre>" . htmlspecialchars($response) . "</pre>";

            // API yanıtından taksit sayısını al
            $response_data = json_decode($response, true);
            if (isset($response_data['data']['installments_number'])) {
                $installments_number = $response_data['data']['installments_number'];
                echo "<h3>Mevcut Taksit Sayısı</h3>";
                echo "<p>Toplam Taksit Sayısı: $installments_number</p>";
            }
        }

        function generateHashKey($total, $installment, $currency_code, $merchant_key, $invoice_id, $app_secret)
        {
            // Bu fonksiyon şu an kullanılmıyor, kaldırabilirsiniz.
        }

        function getToken($app_id, $app_secret)
        {
            $baseUrl = "https://testapp.platformode.com.tr/ccpayment/api/token";
            $data = array('app_id' => $app_id, 'app_secret' => $app_secret);
            $jsonData = json_encode($data);
            $ch = curl_init($baseUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            $response = curl_exec($ch);
            curl_close($ch);
            return $response;
        }
        ?>

    </div>

    <?php include 'footer.php'; ?>
</body>

</html>