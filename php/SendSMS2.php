<?php

$customer_id = '9F70BA09-6F5A-4FEC-BC39-C6397206EA75';
$api_key = 'Q59vZP17Vfz1gLB2sYqXTmdz7uxfP16hGwfEKO72r5HiIhJbWWf6e60/OeoyvnI3nuYyhFVAFCLS94A5rxExsg==';
$phone_number = '+17345893503';
$verify_code = '12345';

$url = 'https://rest-api.telesign.com/v1/messaging';

$headers = [
    'Content-Type: application/json',
    'Authorization: Basic ' . base64_encode($customer_id . ':' . $api_key)
];

$data = [
    'phone_number' => $phone_number,
    'message' => "Your verification code is: $verify_code",
    'message_type' => 'ARN',  // Required for alphanumeric sender ID
    'sender_id' => '6363297650' // Must be pre-approved by Telesign
];
echo $phone_number."\n";
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $url,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_SSL_VERIFYPEER => true
]);

// Execute request
$response = curl_exec($ch);
$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Handle errors
if (curl_errno($ch)) {
    die('cURL error: ' . curl_error($ch));
}

curl_close($ch);

// Process response
$response_json = json_decode($response);
if ($response_json->status->code === 200) {
    echo "Message sent successfully!";
} else {
    echo "Data: " . json_encode($data);
    echo "Error: " . json_encode($response_json);
}
?>