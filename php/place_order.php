<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .loader-container {
            text-align: center;
        }
        .loader {
            border: 8px solid #f3f3f3;
            border-radius: 50%;
            border-top: 8px solid #4cbb17;
            width: 60px;
            height: 60px;
            margin: 0 auto 20px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .loading-text {
            color: #333;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="loader-container">
        <div class="loader"></div>
        <p class="loading-text">Processing your order, please wait...</p>
    </div>
<?php
session_start();
include 'creds.php';

// Rest of the PHP code remains unchanged
if (isset($_SESSION['cart']) && !empty($_SESSION['cart']) && isset($_COOKIE['UserID'])) {
  // Get CustomerID from cookie
  $customerID = intval($_COOKIE['UserID']);
  $restaurantID = intval($_GET['RestaurantID']); // Get RestaurantID from URL or session
  $reservationID = intval($_GET['ReservationID']); // Get ReservationID from URL or session
  $orderDateTime = date('Y-m-d H:i:s'); // Current timestamp
  $totalAmount = 0; // This will be calculated from the cart

  // Validate: Check if a previous order exists for this ReservationID
  $sql = "SELECT * FROM orders WHERE ReservationID = ?";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $reservationID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
      echo "<script>
                Swal.fire({
                    title: 'Order Already Exists!',
                    text: 'An order has already been placed for this booking.',
                    icon: 'error',
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#4cbb17'
                }).then(function() {
                    window.location.href = 'Confirmation.php?ID=" . $reservationID . "';
                });
            </script>";
      exit();
    }
    $stmt->close();
  }

  // Validate: Check if the person placing the order is the one who made the reservation
  $sql = "SELECT CustomerID, Status FROM reservations WHERE ReservationID = ?";
  if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $reservationID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
      if ($row['CustomerID'] != $customerID) {
        echo "<script>
                Swal.fire({
                    title: 'Unauthorized!',
                    text: 'You are not authorized to place an order for this booking.',
                    icon: 'error',
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#4cbb17'
                }).then(function() {
                    window.location.href = 'Profile.php?ID=" . $restaurantID . "';
                });
            </script>";
        exit();
      }
      
      // Check if reservation status is 'Accepted'
      if ($row['Status'] !== 'Accepted') {
        echo "<script>
                Swal.fire({
                    title: 'Sorry!',
                    text: 'Booking status is not Accepted. You cannot place this order.',
                    icon: 'error',
                    confirmButtonText: 'Ok',
                    confirmButtonColor: '#4cbb17'
                }).then(function() {
                    window.location.href = 'Confirmation.php?ID=" . $reservationID . "';
                });
              </script>";
        exit();
      }
    }
    $stmt->close();
  }

  // Start database transaction
  $conn->begin_transaction();

  try {
    foreach ($_SESSION['cart'] as $item) {
      $totalAmount += $item['price'] * $item['quantity'];
    }

    $sql = "INSERT INTO orders (CustomerID, RestaurantID, ReservationID, OrderDateTime, TotalAmount, Status) VALUES (?, ?, ?, ?, ?, ?)";
    $status = 'Pending';
    if ($stmt = $conn->prepare($sql)) {
      $stmt->bind_param("iiisds", $customerID, $restaurantID, $reservationID, $orderDateTime, $totalAmount, $status);
      $stmt->execute();
      $orderID = $stmt->insert_id;
      $stmt->close();
    }

    foreach ($_SESSION['cart'] as $item) {
      $menuItemID = $item['id'];
      $quantity = $item['quantity'];
      $subtotal = $item['price'] * $item['quantity'];
      $instructions = '';

      $sql = "INSERT INTO OrderDetails (OrderID, MenuItemID, Quantity, Subtotal, Instructions) VALUES (?, ?, ?, ?, ?)";
      if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("iiids", $orderID, $menuItemID, $quantity, $subtotal, $instructions);
        $stmt->execute();
        $stmt->close();
      }
    }

    $conn->commit();
    unset($_SESSION['cart']);

    echo "<script>
            Swal.fire({
                title: 'Success!',
                text: 'Order placed successfully.',
                icon: 'success',
                confirmButtonText: 'Ok',
                confirmButtonColor: '#4cbb17'
            }).then(function() {
                setTimeout(function() {
                    window.location.href = 'Confirmation.php?ID=" . $reservationID . "';
                }, 3000);
            });
        </script>";
  } catch (Exception $e) {
    $conn->rollback();
    echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'Error placing the order: " . $e->getMessage() . "',
                icon: 'error',
                confirmButtonText: 'Ok',
                confirmButtonColor: '#4cbb17'
            }).then(function() {
                window.location.href = 'Profile.php?ID=" . $_GET['RestaurantID'] . "';
            });
        </script>";
  }
} else {
  echo "<script>
        Swal.fire({
            title: 'Order Failed!',
            text: 'Your Order has failed. Please try again later.',
            icon: 'error',
            confirmButtonText: 'Ok',
            confirmButtonColor: '#4cbb17'
        });
    </script>";
}

$conn->close();
?>
</body>
</html>
