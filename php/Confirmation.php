<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
    <meta name="description" content="FoodnPals">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">

  <title>FoodnPals - Booking</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/banner.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="assets/css/footer.css">
  <!-- Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon.png">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   <link rel="stylesheet" href="assets/css/Explore.css">
  <?php include 'fetch_cookies.php' ?>

  <style>

    .action-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  margin-bottom: 8px;
  padding: 10px 15px;
  background-color: #4cbb17;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  text-align: center;
  font-weight: 500;
  transition: all 0.2s ease;
  gap: 8px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.action-btn:hover {
  background-color: #45a716;
  transform: translateY(-1px);
  box-shadow: 0 4px 6px rgba(0,0,0,0.15);
}

.action-btn i {
  font-size: 16px;
}

.star-rating {
  display: flex;
  flex-direction: row; /* Changed from row-reverse to row */
  justify-content: center;
}


    @media (max-width: 768px) {
      .footer {
          display: none;
      }
      
      #div1, #div2 {
          padding: 15px !important;
          width: calc(100% - 20px) !important;
      }

      .modal-body {
          /* padding: 15px !important; */
      }

      .action-btn {
          font-size: 14px;
          padding: 8px 12px;
      }

      iframe {
          height: 300px !important;
      }

      .star-rating label {
          font-size: 3em !important;
      }

      /* Order details table responsive */
      .order-details {
          padding: 15px !important;
      }

      .order-details table {
          font-size: 14px;
      }

      .order-details th,
      .order-details td {
          padding: 10px 8px !important;
      }

      .order-details th:nth-child(5),
      .order-details td:nth-child(5) {
          display: none; /* Hide instructions column on mobile */
      }
    }

    /* Tablet view */
    @media (min-width: 769px) and (max-width: 1024px) {
      #div1, #div2 {
          margin: 15px !important;
      }
    }
    
    @media (max-width: 1024px) {
      .section-toggle {
        cursor: pointer;
        display: flex;
        justify-content: space-between;
        align-items: center;
        user-select: none;
      }
      .collapsible-content {
        display: none;
      }
      .collapsible-content.show {
        display: block;
      }
      .toggle-icon {
        font-weight: bold;
        font-size: 24px;
        padding-right: 10px;
      }
    }


    .star-rating input {
      display: none;
    }

    .star-rating label {
      font-size: 4em;
      color: #ddd;
      cursor: pointer;
      transition: color 0.2s;
    }

    .star-rating input:checked~label {
      color: #f5a623;
    }

    .star-rating input:hover~label {
      color: #f5a623;
    }

    .star-rating label:hover~label {
      color: #f5a623;
    }

    /* Custom CSS styles */
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      /* Align items vertically */
      padding: 10px 20px;
      background-color: white;
    }

    .logo {
      width: 100px;
      /* Adjust as needed */
      height: auto;
    }

    .banner {
      height: 60vh;
      /* 30% of screen height */
      background-image: url("Resources/e1.png");
      background-size: cover;
      background-position: center;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      color: white;
    }

    .location-form {
      margin-top: 10px;
      text-align: center;
    }

    .collections {
      height: 20vh;
      /* 10% of screen height */
      display: flex;
      justify-content: space-around;
      align-items: center;
    }

    .collection-item img {
      width: 120px;
      /* Adjust width as needed */
      height: auto;
    }

    .label {
      text-align: center;
      margin-top: 5px;
      /* Adjust spacing as needed */
      font-weight: bold;
      font-size: 14px;
      /* Adjust font size as needed */
      color: #333;
      /* Adjust color as needed */
    }

    .location-form {
      background-color: white;
      border-radius: 10px;
      /* Adjust border radius as needed */
      padding: 10px;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      display: flex;
      /* Add this line */
      align-items: center;
      /* Add this line */
    }

    .location-input {
      position: relative;
      flex: 1;
      /* Add this line */
      margin-right: 10px;
      /* Add this line for spacing between input and button */
    }

    .location-input input {
      padding-left: 30px;
      /* Space for the icon */
      border: none;
      border-radius: 5px;
      /* Adjust border radius as needed */
      width: 300px;
      /* Adjust width as needed */
      height: 40px;
      /* Adjust height as needed */
    }

    .location-icon {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      left: 10px;
      /* Adjust icon position as needed */
      width: 20px;
      /* Adjust icon size as needed */
      height: auto;
    }

    .search-button {
      background-color: #4cbb17;
      color: white;
      border: none;
      border-radius: 5px;
      /* Adjust border radius as needed */
      padding: 10px 20px;
      /* Adjust padding as needed */
      cursor: pointer;
    }

    .menu-bar {
      display: flex;
    }

    .signup-button {
      color: white;
      background-color: #4cbb17;
      /* Same color as specified for buttons */
      border: 1px solid #4cbb17;
      /* Same color as specified for buttons */
      border-radius: 5px;
      padding: 10px 20px;
      margin-left: 10px;
      /* Adjust spacing between buttons */
      cursor: pointer;
    }

    .login-button {
      background-color: white;
      color: #4cbb17;
      /* Same color as specified for buttons */
      border: 1px solid #4cbb17;
      /* Same color as specified for buttons */
      border-radius: 5px;
      padding: 10px 20px;
      margin-left: 10px;
      /* Adjust spacing between buttons */
      cursor: pointer;
    }

    .login-button:hover,
    .signup-button:hover {
      background-color: #2cda60;
      /* Change color on hover */
    }

    .discover-title {
      display: block;
      /* Ensure the element is displayed */
    }

    @media (max-width: 768px) {

      /* Adjust max-width as needed for mobile view */
      .discover-title {
        display: none;
        /* Hide the element in mobile view */
      }
      .footer {
        display: none;
      }
    }

    /* Restaurant Grid */
    .restaurants-grid {
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      /* 5 columns */
      grid-gap: 20px;
      /* Adjust the gap between items */
      padding: 30px;
      padding-top: 0px;
    }

    .restaurant-image img {
      width: 100%;
      /* Adjust width as needed */
      height: auto;
      margin-bottom: 10px;
    }

    .restaurant {
      display: flex;
      flex-direction: column;
      align-items: center;
      margin-bottom: 20px;
    }

    .restaurant-details {
      display: flex;
      align-items: center;
    }

    .restaurant-icon img {
      width: 50px;
      /* Adjust width as needed */
      height: auto;
      margin-right: 10px;
    }

    .restaurant-name,
    .restaurant-type,
    .restaurant-rating {
      margin: 0;
      font-size: large;
    }

    .restaurant-info {
      display: flex;
      align-items: center;
    }

    .restaurant-type {
      display: flex;
      align-items: center;
      color: #797979;
    }

    .restaurant-rating {
      margin: 0;
      color: #797979;

      border-radius: 10px;
    }

    /* Tab styles */
    .tabs {
      display: flex;
      margin-top: 20px;
      margin-left: 40px;
    }

    .tab-btn {
      background-color: #f8f9fa;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
      margin-right: 10px;
    }

    .tab-btn.active {
      color: #4cbb17;
    }

    /* Tab content styles */
    .tab-content {
      display: none;
      padding: 20px;
      border: 1px solid #ddd;
    }

    .tab-content.active {
      display: block;
    }

    /* Grid styles */
    .grid-container {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      grid-gap: 20px;
      margin-top: 20px;
      margin-left: 40px;
      width: 60%;
    }

    .grid-item {
      background-color: #f8f9fa;
      border-radius: 5px;
      border-radius: 15px;
    }

    .grid-item img {
      float: right;
    }

    /* Table title styles */
    .table-title {
      font-weight: bold;
      margin-bottom: 10px;
      margin-top: 10px;
    }

    /* Table description styles */
    .table-description {
      color: #777;
      margin-bottom: 10px;
    }

    .table-title,
    .table-description {
      padding-left: 25px;
      padding-top: 0px;
    }

    /* Select button styles */
    .select-button {
      background-color: transparent;
      color: #11be45;
      border: none;
      border-radius: 5px;
      margin-top: 10px;
      margin-left: 25px;
      cursor: pointer;
      font-weight: bold;
    }
  </style>
