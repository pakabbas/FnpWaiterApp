<!DOCTYPE html>
<html lang="en">

<head>
  <?php session_start();   ?>
  <?php include 'admin/TableStatus.php'; ?>
  <meta charset="UTF-8">
    <meta name="description" content="FoodnPals">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">

  <title>FoodnPals - Restaurant</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/banner.css">
  <link rel="stylesheet" href="assets/css/footer.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon.png">
  <link rel="stylesheet" href="assets/css/Explore.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
 
  <link rel="stylesheet" href="assets/css/profile.css">

 

  <script>
    // Function to get URL parameters
    function getParameterByName(name, url = window.location.href) {
      name = name.replace(/[\[\]]/g, '\\$&');
      const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
      if (!results) return null;
      if (!results[2]) return '';
      return decodeURIComponent(results[2].replace(/\+/g, ' '));
    }

    // Function to open a specific tab
    function openTab(tabName) {
      // Hide all tab contents
      $('.tab-content').hide();

      // Remove 'active' class from all buttons
      $('.tab-btn').removeClass('active');

      // Show the selected tab content
      $('#' + tabName).show();

      // Add 'active' class to the clicked button
      $('#tab-' + tabName).addClass('active');
    }

    document.addEventListener('DOMContentLoaded', function() {
      // Get the restaurantID from the URL parameters first
      const restaurantID = getParameterByName('ID');
      //alert(restaurantID);
      //document.getElementById('RestaurantID').value = restaurantID;

      if (getParameterByName('menu') === '1') {
        openTab('restaurant-menu');

        // Scroll to the section with id="sectiontab"
        $('html, body').animate({
          scrollTop: $("#sectiontab").offset().top
        }, 1000); // 1000ms for smooth scroll
      }
    });
  </script>

  <style>
    /* Responsive header styles */
    @media (max-width: 768px) {
      .header-container {
        padding: 10px 15px;
      }
      .logo-container {
        width: auto;
        max-width: 120px;
      }
      .logo-container img {
        width: 100%;
      }
    }
  </style>

</head>

<body style="margin:0px; padding:0px; ">
  <?php include 'fetch_active_reservation.php' ?>
  
  <!-- Active Reservation Banner -->
  <?php include 'active_booking_banner.php' ?>
  
  <script>
    // Close banner functionality
    document.addEventListener('DOMContentLoaded', function() {
      const closeBanner = document.getElementById('close-banner');
      const banner = document.getElementById('active-booking-banner');
      
      if (closeBanner && banner) {
        closeBanner.addEventListener('click', function(e) {
          e.stopPropagation(); // Prevent banner click event from firing
          banner.style.display = 'none';
        });
      }
    });
  </script>

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

  <!-- Collections Carousel -->
<?php
$bannerFile = $restaurant['RestaurantBanner'];
$bannerPath = "Resources/icons/" . $bannerFile;
$defaultPath = "Resources/R1.png";

$bgImage = file_exists($bannerPath) ? $bannerPath : $defaultPath;

?>
  <div id="webdiv" style=" margin-top: 20px;">
  <div style="width: 60%; height: 300px; background-image: url('<?php echo $bgImage; ?>'); background-size: cover; background-position: center; border-radius: 15px; margin-left: 5%;"></div>
  <div style="position: relative; height: 100px; width: 25%; background-image: url('Resources/p2.png'); background-size: cover; margin-left: 2%; height: 300px; border-radius: 15px;">
     
    
<!-- Button -->
<a href="#" class="see-all-btn"
   onclick="openTab('photos'); scrollToSection();"
   style="position: absolute; bottom: 0; right: 0; margin-right: 15px; margin-bottom: 20px;">
  <i class="fas fa-camera"></i>
  See All (6)
</a>
    
      </div>


  </div>

  <div id="mobilediv" style="height:250px;   background-image: url('<?php echo $bgImage; ?>'); background-size:cover;">
  </div>

  </div>

  <div style="display: flex; margin-top: 20px;">



    <div style="width: 95%; background-color: white; background-repeat: no-repeat; background-size:contain; height: auto; border-radius: 15px; margin-left: 5%;">

    <div class="restaurant-text">

<span class="restaurant-name" style=" font-size: 30px; font-weight: bold;"><?php echo htmlspecialchars("" . $restaurant['Name']); ?></span>


<p class="restaurant-rating">
    <?php
    // Get the average rating as a float
    $rating = floatval($restaurant['AverageRating']);
    
    // Loop through 5 stars
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $rating) {
            // Full star
            echo '<i class="fas fa-star" style="color: #FFD700;"></i>';
        } elseif ($i - 0.5 <= $rating) {
            // Half star
            echo '<i class="fas fa-star-half-alt" style="color: #FFD700;"></i>';
        } else {
            // Empty star
            echo '<i class="far fa-star" style="color: #FFD700;"></i>';
        }
    }
    ?>
    <span style="margin-left: 5px;"><?php echo number_format($restaurant['AverageRating'], 1); ?></span>
</p>
<p class="restaurant-type">
    <?php 
    // Split the cuisine types by comma
    $cuisineTypes = explode(',', $restaurant['CuisineType']);
    
    // Display each cuisine type as a styled tag
    foreach ($cuisineTypes as $cuisine) {
        $cuisine = trim($cuisine);
        if (!empty($cuisine)) {
            echo '<span class="cuisine-tag">' . htmlspecialchars($cuisine) . '</span>';
        }
    }
    ?>
</p>
<style>
    .cuisine-tag {
        display: inline-block;
        background-color: #f8f9fa;
        color: #4CBB17;
        border: 1px solid #4CBB17;
        border-radius: 20px;
        padding: 3px 12px;
        margin-right: 8px;
        margin-bottom: 8px;
        font-size: 14px;
        font-weight: 500;
    }
</style>
<p class="restaurant-type"><i class="fa fa-map-marker" style="color: #4CBB17; font-size: 24px; margin-right: 10px;"></i><?php echo htmlspecialchars("" . $restaurant['Address']. ", " . $restaurant['City']. ", " . $restaurant['State']); ?></p>
</div>
      <!-- <img src="Resources/ratings.png" style="" alt="Restaurant Image"> -->


    </div>

  </div>
