<?php

$baseUrl = "https://testapp.platformode.com.tr/ccpayment/api/paySmart2D";

// Token Request
$app_id = "de948c3eafdf5582409d0ad9a0809666";

// Token & 2D Request
$appSecret = "b15fba89a18997ab32e36d0b490f9aff	";

// 2D Request
$total = 110.00;
$installment = 1;
$merchantKey = '$2y$10$avMpLZvIIEY4brcULaj4u.can9eg3gAnx5s3JGz5Yxd.9zka8YfaO';
$currencyCode = "TRY";
$invoice_id = "Test9861";


$tokenResponse = getToken($app_id, $appSecret);

$decodedTokenResponse = json_decode($tokenResponse, true);

if ($decodedTokenResponse['status_code'] == 100) {
    $token = $decodedTokenResponse['data']['token'];
} else {
    echo "Token alınamadı. Lütfen bilgilerinizi kontrol ediniz.";
	return;
}

$data = array(
    "cc_holder_name" => "John Dao",
    "cc_no" => "4155141122223339",
    "expiry_month" => "12",
    "expiry_year" => "2025",
    "cvv" => "555",
    "currency_code" => $currencyCode,
    "installments_number" => $installment,
    "invoice_id" => $invoice_id,
    "invoice_description" => "INVOICE TEST DESCRIPTION",
    "total" => $total,
    "merchant_key" => $merchantKey,
    "items" => array(
        array(
            "name" => "item",
            "price" => 110.00,
            "quantity" => 1,
            "description" => "item description"
        )
    ),
    "name" => "John",
    "surname" => "Dao",
    "payment_status" => 1,
    "transaction_type" => "Auth",
    "hash_key" => generateHashKey($total, $installment, $currencyCode, $merchantKey, $invoice_id, $appSecret)
);

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

echo $response;

function generateHashKey($total, $installment, $currency_code, $merchant_key, $invoice_id, $app_secret)
{
    $data = $total . '|' . $installment . '|' . $currency_code . '|' . $merchant_key . '|' . $invoice_id;

    $iv = substr(sha1(mt_rand()), 0, 16);
    $password = sha1($app_secret);

    $salt = substr(sha1(mt_rand()), 0, 4);
    $saltWithPassword = hash('sha256', $password . $salt);

    $encrypted = openssl_encrypt("$data", 'aes-256-cbc', "$saltWithPassword", null, $iv);

    $msg_encrypted_bundle = "$iv:$salt:$encrypted";
    $msg_encrypted_bundle = str_replace('/', '__', $msg_encrypted_bundle);

    return $msg_encrypted_bundle;
}

function getToken($app_id, $app_secret) {
    $baseUrl = "https://testapp.platformode.com.tr/ccpayment/api/token";

    $data = array(
        'app_id' => $app_id,
        'app_secret' => $app_secret
    );

    $jsonData = json_encode($data);

    $ch = curl_init($baseUrl);

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
    ));

    $response = curl_exec($ch);
	
	$decodedResponse = json_decode($response, true);
	
	return $response;

    curl_close($ch);
}

?>
