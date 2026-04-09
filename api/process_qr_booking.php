<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'creds.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Only POST method allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

// Validate required parameters
if (!isset($input['booking_id']) || !isset($input['table_number']) || !isset($input['action']) || !isset($input['staff_id'])) {
    echo json_encode(['success' => false, 'message' => 'Missing required parameters: booking_id, table_number, action, staff_id']);
    exit;
}

$bookingID = intval($input['booking_id']);
$tableNumber = intval($input['table_number']);
$action = strtoupper(trim($input['action']));
$staffID = intval($input['staff_id']);

// Validate action
if (!in_array($action, ['COMPLETE'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid action. Must be COMPLETE']);
    exit;
}

// Validate staff exists and is active
$checkStaffSql = "SELECT StaffID FROM staff WHERE StaffID = ? AND AccountStatus = 'Active'";
$checkStaffStmt = $conn->prepare($checkStaffSql);
$checkStaffStmt->bind_param("i", $staffID);
$checkStaffStmt->execute();
$staffResult = $checkStaffStmt->get_result();

if ($staffResult->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Staff not found or inactive']);
    $checkStaffStmt->close();
    $conn->close();
    exit;
}
$checkStaffStmt->close();

// Get current date and time
$currentDateTime = date('Y-m-d H:i:s');

// Determine the status based on the action
$status = 'Completed';

// Fetch the current reservation details
$sqlFetchDetails = "SELECT Details, RestaurantID, Status FROM reservations WHERE ReservationID = ?";
$stmt = $conn->prepare($sqlFetchDetails);
$stmt->bind_param("i", $bookingID);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Booking not found']);
    $stmt->close();
    $conn->close();
    exit;
}

$row = $result->fetch_assoc();
$currentDetails = $row['Details'];
$restaurantID = $row['RestaurantID'];
$currentStatus = $row['Status'];

// Check if booking is in correct status for completion
if ($currentStatus !== 'Accepted') {
    echo json_encode([
        'success' => false, 
        'message' => 'Booking must be Accepted to be completed',
        'current_status' => $currentStatus
    ]);
    $stmt->close();
    $conn->close();
    exit;
}

// Append log to the Details column
$logEntry = "Booking $status at $currentDateTime by StaffID: $staffID";
$newDetails = $currentDetails ? $currentDetails . "\n" . $logEntry : $logEntry;

// Update the reservation row with the new status, ActDate, and Details
$sqlUpdateReservation = "UPDATE reservations 
                         SET Status = ?, ActDate = ?, Details = ?, TableNumber = ? 
                         WHERE ReservationID = ?";
$stmtUpdateReservation = $conn->prepare($sqlUpdateReservation);
$stmtUpdateReservation->bind_param("sssii", $status, $currentDateTime, $newDetails, $tableNumber, $bookingID);

if (!$stmtUpdateReservation->execute()) {
    echo json_encode(['success' => false, 'message' => 'Error updating reservation: ' . $stmtUpdateReservation->error]);
    $stmt->close();
    $stmtUpdateReservation->close();
    $conn->close();
    exit;
}

$response = [
    'success' => true,
    'message' => "Booking completed successfully",
    'data' => [
        'booking_id' => $bookingID,
        'table_number' => $tableNumber,
        'status' => $status,
        'processed_at' => $currentDateTime,
        'staff_id' => $staffID
    ]
];

// Update dining_tables table: set Status back to 'Available' when booking is completed
$sqlUpdateDiningTable = "UPDATE dining_tables 
                         SET Status = 'Available', ReservedUntil = NULL 
                         WHERE TableNumber = ? AND RestaurantID = ?";
$stmtUpdateDiningTable = $conn->prepare($sqlUpdateDiningTable);
$stmtUpdateDiningTable->bind_param("ii", $tableNumber, $restaurantID);

if ($stmtUpdateDiningTable->execute()) {
    $response['data']['table_status'] = 'Available';
    $response['data']['table_freed'] = true;
} else {
    $response['warnings'][] = 'Table status update failed: ' . $stmtUpdateDiningTable->error;
}

$stmtUpdateDiningTable->close();

// Close the statements and connection
$stmt->close();
$stmtUpdateReservation->close();
$conn->close();

echo json_encode($response);
?>
