<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Phone Verification - FoodnPals</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0; 
      padding: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
      background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .verification-container {
      background: #fff;
      width: 100%;
      max-width: 500px;
      border-radius: 20px;
      box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
      overflow: hidden;
      position: relative;
    }

    .header {
      background: linear-gradient(135deg, #4CBB17 0%, #3aa911 100%);
      padding: 40px 30px;
      text-align: center;
      color: white;
      position: relative;
    }

    .header::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="20" cy="80" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
      opacity: 0.3;
    }

    .logo {
      width: 160px;
      height: auto;
      margin-bottom: 20px;
      position: relative;
      z-index: 1;
    }

    .header h1 {
      font-size: 28px;
      font-weight: 700;
      margin-bottom: 8px;
      position: relative;
      z-index: 1;
    }

    .header p {
      font-size: 16px;
      opacity: 0.9;
      position: relative;
      z-index: 1;
    }

    .content {
      padding: 40px 30px;
    }

    .step-indicator {
      display: flex;
      justify-content: center;
      margin-bottom: 30px;
      gap: 10px;
    }

    .step {
      width: 12px;
      height: 12px;
      border-radius: 50%;
      background: #e9ecef;
      transition: all 0.3s ease;
    }

    .step.active {
      background: #4CBB17;
      transform: scale(1.2);
    }

    .step.completed {
      background: #4CBB17;
    }

    h3 {
      color: #333;
      text-align: center;
      margin-bottom: 25px;
      font-size: 24px;
      font-weight: 600;
    }

    .form-group {
      margin-bottom: 25px;
    }

    label {
      display: block;
      color: #555;
      font-weight: 500;
      margin-bottom: 8px;
      font-size: 14px;
    }

    input[type="text"] {
      width: 100%;
      padding: 16px 20px;
      border: 2px solid #e9ecef;
      border-radius: 12px;
      font-size: 16px;
      outline: none;
      transition: all 0.3s ease;
      background: #f8f9fa;
    }

    input[type="text"]:focus {
      border-color: #4CBB17;
      background: #fff;
      box-shadow: 0 0 0 3px rgba(76, 187, 23, 0.1);
    }

    button {
      width: 100%;
      background: linear-gradient(135deg, #4CBB17 0%, #3aa911 100%);
      color: #fff;
      font-weight: 600;
      font-size: 16px;
      padding: 16px;
      border: none;
      border-radius: 12px;
      cursor: pointer;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
    }

    button::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
      transition: left 0.5s;
    }

    button:hover::before {
      left: 100%;
    }

    button:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 20px rgba(76, 187, 23, 0.3);
    }

    button:disabled {
      background: linear-gradient(135deg, #ccc 0%, #bbb 100%);
      cursor: not-allowed;
      transform: none;
      box-shadow: none;
    }

    button:disabled::before {
      display: none;
    }

    .secondary-btn {
      background: linear-gradient(135deg, #6c757d 0%, #5a6268 100%);
      margin-top: 15px;
    }

    .secondary-btn:hover {
      box-shadow: 0 10px 20px rgba(108, 117, 125, 0.3);
    }

    .consent-section {
      background: #f8f9fa;
      padding: 20px;
      border-radius: 12px;
      margin: 20px 0;
      border-left: 4px solid #4CBB17;
    }

    .consent-section p {
      font-size: 13px;
      color: #666;
      margin-bottom: 8px;
      line-height: 1.5;
    }

    .consent-section a {
      color: #4CBB17;
      text-decoration: none;
      font-weight: 500;
    }

    .consent-section a:hover {
      text-decoration: underline;
    }

    .checkbox-container {
      display: flex;
      align-items: flex-start;
      gap: 12px;
      margin-top: 15px;
    }

    .checkbox-container input[type="checkbox"] {
      width: auto;
      margin: 0;
      transform: scale(1.2);
      accent-color: #4CBB17;
    }

    .checkbox-container label {
      margin: 0;
      font-size: 13px;
      line-height: 1.4;
    }

    .hidden {
      display: none;
    }

    .success-message {
      background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
      color: #155724;
      padding: 20px;
      border-radius: 12px;
      margin: 20px 0;
      text-align: center;
      border-left: 4px solid #4CBB17;
      font-weight: 500;
    }

    .error-message {
      background: linear-gradient(135deg, #f8d7da 0%, #f1aeb5 100%);
      color: #721c24;
      padding: 20px;
      border-radius: 12px;
      margin: 20px 0;
      text-align: center;
      border-left: 4px solid #dc3545;
      font-weight: 500;
    }

    .phone-display {
      background: #4CBB17;
      color: white;
      padding: 8px 16px;
      border-radius: 20px;
      font-weight: 600;
      display: inline-block;
    }

    .otp-description {
      text-align: center;
      color: #666;
      margin: 20px 0;
      line-height: 1.6;
    }

    .success-icon {
      width: 80px;
      height: 80px;
      background: #4CBB17;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 20px;
      color: white;
      font-size: 36px;
    }

    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .step-content {
      animation: slideIn 0.4s ease-out;
    }

    /* Mobile Responsiveness */
    @media (max-width: 600px) {
      body {
        padding: 10px;
      }

      .verification-container {
        border-radius: 12px;
      }

      .header {
        padding: 30px 20px;
      }

      .header h1 {
        font-size: 24px;
      }

      .content {
        padding: 30px 20px;
      }

      .logo {
        width: 140px;
      }

      h3 {
        font-size: 20px;
      }

      input[type="text"] {
        padding: 14px 16px;
        font-size: 16px;
      }

      button {
        padding: 14px;
      }
    }

    @media (max-width: 400px) {
      .header {
        padding: 25px 15px;
      }

      .content {
        padding: 25px 15px;
      }

      .logo {
        width: 120px;
      }
    }
  </style>
</head>
<body>

<div class="verification-container">
  <div class="header">
    <img src="Resources/logo.png" style="border-radius:5px;" alt="FoodnPals Logo" class="logo">
    <h1>Phone Verification</h1>
    <p>Secure your account with SMS verification</p>
  </div>

  <div class="content">
    <div class="step-indicator">
      <div class="step active" id="step1"></div>
      <div class="step" id="step2"></div>
      <div class="step" id="step3"></div>
    </div>

    <!-- Phone Number Step -->
    <div id="phoneStep" class="step-content">
      <h3>Enter Your Phone Number</h3>
      <form id="otpForm">
        <div class="form-group">
          <label for="phoneInput">Phone Number</label>
          <input type="text" id="phoneInput" name="phone" placeholder="Enter phone (e.g. +1234567890)" required>
        </div>

        <div class="consent-section">
          <p><strong>SMS Verification Service</strong></p>
          <p>By continuing, you agree to receive a one-time SMS for verification purposes.</p>
          <p><strong>Service:</strong> Account sign-up verification</p>
          <p><strong>Fee Disclosure:</strong> Message and data rates may apply.</p>
          <p><strong>Frequency:</strong> One message per request.</p>
          <p><strong>Help:</strong> Reply "HELP" for help, "STOP" to cancel.</p>
          <p>
            <a href="Terms.php" target="_blank">Terms of Service</a> |
            <a href="PrivacyPolicy.php" target="_blank">Privacy Policy</a>
          </p>
          <div class="checkbox-container">
            <input type="checkbox" id="consentCheckbox" required>
            <label for="consentCheckbox">I consent to receive an OTP via SMS for verification purposes.</label>
          </div>
        </div>

        <button type="submit" id="sendOtpBtn">Send Verification Code</button>
        <button type="button" onclick="window.location.href='logout.php'" class="secondary-btn">Logout</button>
      </form>
    </div>

    <!-- OTP Verification Step -->
    <div id="otpStep" class="step-content hidden">
      <h3>Enter Verification Code</h3>
      <div class="otp-description">
        <p>We sent a 6-digit verification code to</p>
        <div class="phone-display" id="phoneDisplay"></div>
        <p style="margin-top: 10px;">Enter the code below to verify your phone number</p>
      </div>
      <form id="verifyForm">
        <div class="form-group">
          <label for="otpInput">Verification Code</label>
          <input type="text" id="otpInput" name="otp" placeholder="Enter 6-digit code" maxlength="6" required>
        </div>
        <button type="submit" id="verifyBtn">Verify Code</button>
        <button type="button" id="backBtn" class="secondary-btn">Back to Phone Number</button>
      </form>
    </div>

    <!-- Success Step -->
    <div id="successStep" class="step-content hidden">
      <div class="success-icon">✓</div>
      <h3>Verification Complete!</h3>
      <div class="success-message">
        🎉 Your phone number has been successfully verified! Your account is now secured.
      </div>
      <button type="button" onclick="window.location.href='Home.php'" style="margin-top: 20px;">
        Continue to FoodnPals
      </button>
    </div>

    <!-- Message Area -->
    <div id="messageArea"></div>
  </div>
</div>

<script>
let currentPhone = '';
let currentStep = 1;

// Update step indicator
function updateStepIndicator(step) {
  for (let i = 1; i <= 3; i++) {
    const stepEl = document.getElementById(`step${i}`);
    stepEl.classList.remove('active', 'completed');
    if (i < step) {
      stepEl.classList.add('completed');
    } else if (i === step) {
      stepEl.classList.add('active');
    }
  }
  currentStep = step;
}

// Phone number submission
document.getElementById("otpForm").addEventListener("submit", function(e) {
  e.preventDefault();
  
  const phone = document.getElementById('phoneInput').value.trim();
  const sendBtn = document.getElementById('sendOtpBtn');
  
  if (!phone.startsWith("+")) {
    showMessage("Phone number must include + and country code (e.g. +1234567890)", 'error');
    return;
  }

  sendBtn.disabled = true;
  sendBtn.innerHTML = 'Sending Code...';
  clearMessage();

  fetch("vsend_otp.php", {
    method: "POST",
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: `phone=${encodeURIComponent(phone)}`
  })
  .then(async res => {
    const text = await res.text();
    console.log('Raw response:', text);
    
    try {
      return JSON.parse(text);
    } catch (e) {
      throw new Error(`Invalid JSON response: ${text.substring(0, 200)}`);
    }
  })
  .then(data => {
    console.log('Parsed data:', data);
    if (data.success) {
      currentPhone = phone;
      document.getElementById('phoneDisplay').textContent = phone;
      showOtpStep();
      showMessage("Verification code sent successfully!", 'success');
    } else {
      showMessage("Error: " + data.message, 'error');
    }
  })
  .catch(err => {
    console.error("Request failed:", err);
    showMessage("Error sending verification code: " + err.message, 'error');
  })
  .finally(() => {
    sendBtn.disabled = false;
    sendBtn.innerHTML = 'Send Verification Code';
  });
});

// OTP verification
document.getElementById("verifyForm").addEventListener("submit", function(e) {
  e.preventDefault();
  
  const otp = document.getElementById('otpInput').value.trim();
  const verifyBtn = document.getElementById('verifyBtn');
  
  if (!otp || otp.length !== 6) {
    showMessage("Please enter a 6-digit verification code", 'error');
    return;
  }

  verifyBtn.disabled = true;
  verifyBtn.innerHTML = 'Verifying...';
  clearMessage();

  fetch("verify.php", {
    method: "POST",
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: `phone=${encodeURIComponent(currentPhone)}&otp=${encodeURIComponent(otp)}`
  })
  .then(async res => {
    const text = await res.text();
    console.log('Verify response:', text);
    
    try {
      return JSON.parse(text);
    } catch (e) {
      return { success: text.includes('successfully'), message: text };
    }
  })
  .then(data => {
    if (data.success) {
      showSuccessStep();
    } else {
      showMessage("Error: " + data.message, 'error');
    }
  })
  .catch(err => {
    console.error("Verification failed:", err);
    showMessage("Error verifying code: " + err.message, 'error');
  })
  .finally(() => {
    verifyBtn.disabled = false;
    verifyBtn.innerHTML = 'Verify Code';
  });
});

// Back button
document.getElementById("backBtn").addEventListener("click", function() {
  showPhoneStep();
  clearMessage();
});

// Helper functions
function showPhoneStep() {
  document.getElementById('phoneStep').classList.remove('hidden');
  document.getElementById('otpStep').classList.add('hidden');
  document.getElementById('successStep').classList.add('hidden');
  updateStepIndicator(1);
}

function showOtpStep() {
  document.getElementById('phoneStep').classList.add('hidden');
  document.getElementById('otpStep').classList.remove('hidden');
  document.getElementById('successStep').classList.add('hidden');
  updateStepIndicator(2);
  setTimeout(() => {
    document.getElementById('otpInput').focus();
  }, 300);
}

function showSuccessStep() {
  document.getElementById('phoneStep').classList.add('hidden');
  document.getElementById('otpStep').classList.add('hidden');
  document.getElementById('successStep').classList.remove('hidden');
  updateStepIndicator(3);
}

function showMessage(message, type) {
  const messageArea = document.getElementById('messageArea');
  messageArea.innerHTML = `<div class="${type}-message">${message}</div>`;
}

function clearMessage() {
  document.getElementById('messageArea').innerHTML = '';
}

// Auto-focus and formatting for OTP input
document.getElementById('otpInput').addEventListener('input', function(e) {
  // Only allow numbers
  this.value = this.value.replace(/[^0-9]/g, '');
});

// Auto-format phone number input
document.getElementById('phoneInput').addEventListener('input', function(e) {
  let value = this.value;
  // Remove any non-digit characters except +
  value = value.replace(/[^\d+]/g, '');
  // Ensure + is only at the beginning
  if (value.indexOf('+') > 0) {
    value = '+' + value.replace(/\+/g, '');
  }
  this.value = value;
});
</script>

</body>
</html>