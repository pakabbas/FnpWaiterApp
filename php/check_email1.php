<?php
include 'creds.php'; // Include your DB credentials

if (isset($_POST['email'])) {
    $email = $conn->real_escape_string($_POST['email']); // Sanitize input

    // Query to check if the email exists
    $sql = "SELECT 1 FROM AppUsers WHERE Email = '$email' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo json_encode(['exists' => true]); // Email exists
    } else {
        echo json_encode(['exists' => false]); // Email does not exist
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}

$conn->close();
?>