</head>

<body style="margin:0px; padding:0px;">
  <?php include 'fetch_reservation.php'; ?>
  <?php include 'fetch_order.php'; // Include the script to fetch order details 
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

  <section class="row" style="margin:0px; padding:15px;"> 
    <div id="div1" class="col-12 col-sm-12 col-md-6 col-lg-3" style="margin: 0 auto 20px auto; min-height: 550px; border-radius: 10px; background-color: #f9f9f9; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
      <h4 class="section-toggle" style="padding: 20px; margin-bottom: 0;">Booking Details</h4>
      <div class="collapsible-content show">
        <div class="modal-body" style="padding: 20px;">
          <p style="font-family: 'Arial', sans-serif; font-size: 18px; color: #333; line-height: 1.5;">
            <?php
            $status = htmlspecialchars($reservation['Status']);
            $iconSvg = '';
            $statusColor = '';

            switch ($status) {
              case 'Pending':
                // Clock/Pending icon in orange
                $iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <circle cx="12" cy="12" r="10" stroke="#FFA500" stroke-width="2"/>
            <path d="M12 6v6l4 2" stroke="#FFA500" stroke-width="2" stroke-linecap="round"/>
        </svg>';
                $statusColor = '#FFA500';
                break;
              case 'Extension Requested':
                // Clock/Pending icon in orange
                $iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor">
              <circle cx="12" cy="12" r="10" stroke="#FFA500" stroke-width="2"/>
              <path d="M12 6v6l4 2" stroke="#FFA500" stroke-width="2" stroke-linecap="round"/>
          </svg>';
                $statusColor = '#FFA500';
                break;

              case 'Accepted':
                // Checkmark in green circle
                $iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="10" fill="#4CBB17"/>
            <path d="M8 12l3 3l6-6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>';
                $statusColor = '#4CBB17';
                break;

                case 'Completed':
                  // Checkmark in green circle
                  $iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none">
              <circle cx="12" cy="12" r="10" fill="#4CBB17"/>
              <path d="M8 12l3 3l6-6" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>';
                  $statusColor = '#4CBB17';
                  break;

              case 'Declined':
                // X mark in red circle
                $iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="10" fill="#FF0000"/>
            <path d="M15 9l-6 6 M9 9l6 6" stroke="white" stroke-width="2" stroke-linecap="round"/>
        </svg>';
                $statusColor = '#FF0000';
                break;

              case 'Cancelled':
                // X mark in red circle
                $iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="12" r="10" fill="#FF0000"/>
            <path d="M15 9l-6 6 M9 9l6 6" stroke="white" stroke-width="2" stroke-linecap="round"/>
        </svg>';
                $statusColor = '#FF0000';
                break;

              case 'No Show':
                // X mark in red circle
                $iconSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="55" height="55" viewBox="0 0 24 24" fill="none">
              <circle cx="12" cy="12" r="10" fill="#FF0000"/>
              <path d="M15 9l-6 6 M9 9l6 6" stroke="white" stroke-width="2" stroke-linecap="round"/>
          </svg>';
                $statusColor = '#FF0000';
                break;
            }
            ?>

          <div style="display: flex; align-items: center; gap: 8px;">

          <?php echo $iconSvg; ?>
            <label id="status1" style="font-size: 20px; font-weight: bold; color: <?php echo $statusColor; ?>">
              Booking <?php echo $status; ?>
            </label>
          </div> 
          <br>
          <div style="display: flex; align-items: center; margin-bottom: 20px;">
            <img style="height: 70px; width: 70px; border-radius: 50%; object-fit: cover; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" src="<?php echo 'Resources/icons/' . (!empty($reservation['RestaurantIcon']) && file_exists('Resources/icons/' . $reservation['RestaurantIcon']) ? htmlspecialchars($reservation['RestaurantIcon']) : 'r2.png'); ?>" />
            <div style="margin-left: 15px;">
              <span style="font-size: 20px; font-weight: bold; color: black; display: block;"><?php echo htmlspecialchars($reservation['RestaurantName']); ?></span>
              <span style="font-size: 14px; color: #666; display: block;">Table #<?php echo htmlspecialchars($reservation['TableNumber']); ?></span>
            </div>
          </div>

          <div style="width: 100%; background: #f5f5f5; border-radius: 8px; padding: 1px; margin-bottom: 20px;">
            <div style="display: flex; align-items: center; margin-bottom: 12px;">
              <span style="font-size: 15px; color: #797979; margin-left: 10px;">Booking ID:</span>
              <span style="font-weight: 600; margin-left: 5px;"><?php echo htmlspecialchars($reservation['ReservationID']); ?></span>
            </div>
            
            <div style="display: flex; align-items: center; margin-bottom: 12px;">
              <span style="font-size: 15px; color: #797979; margin-left: 10px;">Customer:</span>
              <span style="font-weight: 600; margin-left: 5px;"><?php echo htmlspecialchars($reservation['UserFirstName'] . " " . $reservation['UserLastName']); ?></span>
            </div>
          <!-- <span style="font-size: 16px; color: #797979">Guests:</span>
          <span style="font-weight: bold"><?php echo htmlspecialchars($reservation['NumberofGuests']); ?></span>
          <br /> -->
            <div style="display: flex; align-items: center; margin-bottom: 12px;">
              <span style="font-size: 15px; color: #797979; margin-left: 10px;">Address:</span>
              <?php
                $addr = htmlspecialchars($reservation['RestaurantAddress']);
                $short = strlen($addr) > 35 ? substr($addr, 0, 35) . '...' : $addr;
              ?>
              <span style="font-weight: 600; margin-left: 5px; flex: 1;" title="<?= $addr ?>">
                <?= $short ?>
              </span>
            </div>

            <div style="display: flex; align-items: center;">
              <span style="font-size: 15px; color: #797979; margin-left: 10px;">Est. Time:</span>
              <span style="font-weight: 600; margin-left: 5px;"><?php echo htmlspecialchars($duration); ?></span>
            </div>
          </div>
          </p>

          <div style="display: flex; align-items: center; gap: 10px; ">
            <a href="tel:<?php echo $PhoneNumber; ?>" 
              style="display: flex; align-items: center; justify-content: center; width: 50px; height: 50px; background-color: #4CBB17; border-radius: 50%; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2); cursor: pointer; text-decoration: none; transition: transform 0.2s, box-shadow 0.2s;" 
              onmouseover="this.style.transform='scale(1.1)'; this.style.boxShadow='0px 6px 8px rgba(0, 0, 0, 0.3)';" 
              onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0px 4px 6px rgba(0, 0, 0, 0.2)';" 
              title="Call Now">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width: 20px; height: 20px; fill: white;">
                <path d="M6.62 10.79a15.053 15.053 0 006.59 6.59l2.2-2.2a1.003 1.003 0 011.11-.24c1.12.45 2.33.69 3.58.69.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h2.5c.55 0 1 .45 1 1 0 1.25.24 2.46.69 3.58.13.35.05.74-.24 1.02l-2.2 2.2z"/>
              </svg>
            </a>
            <p style="font-size: 1rem; margin: 0; color: #333;">For Queries Call Restaurant</p>
          </div>
       
          <div style="display: flex; flex-direction: column; gap: 10px; padding: 15px 10px;">
