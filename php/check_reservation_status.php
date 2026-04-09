<?php
include 'creds.php';

$reservationID = isset($_GET['ID']) ? intval($_GET['ID']) : 0;

if ($reservationID <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid Reservation ID']);
    exit();
}

$stmt = $conn->prepare("SELECT Status FROM reservations WHERE ReservationID = ?");
$stmt->bind_param("i", $reservationID);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(['success' => true, 'status' => $row['Status']]);
} else {
    echo json_encode(['success' => false, 'message' => 'Reservation not found']);
}

$stmt->close();
$conn->close();
?>