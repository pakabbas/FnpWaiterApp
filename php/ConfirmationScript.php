<?php
// Include database connection
include 'creds.php';

// Check if required GET parameters are set
if (isset($_GET['BookingID']) && isset($_GET['TableNumber']) && isset($_GET['Action'])) {

    // Sanitize input
    $bookingID = intval($_GET['BookingID']);
    $tableNumber = intval($_GET['TableNumber']);
    $action = $_GET['Action'];

    // Determine the status based on the action
    if ($action == 'ACCEPT') {
        $status = 'Accepted';
    } elseif ($action == 'DECLINE') {
        $status = 'Declined';
    } else {
        die("Invalid action specified.");
    }

    // Get current date and time
    $currentDateTime = date('Y-m-d H:i:s');

    // Get staff ID from cookie
    if (isset($_COOKIE['StaffID'])) {
        $staffID = $_COOKIE['StaffID'];
    } else {
        die("Staff ID not found in cookie.");
    }

    // Fetch the current Details value from the database
    $sqlFetchDetails = "SELECT Details, RestaurantID FROM reservations WHERE ReservationID = ?";
    $stmt = $conn->prepare($sqlFetchDetails);
    $stmt->bind_param("i", $bookingID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        die("No reservation found with the given BookingID.");
    }

    $row = $result->fetch_assoc();
    $currentDetails = $row['Details'];
    $restaurantID = $row['RestaurantID']; // Fetch RestaurantID for time limit lookup

    // Append log to the Details column
    $logEntry = "Reservation $status at $currentDateTime by StaffID: $staffID";
    $newDetails = $currentDetails ? $currentDetails . "\n" . $logEntry : $logEntry;

    // Update the reservation row with the new status, ActDate, and Details
    $sqlUpdateReservation = "UPDATE reservations 
                             SET Status = ?, ActDate = ?, Details = ? 
                             WHERE ReservationID = ? AND TableNumber = ?";
    $stmtUpdateReservation = $conn->prepare($sqlUpdateReservation);
    $stmtUpdateReservation->bind_param("sssii", $status, $currentDateTime, $newDetails, $bookingID, $tableNumber);

    if ($stmtUpdateReservation->execute()) {
        // echo "Reservation updated successfully!<br>";
    } else {
        echo "Error updating reservation: " . $stmtUpdateReservation->error;
    }

    // Proceed only if the action is 'ACCEPT'
    if ($action == 'ACCEPT') {
        // Fetch TableTimeLimit from the restaurant
        $sqlFetchTimeLimit = "SELECT TableTimeLimit FROM restaurants WHERE RestaurantID = ?";
        $stmtTimeLimit = $conn->prepare($sqlFetchTimeLimit);
        $stmtTimeLimit->bind_param("i", $restaurantID);
        $stmtTimeLimit->execute();
        $resultTimeLimit = $stmtTimeLimit->get_result();

        if ($resultTimeLimit->num_rows === 0) {
            die("No restaurant found with the given RestaurantID.");
        }

        $rowTimeLimit = $resultTimeLimit->fetch_assoc();
        $tableTimeLimit = ($rowTimeLimit['TableTimeLimit'] ?? 30) > 0 ? $rowTimeLimit['TableTimeLimit'] : 30;

        // Calculate ReservedUntil time by adding TableTimeLimit to the current date-time
        $reservedUntil = date('Y-m-d H:i:s', strtotime("+$tableTimeLimit minutes"));

        // Update dining_tables table: set Status to 'Reserved' and ReservedUntil
        $sqlUpdateDiningTable = "UPDATE dining_tables 
                                 SET Status = 'Reserved', ReservedUntil = ? 
                                 WHERE TableNumber = ? AND RestaurantID = ?";
        $stmtUpdateDiningTable = $conn->prepare($sqlUpdateDiningTable);
        $stmtUpdateDiningTable->bind_param("sii", $reservedUntil, $tableNumber, $restaurantID);

        if ($stmtUpdateDiningTable->execute()) {


           echo '<script>window.location.href = "Dashboard.php";</script>';
        } else {
            echo "Error updating dining table: " . $stmtUpdateDiningTable->error;
        }

        // Close time limit statement
        $stmtTimeLimit->close();
        $stmtUpdateDiningTable->close();
    } else {
        echo '<script>window.location.href = "Dashboard.php";</script>';
    }

    // Close the statements and connection
    $stmt->close();
    $stmtUpdateReservation->close();

    $conn->close();
} else {
    die("Required parameters not provided.");
}
