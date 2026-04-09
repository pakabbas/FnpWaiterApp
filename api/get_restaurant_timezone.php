<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require_once 'creds.php';
require_once 'timezone_utils.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode(['success' => false, 'message' => 'Only GET method allowed']);
    exit;
}

// Get restaurant ID from query parameter
if (!isset($_GET['restaurant_id'])) {
    echo json_encode(['success' => false, 'message' => 'Restaurant ID required']);
    exit;
}

$restaurant_id = intval($_GET['restaurant_id']);

// Get restaurant timezone
$restaurant_timezone = getRestaurantTimezone($conn, $restaurant_id);

echo json_encode([
    'success' => true,
    'data' => [
        'restaurant_id' => $restaurant_id,
        'timezone' => $restaurant_timezone,
        'current_time' => getCurrentRestaurantTime($restaurant_timezone),
        'today' => getTodayInRestaurantTimezone($restaurant_timezone)
    ]
]);

$conn->close();
?>