<br>

  <section style="margin-left: 1.5%;" id="sectiontab">
    <div class="tabs" style="overflow-x: auto; white-space: nowrap; -webkit-overflow-scrolling: touch; scrollbar-width: none;">
      <button id="tab-available-tables" class="tab-btn active" onclick="openTab('available-tables')">Tables</button>
      <button id="tab-restaurant-description" class="tab-btn" onclick="openTab('restaurant-description')">Description</button>
      <button id="tab-restaurant-menu" class="tab-btn" onclick="openTab('restaurant-menu')">Menu</button>
      <!-- <button id="tab-reviews" class="tab-btn" onclick="openTab('reviews')">Reviews</button> -->
      <button id="tab-photos" class="tab-btn" onclick="openTab('photos')">Photos</button>
        <button id="tab-reviews" class="tab-btn" onclick="openTab('reviews')">Reviews</button>
    </div>
    <style>
      .tab-btn {
        padding: 10px 20px;
        border: none;
        background-color: transparent;
        cursor: pointer;
        font-weight: 500;
        border-radius: 5px;
        margin-right: 5px;
        transition: background-color 0.3s, color 0.3s;
      }
      .tab-btn:hover {
        background-color: rgba(76, 187, 23, 0.1);
      }
      .tab-btn.active {
        background-color: #4CBB17;
        color: white;
      }
      
      /* Mobile responsive styles */
      @media (max-width: 768px) {
        .tab-content {
          width: 94% !important;
          margin-left: 1% !important;
          max-width: 100%;
          overflow-x: hidden;
        }
        
        .responsive-container-mobile {
          width: 100%;
          overflow-x: auto;
        }
        
        .photo-grid {
          padding: 10px;
        }
        
        .photo-grid > div {
          flex: 1 1 calc(50% - 10px) !important;
          max-width: calc(50% - 10px) !important;
        }
      }
      
      @media (max-width: 480px) {
        .photo-grid > div {
          flex: 1 1 100% !important;
          max-width: 100% !important;
        }
      }
    </style>
    
    <!-- Tab content -->
    <div id="available-tables" class="tab-content active" style="margin-left: 1%;">
      <br>
      <h3 style="margin-left: 1%;"> Book Table</h3>
      <div class="responsive-container-mobile">
        <?php include 'fetch_dining_tables.php'; ?>
      </div>
    </div><!--  end div available tables -->

    <div id="restaurant-description" class="tab-content" style="width: 95%; margin-left: 1%;">
      <br>
    <h2 style="margin-left: 1%;">Description</h2>
      <p style="color:rgb(83, 81, 81); margin-left: 1%;"><?php echo htmlspecialchars("" . $restaurant['AdditionalInformation']); ?></p>
    </div>

    <div id="restaurant-menu" class="tab-content" style="margin-left: 1%;">
      <br>
      <h3 style="margin-top: 5px; margin-left: 1%;">Restaurant Menu</h3>
      <div class="responsive-container-mobile">
        <?php include 'fetch_menu.php'; ?>
      </div>
      
      <?php if (isset($isReservationActive) &&   $isReservationActive == "Yes" && $activeReservationRestaurant == $restaurantID): ?>
        <div class="cart-button-container" style="display: flex; justify-content: center; margin: 20px 0 40px;">
          <button id="showModelButton" type="button" class="btn btn-cart-view" data-toggle="modal" data-target="#smallmodal" style="
            background: linear-gradient(135deg, #4CBB17 0%, #45a716 100%);
            color: white;
            border: none;
            border-radius: 50px;
            padding: 12px 25px;
            font-weight: 600;
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(76, 187, 23, 0.3);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 180px;
            transform: scale(1);
            position: relative;
            overflow: hidden;
          ">
            <i class="fas fa-shopping-cart mr-2" style="font-size: 18px;"></i>
            <span>View Cart</span>
            <div class="cart-pulse" style="
              position: absolute;
              width: 100%;
              height: 100%;
              border-radius: 50px;
              border: 2px solid rgba(255, 255, 255, 0.7);
              animation: pulse 2s infinite;
              pointer-events: none;
            "></div>
          </button>
        </div>
        <br><br>
        
        <style>
          @keyframes pulse {
            0% {
              transform: scale(1);
              opacity: 0.7;
            }
            70% {
              transform: scale(1.05);
              opacity: 0;
            }
            100% {
              transform: scale(1);
              opacity: 0;
            }
          }
          
          .btn-cart-view:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(76, 187, 23, 0.4);
          }
          
          .btn-cart-view:active {
            transform: translateY(0);
            box-shadow: 0 2px 10px rgba(76, 187, 23, 0.3);
          }
          
          /* Responsive styles */
          @media (max-width: 768px) {
            .cart-button-container {
              margin: 15px 0 30px;
            }
            
            .btn-cart-view {
              width: 80%;
              max-width: 280px;
              padding: 10px 20px;
              font-size: 14px;
            }
          }
          
          @media (max-width: 480px) {
            .btn-cart-view {
              width: 90%;
              padding: 8px 15px;
            }
          }
        </style>
      <?php endif; ?>
    </div>



    <div id="photos" class="tab-content" style="margin-left: 1%;">
    <br>
  <h2 style="margin-top: 5px; margin-left: 1%;">Photos</h2>
  <div class="photo-grid" style="display: flex; flex-wrap: wrap; gap: 10px; padding: 20px;">
    <?php
    for ($i = 1; $i <= 6; $i++) {
      echo '
        <div style="flex: 1 1 calc(33.333% - 10px); max-width: calc(33.333% - 10px); box-sizing: border-box;">
          <img src="Resources/restaurantImages/' . $i . '.png" alt="Photo ' . $i . '" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px;">
        </div>';
    }
    ?>
  </div>
</div>



<div id="reviews" class="tab-content" style="margin-left: 1%;">
<br>
  <h3 style="margin-top: 5px; margin-left: 1%;">Reviews</h3>
  <?php
// Get the RestaurantID from the GET parameter
$restaurantID = isset($_GET['ID']) ? $_GET['ID'] : null;

if (!$restaurantID) {
  echo "<p>No restaurant selected.</p>";
  exit(); // Exit if no RestaurantID is provided
}


// Pass RestaurantID as a variable to the included file
include 'ReviewsGrid1.php';
?>

