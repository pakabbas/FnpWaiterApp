<?php
require 'checkLogin.php';
require 'fetch_Rcookies.php';
require 'fetch_Dash_report.php';
include 'fetch_restaurant.php';

// Check if request is coming from mobile app webview
$userAgent = $_SERVER['HTTP_USER_AGENT'];
if (
    // Check for common webview indicators
    (strpos($userAgent, 'wv') !== false) || // Android WebView
    (strpos($userAgent, 'Mobile/') !== false && strpos($userAgent, 'Safari/') === false) || // iOS WKWebView
    (strpos($userAgent, 'FoodnPalsApp') !== false) // Custom app identifier if you have one
) {
    header('Location: Dashboard2.php');
    exit;
}

?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>FoodnPals - Dashboard</title>
    <meta name="description" content="FoodnPals Admin">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">

    <link rel="icon" type="image/png" sizes="16x16" href="favicon.png">
    <link rel="apple-touch-icon" href="apple-icon.png">
    <link rel="shortcut icon" href="favicon.ico">

    <link rel="stylesheet" href="../vendors/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../vendors/themify-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="../vendors/selectFX/css/cs-skin-elastic.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="./dbutton.css">

    <link rel="stylesheet" href="../assets/css/style.css">


    <style>
        /* Outer chips row */
        .instant-header .chip {
            border-radius: 11px;
            padding: 8px 14px;
            font-size: 14px;
            line-height: 20px;
        }

        .instant-header .chip--green {
            background: #D9F1CD;
            color: #1F6F2B;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border: 0;
        }

        .instant-header .chip--muted {
            background: #EFF0EE;
            color: #505150;
            font-weight: 500;
            text-decoration: none;
            border: 0;
            display: inline-flex;
            align-items: center;
            padding: 8px 14px;
        }

        .chip-icon {
            display: inline-flex;
            width: 20px;
            height: 20px;
            align-items: center;
            justify-content: center;
        }

        /* Card container */
        .instant-card {
            width: 100%;
            border-radius: 16px;
            padding: 8px;

        }

        .instant-card-body {
            background: #F8F8F8;
            border-radius: 12px;
            padding: 14px 14px 10px;
        }

        .instant-title {
            margin: 4px 2px 8px;
            color: #252525;
            font-weight: 600;
        }

        /* List & rows */
        .instant-list {
            padding-top: 10px;
        }

        .booking-row {
            padding: 14px 2px 10px;
            border-bottom: 1px solid rgba(181, 181, 181, .4);
        }

        .booking-row:last-child {
            border-bottom: 0;
        }

        .booking-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .booking-left .booking-name {
            color: #505150;
            font-weight: 600;
            font-size: 14px;
        }

        .booking-left .booking-phone {
            color: #8a8a8a;
            font-size: 12px;
            display: flex;
            gap: 6px;
            align-items: center;
            margin-top: 4px;
        }

        .phone-dot {
            width: 12px;
            height: 12px;
            border-radius: 999px;
            background: #cfcfcf;
            display: inline-block;
            position: relative;
        }

        .phone-dot::before {
            content: "";
            position: absolute;
            inset: 2px;
            border-radius: 999px;
            background: #8e8e8e;
        }

        /* Right meta chips (exact shape/tones) */
        .booking-right {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }

        .meta-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 8px;
            padding: 6px 10px;
            font-size: 12px;
            font-weight: 600;
            color: #505150;
        }

        .meta-chip--blue {
            background: rgba(188, 236, 242, .5);
        }

        .meta-chip--green {
            background: rgba(217, 241, 205, .7);
        }

        .meta-chip--orange {
            background: rgba(255, 196, 140, .5);
        }

        /* Small glyphs for chips */
        .chip-ico {
            width: 16px;
            height: 16px;
            display: inline-block;
            position: relative;
        }

        .chip-ico.people::before {
            content: "";
            position: absolute;
            inset: 0;
            border: 2px solid #037785;
            border-radius: 3px;
            transform: skewX(-10deg);
        }

        .chip-ico.clock::before {
            content: "";
            position: absolute;
            inset: 2px;
            border: 2px solid #1f6f2b;
            border-radius: 999px;
        }

        .chip-ico.clock::after {
            content: "";
            position: absolute;
            left: 7px;
            top: 4px;
            width: 2px;
            height: 6px;
            background: #1f6f2b;
            border-radius: 1px;
        }

        .chip-ico.chair::before {
            content: "";
            position: absolute;
            left: 2px;
            right: 2px;
            bottom: 3px;
            height: 6px;
            background: #FF9F43;
            border-radius: 2px;
        }

        .chip-ico.chair::after {
            content: "";
            position: absolute;
            left: 2px;
            right: 2px;
            top: 2px;
            height: 6px;
            border: 2px solid #FF9F43;
            border-radius: 2px;
        }

        /* Attended by pill */
        .booking-attended {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        .attended-pill {
            background: #ffffff;
            color: #505150;
            border-radius: 10px;
            padding: 7px 12px;
            font-size: 12px;
            font-weight: 500;
            box-shadow: 0 0 0 1px rgba(0, 0, 0, .04) inset;
        }

        .attended-pill a {
            color: #2eaa34;
            text-decoration: none;
            font-weight: 700;
        }

        /* Make it feel like the screenshot on narrow widths */
        @media (max-width: 420px) {
            .instant-tabs {
                gap: 16px;
            }
        }

        .menu-icon,
        .fa {
            color: #4CBB17;
        }

        ul li i {
            color: #4CBB17;
        }

        .mobile-logout-btn {
            display: none;
        }

        /* Better responsive breakpoints */
        @media (max-width: 991px) {

            /* Adjust header for tablets */
            .header-menu {
                flex-wrap: wrap;
            }

            .col-sm-7,
            .col-sm-5 {
                width: 100%;
                text-align: center;
            }

            /* Adjust dashboard boxes */
            .col-lg-4 {
                margin-bottom: 15px;
            }
        }

        @media (max-width: 768px) {
            .mobile-logout-btn {
                display: block !important;
                width: 90%;
                margin: 0 auto;
            }

            .aside {
                position: fixed;
                padding-top: env(safe-area-inset-top);
                top: 0;
                left: 0;
                right: 0;
                z-index: 9999;
            }

            .logoutdiv {
                height: 0px;
                visibility: hidden;
            }

            .header {
                height: 0px;
                visibility: hidden;
            }

            /* Responsive adjustments for dashboard boxes */
            .container.mt-3 .row>div {
                padding: 5px;
                justify-content: flex-start;
            }

            /* Make dashboard boxes stack properly */
            .d-flex {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .d-flex img {
                max-width: 60px;
                margin-top: 10px;
            }
        }

        /* Specific styles for iPad Mini and similar tablets */
        @media (min-width: 768px) and (max-width: 1024px) {

            /* Ensure proper layout for tablets */
            .right-panel {
                margin-left: 280px;
                /* Adjust based on sidebar width */
                width: calc(100% - 280px);
            }

            /* Responsive grid for dashboard boxes */
            .col-lg-4 {
                flex: 0 0 50%;
                max-width: 50%;
            }

            /* Adjust chart container height */
            .col-lg-4.bg-light {
                height: auto !important;
                min-height: 250px;
            }

            /* Table booking section adjustments */
            .col-lg-8 {
                flex: 0 0 100%;
                max-width: 100%;
                margin-bottom: 20px;
            }

            .col-lg-4 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            /* Modal adjustments */
            .modal-dialog {
                margin: 30px auto;
            }
        }

        /* Ensure proper spacing and alignment */
        .content {
            padding: 15px;
        }

        /* Responsive table images */
        .table-image {
            max-width: 100%;
            height: auto;
        }

        /* Responsive buttons */
        button {
            white-space: normal;
            word-wrap: break-word;
        }

        /* Fix overflow issues */
        .right-panel {
            overflow-x: hidden;
        }

        /* Responsive typography */
        @media (max-width: 768px) {

            p,
            span {
                font-size: 0.9rem;
            }

            .fw-bold.fs-4 {
                font-size: 1.25rem !important;
            }
        }

        /* Align right panel with actual sidebar width */
        @media (min-width: 992px) {
            #left-panel {
                width: 240px;
                /* sidebar width (adjust if yours differs) */
                border-right: 1px solid #e9ecef;
                /* your subtle divider */
            }

            .right-panel {
                margin-left: 240px;
                /* must equal #left-panel width */
            }
        }

        /* On tablets/phones, remove the left offset */
        @media (max-width: 991.98px) {
            .right-panel {
                margin-left: 0 !important;
            }
        }


        /* Header plan status + upgrade styles */
        .user-area.dropdown.float-right {
            display: flex;
            align-items: center;
            gap: 16px;
            border-radius: 12px;
        }





        .upgrade-btn:hover {
            background: #43a013;
        }

        .upgrade-btn:active {
            transform: translateY(1px);
        }

        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0.2; }
            100% { opacity: 1; }
        }
        .blinking {
            animation: blink 1s infinite;
            background-color:rgb(245, 57, 57);
        }
        .distance-label {
            background-color: #43a013;
            color: #fff;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
        }
    </style>
   
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        var lastReservationID = 0; // Start with 0, assuming your IDs are auto-increment
        function requestNotificationPermission() {
            if (Notification.permission === 'default') {
                Notification.requestPermission().then(function(permission) {
                    if (permission === "granted") {
                        console.log("Notification permission granted.");
                    } else {
                        console.log("Notification permission denied.");
                    }
                });
            }
        }

        function fetchReservations() {
            $.ajax({
                url: 'fetch_reservations.php',
                type: 'GET',
                dataType: 'json',
                data: {
                    last_id: lastReservationID
                },
                success: function(response) {
                    const reservations = response.reservations;
                    console.log("LastID: " + lastReservationID + ", New: " + reservations.length);

                    if (reservations.length > 0) {
                        let index = 0;

                        function showNextReservation() {
                            if (index < reservations.length) {
                                const reservation = reservations[index];
                                const dateTime = new Date(reservation.ReservationDateTime);
                                const dateOptions = { year: 'numeric', month: 'short', day: 'numeric' };
                                const timeOptions = { hour: '2-digit', minute: '2-digit', hour12: true };
                                const formattedDate = dateTime.toLocaleDateString('en-US', dateOptions).replace(/,/g, '');
                                const formattedTime = dateTime.toLocaleTimeString('en-US', timeOptions);

                                document.getElementById('BookingID').innerText = reservation.ReservationID;
                                document.getElementById('TableNumber').value = reservation.TableNumber;
                                document.getElementById('Name').innerText = reservation.FirstName + ' ' + reservation.LastName;
                                document.getElementById('Status').innerText = reservation.Status;

                                // Update table status with color coding
                                const tableStatusElement = document.getElementById('TableStatus');
                                const tableStatus = reservation.TableStatus || 'Unknown';
                                tableStatusElement.innerText = tableStatus;
                                
                                // Apply color styling based on status
                                if (tableStatus.toLowerCase() === 'available') {
                                    tableStatusElement.style.color = '#4CBB17'; // Green color
                                } else {
                                    tableStatusElement.style.color = '#DF3737'; // Red color
                                }

                                // Update phone number and call button
                                const phoneNumber = reservation.PhoneNumber;
                                document.getElementById('PhoneNumber').innerText = phoneNumber;
                                document.getElementById('callButton').href = 'tel:' + phoneNumber;

                                // Update details cards
                                document.getElementById('TableNumberBox').innerText = reservation.TableNumber;
                                document.getElementById('BookingDateBox').innerText = formattedDate;
                                document.getElementById('BookingTimeBox').innerText = formattedTime;

                                $('#showModelButton').click();

                                if (Notification.permission === "default") {
                                    requestNotificationPermission();
                                } else if (Notification.permission === "granted") {
                                    // Send the notification
                                    var notification = new Notification('FoodnPals Booking Alert!', {
                                        body: 'Attention! You have a new booking on foodnpals.',
                                        icon: 'https://foodnpals.com/Resources/logo.png', // Optional, use your own icon URL
                                    });
                                    notification.onclick = function() {
                                        window.location.href = 'https://foodnpals.com/admin/Dashboard.php';
                                    };

                                    // Show the modal (example of what you might want to do)
                                    $('#myModal').show();
                                }

                                index++;
                            }
                        }

                        showNextReservation();

                        // Update lastReservationID to the highest new one
                        lastReservationID = Math.max(...reservations.map(r => parseInt(r.ReservationID)));
                    }
                },
                error: function(xhr, status, error) {
                    console.log('AJAX Error:', status, error);
                }
            });
        }

        $(document).ready(function() {
            fetchReservations();
            setInterval(fetchReservations, 30000);

            $('#accept-button').click(function() {
                const bookingID = document.getElementById('BookingID').innerText;
                const tableNumber = document.getElementById('TableNumber').value;
                const tableRequested = document.getElementById('TableNumberBox').innerText;
                window.location.href = `ConfirmationScript.php?BookingID=${bookingID}&TableNumber=${tableNumber}&tableRequested=${tableRequested}&Action=ACCEPT`;
            });

            $('#decline-button').click(function() {
                const bookingID = document.getElementById('BookingID').innerText;
                const tableNumber = document.getElementById('TableNumber').value;
                const tableRequested = document.getElementById('TableNumberBox').innerText;
                const reason = document.getElementById('Reason').value;

                if (!reason) {
                    alert('Please select a reason for declining the booking.');
                    return;
                }

                window.location.href = `ConfirmationScript.php?BookingID=${bookingID}&TableNumber=${tableNumber}&tableRequested=${tableRequested}&Action=DECLINE&Reason=${encodeURIComponent(reason)}`;
            });
        });
    </script>


