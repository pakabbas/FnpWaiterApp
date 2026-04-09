<!DOCTYPE html>
<html lang="en">
<head>
    <?php session_start(); ?>
    <?php include 'admin/TableStatus.php'; ?>
    <meta charset="UTF-8">
    <meta name="description" content="FoodnPals">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>FoodnPals - Restaurant</title>
    
    <!-- CSS Links -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon.png">
    
    <!-- JS Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background:rgb(243, 243, 243);
            overflow-x: hidden;
        }
        
        .mobile-container {
            max-width: 100vw;
            margin: 0 auto;
            background-color: rgb(243, 243, 243);
            min-height: 100vh;
        }
        
        .restaurant-header {
            position: relative;
            height: 250px;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
        
        .restaurant-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.7));
            padding: 20px;
            color: white;
        }
        
        .restaurant-info {
            padding: 20px;
            background:rgb(243, 243, 243);
            margin: -30px 2px 0 2px;
            border-radius: 16px;
            /* box-shadow: 0 2px 20px rgba(0,0,0,0.1); */
            position: relative;
            z-index: 10;
        }
        
        .restaurant-name {
            font-size: 24px;
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
        }
        
        .restaurant-rating {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
        }
        
        .rating-text {
            margin-left: 8px;
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }
        
        .cuisine-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 12px;
        }
        
        .cuisine-tag {
            background-color: #f0f9ff;
            color: #4CBB17;
            border: 1px solid #e0f2e7;
            border-radius: 20px;
            padding: 6px 12px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .restaurant-address {
            display: flex;
            align-items: center;
            color: #666;
            font-size: 14px;
        }
        
        .restaurant-address i {
            color: #4CBB17;
            margin-right: 8px;
            font-size: 16px;
        }
        
        .distance-text {
            color: #999;
            font-size: 12px;
            margin-left: auto;
        }
        
        .expandable-sections {
            padding: 0 16px 20px 16px;
        }
        
        .section-item {
            background: rgb(243, 243, 243);
            border-radius: 12px;
            margin-bottom: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            overflow: hidden;
        }
        
        .section-header {
            padding: 16px;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.2s;
        }
        
        .section-header:hover {
            background-color: #f8f9fa;
        }
        
        .section-title {
            display: flex;
            align-items: center;
            font-size: 16px;
            font-weight: 600;
            color: #333;
        }
        
        .section-title i {
            color: #4CBB17;
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }
        
        .section-arrow {
            color: #999;
            transition: transform 0.3s ease;
            font-size: 14px;
        }
        
        .section-arrow.expanded {
            transform: rotate(180deg);
        }
        
        .section-content {
            display: none;
            padding: 0 16px 16px 16px;
            animation: slideDown 0.3s ease-out;
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                max-height: 0;
            }
            to {
                opacity: 1;
                max-height: 500px;
            }
        }
        
        /* Floating banner styles */
        .floating-banner {
            position: fixed;
            bottom: calc(5px + 1vh); /* 1% higher from bottom */
            left: 16px;
            right: 16px;
            background: white;
            border: 2px solid #4cbb17;
            border-radius: 12px;
            padding: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.15);
            z-index: 1001;
            cursor: pointer;
        }
        
        .banner-header {
            font-size: 14px;
            font-weight: 600;
            color: #4cbb17;
            margin-bottom: 8px;
        }
        
        .banner-content {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        
        .restaurant-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
        }
        
        .book-button {
            position: fixed;
            bottom: 20px;
            left: 16px;
            right: 16px;
            background: linear-gradient(135deg, #4CBB17 0%, #45a716 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 16px;
            font-size: 16px;
            font-weight: 600;
            box-shadow: 0 4px 20px rgba(76, 187, 23, 0.3);
            z-index: 1000;
            transition: all 0.3s ease;
        }
        
        .book-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(76, 187, 23, 0.4);
        }
        
        .table-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 12px;
            padding: 16px 0;
        }
        
        .table-card {
            background: rgb(243, 243, 243);
            border-radius: 12px;
            padding: 16px;
            border: 1px solid #e0e0e0;
            transition: all 0.3s ease;
        }
        
        .table-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }
        
        .menu-grid {
            display: grid;
            gap: 12px;
            padding: 16px 0;
        }
        
        .menu-item {
            display: flex;
            background: rgb(243, 243, 243);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }
        
        .menu-item:hover {
            transform: scale(1.02);
        }
        
        .menu-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
        }
        
        .menu-item-info {
            flex: 1;
            padding: 12px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        
        .menu-item-name {
            font-size: 14px;
            font-weight: 600;
            color: #333;
            margin-bottom: 4px;
        }
        
        .menu-item-desc {
            font-size: 12px;
            color: #666;
            margin-bottom: 8px;
            line-height: 1.3;
        }
        
        .menu-item-price {
            font-size: 14px;
            font-weight: 700;
            color: #4CBB17;
        }
        
        .photo-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 8px;
            padding: 16px 0;
        }
        
        .photo-grid img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
        }
        
        .review-item {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 12px;
        }
        
        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }
        
        .review-name {
            font-weight: 600;
            color: #333;
        }
        
        .review-stars {
            color: #FFD700;
        }
        
        .review-text {
            color: #666;
            font-size: 14px;
            line-height: 1.4;
        }
        
        .bottom-padding {
            height: 100px;
        }
        
        /* Cart icon styles */
        .cart-icon {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: rgb(243, 243, 243);
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.15);
            text-decoration: none;
        }
        
        .cart-icon i {
            color: #4CBB17;
            font-size: 20px;
        }
        
        .cart-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #ff4757;
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 11px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        /* Back button */
        .back-button {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1000;
            background: rgba(0,0,0,0.5);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            color: white;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        

    </style>
</head>

<body>
    <?php include 'fetch_active_reservation.php' ?>
    <?php include 'fetch_cookies.php' ?>
    <?php include 'fetch_restaurant.php' ?>
    
    <!-- Active Reservation Banner -->
    <?php include 'active_booking_banner.php' ?>
    
    <!-- Back Button -->
    <button class="back-button" onclick="history.back()">
        <i class="fas fa-arrow-left"></i>
    </button>
    
    <!-- Cart Icon (only show if user has active reservation at this restaurant) -->
    <?php if (isset($isReservationActive) && $isReservationActive == "Yes" && $activeReservationRestaurant == $restaurant['RestaurantID']): ?>
    <a href="#" onclick="$('#smallmodal').modal('show'); return false;" class="cart-icon">
        <i class="fas fa-shopping-cart"></i>
        <span id="cartCount" class="cart-count" style="display: none;"></span>
    </a>
    <?php endif; ?>

    <div class="mobile-container">
        <!-- Restaurant Header Image -->
        <?php
        $bannerFile = $restaurant['RestaurantBanner'];
        $bannerPath = "Resources/icons/" . $bannerFile;
        $defaultPath = "Resources/R1.png";
        $bgImage = file_exists($bannerPath) ? $bannerPath : $defaultPath;
        ?>
        
        <div class="restaurant-header" style="background-image: url('<?php echo $bgImage; ?>');">
            <div class="restaurant-overlay">
                <!-- Optional overlay content -->
            </div>
        </div>
        
        <!-- Restaurant Info Card -->
        <div class="restaurant-info">
            <h1 class="restaurant-name"><?php echo htmlspecialchars($restaurant['Name']); ?></h1>
            
            <div class="restaurant-rating">
                <div id="stars-container" style="display: flex; align-items: center;">
                <?php
                $rating = floatval($restaurant['AverageRating']);
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $rating) {
                        echo '<i class="fas fa-star" style="color: #FFD700;"></i>';
                    } elseif ($i - 0.5 <= $rating) {
                        echo '<i class="fas fa-star-half-alt" style="color: #FFD700;"></i>';
                    } else {
                        echo '<i class="far fa-star" style="color: #FFD700;"></i>';
                    }
                }
                ?>
                </div>
                <span class="rating-text" id="rating-text-container"><?php echo number_format($restaurant['AverageRating'], 1); ?> (367 Reviews)</span>
            </div>
            
            <div class="cuisine-tags">
                <?php 
                $cuisineTypes = explode(',', $restaurant['CuisineType']);
                foreach ($cuisineTypes as $cuisine) {
                    $cuisine = trim($cuisine);
                    if (!empty($cuisine)) {
                        echo '<span class="cuisine-tag">' . htmlspecialchars($cuisine) . '</span>';
                    }
                }
                ?>
            </div>
            
            <div class="restaurant-address">
                <i class="fas fa-map-marker-alt"></i>
                <span><?php echo htmlspecialchars($restaurant['Address'].", ".$restaurant['City'].", ".$restaurant['State']." ".$restaurant['Country']); ?></span>
                <span class="distance-text"></span>
            </div>
        </div>
        
        <!-- Expandable Sections -->
        <div class="expandable-sections">
            <!-- Table Availability Section -->
            <div class="section-item">
                <div class="section-header" onclick="toggleSection('tables')">
                    <div class="section-title">
                        <i class="fas fa-chair"></i>
                        Table Availability
                    </div>
                    <i class="fas fa-chevron-down section-arrow" id="tables-arrow"></i>
                </div>
                <div class="section-content" id="tables-content">
                    <?php include 'fetch_dining_tables2.php'; ?>
                </div>
            </div>
            
            <!-- Menu Section -->
            <div class="section-item">
                <div class="section-header" onclick="toggleSection('menu')">
                    <div class="section-title">
                        <i class="fas fa-utensils"></i>
                        Menu
                    </div>
                    <i class="fas fa-chevron-down section-arrow" id="menu-arrow"></i>
                </div>
                <div class="section-content" id="menu-content">
                    <div class="menu-grid">
                        <?php include 'fetch_menu2.php'; ?>
                    </div>
                    
                    <?php if (isset($isReservationActive) && $isReservationActive == "Yes" && $activeReservationRestaurant == $restaurantID): ?>
                    <div style="text-align: center; margin-top: 20px;">
                        <button type="button" class="btn" data-toggle="modal" data-target="#smallmodal" style="
                            background: linear-gradient(135deg, #4CBB17 0%, #45a716 100%);
                            color: white;
                            border: none;
                            border-radius: 50px;
                            padding: 12px 25px;
                            font-weight: 600;
                            font-size: 14px;
                        ">
                            <i class="fas fa-shopping-cart mr-2"></i>
                            View Cart
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Description Section -->
            <div class="section-item">
                <div class="section-header" onclick="toggleSection('description')">
                    <div class="section-title">
                        <i class="fas fa-info-circle"></i>
                        Description
                    </div>
                    <i class="fas fa-chevron-down section-arrow" id="description-arrow"></i>
                </div>
                <div class="section-content" id="description-content">
                    <p style="color: #666; line-height: 1.5; font-size: 14px; margin-bottom: 20px;">
                        <?php echo htmlspecialchars($restaurant['AdditionalInformation']); ?>
                    </p>
                    
                    <!-- Google Map -->
                    <?php if (!empty($restaurant['Latitude']) && !empty($restaurant['Longitude'])): ?>
                    <div style="margin-bottom: 20px;">
                        <h6 style="font-size: 16px; font-weight: 600; color: #333; margin-bottom: 10px;">
                            <i class="fas fa-map-marker-alt" style="color: #4CBB17; margin-right: 8px;"></i>Location
                        </h6>
                        <div id="restaurant-map" style="width: 100%; height: 200px; border-radius: 10px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1);"></div>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Restaurant Details -->
                    <div style="display: grid; gap: 15px;">
                        <!-- Opening Hours -->
                        <?php if (!empty($restaurant['OpeningTime']) && !empty($restaurant['ClosingTime'])): ?>
                        <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; border-left: 4px solid #4CBB17;">
                            <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                <i class="fas fa-clock" style="color: #4CBB17; margin-right: 10px; font-size: 16px;"></i>
                                <h6 style="margin: 0; font-size: 14px; font-weight: 600; color: #333;">Opening Hours</h6>
                            </div>
                            <p style="margin: 0; font-size: 14px; color: #666;">
                                <?php echo htmlspecialchars($restaurant['OpeningTime']); ?> - <?php echo htmlspecialchars($restaurant['ClosingTime']); ?>
                            </p>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Parking Availability -->
                        <?php if (!empty($restaurant['ParkingAvailability'])): ?>
                        <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; border-left: 4px solid #4CBB17;">
                            <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                <i class="fas fa-parking" style="color: #4CBB17; margin-right: 10px; font-size: 16px;"></i>
                                <h6 style="margin: 0; font-size: 14px; font-weight: 600; color: #333;">Parking</h6>
                            </div>
                            <p style="margin: 0; font-size: 14px; color: #666;">
                                <?php echo htmlspecialchars($restaurant['ParkingAvailability']); ?>
                            </p>
                        </div>
                        <?php endif; ?>
                        
                        <!-- Smoking Policy -->
                        <?php if (!empty($restaurant['SmokingPolicy'])): ?>
                        <div style="background: #f8f9fa; padding: 15px; border-radius: 10px; border-left: 4px solid #4CBB17;">
                            <div style="display: flex; align-items: center; margin-bottom: 8px;">
                                <i class="fas fa-smoking-ban" style="color: #4CBB17; margin-right: 10px; font-size: 16px;"></i>
                                <h6 style="margin: 0; font-size: 14px; font-weight: 600; color: #333;">Smoking Policy</h6>
                            </div>
                            <p style="margin: 0; font-size: 14px; color: #666;">
                                <?php echo htmlspecialchars($restaurant['SmokingPolicy']); ?>
                            </p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Reviews Section -->
            <div class="section-item">
                <div class="section-header" onclick="toggleSection('reviews')">
                    <div class="section-title">
                        <i class="fas fa-star"></i>
                        Reviews
                    </div>
                    <i class="fas fa-chevron-down section-arrow" id="reviews-arrow"></i>
                </div>
                <div class="section-content" id="reviews-content">
                    <?php
                    $restaurantID = isset($_GET['ID']) ? $_GET['ID'] : null;
                    if ($restaurantID) {
                        include 'ReviewsGrid1.php';
                    }
                    ?>
                </div>
            </div>
            
            <!-- Photos Section -->
            <div class="section-item">
                <div class="section-header" onclick="toggleSection('photos')">
                    <div class="section-title">
                        <i class="fas fa-camera"></i>
                        Photos
                    </div>
                    <i class="fas fa-chevron-down section-arrow" id="photos-arrow"></i>
                </div>
                <div class="section-content" id="photos-content">
                    <div class="photo-grid">
                        <?php
                        for ($i = 1; $i <= 6; $i++) {
                            echo '<img src="Resources/restaurantImages/' . $i . '.png" alt="Photo ' . $i . '">';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bottom Padding -->
        <div class="bottom-padding"></div>
        
        <!-- Book A Table Button -->
        <?php if (isset($isReservationActive) && $isReservationActive !== "Yes"): ?>
        <button class="book-button" onclick="openSection('tables')">
            <i class="fas fa-calendar-check mr-2"></i>
            Book A Table
        </button>
        <?php endif; ?>
    </div>

    <!-- JavaScript Functions -->
    <script>
        // Close banner functionality and default section opening
        document.addEventListener('DOMContentLoaded', function() {
            const closeBanner = document.getElementById('close-banner');
            const banner = document.getElementById('active-booking-banner');
            
            if (closeBanner && banner) {
                closeBanner.addEventListener('click', function(e) {
                    e.stopPropagation(); // Prevent banner click event from firing
                    banner.style.display = 'none';
                });
            }
            
            // Make the banner clickable to go to the reservation page
            if (banner) {
                banner.addEventListener('click', function() {
                    window.location.href = 'Confirmation.php?ID=<?php echo $activeReservation; ?>';
                });
            }
            
            // Check URL parameters to determine which section to open by default
            const urlParams = new URLSearchParams(window.location.search);
            const menuParam = urlParams.get('menu');
            
            // Default section to open (tables if no menu parameter, menu if menu=1)
            const defaultSection = menuParam === '1' ? 'menu' : 'tables';
            
            // Open the default section
            setTimeout(() => {
                const content = document.getElementById(defaultSection + '-content');
                const arrow = document.getElementById(defaultSection + '-arrow');
                
                if (content && arrow) {
                    content.style.display = 'block';
                    arrow.classList.add('expanded');
                }
            }, 100);
        });
    
        function toggleSection(sectionName) {
            const content = document.getElementById(sectionName + '-content');
            const arrow = document.getElementById(sectionName + '-arrow');
            
            // Close all other sections first
            const allSections = ['tables', 'menu', 'description', 'reviews', 'photos'];
            allSections.forEach(section => {
                if (section !== sectionName) {
                    const otherContent = document.getElementById(section + '-content');
                    const otherArrow = document.getElementById(section + '-arrow');
                    if (otherContent) {
                        otherContent.style.display = 'none';
                    }
                    if (otherArrow) {
                        otherArrow.classList.remove('expanded');
                    }
                }
            });
            
            // Toggle the clicked section
            if (content.style.display === 'none' || content.style.display === '') {
                content.style.display = 'block';
                arrow.classList.add('expanded');
            } else {
                content.style.display = 'none';
                arrow.classList.remove('expanded');
            }
        }
        
        function openSection(sectionName) {
            // First scroll to the section
            const section = document.querySelector(`[onclick="toggleSection('${sectionName}')"]`).closest('.section-item');
            section.scrollIntoView({ behavior: 'smooth', block: 'start' });
            
            // Then open it after a short delay
            setTimeout(() => {
                const content = document.getElementById(sectionName + '-content');
                const arrow = document.getElementById(sectionName + '-arrow');
                
                if (content.style.display === 'none' || content.style.display === '') {
                    content.style.display = 'block';
                    arrow.classList.add('expanded');
                }
            }, 500);
        }
        
        // Cart functions
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
        
        function scrollToCheckout(tableID, TableID2, isLoggedIn) {
            if (!isLoggedIn) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Please Log in first to book a table.',
                    confirmButtonColor: '#4CBB17'
                });
                return;
            }

            $.ajax({
                url: 'fetch_last_reservation.php',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        if (!response.canBook) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Booking Limit Reached',
                                text: 'You cannot create another booking now. Please try again later...',
                                confirmButtonColor: '#4CBB17'
                            });
                        } else {
                            var TableID = document.getElementById('TableID');
                            if (TableID) {
                                TableID.value = TableID2;
                                var tableTextbox = document.getElementById('selected-table');
                                tableTextbox.value = tableID;
                                $('#checkoutModal').modal('show');
                            }
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX error:', error);
                }
            });
        }
        
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
            if (modal) {
                // Remove any existing aria-hidden attributes
                modal.removeAttribute('aria-hidden');
                modal.style.display = 'block';
                
                // Make sure no other modals are visible
                const checkoutModal = document.getElementById('checkoutModal');
                if (checkoutModal && checkoutModal.classList.contains('show')) {
                    $('#checkoutModal').modal('hide');
                }
                
                setTimeout(() => {
                    if (typeof initBookingMap === 'function') {
                        initBookingMap();
                    }
                }, 300);
            }
        }
        
        function closeBookingModal() {
            const modal = document.getElementById('bookingConfirmationModal');
            if (modal) {
                modal.style.display = 'none';
            }
        }
        
        function submitBooking() {
            const loadingOverlay = document.getElementById('loadingOverlay');
            if (loadingOverlay) {
                loadingOverlay.style.display = 'flex';
            }
            closeBookingModal();
            const checkoutForm = document.getElementById('checkoutForm');
            if (checkoutForm) {
                checkoutForm.submit();
            }
        }
        
        // Initialize cart count on page load
        $(document).ready(function() {
            updateCartCount();
            
            $('#smallmodal').on('show.bs.modal', function() {
                updateCartModal();
            });
        });
        
        // Google Maps initialization for restaurant description
        function initMap() {
            calculateAndDisplayDistance();
            
            <?php if (!empty($restaurant['Latitude']) && !empty($restaurant['Longitude'])): ?>
            const restaurantLocation = {
                lat: parseFloat(<?php echo $restaurant['Latitude']; ?>),
                lng: parseFloat(<?php echo $restaurant['Longitude']; ?>)
            };
            
            const map = new google.maps.Map(document.getElementById('restaurant-map'), {
                zoom: 15,
                center: restaurantLocation,
                mapTypeId: 'roadmap',
                styles: [
                    {
                        featureType: 'poi',
                        elementType: 'labels',
                        stylers: [{ visibility: 'off' }]
                    }
                ]
            });
            
            const marker = new google.maps.Marker({
                position: restaurantLocation,
                map: map,
                title: '<?php echo addslashes($restaurant['Name']); ?>',
                icon: {
                    url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                        <svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="20" cy="20" r="18" fill="#4CBB17" stroke="white" stroke-width="2"/>
                            <path d="M20 8c-4.4 0-8 3.6-8 8 0 6 8 16 8 16s8-10 8-16c0-4.4-3.6-8-8-8zm0 11c-1.7 0-3-1.3-3-3s1.3-3 3-3 3 1.3 3 3-1.3 3-3 3z" fill="white"/>
                        </svg>
                    `),
                    scaledSize: new google.maps.Size(40, 40),
                    anchor: new google.maps.Point(20, 20)
                }
            });
            
            const infoWindow = new google.maps.InfoWindow({
                content: `
                    <div style="padding: 10px; max-width: 200px;">
                        <h6 style="margin: 0 0 5px 0; color: #333; font-size: 14px;"><?php echo addslashes($restaurant['Name']); ?></h6>
                        <p style="margin: 0; color: #666; font-size: 12px;"><?php echo addslashes($restaurant['Address'].' '.$restaurant['Address2'].' '.$restaurant['City'].' '.$restaurant['State'].' '.$restaurant['Country']); ?></p>
                    </div>
                `
            });
            
            marker.addListener('click', function() {
                infoWindow.open(map, marker);
            });
            <?php endif; ?>
        }
        
        // Google Maps initialization for booking modal
        function initBookingMap() {
            <?php if (!empty($restaurant['Latitude']) && !empty($restaurant['Longitude'])): ?>
            const restaurantLocation = {
                lat: parseFloat(<?php echo $restaurant['Latitude']; ?>),
                lng: parseFloat(<?php echo $restaurant['Longitude']; ?>)
            };
            
            const map = new google.maps.Map(document.getElementById('mapPlaceholder'), {
                zoom: 15,
                center: restaurantLocation,
                mapTypeId: 'roadmap',
                styles: [
                    {
                        featureType: 'poi',
                        elementType: 'labels',
                        stylers: [{ visibility: 'off' }]
                    }
                ]
            });
            
            const marker = new google.maps.Marker({
                position: restaurantLocation,
                map: map,
                title: '<?php echo addslashes($restaurant['Name']); ?>',
                icon: {
                    url: 'data:image/svg+xml;charset=UTF-8,' + encodeURIComponent(`
                        <svg width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="20" cy="20" r="18" fill="#4CBB17" stroke="white" stroke-width="2"/>
                            <path d="M20 8c-4.4 0-8 3.6-8 8 0 6 8 16 8 16s8-10 8-16c0-4.4-3.6-8-8-8zm0 11c-1.7 0-3-1.3-3-3s1.3-3 3-3 3 1.3 3 3-1.3 3-3 3z" fill="white"/>
                        </svg>
                    `),
                    scaledSize: new google.maps.Size(40, 40),
                    anchor: new google.maps.Point(20, 20)
                }
            });
            
            // Calculate travel time (mock implementation)
            const travelTimeElement = document.getElementById('travelTime');
            if (travelTimeElement) {
                travelTimeElement.textContent = '15-20 minutes';
            }
            <?php endif; ?>
        }
        
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

        function calculateAndDisplayDistance() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const userLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

                        <?php if (!empty($restaurant['Latitude']) && !empty($restaurant['Longitude'])): ?>
                        const restaurantLocation = new google.maps.LatLng(
                            parseFloat(<?php echo $restaurant['Latitude']; ?>),
                            parseFloat(<?php echo $restaurant['Longitude']; ?>)
                        );

                        const distanceInMeters = google.maps.geometry.spherical.computeDistanceBetween(userLocation, restaurantLocation);
                        const distanceInMiles = (distanceInMeters / 1609.34).toFixed(1);

                        const distanceEl = document.querySelector('.distance-text');
                        if (distanceEl) {
                            distanceEl.textContent = `• ${distanceInMiles} mi away`;
                        }
                        <?php endif; ?>
                    },
                    (error) => {
                        console.error("Geolocation error:", error.message);
                        const distanceEl = document.querySelector('.distance-text');
                        if (distanceEl) {
                            distanceEl.textContent = ''; // Hide if location is not available
                        }
                    }
                );
            } else {
                console.warn("Geolocation is not supported by this browser.");
            }
        }
    </script>

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
                                <input type="text" readonly id="TableID" name="table_id" class="form-control">
                            </div>
                            <div class="col-md-6">
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
        <div style="background:rgb(243, 243, 243); padding:20px; border-radius:15px; width:90%; max-width:700px; max-height:90vh; position:absolute; top:50%; left:50%; transform:translate(-50%, -50%); box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
            <!-- Header -->
            <div style="background: linear-gradient(135deg, #4CBB17 0%, #45a716 100%); color: white; padding: 15px 20px; margin: -20px -20px 15px -20px; border-top-left-radius: 15px; border-top-right-radius: 15px; position: relative;">
                <h4 style="margin:0; font-size: 20px; font-weight: 600;">Confirm Your Booking</h4>
                <p style="margin: 3px 0 0 0; opacity: 0.8; font-size: 12px;">Please review your booking details</p>
                <button onclick="closeBookingModal()" style="position: absolute; right: 15px; top: 15px; background: none; border: none; color: white; font-size: 18px; cursor: pointer;">&times;</button>
            </div>

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

    <!-- Include all modals from original file -->
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
                                <input type="text" readonly id="TableID" name="table_id" class="form-control">
                            </div>
                            <div class="col-md-6">
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
            <img id="menuItemImage" src="" style="width: 100%; height: 100%; object-fit: cover;" alt="Menu Item">
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
                <div class="modal-footer" style="border-top: none; padding: 15px 20px; display: flex; justify-content: space-between; flex-wrap: wrap;">
                    <button type="button" class="btn" data-dismiss="modal" style="background-color: #f1f2f3; color: #666; border: none; border-radius: 50px; padding: 8px 15px; font-size: 13px; font-weight: 600; margin: 5px;">
                        <i class="fas fa-arrow-left mr-2"></i> Continue
                    </button>
                    <button type="button" class="btn" onclick="placeOrder(<?php echo $activeReservationRestaurant; ?>, <?php echo $_SESSION['ReservationID']; ?>)" style="background: linear-gradient(135deg, #4CBB17 0%, #45a716 100%); color: white; border: none; border-radius: 50px; padding: 8px 15px; font-size: 13px; font-weight: 600; box-shadow: 0 4px 15px rgba(76, 187, 23, 0.3); margin: 5px;">
                        <i class="fas fa-check mr-2"></i> Place Order
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
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

  function placeOrder(restaurantID, reservationID) {
    // Redirect to place_order.php with RestaurantID and ReservationID in URL
    window.location.href = `place_order.php?RestaurantID=${restaurantID}&ReservationID=${reservationID}`;
  }

  // Initialize cart functionality
  $(document).ready(function() {
    // Update cart count on page load
    updateCartCount();
    
    // Update cart when modal is shown
    $('#smallmodal').on('show.bs.modal', function() {
      updateCartModal();
    });
    
    // Test if modal element exists and Bootstrap is working
    console.log('Modal element exists:', $('#menumodal').length > 0);
    console.log('Bootstrap modal method available:', typeof $('#menumodal').modal === 'function');
    
    // Test modal show
    $('#menumodal').on('show.bs.modal', function() {
      console.log('Modal show event triggered');
    });
    
    $('#menumodal').on('shown.bs.modal', function() {
      console.log('Modal shown event triggered');
    });
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
        
        $.each(data.items, function(index, item) {
          var subtotal = item.price * item.quantity;
          total += subtotal;
          itemCount += parseInt(item.quantity);

          cartItemsBody.append('<tr>' +
            '<td>' + item.name + '</td>' +
            '<td>' + item.quantity + '</td>' +
            '<td>$' + item.price.toFixed(2) + '</td>' +
            '<td>$' + subtotal.toFixed(2) + '</td>' +
            '<td><button class="btn btn-danger btn-sm" onclick="removeFromCart(' + item.id + ')">X</button></td>' +
            '</tr>');
        });

        $('#totalAmount').text(total.toFixed(2));
        updateCartBadge(itemCount);
      }
    });
  }

  function removeFromCart(itemIndex) {
    $.ajax({
      url: 'remove_from_cart.php',
      method: 'POST',
      data: {
        itemID: itemIndex
      },
      success: function(response) {
        updateCartModal();
        updateCartCount();
      }
    });
  }

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
</script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDP9cy_r8w6t7O0Wct3KmP0rPI0ISVQqks&libraries=geometry&callback=initMap"></script>
</body>
</html>