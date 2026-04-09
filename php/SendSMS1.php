<?php
/**
 * TeleSign Message Status Checker
 * 
 * This script checks the delivery status of a previously sent message
 */

// TeleSign credentials
$customer_id = '9F70BA09-6F5A-4FEC-BC39-C6397206EA75';
$api_key = 'Q59vZP17Vfz1gLB2sYqXTmdz7uxfP16hGwfEKO72r5HiIhJbWWf6e60/OeoyvnI3nuYyhFVAFCLS94A5rxExsg==';

// Reference ID from the previous API call
$reference_id = '365D8EC9570808689197C1A1D129DC62';

// Set the API endpoint for status checking
$url = "https://rest-api.telesign.com/v1/messaging/$reference_id";

// Create a nonce (random string) and current timestamp
$nonce = uniqid();
$date = new DateTime("now", new DateTimeZone("UTC"));
$timestamp = $date->format("D, d M Y H:i:s T");

// Create the string to sign
$method = "GET";
$content_type = "application/x-www-form-urlencoded";
$resource = "/v1/messaging/$reference_id";

// Format the string to sign according to TeleSign requirements for GET requests
// From the error message, we can see TeleSign expects no empty line before the resource path
$string_to_sign = "$method\n$content_type\n$timestamp\nx-ts-auth-method:HMAC-SHA256\nx-ts-nonce:$nonce\n$resource";

// Calculate the signature
$signature = base64_encode(hash_hmac('sha256', $string_to_sign, base64_decode($api_key), true));

// Create the Authorization header
$auth_header = "TSA $customer_id:$signature";

// Initialize cURL session
$ch = curl_init($url);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
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

// Parse the JSON response
$response_data = json_decode($response, true);

// Display the message status in a user-friendly way
if (isset($response_data['status']['code'])) {
    $status_code = $response_data['status']['code'];
    $status_description = $response_data['status']['description'];
    
    echo "\n--- Message Status ---\n";
    echo "Status Code: $status_code\n";
    echo "Description: $status_description\n";
    
    // Interpret the status code
    if ($status_code == 290) {
        echo "Status: Message is still in progress\n";
    } elseif ($status_code == 291) {
        echo "Status: Message has been delivered successfully\n";
    } elseif ($status_code == 292) {
        echo "Status: Message delivery failed\n";
    } elseif ($status_code == 295) {
        echo "Status: Message expired before delivery\n";
    } elseif ($status_code == 500) {
        echo "Status: There is an error with the message\n";
    } else {
        echo "Status: Unknown status code\n";
    }
}

// For debugging
echo "\nString to Sign: $string_to_sign\n";
echo "Auth Header: $auth_header\n";
?>