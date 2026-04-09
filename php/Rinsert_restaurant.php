<?php
include 'creds.php'; // DB connection ($conn)

function sanitize($data) {
  return htmlspecialchars(trim($data));
}

$name     = sanitize($_POST['Name'] ?? '');
$email    = sanitize($_POST['Email'] ?? '');
$phone    = sanitize($_POST['PhoneNumber'] ?? '');
$address  = sanitize($_POST['Address'] ?? '');
$lat      = $_POST['Latitude'] ?? null;
$lng      = $_POST['Longitude'] ?? null;
$password = $_POST['Password'] ?? '';
$confirm  = $_POST['ConfirmPassword'] ?? '';

// if (!$name || !$email || !$phone || !$address || !$lat || !$lng || !$password || !$confirm) {
//   die("All fields are required.");
// }

if ($password !== $confirm) {
  die("Passwords do not match.");
}

$hashed = password_hash($password, PASSWORD_DEFAULT);
$date   = date("Y-m-d H:i:s");

// Insert into restaurants
$stmt = $conn->prepare("INSERT INTO restaurants 
  (Name, Email, PhoneNumber, Address, RegistrationDate, Latitude, Longitude)
  VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $name, $email, $phone, $address, $date, $lat, $lng);

if (!$stmt->execute()) {
  die("Restaurant insert failed: " . $stmt->error);
}

$restaurantId = $conn->insert_id;

// Insert into staff table
$designation = "Admin";
$userType    = "Admin";
$firstName   = "";
$lastName    = $email;

$stmt2 = $conn->prepare("INSERT INTO staff 
  (Designation, Email, FirstName, LastName, PhoneNumber, RestaurantID, UserType,Password) 
  VALUES (?, ?, ?, ?, ?, ?, ?,?)");
$stmt2->bind_param("sssssiss", $designation, $email, $firstName, $lastName, $phone, $restaurantId, $userType,$password );

if ($stmt2->execute()) {
  echo "Restaurant and admin staff registered successfully!";
          header("Location: Payment.php?RestaurantID=6&PlanID=3");
    
} else {
  echo "Staff insert failed: " . $stmt2->error;
}
