<?php
if (strtoupper($_SERVER['REQUEST_METHOD'] ?? '') === 'POST' && isset($_POST['action'])) {
  header('Content-Type: application/json');

  $action = $_POST['action'];
  $email = trim($_POST['email'] ?? '');

  $isJson = true;
  require_once __DIR__ . '/creds.php';
  if (isset($conn) && $conn instanceof mysqli) {
    $conn->set_charset('utf8mb4');
  }
  require_once __DIR__ . '/vendor/autoload.php';

  if ($action === 'request') {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo json_encode(['success' => false, 'message' => 'Please enter a valid email']);
      exit;
    }

    $stmt = $conn->prepare('SELECT UserID, FirstName FROM AppUsers WHERE Email = ? and AccountStatus = "Active" LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user) {
      echo json_encode(['success' => false, 'message' => 'No account found for this email']);
      exit;
    }

    $code = (string)random_int(100000, 999999);
    $stmt = $conn->prepare('UPDATE AppUsers SET LoginToken = ? WHERE UserID = ?');
    $stmt->bind_param('si', $code, $user['UserID']);
    $stmt->execute();
    $stmt->close();

    try {
      $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'hussainrox555@gmail.com';
      $mail->Password = 'jiuqobkapbgmisos';
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;

      $mail->setFrom('hussainrox555@gmail.com', 'FoodnPals');
      $mail->addAddress($email, $user['FirstName'] ?? '');
      $mail->isHTML(true);
      $mail->Subject = 'Your password reset code';
      $mail->Body = '<p>Hello' . (!empty($user['FirstName']) ? ' ' . htmlspecialchars($user['FirstName']) : '') . ',</p>' .
                    '<p>Your verification code is:</p>' .
                    '<h2 style="letter-spacing:3px; color: #4cbb17;">' . htmlspecialchars($code) . '</h2>' .
                    '<p>This code will be required to reset your password.</p>' .
                    '<p>If you did not request this, you can ignore this email.</p>';
      $mail->AltBody = 'Your verification code is: ' . $code;
      $mail->send();
    } catch (\Throwable $e) {
      error_log('Mail send failed: ' . $e->getMessage());
    }

    echo json_encode(['success' => true, 'message' => 'Verification code sent to your email.']);
    exit;
  }

  if ($action === 'verify') {
    $otp = trim($_POST['otp'] ?? '');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo json_encode(['success' => false, 'message' => 'Please enter a valid email']);
      exit;
    }
    if ($otp === '' || !preg_match('/^\d{6}$/', $otp)) {
      echo json_encode(['success' => false, 'message' => 'Invalid verification code']);
      exit;
    }

    $stmt = $conn->prepare('SELECT UserID, LoginToken FROM AppUsers WHERE Email = ? and AccountStatus = "Active" LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user || (string)$user['LoginToken'] !== $otp) {
      echo json_encode(['success' => false, 'message' => 'Incorrect code']);
      exit;
    }

    echo json_encode(['success' => true, 'message' => 'Code verified. You can now set a new password.']);
    exit;
  }

  if ($action === 'reset') {
    $otp = trim($_POST['otp'] ?? '');
    $password = (string)($_POST['password'] ?? '');
    $confirmPassword = (string)($_POST['confirmPassword'] ?? '');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo json_encode(['success' => false, 'message' => 'Please enter a valid email']);
      exit;
    }
    if ($otp === '' || !preg_match('/^\d{6}$/', $otp)) {
      echo json_encode(['success' => false, 'message' => 'Invalid verification code']);
      exit;
    }
    if ($password === '' || strlen($password) < 6) {
      echo json_encode(['success' => false, 'message' => 'Password must be at least 6 characters']);
      exit;
    }
    if ($password !== $confirmPassword) {
      echo json_encode(['success' => false, 'message' => 'Passwords do not match']);
      exit;
    }

    $stmt = $conn->prepare('SELECT UserID, LoginToken FROM AppUsers WHERE Email = ? and AccountStatus = "Active" LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if (!$user || (string)$user['LoginToken'] !== $otp) {
      echo json_encode(['success' => false, 'message' => 'Invalid email or code']);
      exit;
    }

    // Hash password similar to add_customer.php
    $cleanPassword = password_hash($password, PASSWORD_DEFAULT);
    $empty = '';
    $stmt = $conn->prepare('UPDATE AppUsers SET Password = ?, LoginToken = ? WHERE UserID = ?');
    $stmt->bind_param('ssi', $cleanPassword, $empty, $user['UserID']);
    $ok = $stmt->execute();
    $stmt->close();

    if ($ok) {
      echo json_encode(['success' => true, 'message' => 'Password has been reset successfully']);
    } else {
      echo json_encode(['success' => false, 'message' => 'Failed to update password']);
    }
    exit;
  }

  echo json_encode(['success' => false, 'message' => 'Invalid request']);
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reset Password - FoodnPals</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />

  <style>
    body, html {
      height: 100%;
      margin: 0;
      background-color: #50B849;
    }

    .container-fluid {
      height: 100vh;
      display: flex;
      flex-wrap: wrap;
      background-color: #50B849;
    }

    .left-section {
      width: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #50B849;
    }

    .image-wrapper img {
      max-width: 100%;
      height: auto;
    }

    .right-section {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px;
      width: 50%;
      background-color: #50B849;
    }

    .login-form {
      max-width: 400px;
      width: 100%;
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .login-form h2 {
      color: #4cbb17;
    }

    .btn-custom {
      border: 1px solid #4cbb17;
      background-color: #ffffff;
      color: #4cbb17;
      border-radius: 10px;
      width: 100%;
      transition: background-color 0.2s, color 0.2s;
    }

    .btn-custom:hover, .btn-custom:focus {
      background-color: #4cbb17;
      color: #ffffff;
    }

    .error-message {
      color: red;
      text-align: center;
      margin-top: 10px;
    }

    @media (max-width: 992px) {
      .container-fluid {
        flex-direction: column;
        justify-content: center;
      }

      .left-section {
        display: none;
      }

      .right-section {
        width: 100%;
        height: auto;
      }
    }

    @media (max-width: 768px) {
      .right-section {
        padding: 15px;
      }
      .login-form {
        padding: 20px;
      }
      .btn-light {
        display: none;
      }
    }

    .spinner {
      display: inline-block;
      width: 20px;
      height: 20px;
      border: 3px solid rgba(255,255,255,.3);
      border-radius: 50%;
      border-top-color: #fff;
      animation: spin 1s ease-in-out infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }
  </style>
</head>
<body>
  <div style="background-color: #50B849;" class="container-fluid">
    <div class="left-section">
      <div class="image-wrapper">
        <img src="Resources/login 1.png" alt="Reset Password Image" />
      </div>
    </div>

    <div style="background-color: #50B849;" class="right-section">
      <div class="login-form">
        <h2 class="mb-3 text-center">Forgot Password</h2>
        <label>Reset your password by following the steps</label>

        <form id="forgotPasswordForm">
          <div class="form-group">
            <label for="Email">Email</label>
            <input type="email" class="form-control" id="Email" placeholder="user@mail.com" required />
          </div>

          <div id="otpContainer" class="form-group" style="display: none;">
            <label for="OTP">Enter Verification Code</label>
            <input type="text" class="form-control" id="OTP" placeholder="000000" maxlength="6" />
            <small class="form-text text-muted">Check your email for the 6-digit verification code.</small>
            <div class="mt-2">
              <button type="button" id="resendOtpButton" class="btn btn-link p-0" style="color: #4cbb17; display: none;">Resend Code</button>
              <span id="timerDisplay" class="text-muted"></span>
            </div>
          </div>

          <div id="passwordContainer" style="display: none;">
            <div class="form-group">
              <label for="Password">New Password</label>
              <input type="password" class="form-control" id="Password" placeholder="Enter new password" minlength="6" required />
            </div>
            <div class="form-group">
              <label for="ConfirmPassword">Confirm Password</label>
              <input type="password" class="form-control" id="ConfirmPassword" placeholder="Re-enter new password" minlength="6" required />
            </div>
          </div>

          <button id="sendOtpButton" type="button" class="btn btn-custom btn-block">Send Verification Code</button>
          <button id="resetPasswordButton" type="submit" class="btn btn-custom btn-block" style="display: none;">Reset Password</button>

          <div id="errorMessage" class="error-message"></div>

          <hr />
          <button type="button" class="btn btn-light btn-block w-100">
            <a href="google-login.php" class="d-flex align-items-center justify-content-center">
              <img src="Resources/google_icon.png" alt="Google" class="me-2" style="height: 20px;" />
              Login with Google
            </a>
          </button>

          <button type="button" class="btn btn-light btn-block w-100 mt-2">
            <img src="Resources/apple.png" alt="Apple" class="me-2" style="border-radius:10px; height: 20px;">
            Continue with Apple
          </button>

          <div class="text-center mt-3">
            Already have an account? <a href="Login.html" style="color: #4cbb17;">Login</a>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    let timer;
    const TIMER_DURATION = 60;

    function startTimer() {
      let timeLeft = TIMER_DURATION;
      const timerDisplay = document.getElementById("timerDisplay");
      const resendOtpButton = document.getElementById("resendOtpButton");
      
      // Hide resend button and show timer
      resendOtpButton.style.display = "none";
      timerDisplay.style.display = "inline";
      
      timer = setInterval(() => {
        timeLeft--;
        timerDisplay.textContent = `Resend code in ${timeLeft}s`;
        
        if (timeLeft <= 0) {
          clearInterval(timer);
          timerDisplay.style.display = "none";
          resendOtpButton.style.display = "inline";
        }
      }, 1000);
    }

    // Resend OTP Button Logic
    document.getElementById("resendOtpButton").addEventListener("click", function() {
      const email = document.getElementById("Email").value;
      const resendOtpButton = this;
      
      // Show loading state
      resendOtpButton.innerHTML = '<span class="spinner"></span> Sending...';
      resendOtpButton.disabled = true;

      // Send AJAX request to request new OTP
      const formData = new FormData();
      formData.append('action', 'request');
      formData.append('email', email);

      fetch('ForgetPswd.php', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          showMessage(data.message, data.color || "green");
          startTimer();
        } else {
          showMessage(data.message, data.color || "red");
          resendOtpButton.innerHTML = 'Resend Code';
          resendOtpButton.disabled = false;
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showMessage("An error occurred. Please try again.", "red");
        resendOtpButton.innerHTML = 'Resend Code';
        resendOtpButton.disabled = false;
      });
    });

    // Send OTP Button Logic
    document.getElementById("sendOtpButton").addEventListener("click", function () {
      const email = document.getElementById("Email").value;
      const errorMessage = document.getElementById("errorMessage");
      const otpContainer = document.getElementById("otpContainer");
      const sendOtpButton = document.getElementById("sendOtpButton");

      if (!email) {
        showMessage("Please enter your email.", "red");
        return;
      }

      // Validate email format
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        showMessage("Please enter a valid email address.", "red");
        return;
      }

      // Show loading state
      sendOtpButton.innerHTML = '<span class="spinner"></span> Sending...';
      sendOtpButton.disabled = true;

      // Send AJAX request to request OTP
      const formData = new FormData();
      formData.append('action', 'request');
      formData.append('email', email);

      fetch('ForgetPswd.php', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          otpContainer.style.display = "block";
          sendOtpButton.style.display = "none";
          document.getElementById("Email").readOnly = true;
          showMessage(data.message, data.color || "green");
          startTimer();
        } else {
          showMessage(data.message, data.color || "red");
          sendOtpButton.innerHTML = 'Send Verification Code';
          sendOtpButton.disabled = false;
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showMessage("An error occurred. Please try again.", "red");
        sendOtpButton.innerHTML = 'Send Verification Code';
        sendOtpButton.disabled = false;
      });
    });

    // OTP Verification Logic
    document.getElementById("OTP").addEventListener("input", function () {
      const otp = this.value;
      const passwordContainer = document.getElementById("passwordContainer");
      const resetPasswordButton = document.getElementById("resetPasswordButton");

      if (otp.length === 6) {
        // Send AJAX request to verify OTP
        const formData = new FormData();
        formData.append('action', 'verify');
        formData.append('email', document.getElementById('Email').value);
        formData.append('otp', otp);

        fetch('ForgetPswd.php', {
          method: 'POST',
          body: formData,
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            passwordContainer.style.display = "block";
            resetPasswordButton.style.display = "block";
            document.getElementById("OTP").readOnly = true;
            document.getElementById("resendOtpButton").style.display = "none";
            document.getElementById("timerDisplay").style.display = "none";
            if (timer) clearInterval(timer);
            showMessage(data.message, data.color || "green");
          } else {
            showMessage(data.message, data.color || "red");
            document.getElementById("OTP").value = "";
          }
        })
        .catch(error => {
          console.error('Error:', error);
          showMessage("An error occurred while verifying code.", "red");
        });
      }
    });

    // Reset Password Form Submission
    document.getElementById("forgotPasswordForm").addEventListener("submit", function (event) {
      event.preventDefault();
      const password = document.getElementById("Password").value;
      const confirmPassword = document.getElementById("ConfirmPassword").value;
      const resetPasswordButton = document.getElementById("resetPasswordButton");

      if (!password || !confirmPassword) {
        showMessage("Please fill out all password fields.", "red");
        return;
      }

      if (password !== confirmPassword) {
        showMessage("Passwords do not match.", "red");
        return;
      }

      if (password.length < 6) {
        showMessage("Password must be at least 6 characters long.", "red");
        return;
      }

      // Show loading state
      resetPasswordButton.innerHTML = '<span class="spinner"></span> Resetting...';
      resetPasswordButton.disabled = true;

      // Send AJAX request to reset password
      const formData = new FormData();
      formData.append('action', 'reset');
      formData.append('email', document.getElementById('Email').value);
      formData.append('otp', document.getElementById('OTP').value);
      formData.append('password', password);
      formData.append('confirmPassword', confirmPassword);

      fetch('ForgetPswd.php', {
        method: 'POST',
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          showMessage(data.message, data.color || "green");
          setTimeout(function() {
            window.location.href = "Login.html";
          }, 2000);
        } else {
          showMessage(data.message, data.color || "red");
          resetPasswordButton.innerHTML = 'Reset Password';
          resetPasswordButton.disabled = false;
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showMessage("An error occurred while resetting password.", "red");
        resetPasswordButton.innerHTML = 'Reset Password';
        resetPasswordButton.disabled = false;
      });
    });

    // Helper function to show messages
    function showMessage(message, color) {
      const errorMessage = document.getElementById("errorMessage");
      errorMessage.textContent = message;
      errorMessage.style.color = color;
    }
  </script>
</body>
</html>
