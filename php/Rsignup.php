
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
    body {
      font-family: 'Inter', sans-serif;
      background: #f9f9f9;
      padding: 30px;
    }
    .signup-container {
      max-width: 500px;
      background: #fff;
      padding: 30px;
      margin: auto;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .signup-container h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #4CBB17;
    }
    .form-group {
      margin-bottom: 15px;
      margin-bottom: 0.1rem;

    }

    label {
      display: block;
      margin-bottom: 5px;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 5px;
    }
    button {
      width: 100%;
      padding: 12px;
      background: #4CBB17;
      color: #fff;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
    }
    button:hover {
      background: #3aa911;
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

  <!-- Banner -->
  <!-- <div class="banner" >
    <h3 class="discover-title" style="font-size: 3rem; margin-bottom: 20px;">Transform your restaurant’s

    </h3>
    <h3 class="discover-title" style="font-size: 3rem; margin-bottom: 20px;">revenue with FoodnPals

</h3>
 
  
  </div>
<br>


<br> -->
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
       
       
       
        <div  class="col-md-5 mb-4">
           <form action="Rinsert_restaurant.php" method="POST" onsubmit="return geoEncode()">
    <div class="form-group">
      <label>Restaurant Name</label>
      <input type="text" name="Name" required>
    </div>
    <div class="form-group">
      <label>Email</label>
      <input type="email" name="Email" required>
    </div>
    <div class="form-group">
      <label>Phone Number</label>
      <input type="text" name="PhoneNumber" required>
    </div>
    <div class="form-group">
      <label>Address</label>
      <input type="text" id="address" name="Address" required>
    </div>

    <input type="hidden" name="Latitude" id="latitude" required>
    <input type="hidden" name="Longitude" id="longitude" required>
    <div class="form-group">
      <label>Password</label>
      <input type="password" name="Password" required>
    </div>
    <div class="form-group">
      <label>Confirm Password</label>
      <input type="password" name="ConfirmPassword" required>
    </div>
    <button style="border-radius:5px;" type="submit">Register</button>
  </form>
  <script>
function geoEncode() {
  const address = document.getElementById("address").value;
  const geocoder = new google.maps.Geocoder();
  return new Promise((resolve) => {
    geocoder.geocode({ address }, function(results, status) {
      if (status === "OK" && results[0]) {
        document.getElementById("latitude").value = results[0].geometry.location.lat();
        document.getElementById("longitude").value = results[0].geometry.location.lng();
        resolve(true);
      } else {
        alert("Unable to get location. Please enter a valid address.");
        resolve(false);
      }
    });
  });
}
</script>
        </div>
       
    
    </div>
</section>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


 
<?php include 'footer.php'; ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script>
   function scroll1 () {
        document.getElementById('plans').scrollIntoView({ behavior: 'smooth' });
    }
</script>
<script>
  function initAutocomplete() {
    const input = document.getElementById("address");
    if (input) {
      new google.maps.places.Autocomplete(input);
    }
  }
</script>
    <script
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDP9cy_r8w6t7O0Wct3KmP0rPI0ISVQqks&libraries=places&callback=initAutocomplete"
  async defer></script>

</html>