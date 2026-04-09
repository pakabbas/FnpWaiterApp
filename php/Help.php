
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

       .tab-btn {
        cursor: pointer;
        padding: 10px 20px;
      
        border: none;
        background:rgb(213, 219, 210);
        font-size: 16px;
        color: #333;
        border-bottom: 2px solid transparent;
        transition: all 0.3s;
        margin-right: 10px;
        border-radius: 10px;

      }

    .tab-btn.active {
        background: #4CBB17;
         color: #fff;
        border-color: #4CBB17;
        font-weight: bold;
    }

    .tab-content {
        display: none;
    }

    .tab-content.active {
        display: block;
    }
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
  
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="pricing-card">

                <div class="mb-4">
                    <button class="tab-btn active" data-tab="customers-tab">For App Users</button>
                    <button class="tab-btn" data-tab="restaurants-tab">For Restaurants</button>
                </div>

                <!-- Customers Tab -->
                <div class="tab-content active" id="customers-tab">
                    <h4 class="pricing-title">HELP & SUPPORT FOR APP USERS</h4>
                    <br>


                    <h6>How does FoodnPals ensure a great dining experience?</h6>
                    <p class="pricing-price">
                        FoodnPals offers real-time table availability, instant confirmations, and diverse dining options for a seamless experience.
                    </p>

                    <h6>Do FoodnPals offer reservations for restaurants?</h6>
                    <p class="pricing-price">
                        No, FoodnPals does not offer reservations for restaurants. Instead, FoodnPals provides instant booking capabilities and mobile users can place the order via mobile app after the booking is confirmed by the restaurant.
                    </p>

                    <h6>Can I ask the restaurant to serve me alcohol?</h6>
                    <p class="pricing-price">
                        No. FoodnPals strictly prohibits the restaurants listed on its platform from serving alcohol or other age-restricted products. However, you can still enjoy a great selection of non-alcoholic beverages from our listed restaurants.
                    </p>

                    <br>
                    <h4 class="pricing-title">SUPPORT</h4>
                    <br>

                    <h6>I want to provide feedback</h6>
                    <p class="pricing-price">info@foodnpals.com</p>


                    <h6>Will FoodnPals be accountable for quantity/quality?</h6>
                    <p class="pricing-price">
                        Quantity and quality of the food is the Merchant’s responsibility. However, in case of issues with the quality or quantity, kindly submit your feedback, and we will pass it on to the Merchant.
                    </p>


                    <h6>What should I do if I encounter issues?</h6>
                    <p class="pricing-price">
                        Contact us at
                        <a href="mailto:support@foodnpals.com">support@foodnpals.com</a>
                        or
                        <a href="tel:+17345893503">+1 (734) 329-4804</a>
                        for immediate assistance with any issues. Our support team is available 24/7 to help you.
                    </p>
                </div>

                <!-- Restaurants Tab -->
                <div class="tab-content" id="restaurants-tab">
                    <!-- <h4 class="pricing-title">For Restaurants</h4> -->
                                      <h4 class="pricing-title">HELP & SUPPORT FOR RESTAURANTS</h4>
                    <br>

                    <h6>What is FoodnPals, and how does it help my restaurant?</h6>
                    <p class="pricing-price">
                        FoodnPals is a platform designed to streamline customers' dining experiences, and boost restaurant sales and productivity. FoodnPals allows mobile users to make table bookings from the mobile app and place orders before they walk into the restaurant.
                    </p>

                    <h6>How does FoodnPals ensure a great dining experience?</h6>
                    <p class="pricing-price">
                        FoodnPals offers real-time table availability, instant confirmations, and diverse dining options for a seamless experience.
                    </p>

                    <h6>Do FoodnPals offer reservations for restaurants?</h6>
                    <p class="pricing-price">
                        No, FoodnPals does not offer reservations for restaurants. Instead, FoodnPals provides instant booking capabilities and mobile users can place the order via mobile app after the booking is confirmed by the restaurant.
                    </p>


                    <br>
                    <h4 class="pricing-title">SUPPORT</h4>
                    <br>

                    <h6>I want to provide feedback</h6>
                    <p class="pricing-price">info@foodnpals.com</p>

                    <h6>I want to cancel my booking</h6>
                    <p class="pricing-price">
                        In case you have mistakenly placed a booking, you can cancel it within 24 hours along with a full refund. However, in case 24 hours have passed, no refund will be processed against your cancellation. For more information, refer to our Refund Policy.
                    </p>

                    <h6>Will FoodnPals be accountable for quantity/quality?</h6>
                    <p class="pricing-price">
                        Quantity and quality of the food is the Merchant’s responsibility. However, in case of issues with the quality or quantity, kindly submit your feedback, and we will pass it on to the Merchant.
                    </p>

                    <h6>Can I update my credit card information?</h6>
                    <p class="pricing-price">
                        You can update your credit card information any time in your FoodnPals account. If you would like to replace an existing card, you are required to first add a new card before removing the existing card. The last credit card used will remain the default credit card when placing your order.
                    </p>

                    <h6>What should I do if I encounter issues?</h6>
                    <p class="pricing-price">
                        Contact us at
                        <a href="mailto:restaurants.support@foodnpals.com">restaurants.support@foodnpals.com</a>
                        or
                        <a href="tel:+17345893503">+1 (734) 589-3503</a>
                        for immediate assistance with any issues. Our support team is available 24/7 to help you.
                    </p>
                </div>

            </div>
        </div>
    </div>
</section>

<script>
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            const target = btn.getAttribute('data-tab');

            // Remove active classes
            tabButtons.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));

            // Add active classes
            btn.classList.add('active');
            document.getElementById(target).classList.add('active');
        });
    });
</script>





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