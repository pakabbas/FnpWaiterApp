<?php

require_once 'creds.php'; // Adjust if your file is named differently

include 'fetch_cookies.php';
// Include your DB connection logic

// Accept both POST and GET for testing
$reason = isset($_POST['deleteReason']) ? trim($_POST['deleteReason']) : (isset($_GET['deleteReason']) ? trim($_GET['deleteReason']) : '');


if (!$userID || !$reason) {
    echo json_encode(['status' => 'error', 'message' => 'Missing user or reason']);
    exit;
}

// 1. Update AccountStatus to 'Deleted'
$stmt = $conn->prepare("UPDATE AppUsers SET AccountStatus = 'Deleted' WHERE UserID = ?");
$stmt->bind_param("i", $userID);
$success = $stmt->execute();
$stmt->close();

if ($success) {
    // echo $userID . " " . $reason;
    // 2. Log the reason in DeletionReasons
    $stmt2 = $conn->prepare("INSERT INTO DeletionReasons (UserID, Reason, CreatedAt) VALUES (?, ?, NOW())");
    $stmt2->bind_param("is", $userID, $reason);
    $stmt2->execute();
    $stmt2->close();

    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to delete account']);
}

$conn->close();
?>
