<?php
// cloudflare
// This is my original secret key.
define('SECRET_KEY', '0x4AAAAAAAPG95EdYQIn6MgZAaorDVxbERA');

function handlePost() {

$token = $_POST['cf-turnstile-response'];
// $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
$formData = [
'secret' => SECRET_KEY,
'response' => $token
// 'remoteip' => $ip,
];
$url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
$result = sendPostRequest($url, $formData);
$outcome = json_decode($result, true);

if ($outcome['success']) {
$info = "Turnstile token successfuly validated";
}
else{
$errors['cloudflare-error'] = "Trunstile toke verification failed";
}
}

function sendPostRequest($url, $data) {
$options = [
'http' => [
'header' => "Content-type: application/x-www-form-urlencoded\r\n",
'method' => 'POST',
'content' => http_build_query($data),
],
];

$context = stream_context_create($options);
$result = file_get_contents($url, false, $context);

return $result;
}
// Call the handlePost function when processing a POST request.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
handlePost();
}
?>