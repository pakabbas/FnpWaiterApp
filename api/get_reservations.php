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

// Get today's date in restaurant timezone
$today = getTodayInRestaurantTimezone($restaurant_timezone);

// Fetch today's reservations for the restaurant
$stmt = $conn->prepare("
    SELECT 
        r.ReservationID,
        r.CustomerID,
        r.ReservationDateTime,
        r.TableNumber,
        r.Status,
        r.SpecialRequests,
        r.NumberofGuests,
        r.CheckInTime,
        r.CheckOutTime,
        r.TableID,
        r.CustomerLatitude,
        r.CustomerLongitude,
        r.RestaurantLatitude,
        r.RestaurantLongitude,
        r.Details,
        r.ExtendedTime,
        r.ExtensionReason,
        CONCAT(u.FirstName, ' ', u.LastName) as CustomerName,
        u.PhoneNumber,
        u.Email
    FROM reservations r
    LEFT JOIN AppUsers u ON r.CustomerID = u.UserID
    WHERE r.RestaurantID = ? 
    AND DATE(r.ReservationDateTime) = ?
    ORDER BY r.ReservationDateTime DESC
");
$stmt->bind_param("is", $restaurant_id, $today);
$stmt->execute();
$result = $stmt->get_result();

$reservations = [];
while ($row = $result->fetch_assoc()) {
    $reservations[] = [
        'reservation_id' => $row['ReservationID'],
        'customer_id' => $row['CustomerID'],
        'customer_name' => $row['CustomerName'] ?: 'Unknown Customer',
        'reservation_datetime' => $row['ReservationDateTime'],
        'reservation_datetime_local' => formatDateTimeForDisplay($row['ReservationDateTime'], $restaurant_timezone),
        'table_number' => $row['TableNumber'],
        'status' => $row['Status'],
        'special_requests' => $row['SpecialRequests'],
        'number_of_guests' => $row['NumberofGuests'],
        'check_in_time' => $row['CheckInTime'],
        'check_in_time_local' => $row['CheckInTime'] ? formatDateTimeForDisplay($row['CheckInTime'], $restaurant_timezone) : null,
        'check_out_time' => $row['CheckOutTime'],
        'check_out_time_local' => $row['CheckOutTime'] ? formatDateTimeForDisplay($row['CheckOutTime'], $restaurant_timezone) : null,
        'table_id' => $row['TableID'],
        'customer_latitude' => $row['CustomerLatitude'],
        'customer_longitude' => $row['CustomerLongitude'],
        'restaurant_latitude' => $row['RestaurantLatitude'],
        'restaurant_longitude' => $row['RestaurantLongitude'],
        'details' => $row['Details'],
        'phone_number' => $row['PhoneNumber'],
        'email' => $row['Email'],
        'extended_time' => $row['ExtendedTime'],
        'extended_time_local' => $row['ExtendedTime'] ? formatDateTimeForDisplay($row['ExtendedTime'], $restaurant_timezone) : null,
        'extension_reason' => $row['ExtensionReason'],
        'restaurant_timezone' => $restaurant_timezone
    ];
}

echo json_encode([
    'success' => true,
    'data' => $reservations
]);

$stmt->close();
$conn->close();
?>