</div>


  </section>

  <!-- Checkout Modal -->
  <div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="max-height: 95vh; margin: 1.75rem auto;">
      <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1); max-height: 90vh;">
        <div class="modal-header" style="background: linear-gradient(135deg, #4CBB17 0%, #45a716 100%); color: white; border-top-left-radius: 15px; border-top-right-radius: 15px; padding: 15px 20px;">
          <h5 class="modal-title" id="checkoutModalLabel" style="font-size: 20px; font-weight: 600;">Complete Your Booking</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 1;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" style="padding: 15px 20px; max-height: 80vh; overflow-y: auto;">
          <?php if (isset($isReservationActive) && $isReservationActive !== "Yes") : ?>
            <div class="reservation-progress" style="display: flex; justify-content: space-between; margin-bottom: 15px; position: relative;">
              <div class="progress-bar" style="position: absolute; top: 15px; left: 0; right: 0; height: 3px; background-color: #e9ecef; z-index: 1;"></div>
              <div class="progress-fill" style="position: absolute; top: 15px; left: 0; width: 100%; height: 3px; background-color: #4CBB17; z-index: 2;"></div>
              
              <div class="step active" style="position: relative; z-index: 3; text-align: center;">
                <div class="step-icon" style="width: 25px; height: 25px; border-radius: 50%; background-color: #4CBB17; color: white; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                  <i class="fas fa-check" style="font-size: 12px;"></i>
                </div>
                <div class="step-label" style="font-size: 10px; color: #4CBB17; margin-top: 3px;">Table Selected</div>
              </div>
              
              <div class="step active" style="position: relative; z-index: 3; text-align: center;">
                <div class="step-icon" style="width: 25px; height: 25px; border-radius: 50%; background-color: #4CBB17; color: white; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                  <i class="fas fa-user" style="font-size: 12px;"></i>
                </div>
                <div class="step-label" style="font-size: 10px; color: #4CBB17; margin-top: 3px;">Details</div>
              </div>
              
              <div class="step" style="position: relative; z-index: 3; text-align: center;">
                <div class="step-icon" style="width: 25px; height: 25px; border-radius: 50%; background-color: #e9ecef; color: #6c757d; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
                  <i class="fas fa-map-marker-alt" style="font-size: 12px;"></i>
                </div>
                <div class="step-label" style="font-size: 10px; color: #6c757d; margin-top: 3px;">Confirm</div>
              </div>
            </div>
            
            <form id="checkoutForm" action="process_reservation.php" method="post">
              <div class="card mb-3" style="border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: none;">
                <div class="card-body" style="padding: 12px;">
                  <div class="row g-2">
                    <div class="col-md-6 mb-2">
                      <label for="name" class="form-label" style="font-weight: 500; color: #555; margin-bottom: 3px; font-size: 12px;">Name:</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text" style="background-color: #f8f9fa; border-color: #e4e7ed; border-right: none; padding: 6px;"><i class="fas fa-user" style="color: #4CBB17; font-size: 12px;"></i></span>
                        </div>
                        <input type="text" readonly id="name" value="<?php echo htmlspecialchars($firstName . ' ' . $lastName); ?>" class="form-control" style="border-left: none; background-color: #f8f9fa; border-color: #e4e7ed; padding: 6px 10px; height: auto; font-size: 13px;">
                      </div>
                    </div>
                    <div class="col-md-6 mb-2">
                      <label for="email" class="form-label" style="font-weight: 500; color: #555; margin-bottom: 3px; font-size: 12px;">Email:</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text" style="background-color: #f8f9fa; border-color: #e4e7ed; border-right: none; padding: 6px;"><i class="fas fa-envelope" style="color: #4CBB17; font-size: 12px;"></i></span>
                        </div>
                        <input type="email" readonly value="<?php echo htmlspecialchars($email); ?>" id="email" class="form-control" style="border-left: none; background-color: #f8f9fa; border-color: #e4e7ed; padding: 6px 10px; height: auto; font-size: 13px;">
                      </div>
                    </div>
                  </div>
                  <div class="row g-2">
                    <div class="col-md-6 mb-2">
                      <label for="contact" class="form-label" style="font-weight: 500; color: #555; margin-bottom: 3px; font-size: 12px;">Contact Number:</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text" style="background-color: #f8f9fa; border-color: #e4e7ed; border-right: none; padding: 6px;"><i class="fas fa-phone" style="color: #4CBB17; font-size: 12px;"></i></span>
                        </div>
                        <input type="tel" readonly id="contact" value="<?php echo htmlspecialchars($phoneNumber); ?>" class="form-control" style="border-left: none; background-color: #f8f9fa; border-color: #e4e7ed; padding: 6px 10px; height: auto; font-size: 13px;">
                      </div>
                    </div>
                    <div class="col-md-6 mb-2">
                      <label for="selected-table" class="form-label" style="font-weight: 500; color: #555; margin-bottom: 3px; font-size: 12px;">Selected Table:</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text" style="background-color: #f8f9fa; border-color: #e4e7ed; border-right: none; padding: 6px;"><i class="fas fa-chair" style="color: #4CBB17; font-size: 12px;"></i></span>
                        </div>
                        <input type="text" readonly id="selected-table" name="selected_table" class="form-control" style="border-left: none; background-color: #f8f9fa; border-color: #e4e7ed; padding: 6px 10px; height: auto; font-size: 13px;">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="card mb-3" style="border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border: none;">
                <div class="card-header" style="background-color: #f8f9fa; border-bottom: none; padding: 10px 15px; border-top-left-radius: 10px; border-top-right-radius: 10px;">
                  <h6 style="margin: 0; color: #4a4a4a; font-weight: 600; font-size: 14px;"><i class="fas fa-comment-alt mr-2" style="color: #4CBB17;"></i> Special Requests</h6>
                </div>
                <div class="card-body" style="padding: 12px;">
                  <div class="mb-0">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text" style="background-color: #f8f9fa; border-color: #e4e7ed; border-right: none; padding: 6px;"><i class="fas fa-pencil-alt" style="color: #4CBB17; font-size: 12px;"></i></span>
                      </div>
                      <textarea id="SpecialInstructions" name="SpecialInstructions" class="form-control" placeholder="Any special requests?" style="border-left: none; background-color: #f8f9fa; border-color: #e4e7ed; padding: 6px 10px; height: 40px; font-size: 13px;"></textarea>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="row g-3 mb-3" hidden>
                <div class="col-md-6">
                  <label for="TableID" class="form-label">TableID</label>
                  <input type="text" readonly id="TableID" name="table_id" class="form-control">
                </div>
                <div class="col-md-6">
                  <label for="RestaurantID" class="form-label">RestaurantID</label>
                  <input type="text" readonly id="RestaurantID" name="RestaurantID" value="<?php echo htmlspecialchars($restaurant['RestaurantID']); ?>" class="form-control">
                </div>
              </div>
              
                        <div class="text-center">
            <button type="button" onclick="showPaymentInfo(); openBookingModal();" class="btn" style="padding: 8px 20px; background: linear-gradient(135deg, #4CBB17 0%, #45a716 100%); color: #fff; border: none; border-radius: 50px; font-weight: 600; box-shadow: 0 4px 15px rgba(76, 187, 23, 0.3); transition: all 0.3s ease; font-size: 14px;">
              <i class="fas fa-calendar-check mr-2"></i> Continue to Confirm
            </button>
          </div>
            </form>
          <?php else: ?>
            <div class="alert alert-warning" style="border-radius: 10px; border-left: 5px solid #ffc107; background-color: #fff3cd; padding: 20px;">
              <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle mr-3" style="font-size: 24px; color: #ffc107;"></i>
                <p style="margin: 0; color: #856404; font-weight: 500;">You already have an active booking. Please complete it before making a new one.</p>
              </div>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Booking Confirmation Modal -->
  <div id="bookingConfirmationModal" style="display:none; position:fixed; z-index:1050; left:0; top:0; width:100%; height:100%; overflow:auto; background-color:rgba(0,0,0,0.6);">
    <div style="background:#fff; padding:0; border-radius:15px; width:90%; max-width:700px; max-height:90vh; position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); box-shadow:0 20px 60px rgba(0,0,0,0.3); overflow:hidden; display:flex; flex-direction:column;">
      <!-- Header -->
      <div style="background: linear-gradient(135deg, #4CBB17 0%, #45a716 100%); color: white; padding: 15px 20px; position: relative;">
        <h4 style="margin:0; font-size: 20px; font-weight: 600;">Confirm Your Booking</h4>
        <p style="margin: 3px 0 0 0; opacity: 0.8; font-size: 12px;">Please review your booking details</p>
        <button onclick="closeBookingModal()" style="position: absolute; right: 15px; top: 15px; background: none; border: none; color: white; font-size: 18px; cursor: pointer;">&times;</button>
      </div>

      <div style="padding: 15px; overflow-y: auto; flex-grow: 1;">
        <!-- Progress indicator -->
        <div style="display: flex; justify-content: space-between; margin-bottom: 15px; position: relative;">
          <div style="position: absolute; top: 12px; left: 0; right: 0; height: 3px; background-color: #e9ecef; z-index: 1;"></div>
          <div style="position: absolute; top: 12px; left: 0; width: 100%; height: 3px; background-color: #4CBB17; z-index: 2;"></div>
          
          <div style="position: relative; z-index: 3; text-align: center;">
            <div style="width: 25px; height: 25px; border-radius: 50%; background-color: #4CBB17; color: white; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
              <i class="fas fa-check" style="font-size: 12px;"></i>
            </div>
            <div style="font-size: 10px; color: #4CBB17; margin-top: 3px;">Table Selected</div>
          </div>
          
          <div style="position: relative; z-index: 3; text-align: center;">
            <div style="width: 25px; height: 25px; border-radius: 50%; background-color: #4CBB17; color: white; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
              <i class="fas fa-user" style="font-size: 12px;"></i>
            </div>
            <div style="font-size: 10px; color: #4CBB17; margin-top: 3px;">Details</div>
          </div>
          
          <div style="position: relative; z-index: 3; text-align: center;">
            <div style="width: 25px; height: 25px; border-radius: 50%; background-color: #4CBB17; color: white; display: flex; align-items: center; justify-content: center; margin: 0 auto;">
              <i class="fas fa-map-marker-alt" style="font-size: 12px;"></i>
            </div>
            <div style="font-size: 10px; color: #4CBB17; margin-top: 3px;">Confirm</div>
          </div>
        </div>

        <!-- Map with modern styling -->
        <div id="mapPlaceholder" style="width:100%; height:220px; border-radius:10px; overflow:hidden; margin-bottom:15px; box-shadow: 0 4px 12px rgba(0,0,0,0.08);"></div>
        
        <!-- Travel info cards -->
        <div style="display: flex; gap: 10px; margin-bottom: 15px;">
          <div style="flex: 1; background: #f8f9fa; border-radius: 10px; padding: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
            <div style="display: flex; align-items: center;">
              <div style="width: 32px; height: 32px; border-radius: 50%; background-color: rgba(76, 187, 23, 0.1); display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                <i class="fas fa-clock" style="color: #4CBB17; font-size: 14px;"></i>
              </div>
              <div>
                <h5 style="margin: 0; font-size: 12px; color: #666; font-weight: 500;">Estimated Travel Time</h5>
                <p id="travelTime" style="margin: 0; font-size: 14px; color: #333; font-weight: 600;">Calculating...</p>
              </div>
            </div>
          </div>
          
          <div style="flex: 1; background: #f8f9fa; border-radius: 10px; padding: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
            <div style="display: flex; align-items: center;">
              <div style="width: 32px; height: 32px; border-radius: 50%; background-color: rgba(76, 187, 23, 0.1); display: flex; align-items: center; justify-content: center; margin-right: 10px;">
                <i class="fas fa-hourglass-half" style="color: #4CBB17; font-size: 14px;"></i>
              </div>
              <div>
                <h5 style="margin: 0; font-size: 12px; color: #666; font-weight: 500;">Restaurant Wait Time</h5>
                <p style="margin: 0; font-size: 14px; color: #333; font-weight: 600;"><?php echo htmlspecialchars($restaurant['TableTimeLimit']); ?> minutes</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Action buttons -->
        <div style="display: flex; justify-content: space-between; align-items: center;">
          <button type="button" onclick="closeBookingModal()" style="padding: 8px 20px; background: #f1f2f3; color: #666; border: none; border-radius: 50px; font-weight: 600; transition: all 0.3s ease; font-size: 14px;">
            <i class="fas fa-times mr-2"></i> Cancel
          </button>
          <button type="button" onclick="submitBooking()" style="padding: 8px 20px; background: linear-gradient(135deg, #4CBB17 0%, #45a716 100%); color: #fff; border: none; border-radius: 50px; font-weight: 600; box-shadow: 0 4px 15px rgba(76, 187, 23, 0.3); transition: all 0.3s ease; font-size: 14px;">
            <i class="fas fa-check mr-2"></i> Confirm Booking
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Add loading overlay HTML after the booking confirmation modal -->
<div id="loadingOverlay" style="display:none; position:fixed; z-index:2000; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.7); justify-content:center; align-items:center;">
  <div style="background-color:white; padding:30px; border-radius:10px; text-align:center; box-shadow:0 0 20px rgba(0,0,0,0.3);">
    <div class="spinner-border text-success" role="status" style="width:3rem; height:3rem;">
      <span class="sr-only">Loading...</span>
    </div>
    <h4 style="margin-top:15px; color:#4CBB17;">Processing your booking...</h4>
    <p style="margin-top:5px; color:#666;">Please wait while we confirm your booking</p>
  </div>
