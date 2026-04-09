<?php
// auth.php

header('Content-Type: application/json');
include 'creds.php'; // DB connection
session_start();

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

function set_user_cookies($user) {
    $expire = time() + (86400 * 30); // 30 days
    setcookie("UserID", $user['UserID'], $expire, "/");
    setcookie("FirstName", $user['FirstName'], $expire, "/");
    setcookie("LastName", $user['LastName'], $expire, "/");
    setcookie("Email", $user['Email'], $expire, "/");
    setcookie("PhoneNumber", $user['PhoneNumber'], $expire, "/");
    setcookie("Address", $user['Address'], $expire, "/");
    setcookie("Username", $user['Username'], $expire, "/");
    setcookie("ProfilePictureURL", $user['ProfilePictureURL'], $expire, "/");
    setcookie("PreferredCuisine", $user['PreferredCuisine'], $expire, "/");
    setcookie("Allergies", $user['Allergies'], $expire, "/");
    setcookie("DietaryPreferences", $user['DietaryPreferences'], $expire, "/");
    setcookie("IsPaymentVerified", $user['IsPaymentVerified'], $expire, "/");
    setcookie("AccountStatus", $user['AccountStatus'], $expire, "/");
    setcookie("UserType", $user['UserType'], $expire, "/");
    setcookie("DateOfBirth", $user['DateOfBirth'], $expire, "/");
    setcookie("Longitude", $user['Longitude'], $expire, "/");
    setcookie("Latitude", $user['Latitude'], $expire, "/");
    setcookie("LoginToken", $user['LoginToken'], $expire, "/");
    
    if (empty($user['Password'])) {
        setcookie("Method", "gmail_or_apple", $expire, "/");
    } else {
        setcookie("Method", "manual", $expire, "/");
    }
}

function handleGoogleSignIn($conn, $email, $token) {
    if (!$token) {
        echo json_encode(['success' => false, 'message' => 'Token is required for Google Sign-In.']);
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM AppUsers WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($user['AccountStatus'] !== 'Active') {
            echo json_encode(['success' => false, 'message' => 'Account is not active.']);
            exit();
        }
        
        $stmt->close();
        $updateStmt = $conn->prepare("UPDATE AppUsers SET LoginToken = ? WHERE Email = ?");
        $updateStmt->bind_param("ss", $token, $email);
        if ($updateStmt->execute()) {
            $user['LoginToken'] = $token;
            set_user_cookies($user);
            echo json_encode(['success' => true, 'message' => 'Login successful.', 'user' => $user]);
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
            $user_id = $conn->insert_id;
            $fetchStmt = $conn->prepare("SELECT * FROM AppUsers WHERE UserID = ?");
            $fetchStmt->bind_param("i", $user_id);
            $fetchStmt->execute();
            $user = $fetchStmt->get_result()->fetch_assoc();
            $fetchStmt->close();
            
            set_user_cookies($user);
            echo json_encode(['success' => true, 'message' => 'User registered and logged in successfully.', 'user' => $user]);
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

    $stmt = $conn->prepare("SELECT * FROM AppUsers WHERE Email = ? AND AccountStatus = 'Active'");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['Password'])) {
            $stmt->close();
            $updateStmt = $conn->prepare("UPDATE AppUsers SET LoginToken = ? WHERE Email = ?");
            $updateStmt->bind_param("ss", $token, $email);
            if ($updateStmt->execute()) {
                $user['LoginToken'] = $token;
                set_user_cookies($user);
                echo json_encode(['success' => true, 'message' => 'Login successful.', 'user' => $user]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update token.']);
            }
            $updateStmt->close();
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid email or password.']);
    }
}

function handleTokenValidation($conn, $email, $token) {
    if (!$token) {
        echo json_encode(['success' => false, 'message' => 'Token is required for validation.']);
        exit();
    }

    $stmt = $conn->prepare("SELECT * FROM AppUsers WHERE Email = ? AND LoginToken = ? AND AccountStatus = 'Active'");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        set_user_cookies($user);
        echo json_encode(['success' => true, 'message' => 'Token is valid.', 'user' => $user]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid token.']);
    }
    $stmt->close();
}

?>
