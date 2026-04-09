<?php
// debug_send_reset_otp.php - Simplified version for testing
session_start();

// Set JSON header first
header('Content-Type: application/json');

// Check if POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

// Check if email is provided
if (empty($_POST['email'])) {
    echo json_encode(['success' => false, 'message' => 'Email is required']);
    exit;
}

$email = $_POST['email'];

// Basic email validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Invalid email format']);
    exit;
}

try {
    // Try to include database connection
    if (file_exists('creds.php')) {
        require_once 'creds.php';
        
        // Check if connection exists
        if (!isset($conn)) {
            echo json_encode(['success' => false, 'message' => 'Database connection failed']);
            exit;
        }
        
        // Check if user exists
        $stmt = $conn->prepare("SELECT 1 FROM AppUsers WHERE email = ?");
        if (!$stmt) {
            echo json_encode(['success' => false, 'message' => 'Database query preparation failed']);
            exit;
        }
        
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            echo json_encode([
                'success' => false,
                'message' => 'No account found with this email address!'
            ]);
            exit;
        }
        
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Database configuration file not found']);
        exit;
    }

    // Generate OTP
    $otp = rand(100000, 999999);
    
    // Store in session
    $_SESSION['reset_otp'] = $otp;
    $_SESSION['reset_email'] = $email;

    // Simple email (you can enhance this later)
    $subject = 'FoodnPals - Password Reset Code';
    $message = "Your password reset verification code is: " . $otp;
    $headers = "From: FoodnPals <no-reply@foodnpals.com>\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    // Try to send email
    if (mail($email, $subject, $message, $headers)) {
        echo json_encode([
            'success' => true,
            'message' => 'Verification code sent to ' . $email
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Failed to send email. Please check your server mail configuration.'
        ]);
    }

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Server error: ' . $e->getMessage()
    ]);
}

exit;
?>