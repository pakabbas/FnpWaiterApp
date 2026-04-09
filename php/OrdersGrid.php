<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
require 'creds.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if (!isset($userID) || empty($userID)) {
    // Use JavaScript to redirect since header() can't be used after content is sent
    echo "<script type='text/javascript'>
        if (typeof window !== 'undefined' && window.location) {
            window.location.href = 'Login.html';
        } else {
            document.location.href = 'Login.html';
        }
    </script>";
    exit();
}

// Pagination setup
$ordersPerPage = 6;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $ordersPerPage;

// Get total number of orders for pagination
$countSql = "SELECT COUNT(OrderID) AS total FROM orders WHERE CustomerID = '" . $userID . "'";
$countResult = $conn->query($countSql);
$totalOrders = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalOrders / $ordersPerPage);

// SQL query to fetch data from the orders and restaurants tables with pagination
$sql = "
    SELECT o.OrderID, o.OrderDateTime, o.TotalAmount, o.Status, o.ReservationID,
           res.Name AS RestaurantName, res.DisplayPicture
    FROM orders o
    JOIN restaurants res ON o.RestaurantID = res.RestaurantID
    WHERE o.CustomerID = '" . $userID . "' 
    ORDER BY o.OrderID DESC
    LIMIT $ordersPerPage OFFSET $offset";

$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Start the card HTML
    while ($row = $result->fetch_assoc()) {
        // Check if the restaurant has an image, if not use a placeholder
        $imageSrc = !empty($row['DisplayPicture']) ? "Resources/" . $row['DisplayPicture'] : 'Resources/R1.png';

        ?>
        <div class="col-12 col-md-6 mb-3">
            <div class="card" onclick="window.location.href='Confirmation.php?ID=<?php echo htmlspecialchars($row['ReservationID']); ?>'" style="border-radius: 8px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1); cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.15)';" onmouseout="this.style.transform='none'; this.style.boxShadow='0 1px 4px rgba(0,0,0,0.1)';">
                <div class="card-body" style="padding: 12px;">
                    <div style="display: flex; align-items: start;">
                        <img src="<?php echo $imageSrc; ?>" alt="Restaurant Image" style="width: 100px; height: 70px; border-radius: 5px; object-fit: cover;">
                        <div style="margin-left: 12px; flex-grow: 1;">
                            <div style="display: flex; flex-direction: column;">
                                <div style="display: flex; justify-content: space-between; align-items: start; flex-wrap: wrap;">
                                    <h6 style="margin: 0; font-size: 16px; max-width: 70%;"><?php echo htmlspecialchars($row["RestaurantName"]); ?></h6>
                                    <div class="badge" style="padding: 4px 8px; border-radius: 4px; background-color: #f1f1f1; color: #007bff; font-size: 12px; white-space: nowrap;">
                                        <?php echo date('m/d/Y h:i A', strtotime($row['OrderDateTime'])); ?>
                                    </div>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 8px; flex-wrap: wrap; gap: 4px;">
                                    <div style="font-weight: bold; color: #28a745;">$<?php echo htmlspecialchars($row['TotalAmount']); ?></div>
                                    <p style="font-size: 13px; color: #333; margin: 0;">ID: #<?php echo htmlspecialchars($row["OrderID"]); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
} else {
    echo "<div>No orders found</div>";
}

// Pagination links
if ($totalPages > 1) {
    echo '<nav aria-label="Page navigation" class="w-100">';
    echo '<ul class="pagination justify-content-center" style="padding: 20px 0;">';

    // Previous button
    if ($page > 1) {
        echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '" style="color: #4cbb17;">Previous</a></li>';
    } else {
        echo '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a></li>';
    }

    // Page numbers
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $page) {
            echo '<li class="page-item active"><a class="page-link" href="#" style="background-color: #4cbb17; border-color: #4cbb17;">' . $i . '</a></li>';
        } else {
            echo '<li class="page-item"><a class="page-link" href="?page=' . $i . '" style="color: #4cbb17;">' . $i . '</a></li>';
        }
    }

    // Next button
    if ($page < $totalPages) {
        echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '" style="color: #4cbb17;">Next</a></li>';
    } else {
        echo '<li class="page-item disabled"><a class="page-link" href="#">Next</a></li>';
    }

    echo '</ul>';
    echo '</nav>';
}

// Close connection
$conn->close();
?>