<!-- Order Food -->
<?php if ($status == "Accepted" && (!isset($orders) || empty($orders))): ?>
  <?php if ($status != "Completed"): ?>
    <button class="action-btn" onclick="window.location.href='Profile.php?ID=<?php echo $reservation['RestaurantID']; ?>&menu=1';">
      <i class="fas fa-utensils"></i>
      Order Food
    </button>
  <?php endif; ?>
<?php endif; ?>

<!-- Request Extension -->
<?php if ($reservation['ExtensionReason'] != "" && $status == "Accepted"): ?>
  <button class="action-btn" data-toggle="modal" data-target="#smallmodal">
    <i class="fas fa-clock"></i>
    Request Extension
  </button>
<?php endif; ?>

<?php if ($status == "Completed"): ?>
  <button class="action-btn" data-toggle="modal" data-target="#ReviewModal">
    <i class="fas fa-star"></i>
    Write a Review
  </button>
<?php endif; ?>

<!-- Complete Booking -->
<?php if ($status == "Accepted" && ($status != "Completed")): ?>
  <button class="action-btn" id="CompleteBooking">
    <i class="fas fa-check-circle"></i>
    Complete Booking
  </button>
<?php endif; ?>

</div>






        <br><br>

        </div>
      </div>
    </div>

    <div id="div2" class="col-12 col-sm-12 col-md-6 col-lg-8" style="margin: 0 auto; min-height: 550px; border-radius: 10px; background-color: #f9f9f9; box-shadow: 0 2px 4px rgba(0,0,0,0.1); padding: 20px;">
      <h4 class="mb-3 section-toggle">Map & Address</h4>
      <div class="collapsible-content <?php if ($status !== 'Completed') echo 'show'; ?>">
        <div style="border-radius: 10px; overflow: hidden; width:100%;">
          <?php  if (!empty($directionsURL) && ($status == 'Pending' || $status == 'Accepted' || $status == 'Extension Requested')): ?>
            <iframe src="<?php echo $directionsURL; ?>" width="100%" height="400px" style="border: 0" allowfullscreen="" loading="lazy"></iframe>
            
            <!-- Button to send directions to Maps Apps -->
            <div style="margin-top: 10px; text-align: center;">
                <button id="carplayAndroidBtn" class="action-btn" style="display:none;" onclick="openInMaps('<?php echo $directionsURL; ?>')">
                    <i class="fas fa-map-marker-alt"></i> <span id="carplayAndroidBtnText"></span>
                </button>
            </div>
          <?php else: ?>
            <p>No directions available.</p>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>




  <!-- Order Details Section -->

  <section class="row" style="margin: 20px auto; padding: 20px; max-width: 95%; max-width: 900px; overflow-x: hidden;">
    <?php if (isset($orders) && !empty($orders)): ?>
      <div class="order-details" style="background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08); padding: 25px; width: 100%;">
        <h4 style="color: #333; font-size: 24px; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #f0f0f0;" class="section-toggle">
          Order Details
        </h4>
        <div class="collapsible-content show">
          <div style="overflow-x: auto; margin: 0 -10px;">
            <table style="width: 100%; border-collapse: separate; border-spacing: 0; min-width: 600px;">
              <thead style=" border-radius:10px;">
                <tr style="background: #4CBB17; color:white;">
                  <th style="padding: 15px; text-align: left; color: white; font-size: 14px; font-weight: 600; border-bottom: 2px solid #eee; width: 25%;">Menu Item</th>
                  <th style="padding: 15px; text-align: center; color: white; font-size: 14px; font-weight: 600; border-bottom: 2px solid #eee; width: 15%;">Quantity</th>
                  <th style="padding: 15px; text-align: left; color: white; font-size: 14px; font-weight: 600; border-bottom: 2px solid #eee; width: 15%;">Subtotal</th>
                  <th style="padding: 15px; text-align: left; color: white; font-size: 14px; font-weight: 600; border-bottom: 2px solid #eee;">Instructions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($orders as $order): ?>
                  <tr style="transition: background-color 0.2s ease;">
                    <td style="padding: 15px; border-bottom: 1px solid #eee; color: #444; font-weight: 500; width: 25%; max-width: 200px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                      <?php echo htmlspecialchars($order['Name']); ?>
                    </td>
                    <td style="padding: 15px; border-bottom: 1px solid #eee; color: #444; text-align: center;">
                      <span style="background: #f0f0f0; padding: 5px 10px; border-radius: 15px; font-size: 14px;">
                        <?php echo htmlspecialchars($order['Quantity']); ?>
                      </span>
                    </td>
                    <td style="padding: 15px; border-bottom: 1px solid #eee; color: #444; text-align: left;">
                      $<?php echo htmlspecialchars($order['Subtotal']); ?>
                    </td>
                    <td style="padding: 15px; border-bottom: 1px solid #eee; color: #666; font-size: 14px;">
                      <?php echo htmlspecialchars($order['Instructions']); ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

          <div style="margin-top: 25px; padding: 20px; background: #4CBB17; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; color:white;">
            <span style="font-size: 16px; color: white;">Total Amount</span>
            <span style="font-size: 24px; font-weight: 600; color: white;">
              $<?php echo htmlspecialchars($grandTotal); ?>/-
            </span>
          </div>
        </div>
      </div>
    <?php else: ?>
      <div hidden style="text-align: center; padding: 40px 20px; background: white; border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <circle cx="12" cy="12" r="10" />
          <line x1="12" y1="8" x2="12" y2="12" />
          <line x1="12" y1="16" x2="12" y2="16" />
        </svg>
        <p style="margin-top: 15px; color: #666; font-size: 16px;">No orders found for this Booking.</p>
      </div>
    <?php endif; ?>
  </section>




  <!-- Menu Modal -->
  <div style="min-width:320px; " class="modal fade" id="smallmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 700px; width: 100%;">
      <div class="modal-content" style="width: 100%; border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
        <!-- Modal Header -->
        <div class="modal-header" style="background: #f8f9fa; border-bottom: 1px solid #eee; border-radius: 15px 15px 0 0; padding: 20px 30px;">
          <div style="display: flex; align-items: center; gap: 10px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#4CBB17" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <circle cx="12" cy="12" r="10" />
              <polyline points="12 6 12 12 16 14" />
            </svg>
            <h2 style="margin: 0; color: #2c3e50; font-size: 24px; font-weight: 600;">Extension Request</h2>
          </div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background: none; border: none; font-size: 24px; opacity: 0.5; transition: opacity 0.2s;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body" style="padding: 30px; max-height: 500px; overflow-y: auto;">
          <form id="extensionRequestForm" action="ExtendReservation.php" method="POST">
            <!-- Extended Time Selection -->
            <input hidden id="RID1" name="RID1" value="<?php echo htmlspecialchars($reservation['RestaurantID']) . ""; ?>">
            <input hidden id="ResID2" name="ResID2" value="<?php echo htmlspecialchars($reservation['ReservationID']) . ""; ?>">
            <div style="margin-bottom: 25px;">
              <label for="extendedTime" style="display: block; margin-bottom: 10px; color: #2c3e50; font-weight: 500;">
                Extended Time Required
              </label>
              <div style="position: relative;">

                <select id="extendedTime" name="extendedTime" required style="width: 100%; padding: 12px 15px; border: 2px solid #e0e0e0; border-radius: 8px; appearance: none; background: white; font-size: 16px; color: #2c3e50; transition: border-color 0.2s;">
                  <option value="" disabled selected>Select time extension</option>
                  <option value="15">15 minutes</option>
                  <option value="30">30 minutes</option>
                </select>
                <div style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#666" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="6 9 12 15 18 9"></polyline>
                  </svg>
                </div>
              </div>
            </div>

            <!-- Reason Text Area -->
            <div style="margin-bottom: 25px;">
              <label for="reason" style="display: block; margin-bottom: 10px; color: #2c3e50; font-weight: 500;">
                Reason for Extension
              </label>
              <div style="border: 2px solid #e0e0e0; border-radius: 8px; overflow: hidden;">
                <div style="border-bottom: 1px solid #e0e0e0; padding: 8px; background: #f8f9fa;">
                  <button type="button" style="background: none; border: none; padding: 5px 10px; margin-right: 5px; cursor: pointer; color: #666;">
                    <strong>B</strong>
                  </button>
                  <button type="button" style="background: none; border: none; padding: 5px 10px; margin-right: 5px; cursor: pointer; color: #666;">
                    <i>I</i>
                  </button>
                  <button type="button" style="background: none; border: none; padding: 5px 10px; cursor: pointer; color: #666;">
                    <u>U</u>
                  </button>
                </div>
                <textarea id="reason" name="reason" required
                  style="width: 100%; min-height: 150px; padding: 15px; border: none; resize: vertical; font-size: 16px; color: #2c3e50; line-height: 1.5;"
                  placeholder="Please explain why you need additional time..."></textarea>
              </div>
              <div style="margin-top: 5px; font-size: 13px; color: #666;">
                Please provide a clear explanation for your extension request.
              </div>
            </div>
          </form>
        </div>

        <!-- Modal Footer -->
        <div class="modal-footer" style="border-top: 1px solid #eee; padding: 20px 30px; display: flex; justify-content: space-between; align-items: center;">
          <button type="button" class="btn" data-dismiss="modal"
            style="padding: 10px 20px; border: 2px solid #e0e0e0; background: white; border-radius: 8px; color: #666; font-weight: 500; transition: all 0.2s;">
            Cancel
          </button>
          <button type="submit" form="extensionRequestForm" class="btn"
            style="padding: 10px 30px; background: #4CBB17; border: none; border-radius: 8px; color: white; font-weight: 500; transition: all 0.2s; display: flex; align-items: center; gap: 8px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z" />
            </svg>
            Send Request
          </button>
        </div>
      </div>
    </div>
  </div>


  <!-- end of modal -->





  <!-- Review Modal -->
  <div class="modal fade" id="ReviewModal" tabindex="-1" aria-labelledby="ReviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ReviewModalLabel">Leave a Review</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="background: none; border: none; font-size: 24px; opacity: 0.5; transition: opacity 0.2s;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>



        <div class="modal-body">
          <form id="reviewForm">
            <div class="mb-3" hidden>
              <label for="ReservationID" class="form-label">Booking ID</label>
              <input type="text" class="form-control" id="ReservationID" value="<?php echo htmlspecialchars($reservation['ReservationID']) . ""; ?>" name="ReservationID" required>
            </div>
            <div class="mb-3" hidden>
              <label for="CustomerID" class="form-label">Customer ID</label>
              <input type="text" class="form-control" id="CustomerID" name="CustomerID" value="<?php echo $userID . ""; ?>" required>
            </div>
            <div class="mb-3" hidden>
              <label for="RestaurantID" class="form-label">Restaurant ID</label>
              <input type="text" class="form-control" id="RestaurantID" value="<?php echo htmlspecialchars($reservation['RestaurantID']) . ""; ?>" name="RestaurantID" required>
            </div>

            <!-- Inline CSS for Star Rating -->
            <div class="mb-3">
              <label class="form-label">Rating (1-5)</label>
              <div class="star-rating" style="display: flex;  justify-content: center;">
                <input type="radio" id="star5" name="Ratings" value="5" style="display: none;">
                <label for="star5" title="5 stars" style="font-size: 4em; color: #ddd; cursor: pointer; transition: color 0.2s;">★</label>

                <input type="radio" id="star4" name="Ratings" value="4" style="display: none;">
                <label for="star4" title="4 stars" style="font-size: 4em; color: #ddd; cursor: pointer; transition: color 0.2s;">★</label>

                <input type="radio" id="star3" name="Ratings" value="3" style="display: none;">
                <label for="star3" title="3 stars" style="font-size: 4em; color: #ddd; cursor: pointer; transition: color 0.2s;">★</label>

                <input type="radio" id="star2" name="Ratings" value="2" style="display: none;">
                <label for="star2" title="2 stars" style="font-size: 4em; color: #ddd; cursor: pointer; transition: color 0.2s;">★</label>

                <input type="radio" id="star1" name="Ratings" value="1" style="display: none;">
                <label for="star1" title="1 star" style="font-size: 4em; color: #ddd; cursor: pointer; transition: color 0.2s;">★</label>
              </div>
            </div>

            <div class="mb-3">
              <label for="Details" class="form-label">Review Details</label>
              <textarea class="form-control" id="Details" name="Details" rows="4" required></textarea>
            </div>

            <button style="background-color: #4CBB17;" type="submit" class="btn btn-success center">Submit Review</button>
          </form>
        </div>






      </div>
    </div>
  </div>

  <br>
  
  <?php include 'footer.php'; ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">