</div>

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDP9cy_r8w6t7O0Wct3KmP0rPI0ISVQqks&libraries=places"></script>
  <script>
    const userLat = <?php echo json_encode($latitude); ?>;
    const userLng = <?php echo json_encode($longitude); ?>;
    const restaurantLat = <?php echo json_encode($restaurant['Latitude']); ?>;
    const restaurantLng = <?php echo json_encode($restaurant['Longitude']); ?>;

    function initMap() {
      const userLocation = new google.maps.LatLng(userLat, userLng);
      const restaurantLocation = new google.maps.LatLng(restaurantLat, restaurantLng);

      // Custom map style
      const mapStyle = [
        {
          "featureType": "administrative",
          "elementType": "labels.text.fill",
          "stylers": [{"color": "#444444"}]
        },
        {
          "featureType": "landscape",
          "elementType": "all",
          "stylers": [{"color": "#f2f2f2"}]
        },
        {
          "featureType": "poi",
          "elementType": "all",
          "stylers": [{"visibility": "off"}]
        },
        {
          "featureType": "road",
          "elementType": "all",
          "stylers": [{"saturation": -100}, {"lightness": 45}]
        },
        {
          "featureType": "road.highway",
          "elementType": "all",
          "stylers": [{"visibility": "simplified"}]
        },
        {
          "featureType": "road.arterial",
          "elementType": "labels.icon",
          "stylers": [{"visibility": "off"}]
        },
        {
          "featureType": "transit",
          "elementType": "all",
          "stylers": [{"visibility": "off"}]
        },
        {
          "featureType": "water",
          "elementType": "all",
          "stylers": [{"color": "#c4e5f3"}, {"visibility": "on"}]
        }
      ];

      const map = new google.maps.Map(document.getElementById("mapPlaceholder"), {
        zoom: 13,
        center: userLocation,
        styles: mapStyle,
        disableDefaultUI: true,
        zoomControl: true,
        mapTypeControl: false,
        scaleControl: true,
        streetViewControl: false,
        rotateControl: false,
        fullscreenControl: false
      });

      // Custom direction renderer options
      const directionsService = new google.maps.DirectionsService();
      const directionsRenderer = new google.maps.DirectionsRenderer({
        suppressMarkers: false,
        polylineOptions: {
          strokeColor: "#4CBB17",
          strokeWeight: 5,
          strokeOpacity: 0.8
        },
        markerOptions: {
          icon: {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 8,
            fillColor: "#4CBB17",
            fillOpacity: 1,
            strokeColor: "#FFFFFF",
            strokeWeight: 2
          }
        }
      });
      directionsRenderer.setMap(map);

      // Custom markers
      const userMarker = new google.maps.Marker({
        position: userLocation,
        map: map,
        icon: {
          path: google.maps.SymbolPath.CIRCLE,
          scale: 10,
          fillColor: "#4285F4",
          fillOpacity: 1,
          strokeColor: "#FFFFFF",
          strokeWeight: 2
        },
        title: "Your Location"
      });

      const restaurantMarker = new google.maps.Marker({
        position: restaurantLocation,
        map: map,
        icon: {
          path: google.maps.SymbolPath.CIRCLE,
          scale: 10,
          fillColor: "#4CBB17",
          fillOpacity: 1,
          strokeColor: "#FFFFFF",
          strokeWeight: 2
        },
        title: "Restaurant Location"
      });

      directionsService.route({
        origin: userLocation,
        destination: restaurantLocation,
        travelMode: google.maps.TravelMode.DRIVING,
      }, (response, status) => {
        if (status === google.maps.DirectionsStatus.OK) {
          directionsRenderer.setDirections(response);
          const duration = response.routes[0].legs[0].duration.text;
          document.getElementById("travelTime").textContent = duration;
          
          // Hide the custom markers once directions are displayed
          userMarker.setMap(null);
          restaurantMarker.setMap(null);
        } else {
          document.getElementById("travelTime").textContent = "Could not calculate";
        }
      });
    }

    function openBookingModal() {
      const tableInput = document.getElementById('selected-table');
      const table = tableInput.value.trim();

      if (!table) {
        Swal.fire({
          icon: 'warning',
          title: 'Please select a table first',
          confirmButtonColor: '#4CBB17'
        });
        return;
      }

      const modal = document.getElementById('bookingConfirmationModal');
      modal.style.display = 'block';

      setTimeout(() => {
        initMap();
      }, 300);
    }

    function closeBookingModal() {
      document.getElementById('bookingConfirmationModal').style.display = 'none';
    }

    function submitBooking() {
      // Show loading overlay
      document.getElementById('loadingOverlay').style.display = 'flex';
      
      // Close the booking modal
      closeBookingModal();
      
      // Submit the form
      document.getElementById('checkoutForm').submit();
    }
    
    // Function to show information about the payment step
    function showPaymentInfo() {
      Swal.fire({
        title: 'Booking Guarantee',
        html: `
          <div style="text-align: left; margin-top: 10px;">
            <p><i class="fas fa-info-circle" style="color: #4CBB17;"></i> We'll ask for your card details in the next step.</p>
            <p><i class="fas fa-credit-card" style="color: #4CBB17;"></i> Your card will only be charged $30 in case of a no-show.</p>
            <p><i class="fas fa-shield-alt" style="color: #4CBB17;"></i> Your payment information is securely stored.</p>
          </div>
        `,
        icon: 'info',
        confirmButtonColor: '#4CBB17',
        confirmButtonText: 'Continue'
      });
    }
    
    // Modified function to open checkout modal instead of scrolling
    function scrollToCheckout(tableID, TableID2, isLoggedIn) {
  if (!isLoggedIn) {
    Swal.fire({
      icon: 'warning',
      title: 'Please Log in first to book a table.',
      confirmButtonColor: '#4CBB17'
    });
    return;
  }

  // Check last reservation time before proceeding
  $.ajax({
    url: 'fetch_last_reservation.php',
    method: 'GET',
    dataType: 'json',
    success: function(response) {

      
      if (response.status === 'success') {
        if (!response.canBook) {
          // Less than 60 minutes since last reservation
          Swal.fire({
            icon: 'warning',
            title: 'Booking Limit Reached',
            text: 'You cannot create another booking now. Please try again later...',
            confirmButtonColor: '#4CBB17'
          });
        } else {
          // More than 60 minutes have passed or no previous reservation
          var TableID = document.getElementById('TableID');
          if (TableID) {
            TableID.value = TableID2;
            var tableTextbox = document.getElementById('selected-table');
            tableTextbox.value = tableID;

            // Open the checkout modal
            $('#checkoutModal').modal('show');
          }
        }
      } else {
        console.error('Error checking reservation status:', response.message);
      }
    },
    error: function(xhr, status, error) {
      console.error('AJAX error:', error);
      // Fall back to showing the modal in case of error
      var TableID = document.getElementById('TableID');
      if (TableID) {
        TableID.value = TableID2;
        var tableTextbox = document.getElementById('selected-table');
        tableTextbox.value = tableID;
        $('#checkoutModal').modal('show');
      }
    }
  });
}
  </script>

  <br>
  <br>
  <?php include 'footer.php'; ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">



