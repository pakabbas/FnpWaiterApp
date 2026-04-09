<?php
// logout.php

session_start();
include 'creds.php'; // DB connection

// If Email cookie is set, clear LoginToken in DB
if (isset($_COOKIE['Email'])) {
    $email = $_COOKIE['Email'];

    $stmt = $conn->prepare("UPDATE AppUsers SET LoginToken = NULL WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->close();
}

// Clear all relevant cookies
$cookieParams = [
    'UserID', 'FirstName', 'LastName', 'Email', 'PhoneNumber', 'Address',
    'Username', 'ProfilePictureURL', 'PreferredCuisine', 'Allergies',
    'DietaryPreferences', 'IsPaymentVerified', 'AccountStatus', 'UserType',
    'DateOfBirth', 'Longitude', 'Latitude'
];

foreach ($cookieParams as $param) {
    setcookie($param, '', time() - 3600, "/");
}

session_unset();
session_destroy();

$conn->close();

// Redirect to login page
header("Location: Login.html");
exit();
