
<?php

include 'creds.php'; // Adjust the filename as needed

$customerID = isset($_COOKIE['UserID']) ? $_COOKIE['UserID'] : null;
$today = date('Y-m-d');

// Set the timezone to Detroit/Michigan
date_default_timezone_set('America/Detroit');

if ($customerID) {
    $query = "SELECT r.ReservationID, r.RestaurantID, r.ReservationDateTime, r.ExtendedTime, rt.Name, rt.DisplayPicture
                     FROM reservations r
              JOIN restaurants rt ON r.RestaurantID = rt.RestaurantID
              WHERE r.CustomerID = ? 
              AND r.Status IN ('Pending', 'Accepted')
              ORDER BY r.ReservationID DESC
              LIMIT 1";

    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $customerID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $activeReservation = $row['ReservationID'];
        $activeReservationRestaurant = $row['RestaurantID'];
        $restaurantIcon = $row['DisplayPicture'];
        $restaurantName = $row['Name'];
        
        // Get the reservation and extended times as timestamps for comparison
        $reservationTime = strtotime($row['ReservationDateTime']);
        $extendedTime = strtotime($row['ExtendedTime']);
        $currentTime = time(); // current server time in Detroit timezone (since we've set it)

        // Check if the current time is between the reservation and extended times
        if ($currentTime >= $reservationTime && $currentTime <= $extendedTime) {
            $isReservationActive = 'Yes';
            header("Location: Confirmation.php?ID=$activeReservation");
            exit();
        } else {
            $isReservationActive = 'No';
            // If no active reservation, redirect to CustomerProfile.php
header("Location: CustomerProfile.php");
exit();
        }





    } else {
    }

    $stmt->close();
}

// Output the current time and reservation status
//echo $customerID . " " . (new DateTime())->format('Y-m-d H:i:s') . " / " . $isReservationActive." ".$reservationTime;
?>




    
        


