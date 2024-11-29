<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>İade Entegrasyonu</title>
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
                        <a class="nav-link" href="refund.php">İade Entegrasyonu</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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

    <div class="container">
        <h2 class="mt-5">İade Entegrasyonu</h2>

        <!-- HTML Form for User Input -->
        <form method="post">
            <label for="invoiceId" class="mt-5">Fatura ID:</label>
            <input type="text" id="invoiceId" name="invoice_id" value="" class="form-control" required><br>

            <label for="amount" class="mt-5">Tutar:</label>
            <input type="text" id="amount" name="amount" value="" class="form-control" required><br>

            <button type="submit" name="process_payment" class="btn mb-5 mt-5">Ödemeyi Test Et</button>
        </form>

        <?php
        if (isset($_POST['process_payment'])) {
            // Temel değişkenleri tanımla
            $baseUrl = "https://testapp.platformode.com.tr/ccpayment/api/refund";
            $app_id = "6a2837927bd20097840c985c144c8399";
            $appSecret = "ef987418d46cad78b60c1f645780f3f4";
            $merchantKey = '$2y$10$LApDyMV5TCB8uFiNnHl5QOyFfxY3.sGZgivBfLFUbk0PjUs4g25EK';
            $invoice_id = $_POST['invoice_id'];
            $amount = $_POST['amount'];

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
                "invoice_id" => $invoice_id,
                "merchant_key" => $merchantKey,
                "amount" => $amount,
            );

            // Gönderilen verileri tablodaki formatta göster
            echo "<h3>Gönderilen Veriler</h3>";
            echo "<table class='table table-bordered'>
                    <thead>
                        <tr>
                            <th>Fatura ID</th>
                            <th>İade Tutarı</th>
                            <th>Merchant Key</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>" . htmlspecialchars($invoice_id) . "</td>
                            <td>" . htmlspecialchars($amount) . " TL</td>
                            <td>" . htmlspecialchars($merchantKey) . "</td>
                        </tr>
                    </tbody>
                  </table>";

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

            // Yanıtı tabloya yerleştir
            echo "<h3>Yanıt</h3>";
            $decodedResponse = json_decode($response, true);

            echo "<table class='table table-bordered'>
                    <thead>
                        <tr>
                            <th>Durum Kodu</th>
                            <th>Durum Açıklaması</th>
                            <th>Sipariş Numarası</th>
                            <th>Fatura ID</th>
                            <th>Referans No</th>
                            <th>Referans Numarası</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>" . htmlspecialchars($decodedResponse['status_code']) . "</td>
                            <td>" . htmlspecialchars($decodedResponse['status_description']) . "</td>
                            <td>" . htmlspecialchars($decodedResponse['order_no']) . "</td>
                            <td>" . htmlspecialchars($decodedResponse['invoice_id']) . "</td>
                            <td>" . htmlspecialchars($decodedResponse['ref_no']) . "</td>
                            <td>" . htmlspecialchars($decodedResponse['ref_number']) . "</td>
                        </tr>
                    </tbody>
                  </table>";
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