<!-- Menu Modal -->
<div 
  class="modal fade" 
  id="menumodal" 
  tabindex="-1" 
  role="dialog" 
  aria-labelledby="menuModalLabel" 
  aria-hidden="true">

  <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 500px; width: 95%; margin: 10px auto;">
    <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15); overflow: hidden;">
      
      <!-- Hidden Fields -->
      <div hidden>
        <span id="menuItemID"></span>
        <span id="menurestaurantID"></span>
      </div>

      <!-- Image Header -->
      <div style="position: relative; height: 200px; overflow: hidden;">
        <img id="menuItemImage" src="" style="width: 100%; height: 100%; object-fit: cover;" alt="Menu Item Image">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position: absolute; top: 15px; right: 15px; background: rgba(255,255,255,0.8); border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.2);">
          <span aria-hidden="true" style="color: #333; font-size: 18px;">&times;</span>
        </button>
        <div style="position: absolute; bottom: 0; left: 0; right: 0; background: linear-gradient(transparent, rgba(0,0,0,0.7)); padding: 20px 15px 15px 15px;">
          <h4 id="menuItemName" style="color: white; margin: 0; font-size: 22px; font-weight: 700; text-shadow: 0 1px 3px rgba(0,0,0,0.3);"></h4>
        </div>
      </div>

      <!-- Modal Body -->
      <div class="modal-body" style="padding: 20px; overflow-y: auto; max-height: 50vh;">
        <!-- Price and Description -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
          <div style="font-size: 20px; font-weight: 700; color: #4CBB17;">$<span id="menuItemPrice"></span></div>
          <div class="badge" style="background-color: #e8f5e9; color: #4CBB17; padding: 6px 12px; border-radius: 20px; font-weight: 500; font-size: 12px;">Available</div>
        </div>
        
        <div style="margin-bottom: 20px;">
          <h6 style="font-size: 14px; color: #666; font-weight: 500; margin-bottom: 8px;">Description</h6>
          <p id="menuItemDescription" style="color: #333; font-size: 14px; line-height: 1.5; margin-bottom: 0;"></p>
        </div>
        
        <!-- Divider -->
        <div style="height: 1px; background-color: #f0f0f0; margin: 20px 0;"></div>

        <!-- Make it a Meal Section -->
        <div>
          <h6 style="font-size: 16px; font-weight: 600; color: #333; margin-bottom: 12px;">
            <i class="fas fa-utensils mr-2" style="color: #4CBB17;"></i>Make it a Meal
          </h6>
          <p style="font-size: 14px; color: #666; margin-bottom: 15px;">Choose from the sides below to enhance your meal:</p>
          
          <div id="mealSides" style="max-height: 200px; overflow-y: auto; padding-right: 10px;">
            <!-- Dynamically populated checkboxes for sides -->
          </div>
        </div>
      </div>

      <!-- Fixed Modal Footer -->
      <div style="padding: 15px 20px; background: white; border-top: 1px solid #f0f0f0; display: flex; justify-content: space-between; align-items: center;">
        <div style="display: flex; align-items: center; border: 1px solid #e0e0e0; border-radius: 8px; overflow: hidden;">
          <button style="width: 36px; height: 36px; border: none; background: #f8f8f8; color: #4CBB17; font-size: 16px; font-weight: bold;" type="button" onclick="decreaseQuantity()">-</button>
          <input type="text" id="quantityInput" value="1" style="width: 40px; text-align: center; border: none; height: 36px; font-size: 14px; font-weight: 600;">
          <button style="width: 36px; height: 36px; border: none; background: #f8f8f8; color: #4CBB17; font-size: 16px; font-weight: bold;" type="button" onclick="increaseQuantity()">+</button>
        </div>
        <button style="background: linear-gradient(135deg, #4CBB17 0%, #45a716 100%); color: white; border: none; border-radius: 8px; padding: 10px 20px; font-weight: 600; font-size: 14px; box-shadow: 0 2px 10px rgba(76, 187, 23, 0.2);" type="button" onclick="addToCart('X','X')">
          <i class="fas fa-shopping-cart mr-2"></i>Add to Cart
        </button>
      </div>

    </div>
  </div>
