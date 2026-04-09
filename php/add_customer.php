<?php
include 'creds.php'; // Include your database credentials

// Function to return JSON response
function returnJsonResponse($success, $message, $redirect = null) {
    $response = [
        'success' => $success,
        'message' => $message
    ];
    if ($redirect) {
        $response['redirect'] = $redirect;
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate that all required fields are present
    $required_fields = ['FirstName', 'LastName', 'Email'];
    foreach ($required_fields as $field) {
        if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
            returnJsonResponse(false, "Missing required field: " . htmlspecialchars($field), "SignUp3.php");
        }
    }
    
    // Sanitize and retrieve form data
    $firstName = $conn->real_escape_string(trim($_POST['FirstName']));
    $lastName = $conn->real_escape_string(trim($_POST['LastName']));
    $email = filter_var(trim($_POST['Email']), FILTER_SANITIZE_EMAIL);
    $phoneNumber = $conn->real_escape_string(trim($_POST['PhoneNumber']));
    $dateOfBirth = $conn->real_escape_string(trim($_POST['DateOfBirth']));
    
    // Set default values for unused fields
    $address = '';
    $username = $email; // Use email as username
    $preferredCuisine = '';
    $location = '';
    $longitude = null;
    $latitude = null;
    
    // Handle password - use form password if provided (SignUp2), generate random if not (SignUp3)
    if (isset($_POST['Password']) && !empty(trim($_POST['Password']))) {
        // Use the password from the form (SignUp2.php case)
        $password = password_hash(trim($_POST['Password']), PASSWORD_DEFAULT);
    } else {
        // Generate random password (SignUp3.php case)
        $passwordRaw = bin2hex(random_bytes(8));
        $password = password_hash($passwordRaw, PASSWORD_DEFAULT);
    }
  

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        returnJsonResponse(false, "Invalid email format.", "SignUp3.php");
    }

    // Validate name fields (letters, spaces, hyphens, apostrophes only)
    if (!preg_match('/^[a-zA-Z\s\-\']{1,50}$/', $firstName) || !preg_match('/^[a-zA-Z\s\-\']{1,50}$/', $lastName)) {
        returnJsonResponse(false, "Names must contain only letters, spaces, hyphens, and apostrophes.", "SignUp3.php");
    }

    // Check if username or email already exists
    $checkSql = "SELECT UserID FROM AppUsers WHERE Username = ? OR Email = ?";
    $checkStmt = $conn->prepare($checkSql);
    if ($checkStmt === false) {
        error_log("Error preparing check statement: " . $conn->error);
        returnJsonResponse(false, "An error occurred during registration. Please try again later.", "SignUp3.php");
    }
    
    $checkStmt->bind_param("ss", $username, $email);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    
    if ($checkResult->num_rows > 0) {
        $checkStmt->close();
        returnJsonResponse(false, "This email address is already registered. Please use a different email or login to your existing account.", "SignUp3.php");
    }
    $checkStmt->close();

    // Password is already hashed above

    // Prepare SQL statement with placeholders
    $sql = "INSERT INTO AppUsers (
                FirstName, LastName, Email, PhoneNumber, Address, Username, Password,
                RegistrationDate, Location, PreferredCuisine, DateOfBirth, Longitude, Latitude, AccountStatus
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        error_log("Error preparing the SQL statement: " . $conn->error);
        returnJsonResponse(false, "An error occurred during registration. Please try again later.", "SignUp3.php");
    }

    // Bind parameters to the prepared statement
    $registrationDate = date("Y-m-d H:i:s");
    $accountStatus = 'Active'; // Default account status

    $stmt->bind_param(
        "ssssssssssssss",
        $firstName, $lastName, $email, $phoneNumber, $address, $username, $password,
        $registrationDate, $location, $preferredCuisine, $dateOfBirth, $longitude, $latitude, $accountStatus
    );

    // Execute the statement
    if ($stmt->execute()) {
        // Return success response
        returnJsonResponse(true, "Registration successful!", "Login.html");
    } else {
        // In case of error, log it and show a general error message
        error_log("Error executing query: " . $stmt->error);
        returnJsonResponse(false, "An error occurred during registration. Please try again later.", "SignUp3.php");
    }

    // Close the prepared statement
    $stmt->close();
}

$conn->close();
?>