<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
    <meta name="description" content="FoodnPals">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">

  <title>Customer Profile</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/banner.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <!-- Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon.png">


  <link rel="stylesheet" href="assets/css/footer.css">

  <link rel="stylesheet" href="assets/css/style.css">

  <style>
    /* Responsive container */
    .row {
        margin: 0;
        padding: 15px;
    }

    /* Responsive spacing */
    @media (max-width: 768px) {
        .row {
            padding: 10px;
        }
        
      #div1, #div2 {
            margin: 10px auto !important;
            width: calc(100% - 20px) !important;
        }

        .card-body {
            padding: 15px !important;
        }

        .col-12 {
            padding: 0;
        }
    }

    /* Custom CSS styles */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 10px 20px;
      background-color: white;
    }

    .logo {
      width: 100px;
      height: auto;
    }

    .menu-bar {
      display: flex;
    }

    .signup-button {
      color: white;
      background-color: #4cbb17;
      border: 1px solid #4cbb17;
      border-radius: 5px;
      padding: 10px 20px;
      margin-left: 10px;
      cursor: pointer;
    }

    .login-button {
      background-color: white;
      color: #4cbb17;
      border: 1px solid #4cbb17;
      border-radius: 5px;
      padding: 10px 20px;
      margin-left: 10px;
      cursor: pointer;
    }

    .login-button:hover,
    .signup-button:hover {
      background-color: #2cda60;
      /* Change color on hover */
    }

    /* Responsive Pagination */
    .pagination {
      flex-wrap: wrap;
      justify-content: center;
    }

    @media (max-width: 480px) {
      .pagination .page-link {
        padding: .25rem .5rem;
        font-size: .875rem;
      }
    }
  </style>
</head>

<body>
<?php
        // Enable error reporting for debugging
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        include 'fetch_cookies.php';
        include 'fetch_userdata.php';
        include 'check_profile_image.php';
        ?>

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
  <?php echo getProfileImageHtml($profilePictureURL); ?>
  <p style="font-size: 20px; color: #4cbb17;"></p>
  </a>
  <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
  <a class="dropdown-item" href="CustomerProfile.php">Profile</a>
    <a class="dropdown-item" href="CustomerBookings.php">Bookings </a>
    <a class="dropdown-item" href="CustomerReviews.php">Reviews </a>
    <div class="dropdown-divider"></div>
    <a class="dropdown-item" href="CustomerDeletion.php" style="color: #d9534f;">Delete Account</a>
    <div class="dropdown-divider"></div>
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



  <section class="row">
    <div id="div1" class="col-12 col-md-3 col-lg-2" style="margin: 0 auto 20px auto; border-radius: 10px; background-color: #f9f9f9;">
      <?php 
        include 'sidebar_menu.php';
        echo renderSidebarMenu('orders');
      ?>
    </div>



    <div id="div2" class="col-12 col-md-8 col-lg-9" style="margin: 0 auto; border-radius: 10px; background-color: #f9f9f9;">
    <h4 style="color: #4cbb17; margin-top: 10px; margin-left: 2%;">Your Orders</h4>
    <div class="card-body">
        <div class="row">
            <?php include 'OrdersGrid.php'; ?>
        </div>
    </div>
</div>

  </section>

  <br /><br />
  <br>
  <br>
  <br>
  <?php include 'footer.php'; ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- Order Details Section -->


</body>


</html>