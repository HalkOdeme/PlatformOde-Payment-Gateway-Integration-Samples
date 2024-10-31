<?php


echo ('İşlem Başarısız <br><br>');


echo 'status_description : ' . htmlspecialchars($_GET['status_description']) . '<br>';
echo 'error_code : ' . htmlspecialchars($_GET['error_code']) . '<br>';
echo 'error : ' . htmlspecialchars($_GET['error']) . '<br>';
echo 'order_no : ' . htmlspecialchars($_GET['order_no']) . '<br>';
echo 'order_id : ' . htmlspecialchars($_GET['order_id']) . '<br>';
echo 'invoice_id : ' . htmlspecialchars($_GET['invoice_id']) . '<br>';
echo 'status_code : ' . htmlspecialchars($_GET['status_code']) . '<br>';
echo 'transaction_type : ' . htmlspecialchars($_GET['transaction_type']) . '<br>';
echo 'payment_status : ' . htmlspecialchars($_GET['payment_status']) . '<br>';


?>

 