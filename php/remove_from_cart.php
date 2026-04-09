<?php
session_start();

// Check if itemID is provided
if (isset($_POST['itemID'])) {
  $itemID = intval($_POST['itemID']); // Sanitize input

  // Check if cart exists
  if (isset($_SESSION['cart'])) {
    // Remove the item from the cart
    if (array_key_exists($itemID, $_SESSION['cart'])) {
      unset($_SESSION['cart'][$itemID]);
      echo "Item removed from cart.";
    } else {
      echo "Item not found in cart.";
    }
  } else {
    echo "Cart is empty.";
  }
} else {
  echo "No item ID provided.";
}
