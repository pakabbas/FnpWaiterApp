<?php
session_start();

// Include database connection file
include 'creds.php';

if (isset($_GET['itemID']) && isset($_GET['RestaurantID'])) {
    $itemID = intval($_GET['itemID']); // Sanitize input
    $newRestaurantID = intval($_GET['RestaurantID']); // RestaurantID from URL
    $sides = isset($_GET['sides']) ? $_GET['sides'] : []; // Get sides array from request

    // Initialize cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Check if the cart contains items from a different restaurant
    if (!empty($_SESSION['cart'])) {
        $currentRestaurantID = reset($_SESSION['cart'])['RestaurantID']; // Get RestaurantID of the first item
        if ($currentRestaurantID !== $newRestaurantID) {
            // Clear cart if restaurant is different
            $_SESSION['cart'] = [];
        }
    }

    // Check if main item is already in the cart
    if (array_key_exists($itemID, $_SESSION['cart'])) {
        $_SESSION['cart'][$itemID]['quantity'] += 1; // Increment quantity
    } else {
        // Fetch item details from database
        $sql = "SELECT * FROM menu_items WHERE ItemID = ?";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("i", $itemID);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($row = $result->fetch_assoc()) {
                // Add main item to cart
                $_SESSION['cart'][$itemID] = [
                    'id' => $itemID,
                    'name' => $row['Name'],
                    'price' => $row['Price'],
                    'RestaurantID' => $row['RestaurantID'],
                    'Instructions' => '',
                    'quantity' => 1,
                    'sides' => [] // Initialize sides array
                ];
            }
            $stmt->close();
        }
    }

    // Add sides to cart if any are selected
    if (!empty($sides)) {
        foreach ($sides as $sideID) {
            $sideID = intval($sideID); // Sanitize input

            // Check if the side item is already in the cart
            if (array_key_exists($sideID, $_SESSION['cart'])) {
                $_SESSION['cart'][$sideID]['quantity'] += 1; // Increment quantity
            } else {
                // Fetch side item details from database
                $sql = "SELECT * FROM menu_items WHERE ItemID = ?";
                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("i", $sideID);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($row = $result->fetch_assoc()) {
                        // Add side item to the cart
                        $_SESSION['cart'][$sideID] = [
                            'id' => $sideID,
                            'name' => $row['Name'],
                            'price' => $row['Price'],
                            'RestaurantID' => $row['RestaurantID'],
                            'Instructions' => '',
                            'quantity' => 1
                        ];
                    }
                    $stmt->close();
                }
            }
        }
    }

    // Prepare JSON response
    $response = [
        "message" => $_SESSION['cart'][$itemID]['name'] . " is added to cart along with selected sides",
        "cartCount" => count($_SESSION['cart'])
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    echo json_encode(["message" => "No item ID or RestaurantID provided."]);
}

// Close the database connection
$conn->close();
