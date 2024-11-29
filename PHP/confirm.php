<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <title>2D Ödeme İşlemi</title>
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
            margin-bottom: 25px;
        }

        td {
            word-wrap: break-word;
            word-break: break-word;
            max-width: 250px;
        }
    </style>
</head>
<?php
        date_default_timezone_set('Europe/Istanbul');

        ?>
<body>
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <a class="navbar-brand mx-auto" href="#">
                <img src="platform-logo.svg" alt="Ödeme Sistemi" style="height: 40px;">
            </a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>2D Ödeme İşlemi</h2>

        <!-- Form -->
        <form method="post">
            <div class="form-group">
                <label for="invoice_id" class="mt-2">Fatura ID:</label>
                <input type="text" class="form-control" id="invoice_id" name="invoice_id" required>
            </div>
            <div class="form-group">
                <label for="order_id">İşlem No:</label>
                <input type="text" class="form-control" id="order_id" name="order_id" required>
            </div>
            <div class="form-group">
                <label for="total">Tutar:</label>
                <input type="text" class="form-control" id="total" name="total" required>
            </div>
            <button type="submit" name="process_payment" class="btn">Ödemeyi Gönder</button>
        </form>

        <?php
        if (isset($_POST['process_payment'])) {
            // Kullanıcıdan alınan veriler
            $invoice_id = $_POST['invoice_id'];
            $order_id = $_POST['order_id'];
            $total = $_POST['total'];

            // Sabit API bilgileri
            $baseUrl = "https://testapp.platformode.com.tr/api/confirmPayment"; // Endpoint URL
            $app_id = "6a2837927bd20097840c985c144c8399";
            $appSecret = "ef987418d46cad78b60c1f645780f3f4";
            $merchantKey = '$2y$10$LApDyMV5TCB8uFiNnHl5QOyFfxY3.sGZgivBfLFUbk0PjUs4g25EK';

            // cURL başlatma
            $curl = curl_init();

            // API'ye gönderilecek veriler
            $body  = array(
                "merchant_key" => $merchantKey,
                "hash_key" => hash("sha256", $app_id . $appSecret),  // hash_key oluşturuluyor
                "invoice_id" => $invoice_id,
                "order_id" => $order_id,
                "status" => "complete"
            );

            // cURL ayarlarını yapılandırma
            curl_setopt_array($curl, [
                CURLOPT_URL => $baseUrl,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($body),
                
            ]);

            $response = curl_exec($curl);

            // cURL hatasını kontrol et
            if (curl_errno($curl)) {
                echo "<p><strong>cURL Hatası:</strong> " . curl_error($curl) . "</p>";
            } else {
                curl_close($curl);
            }

            // Yanıtı kontrol et
            if ($response === false) {
                echo "<p><strong>API Yanıtı:</strong> Geçersiz yanıt alındı veya bağlantı hatası oluştu.</p>";
            } else {
                // Yanıtı doğrudan ekrana yazdırma (Debug için)
                echo "<h3>API Yanıtı:</h3>";
                echo "<pre>" . $response . "</pre>";

                // JSON verisini işleme
                $decodedResponse = json_decode($response, true);

                // Yanıtın geçerli olup olmadığını kontrol et
                if ($decodedResponse === null) {
                    echo "<p><strong>Hata:</strong> API yanıtı geçersiz veya boş.</p>";
                } else {
                    // Yanıtın geçerli olup olmadığını kontrol et
                    if (isset($decodedResponse['status_code']) && $decodedResponse['status_code'] == 100) {
                        echo "<h3>İşlem Başarılı!</h3>";
                        echo "<p><strong>Fatura ID:</strong> " . $decodedResponse['invoice_id'] . "</p>";
                        echo "<p><strong>İşlem No:</strong> " . $decodedResponse['order_id'] . "</p>";
                        echo "<p><strong>Durum:</strong> " . $decodedResponse['status_description'] . "</p>";
                    } else {
                        echo "<p><strong>İşlem Başarısız:</strong> " . $decodedResponse['status_description'] . "</p>";
                    }
                }
            }
        }
        ?>

    </div>

    <footer class="text-center py-3">
        © 2024 Ödeme Sistemi
    </footer>
</body>

</html>