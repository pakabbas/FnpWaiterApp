<?php
include 'creds.php';

$planID = isset($_GET['PlanID']) ? (int)$_GET['PlanID'] : 0;
$restaurantIDParam = isset($_GET['RestaurantID']) ? (int)$_GET['RestaurantID'] : 0;
$plan = null;

if ($planID > 0) {
    $stmt = $conn->prepare("SELECT * FROM Plans WHERE PlanID = ?");
    $stmt->bind_param("i", $planID);
    $stmt->execute();
    $result = $stmt->get_result();
    $plan = $result->fetch_assoc();
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

  <?php include 'fetch_cookies.php' ?>
  <?php include 'fetch_active_reservation.php' ?>
  <script src="https://js.stripe.com/v3/"></script>
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
      background: #fff;
      border-radius: 8px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
      padding: 30px;
      max-width: 500px;
      margin: 50px auto;
    }

    .payment-form h2 {
      font-weight: bold;
      margin-bottom: 20px;
    }

    .plan-detail {
      font-size: 16px;
      margin-bottom: 10px;
    }

    .pay-button {
      background-color: #4CBB17;
      color: white;
      border: none;
      padding: 12px 20px;
      font-size: 16px;
      border-radius: 4px;
      width: 100%;
    }

    .pay-button:hover {
      background-color: #3aa212;
    }
  </style>


  <style>
   

    .payment-container {
      max-width: 600px;
      margin: 60px auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 12px rgba(0, 0, 0, 0.05);
    }

    .payment-container h2 {
      margin-bottom: 30px;
      text-align: center;
      color: #343a40;
    }

    .label-row {
      display: flex;
      justify-content: space-between;
      padding: 10px 0;
      border-bottom: 1px solid #e9ecef;
    }

    .label-row:last-child {
      border-bottom: none;
    }

    .label-row label {
      font-weight: 500;
      margin: 0;
      color: #495057;
    }

    .label-row span {
      font-weight: 600;
      color: #212529;
    }

    .pay-button {
      width: 100%;
      padding: 14px;
      font-size: 16px;
      background-color: #4CBB17;
      color: white;
      border: none;
      border-radius: 6px;
      margin-top: 30px;
    }

    .pay-button:hover {
      background-color: #3ca113;
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
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      font-size: 14px;
      color: #666;
      margin-bottom: 5px;
    }

    .form-group input {
      width: 100%;
      padding: 10px;
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
      padding: 10px;
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
      margin-bottom: 5px;
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
        padding: 15px;
      }
    }
  </style>




</head>

<body style="margin:0px; padding:0px;">

  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <!-- Header -->
  <div class="container-fluid p-3 d-flex justify-content-between align-items-center header1">
     <a href="Home.php">
      <img src="Resources/logo.png" alt="Location" class="img-fluid" style="width: 160px;">
    </a>
    <?php
    $userID = isset($_COOKIE['UserID']) ? $_COOKIE['UserID'] : null;
    if ($userID): ?>
     <div class="d-flex align-items-center">
  <a href="#" class="dropdown-toggle" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration: none; display: flex; align-items: center; color: inherit;">
    <i class="fas fa-user-circle" style="font-size: 36px; color: #4cbb17;"></i>
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
          <a href="Login.html" class="header-btn login-btn" style="background:rgb(218, 217, 217);">
            <span class="btn-text">Login</span>
            <img src="Resources/si_sign-in-fill.svg" alt="Sign In" class="mobile-icon" />
          </a>
          
          <a href="SignUp.php" class="header-btn signup-btn">
            <span class="btn-text">Sign Up</span>
            <i class="fas fa-user-plus mobile-icon"></i>
          </a>
        </div>

    <?php endif; ?>
  </div>


