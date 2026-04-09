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

if (!isset($input['staff_id']) || !isset($input['fcm_token'])) {
    echo json_encode(['success' => false, 'message' => 'Staff ID and FCM token required']);
    exit;
}

$staff_id = intval($input['staff_id']);
$fcm_token = trim($input['fcm_token']);

if ($staff_id <= 0 || empty($fcm_token)) {
    echo json_encode(['success' => false, 'message' => 'Invalid staff ID or FCM token']);
    exit;
}

// Check if staff exists
$checkStmt = $conn->prepare("SELECT StaffID FROM staff WHERE StaffID = ? AND AccountStatus = 'Active'");
$checkStmt->bind_param("i", $staff_id);
$checkStmt->execute();
$result = $checkStmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Staff not found or inactive']);
    $checkStmt->close();
    $conn->close();
    exit;
}

// Update FCM token in database
$updateStmt = $conn->prepare("UPDATE staff SET FCMToken = ? WHERE StaffID = ?");
$updateStmt->bind_param("si", $fcm_token, $staff_id);

if ($updateStmt->execute()) {
    if ($updateStmt->affected_rows > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'FCM token updated successfully',
            'data' => [
                'staff_id' => $staff_id,
                'fcm_token' => $fcm_token,
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No changes made to FCM token']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update FCM token']);
}

$checkStmt->close();
$updateStmt->close();
$conn->close();
?>