</head>

<body>

    <script>
        // Request notification permission when page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Check if the browser supports notifications
            if ('Notification' in window) {
                if (Notification.permission !== 'granted' && Notification.permission !== 'denied') {
                    Notification.requestPermission().then(function(permission) {
                        if (permission === 'granted') {
                            console.log('Notification permission granted.');
                        }
                    });
                }
            } else {
                console.log('This browser does not support desktop notifications.');
            }
        });
    </script>

    <!-- Left Panel -->

    <?php
    $currentPage = 'dashboard';
    include 'sidebar.php';
   
    ?>


    <!-- Left Panel -->

    <!-- Right Panel -->

    <div id="right-panel" class="right-panel">

        <!-- Header-->
        <header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-7">
                    <!-- <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a> -->
                    <div class="header-left">
                        <button hidden class="search-trigger"><i class="fa fa-search"></i></button>
                    </div>
                </div>

                <div class="col-sm-5">
                    <div class="user-area dropdown float-right">
                        <div class="plan-actions" style="display: inline-flex; align-items: center; gap: 12px; white-space: nowrap;">
                            <?php include 'header_plan_status.php'; ?>
                        </div>
                        <div style="position: relative; display: inline-block;">
                            <!-- User Icon with Dropdown Indicator -->
                            <div onclick="toggleDropdown()"
                                style="display: flex; align-items: center; cursor: pointer; gap: 5px;">
                                <?php
                                $iconSrc = isset($RestaurantIcon) ? trim((string)$RestaurantIcon) : '';
                                $hasIcon = ($iconSrc !== '' && strtolower($iconSrc) !== 'not set');
                                ?>
                                <img
                                    id="logoutdiv"
                                    src="<?php echo htmlspecialchars($hasIcon ? $iconSrc : '', ENT_QUOTES, 'UTF-8'); ?>"
                                    alt="Restaurant Icon"
                                    style="min-width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 2px solid #4cbb17; <?php echo $hasIcon ? '' : 'display:none;'; ?>"
                                    onerror="this.style.display='none'; document.getElementById('fallbackUserIcon').style.display='inline-block';" />
                                <i
                                    id="fallbackUserIcon"
                                    class="fas fa-user-circle"
                                    style="font-size: 36px; color: #4cbb17; <?php echo $hasIcon ? 'display:none;' : 'display:inline-block;'; ?>">
                                </i>
                                <i class="fas fa-caret-down"
                                    style="font-size: 20px; color: #4cbb17;"></i>
                            </div>

                            <!-- Dropdown Menu -->
                            <div id="dropdown-menu"
                                style="display: none; position: absolute; background-color: white; min-width: 160px; 
                                box-shadow: 0px 4px 8px rgba(0,0,0,0.2); z-index: 1000; border-radius: 6px; 
                                overflow: hidden; right: 0; margin-top: 5px;">
                                <a href="EditRestaurants.php?ID=<?php echo $_COOKIE['RestaurantID']; ?>"
                                    style="display: block; padding: 10px 15px; text-decoration: none; color: black; 
                                font-size: 16px; background-color: white;"
                                    onmouseover="this.style.backgroundColor='#f1f1f1'"
                                    onmouseout="this.style.backgroundColor='white'">
                                    <i class="fas fa-user" style="margin-right: 10px;"></i> Profile
                                </a>

                                <a href="Rlogout.php"
                                    style="display: block; padding: 10px 15px; text-decoration: none; color: black; 
                                font-size: 16px; background-color: white;"
                                    onmouseover="this.style.backgroundColor='#f1f1f1'"
                                    onmouseout="this.style.backgroundColor='white'">
                                    <i class="fas fa-sign-out-alt" style="margin-right: 10px;"></i> Logout
                                </a>
                            </div>
                        </div>

                        <script>
                            function toggleDropdown() {
                                var dropdown = document.getElementById("dropdown-menu");
                                dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
                            }

                            document.addEventListener("click", function(event) {
                                var dropdown = document.getElementById("dropdown-menu");
                                var userIcon = document.getElementById("logoutdiv").parentElement;
                                if (!userIcon.contains(event.target) && !dropdown.contains(event.target)) {
                                    dropdown.style.display = "none";
                                }
                            });
                        </script>


                    </div>
                </div>
            </div>

        </header>


        <?php if ($UserType === "Admin"): ?>
            <div class="container-fluid mt-3">
                <h4 style="font-weight:600; color:#333; margin-bottom:20px;">Overview</h4>


                <!-- row 1 -->
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4 mb-3">
                        <!-- 1st Box -->
                        <a href="viewbooking.php" style="text-decoration:none; color:inherit;">
                            <div style="background:#D9F1CD; cursor:pointer;" class="d-flex flex-column flex-md-row bg-success-subtle rounded p-3 mb-3 w-380" title="Go to Bookings">
                                <div class="flex-grow-1">
                                    <p style="font-size:large; font-weight:500; color:#1C1C1C" class="fw-bold">Active / Expired / No Show</p>
                                    <p>
                                        <span style="margin-left:10px; font-size:x-large; color:#1C1C1C;font-weight:600;" class="fw-bold fs-4"><?php echo $todayActive; ?> / <?php echo $todayExpired; ?> / <?php echo $todayNoShow; ?></span>
                                    </p>
                                </div>
                                <div>
                                    <br>
                                    <img src="../Resources/dash1.png" alt="icon" class="img-fluid">
                                </div>
                            </div>
                        </a>

                        <!-- Second Box - Total Bookings / Total Orders -->
                        <a href="viewbooking.php" style="text-decoration:none; color:inherit;">
                            <div style="background:#D9F1CD; cursor:pointer;" class="d-flex flex-column flex-md-row bg-success-subtle rounded p-3 mb-3" title="Go to Bookings">
                                <div class="flex-grow-1">
                                    <p style="font-size:large;color:#1C1C1C; font-weight:500;" class="fw-medium">Total Bookings / Orders</p>
                                    <p>
                                        <span style="margin-left:10px; font-size:x-large; color:#1C1C1C; font-weight:600;" class="fw-bold fs-4">
                                            <?php echo $totalBookings; ?> / <?php echo $totalOrders; ?>
                                        </span>
                                    </p>

                                </div>
                                <div>
                                    <br>
                                    <img src="../Resources/dash2.png" alt="icon" class="img-fluid">
                                </div>
                            </div>
                        </a>



                    </div>



                    <div class="col-12 col-md-6 col-lg-4 mb-3">

                        <!-- 1st Box -->
                        <a href="Reports.php" style="text-decoration:none; color:inherit;">
                            <div style="background:#D9F1CD; cursor:pointer;" class="d-flex flex-column flex-md-row bg-success-subtle rounded p-3 mb-3" title="Go to Reports">
                                <div class="flex-grow-1">
                                    <p style="font-size:large; font-weight:500; color:#1C1C1C;" class="fw-medium">Completed Ratio</p>
                                    <p>
                                        <span style="margin-left:10px; font-size:x-large; font-weight:600; color:#1C1C1C;" class="fw-bold fs-4"><?php echo number_format($completedRatio, 1); ?>%</span>
                                        <span class="text-success"><?php echo $customersGrowthFormatted; ?></span>
                                        <img src="../Resources/dash5.png" alt="icon" />
                                    </p>
                                </div>
                                <div>
                                    <br>
                                    <img src="../Resources/dash2.png" alt="icon" class="img-fluid">
                                </div>
                            </div>
                        </a>

                        <!-- Second Box -->
                        <a href="Users.php" style="text-decoration:none; color:inherit;">
                            <div style="background:#D9F1CD; cursor:pointer;" class="d-flex flex-column flex-md-row bg-success-subtle rounded p-3 mb-3" title="Go to Users">
                                <div class="flex-grow-1">
                                    <p style="font-size:large; font-weight:500;color:#1C1C1C;" class="fw-medium">Total Customers</p>
                                    <p>
                                        <span style="margin-left:10px; font-size:x-large; color:#1C1C1C;font-weight:600;" class="fw-bold fs-4"><?php echo $totalCustomers; ?></span>
                                        <span class="text-success"><?php echo $customersGrowthFormatted; ?></span>
                                        <img src="../Resources/dash5.png" alt="icon" />
                                    </p>
                                </div>
                                <div>
                                    <br>
                                    <img src="../Resources/dash4.png" alt="icon" class="img-fluid">
                                </div>
                            </div>
                        </a>



                    </div>


                    <!-- Second Column (Right Section) -->
                    <div class="col-12 col-lg-4 mb-3 bg-light rounded p-3" style="min-height: 250px;">
                        <canvas style="height: 100%; width: 80%;" id="salesChart"></canvas>
                        <?php include 'OrdersgridChart.php'; ?>
                        <?php include 'TableStatus.php'; ?>
                    </div>

                </div>
                <!-- end row 1 -->

            </div>

        <?php endif; ?>






        <div class="content mt-3">

            <div class="row">
                <?php if ($UserType === "Admin"): ?>
                    <div class="col-sm-6 col-lg-6">
                        <div class="card text-white" style="border: none; background-color:#f9f9f9; border-radius:15px;">
                            <div>
                                <p style="margin: 5px; text-align: center;"> Bookings (Based on Time)</p>
                                <canvas id="reservationPieChart" style="max-width: 100%; max-height: 200px; width: 100%; height: auto;"></canvas>
                                <?php include 'Reservationgrid1.php'; ?>
                            </div>
                        </div>
                    </div>
                    <!--/.col-->

                    <div class="col-sm-6 col-lg-6">
                        <div class="card text-white" style=" border:none; background-color:#f9f9f9;border-radius:15px;">
                            <div>
                                <p style="margin: 5px; text-align: center;"> Bookings per Table</p>
                                <canvas id="capacityPieChart" style="max-width: 100%; max-height: 200px; width: 100%; height: auto;"></canvas>
                                <?php include 'BookingsPerTable.php'; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>


            <?php if ($UserType === "Editor"): ?>
                <div class="row">
                    <div class="col-12">
                        <br><br>
                        <h5 style="margin-top: -0px; color: #4CBB17; font-size: 1.5rem; text-align: center; padding: 10px; border-radius: 5px; background-color: #f1f1f1; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); max-width: 80%; margin-left: auto; margin-right: auto;">
                            Welcome to FoodnPals Waiter App
                        </h5>
                    </div>
                </div>
            <?php endif; ?>


            <div class="row mt-3">
                <div class="col-12">
                    <div style="background-color:#fff; border-radius:10px; padding:10px; width:100%; display:flex; align-items:center;">

                        <!-- Left: title -->
                        <div style="flex:1 1 auto; min-width:200px;">
                            <p style="margin:0; font-size:25px; font-weight:500; color:#000;">Available Tables</p>
                            <p style="margin-top:6px; font-size:16px; font-weight:600; color:gray;">
                                (Double tap to change status)
                            </p>
                        </div>



                        
                    </div>
                </div>
            </div>


        </div> <!-- .content -->



        <div class="content mt-3">
            <div class="row">
                <!-- Table Booking (Left on large screens, Top on small screens) -->
                <div class="col-12 col-lg-8 mb-3 order-1">
                    <div class="d-flex flex-wrap justify-content-center" style="background-color: #f9f9f9; border-radius: 16px;">
                        <?php include 'fetch_tablestoggle.php'; ?>
                    </div>
                </div>

                <!-- RIGHT SIDE: Instant Booking + Booking List -->
                <div class="col-12 col-lg-4 order-2">
                    <!-- Scan button under the card (as in your screenshot it’s not primary focus) -->
                    <div class="mt-6">
                        <button id="scanQRButton" class="custom-btn w-100">Scan QR Code</button>
                    </div>
                    <!-- Card -->
                    <div class="instant-card ">
                        <div class="instant-card-body">
                            <h5 class="instant-title mb-2 ">Booking List</h5>

                           
                                <?php include 'fetch_bookings.php'; ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="content mt-3">
            <div class="row">
                <div class="col-12">
                    <a href="Rlogout.php"
                        class="mobile-logout-btn"
                        style="display: none; padding: 10px 15px; text-decoration: none; color: black; 
                        font-size: 16px; width:100%;
                        border-radius:10px;
                        margin-top: 40px !important; 
                        background: #4CBB17;
                        text-align: center;">
                        <i class="fas fa-sign-out-alt" style="margin-right: 10px;"></i> Logout
                    </a>
                    <br>
                </div>
                <br>
            </div>
            <br>
        </div>
        <br>



        <button hidden id="showModelButton" type="button" class="btn btn-secondary mb-1" data-toggle="modal" data-target="#smallmodal">

        </button>

        <div class="modal fade" id="smallmodal" tabindex="-1" role="dialog" aria-labelledby="smallmodalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm" role="document" style="max-width:500px;">
                <div class="modal-content" style="border-radius:20px; box-shadow:0px 14px 42px rgba(8,15,52,0.06); border:0.5px solid #C5C5C5; padding:32px;">

                    <!-- Close Button -->
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position:absolute; top:20px; right:20px;">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <!-- Icon Circle -->
                    <div style="width:80px; height:80px; background:rgba(250,180,180,0.3); border-radius:9999px; margin:0 auto; display:flex; align-items:center; justify-content:center;">
                        <img src="../Resources/not1.png" alt="alert" style="width:70px; height:70px;">
                    </div>

                    <!-- Title -->
                    <div style="text-align:center; color:#3F3F3F; font-size:24px; font-weight:700; margin-top:1px; margin-bottom:1px;">
                        Booking Alert
                    </div>

                    <!-- Info -->
                    <div style="text-align:center; font-size:16px; color:#5F5F5F; margin-bottom:5px;">
                        Booking ID: <span id="BookingID" style="font-weight:600;"></span>
                    </div>
                    <div style="text-align:center; font-size:16px; color:#5F5F5F; margin-bottom:5px;">
                        Name: <span id="Name" style="font-weight:600;"></span>
                    </div>
                    <div id="customer-phone-container" style="text-align:center; font-size:16px; color:#5F5F5F; margin-bottom:5px; display: flex; align-items: center; justify-content: center; gap: 10px;">
                        Phone: <span id="PhoneNumber" style="font-weight:600;"></span>
                        <a id="callButton" href="#" class="btn btn-success" style="padding: 5px 10px; font-size: 14px; background-color: #4CBB17; border-color: #4CBB17; border-radius: 5px;">Call</a>
                    </div>
                    <div style="text-align:center; font-size:16px; color:#5F5F5F; margin-bottom:5px;">
                        Status: <span id="Status" style="font-weight:600;"></span>
                    </div>
                    <div style="text-align:center; font-size:16px; color:#5F5F5F; margin-bottom:20px;">
                        Table Status: <span id="TableStatus" style="font-weight:600;"></span>
                    </div>

                    <!-- Booking Details Cards -->
                    <div style="display:flex; justify-content:center; align-items:stretch; gap:15px; margin-top:0px; flex-wrap:nowrap;">

                        <!-- Table Number -->
                        <div style="flex:1; min-width:100px; padding:10px; background:white; border-radius:8px; border:1px solid #C5C5C5; display:flex; flex-direction:column; justify-content:center; align-items:center; gap:10px;">
                            <i class="fas fa-chair" style="font-size:22px; color:#4CBB17;"></i>
                            <div style="text-align:center; color:#3F3F3F; font-size:14px; font-family:Roboto; font-weight:500;">
                                Table No. <span id="TableNumberBox"></span>
                            </div>
                        </div>

                        <!-- Date -->
                        <div style="flex:1; min-width:100px; padding:10px; background:white; border-radius:8px; border:1px solid #C5C5C5; display:flex; flex-direction:column; justify-content:center; align-items:center; gap:10px;">
                            <i class="fas fa-calendar-alt" style="font-size:22px; color:#4CBB17;"></i>
                            <div style="text-align:center; color:#3F3F3F; font-size:14px; font-family:Roboto; font-weight:500;">
                                <span id="BookingDateBox"></span>
                            </div>
                        </div>

                        <!-- Time -->
                        <div style="flex:1; min-width:100px; padding:10px; background:white; border-radius:8px; border:1px solid #C5C5C5; display:flex; flex-direction:column; justify-content:center; align-items:center; gap:10px;">
                            <i class="fas fa-clock" style="font-size:22px; color:#4CBB17;"></i>
                            <div style="text-align:center; color:#3F3F3F; font-size:14px; font-family:Roboto; font-weight:500;">
                                <span id="BookingTimeBox"></span>
                            </div>
                        </div>

                    </div>

                    <!-- Divider -->
                    <hr style="margin:15px 0; border-color:#B6B6B6;">

                    <!-- Action Buttons -->
                    <div style="display:flex; flex-direction:column; gap:15px; align-items:center;">

                        <!-- Hidden Form: Offer Another Table -->
                        <form id="restaurant-form" novalidate="novalidate" style="display:none; width:100%;">
                            <div class="form-group">
                                <label for="TableNumber">Table Number</label>
                                <select id="TableNumber" name="TableNumber" class="form-control" required>
                                    <?php include 'fetch_Availabletables.php'; ?>
                                </select>
                            </div>
                        </form>

                        <!-- Hidden Form: Decline Reason -->
                        <form id="restaurant-form1" novalidate="novalidate" style="display:none; width:100%;">
                            <div class="form-group">
                                <label for="Reason">Reason</label>
                                <select id="Reason" name="Reason" class="form-control" required>
                                    <option value="">Select a reason</option>
                                    <option value="No Space Available">No Space Available</option>
                                    <option value="Closing hours">Closing hours</option>
                                    <option value="Table already booked">Table already booked</option>
                                </select>
                            </div>
                            <button id="decline-button" type="button" class="btn btn-danger btn-block" style="border-radius:8px;">Decline</button>
                        </form>

                        <!-- Buttons Row -->
                        <div style="display:flex; flex-wrap:wrap; gap:15px; justify-content:center; width:100%;">
                            <button id="accept-button" type="button" class="btn btn-success" style="flex:1; min-width:140px; height:54px; border-radius:8px; background:#4CBB17; border:none;">Accept</button>
                            <button id="show-form-button1" type="button" class="btn btn-danger" style="flex:1; min-width:140px; height:54px; border-radius:8px; background:#DF3737; border:none;">Decline</button>
                            <button id="show-form-button" type="button" class="btn btn-outline-secondary" style="flex:1; min-width:140px; height:54px; border-radius:8px; border:1px solid #797979; color:#797979;">Offer Another Table</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>



        <!-- Scanner Modal -->
        <div id="QRScannerModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
    background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0,0,0,0.1); text-align: center;
    z-index: 9999; width: 400px; max-width: 95%; max-height: 90vh;">
            <h3 style="margin-bottom: 15px;">Scan QR Code</h3>
            <div id="reader" style="width: 100%; height: 400px; margin: 0 auto 20px auto;"></div>
            <button onclick="closeQRScanner()" style="margin-top: 10px; background: red; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px; position: relative;">
                Close
            </button>
        </div>

        <!-- Overlay -->
        <div id="QRScannerOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0, 0, 0, 0.5); z-index: 9998;" onclick="closeQRScanner()"></div>

        <!-- Include QR Code Scanner Library -->
        <script src="https://unpkg.com/html5-qrcode"></script>

        <script>
            let scanner;

            document.getElementById("scanQRButton").addEventListener("click", function() {
                document.getElementById("QRScannerModal").style.display = "block";
                document.getElementById("QRScannerOverlay").style.display = "block";

                scanner = new Html5Qrcode("reader");

                scanner.start({
                        facingMode: "environment"
                    }, // Use rear camera
                    {
                        fps: 10, // Frames per second
                        qrbox: 250 // QR scan area size
                    },
                    (decodedText) => {
                        // Auto-close scanner
                        closeQRScanner();

                        // Redirect to the scanned URL
                        window.location.href = decodedText;
                    },
                    (errorMessage) => {
                        console.log(errorMessage); // Log errors
                    }
                ).catch(err => console.log(err));
            });

            function closeQRScanner() {
                if (scanner) {
                    scanner.stop().then(() => {
                        document.getElementById("QRScannerModal").style.display = "none";
                        document.getElementById("QRScannerOverlay").style.display = "none";
                    }).catch(err => console.log(err));
                }
            }
        </script>
        <br>
