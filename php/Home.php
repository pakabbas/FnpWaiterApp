<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="FoodnPals">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
  <title>FoodnPals - Explore</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/banner.css">
  <link rel="stylesheet" href="assets/css/Explore.css">
  <link rel="stylesheet" href="assets/css/footer.css">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon.png">
  <script async src="https://www.googletagmanager.com/gtag/js?id=G-VGFVP25KQR"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <?php include 'fetch_cookies.php' ?>
  <?php include 'fetch_active_reservation.php' ?>
  <style>
.collections-container {
  position: relative;
  padding: 0 0px;
}

@media (max-width: 768px) {
    .footer {
        /* display: none; */
    }
}

.collections {
 height:27vh;
  display: flex;
  overflow-x: auto;
  scroll-behavior: smooth;
  -ms-overflow-style: none;
  scrollbar-width: none;
  gap: 10px;
  padding-bottom: 0px;
}

.collections::-webkit-scrollbar {
  display: none;
}

.arrow {
    background-image: url(data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='%23fff' viewBox='0 0 8 8'%3E%3Cpath d='M2.75 0l-1.5 1.5 2.5 2.5-2.5 2.5 1.5 1.5 4-4-4-4z'/%3E%3C/svg%3E);
  color:black;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background: white;
  border: none;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  box-shadow: 0 2px 5px rgba(0,0,0,0.2);
  cursor: pointer;
  z-index: 1;
  font-size: 1.5rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.arrow:hover {
  background: #f8f9fa;
}


.collection-item {
  flex: 0 0 auto;
  width: 200px;
  cursor: pointer;
  gap:25px;
  transition: transform 0.2s;
}

.collection-item:hover {
  transform: translateY(-5px);
}

.collection-item img {
  width: 100%;
  height: auto;
  width: 120px !important;
  height: 120px !important;
  margin: 0 auto;
}

.arrow-left {
  left: -10px;
}

.arrow-right {
  right: -10px;
}


@media (max-width: 768px) {
  .collection-item {
    width: 120px;
  }
  
  .arrow {
    width: 35px;
    height: 35px;
  }
  .categoriesslider{
    min-width:100%;
  }
}

@media (max-width: 480px) {

  .arrow-left {
  left: 10px;
}

.arrow-right {
  right: 10px;
}

  .collection-item {
    width: 150px;
  }
  
  .collections-container {
    padding: 0 10px;
    min-width:99%;
  }
}
</style>
  <style>
    .banner {
      height: 70vh;
      background-image: url('Resources/e1.png');
      background-size: cover;
      background-position: center;
      display: flex;
      flex-direction: column;
      color: white;
    }

    .mobile-banner {
        display: none;
    }


    @media (max-width: 768px) {
    .mobile-banner {
        display: flex;
    }

    .banner {
        display: none;
    }
}
    
    


    @media (max-width: 768px) {
      .discover-title {
        font-size: 1.5rem !important;
      }

      .location-input {
        margin-left: 0 !important;
      }
    }

    @media (max-width: 576px) {
      .location-form {
        flex-direction: column !important;
      }

      .search-button {
        width: 100% !important;
        margin-top: 10px !important;
      }
    }

    .row::-webkit-scrollbar {
      display: none;
    }

  </style>

<style>
.header-buttons {
  display: flex;
  gap: 12px;
}

/* Base button styles */
.header-btn {
  padding: 10px 20px;
  width: 120px;
  border: 1px solid #ccc;
  border-radius: 5px;
  cursor: pointer;
  font-size: 16px;
  font-family: Arial, sans-serif;
  text-decoration: none;
  text-align: center;
  position: relative;
}

/* Show text by default (web view) */
.btn-text {
  display: inline-block !important;
}

/* Hide icons by default (web view) */
.mobile-icon {
  display: none !important;
}

/* Button specific styles */
.login-btn {
  background: white;
  color: black;
}

.signup-btn {
  background: #4cbb17;
  color: white;
  border-color: #4cbb17;
}

/* Mobile styles */
@media (max-width: 768px) {
  .header-buttons {
    gap: 8px;
  }
  
  .header-btn {
    width: 40px;
    height: 40px;
    padding: 0;
  }

  /* Hide text and show icon on mobile */
  .btn-text {
    display: none !important;
  }
  
  .mobile-icon {
    display: block !important;
    font-size: 20px;
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
  }
}



</style>
  <script src="assets/js/Explore.js"></script>



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

    <h1 class="discover-title" style="font-size: 2rem; margin-bottom: 20px;">Transforming traditional dining into tech!</h1>
    <div class="location-form d-flex align-items-center" style="width: 50%;  padding: 10px; justify-content: flex-start; position: relative;">
      <div class="location-input d-flex" style="flex-grow: 1; margin-right: 10px;">
        <input id="restaurant-input1" autocomplete="off" type="text" placeholder="Discover the best restaurants" class="form-control">
      </div>
      <button class="search-button ms-3" style="margin-top: -10px;">Search</button>
      
      <div id="suggestions" class="suggestions-dropdown" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background-color: white; border-radius: 10px; margin-top: 5px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); z-index: 999; max-height: 300px; overflow-y: auto;"></div>
    </div>

    <div id="suggestions" style="color: black; width:50%;"></div>
    <br><br>
    <div style="display: flex; align-items: center; gap: 20px;">
        <a href="https://www.apple.com/app-store/" target="_blank">
            <img style="width: 150px; cursor: pointer;" src="Resources/vector.png" />
        </a>
        <a href="https://play.google.com/store/apps/details?id=com.foodnpals.foodnpalsWaiterApp" target="_blank">
            <img style="width: 150px; cursor: pointer;" src="Resources/vector2.png" />
        </a>
    </div>

  </div>



  <!-- Mobile Banner -->
  <div class="mobile-banner" style=" border-radius: 0px 0px 70px 70px;  height: 70vh; background: #6FC945;  flex-direction: column; align-items: center; color: white; padding: 20px; text-align: center; width: 100%; position: relative;">
    <!-- Location and Profile -->
     <br>
    <div class="mobile-header" style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 0 20px; position: absolute; top: 20px;">
        <!-- <div class="location" style="font-size: 1rem; font-weight: bold;">Houston<br><span style="font-size: 0.9rem; font-weight: normal;">Your Location</span></div> -->
        <div class="profile" style="width: 40px; height: 40px; border-radius: 50%; overflow: hidden; border: 2px solid white;">
            <?php 
