
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FoodnPals</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/banner.css">
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

  <script src="assets/js/Explore.js"></script>

</head>

<body style="margin:0px; padding:0px;">
  <?php if (isset($isReservationActive) && $isReservationActive == "Yes"): ?>
    <div class="floating-banner" id="active-booking-banner">
      <div class="banner-header">Booking in progress...</div>
      <div class="banner-content d-flex align-items-center">
        <img src="Resources/<?php echo $restaurantIcon; ?>" alt="Restaurant Icon" class="restaurant-icon">
        <div class="restaurant-details ml-3">
          <div class="restaurant-name"><?php echo $restaurantName; ?></div>
        <div class="reservation-time">
    <?php echo date('F j, Y \a\t g:i A', $reservationTime); ?>
</div>


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
   <?php 
$profilePath = 'AppUsers/uploads/' . $profilePictureURL;
if (!empty($profilePictureURL) && file_exists($profilePath)) {
    echo '<img src="' . $profilePath . '" alt="Profile" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">';
} else {
    echo '<i class="fas fa-user-circle" style="font-size: 36px; color: #4CBB17;"></i>';
}
?>

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
   <!-- <h1 class="discover-title" style="font-size: 4rem; margin-bottom: 20px;">About Us</h1> -->
 
  <!-- <div class="banner" >
   
  
  </div>
<br><br> -->



<section class="pricing-section container">
    <div class="row">
        <div class="col-md-8 mb-4">
            <div class="pricing-card">
<br>
            <h3 class="pricing-title">About Us</h3>
                <p class="pricing-price">Founded in 2023 by a team of tech experts, FoodnPals was created with a bold vision to become the ultimate bridge between diners and restaurants, eliminating wait times and redefining the dining experience.

We understand that in today’s fast-paced world, time is precious. That’s why we’ve designed FoodnPals to make dining out seamless and stress-free for both customers and restaurants. Our platform connects diners with their favorite eateries, ensuring every meal is a delightful experience without the hassle of waiting.

</p>

<h4 class="pricing-title">What We Offer</h4>
                <p class="pricing-price">

Instant Table Booking: Secure your table in real time, even for last-minute plans, and skip the lines.

Pre-Order Meals: Place your order before you arrive, so your food is served fresh and ready when you are.

FoodnPals is more than just an app; it’s a movement to enhance the way people dine. By combining technology with convenience, we’re empowering restaurants to better manage their operations while giving customers the dining experience they deserve.

Join us on this journey to make dining out smarter, faster, and more enjoyable. 

With FoodnPals, your perfect meal is just a tap away!

</p>
               
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="pricing-card">
              <br>
              <img style="width:100%;" src="Resources/par5.png" />
            </div>
        </div>
    
    </div>
</section>




<section class="why-section container">
    <h2>Why FoodnPals</h2>
    <div class="row" >
        <div class="col-md-4 col-lg-2 offset-lg-1 mb-4">
            <div class="why-card">
                <div class="icon">1</div>
                <h5>Real-Time Availability</h5>
                <p>With our real-time booking system, customers can quickly find available tables at their favorite restaurants. Say goodbye to waiting and uncertainty—secure your spot instantly!
                </p>
            </div>
        </div>
        <div class="col-md-4 col-lg-2 mb-4">
            <div class="why-card">
                <div class="icon">2</div>
                <h5>Hassle-Free Bookings</h5>
                <p>FoodnPals is there for you to enjoy a seamless booking experience with our intuitive platform. Book your table in just a few taps, focus on what really matters and enjoy your meal with your family, friends and colleagues.

                </p>
            </div>
        </div>
        <div class="col-md-4 col-lg-2 mb-4">
            <div class="why-card">
                <div class="icon">3</div>
                <h5>Diverse Dining Options</h5>
                <p>Explore a wide range of restaurants, from trendy bistros to classic favorites. With FoodnPals, you can discover new culinary experiences that cater to every taste and occasion.