</body>


<!-- Right Panel -->

<script src="../vendors/jquery/dist/jquery.min.js"></script>
<script src="../vendors/popper.js/dist/umd/popper.min.js"></script>
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../assets/js/main.js"></script>
<script src="../assets/js/loader.js"></script>

<script>
// Debug script to ensure loader functions are available
document.addEventListener('DOMContentLoaded', function() {
    console.log('Loader functions available:', typeof showNavigationLoader);
    if (typeof showNavigationLoader !== 'function') {
        console.error('showNavigationLoader function not found!');
    }
});
</script>


<script>
    function toggleImage(imgId) {
        var img = document.getElementById(imgId);
        if (img.src.endsWith('1.png')) {
            img.src = img.src.replace('1.png', '2.png');
        } else if (img.src.endsWith('2.png')) {
            img.src = img.src.replace('2.png', '3.png');
        } else if (img.src.endsWith('3.png')) {
            img.src = img.src.replace('3.png', '1.png');
        }
    }
</script>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(ctx, {
        type: 'bar', // Changed from 'line' to 'bar' for a bar chart
        data: {
            labels: labels,
            datasets: [{
                label: 'Total Bookings',
                data: monthlySalesData,
                backgroundColor: 'rgba(5, 105, 50, 0.8)',
                borderColor: 'rgb(5, 107, 39)',
                borderWidth: 2,
                borderRadius: 4, // Rounded corners for bars
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Monthly Bookings',
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                },
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeInOutQuart'
            }
        }
    });
