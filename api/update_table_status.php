<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require_once 'creds.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Only POST method allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['table_id']) || !isset($input['status'])) {
    echo json_encode(['success' => false, 'message' => 'Table ID and status required']);
    exit;
}

$table_id = intval($input['table_id']);
$status = trim($input['status']);

// Validate status
if (!in_array($status, ['Available', 'Reserved', 'occupied', 'reserved', 'maintenance'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid status']);
    exit;
}

// Update table status
$stmt = $conn->prepare("UPDATE dining_tables SET Status = ? WHERE TableID = ?");
$stmt->bind_param("si", $status, $table_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo json_encode([
        'success' => true,
        'message' => 'Table status updated successfully',
        'data' => [
            'table_id' => $table_id,
            'status' => $status
        ]
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update table status']);
}

$stmt->close();
$conn->close();
?>
