
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FoodnPals</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <link rel="stylesheet" href="assets/css/Explore.css">
  <link rel="stylesheet" href="assets/css/footer.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon.png">

  <?php include 'fetch_cookies.php' ?>
  <?php include 'fetch_active_reservation.php' ?>

  <style>

.banner {
    width: 100%; /* Full width */
    height: 75vh; /* Adjusted height */
    position: relative; /* Positioning for internal content */
    overflow: hidden; /* Ensures no content spills out */
    display: flex;
    flex-direction: column;
    color: white;
    background: black; /* Optional for fallback background color */
    background-image: url('Resources/par7.png');
    background-size: cover; /* Stretches the image to cover the div */
    background-repeat: no-repeat; /* Prevents the image from repeating */
    background-position: center; /* Centers the image within the div */
}

    .row::-webkit-scrollbar {
      display: none;
    }
  </style>


<style>
       .why-section {
            padding: 50px 20px;
            background-color: #ffffff;
        }
        .why-section h2 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 40px;
        }
        .why-card {
            text-align: center;
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 20px;
            background-color: #fff;
            transition: transform 0.3s, box-shadow 0.3s;
            min-height:320px;
        }
        .why-card h5 {
            font-size: 16px;
        }
        .why-card p {
font-size:11px;
        }
        .why-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .why-card .icon {
            width: 50px;
            height: 50px;
            background-color: #4CBB17;
            color: white;
            font-size: 1.5rem;
            font-weight: bold;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 20px;
            border: 5px solid rgb(203, 228, 192); /* Red border with 5px thickness */
            border-radius: 50%; /* Optional: Makes it circular if it's a square element */
        }

        .faq-section {
            padding: 50px 20px;
            background-color: #ffffff;
        }
        .faq-section h2 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 40px;
        }
        .faq-item {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px 20px;
            background-color: #fff;
            margin-bottom: 15px;
            cursor: pointer;
            transition: box-shadow 0.3s;
        }
        .faq-item:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }
        .faq-item .question {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: bold;
        }
        .faq-item .description {
            display: none;
            margin-top: 10px;
            color: #555;
        }
        .faq-item.active .description {
            display: block;
        }
        .faq-item.active .icon {
            transform: rotate(45deg);
        }
        .faq-item .icon {
            font-size: 1.2rem;
            transition: transform 0.3s;
        }

        
  </style>


</head>

<body style="margin:0px; padding:0px;">

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>

  <!-- Header -->
  <?php include 'fetch_cookies.php' ?>
  <?php include 'fetch_restaurant.php' ?>

  <div class="container-fluid header-container" style="display: flex; justify-content: space-between; align-items: center; padding: 10px 15px; width: 100%;">
    <div class="logo-container" style="width: auto; display: flex; align-items: center;">
      <a href="Home.php" style="display: block;">
        <img src="Resources/logo.png" alt="Location" class="img-fluid" style="max-width: 160px; height: auto;">
      </a>
    </div>
    
    <?php
    $userID = isset($_COOKIE['UserID']) ? $_COOKIE['UserID'] : null;
    if ($userID): ?>
     <div class="profile-container" style="display: flex; align-items: center; margin-left: auto;">
     <?php  if ($isReservationActive === 'Yes' && $activeReservationRestaurant === $restaurant['RestaurantID']): ?>   
    
      <a href="#" onclick="$('#smallmodal').modal('show'); return false;" style="text-decoration: none; margin-right: 15px; position: relative;">
          <i class="fas fa-shopping-cart" style="font-size: 24px; color: #4CBB17;"></i>
          <span id="cartCount" style="position: absolute; top: -8px; right: -8px; background-color: #ff4757; color: white; border-radius: 50%; width: 18px; height: 18px; font-size: 11px; display: flex; align-items: center; justify-content: center; font-weight: bold;"></span>
        </a>
    
        <?php  endif; ?>      
      <a href="#" class="dropdown-toggle" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="text-decoration: none; display: flex; align-items: center; color: inherit;">
        <?php 
$profilePath = 'AppUsers/uploads/' . $profilePictureURL;
if (!empty($profilePictureURL) && file_exists($profilePath)) {
    echo '<img src="' . $profilePath . '" alt="Profile" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">';
} else {
    echo '<i class="fas fa-user-circle" style="font-size: 36px; color: #4CBB17;"></i>';
}
?>
        <p style="font-size: 20px; color: #4cbb17; margin: 0 0 0 5px;"></p>
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
        <a class="dropdown-item" href="CustomerProfile.php">Profile</a>
        <a class="dropdown-item" href="CustomerBookings.php">Bookings </a>
        <a class="dropdown-item" href="CustomerReviews.php">Reviews </a>
        <a class="dropdown-item" href="logout.php">Logout </a>
      </div>
    </div>
    <?php else: ?>
        <div class="header-buttons" style="margin-left: auto;">
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
   <!-- <h1 class="discover-title" style="font-size: 4rem; margin-bottom: 20px;">About Us</h1> -->
 
  <!-- <div class="banner" >
   
  
  </div>
<br><br> -->



<section class="pricing-section container">
  
    <div class="row container">
        <div class="col-md-12 mb-4">
            <div class="pricing-card">

                <div class="tab-content active" id="restaurants-tab">
                    <!-- <h4 class="pricing-title">For Restaurants</h4> -->
                                      <h4 class="pricing-title">FoodnPals Refund Policy for Restaurants</h4>
           
                    <!-- <h6>FoodnPals Terms and Conditions</h6> -->
                 <p class="pricing-price">
     <br>  You acknowledge that:

<br><br>(a) In the event that you inadvertently or mistakenly place a Booking, you have the right to a refund for a Booking placed within 24 hours. In case 24 hours have passed, you understand that no refunds (whether in whole or in part) will be issued to you, and you forfeit the delivery of your canceled Booking.

<br><br>(b) Your cancellation, or attempted or purported cancellation of a Booking or, cancellation due to reasons not attributable to FoodnPals, that is, in the event you provide incorrect particulars, contact number, etc., or that you were unresponsive, not reachable, or unavailable for fulfillment of the services offered to you shall amount to a breach of your unconditional and irrevocable authorization in favour of FoodnPals to place that Booking against the Merchant on your behalf (“Authorization Breach”).

<br><br>(c) If you commit an Authorization Breach, you shall be liable to pay the liquidated damages of an amount equivalent to the Booking value. You hereby authorize FoodnPals to deduct or collect the amount payable as liquidated damages through such means as FoodnPals may determine in its discretion, including, without limitation, by deducting such amount from any payment made towards your next Booking.

<br><br>(d) There may be cases where FoodnPals is either unable to accept your Booking or cancels the Booking, due to reasons including, without limitation, technical errors, unavailability of the item(s) ordered, or any other reason attributable to FoodnPals or Merchant. In such cases, FoodnPals shall not charge a cancellation fee from you. If the Booking is canceled after payment has been charged, and you are eligible for a refund of the Booking value or any part thereof, the said amount will be returned to you.

<br><br>(e) In the event that you have elected to enroll in automatic subscription, you retain the right to terminate said subscription, provided that such cancellation is effected no later than seven (7) calendar days preceding the scheduled auto-renewal date. This right of cancellation shall be exercised in accordance with the procedures set forth in these Terms or as otherwise designated by the FoodnPals.
  </p>

                   
                </div>

            </div>
        </div>
    </div>
</section>







<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>





  <br>
 
  <?php include 'footer.php'; ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script>
   function scroll1 () {
        document.getElementById('plans').scrollIntoView({ behavior: 'smooth' });
    }
</script>

</html>