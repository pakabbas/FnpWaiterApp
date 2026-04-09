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

if (!isset($input['username']) || !isset($input['password'])) {
    echo json_encode(['success' => false, 'message' => 'Username and password required']);
    exit;
}

$username = trim($input['username']);
$password = trim($input['password']);

// Check staff credentials
$stmt = $conn->prepare("SELECT StaffID, RestaurantID, FirstName, LastName, Email, UserType, Designation FROM staff WHERE Email = ? AND Password = ? AND AccountStatus = 'active'");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $staff = $result->fetch_assoc();
    
    // Generate a simple token (in production, use proper JWT or session management)
    $token = bin2hex(random_bytes(32));
    
    // Update token in database
    $updateStmt = $conn->prepare("UPDATE staff SET Token = ? WHERE StaffID = ?");
    $updateStmt->bind_param("si", $token, $staff['StaffID']);
    $updateStmt->execute();
    
    echo json_encode([
        'success' => true,
        'message' => 'Login successful',
        'data' => [
            'staff_id' => $staff['StaffID'],
            'restaurant_id' => $staff['RestaurantID'],
            'first_name' => $staff['FirstName'],
            'last_name' => $staff['LastName'],
            'email' => $staff['Email'],
            'user_type' => $staff['UserType'],
            'designation' => $staff['Designation'],
            'token' => $token
        ]
    ]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid credentials']);
}

$stmt->close();
$conn->close();
?>
