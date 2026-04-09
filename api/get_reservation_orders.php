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

// Get reservation ID from query parameter
if (!isset($_GET['reservation_id'])) {
    echo json_encode(['success' => false, 'message' => 'Reservation ID required']);
    exit;
}

$reservation_id = intval($_GET['reservation_id']);

// Fetch orders for the reservation
$stmt = $conn->prepare("
    SELECT 
        o.OrderID,
        o.CustomerID,
        o.RestaurantID,
        o.ReservationID,
        o.OrderDateTime,
        o.TotalAmount,
        o.Status as OrderStatus
    FROM orders o
    WHERE o.ReservationID = ?
    ORDER BY o.OrderDateTime DESC
");
$stmt->bind_param("i", $reservation_id);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    // Get order details for each order
    $detailStmt = $conn->prepare("
        SELECT 
            od.OrderDetailID,
            od.MenuItemID,
            od.Quantity,
            od.Subtotal,
            od.Instructions,
            mi.Name as ItemName,
            mi.Price,
            mi.Category
        FROM OrderDetails od
        LEFT JOIN menu_items mi ON od.MenuItemID = mi.ItemID
        WHERE od.OrderID = ?
        ORDER BY od.OrderDetailID
    ");
    $detailStmt->bind_param("i", $row['OrderID']);
    $detailStmt->execute();
    $detailResult = $detailStmt->get_result();
    
    $order_details = [];
    while ($detailRow = $detailResult->fetch_assoc()) {
        $order_details[] = [
            'detail_id' => $detailRow['OrderDetailID'],
            'menu_item_id' => $detailRow['MenuItemID'],
            'item_name' => $detailRow['ItemName'],
            'price' => $detailRow['Price'],
            'quantity' => $detailRow['Quantity'],
            'subtotal' => $detailRow['Subtotal'],
            'instructions' => $detailRow['Instructions'],
            'category' => $detailRow['Category']
        ];
    }
    
    $orders[] = [
        'order_id' => $row['OrderID'],
        'customer_id' => $row['CustomerID'],
        'restaurant_id' => $row['RestaurantID'],
        'reservation_id' => $row['ReservationID'],
        'order_datetime' => $row['OrderDateTime'],
        'total_amount' => $row['TotalAmount'],
        'status' => $row['OrderStatus'],
        'order_details' => $order_details
    ];
    
    $detailStmt->close();
}

echo json_encode([
    'success' => true,
    'data' => $orders
]);

$stmt->close();
$conn->close();
?>
