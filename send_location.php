<?php
$botToken = 'TELEGRAM_BOT_TOKEN';
$chatId = 'TELEGRAM_CHAT_ID';


$address = $_POST['address'];
$url = $_POST['url'];

$message = "Yeni konumunuz:\nAdres: $address\nYol Tarifi: $url";
$telegramUrl = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($message);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $telegramUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

echo $response;
?>