</p>
            </div>
        </div>
        <div class="col-md-4 col-lg-2 mb-4">
            <div class="why-card">
                <div class="icon">4</div>
                <h5>Instant Confirmation</h5>
                <p>Restaurants receive notifications immediately for the  confirmation of customer booking, so you can plan your dining experience with confidence and certainty.


              </p>
            </div>
        </div>
        <div class="col-md-4 col-lg-2 mb-4">
            <div class="why-card">
                <div class="icon">5</div>
                <h5>Order Placing  </h5>
                <p>The features makes FoodnPals unique is not just the real-time table booking but also while you are heading to the restaurant you can place the order from the app so by the time you step in to the restaurant your order was already placed.</p>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<br><br>

<div class="banner" style="  height: 70vh; background-image: url('Resources/par6.png');">
    <h1 class="discover-title" style="font-size: 2rem; margin-bottom: 20px;">Become Part of Our Vision</h1>
    <p> Join us in shaping the future. Together, we can create innovative solutions that make a real impact!</p>
  

    <button class="search-button ms-3" onclick="window.location.href='PartnerWithUs.php';">Join Us</button>


  
</div>

<br>

<section class="faq-section container">
    <h2>Frequently Asked Questions</h2>
    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="faq-item">
                <div class="question">
                    <span>What is FoodnPals, and how does it help my restaurant?</span>
                    <span class="icon">+</span>
                </div>
                <div class="description">
                FoodnPals is a platform designed to streamline customers' dining experiences, and boost restaurant sales and productivity. FoodnPals allows mobile users to make table bookings from the mobile app and place orders before they walk into the restaurant.
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="faq-item">
                <div class="question">
                    <span>How does FoodnPals ensure a great dining experience?</span>
                    <span class="icon">+</span>
                </div>
                <div class="description">
                FoodnPals offers real-time table availability, instant confirmations, and diverse dining options for a seamless experience. 
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="faq-item">
                <div class="question">
                    <span>Do FoodnPals offer reservations for restaurants?</span>
                    <span class="icon">+</span>
                </div>
                <div class="description">
                No, FoodnPals does not offer reservations for the restaurants. FoodnPals provides instant booking capabilities and mobile user can place the order via mobile app after the booking is confirmed by the restaurant
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="faq-item">
                <div class="question">
                    <span>What should I do if I encounter issues?</span>
                    <span class="icon">+</span>
                </div>
                <div class="description">
                Contact us at support@foodnpals.com for immediate assistance with any issues. Our support team is 24/7 available to help you
              </div>
             </div>
         </div>

                 <div class="col-md-6 mb-3">
            <div class="faq-item">
                <div class="question">
                    <span>Can I ask the restaurant to serve me alcohol?</span>
                    <span class="icon">+</span>
                </div>
                <div class="description">
            No. FoodnPals strictly prohibits the restaurants listed on its platform from serving alcohol or other age-restricted products. However, you can still enjoy a great selection of non-alcoholic beverages from our listed restaurants.

              </div>
             </div>
         </div>
        
         <div class="col-md-6 mb-3">
            <div class="faq-item">
                <div class="question">
                    <span>Does FoodnPals charge customers for booking a table at the restaurant?
                    </span>
                    <span class="icon">+</span>
                </div>
                <div class="description">
                No. There is absolutely no fee or hidden charges involved. However, credit card information is collected from the customer to protect the listed restaurant from frequent no-shows.
              </div>
             </div>
         </div>


         <div class="col-md-6 mb-3">
            <div class="faq-item">
                <div class="question">
                    <span>What if I book a table and fail to show up at the restaurant?</span>
                    <span class="icon">+</span>
                </div>
                <div class="description">
                In case you have booked a table and fail to show up at the restaurant, FoodnPals will charge you a nominal amount of $25. This amount is deducted from the credit card of the customer, the details of which are provided when a customer books a table.

This deducted amount is paid to the restaurant after tax and Stripe service fee deduction. This is to ensure fewer no-shows and minimize the impact of losses borne by the listed restaurants.


              </div>
             </div>
         </div>
        
</section>

<script>
    document.querySelectorAll('.faq-item').forEach(item => {
        item.addEventListener('click', () => {
            item.classList.toggle('active');
        });
    });
</script>

  <br>
 
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