<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require_once 'creds.php';
require_once 'timezone_utils.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Only POST method allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['reservation_id'])) {
    echo json_encode(['success' => false, 'message' => 'Reservation ID required']);
    exit;
}

$reservation_id = intval($input['reservation_id']);

// Get restaurant ID for this reservation to determine timezone
$stmt = $conn->prepare("SELECT RestaurantID FROM reservations WHERE ReservationID = ?");
$stmt->bind_param("i", $reservation_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $restaurant_id = $row['RestaurantID'];
    $restaurant_timezone = getRestaurantTimezone($conn, $restaurant_id);
} else {
    echo json_encode(['success' => false, 'message' => 'Reservation not found']);
    exit;
}
$stmt->close();

// Build dynamic update query based on provided fields
$updateFields = [];
$params = [];
$types = '';

if (isset($input['status'])) {
    $updateFields[] = "Status = ?";
    $params[] = trim($input['status']);
    $types .= 's';
}

if (isset($input['special_requests'])) {
    $updateFields[] = "SpecialRequests = ?";
    $params[] = trim($input['special_requests']);
    $types .= 's';
}

if (isset($input['number_of_guests'])) {
    $updateFields[] = "NumberofGuests = ?";
    $params[] = intval($input['number_of_guests']);
    $types .= 'i';
}

if (isset($input['check_in_time'])) {
    $updateFields[] = "CheckInTime = ?";
    // Convert from restaurant timezone to UTC for storage
    $utc_check_in = convertToUTC($input['check_in_time'], $restaurant_timezone);
    $params[] = $utc_check_in;
    $types .= 's';
}

if (isset($input['check_out_time'])) {
    $updateFields[] = "CheckOutTime = ?";
    // Convert from restaurant timezone to UTC for storage
    $utc_check_out = convertToUTC($input['check_out_time'], $restaurant_timezone);
    $params[] = $utc_check_out;
    $types .= 's';
}

if (isset($input['details'])) {
    $updateFields[] = "Details = ?";
    $params[] = trim($input['details']);
    $types .= 's';
}

if (isset($input['table_id'])) {
    $updateFields[] = "TableID = ?";
    $params[] = intval($input['table_id']);
    $types .= 'i';
}

if (isset($input['table_number'])) {
    $updateFields[] = "TableNumber = ?";
    $params[] = intval($input['table_number']);
    $types .= 'i';
}

if (isset($input['decline_reason'])) {
    $updateFields[] = "DeclineReason = ?";
    $params[] = trim($input['decline_reason']);
    $types .= 's';
}

if (empty($updateFields)) {
    echo json_encode(['success' => false, 'message' => 'No fields to update']);
    exit;
}

$params[] = $reservation_id;
$types .= 'i';

$sql = "UPDATE reservations SET " . implode(', ', $updateFields) . " WHERE ReservationID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode([
        'success' => true,
        'message' => 'Reservation updated successfully',
        'data' => [
            'reservation_id' => $reservation_id
        ]
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update reservation']);
}

$stmt->close();
$conn->close();
?>
