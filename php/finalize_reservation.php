<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
include 'creds.php';

// Start session
session_start();

// Check if reservation data exists in session
if (!isset($_SESSION['reservation_data'])) {
    echo "<script>
        alert('No reservation data found. Please try again.');
        window.location.href = 'Home.php';
    </script>";
    exit;
}

// Get reservation data from session
$data = $_SESSION['reservation_data'];

// Insert reservation into database
$sql = "INSERT INTO reservations 
(CustomerID, RestaurantID, ReservationDateTime, TableNumber, Status, NumberofGuests, 
 TableID, ActDate, RestaurantLatitude, RestaurantLongitude, CustomerLatitude,
 CustomerLongitude, ExtendedTime, Details) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, DATE_ADD(?, INTERVAL ? MINUTE), ?)";

$stmt = $conn->prepare($sql);

$stmt->bind_param("iissssissssssis", 
    $data['customerID'],          // CustomerID
    $data['restaurantID'],        // RestaurantID
    $data['reservationTime'],     // ReservationDateTime
    $data['selectedTable'],       // TableNumber
    $data['status'],              // Status
    $data['guests'],              // NumberofGuests
    $data['tableID'],             // TableID
    $data['reservationTime'],     // ActDate
    $data['restaurantLatitude'],  // RestaurantLatitude
    $data['restaurantLongitude'], // RestaurantLongitude
    $data['customerLatitude'],    // CustomerLatitude
    $data['customerLongitude'],   // CustomerLongitude
    $data['reservationTime'],     // The reservation time to add the interval to
    $data['tableTimeLimit'],      // Interval (tableTimeLimit in minutes)
    $data['specialInstructions']  // Special instructions
);

if ($stmt->execute()) {
    $reservationID = $conn->insert_id;
    
    // Update the BookingID in the StripeCustomers table
    $updateSql = "UPDATE StripeCustomers SET BookingID = ? WHERE BookingID = 0 AND CustomerID = ? ORDER BY ID DESC LIMIT 1";
    $updateStmt = $conn->prepare($updateSql);
    $updateStmt->bind_param("is", $reservationID, $data['customerID']);
    $updateStmt->execute();
    $updateStmt->close();
    
    // Clear the session reservation data
    unset($_SESSION['reservation_data']);
    
    // Redirect to confirmation page
    header("Location: Confirmation.php?ID=" . $reservationID);
    exit;
} else {
    echo "<script>
        alert('Error making reservation: " . $stmt->error . "');
        window.location.href = 'Profile.php?ID=" . $data['restaurantID'] . "';
    </script>";
}

$stmt->close();
$conn->close();
?> 