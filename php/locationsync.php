<?php
require 'creds.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_POST['UserID'] ?? null;
    $latitude = $_POST['Latitude'] ?? null;
    $longitude = $_POST['Longitude'] ?? null;

    if (!$userID || !$latitude || !$longitude) {
        echo json_encode(['success' => false, 'message' => 'Missing parameters']);
        exit;
    }

    $stmt = $conn->prepare("SELECT ReservationID FROM reservations WHERE CustomerID = ? AND Status IN ('Pending', 'Accepted') ORDER BY ReservationDateTime DESC LIMIT 1");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $reservationID = $row['ReservationID'];

        $update = $conn->prepare("UPDATE reservations SET CustomerLatitude = ?, CustomerLongitude = ? WHERE ReservationID = ?");
        $update->bind_param("ddi", $latitude, $longitude, $reservationID);
        $update->execute();

        echo json_encode(['success' => true, 'message' => 'Yes']);
    } else {
        echo json_encode(['success' => false, 'message' => 'No']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
  