<?php
// login.php

// Database connection
include 'creds.php'; // Include your database connection credentials

// Start session
session_start();

// Get form input
$usernameOrEmail = $_POST['username'];
$password = $_POST['password'];

// Debug: Output received data
echo '<pre>';
print_r($_POST);
echo '</pre>';

// Prepare SQL query to check if user exists
$sql = "SELECT * FROM AppUsers WHERE (Username = ? OR Email = ?) AND AccountStatus = 'Active'";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $usernameOrEmail, $usernameOrEmail);
$stmt->execute();
$result = $stmt->get_result();

// Check if user exists
if ($result->num_rows > 0) {
  $user = $result->fetch_assoc();

  // Verify password
  if (password_verify($password, $user['Password'])) {
    // Password is correct, set cookies
    setcookie("UserID", $user['UserID'], time() + (86400 * 30), "/"); // 1 month
    setcookie("FirstName", $user['FirstName'], time() + (86400 * 30), "/");
    setcookie("LastName", $user['LastName'], time() + (86400 * 30), "/");
    setcookie("Email", $user['Email'], time() + (86400 * 30), "/");
    setcookie("PhoneNumber", $user['PhoneNumber'], time() + (86400 * 30), "/");
    setcookie("Address", $user['Address'], time() + (86400 * 30), "/");
    setcookie("Username", $user['Username'], time() + (86400 * 30), "/");
    setcookie("ProfilePictureURL", $user['ProfilePictureURL'], time() + (86400 * 30), "/");
    setcookie("PreferredCuisine", $user['PreferredCuisine'], time() + (86400 * 30), "/");
    setcookie("Allergies", $user['Allergies'], time() + (86400 * 30), "/");
    setcookie("DietaryPreferences", $user['DietaryPreferences'], time() + (86400 * 30), "/");
    setcookie("IsPaymentVerified", $user['IsPaymentVerified'], time() + (86400 * 30), "/");
    setcookie("AccountStatus", $user['AccountStatus'], time() + (86400 * 30), "/");
    setcookie("UserType", $user['UserType'], time() + (86400 * 30), "/");
    setcookie("DateOfBirth", $user['DateOfBirth'], time() + (86400 * 30), "/");
    setcookie("Longitude", $user['Longitude'], time() + (86400 * 30), "/");
    setcookie("Latitude", $user['Latitude'], time() + (86400 * 30), "/");
    if (empty($user['Password'])) {
        setcookie("Method", "gmail_or_apple", time() + (86400 * 30), "/");
    } else {
        setcookie("Method", "manual", time() + (86400 * 30), "/");
    }


    // Redirect to Explore page
    header("Location: Home.php");
    exit();
  } else {
    // Invalid password
    echo "<script>alert('Invalid username/email or password');</script>";
    header("Location: Login.html?Error=1");
    exit();
  }
} else {
  // No such user
  echo "<script>alert('Invalid username/email or password');</script>";
  header("Location: Login.html?Error=1");
  exit();
}

$stmt->close();
$conn->close();