</div>







  <!-- Cart Modal -->
  <div class="modal fade" id="smallmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 600px; width: 95%; margin: 10px auto;">
      <div class="modal-content" style="border-radius: 15px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15); overflow: hidden;">
        
        <!-- Modal Header -->
        <div class="modal-header" style="background: linear-gradient(135deg, #4CBB17 0%, #45a716 100%); color: white; border-top-left-radius: 15px; border-top-right-radius: 15px; padding: 15px 20px;">
          <div>
            <h5 class="modal-title" style="font-size: 20px; font-weight: 600; margin-bottom: 3px;">Your Cart</h5>
            <p style="margin: 0; font-size: 14px; opacity: 0.8;">
              <i class="fas fa-utensils mr-1"></i> <span id="RestaurantName"></span>
            </p>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white; opacity: 1; text-shadow: none;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <!-- Modal Body -->
        <div class="modal-body" style="padding: 0; max-height: 70vh; overflow-y: auto;">
          <!-- Booking Info -->
          <div style="padding: 15px 20px; background-color: #f8f9fa; border-bottom: 1px solid #eee;">
            <div style="display: flex; align-items: center;">
              <div style="width: 36px; height: 36px; border-radius: 50%; background-color: rgba(76, 187, 23, 0.1); display: flex; align-items: center; justify-content: center; margin-right: 12px;">
                <i class="fas fa-calendar-check" style="color: #4CBB17; font-size: 16px;"></i>
              </div>
              <div>
                <p style="margin: 0; font-size: 12px; color: #666; font-weight: 500;">Booking Reference</p>
                <p style="margin: 0; font-size: 14px; color: #333; font-weight: 600;">#<span id="ReservationID"></span></p>
              </div>
            </div>
          </div>
          
          <!-- Cart Items -->
          <div style="padding: 15px 20px;">
            <h6 style="font-size: 14px; font-weight: 600; color: #666; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 0.5px;">
              Order Items
            </h6>
            
            <div id="emptyCartMessage" style="text-align: center; padding: 30px 20px; display: none;">
              <div style="width: 80px; height: 80px; border-radius: 50%; background-color: #f8f9fa; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px auto;">
                <i class="fas fa-shopping-cart" style="font-size: 36px; color: #e0e0e0;"></i>
              </div>
              <p style="color: #999; font-size: 14px;">Your cart is empty</p>
              <button onclick="$('#smallmodal').modal('hide');" class="btn btn-sm" style="background-color: #f0f0f0; color: #666; border: none; border-radius: 20px; padding: 5px 15px; font-size: 12px; margin-top: 10px;">
                Continue Browsing
              </button>
            </div>
            
            <div id="cartItemsContainer">
              <div class="table-responsive">
                <table class="table" style="margin-bottom: 0;">
                  <thead>
                    <tr>
                      <th style="font-size: 13px; font-weight: 600; color: #666; border-top: none; padding: 8px;">Item</th>
                      <th style="font-size: 13px; font-weight: 600; color: #666; border-top: none; padding: 8px; text-align: center;">Qty</th>
                      <th style="font-size: 13px; font-weight: 600; color: #666; border-top: none; padding: 8px; text-align: right;">Price</th>
                      <th style="font-size: 13px; font-weight: 600; color: #666; border-top: none; padding: 8px; text-align: right;">Subtotal</th>
                      <th style="font-size: 13px; font-weight: 600; color: #666; border-top: none; padding: 8px; width: 40px;"></th>
                    </tr>
                  </thead>
                  <tbody id="cartItemsBody">
                    <!-- Cart items will be populated here -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          
          <!-- Order Summary -->
          <div style="background-color: #f8f9fa; padding: 15px 20px; border-top: 1px solid #eee;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
              <span style="font-size: 14px; color: #666;">Subtotal</span>
              <span style="font-size: 14px; color: #333; font-weight: 500;">$<span id="subtotalAmount">0.00</span></span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 5px;">
              <span style="font-size: 14px; color: #666;">Tax</span>
              <span style="font-size: 14px; color: #333; font-weight: 500;">$<span id="taxAmount">0.00</span></span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 10px; border-top: 1px dashed #ddd; margin-top: 10px;">
              <span style="font-size: 16px; color: #333; font-weight: 600;">Total</span>
              <span style="font-size: 18px; color: #4CBB17; font-weight: 700;">$<span id="totalAmount">0.00</span></span>
            </div>
          </div>
        </div>
        
        <!-- Modal Footer -->
        <div class="modal-footer" style="border-top: none; padding: 15px 20px; display: flex; justify-content: space-between;">
          <button type="button" class="btn" data-dismiss="modal" style="background-color: #f1f2f3; color: #666; border: none; border-radius: 50px; padding: 8px 20px; font-size: 14px; font-weight: 600;">
            <i class="fas fa-arrow-left mr-2"></i> Continue Shopping
          </button>
          <button type="button" class="btn" onclick="placeOrder(<?php echo $activeReservationRestaurant; ?>, <?php echo $_SESSION['ReservationID']; ?>)" style="background: linear-gradient(135deg, #4CBB17 0%, #45a716 100%); color: white; border: none; border-radius: 50px; padding: 8px 20px; font-size: 14px; font-weight: 600; box-shadow: 0 4px 15px rgba(76, 187, 23, 0.3);">
            <i class="fas fa-check mr-2"></i> Place Order
          </button>
        </div>
      </div>
    </div>
  </div>




  <div id="toast" style="
    position: fixed;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #4CBB17;
    color: #fff;
    padding: 15px;
    border-radius: 5px;
    display: none;
    z-index: 1000;
    font-size: 16px;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
