<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=cover">
  <meta name="description" content="FoodnPals Mobile">
  <meta name="robots" content="noindex, nofollow">
  <meta name="googlebot" content="noindex, nofollow">
  <title>FoodnPals - Mobile</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link rel="icon" type="image/png" sizes="16x16" href="favicon.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  
  <?php include 'fetch_cookies.php' ?>
  <?php include 'fetch_active_reservation.php' ?>
  
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
      background-color: #f8f9fa;
      overflow-x: hidden;
    }

    /* Header Section */
    .mobile-header {
      background: linear-gradient(135deg, #6FC945 0%, #4cbb17 100%);
      color: white;
      padding: 40px 20px 30px;
      border-radius: 0 0 25px 25px;
      position: relative;
    }

    .header-top {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
    }

    .location-info {
      display: flex;
      align-items: center;
      gap: 8px;
    }

    .location-icon {
      font-size: 18px;
      color: white;
    }

    .location-text {
      font-size: 16px;
      font-weight: 600;
    }

    .location-subtext {
      font-size: 12px;
      opacity: 0.8;
    }

    .profile-icon {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      border: 2px solid white;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
      cursor: pointer;
    }

    .profile-icon img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .header-greeting {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 8px;
      line-height: 1.3;
    }

    .header-subtitle {
      font-size: 16px;
      opacity: 0.9;
      margin-bottom: 25px;
    }

    /* Search Bar */
    .search-container {
      position: relative;
    }

    .search-box {
      background: white;
      border-radius: 25px;
      padding: 15px 20px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      display: flex;
      align-items: center;
      gap: 15px;
    }

    .search-input {
      flex: 1;
      border: none;
      outline: none;
      font-size: 16px;
      color: #333;
    }

    .search-input::placeholder {
      color: #999;
    }

    .search-icon {
      color: #4cbb17;
      font-size: 20px;
      cursor: pointer;
    }

    .suggestions-dropdown {
      position: absolute;
      top: 100%;
      left: 0;
      right: 0;
      background: white;
      border-radius: 15px;
      margin-top: 8px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
      z-index: 1000;
      max-height: 300px;
      overflow-y: auto;
      display: none;
    }

    .suggestion-item {
      padding: 15px 20px;
      cursor: pointer;
      border-bottom: 1px solid #f0f0f0;
      transition: background-color 0.2s;
      color:rgb(0, 0, 0);
    }

    .suggestion-item:hover {
      background-color: #f8f9fa;
    }

    .suggestion-item:last-child {
      border-bottom: none;
    }

    /* Collections Section */
    .collections-section {
      padding: 25px 20px;
    }

    .section-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 20px;
    }

    .section-title {
      font-size: 22px;
      font-weight: bold;
      color: #333;
    }

    .see-all {
      color: #4cbb17;
      font-size: 14px;
      font-weight: 600;
      text-decoration: none;
    }

    .collections-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin-bottom: 10px;
    }
    
    /* All collections grid */
    #all-collections {
      grid-template-columns: repeat(3, 1fr);
    }
    
    @media (min-width: 768px) {
      #all-collections {
        grid-template-columns: repeat(4, 1fr);
      }
    }

    .collection-item {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 15px;
      background: white;
      border-radius: 15px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
      cursor: pointer;
      transition: transform 0.2s, box-shadow 0.2s;
    }

    .collection-item:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 15px rgba(0,0,0,0.12);
    }

    .collection-icon {
      width: 50px;
      height: 50px;
      margin-bottom: 8px;
    }

    .collection-name {
      font-size: 14px;
      font-weight: 500;
      color: #333;
      text-align: center;
    }

    /* Popular Restaurants Section */
    .popular-section {
      padding: 0 20px 25px;
    }
    
    /* Restaurant carousel styles */
    .restaurant-carousel {
      overflow-x: auto;
      overflow-y: hidden;
      -webkit-overflow-scrolling: touch;
      padding-bottom: 10px;
    }
    
    .carousel-track {
      display: flex;
      gap: 16px;
      scroll-snap-type: x mandatory;
      padding: 4px 4px 4px 0;
    }
    
    .carousel-item {
      scroll-snap-align: start;
      flex: 0 0 80%;
      max-width: 80%;
    }
    
    .restaurant-carousel::-webkit-scrollbar {
      height: 8px;
    }
    
    .restaurant-carousel::-webkit-scrollbar-thumb {
      background: rgba(0,0,0,0.2);
      border-radius: 4px;
    }
    
    .cuisine-tag {
      display: inline-block;
      background-color: #4CBB17;
      color: white;
      padding: 3px 8px;
      margin: 2px;
      border-radius: 12px;
      font-size: 12px;
      font-weight: 500;
      box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }

    .restaurant-card {
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 3px 12px rgba(0,0,0,0.08);
      margin-bottom: 15px;
      position: relative;
    }

    .restaurant-image {
      width: 100%;
      height: 180px;
      object-fit: cover;
      position: relative;
    }

    .open-badge {
      position: absolute;
      top: 15px;
      left: 15px;
      background: #4cbb17;
      color: white;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: 600;
    }

    .restaurant-info {
      padding: 15px;
    }

    .restaurant-name {
      font-size: 18px;
      font-weight: bold;
      color: #333;
      margin-bottom: 5px;
    }

    .restaurant-details {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .restaurant-meta {
      display: flex;
      align-items: center;
      gap: 15px;
      font-size: 13px;
      color: #666;
    }

    .rating {
      display: flex;
      align-items: center;
      gap: 4px;
      background: #f8f9fa;
      padding: 4px 8px;
      border-radius: 12px;
    }

    .star {
      color: #ffc107;
      font-size: 12px;
    }

    .distance {
      font-weight: 500;
      color: #4cbb17;
    }

    /* All Restaurants Section */
    .all-restaurants-section {
      padding: 0 20px 25px;
    }

    .filter-bar {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
      overflow-x: auto;
      padding-bottom: 5px;
    }

    .filter-btn {
      background: white;
      border: 1px solid #e0e0e0;
      padding: 8px 16px;
      border-radius: 20px;
      font-size: 14px;
      white-space: nowrap;
      cursor: pointer;
      transition: all 0.2s;
    }

    .filter-btn.active {
      background: #4cbb17;
      color: white;
      border-color: #4cbb17;
    }

    /* Restaurant Details */
    .restaurant-details {
      flex: 1;
    }

    .restaurant-name {
      font-weight: 600;
      font-size: 16px;
      color: #333;
      margin-bottom: 2px;
    }

    .reservation-time {
      font-size: 13px;
      color: #666;
    }

    /* Loading spinner */
    .loading-spinner {
      display: flex;
      justify-content: center;
      padding: 20px;
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

    /* Hide scrollbars */
    .filter-bar::-webkit-scrollbar {
      display: none;
    }

    .suggestions-dropdown::-webkit-scrollbar {
      width: 6px;
    }

    .suggestions-dropdown::-webkit-scrollbar-track {
      background: #f1f1f1;
      border-radius: 3px;
    }

    .suggestions-dropdown::-webkit-scrollbar-thumb {
      background: #ccc;
      border-radius: 3px;
    }
  </style>
</head>

<body>
  <!-- Header Section -->
  <div class="mobile-header">
    <div class="header-top">
      <div class="location-info">
        <i class="fas fa-map-marker-alt location-icon"></i>
        <div>
          <div class="location-text">Your Location</div>
          <div class="location-subtext">Michighan</div>
        </div>
      </div>
      <div class="profile-icon" onclick="toggleProfile()">
        <?php 
        $profilePath = 'AppUsers/uploads/' . $profilePictureURL;
        if (!empty($profilePictureURL) && file_exists($profilePath)) {
            echo '<img src="' . $profilePath . '" alt="Profile">';
        } else {
            echo '<i class="fas fa-user-circle" style="font-size: 24px; color: white;"></i>';
        }
        ?>
      </div>
    </div>

    <div class="header-greeting">
    Transforming traditional dining into tech!
    </div>
    <!-- <div class="header-subtitle">
      What do you want to eat?
    </div> -->

    <!-- Search Bar -->
    <div class="search-container">
      <div class="search-box">
        <input 
          type="text" 
          class="search-input" 
          id="restaurant-input" 
          placeholder="Search restaurant, menu or etc"
          autocomplete="off"
        >
        <i class="fas fa-search search-icon" onclick="performSearch()"></i>
      </div>
      <div id="suggestions" class="suggestions-dropdown"></div>
    </div>
  </div>

  <!-- Collections Section -->
  <div class="collections-section">
    <div class="section-header">
      <div class="section-title">Collection</div>
      <a href="#" class="see-all" onclick="toggleAllCollections(); return false;">See All</a>
    </div>
    
    <!-- Default 6 collections grid -->
    <div class="collections-grid" id="default-collections">
      <div class="collection-item" onclick="redirectToExplore('Chinese')">
        <img src="Resources/food icons/Chinses.svg" alt="Chinese" class="collection-icon">
        <div class="collection-name">Chinese</div>
      </div>
      <div class="collection-item" onclick="redirectToExplore('American')">
        <img src="Resources/food icons/sandwich.svg" alt="American" class="collection-icon">
        <div class="collection-name">American</div>
      </div>
      <div class="collection-item" onclick="redirectToExplore('Thai')">
        <img src="Resources/food icons/Asian.svg" alt="Thai" class="collection-icon">
        <div class="collection-name">Thai</div>
      </div>
      <div class="collection-item" onclick="redirectToExplore('Coffee')">
        <img src="Resources/food icons/coffee.png" alt="Coffee" class="collection-icon">
        <div class="collection-name">Coffee</div>
      </div>
      <div class="collection-item" onclick="redirectToExplore('Italian')">
        <img src="Resources/food icons/Italian.svg" alt="Italian" class="collection-icon">
        <div class="collection-name">Italian</div>
      </div>
      <div class="collection-item" onclick="redirectToExplore('Sea food')">
        <img src="Resources/food icons/Sea food.svg" alt="Seafood" class="collection-icon">
        <div class="collection-name">Seafood</div>
      </div>
    </div>
    
    <!-- Extended collections grid (initially hidden) -->
    <div class="collections-grid" id="all-collections" style="display: none;">
      <div class="collection-item" onclick="redirectToExplore('Chinese')">
        <img src="Resources/food icons/Chinses.svg" alt="Chinese" class="collection-icon">
        <div class="collection-name">Chinese</div>
      </div>
      <div class="collection-item" onclick="redirectToExplore('American')">
        <img src="Resources/food icons/sandwich.svg" alt="American" class="collection-icon">
        <div class="collection-name">American</div>
      </div>
      <div class="collection-item" onclick="redirectToExplore('Thai')">
        <img src="Resources/food icons/Asian.svg" alt="Thai" class="collection-icon">
        <div class="collection-name">Thai</div>
      </div>
      <div class="collection-item" onclick="redirectToExplore('Coffee')">
        <img src="Resources/food icons/coffee.png" alt="Coffee" class="collection-icon">
        <div class="collection-name">Coffee</div>
      </div>
      <div class="collection-item" onclick="redirectToExplore('Italian')">
        <img src="Resources/food icons/Italian.svg" alt="Italian" class="collection-icon">
        <div class="collection-name">Italian</div>
      </div>
      <div class="collection-item" onclick="redirectToExplore('Sea food')">
        <img src="Resources/food icons/Sea food.svg" alt="Seafood" class="collection-icon">
        <div class="collection-name">Seafood</div>
      </div>
      <div class="collection-item" onclick="redirectToExplore('Breakfast')">
        <img src="Resources/food icons/Breakfast.svg" alt="Breakfast" class="collection-icon">
        <div class="collection-name">Breakfast</div>
      </div>
      <div class="collection-item" onclick="redirectToExplore('Mediterranean')">
        <img src="Resources/food icons/BBQ.png" alt="Mediterranean" class="collection-icon">
        <div style="font-size: 10px;" class="collection-name">Mediterranean</div>
      </div>
      <div class="collection-item" onclick="redirectToExplore('Asian')">
        <img src="Resources/food icons/Asian.svg" alt="Asian" class="collection-icon">
        <div class="collection-name">Asian</div>
      </div>
      <div class="collection-item" onclick="redirectToExplore('Halal')">
        <img src="Resources/food icons/Halal.svg" alt="Halal" class="collection-icon">
        <div class="collection-name">Halal</div>
      </div>
      <div class="collection-item" onclick="redirectToExplore('Vegan')">
        <img src="Resources/food icons/11.png" alt="Vegan" class="collection-icon">
        <div class="collection-name">Vegan</div>
      </div>
      <div class="collection-item" onclick="redirectToExplore('Pakistani')">
        <img src="Resources/food icons/5.png" alt="Pakistani" class="collection-icon">
        <div class="collection-name">Pakistani</div>
      </div>
      <div class="collection-item" onclick="redirectToExplore('Salad')">
        <img src="Resources/food icons/12.png" alt="Salad" class="collection-icon">
        <div class="collection-name">Salad</div>
      </div>
      <div class="collection-item" onclick="redirectToExplore('Indian')">
        <img src="Resources/food icons/indian.png" alt="Indian" class="collection-icon">
        <div class="collection-name">Indian</div>
      </div>
    </div>
  </div>

  <!-- Popular Restaurants Section -->
  <div hidden class="popular-section">
    <div class="section-header">
      <div class="section-title">Popular Restaurants</div>
      <a href="#" class="see-all">See All</a>
    </div>
    
    <div class="popular-restaurants">
      <?php include 'fetch_4_restaurant.php'; ?>
    </div>
  </div>

  <!-- All Restaurants Section -->
  <div class="all-restaurants-section">
    <div class="section-header">
      <div class="section-title" id="allrestaurants">All Restaurant</div>
    </div>
    
    <div class="filter-bar">
      <button class="filter-btn active">
        <i class="fas fa-filter"></i> Filter
      </button>
      <button class="filter-btn">Sort By</button>
      <button class="filter-btn">Rating</button>
      <button class="filter-btn">Near</button>
    </div>
    
    <div class="all-restaurants">
      <?php include 'fetch_all_restaurant.php'; ?>
    </div>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script>
    // Toggle between default and all collections
    function toggleAllCollections() {
      const defaultCollections = document.getElementById('default-collections');
      const allCollections = document.getElementById('all-collections');
      const seeAllLink = document.querySelector('.see-all');
      
      if (allCollections.style.display === 'none') {
        defaultCollections.style.display = 'none';
        allCollections.style.display = 'grid';
        seeAllLink.textContent = 'Show Less';
      } else {
        defaultCollections.style.display = 'grid';
        allCollections.style.display = 'none';
        seeAllLink.textContent = 'See All';
      }
    }
    
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
    
    // Search functionality
    document.getElementById('restaurant-input').addEventListener('input', function() {
      let query = this.value;
      if (query.length > 1) {
        fetchRestaurants(query);
      } else {
        hideDropdown();
      }
    });

    document.getElementById('restaurant-input').addEventListener('keypress', function(e) {
      if (e.key === 'Enter') {
        performSearch();
      }
    });

    function performSearch() {
      const query = document.getElementById('restaurant-input').value;
      if (query.trim().length > 0) {
        // Update URL without page reload
        const newUrl = window.location.pathname + "?search=" + encodeURIComponent(query);
        window.history.pushState({ path: newUrl }, '', newUrl);
        
        // Update the section title
        document.getElementById('allrestaurants').textContent = 'Search Result For: ' + query;
        
        // Show loading indicator
        document.querySelector('.all-restaurants').innerHTML = '<div class="loading-spinner" style="margin: 30px auto;"></div>';
        
        // Hide dropdown
        hideDropdown();
        
        // Make AJAX request
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "search_restaurants.php", true);
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        
        xhr.onload = function() {
          if (this.status === 200) {
            let results = JSON.parse(this.responseText);
            displayRestaurants(results);
          } else {
            document.querySelector('.all-restaurants').innerHTML = "<div style='text-align:center; padding:20px;'>Error loading results</div>";
          }
        };
        
        xhr.onerror = function() {
          document.querySelector('.all-restaurants').innerHTML = "<div style='text-align:center; padding:20px;'>Error loading results</div>";
        };
        
        xhr.send("query=" + query);
        
        // Scroll to results section
        document.getElementById('allrestaurants').scrollIntoView({ behavior: 'smooth' });
      }
    }

    function fetchRestaurants(query) {
      const suggestionBox = document.getElementById('suggestions');
      
      suggestionBox.innerHTML = '<div class="loading-spinner"></div>';
      suggestionBox.style.display = "block";
      
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "search_restaurants.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

      xhr.onload = function() {
        if (this.status === 200) {
          let results = JSON.parse(this.responseText);
          displaySuggestions(results);
        } else {
          suggestionBox.innerHTML = "<div class='suggestion-item'>Error loading results</div>";
        }
      };
      
      xhr.onerror = function() {
        suggestionBox.innerHTML = "<div class='suggestion-item'>Error loading results</div>";
      };

      xhr.send("query=" + query);
    }

    function displaySuggestions(restaurants) {
      let suggestionBox = document.getElementById('suggestions');
      suggestionBox.innerHTML = "";
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
        suggestionBox.innerHTML = "<div class='suggestion-item'>No restaurants found</div>";
      }
    }

    function hideDropdown() {
      document.getElementById('suggestions').style.display = "none";
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
      const dropdown = document.getElementById('suggestions');
      const input = document.getElementById('restaurant-input');
      
      if (!event.target.closest('#restaurant-input') && 
          !event.target.closest('#suggestions') && 
          dropdown.style.display === 'block') {
        hideDropdown();
      }
    });

    // Collection filter using AJAX
    function redirectToExplore(foodType) {
      // Update the search input field
      document.getElementById('restaurant-input').value = foodType;
      
      // Update the section title to show what's being filtered
      document.getElementById('allrestaurants').textContent = 'Search Result For: ' + foodType;
      
      // Show loading indicator in the all-restaurants section
      document.querySelector('.all-restaurants').innerHTML = '<div class="loading-spinner" style="margin: 30px auto;"></div>';
      
      // Make AJAX request to search restaurants
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "search_restaurants.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      
      xhr.onload = function() {
        if (this.status === 200) {
          let results = JSON.parse(this.responseText);
          displayRestaurants(results);
        } else {
          document.querySelector('.all-restaurants').innerHTML = "<div style='text-align:center; padding:20px;'>Error loading results</div>";
        }
      };
      
      xhr.onerror = function() {
        document.querySelector('.all-restaurants').innerHTML = "<div style='text-align:center; padding:20px;'>Error loading results</div>";
      };
      
      xhr.send("query=" + foodType);
      
      // Scroll to the results section
      document.getElementById('allrestaurants').scrollIntoView({ behavior: 'smooth' });
    }
    
    // Display restaurant results
    function displayRestaurants(restaurants) {
      const restaurantsContainer = document.querySelector('.all-restaurants');
      
      if (restaurants.length > 0) {
        let html = '';
        
        restaurants.forEach(restaurant => {
          // Get image paths with fallbacks
          const thumbnail = restaurant.Thumbnail ? `Resources/icons/${restaurant.Thumbnail}` : 'Resources/R1.png';
          
          // Format rating with stars
          const rating = parseFloat(restaurant.AverageRating) || 4.5;
          
          html += `
            <div class="restaurant-card">
              <a href="Profile.php?ID=${restaurant.RestaurantID}" style="text-decoration:none; color:inherit;">
                <div style="position:relative;">
                  <img src="${thumbnail}" alt="${restaurant.Name}" class="restaurant-image">
                  <div class="open-badge">Open</div>
                </div>
                <div class="restaurant-info">
                  <div class="restaurant-name">${restaurant.Name}</div>
                  <div class="restaurant-details">
                    <div class="restaurant-meta">
                      <div class="rating">
                        <i class="fas fa-star star"></i>
                        <span>${rating.toFixed(1)}</span>
                      </div>
                    </div>
                  </div>
                  <p style="margin-top:10px;">
                    ${restaurant.CuisineType.split(',').map(cuisine => 
                      `<span class="cuisine-tag">${cuisine.trim()}</span>`
                    ).join(' ')}
                  </p>
                  <p style="margin-top:5px; font-size:13px; color:#666;">
                    <i class="fas fa-map-marker-alt" style="color: #4CBB17; margin-right: 5px;"></i> ${restaurant.Location || restaurant.Address}
                  </p>
                </div>
              </a>
            </div>
          `;
        });
        
        restaurantsContainer.innerHTML = html;
      } else {
        restaurantsContainer.innerHTML = "<div style='text-align:center; padding:20px;'>No restaurants found</div>";
      }
    }

    // Profile toggle (you can customize this)
    function toggleProfile() {
      // Add your profile menu logic here
      <?php if (isset($_COOKIE['UserID']) && $_COOKIE['UserID']): ?>
        window.location.href = "CustomerProfile.php";
      <?php else: ?>
        window.location.href = "Login.html";
      <?php endif; ?>
    }

    // Active booking banner click
    document.addEventListener('DOMContentLoaded', function() {
      const activeBookingBanner = document.getElementById('active-booking-banner');
      <?php if (!empty($activeReservation)): ?>
        const reservationId = <?php echo json_encode($activeReservation); ?>;
        if (activeBookingBanner) {
          activeBookingBanner.addEventListener('click', function() {
            window.location.href = 'Confirmation.php?ID=' + reservationId;
          });
        }
      <?php endif; ?>
    });

    // Handle search parameter in URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('search')) {
      const searchValue = urlParams.get('search');
      document.getElementById('allrestaurants').textContent = 'Search Result For: ' + searchValue;
      document.getElementById('restaurant-input').value = searchValue;
      
      // Load search results via AJAX if search parameter exists
      const xhr = new XMLHttpRequest();
      xhr.open("POST", "search_restaurants.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      
      xhr.onload = function() {
        if (this.status === 200) {
          let results = JSON.parse(this.responseText);
          displayRestaurants(results);
        }
      };
      
      xhr.send("query=" + searchValue);
    }

    // Location update (same as original)
    function updateLocationCookies() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          var longitude = position.coords.longitude;
          var latitude = position.coords.latitude;

          document.cookie = "Longitude=" + longitude + "; path=/; max-age=" + 60 * 60 * 24 * 30;
          document.cookie = "Latitude=" + latitude + "; path=/; max-age=" + 60 * 60 * 24 * 30;
        }, function(error) {
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
        }, {
          enableHighAccuracy: true,
          timeout: 10000,
          maximumAge: 0
        });
      } else {
          console.error("Geolocation is not supported by this browser.");
      }
    }

    setInterval(updateLocationCookies, 20000);
    updateLocationCookies();
  </script>
  
  <!-- Active Reservation Banner -->
  <?php include 'active_booking_banner.php' ?>
</body>
</html>