<!-- Unique QR Code Modal -->
<div id="QRCodeModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
    background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); text-align: center;
    z-index: 9999; width: 300px; max-width: 95%;">
    <h3 style="margin-bottom: 10px;">Scan QR Code</h3>
    <div id="qrcode"></div>
    <p>Show this QR Code at the restaurant to dine in.</p>
    <button onclick="closeQRModal()" style="margin-top: 1px; background: red; color: white; padding: 8px 15px; border: none; cursor: pointer; border-radius: 5px;">
        Close
    </button>
</div>

<!-- Overlay -->
<div id="QRCodeOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.5); z-index: 9998;" onclick="closeQRModal()"></div>

<!-- Include QRCode.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
    document.getElementById("CompleteBooking").addEventListener("click", function () {
        let qrCodeUrl = "https://foodnpals.com/admin/QRCode.php?ID=<?php echo htmlspecialchars($reservation['ReservationID']); ?>";
        
        // Clear previous QR
        document.getElementById("qrcode").innerHTML = ""; 

        // Generate new QR Code
        new QRCode(document.getElementById("qrcode"), {
            text: qrCodeUrl,
            width: 240,
            height: 240
        });

        // Show Modal
        document.getElementById("QRCodeModal").style.display = "block";
        document.getElementById("QRCodeOverlay").style.display = "block";
    });

    function closeQRModal() {
        document.getElementById("QRCodeModal").style.display = "none";
        document.getElementById("QRCodeOverlay").style.display = "none";
    }
