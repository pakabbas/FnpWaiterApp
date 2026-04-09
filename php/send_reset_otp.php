<?php
// send_reset_otp.php
session_start();
error_reporting(0); // Turn off error display for JSON responses
ini_set('display_errors', 0);

// Set JSON header
header('Content-Type: application/json');

try {
    require_once 'creds.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $email = $_POST['email'];
        
        // Check if user exists in database (opposite of registration check)
        $stmt = $conn->prepare("SELECT 1 FROM AppUsers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 0) {
            echo json_encode([
                'success' => false,
                'message' => 'No account found with this email address!',
                'color' => 'red'
            ]);
            exit;
        }

        // Generate OTP
        $otp = rand(100000, 999999);

        // Store OTP and email in session
        $_SESSION['reset_otp'] = $otp;
        $_SESSION['reset_email'] = $email;

        $subject = 'FoodnPals - Password Reset Verification';

        $message = "
        <html>
        <head>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }
                .container {
                    max-width: 600px;
                    margin: 20px auto;
                    background: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0px 0px 10px #ccc;
                }
                .header {
                    text-align: center;
                    padding: 20px;
                }
                .header img {
                    width: 180px;
                }
                .content {
                    text-align: center;
                    padding: 20px;
                }
                .code {
                    background: #f4f4f4;
                    display: inline-block;
                    padding: 10px 20px;
                    font-size: 24px;
                    font-weight: bold;
                    color: #4CBB17;
                    border-radius: 5px;
                }
                .footer {
                    text-align: center;
                    padding: 20px;
                    font-size: 14px;
                    color: #666;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <img style=\"width: 210px;\" src='https://foodnpals.com/Resources/logo.png' alt='FoodnPals'>
                </div>
                
                <img style=\"width: 600px;\" src='https://foodnpals.com/Resources/email1.jpg' alt='FoodnPals'>
               
                <div class='content'>
                    <p>You requested to reset your password. Please use the verification code below to proceed with password reset.</p>
                    <br> 
                    <h1 style=\"color:black;\">Password Reset Code</h1>
                    <div class='code'>$otp</div>
                    <p style=\"color: #666; font-size: 14px; margin-top: 20px;\">This code will expire in 10 minutes. If you didn't request this, please ignore this email.</p>
                </div>
                <div class='footer'>
                    <img style=\"width: 600px;\" src='https://foodnpals.com/Resources/email2.jpg' alt='FoodnPals'>
                </div>
            </div>
        </body>
        </html>
        ";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: FoodnPals <no-reply@foodnpals.com>" . "\r\n";
        $headers .= "Reply-To: no-reply@foodnpals.com" . "\r\n";

        if (mail($email, $subject, $message, $headers)) {
            echo json_encode([
                'success' => true, 
                'message' => 'Verification code sent successfully to ' . $email,
                'color' => 'green'
            ]);
        } else {
            echo json_encode([
                'success' => false, 
                'message' => 'Failed to send verification email. Please try again.',
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