<section class="pricing-section container">
    <div class="row">

    <div class="col-md-6 mb-4">
      <br>
      <br>
            <div class="pricing-card">
            <h3 class="pricing-title">Join Us Now and Transform Your Business Potential</h3>
                <p class="pricing-price">Become part of our community and gain valuable strategies for growth and success. Together, we can turn your goals into reality and elevate your business to new heights.</p>
           
              <img style="width:100%;" src="Resources/par4.png" />
            </div>
        </div>
       
       
       
        <div  class="col-md-6 mb-4">
     <?php if ($plan): ?>


       <div class="payment-container">
    <h2>Complete Your Payment</h2>

    <?php if ($plan): ?>
      <div class="label-row">
        <label>Plan Name</label>
        <span><?= htmlspecialchars($plan['PlanName']) ?></span>
      </div>
    
    
      <div class="label-row">
        <label>Payment Type</label>
        <span><?= empty($plan['BillingCycle']) || $plan['BillingCycle'] === 'one-time' ? 'One-time Payment' : ucfirst($plan['BillingCycle']) . ' Subscription' ?></span>
      </div>
      <div class="label-row">
        <label>Amount</label>
        <span>$<?= $plan['Amount'] ?><?= empty($plan['BillingCycle']) || $plan['BillingCycle'] === 'one-time' ? '' : '/' . strtolower($plan['BillingCycle']) ?></span>
      </div>
      <div class="label-row">
        <label>Details</label>
        <span><?= nl2br(htmlspecialchars($plan['Details'])) ?></span>
      </div>

      <input  id="RestaurantID" value="<?= $restaurantIDParam ?>">
      <input  id="PlanID" value="<?= $plan['PlanID'] ?>">
      <input  id="StripePriceID" value="<?= $plan['StripePriceID'] ?>">

      <button id="pay-now-btn" class="pay-button">Pay Now</button>
    <?php else: ?>
      <div class="alert alert-danger text-center">
        Invalid Plan ID.

      </div>
    <?php endif; ?>
  </div>

  <script>
    const stripe = Stripe("pk_test_51RSL48QQYpP9NcW7p8x1GwTt41Xx06ERmQQ5IbhpcFyXXXQWmsczYqw8w0WeUvxqyv7IDL1ibTTISq2yPyFkwAuw00IybgJukG");

    document.getElementById('pay-now-btn')?.addEventListener('click', () => {
      const restaurantID = document.getElementById('RestaurantID').value;
      const planID = document.getElementById('PlanID').value;

      fetch(`create-checkout-session.php?RestaurantID=${restaurantID}&PlanID=${planID}`)
        .then(res => res.json())
        .then(data => {
          if (data.error) {
            alert('Error:: ' + data.error);
            return;
          }
          window.location.href = data.url;
        })
        .catch(err => alert('Fetch error: ' + err.message));
    });
  </script>
<!-- <form class="payment-form" method="GET" action="create-checkout-session.php">
  <h2>Plan: <?= htmlspecialchars($plan['PlanName']) ?></h2>

  <div class="form-group">
    <label>Plan Name</label>
    <input type="text" name="PlanName" class="form-control" value="<?= htmlspecialchars($plan['PlanName']) ?>" readonly>
  </div>

  <input type="hidden" name="MaxTables" value="<?= $plan['MaxTables'] ?>">
  <input type="hidden" name="MaxUsers" value="<?= $plan['MaxUsers'] ?>">
  <input type="hidden" name="WaiterApp" value="<?= $plan['WaiterApp'] ? 'Included' : 'Not Included' ?>">
  <input type="hidden" name="POSIntegration" value="<?= $plan['POSIntegration'] ? 'Included' : 'Not Included' ?>">
  <input type="hidden" name="BillingCycle" value="<?= ucfirst($plan['BillingCycle']) ?>">
  <input type="hidden" name="RestaurantID" value="6">
  <input type="hidden" name="PlanID" value="<?= $plan['PlanID'] ?>">
  <input type="hidden" name="StripePriceID" value="<?= $plan['StripePriceID'] ?>">

  <div class="form-group">
    <label>Amount</label>
    <input type="text" name="Amount" class="form-control" value="$<?= $plan['Amount'] ?>" readonly>
  </div>

  <div class="form-group">
    <label>Details</label>
    <textarea name="Details" class="form-control" rows="3" readonly><?= htmlspecialchars($plan['Details']) ?></textarea>
  </div>

  <button type="submit" class="pay-button">Proceed to Checkout</button>
</form> -->

<?php else: ?>
  <div class="text-center mt-5">
    <h4>Invalid Plan Selected.</h4>
    <a href="Home.php" class="btn btn-secondary mt-3">Go Back</a>
  </div>
<?php endif; ?>
        </div>
       
    
    </div>
</section>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


 
<?php include 'footer.php'; ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDP9cy_r8w6t7O0Wct3KmP0rPI0ISVQqks&libraries=places"></script>
<script>
   function scroll1 () {
        document.getElementById('plans').scrollIntoView({ behavior: 'smooth' });
    }
</script>

</html>