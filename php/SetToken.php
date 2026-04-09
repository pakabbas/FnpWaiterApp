<?php
// SetToken.php

include 'creds.php'; // DB connection

$email = $_GET['email'] ?? null;
$token = $_GET['token'] ?? null;

if (!$email || !$token) {
    header('Location: logout.php');
    exit();
}

// Check if user exists first
$checkStmt = $conn->prepare("SELECT UserID FROM AppUsers WHERE Email = ?");
$checkStmt->bind_param("s", $email);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    // User exists, so just update the token
    $checkStmt->close();
    $updateStmt = $conn->prepare("UPDATE AppUsers SET LoginToken = ? WHERE Email = ?");
    $updateStmt->bind_param("ss", $token, $email);
    if ($updateStmt->execute()) {
        // Successfully updated
        header('Location: MobileLogin.php?email=' . urlencode($email) . '&token=' . urlencode($token));
    } else {
        // Failed to update
        header('Location: logout.php');
    }
    $updateStmt->close();
} else {
    // User does not exist, create a new one
    $checkStmt->close();
    
    // Extract names from email
    $username = $email;
    $parts = explode('@', $email);
    $firstName = ucfirst($parts[0]);
    $lastName =  ucfirst($parts[0]);

    $latitude = "42.3314";  // Michigan USA
    $longitude = "-83.0458";

    $accountStatus = "Pending";
    $userType = "User";
    $registrationDate = date("Y-m-d H:i:s");

    $insertStmt = $conn->prepare("
        INSERT INTO AppUsers 
        (FirstName, LastName, Email, Username, LoginToken, Latitude, Longitude, AccountStatus, UserType, RegistrationDate) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $insertStmt->bind_param("ssssssssss", 
        $firstName, 
        $lastName, 
        $email, 
        $username, 
        $token, 
        $latitude, 
        $longitude, 
        $accountStatus, 
        $userType, 
        $registrationDate
    );

    if ($insertStmt->execute()) {
        // Successfully created user
        header('Location: MobileLogin.php?email=' . urlencode($email) . '&token=' . urlencode($token));
    } else {
        // Failed to create user
        header('Location: logout.php');
    }
    $insertStmt->close();
}

$conn->close();
exit();
