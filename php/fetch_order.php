<?php
// Include your database credentials
include 'creds.php'; // Modify this if the path is different

try {
    // Initialize a new PDO connection
    $pdo = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
    // Set PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the ReservationID from the URL
    if (isset($_GET['ID'])) {
        $reservationID = $_GET['ID'];

        // Fetch order details based on the ReservationID
        $query = "SELECT o.OrderID, o.TotalAmount, od.OrderDetailID, od.MenuItemID, od.Quantity, od.Subtotal, od.Instructions,mi.Name
                  FROM orders o
                  JOIN OrderDetails od ON o.OrderID = od.OrderID
                  JOIN menu_items mi ON mi.ItemID = od.MenuItemID
                  WHERE o.ReservationID = :reservationID";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':reservationID', $reservationID, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch all the order details
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Get the total amount for the order
        $totalAmountQuery = "SELECT TotalAmount FROM orders WHERE ReservationID = :reservationID LIMIT 1";
        $totalStmt = $pdo->prepare($totalAmountQuery);
        $totalStmt->bindParam(':reservationID', $reservationID, PDO::PARAM_INT);
        $totalStmt->execute();

        $totalRow = $totalStmt->fetch(PDO::FETCH_ASSOC);
        $grandTotal = $totalRow ? $totalRow['TotalAmount'] : 0; // Default to 0 if no total found
    } else {
        echo "No Booking ID provided!";
    }
} catch (PDOException $e) {
    // Handle any connection or query errors
    echo "Error: " . $e->getMessage();
}