</script>



</body>


<script>
  // Function to get URL parameters
  function getUrlParameter(name) {
    name = name.replace(/[[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
    var results = regex.exec(location.search);
    return results === null ?
      "" :
      decodeURIComponent(results[1].replace(/\+/g, " "));
  }

  // Check if URL contains the specified parameter
  var idParameter = getUrlParameter("ID");
  if (idParameter === "1") {
    // Update the text content of the label
    document.getElementById("status1").textContent = "Booking Confirmed";
  }
</script>

<script>
  // Function to get the user's location
  window.onload = function() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        // Set latitude and longitude values in input fields
        //        document.getElementById('latitude').value = position.coords.latitude;
        //      document.getElementById('longitude').value = position.coords.longitude;
      }, function(error) {
        console.error("Error getting location: ", error);
        // alert('Unable to retrieve your location');
      });
    } else {
      // alert('Geolocation is not supported by your browser');
    }
  };
</script>

<script>
  $(document).ready(function() {
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
          $.each(data.items, function(index, item) {
            var subtotal = item.price * item.quantity;
            total += subtotal;

            cartItemsBody.append('<tr>' +
              '<td>' + item.name + '</td>' +
              '<td>' + item.quantity + '</td>' +
              '<td>$' + item.price.toFixed(2) + '</td>' +
              '<td>$' + subtotal.toFixed(2) + '</td>' +
              '<td><button class="btn btn-danger btn-sm" onclick="removeFromCart(' + item.id + ')">Remove</button></td>' +
              '</tr>');
          });

          $('#totalAmount').text(total.toFixed(2));
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
        $('#smallmodal').modal('hide'); // Close the modal after item is removed
      }
    });
  }