$profilePath = 'AppUsers/uploads/' . $profilePictureURL;
if (!empty($profilePictureURL) && file_exists($profilePath)) {
    echo '<img src="' . $profilePath . '" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">';
} else {
    echo '<i class="fas fa-user-circle" style="font-size: 40px; color: #4CBB17;"></i>';
}
?>
        </div>
    </div>

    <!-- Content and Food Image -->
    <div class="content-container" style="display: flex; justify-content: center; align-items: center; margin-top: 60px; width: 100%; max-width: 400px;">
        <div class="text-container" style="flex: 1; text-align: left;">
            <h1 style="font-size: 1.8rem; margin-bottom: 10px;">Transforming traditional dining into tech!</h1>
            <!-- <p style="margin-bottom: 20px; font-size: 1rem;">What do you want to eat?</p> -->
        </div>
        <div class="food-image" style="margin-left: 20px;">
            <img src="Resources/mob1.png" alt="Food" style="width: 100px; height: auto; border-radius: 10px;">
        </div>
    </div>

    <!-- Search Box -->
    <div class="search-container" style="width: 100%; max-width: 400px; position: relative; margin-top: 20px;">
        <div style="background: white; border-radius: 30px; display: flex; align-items: center; padding: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
            <input id="restaurant-input2" autocomplete="off" type="text" placeholder="Discover the best restaurants" style="flex: 1; border: none; outline: none; padding: 10px; font-size: 1rem; border-radius: 30px;">
            <button class="mobile-search-button" style="background: transparent; border: none; cursor: pointer;">
                <img src="Resources/mob3.png" alt="Search Icon" style="width: 24px; height: 24px;">
            </button>
        </div>
        <div id="suggestions2" class="suggestions-dropdown" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background-color: white; border-radius: 10px; margin-top: 5px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); z-index: 999; max-height: 300px; overflow-y: auto;"></div>
    </div>
</div>

<style>
/* Styling for suggestion items */
.suggestions-dropdown {
  padding: 8px 0;
  
}

