
<?php
include 'creds.php';
require 'vendor/autoload.php';

// Handle AJAX requests for email verification
if (isset($_POST['action'])) {
    header('Content-Type: application/json');
    
    if ($_POST['action'] === 'send_otp') {
        $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
        if (!$email) {
            echo json_encode(['success' => false, 'message' => 'Invalid email address']);
            exit;
        }

        // Generate 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store OTP in session
        session_start();
        $_SESSION['email_otp'] = [
            'code' => $otp,
            'email' => $email,
            'expires' => time() + 600 // 10 minutes expiry
        ];

        // Send OTP via PHPMailer
        try {
            $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'no-reply@foodnpals.com';
            $mail->Password = 'pfjkabctjbsicmrm';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('no-reply@foodnpals.com', 'FoodnPals');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Verify Your Email - FoodnPals Restaurant Registration';
            $mail->Body = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                    <h2 style='color: #4CBB17;'>Email Verification</h2>
                    <p>Hello,</p>
                    <p>Your verification code for FoodnPals restaurant registration is:</p>
                    <h1 style='color: #4CBB17; font-size: 32px; letter-spacing: 3px;'>{$otp}</h1>
                    <p>This code will expire in 10 minutes.</p>
                    <p>If you didn't request this code, please ignore this email.</p>
                    <br>
                    <p>Best regards,<br>FoodnPals Team</p>
                </div>";
            $mail->AltBody = "Your verification code is: {$otp}\nValid for 10 minutes.";
            
            $mail->send();
            echo json_encode(['success' => true, 'message' => 'Verification code sent successfully']);
        } catch (Exception $e) {
            error_log("Failed to send OTP: " . $e->getMessage());
            echo json_encode(['success' => false, 'message' => 'Failed to send Verification code']);
        }
        exit;
    }

    if ($_POST['action'] === 'verify_otp') {
        session_start();
        $submitted_otp = $_POST['otp'] ?? '';
        $email = $_POST['email'] ?? '';
        
        if (
            isset($_SESSION['email_otp']) &&
            $_SESSION['email_otp']['code'] === $submitted_otp &&
            $_SESSION['email_otp']['email'] === $email &&
            $_SESSION['email_otp']['expires'] > time()
        ) {
            // OTP verified successfully
            $_SESSION['email_verified'] = $email;
            echo json_encode(['success' => true, 'message' => 'Email verified successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid or expired OTP']);
        }
        exit;
    }
}

$planId = isset($_GET['PlanID']) ? (int)$_GET['PlanID'] : 0;
$selectedPlan = null;
if ($planId > 0 && isset($conn)) {
    $stmt = $conn->prepare("SELECT PlanID, PlanName FROM Plans WHERE PlanID = ?");
    $stmt->bind_param("i", $planId);
    $stmt->execute();
    $result = $stmt->get_result();
    $selectedPlan = $result->fetch_assoc();
    $stmt->close();
}
?>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FoodnPals - Payment</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/banner.css">
  <link rel="stylesheet" href="assets/css/Explore.css">
  <link rel="stylesheet" href="assets/css/footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon.png">
  
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <?php include 'fetch_cookies.php' ?>
  <?php include 'fetch_active_reservation.php' ?>

  <style>
.banner {
    width: 100%; /* Full width */
    height: 70vh; /* Adjusted height */
    position: relative; /* Positioning for internal content */
    overflow: hidden; /* Ensures no content spills out */
    display: flex;
    flex-direction: column;
    color: white;
    background: black; /* Optional for fallback background color */
    background-image: url('Resources/par3.png');
}

.banner img {
    width: 100%; /* Full width of the container */
    height: 100%; /* Full height of the container */
    object-fit: contain; /* Ensure the entire image is visible */
    object-position: center; /* Centers the image in the div */
}



    .row::-webkit-scrollbar {
      display: none;
    }
  </style>


