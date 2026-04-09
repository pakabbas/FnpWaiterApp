
<?php
include 'creds.php';

$plans = [];
if (isset($conn)) {
    $result = $conn->query("SELECT PlanID, PlanName, Amount FROM Plans");
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $plans[(int)$row['PlanID']] = $row;
        }
        $result->free();
    }
}

// Map expected plan IDs
$trialPlanId = 1;
$businessMonthlyId = 2;
$enterpriseMonthlyId = 3;
$businessYearlyId = 4;
$enterpriseYearlyId = 5;

function planAmount($plans, $id) {
    if (isset($plans[$id]) && isset($plans[$id]['Amount'])) {
        return number_format((float)$plans[$id]['Amount'], 2);
    }
    return null;
}
?>
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <?php include 'fetch_cookies.php' ?>
  <?php include 'fetch_active_reservation.php' ?>

  <style>
    .banner {
      height: 90vh;
      background-image: url('Resources/par11.png');
      background-size: cover;
      background-position: center;
      display: flex;
      flex-direction: column;
      color: white;
    }
    .row::-webkit-scrollbar {
      display: none;
    }
  </style>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
   font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }
        .pricing-section {
            padding: 50px 20px;
        }
        .pricing-card {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            text-align: left;
            padding: 30px;
            transition: transform 0.3s, box-shadow 0.3s, background-color 0.3s;
            background-color: #f8f9fa;
            height: 100%;
        }
        .pricing-card:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            background-color: #fff;
        }
        .pricing-title {
            color: Black;
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 5px;
            font-family: inter;
        }
        .pricing-price {
            font-size: 1.5rem;
            color:rgb(61, 61, 61);
            margin-bottom: 20px;
        }
        .pricing-button {
            margin-top: 20px;
        }
     .key-features {
    text-align: left;
    margin-top: 20px;
}
.key-features ul {
    padding-left: 0;
    list-style: none;
    
}
.key-features li {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}
    .key-features i {
    color: #4cbb17;
    margin-right: 10px;
    font-size:0.9rem;
}

