<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>2D Ödeme İşleme Sorgulama</title>
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
                        <a class="nav-link" href="2d.php">2D Entegrasyonu</a>
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

                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>2D Ödeme İşlemi</h2>

        <!-- Form -->
        <form method="post">
            <div class="form-group">
                <label for="invoice_id" class="mt-2">Fatura ID:</label>
                <input type="text" class="form-control" id="invoice_id" name="invoice_id" required>
            </div>
            <div class="form-group">
                <label for="cc_holder_name">Kart Sahibi Adı:</label>
                <input type="text" class="form-control" id="cc_holder_name" name="cc_holder_name" required>
            </div>
            <div class="form-group">
                <label for="cc_no">Kart Numarası:</label>
                <input type="text" class="form-control" id="cc_no" name="cc_no" required>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="expiry_month">Son Kullanım Ayı (AA):</label>
                    <input type="text" class="form-control" id="expiry_month" name="expiry_month" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="expiry_year">Son Kullanım Yılı (YYYY):</label>
                    <input type="text" class="form-control" id="expiry_year" name="expiry_year" required>
                </div>
            </div>
            <div class="form-group">
                <label for="cvv">CVV:</label>
                <input type="text" class="form-control" id="cvv" name="cvv" required>
            </div>
            <div class="form-group">
                <label for="total">Tutar:</label>
                <input type="text" class="form-control" id="total" name="total" required>
            </div>
            <div class="form-group">
                <label for="installments_number">Taksit Sayısı:</label>
                <input type="text" class="form-control" id="installments_number" name="installments_number" value="">
            </div>

            <div class="form-group">
                <label for="transaction_type">Ödeme Tipi Seçiniz:</label>
                <select class="form-control" id="transaction_type" name="transaction_type" required>
                    <option value="Auth">Auth</option>
                    <option value="PreAuth">PreAuth</option>
                </select>
            </div>

            <button type="submit" name="process_payment" class="btn">Ödemeyi Gönder</button>
        </form>

        <?php
        if (isset($_POST['process_payment'])) {
            // Temel değişkenleri tanımla
            $baseUrl = "https://testapp.platformode.com.tr/ccpayment/api/paySmart2D";
            $app_id = "6a2837927bd20097840c985c144c8399";
            $appSecret = "ef987418d46cad78b60c1f645780f3f4";
            $merchantKey = '$2y$10$LApDyMV5TCB8uFiNnHl5QOyFfxY3.sGZgivBfLFUbk0PjUs4g25EK';
            $total = $_POST['total'];
            $installments_number = $_POST['installments_number'];
            $currencyCode = "TRY";
            $invoice_id = $_POST['invoice_id'];
            $transaction_type = $_POST['transaction_type'];

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
                "cc_holder_name" => $_POST['cc_holder_name'],
                "cc_no" => $_POST['cc_no'],
                "expiry_month" => $_POST['expiry_month'],
                "expiry_year" => $_POST['expiry_year'],
                "cvv" => $_POST['cvv'],
                "currency_code" => $currencyCode,
                "installments_number" => $installments_number,
                "invoice_id" => $invoice_id,
                "invoice_description" => "FATURA TEST AÇIKLAMASI",
                "total" => $_POST['total'],
                "merchant_key" => $merchantKey,
                "transaction_type" => $transaction_type,
                "items" => array(
                    array(
                        "name" => "item",
                        "price" => $_POST['total'],
                        "quantity" => 1,
                        "description" => "ürün açıklaması"
                    )
                ),
                "name" => $_POST['cc_holder_name'],
                "surname" => "Dao",
                "payment_status" => 1,
                "hash_key" => generateHashKey($total, $installments_number, $currencyCode, $merchantKey, $invoice_id, $appSecret)
            );

            // Gönderilen verileri tablo olarak göster
            echo "<h3>Gönderilen Veriler</h3>";
            echo "<table class='table table-bordered'><thead><tr><th>Parametre</th><th>Değer</th></tr></thead><tbody>";
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    $value = json_encode($value);
                }
                echo "<tr><td>$key</td><td>$value</td></tr>";
            }
            echo "</tbody></table>";

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

            // Yanıtı tablo olarak göster
            $decodedResponse = json_decode($response, true);
            echo "<h3>API Yanıtı</h3>";
            if ($decodedResponse) {
                echo "<table class='table table-bordered'><thead><tr><th>Parametre</th><th>Değer</th></tr></thead><tbody>";
                foreach ($decodedResponse as $key => $value) {
                    if (is_array($value)) {
                        $value = json_encode($value);
                    }
                    echo "<tr><td>$key</td><td>$value</td></tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p><strong>Hata:</strong> Yanıt alınamadı.</p>";
            }
        }

        function generateHashKey($total, $installment, $currency_code, $merchant_key, $invoice_id, $app_secret)
        {
            $data = $total . '|' . $installment . '|' . $currency_code . '|' . $merchant_key . '|' . $invoice_id;
            $iv = substr(sha1(mt_rand()), 0, 16);
            $password = sha1($app_secret);
            $salt = substr(sha1(mt_rand()), 0, 4);
            $saltWithPassword = hash('sha256', $password . $salt);
            $encrypted = openssl_encrypt("$data", 'aes-256-cbc', "$saltWithPassword", 0, $iv);
            $msg_encrypted_bundle = "$iv:$salt:$encrypted";
            $msg_encrypted_bundle = str_replace('/', '__', $msg_encrypted_bundle);
            return $msg_encrypted_bundle;
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