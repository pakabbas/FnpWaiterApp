<?php
/**
 * TeleSign SMS Sender
 * 
 * This script demonstrates how to send SMS messages using the TeleSign REST API.
 */

// TeleSign credentials
$customer_id = '9F70BA09-6F5A-4FEC-BC39-C6397206EA75';
$api_key = 'Q59vZP17Vfz1gLB2sYqXTmdz7uxfP16hGwfEKO72r5HiIhJbWWf6e60/OeoyvnI3nuYyhFVAFCLS94A5rxExsg==';
$phone_number = '+17345893503';
$verify_code = '123456';

// Create the message to send
$message = "Message Number 3 From Abbas: Your verification code is: $verify_code";

// Set the API endpoint
$url = 'https://rest-api.telesign.com/v1/messaging';

// Create a nonce (random string) and current timestamp
$nonce = uniqid();
$date = new DateTime("now", new DateTimeZone("UTC"));
$timestamp = $date->format("D, d M Y H:i:s T");

// Prepare the data to send - MOVED UP
$data = array(
    'phone_number' => '17345893503',
    'message' => "From Abbas: Your verification code is: 123456",
    'message_type' => 'MKT'
);

ksort($data); // important for consistent ordering!

$request_body = http_build_query($data, '', '&', PHP_QUERY_RFC3986);


// Create the string to sign
$content_type = 'application/x-www-form-urlencoded';

$method = "POST";
$resource = "/v1/messaging";

// Format the string to sign according to TeleSign requirements
$request_body = http_build_query($data);
$string_to_sign = "$method\n$content_type\n$timestamp\nx-ts-auth-method:HMAC-SHA256\nx-ts-nonce:$nonce\n$request_body\n$resource";

// Calculate the signature
$signature = base64_encode(hash_hmac('sha256', $string_to_sign, base64_decode($api_key), true));

// Create the Authorization header
$auth_header = "TSA $customer_id:$signature";

// Initialize cURL session
$ch = curl_init($url);

// Set cURL options
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Authorization: $auth_header",
    "Date: $timestamp",
    "Content-Type: $content_type",
    "x-ts-auth-method: HMAC-SHA256",
    "x-ts-nonce: $nonce"
    
));

// Execute the request
$response = curl_exec($ch);
$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Check for errors
if (curl_errno($ch)) {
    echo "cURL Error: " . curl_error($ch) . "\n";
    exit;
}

curl_close($ch);

// Output the response
echo "HTTP Status Code: $status_code\n";
echo "Response: $response\n";

// For debugging
echo "String to Sign: $string_to_sign\n";
echo "Auth Header: $auth_header\n";
?>