.suggestion-item {
  padding: 10px 16px;
  cursor: pointer;
  transition: background-color 0.2s;
  font-size: 14px;
  color: #000000;
}

.suggestion-item:hover {
  background-color: #f5f5f5;
}

.no-results {
  padding: 10px 16px;
  color: #666;
  font-style: italic;
  font-size: 14px;
}

/* Loading indicator */
.loading-spinner {
  display: flex;
  justify-content: center;
  padding: 15px 0;
}

.loading-spinner::after {
  content: "";
  width: 20px;
  height: 20px;
  border: 2px solid #f3f3f3;
  border-top: 2px solid #4cbb17;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>


<!-- Collections Carousel -->
<div  class="container mt-5 categoriesslider" style="padding:0;">
  <h2  style="margin-left: 25px;">Categories</h2>
  <div class="collections-container"  style="padding:0px 30px 0px 30px;">
  <button class="arrow arrow-left"  style="background:#4cbb17; color:white;">
  <svg viewBox="0 0 24 24" width="32" height="32">
    <path d="M15.41 16.59L10.83 12l4.58-4.59L14 6l-6 6 6 6 1.41-1.41z" fill="white" />
  </svg>
</button>
<button class="arrow arrow-right"  style="background:#4cbb17; color:white;">
  <svg viewBox="0 0 24 24" width="24" height="24" >
<path d="M8.59 16.59L13.17 12 8.59 7.41 10 6l6 6-6 6-1.41-1.41z" fill="white"/>

  </svg>
</button>  
<div class="collections">
      <div class="collection-item" style="display: inline-block; text-align: center;" onclick="redirectToExplore('Sandwiches')">
        <img src="Resources/food icons/sandwich.svg" alt="Sandwiches">
        <p class="label mt-2">Sandwiches</p>
      </div>

            <div class="collection-item" style="display: inline-block; text-align: center;" onclick="redirectToExplore('Coffee')">
        <img style="height:120px; widht:120px;" src="Resources/food icons/coffee.png" alt="Coffee">
        <p class="label mt-2">Coffee</p>
      </div>
          <div class="collection-item" style="display: inline-block; text-align: center;" onclick="redirectToExplore('Breakfast')">
        <img src="Resources/food icons/Breakfast.svg" alt="Breakfast">
        <p class="label mt-2">Breakfast</p>
      </div>

      <div class="collection-item" style="display: inline-block; text-align: center;" onclick="redirectToExplore('Chinese')">
        <img src="Resources/food icons/Chinses.svg" alt="Chinese">
        <p class="label mt-2">Chinese</p>
      </div>
      <div class="collection-item" style="display: inline-block; text-align: center;" onclick="redirectToExplore('Mediterranean')">
        <img style="height:120px; widht:120px;" src="Resources/food icons/BBQ.png" alt="BBQ">
        <p class="label mt-2">Mediterranean</p>
      </div>
      <div class="collection-item" style="display: inline-block; text-align: center;" onclick="redirectToExplore('Asian')">
        <img src="Resources/food icons/Asian.svg" alt="Asian">
        <p class="label mt-2">Asian</p>
      </div>
      <div class="collection-item" style="display: inline-block; text-align: center;" onclick="redirectToExplore('Halal')">
        <img src="Resources/food icons/Halal.svg" alt="Halal">
        <p class="label mt-2">Halal</p>
      </div>
      <div class="collection-item" style="display: inline-block; text-align: center;" onclick="redirectToExplore('Italian')">
        <img src="Resources/food icons/Italian.svg" alt="Italian">
        <p class="label mt-2">Italian</p>
      </div>
      <div class="collection-item" style="display: inline-block; text-align: center;" onclick="redirectToExplore('Sea food')">
        <img src="Resources/food icons/Sea food.svg" alt="Sea food">
        <p class="label mt-2">Sea Food</p>
      </div>

            <div class="collection-item" style="display: inline-block; text-align: center;" onclick="redirectToExplore('Vegan')">
        <img src="Resources/food icons/11.png" alt="Vegan">
        <p class="label mt-2">Vegan</p>
      </div>

            <div class="collection-item" style="display: inline-block; text-align: center;" onclick="redirectToExplore('Pakistani')">
        <img src="Resources/food icons/5.png" alt="Pakistani">
        <p class="label mt-2">Pakistani</p>
      </div>

            <div class="collection-item" style="display: inline-block; text-align: center;" onclick="redirectToExplore('Salad')">
        <img src="Resources/food icons/12.png" alt="Salad">
        <p class="label mt-2">Salad</p>
      </div>

            <div class="collection-item" style="display: inline-block; text-align: center;" onclick="redirectToExplore('Indian')">
        <img src="Resources/food icons/indian.png" alt="Indian">
        <p class="label mt-2">Indian</p>
      </div>

    </div>
  </div>
</div>



<script>
  const collections = document.querySelector('.collections');
  const arrowLeft = document.querySelector('.arrow-left');
  const arrowRight = document.querySelector('.arrow-right');

  arrowLeft.addEventListener('click', () => {
    collections.scrollBy({
      left: -collections.offsetWidth,
      behavior: 'smooth'
    });
  });

  arrowRight.addEventListener('click', () => {
    collections.scrollBy({
      left: collections.offsetWidth,
      behavior: 'smooth'
    });
  });

  function redirectToExplore(foodType) {
    window.location.href = `Home.php?search=${encodeURIComponent(foodType)}`;
  }
</script>


  <!-- Hide scrollbar for WebKit browsers -->




  <!-- Popular Restaurants -->
  <div hidden class="container mt-5">
    <h2 class="mb-4">Popular Restaurants</h2>
    <div class="row restaurants-grid">
      <?php include 'fetch_4_restaurant.php'; ?>
    </div>
  </div>



  <!-- All Restaurants -->
  <div class="container mt-5" style="max-width: 100%;">
    <h2 id="allrestaurants" class="mb-4" style=" margin-left: 15px;">All Restaurants</h2>
    <div class="row restaurants-grid" style="width: 100%; margin:0">
      <?php include 'fetch_all_restaurant.php';
      ?>
    </div>
  </div>
  <br><br><br>
  <br>
  <br>
 
  <?php include 'footer.php'; ?>
<!-- Cookie Consent Popup -->
<div id="cookieConsent" style="
  position: fixed;
  bottom: 20px;
  left: 20px;
  right: 20px;
  background: white;
  color: #333;
  border: 1px solid #4cbb17;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  display: flex;
  flex-direction: column;
  gap: 15px;
  z-index: 1000;
  max-width: 480px;
  margin: auto;
  font-family: 'Segoe UI', sans-serif;
">

  <div style="display: flex; align-items: center; gap: 15px;">
    <img src="https://img.icons8.com/fluency/48/000000/cookie.png" alt="cookie" style="width: 36px; height: 36px;" />
    <div>
      <strong style="font-size: 16px;">We use cookies!</strong>
      <p style="margin-top: 5px; font-size: 14px;">To improve your experience on our site. By using our site, you accept cookies.</p>
    </div>
  </div>

  <div style="display: flex; justify-content: flex-end; gap: 10px; flex-wrap: wrap;">
    <button onclick="document.getElementById('cookieConsent').style.display='none'; localStorage.setItem('cookieAccepted','yes')" style="
      background: #4cbb17;
      color: white;
      border: none;
      padding: 10px 18px;
      border-radius: 8px;
      font-size: 14px;
      cursor: pointer;
    ">Accept</button>

    <a href="PrivacyPolicy.php" style="color: #4cbb17; font-size: 14px; align-self: center;">Learn more</a>
  </div>
</div>

<script>
  if (localStorage.getItem('cookieAccepted') === 'yes') {
    document.getElementById('cookieConsent').style.display = 'none';
  }
</script>


</body>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDP9cy_r8w6t7O0Wct3KmP0rPI0ISVQqks&libraries=places"></script>
<script>
  let latitude, longitude;

  // Function to initialize Google Places Autocomplete
  // function initAutocomplete() {
  //   const input = document.getElementById('location-input');
  //   const latitudeInput = document.getElementById('latitude-input');
  //   const longitudeInput = document.getElementById('longitude-input');
  //   const options = {
  //     componentRestrictions: {
  //       country: 'us'
  //     },
  //     types: ['address'], // Restrict to addresses (no cities or regions)
  //     fields: ['place_id', 'geometry', 'name', 'formatted_address'],
  //   };
  //   const autocomplete = new google.maps.places.Autocomplete(input, options);

  //   // Get place details when user selects a place
  //   autocomplete.addListener('place_changed', function() {
  //     const place = autocomplete.getPlace();

  //     if (place.geometry) {
  //       const lat = place.geometry.location.lat();
  //       const lng = place.geometry.location.lng();

  //       latitudeInput.value = lat;
  //       longitudeInput.value = lng;
  //       alert(lat + "/" + lng);
  //     }
  //     console.log('Selected Place:', place.name);
  //   });
  // }

  // Function to get user's current location
  function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition, showError, {
        enableHighAccuracy: true,
        timeout: 10000, // 10 second timeout
        maximumAge: 0 // Force a fresh location
      });
    } else {
      console.error("Geolocation is not supported by this browser.");
    }
  }

  // Show the user's position (latitude and longitude)
  function showPosition(position) {
    latitude = position.coords.latitude;
    longitude = position.coords.longitude;

    console.log('Latitude:', latitude);
    console.log('Longitude:', longitude);
    // alert(latitude + "/" + longitude);
    // Use Google Geocoder to get the address from the coordinates
    const geocoder = new google.maps.Geocoder();
    const latlng = {
      lat: latitude,
      lng: longitude
    };

    geocoder.geocode({
      location: latlng
    }, function(results, status) {
      if (status === 'OK') {
        if (results[0]) {
          //document.getElementById('location-input').value = results[0].formatted_address;
          //document.getElementById('latitude-input').value = latitude;
          //document.getElementById('longitude-input').value = longitude;
        } else {
          console.log('No results found');
        }
      } else {
        console.log('Geocoder failed due to: ' + status);
      }
    });
  }

  // Handle errors with Geolocation
  function showError(error) {
    let errorMessage = "An unknown error occurred.";
    switch (error.code) {
      case error.PERMISSION_DENIED:
        errorMessage = "User denied the request for Geolocation. Note: This feature requires a secure connection (HTTPS).";
        break;
      case error.POSITION_UNAVAILABLE:
        errorMessage = "Location information is unavailable.";
        break;
      case error.TIMEOUT:
        errorMessage = "The request to get user location timed out.";
        break;
      case error.UNKNOWN_ERROR:
        errorMessage = "An unknown error occurred.";
        break;
    }
    console.error("Geolocation Error: " + errorMessage, error);
  }

  // Initialize autocomplete and fetch the user's location on page load
  $(document).ready(function() {
    //initAutocomplete();
    getLocation();
  });
