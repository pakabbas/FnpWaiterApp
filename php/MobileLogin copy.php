<?php
// MobileLogin.php

include 'creds.php';
session_start();

// Get email and token from GET params
$email = $_GET['email'] ?? '';
$token = $_GET['token'] ?? '';

// If missing params, redirect to logout
if (empty($email) || empty($token)) {
    header("Location: logout.php");
    exit();
}

try {
    // Check user with matching token
    $sql = "SELECT * FROM AppUsers WHERE LoginToken = ? AND AccountStatus != 'Deleted'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        header("Location: logout.php");
        exit();
    }

    $user = $result->fetch_assoc();

    // Set cookies for 30 days
    $expire = time() + (86400 * 30);
    foreach ($user as $key => $value) {
        if (!is_numeric($key)) {
            setcookie($key, $value, $expire, "/");
        }
    }

    header("Location: HomeMobile.php");
    exit();
} catch (Exception $e) {
    // On any error, redirect to logout
    header("Location: logout.php");
    exit();
}
?>