"></div>







  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    $(document).ready(function() {
      // Update cart count on page load
      updateCartCount();
      
      // Update cart when modal is shown
      $('#smallmodal').on('show.bs.modal', function() {
          updateCartModal();
      });

      function updateCartModal() {
        $.ajax({
          url: 'get_cart.php',
          method: 'GET',
          dataType: 'json',
          success: function(data) {
            $('#RestaurantName').text(data.restaurantName);
            $('#ReservationID').text(data.reservationID);

            var cartItemsBody = $('#cartItemsBody');
            cartItemsBody.empty();

            var total = 0;
            var itemCount = 0;
            
            // Check if cart is empty
            if (!data.items || data.items.length === 0) {
              $('#emptyCartMessage').show();
              $('#cartItemsContainer').hide();
            } else {
              $('#emptyCartMessage').hide();
              $('#cartItemsContainer').show();
              
              $.each(data.items, function(index, item) {
                var subtotal = item.price * item.quantity;
                total += subtotal;
                itemCount += parseInt(item.quantity);

                cartItemsBody.append('<tr>' +
                  '<td style="font-size: 14px; color: #333; font-weight: 500;">' + item.name + '</td>' +
                  '<td style="font-size: 14px; text-align: center;">' + item.quantity + '</td>' +
                  '<td style="font-size: 14px; text-align: right;">$' + item.price.toFixed(2) + '</td>' +
                  '<td style="font-size: 14px; font-weight: 500; text-align: right;">$' + subtotal.toFixed(2) + '</td>' +
                  '<td><button class="btn" style="padding: 2px 8px; background-color: #f8f9fa; color: #dc3545; border: none; border-radius: 50%;" onclick="removeFromCart(' + item.id + ')"><i class="fas fa-times"></i></button></td>' +
                  '</tr>');
              });
            }

            // Calculate tax (assuming 8% tax rate)
            var tax = total * 0.08;
            var finalTotal = total + tax;
            
            // Update all amount fields
            $('#subtotalAmount').text(total.toFixed(2));
            $('#taxAmount').text(tax.toFixed(2));
            $('#totalAmount').text(finalTotal.toFixed(2));
            
            // Update cart count badge
            updateCartBadge(itemCount);
          }
        });
      }
      
      // Function to update cart count
      function updateCartCount() {
        $.ajax({
          url: 'get_cart.php',
          method: 'GET',
          dataType: 'json',
          success: function(data) {
            var itemCount = 0;
            $.each(data.items, function(index, item) {
              itemCount += parseInt(item.quantity);
            });
            updateCartBadge(itemCount);
          }
        });
      }

      // Handle the place order button click
    });

    // Remove from cart function
    function removeFromCart(itemIndex) {
      $.ajax({
        url: 'remove_from_cart.php',
        method: 'POST',
        data: {
          itemID: itemIndex
        },
        success: function(response) {
          updateCartModal();
          // Don't close the modal, just update it
          // Update cart count
          updateCartCount();
        }
      });
    }
  </script>


  <script>
    function placeOrder(restaurantID, reservationID) {
      // Redirect to place_order.php with RestaurantID and ReservationID in URL
      window.location.href = `place_order.php?RestaurantID=${restaurantID}&ReservationID=${reservationID}`;
    }
  </script>







  <!-- <br>
  <br><br>
  <br>
  <br>
  <h3 class=" mb-4" style="margin-left: 5%;">Our top cities</h3>
  <img src="Resources/Our Top Cities.png" style="margin-left: 50px;" alt="Restaurant Image">
  <br>
  <br>
  <br><br>
  <br>
  <img src="Resources/Menu + Subscription.png" style="margin-left: 50px;" alt="Restaurant Image"> -->
  


  <script>
    // Function to open tab content
    function openTab(tabName) {
      // Remove active class from all tab buttons
      var tabs = document.getElementsByClassName('tab-btn');
      for (var i = 0; i < tabs.length; i++) {
        tabs[i].classList.remove('active');
      }

      // Hide all tab content
      var tabContents = document.getElementsByClassName('tab-content');
      for (var i = 0; i < tabContents.length; i++) {
        tabContents[i].classList.remove('active');
        tabContents[i].style.display = 'none';
      }

      // Show the selected tab
      document.getElementById(tabName).classList.add('active');
      document.getElementById(tabName).style.display = 'block';

      // Add active class to the corresponding tab button
      document.getElementById('tab-' + tabName).classList.add('active');
    }


    function scrollToCheckout(tableID, TableID2, isLoggedIn) {
    if (!isLoggedIn) {
      Swal.fire({
        icon: 'warning',
        title: 'Please Log in first to book a table.',
        confirmButtonColor: '#4CBB17'
      });
      return;
    }

    // Check last reservation time before proceeding
    $.ajax({
      url: 'fetch_last_reservation.php',
      method: 'GET',
      dataType: 'json',
      success: function(response) {
        // Debug information
        console.log('Last reservation response:', response);
        console.log('Last reservation time:', response.lastReservation);
        console.log('Minutes since last reservation:', response.minutesSince);
        console.log('Can book?', response.canBook);
        
        if (response.status === 'success') {
          if (!response.canBook) {
            // Less than 60 minutes since last reservation
            Swal.fire({
              icon: 'warning',
              title: 'Booking Limit Reached',
              text: 'You cannot create another booking now. Please try again later...',
              confirmButtonColor: '#4CBB17'
            });
          } else {
            // More than 60 minutes have passed or no previous reservation
            var TableID = document.getElementById('TableID');
            if (TableID) {
              TableID.value = TableID2;
              var tableTextbox = document.getElementById('selected-table');
              tableTextbox.value = tableID;

              // Open the checkout modal
              $('#checkoutModal').modal('show');
            }
          }
        } else {
          console.error('Error checking reservation status:', response.message);
        }
      },
      error: function(xhr, status, error) {
        console.error('AJAX error:', error);
        // Fall back to showing the modal in case of error
        var TableID = document.getElementById('TableID');
        if (TableID) {
          TableID.value = TableID2;
          var tableTextbox = document.getElementById('selected-table');
          tableTextbox.value = tableID;
          $('#checkoutModal').modal('show');
        }
      }
    });
  }
  </script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const activeBookingBanner = document.getElementById('active-booking-banner');

      if (activeBookingBanner) {
        activeBookingBanner.addEventListener('click', function() {
          window.location.href = 'Confirmation.php?ID=<?php echo $activeReservation; ?>';
        });
      }
    });
  </script>


