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

    $stmt = $conn->prepare("SELECT * FROM AppUsers WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, update token
        $user = $result->fetch_assoc();
        $stmt->close();
        $updateStmt = $conn->prepare("UPDATE AppUsers SET LoginToken = ? WHERE Email = ?");
        $updateStmt->bind_param("ss", $token, $email);
        if ($updateStmt->execute()) {
            $user['LoginToken'] = $token; // Manually update token in our user array
            foreach ($user as $key => $value) {
                if (!is_numeric($key)) {
                    setcookie($key, $value, time() + (86400 * 30), "/");
                }
            }
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
            
            foreach ($user as $key => $value) {
                if (!is_numeric($key)) {
                    setcookie($key, $value, time() + (86400 * 30), "/");
                }
            }
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

    $stmt = $conn->prepare("SELECT * FROM AppUsers WHERE Email = ?");
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
                $user['LoginToken'] = $token; // Manually update token in our user array
                foreach ($user as $key => $value) {
                    if (!is_numeric($key)) {
                        setcookie($key, $value, time() + (86400 * 30), "/");
                    }
                }
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

    $stmt = $conn->prepare("SELECT * FROM AppUsers WHERE Email = ? AND LoginToken = ?");
    $stmt->bind_param("ss", $email, $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        foreach ($user as $key => $value) {
            if (!is_numeric($key)) {
                setcookie($key, $value, time() + (86400 * 30), "/");
            }
        }
        echo json_encode(['success' => true, 'message' => 'Token is valid.', 'user' => $user]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid token.']);
    }
    $stmt->close();
}

?>
