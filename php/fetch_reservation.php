<?php
// confirmation.php

// Include database connection
include 'creds.php'; // Include your database connection credentials

// Get ReservationID from URL
$reservationID = isset($_GET['ID']) ? intval($_GET['ID']) : 0;

if ($reservationID <= 0) {
    echo "Invalid Reservation ID.";
    exit();
}

// Prepare SQL query to fetch reservation details
$sql = "
    SELECT 
        r.ReservationID,
        r.CustomerID,
        r.RestaurantID,
        r.ReservationDateTime,
        r.TableNumber,
        r.Status,
        r.SpecialRequests,
        r.NumberofGuests,
        r.CheckInTime,
        r.CheckOutTime,
        r.TableID,
        r.ActDate,
         r.ExtensionReason,
        r.RestaurantLatitude AS ReservationRestaurantLatitude,
        r.RestaurantLongitude AS ReservationRestaurantLongitude,
        r.CustomerLatitude AS ReservationCustomerLatitude,
        r.CustomerLongitude AS ReservationCustomerLongitude,
        rest.Name AS RestaurantName,
        rest.Address AS RestaurantAddress,
        rest.Latitude AS RestaurantLatitude,
        rest.PhoneNumber AS PhoneNumber,
        rest.Longitude AS RestaurantLongitude,
        rest.RestaurantIcon AS RestaurantIcon,
        user.FirstName AS UserFirstName,
        user.LastName AS UserLastName,
        user.Latitude AS UserLatitude,
        user.Longitude AS UserLongitude
    FROM reservations r
    JOIN restaurants rest ON r.RestaurantID = rest.RestaurantID
    JOIN AppUsers user ON r.CustomerID = user.UserID
    WHERE r.ReservationID = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $reservationID);
$stmt->execute();
$result = $stmt->get_result();

// Fetch and display reservation details
if ($result->num_rows > 0) {
    $reservation = $result->fetch_assoc();

    // Google Maps Directions API request
    $apiKey = 'AIzaSyDP9cy_r8w6t7O0Wct3KmP0rPI0ISVQqks';
    $origin = (isset($_COOKIE['Latitude']) && isset($_COOKIE['Longitude']))
    ? $_COOKIE['Latitude'] . ',' . $_COOKIE['Longitude']
    : '0,0'; // fallback if cookies aren't set
   // $origin = "{$reservation['ReservationCustomerLatitude']},{$reservation['ReservationCustomerLongitude']}";
    
$destination = "{$reservation['ReservationRestaurantLatitude']},{$reservation['ReservationRestaurantLongitude']}";
//  $origin = "{$reservation['ReservationCustomerLatitude']},{$reservation['ReservationCustomerLongitude']}";
    //$destination = "{$reservation['ReservationRestaurantLatitude']},{$reservation['ReservationRestaurantLongitude']}";


    $PhoneNumber = $reservation['PhoneNumber']."";


    //$origin = "44.182205,-84.506836";
    //$destination = "44.192205,-84.516836";

    // URL to get directions data
    $directionsApiUrl = "https://maps.googleapis.com/maps/api/directions/json?origin=" . urlencode($destination) . "&destination=" . urlencode($origin) . "&key=" . $apiKey;

    // Fetch directions data
    $directionsResponse = file_get_contents($directionsApiUrl);
    $directionsData = json_decode($directionsResponse, true);

    if (isset($directionsData['routes'][0]['legs'][0]['duration'])) {
        $duration = $directionsData['routes'][0]['legs'][0]['duration']['text'];
        $directionsURL = "https://www.google.com/maps/embed/v1/directions?key={$apiKey}&origin={$origin}&destination={$destination}";
    } else {
        $duration = 'N/A';
        $directionsURL = '';
    }
} else {
    echo "No Booking found for the given ID.";

}


$stmt->close();
$conn->close();