</script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const activeBookingBanner = document.getElementById('active-booking-banner');
    <?php if (!empty($activeReservation)) : ?>
      const reservationId = <?php echo json_encode($activeReservation); ?>;
      if (activeBookingBanner) {
        activeBookingBanner.addEventListener('click', function() {
          window.location.href = 'Confirmation.php?ID=' + reservationId;
        });
      }
    <?php endif; ?>
  });
</script>

<script>
  document.getElementById('restaurant-input1').addEventListener('input', function() {
    let query = this.value;
    if (query.length > 1) { // Trigger search when user types more than 1 character
      fetchRestaurants(query,"suggestions");
    } else {
      hideDropdown("suggestions");
    }
  });
  
  document.getElementById('restaurant-input2').addEventListener('input', function() {
    let query = this.value;
    if (query.length > 1) { // Trigger search when user types more than 1 character
      fetchRestaurants(query,"suggestions2");
    } else {
      hideDropdown("suggestions2");
    }
  });
  
  // Handle search button clicks
  document.querySelector('.search-button').addEventListener('click', function() {
    const query = document.getElementById('restaurant-input1').value;
    if (query.trim().length > 0) {
      window.location.href = "Home.php?search=" + encodeURIComponent(query);
    }
  });
  
  document.querySelector('.mobile-search-button').addEventListener('click', function() {
    const query = document.getElementById('restaurant-input2').value;
    if (query.trim().length > 0) {
      window.location.href = "Home.php?search=" + encodeURIComponent(query);
    }
  });
  
  // Handle Enter key press
  document.getElementById('restaurant-input1').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
      if (this.value.trim().length > 0) {
        window.location.href = "Home.php?search=" + encodeURIComponent(this.value);
      }
    }
  });
  
  document.getElementById('restaurant-input2').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
      if (this.value.trim().length > 0) {
        window.location.href = "Home.php?search=" + encodeURIComponent(this.value);
      }
    }
  });
  
  function fetchRestaurants(query, suggestions) {
    const suggestionBox = document.getElementById(suggestions);
    
    // Show loading indicator
    suggestionBox.innerHTML = '<div class="loading-spinner"></div>';
    suggestionBox.style.display = "block";
    
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "search_restaurants.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
      if (this.status === 200) {
        let results = JSON.parse(this.responseText);
        displaySuggestions(results, suggestions);
      } else {
        suggestionBox.innerHTML = "<div class='no-results'>Error loading results</div>";
      }
    };
    
    xhr.onerror = function() {
      suggestionBox.innerHTML = "<div class='no-results'>Error loading results</div>";
    };

    xhr.send("query=" + query);
  }

  function displaySuggestions(restaurants, suggestions) {
    let suggestionBox = document.getElementById(suggestions);
    suggestionBox.innerHTML = ""; // Clear previous results
    
    // Show the dropdown
    suggestionBox.style.display = "block";
    
    if (restaurants.length > 0) {
      restaurants.forEach(restaurant => {
        let suggestionItem = document.createElement('div');
        suggestionItem.className = 'suggestion-item';
        suggestionItem.innerText = restaurant.Name;
        suggestionItem.addEventListener('click', function() {
          window.location.href = "Profile.php?ID=" + restaurant.RestaurantID;
        });
        suggestionBox.appendChild(suggestionItem);
      });
    } else {
      suggestionBox.innerHTML = "<div class='no-results'>No restaurants found</div>";
    }
  }
  
  function hideDropdown(dropdownId) {
    document.getElementById(dropdownId).style.display = "none";
  }
  
  // Close dropdowns when clicking outside
  document.addEventListener('click', function(event) {
    const dropdown1 = document.getElementById('suggestions');
    const dropdown2 = document.getElementById('suggestions2');
    const input1 = document.getElementById('restaurant-input1');
    const input2 = document.getElementById('restaurant-input2');
    
    // If click is outside the search input and dropdown for input1
    if (!event.target.closest('#restaurant-input1') && 
        !event.target.closest('#suggestions') && 
        dropdown1.style.display === 'block') {
      hideDropdown('suggestions');
    }
    
    // If click is outside the search input and dropdown for input2
    if (!event.target.closest('#restaurant-input2') && 
        !event.target.closest('#suggestions2') && 
        dropdown2.style.display === 'block') {
      hideDropdown('suggestions2');
    }
  });
  
  // Focus events to reshow dropdown if there's content
  document.getElementById('restaurant-input1').addEventListener('focus', function() {
    if (this.value.length > 1) {
      fetchRestaurants(this.value, "suggestions");
    }
  });
  
  document.getElementById('restaurant-input2').addEventListener('focus', function() {
    if (this.value.length > 1) {
      fetchRestaurants(this.value, "suggestions2");
    }
  });
