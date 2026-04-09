<?php
// Turn off all error display and HTML output before JSON header
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(0);

// Clean any output buffer
if (ob_get_level()) {
    ob_clean();
}

// Set JSON header first
header('Content-Type: application/json');

include 'creds.php'; // Make sure $conn is defined here

function json_error($msg) {
  echo json_encode(['success' => false, 'message' => $msg]);
  exit;
}

function json_success($msg) {
  echo json_encode(['success' => true, 'message' => $msg]);
  exit;
}

try {
  if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_error("Invalid request method");
  }

  $phone = $_POST['phone'] ?? '';
  if (!$phone || strlen($phone) < 10) {
    json_error("Invalid phone number");
  }

  // Validate phone format
  if (!preg_match('/^\+[1-9]\d{1,14}$/', $phone)) {
    json_error("Phone number must be in international format (+country code + number)");
  }

  $code = rand(100000, 999999); // 6-digit OTP

  $customer_id = '9F70BA09-6F5A-4FEC-BC39-C6397206EA75';
  $api_key = 'Q59vZP17Vfz1gLB2sYqXTmdz7uxfP16hGwfEKO72r5HiIhJbWWf6e60/OeoyvnI3nuYyhFVAFCLS94A5rxExsg==';
  $message = "Your FoodnPals verification code is: $code";

  $url = 'https://rest-api.telesign.com/v1/messaging';
  $nonce = uniqid();
  $timestamp = gmdate("D, d M Y H:i:s T");

  $data = [
    'phone_number' => preg_replace('/^\+/', '', $phone),
    'message' => $message,
    'message_type' => 'OTP'
  ];
  $request_body = http_build_query($data);
  $content_type = 'application/x-www-form-urlencoded';
  $method = "POST";
  $resource = "/v1/messaging";
  $string_to_sign = "$method\n$content_type\n$timestamp\nx-ts-auth-method:HMAC-SHA256\nx-ts-nonce:$nonce\n$request_body\n$resource";
  $signature = base64_encode(hash_hmac('sha256', $string_to_sign, base64_decode($api_key), true));
  $auth_header = "TSA $customer_id:$signature";

  $ch = curl_init($url);
  curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POSTFIELDS => $request_body,
    CURLOPT_HTTPHEADER => [
      "Authorization: $auth_header",
      "Date: $timestamp",
      "Content-Type: $content_type",
      "x-ts-auth-method: HMAC-SHA256",
      "x-ts-nonce: $nonce"
    ],
    CURLOPT_TIMEOUT => 30,
    CURLOPT_SSL_VERIFYPEER => false
  ]);

  $response = curl_exec($ch);
  $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  $error = curl_error($ch);
  curl_close($ch);

  if ($error) {
    json_error("Network error: $error");
  }

  if ($status === 200) {
    // Delete old OTP codes for this phone
    $delete_stmt = $conn->prepare("DELETE FROM otp_store WHERE phone = ?");
    if ($delete_stmt) {
      $delete_stmt->bind_param("s", $phone);
      $delete_stmt->execute();
    }

    // Insert new OTP
    $stmt = $conn->prepare("INSERT INTO otp_store (phone, code, created_at) VALUES (?, ?, NOW())");
    if (!$stmt) {
      json_error("Database prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("ss", $phone, $code);
    if (!$stmt->execute()) {
      json_error("Database execute failed: " . $stmt->error);
    }

    json_success('OTP sent successfully');
  } else {
    $response_data = json_decode($response, true);
    $error_msg = isset($response_data['errors']) ? 
      implode(', ', array_column($response_data['errors'], 'description')) : 
      'Unknown TeleSign error';
    json_error("TeleSign Error ($status): $error_msg");
  }

} catch (Throwable $e) {
  json_error("Server error: " . $e->getMessage());
}
?>