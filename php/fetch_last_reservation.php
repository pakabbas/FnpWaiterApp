<?php
// Include database connection
include 'creds.php';

// Get customer ID from session or cookie
session_start();
$customerID = isset($_COOKIE['UserID']) ? $_COOKIE['UserID'] : null;

// Return error if no customer ID
if (!$customerID) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit;
}

// Query to get the last reservation for this customer
$query = "SELECT ActDate as ReservationDateTime FROM reservations 
          WHERE CustomerID = ? 
          
          ORDER BY ReservationDateTime DESC 
          LIMIT 1";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $customerID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $lastReservationTime = strtotime($row['ReservationDateTime']);
    $currentTime = time();
    $timeDifference = $currentTime - $lastReservationTime;
    $minutesDifference = $timeDifference / 60; // Convert to minutes
    
    echo json_encode([
        'status' => 'success',
        'lastReservation' => $row['ReservationDateTime'],
        'minutesSince' => $minutesDifference,
        'canBook' => ($minutesDifference > 30) // true if more than 60 minutes have passed
    ]);
} else {
    // No previous reservations found
    echo json_encode([
        'status' => 'success',
        'lastReservation' => null,
        'canBook' => true // Can book if no previous reservations
    ]);
}

$stmt->close();
$conn->close();
?>
