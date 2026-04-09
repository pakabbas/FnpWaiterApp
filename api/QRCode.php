

<?php 
require 'checkLogin.php'; 
require 'fetch_Rcookies.php'; 
require 'creds.php';

// Enable error logging
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

if ($conn->connect_error) {
    error_log("QRCode.php - Database connection failed: " . $conn->connect_error);
    die("Connection failed: " . $conn->connect_error);
}

// Fetch ID from URL with validation
if (!isset($_GET['ID']) || empty($_GET['ID'])) {
    error_log("QRCode.php - Invalid request: No ID provided");
    echo "<script>alert('Invalid Request: No ID provided'); window.location.href='index.php';</script>";
    exit;
}

$reservationID = intval($_GET['ID']);

// Validate reservation ID
if ($reservationID <= 0) {
    error_log("QRCode.php - Invalid reservation ID: " . $_GET['ID']);
    echo "<script>alert('Invalid Request: Invalid ID format'); window.location.href='index.php';</script>";
    exit;
}

$currentTime = date("Y-m-d H:i:s");

if ($RestaurantID != "Not set") {
    // First check if reservation exists and is in correct status
    $checkSql = "SELECT Status FROM reservations WHERE ReservationID = ?";
    $checkStmt = $conn->prepare($checkSql);
    $checkStmt->bind_param("i", $reservationID);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    
    if ($checkResult->num_rows === 0) {
        error_log("QRCode.php - Reservation not found: $reservationID");
        echo "<script>alert('Reservation not found'); window.location.href='index.php';</script>";
        $checkStmt->close();
        $conn->close();
        exit;
    }
    
    $reservation = $checkResult->fetch_assoc();
    $currentStatus = $reservation['Status'];
    
    if ($currentStatus !== 'Accepted') {
        error_log("QRCode.php - Reservation $reservationID is not in Accepted status. Current: $currentStatus");
        echo "<script>alert('Reservation must be Accepted to be completed. Current status: $currentStatus'); window.location.href='index.php';</script>";
        $checkStmt->close();
        $conn->close();
        exit;
    }
    
    $checkStmt->close();

    // Update Reservation in Database using prepared statement
    $sql = "UPDATE reservations 
            SET Status = 'Completed', 
                CheckInTime = ?, 
                Details = CONCAT(COALESCE(Details, ''), '\\nBooking Completed at ', ?) 
            WHERE ReservationID = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $currentTime, $currentTime, $reservationID);

    if ($stmt->execute()) {
        error_log("QRCode.php - Successfully completed reservation $reservationID");
        echo "<script>alert('Booking marked as Completed successfully!'); window.location.href='Booking.php?ID=$reservationID';</script>";
    } else {
        error_log("QRCode.php - Error updating reservation $reservationID: " . $stmt->error);
        echo "<script>alert('Error updating booking: " . $stmt->error . "'); window.location.href='Booking.php?ID=$reservationID';</script>";
    }
    
    $stmt->close();
} else {
    error_log("QRCode.php - Restaurant ID not set");
    echo "<script>alert('Error: Restaurant not configured'); window.location.href='index.php';</script>";
}

$conn->close();
?>