<style>
   

    .payment-form {
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
      padding: 20px;
      box-sizing: border-box;
    }

    .payment-form h2 {
      font-size: 20px;
      color: #333;
      margin-bottom: 20px;
    }

    .form-group {
      margin-bottom: 5px;
    }

    .form-group label {
      display: block;
      font-size: 14px;
      color: #666;
      margin-bottom: 0px;
    }

    .form-group input {
      width: 100%;
      /* padding: 10px; */
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    .payment-options {
      margin: 20px 0;
    }

    .payment-options label {
      display: flex;
      align-items: center;
      /* padding: 10px; */
      border: 1px solid #ccc;
      border-radius: 4px;
      margin-bottom: 10px;
      cursor: pointer;
    }

    .payment-options input[type="radio"] {
      margin-right: 10px;
    }

    .payment-options label.selected {
      border-color: #4CBB17;
      background-color: #f0fdf4;
    }

    .totals {
      text-align: right;
      margin-top: 20px;
    }

    .totals div {
      font-size: 16px;
      /* margin-bottom: 5px; */
    }

    .totals .total {
      font-weight: bold;
      font-size: 18px;
      color: #333;
    }

    .pay-button {
      display: block;
      width: 100%;
      padding: 12px;
      font-size: 16px;
      color: #fff;
      background-color: #4CBB17;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      text-align: center;
    }

    .pay-button:hover {
      background-color: #218838;
    }

    @media (max-width: 480px) {
      .payment-form {
        /* padding: 15px; */
      }
    }
  </style>




</head>

<body style="margin:0px; padding:0px;">
  <?php if (isset($isReservationActive) && $isReservationActive == "Yes"): ?>
    <div class="floating-banner" id="active-booking-banner">
      <div class="banner-header">Booking in progress...</div>
      <div class="banner-content d-flex align-items-center">
        <img src="Resources/<?php echo $restaurantIcon; ?>" alt="Restaurant Icon" class="restaurant-icon">
        <div class="restaurant-details ml-3">
          <div class="restaurant-name"><?php echo $restaurantName; ?></div>
          <div class="reservation-time"><?php echo $reservationTime; ?></div>
        </div>
      </div>
    </div>
  <?php endif; ?>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <!-- Header -->
  <div class="container-fluid p-3 d-flex justify-content-between align-items-center">
     <a href="Home.php">
      <img src="Resources/logo.png" alt="Location" class="img-fluid" style="width: 160px;">
    </a>
    <?php
    $userID = isset($_COOKIE['UserID']) ? $_COOKIE['UserID'] : null;
    if ($userID): ?>
     <div class="d-flex align-items-center">
  <a href="#" class="dropdown-toggle" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration: none; display: flex; align-items: center; color: inherit;">
   <img src="AppUsers/uploads/<?php echo $profilePictureURL; ?>" alt="Profile" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">

    <p style="font-size: 20px; color: #4cbb17;"></p>
  </a>
  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
    <a class="dropdown-item" href="CustomerProfile.php">Profile</a>
    <a class="dropdown-item" href="CustomerBookings.php">Bookings </a>
    <a class="dropdown-item" href="CustomerReviews.php">Reviews </a>
    <a class="dropdown-item" href="logout.php">Logout </a>
  
  </div>
</div>
    <?php else: ?>
        <div class="header-buttons">
<div class="dropdown" style="position: relative; display: inline-block;">
  <button class="header-btn login-btn" style="background:rgb(218, 217, 217); border: none; cursor: pointer;">
    <span class="btn-text">Login</span>
    <img src="Resources/si_sign-in-fill.svg" alt="Sign In" class="mobile-icon" />
  </button>
  <div class="dropdown-content" style="
    display: none;
    position: absolute;
    background-color:rgb(255, 255, 255);
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    z-index: 1;
  ">
<a href="Login.html" style="color: black; padding: 12px 16px; text-decoration: none; display: block;">
  <i  style="color:#4cbb17;" class="fas fa-user"></i> User Login
</a> 
<a href="./admin/index.php" style="color: black; padding: 12px 16px; text-decoration: none; display: block;">
  <i style="color:#4cbb17;" class="fas fa-store"></i> Partner Login
</a>

  </div>
</div>

<script>
  const dropdown = document.querySelector('.dropdown');
  const content = dropdown.querySelector('.dropdown-content');

  dropdown.addEventListener('mouseenter', () => {
    content.style.display = 'block';
  });

  dropdown.addEventListener('mouseleave', () => {
    content.style.display = 'none';
  });
</script>

          
          <a href="SignUp.php" class="header-btn signup-btn">
            <span class="btn-text">Sign Up</span>
            <i class="fas fa-user-plus mobile-icon"></i>
          </a>
        </div>

    <?php endif; ?>
  </div>

  <!-- Banner -->



       
       
       
        
      <style>
    .restaurant-form {
        margin-left: 30px;
        display: grid;
        gap: 20px;
    }

    @media (min-width: 768px) {
        .restaurant-form {
            grid-template-columns: 1fr 1fr; /* Two columns on larger screens */
        }
    }

    @media (max-width: 767px) {
        .restaurant-form {
            grid-template-columns: 1fr; /* Single column on smaller screens */
        }
    }

    .form-group {
        display: flex;
        flex-direction: column;
        margin-bottom: 0rem;
        
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .form-group label {
        margin-bottom: 5px;
        font-weight: bold;
    }

    .full-width {
        grid-column: span 2;
    }

    .pay-button {
        padding: 10px 20px;
        background-color: #4CBB17;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .pay-button:hover {
        background-color: #3aa814;
    }
</style>






        
       

<!-- BEGIN New Responsive Registration Card -->
<style>
    /* Restaurant Registration Styles */
    .register-card {
        max-width: 900px;
        margin: 0rem auto;
        padding: 1rem 3rem;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0,0,0,.1);
    }
    .register-card h2 {
        font-weight: 700;
        margin-bottom: 1.5rem;
        color: #333;
    }
    .btn-register {
        background:#4CBB17;
        color:#fff;
        font-weight:600;
    }
    .btn-register:hover {
        background:#3aa814;
        color:#fff;
    }
</style>

<div class="register-card">
    <h2 class="text-center">Restaurant Registration</h2>
    <form method="POST" action="signup_restaurant.php">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="Name" class="form-label">Restaurant Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="Name" name="Name" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="FirstName" class="form-label">Owner First Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="FirstName" name="FirstName" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="LastName" class="form-label">Owner Last Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="LastName" name="LastName" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="Email" class="form-label">Email <span class="text-danger">*</span></label>
                <div class="input-group">
                    <input type="email" class="form-control" id="Email" name="Email" required>
                    <div class="input-group-append">
                        <button type="button" class="btn" style="background-color: #4CBB17; color: white;" id="verifyEmailBtn">Verify Email</button>
                    </div>
                </div>
                <div id="otpSection" style="display: none; margin-top: 10px;">
                    <div class="input-group">
                        <input type="text" class="form-control" id="otpInput" placeholder="Enter 6-digit OTP" maxlength="6">
                        <div class="input-group-append">
                            <button type="button" class="btn" style="background-color: #4CBB17; color: white;" id="verifyOtpBtn">Verify</button>
                        </div>
                    </div>
                    <small class="text-muted">OTP sent to your email</small>
                </div>
                <input type="hidden" name="isEmailVerified" id="isEmailVerified" value="0">
            </div>
            <div class="col-md-6 mb-3">
                <label for="PhoneNumber" class="form-label">Phone Number <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="PhoneNumber" name="PhoneNumber" required>
            </div>
            
            <div class="col-md-6 mb-3">
                <label for="PlanName" class="form-label">Plan Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="PlanName" name="PlanName" value="<?= htmlspecialchars($selectedPlan['PlanName'] ?? '') ?>" readonly required>
            </div>
            
            <div class="col-md-6 mb-3">
                <label for="Password" class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" class="form-control" id="Password" name="Password" required>
            </div>
        </div>
        
        <input type="hidden" id="PlanID" name="PlanID" value="<?= isset($selectedPlan['PlanID']) ? (int)$selectedPlan['PlanID'] : '' ?>">
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-register px-5 py-2">Register</button>
        </div>
    </form>
</div>
<!-- END New Responsive Registration Card -->


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


 
  <footer class="footer">
    <div class="footer-content">
      <div class="footer-grid">
        <!-- Cities Section -->
        <div class="footer-section">
          <h3 class="footer-title">Our top cities</h3>
          <ul class="footer-links">
            <li><a href="#">Michighan</a></li>
            <li><a href="#">Los Angeles</a></li>
            <li><a href="#">New York City</a></li>
            <li><a href="#">Chicago</a></li>
            <li><a href="#">Miami</a></li>
          </ul>
        </div>

        <!-- Company Section -->
        <div class="footer-section">
          <h3 class="footer-title">Company</h3>
          <ul class="footer-links">
            <li><a href="#">About us</a></li>
            <li><a href="#">Team</a></li>
            <li><a href="#">Careers</a></li>
            <li><a href="#">Blog</a></li>
          </ul>
        </div>

        <!-- Contact Section -->
        <div class="footer-section">
          <h3 class="footer-title">Contact</h3>
          <ul class="footer-links">
            <li><a href="#">Help & Support</a></li>
            <li><a href="#">Partner with us</a></li>
          </ul>
        </div>

        <!-- Legal Section -->
        <div class="footer-section">
          <h3 class="footer-title">Legal</h3>
          <ul class="footer-links">
            <li><a href="#">Terms & Conditions</a></li>
            <li><a href="#">Refund & Cancellation</a></li>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Cookie Policy</a></li>
          </ul>
        </div>

        <!-- Follow Us Section -->
        <div class="footer-section">
          <h3 class="footer-title">Follow Us</h3>
          <div class="social-links">
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
          </div>

          <div class="newsletter">
            <p class="newsletter-title">Receive exclusive offers in your mailbox</p>
            <form class="newsletter-form">
              <input type="email" class="newsletter-input" placeholder="Enter Your email">
              <button type="submit" class="newsletter-button">Subscribe</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

<script>
  // Smooth scroll helper
  function scroll1 () {
    const el = document.getElementById('plans');
    if (el) el.scrollIntoView({ behavior: 'smooth' });
  }

  // Email verification
  document.getElementById('verifyEmailBtn')?.addEventListener('click', async function() {
    const emailInput = document.getElementById('Email');
    const email = emailInput.value.trim();
    const verifyBtn = this;
    const otpSection = document.getElementById('otpSection');

    if (!email) {
        await Swal.fire({
            icon: 'warning',
            title: 'Required',
            text: 'Please enter your email address',
            confirmButtonColor: '#4CBB17'
        });
        return;
    }

    verifyBtn.disabled = true;
    verifyBtn.textContent = 'Sending...';

    try {
        const formData = new FormData();
        formData.append('action', 'send_otp');
        formData.append('email', email);

        const response = await fetch('RestaurantSignUp.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();
        if (data.success) {
            otpSection.style.display = 'block';
            await Swal.fire({
                icon: 'success',
                title: 'OTP Sent',
                text: 'Please check your email for the verification code',
                confirmButtonColor: '#4CBB17'
            });
            emailInput.readOnly = true;
        } else {
            await Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Failed to send OTP',
                confirmButtonColor: '#4CBB17'
            });
        }
    } catch (error) {
        await Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error sending OTP. Please try again.',
            confirmButtonColor: '#4CBB17'
        });
    } finally {
        verifyBtn.disabled = false;
        verifyBtn.textContent = 'Verify Email';
    }
  });

  document.getElementById('verifyOtpBtn')?.addEventListener('click', async function() {
    const email = document.getElementById('Email').value.trim();
    const otpInput = document.getElementById('otpInput');
    const otp = otpInput.value.trim();
    const verifyBtn = this;
    const isEmailVerified = document.getElementById('isEmailVerified');

    if (!otp) {
        await Swal.fire({
            icon: 'warning',
            title: 'Required',
            text: 'Please enter the OTP',
            confirmButtonColor: '#4CBB17'
        });
        return;
    }

    verifyBtn.disabled = true;
    verifyBtn.textContent = 'Verifying...';

    try {
        const formData = new FormData();
        formData.append('action', 'verify_otp');
        formData.append('email', email);
        formData.append('otp', otp);

        const response = await fetch('RestaurantSignUp.php', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();
        if (data.success) {
            await Swal.fire({
                icon: 'success',
                title: 'Verified!',
                text: 'Email verified successfully',
                confirmButtonColor: '#4CBB17'
            });
            document.getElementById('otpSection').style.display = 'none';
            document.getElementById('verifyEmailBtn').style.display = 'none';
            isEmailVerified.value = '1';
            
            // Show verified checkmark
            const emailGroup = document.getElementById('Email').parentElement;
            const checkmark = document.createElement('span');
            checkmark.innerHTML = ' ✓';
            checkmark.style.color = '#4CBB17';
            checkmark.style.fontSize = '20px';
            emailGroup.appendChild(checkmark);
        } else {
            await Swal.fire({
                icon: 'error',
                title: 'Invalid OTP',
                text: data.message || 'Please check the code and try again',
                confirmButtonColor: '#4CBB17'
            });
        }
    } catch (error) {
        await Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error verifying OTP. Please try again.',
            confirmButtonColor: '#4CBB17'
        });
    } finally {
        verifyBtn.disabled = false;
        verifyBtn.textContent = 'Verify OTP';
    }
  });

  // Prevent form submission if email not verified
  document.querySelector('form')?.addEventListener('submit', async function(e) {
    const isEmailVerified = document.getElementById('isEmailVerified').value === '1';
    if (!isEmailVerified) {
        e.preventDefault();
        await Swal.fire({
            icon: 'warning',
            title: 'Verification Required',
            text: 'Please verify your email address before proceeding',
            confirmButtonColor: '#4CBB17'
        });
    }
  });
</script>

</html>