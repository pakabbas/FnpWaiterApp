<?php






error_reporting(E_ALL);
ini_set('display_errors', 1);
// Database connection parameters

include 'creds.php'; // Include your DB credentials

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get ID from URL
$id = isset($_GET['ID']) ? intval($_GET['ID']) : 0;

// Fetch restaurant details from database
$sql = "SELECT * FROM restaurants WHERE RestaurantID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

$restaurant = $result->fetch_assoc();
       
// echo '<script>alert("' . $id . ": " .  $restaurant['Name'] . '");</script>';

$conn->close();