/* Billing tabs styling */
.billing-tabs {
    display: flex;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.billing-tab {
    padding: 10px 20px;
    border: none;
    background-color: #f8f9fa;
    color: black;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
    outline: none;
}

.billing-tab.active {
    background-color: #4cbb17;
    color: white;
}

.save-badge {
    font-size: 0.7rem;
    background-color: #ff6b6b;
    color: white;
    padding: 2px 6px;
    border-radius: 10px;
    margin-left: 5px;
    font-weight: normal;
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
  <!-- Active Reservation Banner -->
  <?php include 'active_booking_banner.php' ?>
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
  <div class="banner" style="height: 80vh;  background-size: cover; background-position: center; flex-direction: column; justify-content: center; align-items: flex-start; color: white; padding-left: 20px; padding-right: 20px; width: 100%; overflow: hidden;">
      <div style="margin-left: 5%; ">
    <br>
    <div style="with:50%;">
    <h6 class="discover-title" style="font-size: 1.7rem; margin-bottom: 10px;">Join FoodnPals to maximize your
</h6>

    <h5 class="discover-title" style="font-size: 1.7rem; margin-bottom: 10px;"> restaurant’s revenue by filling more tables
 
</h5>
    <h5 class="discover-title" style="font-size: 1.7rem; margin-bottom: 10px;">   and turning every dining experience
</h5>
    <h5 class="discover-title" style="font-size: 1.7rem; margin-bottom: 10px;">
 into profit. Partner with us to attract
</h5>

    <h5 class="discover-title" style="font-size: 1.7rem; margin-bottom: 10px;">
        ready-to-order customers and boost table
</h5>
    <h5 class="discover-title" style="font-size: 1.7rem; margin-bottom: 10px;">
    utilization effortlessly.
</h5>
</div>
<br>
    <button class="search-button ms-3" onclick="scroll1()">Explore Plans</button>

    </div>
    <br><br>

  </div>
<br>

<section id="plans" class="pricing-section container">
    <!-- Billing toggle tabs -->
    <div class="d-flex justify-content-end mb-4">
        <div class="billing-tabs">
            <button id="monthlyTab" class="billing-tab active">Monthly</button>
            <button id="yearlyTab" class="billing-tab">Yearly </button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="pricing-card">
                <h3 class="pricing-title">Trial</h3>
                 <!-- <p style="font-size:0.8rem; color:rgb(131, 131, 131);" class="pricing-price">Advanced recording & analytics</p> -->
                <p class="pricing-price">Free</p>
                <!-- <p style="font-size:18px;" class="pricing-price">First month only</p> -->
                 <button class="search-button ms-3"
                 onclick="window.location.href='RestaurantSignUp.php?PlanID=<?= $trialPlanId ?>'">Get Trial</button>


                <div class="key-features">
                  
                      <ul class="key-features">
    <li><i class="bi bi-circle-fill"></i> Online Ordering</li>
    <li><i class="bi bi-circle-fill"></i> Table Management</li>
    <li><i class="bi bi-circle-fill"></i> Menu Management</li>
</ul>
<hr style="border: none; height: 2px; background-color: #4CBB17;">

                </div>

                <div class="key-features">
                    <h5>Key Features</h5>
                  
                      <ul class="key-features">
    <li><i class="bi bi-gift-fill"></i> One-Month Free Trial</li>
    <li><i class="bi bi-clock-history"></i> Real-time Booking Experience</li>
    <li><i class="bi bi-table"></i> Only 1 table are allowed to add</li>
    <li><i class="bi bi-person-lines-fill"></i> Customer tracking</li>
    <li><i class="bi bi-graph-up-arrow"></i> Dashboard and Analytics</li>
</ul>


                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="pricing-card">
            <h3 class="pricing-title">Business Starter</h3>
              <!-- <p style="font-size:0.8rem; color:rgb(131, 131, 131);" class="pricing-price">Advanced recording & analytics</p> -->
               
            <p class="pricing-price monthly-price">$<?= planAmount($plans, $businessMonthlyId) ?: '0.00' ?> / month</p>
            <p class="pricing-price yearly-price" style="display: none;">$<?= planAmount($plans, $businessYearlyId) ?: '0.00' ?> / year</p>
            <button id="businessPlanBtn" class="search-button ms-3"
              data-monthly-plan-id="<?= $businessMonthlyId ?>"
              data-yearly-plan-id="<?= $businessYearlyId ?>"
              onclick="window.location.href='RestaurantSignUp.php?PlanID=<?= $businessMonthlyId ?>'">Buy Monthly Plan</button>
                
                            <div class="key-features">
                  
                      <ul class="key-features">
    <li><i class="bi bi-circle-fill"></i> Online Ordering</li>
    <li><i class="bi bi-circle-fill"></i> Table Management</li>
    <li><i class="bi bi-circle-fill"></i> Menu Management</li>
</ul>
<hr style="border: none; height: 2px; background-color: #4CBB17;">

                </div>
            <div class="key-features">
                    <h5>Key Features</h5>
                    <ul>
                        <ul class="key-features">
    <li><i class="bi bi-clock-history"></i> Real-time Booking Experience</li>
    <li><i class="bi bi-table"></i> Only 4 tables are allowed to add</li>
    <li><i class="bi bi-person-lines-fill"></i> Customer tracking</li>
    <li><i class="bi bi-graph-up-arrow"></i> Dashboard and Analytics</li>
    <li><i class="bi bi-tablet-landscape"></i> Employee app (If using iPad / Tablet / Phone for menu and orders)</li>
    
</ul>

                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="pricing-card">
            <h3 class="pricing-title">Enterprise</h3>
              <!-- <p style="font-size:0.8rem; color:rgb(131, 131, 131);" class="pricing-price">Advanced recording & analytics</p> -->
               
            <p class="pricing-price monthly-price">$<?= planAmount($plans, $enterpriseMonthlyId) ?: '0.00' ?> / month</p>
            <p class="pricing-price yearly-price" style="display: none;">$<?= planAmount($plans, $enterpriseYearlyId) ?: '0.00' ?> / year</p>
            <button id="enterprisePlanBtn" class="search-button ms-3"
              data-monthly-plan-id="<?= $enterpriseMonthlyId ?>"
              data-yearly-plan-id="<?= $enterpriseYearlyId ?>"
              onclick="window.location.href='RestaurantSignUp.php?PlanID=<?= $enterpriseMonthlyId ?>'">Buy Monthly Plan</button>
                <div class="key-features">
                  
                      <ul class="key-features">
    <li><i  class="bi bi-circle-fill"></i> Online Ordering</li>
<li><i class="bi bi-circle-fill"></i> Table Management</li>

    <li><i class="bi bi-circle-fill"></i> Menu Management</li>
</ul>
<hr style="border: none; height: 2px; background-color: #4CBB17;">

                </div>
                <div class="key-features">
                    <h5>Key Features</h5>
                   <ul class="key-features">
    <li><i class="bi bi-clock-history"></i> Real-time Booking Experience</li>
    <li><i class="bi bi-table"></i> Unlimited tables are allowed to add</li>
    <li><i class="bi bi-person-lines-fill"></i> Customer tracking</li>
    <li><i class="bi bi-graph-up-arrow"></i> Dashboard and Analytics</li>
    <li><i class="bi bi-tablet-landscape"></i> Employee app (If using iPad / Tablet / Phone for menu and orders)</li>
    <li><i class="bi bi-cash-stack"></i> Point of Sales Integration (Square/Clover)</li>
</ul>

                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>





<div class="banner" style=" background-image: url('Resources/par2.png'); height: 70vh;  background-size: cover; background-position: center; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; color: white; padding-left: 20px; padding-right: 20px; width: 100%; overflow: hidden;">
    <h1 class="discover-title" style="font-size: 1.7rem; margin-bottom: 20px;">Transform your restaurant’s</h1>
    <h1 class="discover-title" style="font-size: 1.7rem; margin-bottom: 20px;">revenue with FoodnPals</h1>
  
    <button class="search-button ms-3" onclick="window.location.href='AboutUs.php';">About Us</button>

  
  </div>

  <br>
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

<script>
document.addEventListener("DOMContentLoaded", function() {
    const urlParams = new URLSearchParams(window.location.search);
    const plan = urlParams.get("Plan");

    if (plan === "Gold") {
        document.querySelectorAll(".pricing-card").forEach(card => {
            const title = card.querySelector(".pricing-title").textContent.trim();
            if (title === "Gold Plan" || title === "Silver Plan") {
                const button = card.querySelector("button");
                if (button) {
                    button.disabled = true;
                    button.style.opacity = "0.5";
                    button.style.cursor = "not-allowed";
                }
            }
        });
    }
    
    // Toggle between monthly and yearly pricing
    const monthlyTab = document.getElementById('monthlyTab');
    const yearlyTab = document.getElementById('yearlyTab');
    const businessBtn = document.getElementById('businessPlanBtn');
    const enterpriseBtn = document.getElementById('enterprisePlanBtn');
    
    function toggleBilling(isYearly) {
        // Update active tab
        monthlyTab.classList.toggle('active', !isYearly);
        yearlyTab.classList.toggle('active', isYearly);
        
        // Toggle visibility of pricing elements
        document.querySelectorAll('.monthly-price').forEach(el => {
            el.style.display = isYearly ? 'none' : 'block';
        });
        
        document.querySelectorAll('.yearly-price').forEach(el => {
            el.style.display = isYearly ? 'block' : 'none';
        });
        
        // Update button text and target for Business Starter
        if (businessBtn) {
            const monthlyId = businessBtn.dataset.monthlyPlanId;
            const yearlyId = businessBtn.dataset.yearlyPlanId;
            businessBtn.textContent = isYearly ? 'Buy Yearly Plan' : 'Buy Monthly Plan';
            businessBtn.onclick = function() {
                const planId = isYearly ? yearlyId : monthlyId;
                window.location.href = 'RestaurantSignUp.php?PlanID=' + planId;
            };
        }

        // Update button text and target for Enterprise
        if (enterpriseBtn) {
            const monthlyId = enterpriseBtn.dataset.monthlyPlanId;
            const yearlyId = enterpriseBtn.dataset.yearlyPlanId;
            enterpriseBtn.textContent = isYearly ? 'Buy Yearly Plan' : 'Buy Monthly Plan';
            enterpriseBtn.onclick = function() {
                const planId = isYearly ? yearlyId : monthlyId;
                window.location.href = 'RestaurantSignUp.php?PlanID=' + planId;
            };
        }
    }
    
    // Add click event listeners to tabs
    if (monthlyTab && yearlyTab) {
        monthlyTab.addEventListener('click', function() {
            toggleBilling(false);
        });
        
        yearlyTab.addEventListener('click', function() {
            toggleBilling(true);
        });
    }
});
</script>

</html>