</script>

<script>
document.getElementById('reviewForm').addEventListener('submit', function(e) {
    e.preventDefault();

    var formData = new FormData(this);

    // Submit the form using AJAX
    fetch('submit_review.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {

            // Close the modal (if any)
            $('#ReviewModal').modal('hide');

            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Review Submitted',
                text: 'Thank you for your review! You have helped millions!',
                confirmButtonText: 'OK',
                confirmButtonColor: '#4cbb17'  // Button color
            });

        } else {
            // If error (ReservationID already exists), show error message
            Swal.fire({
                icon: 'error',
                title: 'Review Submission Failed',
                text: data.message,
                confirmButtonText: 'OK',
                confirmButtonColor: '#4cbb17'  // Button color
            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while submitting the review.' + error);
    });
});

</script>

<script>
 // Add event listeners to handle the star hover and selection interactions
document.querySelectorAll('.star-rating label').forEach(star => {
  star.addEventListener('click', function() {
    let siblings = this.parentNode.childNodes;
    
    // Reset all stars to gray before setting the selected ones to golden
    siblings.forEach(sib => {
      if (sib.nodeName === "LABEL") {
        sib.style.color = '#ddd';
      }
    });

    // Set the clicked star and all previous stars to golden
    this.style.color = '#f5a623';
    let prevSibling = this.previousElementSibling;
    while (prevSibling) {
      if (prevSibling.nodeName === "LABEL") {
        prevSibling.style.color = '#f5a623';
      }
      prevSibling = prevSibling.previousElementSibling;
    }
  });

  star.addEventListener('mouseover', function() {
    let siblings = this.parentNode.childNodes;
    
    // Reset the colors of all stars when hovering
    siblings.forEach(sib => {
      if (sib.nodeName === "LABEL") {
        sib.style.color = '#ddd';
      }
    });

    // Set the hovered star and all previous stars to golden
    this.style.color = '#f5a623';
    let prevSibling = this.previousElementSibling;
    while (prevSibling) {
      if (prevSibling.nodeName === "LABEL") {
        prevSibling.style.color = '#f5a623';
      }
      prevSibling = prevSibling.previousElementSibling;
    }
  });

  star.addEventListener('mouseout', function() {
    let checkedStar = document.querySelector('.star-rating input:checked');
    let siblings = this.parentNode.childNodes;
    
    // Reset all stars to gray on mouse out
    siblings.forEach(sib => {
      if (sib.nodeName === "LABEL") {
        sib.style.color = '#ddd';
      }
    });

    // If a star is selected, highlight the selected star and all previous ones
    if (checkedStar) {
      let label = checkedStar.nextElementSibling;
      label.style.color = '#f5a623';
      let prevSibling = label.previousElementSibling;
      while (prevSibling) {
        if (prevSibling.nodeName === "LABEL") {
          prevSibling.style.color = '#f5a623';
        }
        prevSibling = prevSibling.previousElementSibling;
      }
    }
  });
});

