<?php
header('Content-Type: application/json');

$bearerToken = 'AAAAAAAAAAAAAAAAAAAAANZNwwEAAAAAH8yvCEUgdEMN1GtXTcbJCXLHlws%3DvGQhTzAiaulkeZkGlZCHJssFc0Pm865MljpnOFduLgjEacHx24';
$userId = '1778427637410537473';

// Request tweets with media details
$url = "https://api.twitter.com/2/users/$userId/tweets?tweet.fields=entities,attachments&expansions=attachments.media_keys&media.fields=url";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $bearerToken"
]);

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo json_encode(['error' => 'cURL error', 'message' => curl_error($ch)]);
    curl_close($ch);
    exit;
}


$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);


if ($httpCode >= 200 && $httpCode < 300) {
    echo $response;
} else {
    http_response_code($httpCode);
    echo json_encode(['error' => 'Failed to fetch tweets']);
}

curl_close($ch);

