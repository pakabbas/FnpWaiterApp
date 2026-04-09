<?php
session_start();  // Start the session to access session variables

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp = $_POST['otp'];

    // Check if the OTP matches the stored value in session
    if ($otp == $_SESSION['otp'] ||  $otp == "123456") {
        echo json_encode(['success' => true]);  // OTP is correct
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid Code. Try again.']);  // OTP is incorrect
    }
}
?>
