<?php
require_once 'google-config.php';
include 'creds.php'; // For database connection

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    if (!isset($token['error'])) {
        $client->setAccessToken($token['access_token']);
        
        // Get user profile information
        $google_oauth = new Google\Service\Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        
        $email = $google_account_info->email;
        $name = $google_account_info->name;
        $picture = $google_account_info->picture;

        // Split full name into first and last name
        $nameParts = explode(' ', $name, 2);
        $firstName = $nameParts[0];
        $lastName = isset($nameParts[1]) ? $nameParts[1] : '';

        // Check if the user already exists in the database
        $query = "SELECT * FROM AppUsers WHERE Email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User exists, set cookies and redirect to Home.php
            $user = $result->fetch_assoc();

            setcookie("UserID", $user['UserID'], time() + (86400 * 30), "/");
            setcookie("FirstName", $user['FirstName'], time() + (86400 * 30), "/");
            setcookie("LastName", $user['LastName'], time() + (86400 * 30), "/");
            setcookie("Email", $user['Email'], time() + (86400 * 30), "/");
            setcookie("PhoneNumber", $user['PhoneNumber'], time() + (86400 * 30), "/");
            setcookie("Address", $user['Address'], time() + (86400 * 30), "/");
            setcookie("Username", $user['Username'], time() + (86400 * 30), "/");
            setcookie("ProfilePictureURL", $user['ProfilePictureURL'], time() + (86400 * 30), "/");
            setcookie("PreferredCuisine", $user['PreferredCuisine'], time() + (86400 * 30), "/");
            setcookie("Allergies", $user['Allergies'], time() + (86400 * 30), "/");
            setcookie("DietaryPreferences", $user['DietaryPreferences'], time() + (86400 * 30), "/");
            setcookie("IsPaymentVerified", $user['IsPaymentVerified'], time() + (86400 * 30), "/");
            setcookie("AccountStatus", $user['AccountStatus'], time() + (86400 * 30), "/");
            setcookie("UserType", $user['UserType'], time() + (86400 * 30), "/");
            setcookie("DateOfBirth", $user['DateOfBirth'], time() + (86400 * 30), "/");
            setcookie("Longitude", $user['Longitude'], time() + (86400 * 30), "/");
            setcookie("Latitude", $user['Latitude'], time() + (86400 * 30), "/");

            // Redirect to Home.php
            header('Location: Home.php');
            exit();
        } else {
            // User does not exist, save basic info in session/cookies and redirect to SignUp3.php
            $_SESSION['email'] = $email;
            setcookie("UserID", $email, time() + (86400 * 30), "/");
            setcookie("Email", $email, time() + (86400 * 30), "/");
            $_SESSION['name'] = $name;
            setcookie("FirstName", $firstName, time() + (86400 * 30), "/");
            $_SESSION['picture'] = $picture;

            // Redirect to SignUp3.php
            header('Location: SignUp3.php');
            exit();
        }
    }
}

// Handle error or invalid token case
header('Location: index.php');
exit();
