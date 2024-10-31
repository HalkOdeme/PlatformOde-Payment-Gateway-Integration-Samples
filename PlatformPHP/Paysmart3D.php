<?php

$baseUrl = "https://testapp.platformode.com.tr/ccpayment/api/paySmart3D";

// Parametreler
$total=125;
$installments=1;
$merchantKey='$2y$10$avMpLZvIIEY4brcULaj4u.can9eg3gAnx5s3JGz5Yxd.9zka8YfaO';
$currencyCode='TRY';
$invoice_id="Test9663";
$appSecret="b15fba89a18997ab32e36d0b490f9aff";
$data = array(
    "cc_holder_name" => "Test kart",
    "cc_no" => "4155141122223339",
    "expiry_month" => "12",
    "expiry_year" => "2025",
    "currency_code" => $currencyCode,
    "installments_number" => $installments,
    "invoice_id" => $invoice_id,
    "invoice_description" => "ewrwer",
    "total" => $total,
    "merchant_key" => $merchantKey,
    "items" => json_encode(array(
		array(
			"name" => "Item1",
			"price" => 125,
			"quantity" => $installments,
			"description" => "item1 description")
		)
	),
    "name" => "John",
    "surname" => "Dao",
    "hash_key" => generateHashKey($total,$installments,$currencyCode,$merchantKey,$invoice_id,$appSecret),
    "return_url" => "http://localhost/odeme/success.php",
    "cancel_url" => "http://localhost/odeme/fail.php"
);

$ch = curl_init($baseUrl);

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

curl_close($ch);

echo $response;

function generateHashKey($total, $installment, $currency_code,$merchant_key, $invoice_id, $app_secret)
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

?>