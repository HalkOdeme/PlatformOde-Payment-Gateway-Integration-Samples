<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3D Ödeme İşleme</title>
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
                        <a class="nav-link" href="3d.php">3D Entegrasyonu</a>
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

        <h2>3D Ödeme İşlemi</h2>

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
            <button type="submit" name="process_payment" class="btn">Ödemeyi Gönder</button>
        </form>

        <?php
        if (isset($_POST['process_payment'])) {
            $baseUrl = "https://testapp.platformode.com.tr/ccpayment/api/paySmart3D";
            $installments = 1;
            $app_id = "6a2837927bd20097840c985c144c8399";
            $appSecret = "ef987418d46cad78b60c1f645780f3f4";
            $merchantKey = '$2y$10$LApDyMV5TCB8uFiNnHl5QOyFfxY3.sGZgivBfLFUbk0PjUs4g25EK';
            $currencyCode = 'TRY';
            $total = $_POST['total'];
            $invoice_id = $_POST['invoice_id'];
  
        

            $data = array(
                "cc_holder_name" => "Test kart",
                "cc_no" => "4155141122223339",
                "expiry_month" => "12",
                "expiry_year" => "2025",
                "cvv" => "555",
                "currency_code" => $currencyCode,
                "installments_number" => $installments,
                "invoice_id" => $invoice_id,
                "invoice_description" => "ewrwer",
                "total" => $total,
                "merchant_key" => $merchantKey,
                "items" => json_encode(
                    array(
                        array(
                            "name" => "Item1",
                            "price" => $total,
                            "quantity" => $installments,
                            "description" => "item1 description"
                        )
                    )
                ),
                "name" => "John",
                "surname" => "Dao",
                "hash_key" => generateHashKey($total, $installments, $currencyCode, $merchantKey, $invoice_id, $appSecret),
                "return_url" => "http://localhost/PHP/succes.php",
                "cancel_url" => "http://localhost/PHP/fail.php"
            );

            $ch = curl_init($baseUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            echo $response;
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
        ?>
    </div>

    <?php include 'footer.php'; ?>

</body>

</html>