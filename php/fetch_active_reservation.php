<?php

include 'creds.php'; // for db conn

$customerID = isset($_COOKIE['UserID']) ? $_COOKIE['UserID'] : null;
$today = date('Y-m-d');
$activeReservationRestaurant = '';
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
        $restaurantName1 = $row['Name'];
        
        // Get the reservation and extended times as timestamps for comparison
        $reservationTime = strtotime($row['ReservationDateTime']);
        $extendedTime = strtotime($row['ExtendedTime']);
        $currentTime = time(); // current server time in Detroit timezone (since we've set it)

        // Check if the current time is between the reservation and extended times
        if ($currentTime >= $reservationTime && $currentTime <= $extendedTime) {
            $isReservationActive = 'Yes';
        } else {
            $isReservationActive = 'No';
        }

        $_SESSION['ReservationID'] = $row['ReservationID'];
        $_SESSION['RName'] = $row['Name'];
    } else {
        $_SESSION['ReservationID'] = "";
        $_SESSION['RName'] = "";
        $isReservationActive = "No";
        $activeReservation = "0";
    }

    $stmt->close();
}

if (isset($isReservationActive) && $isReservationActive === 'Yes') {

    echo "<script>
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            document.cookie = 'Latitude=' + lat + '; path=/';
            document.cookie = 'Longitude=' + lng + '; path=/';

            fetch('update_location.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    reservationID: '{$activeReservation}',
                    latitude: lat,
                    longitude: lng
                })
            });
        }, function(error) {
           // alert('Error fetching location: ' + error.message);
        });
    } else {
        //alert('Geolocation not supported by this browser.');
    }
</script>";


}


// Output the current time and reservation status
//echo $customerID . " " . (new DateTime())->format('Y-m-d H:i:s') . " / " . $isReservationActive." ".$reservationTime;
?>
