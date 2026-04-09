<?php
include 'creds.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['reservationID'], $data['latitude'], $data['longitude'])) {
    $reservationID = intval($data['reservationID']);
    $latitude = floatval($data['latitude']);
    $longitude = floatval($data['longitude']);

    $stmt = $conn->prepare("UPDATE reservations SET CustomerLatitude = ?, CustomerLongitude = ? WHERE ReservationID = ?");
    $stmt->bind_param('ddi', $latitude, $longitude, $reservationID);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
?>
