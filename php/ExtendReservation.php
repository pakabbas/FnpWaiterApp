<?php
// Include database connection
include 'creds.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Get the form data

  $requestedMinutes = isset($_POST['extendedTime']) ? intval($_POST['extendedTime']) : 0;
  $extensionReason = isset($_POST['reason']) ? trim($_POST['reason']) : '';
  $reservationID = isset($_POST['ResID2']) ? intval($_POST['ResID2']) : null;
  echo $reservationID;
  // Validate inputs
  if ($reservationID && $requestedMinutes > 0 && !empty($extensionReason)) {
    // Fetch the current reservation details
    $query = "SELECT ReservationDateTime, Details FROM reservations WHERE ReservationID = ?";
    if ($stmt = $conn->prepare($query)) {
      $stmt->bind_param('i', $reservationID);
      $stmt->execute();
      $result = $stmt->get_result();
      if ($row = $result->fetch_assoc()) {
        $currentDateTime = $row['ReservationDateTime'];
        $currentDetails = $row['Details'];

        // Calculate new extended time
        $newExtendedTime = date('Y-m-d H:i:s', strtotime($currentDateTime . " + $requestedMinutes minutes"));

        // Append to the Details log
        $dateTimeNow = date('Y-m-d H:i:s');
        $newDetails = $currentDetails . "\nExtension requested by customer on " . $dateTimeNow . "\n";

        // Update the reservation
        $updateQuery = "
                    UPDATE reservations 
                    SET Status = 'Accepted', 
                        ExtendedTime = ?, 
                        ExtensionReason = ?, 
                        Details = ? 
                    WHERE ReservationID = ?";
        if ($updateStmt = $conn->prepare($updateQuery)) {
          $updateStmt->bind_param('sssi', $newExtendedTime, $extensionReason, $newDetails, $reservationID);
          if ($updateStmt->execute()) {
            // Redirect back to the confirmation page
            header("Location: Confirmation.php?ID=" . $reservationID);
            exit();
          } else {
            echo "Error updating booking.";
          }
          $updateStmt->close();
        }
      }
      $stmt->close();
    }
  } else {
    echo "Invalid input. Please fill all the required fields. " . "," . $extensionReason . "," . $requestedMinutes . "," . $reservationID;
  }
} else {
  echo "Invalid request method.";
}

$conn->close();
