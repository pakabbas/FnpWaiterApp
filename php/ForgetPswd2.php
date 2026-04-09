<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password - FoodnPals</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body,
    html {
      height: 100%;
    }

    .bg-image {
      background-image: url('Resources/banner1.png');
      height: 100%;
      background-position: center;
      background-repeat: no-repeat;
      background-size: cover;
    }

    .login-container {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100%;
    }

    .login-form {
      background-color: rgba(255, 255, 255, 0.7);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
      margin-top: 30px;
      width: 70%;
    }

    .loading {
      opacity: 0.6;
      pointer-events: none;
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
  <div class="bg-image">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 offset-lg-6 col-md-8 offset-md-2 login-container">
          <div class="login-form" style="min-width: 350px;">
            <h2 class="mb-4">Forgot Password</h2>
            <label>Reset your password by following the steps</label>

            <form id="forgotPasswordForm">
              <div class="form-group">
                <label for="Email">Email</label>
                <input type="email" class="form-control" id="Email" placeholder="user@mail.com" required>
              </div>

              <div id="otpContainer" class="form-group" style="display: none;">
                <label for="OTP">Enter Verification Code</label>
                <input type="text" class="form-control" id="OTP" placeholder="000000" maxlength="6">
                <small class="form-text text-muted">Check your email for the 6-digit verification code.</small>
              </div>

              <div id="passwordContainer" style="display: none;">
                <div class="form-group">
                  <label for="Password">New Password</label>
                  <input type="password" class="form-control" id="Password" placeholder="Enter new password" minlength="6" required>
                </div>
                <div class="form-group">
                  <label for="ConfirmPassword">Confirm Password</label>
                  <input type="password" class="form-control" id="ConfirmPassword" placeholder="Re-enter new password" minlength="6" required>
                </div>
              </div>

              <button
                id="sendOtpButton"
                type="button"
                style="border: none; background-color: #4CBB17; border-radius: 10px;"
                class="btn btn-primary btn-block">
                Send Verification Code
              </button>

              <button
                id="resetPasswordButton"
                type="submit"
                style="border: none; background-color: #4CBB17; border-radius: 10px; display: none;"
                class="btn btn-primary btn-block">
                Reset Password
              </button>

              <div id="errorMessage" style="margin-top: 10px; font-weight: bold;"></div>

              <hr>
              <button type="button" class="btn btn-danger btn-block" style="background-color: white; color: #313957;">
                <a href="google-login.php" style="text-decoration: none; color: inherit;">
                  <img src="Resources/google_icon.png" alt="Google" class="mr-2" />
                  Login with Google
                </a>
              </button>
              <button type="button" class="btn btn-primary btn-block" style="background-color: white; color: #313957;">
                <img style="border-radius:10px;" src="Resources/apple.png" alt="Apple" class="mr-2"> Continue with Apple
              </button>
              <div class="text-center mt-3">
                Already have an account? <a style="color: #4CBB17;" href="Login.html">Login</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
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

      // Send AJAX request to PHP backend
      const formData = new FormData();
      formData.append('email', email);

      fetch('send_reset_otp.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          otpContainer.style.display = "block";
          sendOtpButton.style.display = "none";
          document.getElementById("Email").readOnly = true;
          showMessage(data.message, data.color || "green");
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
        formData.append('otp', otp);

        fetch('verify_reset_otp.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            passwordContainer.style.display = "block";
            resetPasswordButton.style.display = "block";
            document.getElementById("OTP").readOnly = true;
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
      formData.append('password', password);
      formData.append('confirmPassword', confirmPassword);

      fetch('reset_password.php', {
        method: 'POST',
        body: formData
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