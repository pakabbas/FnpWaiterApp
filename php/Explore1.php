<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FoodnPals</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/banner.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <style>
    /* Custom CSS styles */

    .restaurants-grid a {
      text-decoration: none;
      color: inherit;
      /* Inherit the text color from the parent element */
    }

    /* Ensure that link hover state also doesn't change text decoration */
    .restaurants-grid a:hover {
      text-decoration: none;
    }

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
      background-image: url('Resources/e1.png');
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
      /* position: relative; */
    }

    .collections {
      height: 20vh;
      /* 10% of screen height */
      display: flex;
      justify-content: space-around;
      align-items: center;
    }

    .collection-item img {
      width: 150px;
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
      background-color: #4CBB17;
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
      background-color: #4CBB17;
      /* Same color as specified for buttons */
      border: 1px solid #4CBB17;
      /* Same color as specified for buttons */
      border-radius: 5px;
      padding: 10px 20px;
      margin-left: 10px;
      /* Adjust spacing between buttons */
      cursor: pointer;
    }

    .login-button {
      background-color: white;
      color: #4CBB17;
      /* Same color as specified for buttons */
      border: 1px solid #4CBB17;
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
    }

    .restaurant-info {
      display: flex;
      align-items: center;
    }


    .restaurant-rating {
      margin: 0;
      background-color: #FFB30E;
      color: white;
      font-weight: bold;
      padding: 5px;
      margin-left: 35px;
      border-radius: 10px;
    }


    #suggestions {

      margin-top: 140px;
      background-color: white;
      border: 1px solid black;
      width: 100%;
      /* Make the suggestion box as wide as the input */
      max-height: 200px;
      /* Limit the height and add scroll if needed */
      overflow-y: auto;
      position: absolute;
      /* Position it right under the search input */
      z-index: 999;
      /* Ensure it stays above other elements */
      color: black;
      border-color: black;
      border-radius: 10px;

    }

    .suggestion-item {
      padding: 10px;
      cursor: pointer;
      border-bottom: 1px solid #eee;
    }

    .suggestion-item:hover {
      background-color: #f0f0f0;
      color: green;
      /* Change text to green on hover */
      cursor: pointer;
      /* Change cursor to pointer on hover */
    }

    .no-results {
      padding: 10px;
      color: #888;
    }
  </style>
  <?php include 'fetch_cookies.php' ?>
  <?php include 'fetch_active_reservation.php' ?>

</head>

<body>
  <?php if ($isReservationActive == "Yes"): ?>
    <div class="floating-banner" id="active-booking-banner">
      <div class="banner-header">Booking in progress...</div>
      <div class="banner-content">
        <img src="Resources/<?php echo $restaurantIcon; ?>" alt="Restaurant Icon" class="restaurant-icon">
        <div class="restaurant-details">
          <div class="restaurant-name"><?php echo $restaurantName; ?></div>
        <div class="reservation-time">
    <?php echo date('F j, Y \a\t g:i A', $reservationTime); ?>
