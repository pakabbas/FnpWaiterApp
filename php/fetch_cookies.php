<?php

// Start session

// Check if cookies are set and fetch their values
$userID = isset($_COOKIE['UserID']) ? $_COOKIE['UserID'] : 'Not set';
$firstName = isset($_COOKIE['FirstName']) ? $_COOKIE['FirstName'] : 'Not set';
$lastName = isset($_COOKIE['LastName']) ? $_COOKIE['LastName'] : 'Not set';
$email = isset($_COOKIE['Email']) ? $_COOKIE['Email'] : 'Not set';
$phoneNumber = isset($_COOKIE['PhoneNumber']) ? $_COOKIE['PhoneNumber'] : '';
$address = isset($_COOKIE['Address']) ? $_COOKIE['Address'] : 'Not set';
$username = isset($_COOKIE['Username']) ? $_COOKIE['Username'] : 'Not set';
$profilePictureURL = isset($_COOKIE['ProfilePictureURL']) ? $_COOKIE['ProfilePictureURL'] : 'Not set';
$preferredCuisine = isset($_COOKIE['PreferredCuisine']) ? $_COOKIE['PreferredCuisine'] : 'Not set';
$allergies = isset($_COOKIE['Allergies']) ? $_COOKIE['Allergies'] : 'Not set';
$dietaryPreferences = isset($_COOKIE['DietaryPreferences']) ? $_COOKIE['DietaryPreferences'] : 'Not set';
$isPaymentVerified = isset($_COOKIE['IsPaymentVerified']) ? $_COOKIE['IsPaymentVerified'] : 'Not set';
$accountStatus = isset($_COOKIE['AccountStatus']) ? $_COOKIE['AccountStatus'] : 'Pending';
$userType = isset($_COOKIE['UserType']) ? $_COOKIE['UserType'] : 'Not set';
$dateOfBirth = isset($_COOKIE['DateOfBirth']) ? $_COOKIE['DateOfBirth'] : 'Not set';
$longitude = isset($_COOKIE['Longitude']) ? $_COOKIE['Longitude'] : 'Not set';
$latitude = isset($_COOKIE['Latitude']) ? $_COOKIE['Latitude'] : 'Not set';
?>

<?php
//echo 'info is here   '.$accountStatus.'/'.$phoneNumber;
if ($accountStatus === "Pending" && $userID !== "Not set") {
   header("Location: TNC.php");
   exit;
}
?>

<?php
if (($phoneNumber === null || $phoneNumber === '' )&& $userID !== "Not set") {
    header("Location: ValidatePhone.php");
    exit;
}
?>
