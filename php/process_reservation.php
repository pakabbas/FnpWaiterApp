<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
include 'creds.php'; 

// Start session
session_start();

// Get form data
$selectedTable = $_POST['selected_table'];
$tableID = $_POST['table_id'];
$restaurantID = $_POST['RestaurantID'];
$specialInstructions = $_POST['SpecialInstructions'] ?? '';

if (empty($selectedTable)) {
    echo "<script>alert('  Swal.fire({
        icon: 'warning',
        title: 'Table Required',
        text: 'Please select a table first.',
        confirmButtonText: 'OK',
          confirmButtonColor: '#4CBB17'
      });'); window.location.href='Profile.php?ID=" . $restaurantID . "';</script>";
    exit();
}

// Get customer info from cookies
$customerID = $_COOKIE['UserID'] ?? null;
$longitude = $_COOKIE['Longitude'] ?? null;
$latitude = $_COOKIE['Latitude'] ?? null;

// Get restaurant info including TableTimeLimit and Timezone
$sql = "SELECT Latitude, Longitude, TableTimeLimit, Timezone FROM restaurants WHERE RestaurantID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $restaurantID);
$stmt->execute();
$restaurantResult = $stmt->get_result();

if ($restaurantResult->num_rows > 0) {
    $restaurant = $restaurantResult->fetch_assoc();
    $restaurantLatitude = $restaurant['Latitude'];
    $restaurantLongitude = $restaurant['Longitude'];
    $tableTimeLimit = $restaurant['TableTimeLimit']; 
    $restaurantTimezone = $restaurant['Timezone'];
} else {
    echo "<script>alert('Invalid restaurant ID'); window.location.href='Profile.php?ID=" . $restaurantID . "';</script>";
    exit();
}

// ✅ FIX: Use PHP for timezone instead of MySQL (because GoDaddy restricts MySQL timezones)
date_default_timezone_set($restaurantTimezone);

// Get the current time in the restaurant's timezone
$reservationTime = date("Y-m-d H:i:s");  // Formatted date in the restaurant's time zone

// Store the data in the session
$_SESSION['reservation_data'] = [
    'customerID' => $customerID,
    'restaurantID' => $restaurantID,
    'reservationTime' => $reservationTime,
    'selectedTable' => $selectedTable,
    'status' => 'Pending',
    'guests' => 0,
    'tableID' => $tableID,
    'restaurantLatitude' => $restaurantLatitude,
    'restaurantLongitude' => $restaurantLongitude,
    'customerLatitude' => $latitude,
    'customerLongitude' => $longitude,
    'tableTimeLimit' => $tableTimeLimit,
    'specialInstructions' => $specialInstructions
];

// Check if customer already has a valid payment method
$checkPaymentSql = "SELECT * FROM StripeCustomers WHERE CustomerID = ? AND StripeStatus = 'setup_confirmed' ORDER BY ID DESC LIMIT 1";
$checkStmt = $conn->prepare($checkPaymentSql);
$checkStmt->bind_param("s", $customerID);
$checkStmt->execute();
$paymentResult = $checkStmt->get_result();

if ($paymentResult->num_rows > 0) {
    // Customer has an existing payment method
    $paymentMethod = $paymentResult->fetch_assoc();
    
    // Store payment method in session for verification
    $_SESSION['existing_payment_method'] = $paymentMethod;
    
    // Redirect to verify payment method page
    echo "<script>window.location.href='verify_payment.php?restaurant=" . $restaurantID . "';</script>";
} else {
    // No existing payment method, redirect to payment setup
    echo "<script>window.location.href='payment_setup.php?restaurant=" . $restaurantID . "';</script>";
}

$stmt->close();
$checkStmt->close();
$conn->close();
?>
