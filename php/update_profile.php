<?php
// Include database connection and start session
require_once 'creds.php';
session_start();

// Initialize response array
$response = array(
    'success' => false,
    'message' => ''
);

// Get UserID from cookie
$userID = isset($_COOKIE['UserID']) ? $_COOKIE['UserID'] : null;

if (!$userID) {
    $response['message'] = "User not authenticated";
    header("Location: Login.html");
    exit();
}

// Function to validate password
function validatePassword($conn, $userID, $currentPassword)
{
    $stmt = $conn->prepare("SELECT Password FROM AppUsers WHERE UserID = ?");
    $stmt->bind_param("i", $userID);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    // Verify password hash
    return password_verify($currentPassword, $user['Password']);
}

try {
    // Check if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get form data
        $firstName = trim($_POST['firstName']);
        $lastName = trim($_POST['lastName']);
        $mobileNo = trim($_POST['address']); // Note: named 'address' in form but used for mobile
        $currentPassword = $_POST['currentPassword'];
        $newPassword = $_POST['newPassword'];
        $confirmPassword = $_POST['confirmPassword'];

        // Validate current password
        if (!validatePassword($conn, $userID, $currentPassword)) {
            $response['message'] = "Current password is incorrect";
            header("Location: CustomerProfile.php?error=" . urlencode($response['message']));
            exit();
        }

        // Start transaction
        $conn->begin_transaction();

        // Update basic profile information
        $updateProfileStmt = $conn->prepare("
            UPDATE AppUsers 
            SET FirstName = ?,
                LastName = ?,
                PhoneNumber = ?
            WHERE UserID = ?
        ");

        $updateProfileStmt->bind_param(
            "sssi",
            $firstName,
            $lastName,
            $mobileNo,
            $userID
        );

        $updateProfileStmt->execute();
        $updateProfileStmt->close();

        // Check if password change was requested
        if (!empty($newPassword) && !empty($confirmPassword)) {
            // Validate new password and confirmation match
            if ($newPassword !== $confirmPassword) {
                throw new Exception("New password and confirmation do not match");
            }

            // Validate password strength (add your own criteria)
            if (strlen($newPassword) < 8) {
                throw new Exception("New password must be at least 8 characters long");
            }

            // Hash new password
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update password
            $updatePasswordStmt = $conn->prepare("
                UPDATE AppUsers 
                SET Password = ?
                WHERE UserID = ?
            ");

            $updatePasswordStmt->bind_param("si", $newPasswordHash, $userID);
            $updatePasswordStmt->execute();
            $updatePasswordStmt->close();
        }

        // Commit transaction
        $conn->commit();

        // Set success response
        $response['success'] = true;
        $response['message'] = "Profile updated successfully";
        header("Location: CustomerProfile.php?success=" . urlencode($response['message']));
        exit();
    } else {
        throw new Exception("Invalid request method");
    }
} catch (Exception $e) {
    // Rollback transaction on error
    if ($conn->connect_errno === 0) {
        $conn->rollback();
    }

    // Log error
    error_log("Error updating profile: " . $e->getMessage());

    // Set error response
    $response['message'] = "Error updating profile: " . $e->getMessage();
    header("Location: CustomerProfile.php?error=" . urlencode($response['message']));
    exit();
} finally {
    // Close database connection
    $conn->close();
}