</div>


        </div>
      </div>
    </div>
  <?php endif; ?>
  <!-- Header -->
  <div class="header">

     <a href="Home.php">
      <img src="Resources/logo.png" alt="Location" style="margin-left: 10px; width: 160px;"></a>
    <?php
    $userID = isset($_COOKIE['UserID']) ? $_COOKIE['UserID'] : null;
    $username = isset($_COOKIE['Username']) ? $_COOKIE['Username'] : null;
    if ($userID): ?>
      <div class="menu-bar">
        <i class="fas fa-user-circle" style="font-size: 36px; color: #4cbb17;"> </i>
        <p style="font-size: 20px; color: #4cbb17;"> Muhammad Abbas</p>
        <!-- <p style="color: #4cbb17"><?php //echo "  " . htmlspecialchars($username) . htmlspecialchars($userID); 
                                        ?></p> -->
      </div>
    <?php else: ?>
      <div class="menu-bar">
        <button onclick="window.location.href='Login.html'" class="login-button">Login</button>
        <button onclick="window.location.href='SignUp.php'" class="signup-button">Sign Up</button>
      </div>
    <?php endif; ?>

  </div>

  <!-- Banner -->
  <div class="banner">
    <h1 class="discover-title">Discover the Best Restaurants</h1>
    <div class="location-form">

      <div hidden class="location-input">
        <input id="location-input" type="text" placeholder="Enter your location">
        <input hidden id="latitude-input" type="text">
        <input hidden id="longitude-input" type="text">
        <img src="Resources/ion_locate.png" alt="Location" class="location-icon">
      </div>

      <div class="location-input">
        <input id="restaurant-input1" autocomplete="off" type="text" placeholder="Search Restaurants">
      </div> <button class="search-button">Search</button>
      <div style="color: black;" id="suggestions"></div>


    </div>
  </div>

  <!-- Collections Carousel -->
  <div class="container mt-5" style="background-color: white;">
    <h2 class=" mb-4">Collections</h2>
    <div class="collections">
      <div class="collection-item">
        <img src="Resources/Chinese.png" alt="Chinese">
        <p class="label">Chinese</p>
      </div>
      <div class="collection-item">
        <img src="Resources/american.png" alt="American">
        <p class="label">American</p>
      </div>
      <div class="collection-item">
        <img src="Resources/Chinese.png" alt="Chinese">
        <p class="label">Kosher</p>
      </div>
      <div class="collection-item">
        <img src="Resources/Desi.png" alt="Desi">
        <p class="label">Desi</p>
      </div>
      <div class="collection-item">
        <img src="Resources/Halal.png" alt="Halal">
        <p class="label">Halal</p>
      </div>
      <div class="collection-item">
        <img src="Resources/Thai.png" alt="Thai">
        <p class="label">Thai</p>
      </div>

    </div>

  </div>
  <br>
  <h2 class=" mb-4" style="margin-left: 5%;">Popular Restaurants</h2>
  <div class="restaurants-grid">
    <!-- Popular Restaurants items here -->



    <?php include 'fetch_4_restaurant.php'; ?>



  </div> <!-- END Popular Restaurants -->




  <br>
  <h2 class=" mb-4" style="margin-left: 5%;">Recent Dine in</h2>
  <div class="restaurants-grid">
    <!-- Restaurant items here -->

    <div class="restaurant" `> <!--R1 -->
      <div class="restaurant-image">
        <img src="Resources/R1.png" alt="Restaurant Image">
      </div>
      <div class="restaurant-details">
        <div class="restaurant-info">
          <div class="restaurant-icon">
            <img src="Resources/R2.png" alt="Restaurant Icon">
          </div>
          <div class="restaurant-text">
            <span class="restaurant-name" style="font-weight: bold;">Kababjees Restaurant</span>
            <p class="restaurant-type">BBQ, American</p>
          </div>
        </div>
        <p class="restaurant-rating">4.4 <img src="Resources/star.png" alt="Star Icon" style="width: 13px; padding-bottom: 5px;"></p>
      </div>
    </div>

    <div class="restaurant"> <!--R2 -->
      <div class="restaurant-image">
        <img src="Resources/R3.png" alt="Restaurant Image">
      </div>
      <div class="restaurant-details">
        <div class="restaurant-info">
          <div class="restaurant-icon">
            <img src="Resources/R2.png" alt="Restaurant Icon">
          </div>
          <div class="restaurant-text">
            <span class="restaurant-name" style="font-weight: bold;">Kababjees Restaurant</span>
            <p class="restaurant-type">BBQ, American</p>
          </div>
        </div>
        <p class="restaurant-rating">4.4 <img src="Resources/star.png" alt="Star Icon" style="width: 13px; padding-bottom: 5px;"></p>


      </div>
    </div>

    <div class="restaurant"> <!--R3 -->
      <div class="restaurant-image">
        <img src="Resources/R4.png" alt="Restaurant Image">
      </div>
      <div class="restaurant-details">
        <div class="restaurant-info">
          <div class="restaurant-icon">
            <img src="Resources/R2.png" alt="Restaurant Icon">
          </div>
          <div class="restaurant-text">
            <span class="restaurant-name" style="font-weight: bold;">Kababjees Restaurant</span>

            <p class="restaurant-type">BBQ, American</p>
          </div>
        </div>
        <p class="restaurant-rating">4.4 <img src="Resources/star.png" alt="Star Icon" style="width: 13px; padding-bottom: 5px;"></p>
      </div>
    </div>

    <div class="restaurant"> <!--R4 -->
      <div class="restaurant-image">
        <img src="Resources/R5.png" alt="Restaurant Image">
      </div>
      <div class="restaurant-details">
        <div class="restaurant-info">
          <div class="restaurant-icon">
            <img src="Resources/R2.png" alt="Restaurant Icon">
          </div>
          <div class="restaurant-text">
            <span class="restaurant-name" style="font-weight: bold;">Kababjees Restaurant</span>

            <p class="restaurant-type">BBQ, American</p>
          </div>
        </div>
        <p class="restaurant-rating">4.4 <img src="Resources/star.png" alt="Star Icon" style="width: 13px; padding-bottom: 5px;"></p>
      </div>
    </div>





  </div> <!--Recent Dine in End grid -->



  <br>
  <h2 class=" mb-4" style="margin-left: 5%;">All Restaurants</h2>
  <img src="Resources/Frame 150.png" style="margin-left: 50px;" alt="Restaurant Image">
  <br><br>
  <div class="restaurants-grid">
    <!-- Restaurant items here -->


    <?php include 'fetch_all_restaurant.php'; ?>




  </div> <!--END Restaurant items here -->

  <h3 class=" mb-4" style="margin-left: 5%;">Our top cities</h3>
  <img src="Resources/Our Top Cities.png" style="margin-left: 50px;" alt="Restaurant Image">
  <br>
  <br>
  <br><br>
  <br>
  <img src="Resources/Menu + Subscription.png" style="margin-left: 50px;" alt="Restaurant Image">

  <br>
  <br>
  <br>
  <br>
</body>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDP9cy_r8w6t7O0Wct3KmP0rPI0ISVQqks&libraries=places"></script>
<script>
  let latitude, longitude;

  // Function to initialize Google Places Autocomplete
  function initAutocomplete() {
    const input = document.getElementById('location-input');
    const latitudeInput = document.getElementById('latitude-input');
    const longitudeInput = document.getElementById('longitude-input');
    const options = {
      componentRestrictions: {
        country: 'us'
      },
      types: ['address'], // Restrict to addresses (no cities or regions)
      fields: ['place_id', 'geometry', 'name', 'formatted_address'],
    };
    const autocomplete = new google.maps.places.Autocomplete(input, options);

    // Get place details when user selects a place
    autocomplete.addListener('place_changed', function() {
      const place = autocomplete.getPlace();

      if (place.geometry) {
        const lat = place.geometry.location.lat();
        const lng = place.geometry.location.lng();

        latitudeInput.value = lat;
        longitudeInput.value = lng;
        alert(lat + "/" + lng);
      }
      console.log('Selected Place:', place.name);
    });
  }

  // Function to get user's current location
  function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition, showError);
    } else {
      alert("Geolocation is not supported by this browser.");
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
          document.getElementById('location-input').value = results[0].formatted_address;
          document.getElementById('latitude-input').value = latitude;
          document.getElementById('longitude-input').value = longitude;
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
    switch (error.code) {
      case error.PERMISSION_DENIED:
      //  alert("User denied the request for Geolocation.");
        break;
      case error.POSITION_UNAVAILABLE:
        //alert("Location information is unavailable.");
        break;
      case error.TIMEOUT:
        //alert("The request to get user location timed out.");
        break;
      case error.UNKNOWN_ERROR:
       // alert("An unknown error occurred.");
        break;
    }
  }

  // Initialize autocomplete and fetch the user's location on page load
  $(document).ready(function() {
    initAutocomplete();
    getLocation();
  });
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
<script>
  document.getElementById('restaurant-input1').addEventListener('input', function() {
    let query = this.value;
    if (query.length > 1) { // Trigger search when user types more than 1 character
      fetchRestaurants(query);
    }
  });

  function fetchRestaurants(query) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "search_restaurants.php", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    xhr.onload = function() {
      if (this.status === 200) {
        let results = JSON.parse(this.responseText);
        displaySuggestions(results);
      }
    };

    xhr.send("query=" + query);
  }

  function displaySuggestions(restaurants) {
    let suggestionBox = document.getElementById('suggestions');
    suggestionBox.innerHTML = ""; // Clear previous results
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
</script>

</html>