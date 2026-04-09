<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'creds.php';

// Enable error logging
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Only POST method allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

// Validate JSON input
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON input']);
    exit;
}

// Validate required parameters
if (!isset($input['qr_url']) || !isset($input['staff_id'])) {
    echo json_encode(['success' => false, 'message' => 'QR URL and staff_id are required']);
    exit;
}

$qrUrl = trim($input['qr_url']);
$staffID = intval($input['staff_id']);

// Additional validation
if (empty($qrUrl) || $staffID <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid parameters provided']);
    exit;
}

// Parse the URL to extract booking ID
$parsedUrl = parse_url($qrUrl);
$bookingID = null;

if (isset($parsedUrl['query'])) {
    parse_str($parsedUrl['query'], $queryParams);
    $bookingID = isset($queryParams['ID']) ? intval($queryParams['ID']) : null;
}

if (!$bookingID || $bookingID <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid QR URL format. Expected: https://foodnpals.com/admin/QRCode.php?ID=123']);
    exit;
}

// Log the QR scan attempt
error_log("QR Scan Attempt - StaffID: $staffID, BookingID: $bookingID, URL: $qrUrl");

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

// Fetch the current reservation details
$sqlFetchDetails = "SELECT Details, RestaurantID, Status, TableNumber FROM reservations WHERE ReservationID = ?";
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
$tableNumber = $row['TableNumber'];

// Check if booking is in correct status for completion
if ($currentStatus !== 'Accepted') {
    error_log("QR Scan Failed - Booking $bookingID is not in Accepted status. Current status: $currentStatus");
    echo json_encode([
        'success' => false, 
        'message' => 'Booking must be Accepted to be completed',
        'current_status' => $currentStatus
    ]);
    $stmt->close();
    $conn->close();
    exit;
}

// Check if booking is already completed (prevent duplicate processing)
if ($currentStatus === 'Completed') {
    error_log("QR Scan Failed - Booking $bookingID is already completed");
    echo json_encode([
        'success' => false, 
        'message' => 'Booking is already completed',
        'current_status' => $currentStatus
    ]);
    $stmt->close();
    $conn->close();
    exit;
}

// Append log to the Details column
$logEntry = "Booking Completed at $currentDateTime by StaffID: $staffID";
$newDetails = $currentDetails ? $currentDetails . "\n" . $logEntry : $logEntry;

// Update the reservation row with the new status, ActDate, and Details
$sqlUpdateReservation = "UPDATE reservations 
                         SET Status = 'Completed', ActDate = ?, Details = ? 
                         WHERE ReservationID = ?";
$stmtUpdateReservation = $conn->prepare($sqlUpdateReservation);
$stmtUpdateReservation->bind_param("ssi", $currentDateTime, $newDetails, $bookingID);

if (!$stmtUpdateReservation->execute()) {
    error_log("QR Scan Failed - Database error updating reservation $bookingID: " . $stmtUpdateReservation->error);
    echo json_encode(['success' => false, 'message' => 'Error updating reservation: ' . $stmtUpdateReservation->error]);
    $stmt->close();
    $stmtUpdateReservation->close();
    $conn->close();
    exit;
}

// Log successful completion
error_log("QR Scan Success - Booking $bookingID completed by StaffID: $staffID");

$response = [
    'success' => true,
    'message' => "Booking completed successfully",
    'data' => [
        'booking_id' => $bookingID,
        'table_number' => $tableNumber,
        'status' => 'Completed',
        'processed_at' => $currentDateTime,
        'staff_id' => $staffID,
        'qr_url' => $qrUrl,
        'extracted_id' => $bookingID
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
