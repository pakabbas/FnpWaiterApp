<?php
session_start();
require_once 'creds.php'; // Include your database connection

// Check if the request is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('HTTP/1.1 400 Bad Request');
  exit('Invalid request method');
}

// Get POST data
$restaurantId = isset($_POST['rid']) ? intval($_POST['rid']) : 0;
$reservationId = isset($_POST['resid']) ? intval($_POST['resid']) : 0;
$extendedMinutes = isset($_POST['extendedTime']) ? intval($_POST['extendedTime']) : 0;
$reason = isset($_POST['reason']) ? trim($_POST['reason']) : '';

// Validate inputs
if (!$restaurantId || !$reservationId || !$extendedMinutes || empty($reason)) {
  echo '<script>alert("error");</script>';
  header('HTTP/1.1 400 Bad Request');
  exit('Missing required fields');
}

try {
  // Start transaction
  $pdo->beginTransaction();

  // First, get the current reservation details
  $stmt = $pdo->prepare("SELECT ReservationDateTime, Details FROM Reservations WHERE ReservationID = ? AND RestaurantID = ?");
  $stmt->execute([$reservationId, $restaurantId]);
  $reservation = $stmt->fetch(PDO::FETCH_ASSOC);

  if (!$reservation) {
    throw new Exception('Reservation not found');
  }

  // Calculate new extended time
  $currentDateTime = $reservation['ReservationDateTime'];
  $extendedDateTime = date('Y-m-d H:i:s', strtotime($currentDateTime . " +{$extendedMinutes} minutes"));

  // Prepare the new details log entry
  $currentTimestamp = date('Y-m-d H:i:s');
  $newLogEntry = "Extension requested by customer on {$currentTimestamp}\n";
  $updatedDetails = $reservation['Details'] ? $reservation['Details'] . $newLogEntry : $newLogEntry;

  // Update the reservation
  $stmt = $pdo->prepare("
        UPDATE Reservations 
        SET Status = 'Extension Requested',
            ExtendedTime = ?,
            ExtensionReason = ?,
            Details = ?
        WHERE ReservationID = ? 
        AND RestaurantID = ?
    ");

  $stmt->execute([
    $extendedDateTime,
    $reason,
    $updatedDetails,
    $reservationId,
    $restaurantId
  ]);

  // Commit transaction
  $pdo->commit();

  echo 'success';
} catch (Exception $e) {
  // Rollback transaction on error
  if ($pdo->inTransaction()) {
    $pdo->rollBack();
  }

  // Log the error (you should implement proper error logging)
  error_log("Error in ExtendReservation.php: " . $e->getMessage());

  header('HTTP/1.1 500 Internal Server Error');
  exit('An error occurred while processing your request');
}
