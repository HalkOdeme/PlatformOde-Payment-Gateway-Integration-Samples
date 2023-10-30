<?php
$baseUrl = "https://app.platformode.com.tr/ccpayment/api/paySmart3D";

// İsteği oluştur
$ch = curl_init($baseUrl);

// Authorization başlığını ekleyin
$authorizationHeader = "Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxNSIsImp0aSI6ImEyZTlkMzllYT71YyNPI6NQAj3KxOX";
curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorizationHeader));

// Diğer parametreleri ekleyin
$data = array(
    "cc_holder_name" => "asddasddddd",
    "cc_no" => "4132260000000003",
    "expiry_month" => "12",
    "expiry_year" => "2024",
    "currency_code" => "TRY",
    "installments_number" => "1",
    "invoice_id" => "03b9659f-03f4-48af-ad9d-b42e8c11407d",
    "invoice_description" => "ewrwer",
    "total" => "125",
    "merchant_key" => "$2y$10$w/ODdbTmfubcbUCUq/ia3OoJFMUmkM1UVNBiIQIuLfUlPmaLUT1he",
    "items" => json_encode(array(array("name" => "Item3", "price" => 125.00, "quantity" => 1, "description" => "item3 description"))),
    "name" => "John",
    "surname" => "Dao",
    "hash_key" => "17a800423ccdeab5:6541:dl5CJlHN9ElmApnqUw9t1KEjTVoJgO8DJUm9qDqf557tkO2B0cqMMgEI9ke9eHCjHhoEIbJD+2e8T2YefjwfJ82zUhNP9ofXYDFSMXYz95J1tyhxNYuT0EUjzhr6oWlrT__t3TAb05O6exZ+rSk4tPQ==",
    "return_url" => "http://merchant-domain.com?success.php",
    "cancel_url" => "http://merchant-domain.com?fail.php"
);

// POST isteğini yapılandırın
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

// Sonuçları al
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

// İsteği kapat
curl_close($ch);

// Sonucu yazdır
echo $response;
?>
