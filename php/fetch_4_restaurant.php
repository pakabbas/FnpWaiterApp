<?php
// auth.php

header('Content-Type: application/json');
include 'creds.php'; // DB connection

$action = $_POST['action'] ?? $_GET['action'] ?? null;
$email = $_POST['email'] ?? $_GET['email'] ?? null;
$token = $_POST['token'] ?? $_GET['token'] ?? null;

if (!$action || !$email) {
    echo json_encode(['success' => false, 'message' => 'Missing required parameters.']);
    exit();
}

switch ($action) {
    case 'google_signin':
        handleGoogleSignIn($conn, $email, $token);
        break;
    
    case 'manual_login':
        $password = $_POST['password'] ?? null;
        handleManualLogin($conn, $email, $password, $token);
        break;

    case 'validate_token':
        handleTokenValidation($conn, $email, $token);
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Invalid action.']);
        break;
}

$conn->close();

function handleGoogleSignIn($conn, $email, $token) {
    if (!$token) {
        echo json_encode(['success' => false, 'message' => 'Token is required for Google Sign-In.']);
        exit();
    }

    $stmt = $conn->prepare("SELECT UserID FROM AppUsers WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // User exists, update token
        $stmt->close();
        $updateStmt = $conn->prepare("UPDATE AppUsers SET LoginToken = ? WHERE Email = ?");
        $updateStmt->bind_param("ss", $token, $email);
        if ($updateStmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Login successful.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update token.']);
        }
        $updateStmt->close();
    } else {
        // User does not exist, create new user
        $stmt->close();
        $username = $email;
        $parts = explode('@', $email);
        $firstName = ucfirst($parts[0]);
        $lastName = ''; 
        $accountStatus = "Active"; 
        $userType = "User";
        $registrationDate = date("Y-m-d H:i:s");

        $insertStmt = $conn->prepare("INSERT INTO AppUsers (FirstName, LastName, Email, Username, LoginToken, AccountStatus, UserType, RegistrationDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $insertStmt->bind_param("ssssssss", $firstName, $lastName, $email, $username, $token, $accountStatus, $userType, $registrationDate);

        if ($insertStmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'User registered and logged in successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create new user.']);
        }
        $insertStmt->close();
    }
}

function handleManualLogin($conn, $email, $password, $token) {
    if (!$password || !$token) {
        echo json_encode(['success' => false, 'message' => 'Password and token are required for manual login.']);
        exit();
    }

    $stmt = $conn->prepare("SELECT Password FROM AppUsers WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        $stmt->close();
        $updateStmt = $conn->prepare("UPDATE AppUsers SET LoginToken = ? WHERE Email = ?");
        $updateStmt->bind_param("ss", $token, $email);
        if ($updateStmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Login successful.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update token.']);
        }
        $updateStmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
    }
}

function handleTokenValidation($conn, $email, $token) {
    if (!$token) {
        echo json_encode(['success' => false, 'message' => 'Token is required for validation.']);
        exit();
    }

    $stmt = $conn->prepare("SELECT UserID FROM AppUsers WHERE Email = ? AND LoginToken = ?");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Token is valid.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid token.']);
    }
    $stmt->close();
}

?>
