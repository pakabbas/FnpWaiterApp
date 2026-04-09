<?php
// verify_reset_otp.php
session_start();
error_reporting(0); // Turn off error display for JSON responses
ini_set('display_errors', 0);

// Set JSON header
header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $otp = $_POST['otp'];
        
        // Check if OTP exists in session
        if (!isset($_SESSION['reset_otp']) || !isset($_SESSION['reset_email'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Session expired. Please request a new verification code.',
                'color' => 'red'
            ]);
            exit;
        }
        
        // Verify OTP
        if ($_SESSION['reset_otp'] == $otp) {
            // Mark OTP as verified
            $_SESSION['otp_verified'] = true;
            echo json_encode([
                'success' => true,
                'message' => 'Verification code confirmed. You can now reset your password.',
                'color' => 'green'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Invalid verification code. Please try again.',
                'color' => 'red'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid request method',
            'color' => 'red'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Server error occurred. Please try again.',
        'color' => 'red'
    ]);
}
exit;
?>