<?php

$url = "https://app.platformode.com.tr/ccpayment/api/paySmart2D"; // Yeni URL

$data = array(
    "cc_holder_name" => "Test kart",
    "cc_no" => "4132260000000003",
    "expiry_month" => "12",
    "expiry_year" => "2024",
    "cvv" => "555",
    "currency_code" => "TRY",
    "installments_number" => 1,
    "invoice_id" => "s1211111111",
    "invoice_description" => "INVOICE TEST DESCRIPTION",
    "total" => 10,
    "merchant_key" => "$2y$10$HmRgYosneqcwHj.UH7upGuyCZqpQ1ITgSMj9Vvxn.t6f.Vdf2SQFO",
    "items" => array(
        array(
            "name" => "Item3",
            "price" => 10,
            "quantity" => 1,
            "description" => "item3 description"
        )
    ),
    "name" => "John",
    "surname" => "Dao",
    "hash_key" => "4ceae33d55ce49f9:7800:WheFAz8QSZTZkA6kxHfpPpzLiSOG7RC8RZ4UZCpotgMUGXNQ4S7h48THDmNxN6fwzZzSeQ7Ps13whEIxoLZ7LSz__shMHuaNBQWw72iyZZhW__PmrFbB4j2qGg3C4Njcj1"
);

$headers = array(
    "Accept: application/json",
    "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxNSIsImp0aSI6ImEyZTlkMzllYT71YyNPI6NQAj3KxOX"
);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);

if ($response === false) {
    echo "cURL hata: " . curl_error($ch);
} else {
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpCode == 200) {
        echo $response;
    } else {
        echo "HTTP isteği başarısız: " . $httpCode;
    }
}

curl_close($ch);

?>
