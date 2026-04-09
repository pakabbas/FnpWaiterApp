<?php
// Include database connection
require_once 'creds.php';

// Initialize $userData array
$userData = array();

// Get UserID from cookie
$email = isset($_COOKIE['Email']) ? $_COOKIE['Email'] : 'Not set';
$userID = isset($_COOKIE['UserID']) ? $_COOKIE['UserID'] : null;

if ($userID) {
    try {
        // Prepare SQL statement
        $stmt = $conn->prepare("
            SELECT 
                *
            FROM AppUsers 
            WHERE UserID = ?
        ");

        // Bind UserID parameter
        $stmt->bind_param("i", $userID);

        // Execute the query
        $stmt->execute();

        // Get result
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Fetch user data and store in array
            $row = $result->fetch_assoc();

            // Map database columns to userData array
            $userData = array(
                'userID' => $row['UserID'],
                'firstName' => $row['FirstName'],
                'lastName' => $row['LastName'],
                'email' => $row['Email'],
                'phoneNumber' => $row['PhoneNumber'],
                'address' => $row['Address'],
                'username' => $row['Username'],
                'location' => $row['Location'],
                'profilePicture' => $row['ProfilePictureURL'],
                'preferredCuisine' => $row['PreferredCuisine'],
                'isPaymentVerified' => $row['IsPaymentVerified'],
                'accountStatus' => $row['AccountStatus'],
                'userType' => $row['UserType'],
                'dateOfBirth' => $row['DateOfBirth']
            );
        } else {
            // No user found with this ID, try email instead
            if ($email != 'Not set') {
                $stmt->close(); // Close previous statement
                
                // Try to find user by email
                $stmt = $conn->prepare("SELECT * FROM AppUsers WHERE Email = ?");
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $result = $stmt->get_result();
                
                if ($result->num_rows > 0) {
                    // User found by email
                    $row = $result->fetch_assoc();
                    
                    // Map database columns to userData array
                    $userData = array(
                        'userID' => $row['UserID'],
                        'firstName' => $row['FirstName'],
                        'lastName' => $row['LastName'],
                        'email' => $row['Email'],
                        'phoneNumber' => $row['PhoneNumber'],
                        'address' => $row['Address'],
                        'username' => $row['Username'],
                        'location' => $row['Location'],
                        'profilePicture' => $row['ProfilePictureURL'],
                        'preferredCuisine' => $row['PreferredCuisine'],
                        'isPaymentVerified' => $row['IsPaymentVerified'],
                        'accountStatus' => $row['AccountStatus'],
                        'userType' => $row['UserType'],
                        'dateOfBirth' => $row['DateOfBirth']
                    );
                    
                    // Set UserID cookie since we found the user by email
                    setcookie('UserID', $row['UserID'], time() + (86400 * 30), "/");
                } else {
                    // User not found by email either
                    error_log("No user found with Email: " . $email);
                    header("Location: Login.html");
                    exit();
                }
            } else {
                // No email to try with
                error_log("No user found with ID: " . $userID);
                header("Location: Login.html");
                exit();
            }
        }

        // Close statement
        $stmt->close();
    } catch (Exception $e) {
        // Log the error
        error_log("Error fetching user data: " . $e->getMessage());
        $userData = array(); // Reset userData on error
    }
} else if ($email != 'Not set') {
    // No UserID cookie but we have email, try to find user by email
    try {
        $stmt = $conn->prepare("SELECT * FROM AppUsers WHERE Email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // User found by email
            $row = $result->fetch_assoc();
            
            // Map database columns to userData array
            $userData = array(
                'userID' => $row['UserID'],
                'firstName' => $row['FirstName'],
                'lastName' => $row['LastName'],
                'email' => $row['Email'],
                'phoneNumber' => $row['PhoneNumber'],
                'address' => $row['Address'],
                'username' => $row['Username'],
                'location' => $row['Location'],
                'profilePicture' => $row['ProfilePictureURL'],
                'preferredCuisine' => $row['PreferredCuisine'],
                'isPaymentVerified' => $row['IsPaymentVerified'],
                'accountStatus' => $row['AccountStatus'],
                'userType' => $row['UserType'],
                'dateOfBirth' => $row['DateOfBirth']
            );
            
            // Set UserID cookie since we found the user by email
            setcookie('UserID', $row['UserID'], time() + (86400 * 30), "/");
            
            $stmt->close();
        } else {
            // No user found with this email
            error_log("No user found with Email: " . $email);
            header("Location: Login.html");
            exit();
        }
    } catch (Exception $e) {
        error_log("Error fetching user data by email: " . $e->getMessage());
        header("Location: Login.html");
        exit();
    }
} else {
    // No UserID or Email cookie found, redirect to login
    header("Location: Login.html");
    exit();
}

// Close database connection
$conn->close();
