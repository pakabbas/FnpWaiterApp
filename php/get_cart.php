<?php
session_start();
header('Content-Type: application/json');

// Dummy data for restaurant and reservation ID (replace with actual data)
$response = [
    'restaurantName' => $_SESSION['RName'], // Replace with actual name
    'reservationID' =>  $_SESSION['ReservationID'], // Replace with actual ID
    'items' => []
];

if (isset($_SESSION['cart'])) {
    foreach ($_SESSION['cart'] as $itemID => $item) {
        $response['items'][] = [
            'id' => $itemID, // Make sure this line exists
            'name' => $item['name'],
            'price' => $item['price'],
            'RestaurantID' => $item['RestaurantID'],
            'quantity' => $item['quantity']
        ];
    }
}

echo json_encode($response);