</script>

<script>
    var ctx = document.getElementById('capacityPieChart').getContext('2d');
    var bookingsPerTableChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: tableNumbers,
            datasets: [{
                label: 'Number of Bookings',
                data: bookingCounts,
                backgroundColor: [
                    '#4CBB17', '#518239', '#28660A', '#61C92F', '#339405', '#194D00', '#263D1B', '#9966FF', '#FF9F40', '#C9CBCF'
                ],
                borderColor: [
                    '#4CBB17', '#518239', '#28660A', '#61C92F', '#339405', '#194D00', '#263D1B', '#9966FF', '#FF9F40', '#C9CBCF'
                ],
                borderWidth: 2,
                borderRadius: 4,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    text: 'Bookings per Table',
                    font: {
                        size: 16,
                        weight: 'bold'
                    }
                },
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            animation: {
                duration: 1000,
                easing: 'easeInOutQuart'
            }
        }
    });
</script>

<script>
    var ctx = document.getElementById('reservationPieChart').getContext('2d');
    var reservationPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['00:00-03:00', '03:00-06:00', '06:00-09:00', '09:00-12:00', '12:00-15:00', '15:00-18:00', '18:00-21:00', '21:00-00:00'],
            datasets: [{
                data: timeSlotsData,
                backgroundColor: [
                    '#4CBB17', '#518239', '#28660A', '#61C92F',
                    '#9966FF', '#FF9F40', '#C9CBCF', '#A6A6A6'
                ],
                hoverBackgroundColor: [
                    '#4CBB17', '#36A2EB', '#28660A', '#61C92F',
                    '#9966FF', '#FF9F40', '#C9CBCF', '#A6A6A6'
                ]
            }]
        },
        options: {
            responsive: true,
            title: {
                display: true,
                text: 'Reservations per 3-Hour Slot'
            }
        }
    });
