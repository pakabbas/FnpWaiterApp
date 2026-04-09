<?php
include 'creds.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Basic restaurant details
    $name = $_POST['Name'];
    $email = $_POST['Email'];
    $phoneNumber = $_POST['PhoneNumber'];
    $address = $_POST['Address'] ?? '';
    $planName = $_POST['PlanName'];
    $registrationDate = date('Y-m-d');
    $location = $_POST['Location'] ?? '';
    $latitude = isset($_POST['Latitude']) ? (float)$_POST['Latitude'] : 0.0;
    $longitude = isset($_POST['Longitude']) ? (float)$_POST['Longitude'] : 0.0;
    $planId = isset($_POST['PlanID']) ? (int)$_POST['PlanID'] : 0;

    // Staff (owner) details
    $firstName = $_POST['FirstName'];
    $lastName = $_POST['LastName'];
    $password = $_POST['Password']; // Securely hash password
    $userType = 'Admin';
    $designation = 'Owner';
    $accountStatus = 'Active';

    // Insert into restaurants table
    $sql = "INSERT INTO restaurants (Name, Email, PhoneNumber, Address, PlanName, RegistrationDate, Location, Latitude, Longitude) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssssssdd', $name, $email, $phoneNumber, $address, $planName, $registrationDate, $location, $latitude, $longitude);

    if ($stmt->execute()) {
        // Get the last inserted RestaurantID
        $restaurantID = $stmt->insert_id;

        // Insert into staff table
        $staffSQL = "INSERT INTO staff (RestaurantID, FirstName, LastName, UserType, Designation, Email, PhoneNumber, Password, AccountStatus) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $staffStmt = $conn->prepare($staffSQL);
        $staffStmt->bind_param('issssssss', $restaurantID, $firstName, $lastName, $userType, $designation, $email, $phoneNumber, $password, $accountStatus);

        if ($staffStmt->execute()) {
            $redirectPlanId = $planId > 0 ? $planId : 3; // fallback to Enterprise - Monthly if missing
            header("Location: Payment.php?RestaurantID={$restaurantID}&PlanID={$redirectPlanId}");
            exit;
        } else {
            echo "Error inserting staff: " . $staffStmt->error;
        }

        $staffStmt->close();
    } else {
        echo "Error inserting restaurant: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