</script>

<script>
  // Check if the 'search' parameter exists in the URL
  const urlParams = new URLSearchParams(window.location.search);
  
  if (urlParams.has('search')) {
    // If 'search' parameter is present, hide the banner
    document.querySelector('.banner').style.display = 'none';
    document.querySelector('.mobile-banner').style.display = 'none';

    // Change the text of the h2 element with id 'allrestaurants'
    const searchValue = urlParams.get('search');
    document.getElementById('allrestaurants').textContent = 'Search Result For: ' + searchValue;
  }
</script>


<script>
    // Function to get the current position and set cookies
    function updateLocationCookies() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var longitude = position.coords.longitude;
                var latitude = position.coords.latitude;

                // Set cookies with the current position
                document.cookie = "Longitude=" + longitude + "; path=/; max-age=" + 60 * 60 * 24 * 30; // Expires in 30 days
                document.cookie = "Latitude=" + latitude + "; path=/; max-age=" + 60 * 60 * 24 * 30; // Expires in 30 days
              
              }, function(error) {
                console.error("Geolocation error: " + error.message);
            });
        } else {
            console.error("Geolocation is not supported by this browser.");
        }
    }

    // Update location every 2 minutes (120,000 milliseconds)
    setInterval(updateLocationCookies, 20000);
    
    // Call the function once to set the initial location
    updateLocationCookies();
</script>


</html>