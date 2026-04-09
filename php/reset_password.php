<?php
// reset_password.php
session_start();
error_reporting(0); // Turn off error display for JSON responses
ini_set('display_errors', 0);

// Set JSON header
header('Content-Type: application/json');

try {
    require_once 'creds.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        
        // Check if OTP was verified
        if (!isset($_SESSION['otp_verified']) || !$_SESSION['otp_verified']) {
            echo json_encode([
                'success' => false,
                'message' => 'Please verify your email first.',
                'color' => 'red'
            ]);
            exit;
        }
        
        if (!isset($_SESSION['reset_email'])) {
            echo json_encode([
                'success' => false,
                'message' => 'Session expired. Please start the process again.',
                'color' => 'red'
            ]);
            exit;
        }
        
        // Validate passwords
        if ($password !== $confirmPassword) {
            echo json_encode([
                'success' => false,
                'message' => 'Passwords do not match.',
                'color' => 'red'
            ]);
            exit;
        }
        
        if (strlen($password) < 6) {
            echo json_encode([
                'success' => false,
                'message' => 'Password must be at least 6 characters long.',
                'color' => 'red'
            ]);
            exit;
        }
        
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $email = $_SESSION['reset_email'];
        
        // Update password in database
        $stmt = $conn->prepare("UPDATE AppUsers SET password = ? WHERE email = ? AND AccountStatus = 'Active'");
        $stmt->bind_param("ss", $hashedPassword, $email);
        
        if ($stmt->execute()) {
            // Clear session data
            unset($_SESSION['reset_otp']);
            unset($_SESSION['reset_email']);
            unset($_SESSION['otp_verified']);
            
            echo json_encode([
                'success' => true,
                'message' => 'Password reset successfully! You can now login with your new password.',
                'color' => 'green'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to update password. Please try again.',
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