</script>
<script>
    document.getElementById('show-form-button').addEventListener('click', function() {
        var form = document.getElementById('restaurant-form');
        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    });
</script>

<script>
    document.getElementById('show-form-button1').addEventListener('click', function() {
        var form = document.getElementById('restaurant-form1');
        var form2 = document.getElementById('show-form-button1');

        if (form.style.display === 'none') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';

        }

        if (form2.style.display === 'none') {
            form2.style.display = 'block';
        } else {
            form2.style.display = 'none';

        }
    });
</script>
<script>
    // Reload the page every 2 minutes (120000 milliseconds)
    setInterval(() => {
        location.reload();
    }, 180000);
</script>

<script>
    function toggleTableStatus(element) {
        const tableID = element.getAttribute('data-table-id');
        const currentStatus = element.getAttribute('data-status');
        const newStatus = currentStatus === 'Available' ? 'Reserved' : 'Available';

        // Update the status in the database
        fetch('update_table_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    tableID,
                    status: newStatus
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Toggle the image and data-status attribute
                    element.setAttribute('src', newStatus === 'Available' ? '../Resources/tableimg2.png' : '../Resources/tableimg1.png');
                    element.setAttribute('data-status', newStatus);
                } else {
                    alert('Failed to update the table status.');
                }
            })
            .catch(err => console.error('Error:', err));
    }
</script>


<script>
    setTimeout(function() {
        location.reload(); // Reloads the page
    }, 300000);
</script>

</html>