</script>

<script>
  let reloadInterval;

  function startReloading() {
    reloadInterval = setInterval(() => {
      location.reload();
    }, 30000);
  }

  function stopReloading() {
    clearInterval(reloadInterval);
  }

  $(document).ready(function() {
    // Start reloading when the page loads
    startReloading();

    // When the modal is shown, stop the page from reloading
    $('#smallmodal').on('show.bs.modal', function() {
      stopReloading();
    });

    // When the modal is hidden, resume reloading
    $('#smallmodal').on('hidden.bs.modal', function() {
      startReloading();
    });
  });
</script>



<script>
document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const reservationID = urlParams.get('ID');

    if (reservationID && navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function (position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;

            document.cookie = 'Latitude=' + lat + '; path=/';
            document.cookie = 'Longitude=' + lng + '; path=/';
           
            //document.getElementById('status1').innerHTML = lat+" / "+ lng;

            fetch('update_location.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    reservationID: reservationID,
                    latitude: lat,
                    longitude: lng
                })
            });
        }, function (error) {
            console.warn('Location error: ' + error.message);
        });
    }
});
</script>

<script>
function openInMaps(directionsUrl) {
    try {
        // Remove @ prefix and trim whitespace if present
        directionsUrl = directionsUrl.replace(/^@/, '').trim();
        
        // Parse origin and destination from the directions URL
        const url = new URL(directionsUrl);
        const params = new URLSearchParams(url.search);
        const origin = params.get('origin');
        const destination = params.get('destination');
        
        // Get user's platform
        var userAgent = navigator.userAgent || navigator.vendor || window.opera;
        
        // iOS detection
        if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
            // Apple Maps URL scheme with directions
            window.location.href = `maps://?saddr=${origin}&daddr=${destination}`;
        }
        // Android detection
        else if (/android/i.test(userAgent)) {
            // Google Maps URL for Android
            window.location.href = `https://www.google.com/maps/dir/${origin}/${destination}`;
        }
        else {
            // For desktop browsers, open Google Maps in a new tab
            window.open(`https://www.google.com/maps/dir/${origin}/${destination}`, '_blank');
        }
    } catch (error) {
        console.error('Error opening maps:', error);
        // Log the URL for debugging
        console.log('Directions URL:', directionsUrl);
        // Fallback to opening Google Maps with just the coordinates
        const fallbackUrl = 'https://www.google.com/maps/dir/' + 
            directionsUrl.match(/origin=([\d.,]+)/)[1] + '/' + 
            directionsUrl.match(/destination=([\d.,]+)/)[1];
        window.open(fallbackUrl, '_blank');
    }
}
</script>

