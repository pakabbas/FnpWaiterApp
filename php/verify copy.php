<?php
// Turn off all error display and HTML output before JSON header
ini_set('display_errors', 0);
ini_set('log_errors', 1);
error_reporting(0);
$email = isset($_COOKIE['Email']) ? $_COOKIE['Email'] : 'Not set';
// Clean any output buffer
if (ob_get_level()) {
    ob_clean();
}

// Set JSON header first
header('Content-Type: application/json');

include 'creds.php';

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
  $otp = $_POST['otp'] ?? '';

  if (!$phone || !$otp) {
    json_error("Missing phone number or OTP");
  }

  if (strlen($otp) !== 6 || !ctype_digit($otp)) {
    json_error("OTP must be 6 digits");
  }

  // Check OTP (with 5 minute expiry)
  $stmt = $conn->prepare("SELECT * FROM otp_store WHERE phone=? AND code=? AND created_at > DATE_SUB(NOW(), INTERVAL 5 MINUTE) ORDER BY created_at DESC LIMIT 1");
  if (!$stmt) {
    json_error("Database prepare failed: " . $conn->error);
  }

  $stmt->bind_param("ss", $phone, $otp);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    // Delete used OTP
    $delete_stmt = $conn->prepare("DELETE FROM otp_store WHERE phone=? AND code=?");
    if ($delete_stmt) {
      $delete_stmt->bind_param("ss", $phone, $otp);
    //  $delete_stmt->execute();
    }

    // Save to AppUsers if not exists
    $check = $conn->prepare("SELECT * FROM AppUsers WHERE PhoneNumber=?");
    if (!$check) {
      json_error("Database prepare failed: " . $conn->error);
    }

    $check->bind_param("s", $phone);
    $check->execute();
    $exists = $check->get_result()->num_rows > 0;

   // if (!$exists) {
      $insert = $conn->prepare("UPDATE AppUsers SET PhoneNumber = ? WHERE Email = ?");
      if (!$insert) {
        json_error("Database prepare failed: " . $conn->error);
      }
      $insert->bind_param("ss", $phone, $email);
      if (!$insert->execute()) {
        json_error("Failed to save user: " . $insert->error);
      }
    //}

    setcookie("PhoneNumber", $phone, time() + (86400 * 30), "/");

    json_success("Phone verified successfully for ". $email);
  } else {
    json_error("Invalid or expired OTP");
  }

} catch (Throwable $e) {
  json_error("Server error: " . $e->getMessage());
}
?>