</body>
<script>
  function addToCart(itemID, restaurantID1) {
    // Check if there is an active reservation
    const isReservationActive = <?php echo isset($isReservationActive) && $isReservationActive === 'Yes' ? 'true' : 'false'; ?>;
    const activeReservationRestaurant = <?php echo isset($activeReservationRestaurant) ? $activeReservationRestaurant : '0'; ?>;
    
    if (itemID == 'X') {
      itemID = document.getElementById('menuItemID').innerHTML;
    }
    if (restaurantID1 == 'X') {
      restaurantID1 = document.getElementById('menurestaurantID').innerHTML;
    }
    
    // Convert restaurantID1 to a number for comparison
    const restaurantIDNum = parseInt(restaurantID1);
    
    // Check if user has an active reservation at this restaurant
    if (!isReservationActive) {
      $('#menumodal').modal('hide');
      Swal.fire({
        icon: 'warning',
        title: 'No Active Booking',
        text: 'You do not have an active booking at this restaurant at the moment.',
        confirmButtonColor: '#4CBB17'
      });
      return;
    }
    
    // Check if the active reservation is for this restaurant
    if (activeReservationRestaurant !== restaurantIDNum) {
      $('#menumodal').modal('hide');
      Swal.fire({
        icon: 'warning',
        title: 'Wrong Restaurant',
        text: 'You do not have an active booking at this restaurant at the moment.',
        confirmButtonColor: '#4CBB17'
      });
      return;
    }
    
    // Get selected side items
    let selectedSides = [];
    $('.form-check-input:checked').each(function() {
      selectedSides.push($(this).val()); // Get the value (ItemID) of each checked checkbox
    });

    $('#menumodal').modal('hide'); // Close the modal

    $.ajax({
      url: 'add_to_cart.php',
      method: 'GET',
      data: {
        itemID: itemID,
        RestaurantID: restaurantID1, // Pass RestaurantID in the request
        sides: selectedSides // Pass selected side items as an array
      },
      dataType: 'json', // Expect JSON response from server
      success: function(response) {
        if (response.message && response.cartCount) {
          // Update and display the toast with item name and total count
          showToast(response.message + " Total Items: " + response.cartCount);
          // Update the cart count badge
          updateCartBadge(response.cartCount);
        }
      },
      error: function(xhr, status, error) {
        console.log('Error adding item to cart:', xhr.responseText);
        showToast('Error adding item to cart: ' + error);
      }
    });
  }



  function showToast(message) {
    var toast = document.getElementById('toast');
    toast.innerText = message;
    toast.style.display = 'block';

    setTimeout(function() {
      toast.style.display = 'none';
    }, 5000);
  }
  
  function updateCartBadge(count) {
    var cartCount = document.getElementById('cartCount');
    if (cartCount) {
      if (count > 0) {
        cartCount.textContent = count;
        cartCount.style.display = 'flex';
      } else {
        cartCount.style.display = 'none';
      }
    }
  }
</script>



<script>
  function openMenuModal(itemID, name, image, description, price, restaurantID) {
    console.log('openMenuModal called with:', itemID, name, restaurantID);
    
    // Set the modal fields
    document.getElementById('menuItemID').innerHTML = itemID;
    document.getElementById('menurestaurantID').innerHTML = restaurantID;
    document.getElementById('menuItemName').innerHTML = name;
    document.getElementById('menuItemImage').src = 'images/' + image;
    document.getElementById('menuItemDescription').innerHTML = description;
    document.getElementById('menuItemPrice').innerHTML = price;

    // Reset quantity to 1
    document.getElementById('quantityInput').value = 1;

    // Fetch sides (Type = 'Side')
    fetchSides(restaurantID);

    // Show the modal
    console.log('Attempting to show modal...');
    $('#menumodal').modal('show');
    
    // Check if modal is visible after a short delay
    setTimeout(function() {
      if ($('#menumodal').hasClass('show')) {
        console.log('Modal is now visible');
      } else {
        console.log('Modal failed to show, trying alternative method');
        $('#menumodal').modal('show');
      }
    }, 500);
  }

  function fetchSides(restaurantID) {
    // Perform an AJAX request to get sides
    $.ajax({
      url: 'fetch_sides.php', // This PHP script will return the sides
      type: 'GET',
      data: {
        ID: restaurantID
      }, // Pass RestaurantID
      success: function(data) {
        // Populate the mealSides div with the checkbox list
        document.getElementById('mealSides').innerHTML = data;
       // alert(data);
      },
      error: function(error) {
        console.log("Error fetching sides:", error);
      }
    });
  }


  function decreaseQuantity() {
    let qtyInput = document.getElementById('quantityInput');
    let qty = parseInt(qtyInput.value);
    if (qty > 1) {
      qtyInput.value = qty - 1;
    }
  }

  function increaseQuantity() {
    let qtyInput = document.getElementById('quantityInput');
    qtyInput.value = parseInt(qtyInput.value) + 1;
  }
</script>

<script>
  function checkTableID(event) {
    const tableID = document.getElementById("TableID").value;
    const RID = document.getElementById("RestaurantID").value;
 //const selectedTable = document.getElementById("selectedTable").value;
    if (!tableID || !RID) {
      event.preventDefault(); // Prevent form submission
      Swal.fire({
        icon: 'warning',
        title: 'Table Required',
        text: 'Please select a table first.',
        confirmButtonText: 'OK',
          confirmButtonColor: '#4CBB17'
      });
    }
  }

  function scrollToSection() {
  const section = document.getElementById('sectiontab');
  if (section) {
    section.scrollIntoView({ behavior: 'smooth' });
  } else {
    console.error("Element with ID 'sectiontab' not found.");
  }
}
</script>


</html>