<script>
function isWebView() {
    // iOS webview detection
    var standalone = window.navigator.standalone;
    var userAgent = window.navigator.userAgent.toLowerCase();
    var isIOS = /iphone|ipad|ipod/.test(userAgent);
    var isAndroid = /android/.test(userAgent);

    // iOS webview: not Safari, not Chrome, not Firefox, not Opera, not Edge, not standalone
    var isIOSWebView = isIOS && !standalone && !/safari/.test(userAgent);

    // Android webview: user agent contains 'wv' or 'version/x.x'
    var isAndroidWebView = isAndroid && (userAgent.indexOf('wv') > -1 || userAgent.indexOf('version/') > -1);

    return {
        isIOSWebView: isIOSWebView,
        isAndroidWebView: isAndroidWebView
    };
}

document.addEventListener('DOMContentLoaded', function() {
    var btn = document.getElementById('carplayAndroidBtn');
    var btnText = document.getElementById('carplayAndroidBtnText');
    var env = isWebView();

    if (env.isIOSWebView) {
        btn.style.display = '';
        btnText.textContent = 'Open in Carplay';
    } else if (env.isAndroidWebView) {
        btn.style.display = '';
        btnText.textContent = 'Open in Android Auto';
    } else {
        btn.style.display = 'none';
    }
});
</script>

<script>
const reservationID = "<?php echo htmlspecialchars($reservation['ReservationID']); ?>";
let currentStatus = "<?php echo htmlspecialchars($reservation['Status']); ?>";
let audioReady = false;
// Notification sound removed

// Store the last status in localStorage to persist between page reloads
if (!localStorage.getItem('lastStatus_' + reservationID)) {
    localStorage.setItem('lastStatus_' + reservationID, currentStatus);
}
let lastStatus = localStorage.getItem('lastStatus_' + reservationID);

// Audio notification code removed

// Only system notification, no sound
function showNotification() {
    if (Notification.permission === 'granted') {
        new Notification('Booking Accepted!');
    }
}

// Check if status has changed from Pending to Accepted after page reload
document.addEventListener('DOMContentLoaded', function() {
    console.log("Last status:", lastStatus, "Current status:", currentStatus);
    
    if (lastStatus === 'Pending' && currentStatus === 'Accepted') {
        console.log("Status changed from Pending to Accepted - playing notification");
        showNotification();
    }
    
    // Update the stored status
    localStorage.setItem('lastStatus_' + reservationID, currentStatus);
});

function checkReservationStatus() {
    fetch('check_reservation_status.php?ID=' + encodeURIComponent(reservationID))
        .then(response => response.json())
        .then(data => {
            if (data.success && data.status) {
                // Check if status changed from Pending to Accepted
                if (lastStatus === 'Pending' && data.status === 'Accepted') {
                    console.log("Status changed from Pending to Accepted - playing notification");
                    showNotification();
                }
                
                // Update stored status
                lastStatus = data.status;
                localStorage.setItem('lastStatus_' + reservationID, data.status);
            }
        })
        .catch(err => {
            console.log("Status check error:", err);
        });
}

// Poll every 10 seconds
setInterval(checkReservationStatus, 10000);
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    if (window.innerWidth > 1024) {
      return;
    }

    var toggles = document.querySelectorAll('.section-toggle');
    toggles.forEach(function(toggle) {
      var content = toggle.nextElementSibling;
      
      var icon = document.createElement('span');
      icon.className = 'toggle-icon';
      
      if(content && content.classList.contains('show')) {
        icon.textContent = '-';
      } else {
        icon.textContent = '+';
      }
      toggle.appendChild(icon);

      toggle.addEventListener('click', function() {
        if (!content) return;
        content.classList.toggle('show');
        if (content.classList.contains('show')) {
          toggle.querySelector('.toggle-icon').textContent = '-';
        } else {
          toggle.querySelector('.toggle-icon').textContent = '+';
        }
      });
    });
  });
</script>


</html>