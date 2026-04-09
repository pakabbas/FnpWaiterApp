<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require_once 'creds.php';

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

// Fetch dining tables for the restaurant
$stmt = $conn->prepare("SELECT TableID, TableNumber, Capacity, Status, Description FROM dining_tables WHERE RestaurantID = ? ORDER BY TableNumber");
$stmt->bind_param("i", $restaurant_id);
$stmt->execute();
$result = $stmt->get_result();

$tables = [];
while ($row = $result->fetch_assoc()) {
    $tables[] = [
        'table_id' => $row['TableID'],
        'table_number' => $row['TableNumber'],
        'capacity' => $row['Capacity'],
        'status' => $row['Status'],
        'description' => $row['Description'],
        'is_occupied' => ($row['Status'] === 'occupied')
    ];
}

echo json_encode([
    'success' => true,
    'data' => $tables
]);

$stmt->close();
$conn->close();
?>
