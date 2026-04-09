<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
    <meta name="description" content="FoodnPals">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">

  <title>Sign Up - FoodnPals</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"/>
  <style>
    html, body {
      height: 100%;
      margin: 0;
    }

    .main-container {
      display: flex;
      height: 100vh;
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
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      background: #50B849;
    }

    .login-form {
      background-color: rgba(255, 255, 255, 0.9);
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 400px;
    }

    .btn-custom {
      border: none;
      background-color: #4CBB17;
      border-radius: 10px;
    }

    .social-btn {
      background-color: white;
      color: #313957;
      border: 1px solid #ddd;
    }

    .social-btn img {
      margin-right: 10px;
    }

    a {
      color: #4CBB17;
    }

    /* Responsive Design */
    @media (max-width: 767px) {
      .main-container {
        flex-direction: column;
      }

      .left-section {
        display: none; /* Hide the left section on mobile */
      }

      .right-section {
        background-color: #ffffff;
        width: 100%;
      }

      .login-form {
        padding: 20px;
        max-width: 90%;
        width: 100%;
      }
      .social-btn {
        display: none;
      }
    }

    /* Surface Pro Z and similar tablet resolutions (768px - 1024px) */
    @media (min-width: 768px) and (max-width: 1024px) {
      .main-container {
        flex-direction: row;
        height: 100vh;
      }

      .left-section {
        display: none; /* Hide the left section on tablets */
      }

      .right-section {
        width: 100%;
        height: 100vh;
        background: #50B849;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .login-form {
        padding: 100px 30px 100px 30px;
        max-width: 80%;
        width: 100%;
      }

      .social-btn {
        display: block;
      }
    }

    /* Large tablets and small desktops (1025px and up) */
    @media (min-width: 1025px) {
      .main-container {
        flex-direction: row;
        height: 100vh;
      }

      .left-section {
        display: flex;
        width: 50%;
        height: 100vh;
        align-items: center;
        justify-content: center;
        background-color: #50B849;
      }

      .right-section {
        width: 50%;
        height: 100vh;
        background: #ddf2d3;
        display: flex;
        align-items: center;
        justify-content: center;
      }

      .image-wrapper img {
        max-width: 100%;
        height: auto;
      }

      .login-form {
        padding: 30px;
        max-width: 400px;
        width: 100%;
      }

      .social-btn {
        display: block;
      }
    }
  </style>
</head>
<body>

<div class="main-container">
  <div class="left-section">
    <div class="image-wrapper">
      <img src="Resources/login 1.png" alt="Login Image">
    </div>
  </div>

  <div class="right-section" style="background:#ddf2d3;">
    <div class="login-form text-center" >
      <h2 class="mb-3">Create An Account</h2>
      <p>Sign up or log in to continue</p>

      <form id="signupForm">
        <div class="form-group text-left">
          <label for="Email">Email</label>
          <input type="text" class="form-control" id="Email" placeholder="user@mail.com">
        </div>

        <div id="otpContainer" class="form-group text-left" style="display: none;">
          <label for="OTP">Enter Verification Code</label>
          <input type="text" class="form-control" id="OTP" placeholder="000000">
        </div>

        <button id="sendOtpButton" style="color:white;" type="button" class="btn btn-custom btn-block">Send Verification Code</button>

        <button id="signUpButton" type="submit" class="btn btn-custom btn-block" style="display: none;">Sign Up</button>

        <div id="errorMessage" style="color: red; margin-top: 10px;"></div>

        <hr>

        <a href="google-login.php" class="btn social-btn btn-block" id="googleBtn">
          <img src="Resources/google_icon.png" alt="Google"> Continue with Google
        </a>

        <button type="button" class="btn social-btn btn-block" id="appleBtn">
          <img src="Resources/apple.png" alt="Apple" style="border-radius: 10px;"> Continue with Apple
        </button>

        <div class="mt-3">
          Already have an account? <a href="Login.html">Login</a>
        </div>
      </form>
    </div>
  </div>
</div>
<script>
  const emailInput = document.getElementById("Email");
  const otpInput = document.getElementById("OTP");
  const sendOtpButton = document.getElementById("sendOtpButton");
  const signUpButton = document.getElementById("signUpButton");
  const otpContainer = document.getElementById("otpContainer");
  const errorMessage = document.getElementById("errorMessage");
  const signupForm = document.getElementById("signupForm");
  const googleBtn = document.getElementById("googleBtn");
  const appleBtn = document.getElementById("appleBtn");

  // Function to detect if running in a webview
  function isWebView() {
    const userAgent = navigator.userAgent || navigator.vendor || window.opera;
    
    // Check for Android WebView
    const isAndroidWebView = /Android/i.test(userAgent) && 
      (userAgent.includes('wv') || userAgent.includes('WebView') || 
       !userAgent.includes('Chrome') || userAgent.includes('Version/'));
    
    // Check for iOS WebView
    const isIOSWebView = /iPad|iPhone|iPod/.test(userAgent) && 
      !window.MSStream && !window.webkit && !window.chrome;
    
    // Additional checks for webview detection
    const isWebViewUA = userAgent.includes('wv') || 
                       userAgent.includes('WebView') ||
                       (window.navigator.standalone === false) ||
                       (window.matchMedia && window.matchMedia('(display-mode: standalone)').matches === false);
    
    return isAndroidWebView || isIOSWebView || isWebViewUA;
  }

  // Hide social login buttons if in webview
  if (isWebView()) {
    googleBtn.style.display = 'none';
    appleBtn.style.display = 'none';
  }

  sendOtpButton.addEventListener("click", async function () {
    const email = emailInput.value.trim();
    errorMessage.textContent = "";

    if (!email) {
      errorMessage.textContent = "Please enter your email.";
      return;
    }

    try {
      const response = await fetch('send_otp.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ email }).toString()
      });
      const text = await response.text();

      try {
        const data = JSON.parse(text);
        if (data.success) {
          otpContainer.style.display = "block";
          sendOtpButton.style.display = "none";
          signUpButton.style.display = "block";
          errorMessage.textContent = "Verification Code sent successfully!";
          errorMessage.style.color = "#4CBB17";
          console.log(text);
        } else {
          errorMessage.textContent = data.message || "Failed to send Verification Code.";
        }
      } catch (e) {
        console.error("Invalid JSON:", text);
        errorMessage.textContent = "Server error. Check console.";
      }
    } catch (err) {
      console.error("Fetch Error:", err);
      errorMessage.textContent = "Error sending Verification Code.";
    }
  });

  signupForm.addEventListener("submit", async function (event) {
    event.preventDefault();
    const email = emailInput.value.trim();
    const otp = otpInput.value.trim();
    errorMessage.textContent = "";

    if (!email || !otp) {
      errorMessage.textContent = "Please enter both email and Verification Code.";
      return;
    }

    try {
      const response = await fetch('verify_otp.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ email, otp }).toString()
      });
      const data = await response.json();

      if (data.success) {
        window.location.href = `SignUp2.php?email=${encodeURIComponent(email)}`;
      } else {
        errorMessage.textContent = data.message || "Invalid Verification Code.";
      }
    } catch (err) {
      console.error(err);
      errorMessage.textContent = "Error verifying code.";
    }
  });
</script>


</body>
</html>
