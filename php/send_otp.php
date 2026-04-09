
<?php
//send_otp.php:
session_start();
error_reporting(E_ALL); // Enable error reporting to capture details
ini_set('display_errors', 0); // But don't display them to avoid breaking JSON

// Set JSON header
header('Content-Type: application/json');

require_once 'creds.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    
    $stmt = $conn->prepare("SELECT 1 FROM AppUsers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode([
            'success' => false,
            'message' => 'Account already exists with this email!',
            'color' => 'red'
        ]);
        exit;
    }



    $otp = rand(100000, 999999);

    $_SESSION['otp'] = $otp;
    $_SESSION['email'] = $email;

    $subject = 'Welcome to FoodnPals - Verify Your Account';

    $verificationLink = "https://foodnpals.com/verify?email=" . urlencode($email);

        $message = "
<!DOCTYPE html>
<html>
<head>
    <meta charset=\"UTF-8\">
    <title>Verify Your FoodnPals Account</title>
</head>
<body style=\"margin:0;padding:0;background-color:#f4f4f4;\">
    <table width=\"100%\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\">
        <tr>
            <td align=\"center\" style=\"padding:20px 0;\">
                <table width=\"600\" cellpadding=\"0\" cellspacing=\"0\" role=\"presentation\" style=\"background:#ffffff;border-radius:8px;box-shadow:0 4px 8px rgba(0,0,0,0.1);padding:20px;\">
                    <tr>
                        <td align=\"center\" style=\"font-family:Arial,sans-serif;font-size:24px;font-weight:bold;color:#28a745;margin-bottom:15px;\">
                            Welcome to FoodnPals Family!
                        </td>
                    </tr>
                    <tr>
                        <td align=\"center\" style=\"font-family:Arial,sans-serif;font-size:16px;color:#555555;margin-bottom:25px;\">
                            We're excited to have you on board. To complete your account setup, please use the verification code below.
                        </td>
                    </tr>
                    <tr>
                        <td align=\"center\" style=\"padding-bottom:25px;\">
                            <img src=\"https://foodnpals.com/Resources/logo.png\" alt=\"FoodnPals Logo\" style=\"width:100%;height:auto;margin-bottom:25px;\">
                        </td>
                    </tr>
                    <tr>
                        <td align=\"center\" style=\"font-family:'Courier New',monospace;font-size:30px;font-weight:bold;color:#28a745;margin-bottom:25px;\">
                            $otp
                        </td>
                    </tr>
                    <tr>
                        <td align=\"center\" style=\"font-family:Arial,sans-serif;font-size:14px;color:#555555;margin-bottom:25px;\">
                            Please enter this code in the verification section of your account settings to activate your account. If you didn’t sign up for FoodnPals, you can ignore this email.
                        </td>
                    </tr>
                    <tr>
                        <td align=\"center\" style=\"padding-bottom:25px;\">
                            <a href=\"$verificationLink\" style=\"background-color:#28a745;color:#ffffff;padding:10px 20px;border-radius:5px;font-family:Arial,sans-serif;font-size:16px;text-decoration:none;display:inline-block;\">Verify Now</a>
                        </td>
                    </tr>
                    <tr>
                        <td align=\"center\" style=\"font-family:Arial,sans-serif;font-size:14px;color:#555555;margin-top:25px;\">
                            Thank you for choosing!
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
";

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: FoodnPals <no-reply@foodnpals.com>" . "\r\n";
        $headers .= "Reply-To: no-reply@foodnpals.com" . "\r\n";

        if (mail($email, $subject, $message, $headers)) {
            echo json_encode(['success' => true, 'message' => 'OTP sent successfully to ' . $email]);
        } else {
            $error = error_get_last();
            $detailed_error = $error ? $error['message'] : 'Unknown mail() error.';
            error_log('Mail send failed in send_otp.php for email: ' . $email . '. Error: ' . $detailed_error);
            echo json_encode([
                'success' => false, 
                'message' => 'Failed to send verification code. Please try again.',
                'error' => $detailed_error
            ]);
        }
        exit;
}
?>