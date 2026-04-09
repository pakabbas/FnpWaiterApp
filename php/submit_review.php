<?php
// Include your database connection
include 'creds.php';

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Retrieve posted form data
    $ReservationID = mysqli_real_escape_string($conn, $_POST['ReservationID']);
    $CustomerID = mysqli_real_escape_string($conn, $_POST['CustomerID']);
    $RestaurantID = mysqli_real_escape_string($conn, $_POST['RestaurantID']);
    $Ratings = mysqli_real_escape_string($conn, $_POST['Ratings']);
    $Details = mysqli_real_escape_string($conn, $_POST['Details']); // Or use other validation/sanitization methods

    // Check if the ReservationID already exists in the Reviews table
    $checkSql = "SELECT * FROM Reviews WHERE ReservationID = ?";
    $stmt = $conn->prepare($checkSql);
    $stmt->bind_param("i", $ReservationID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // ReservationID already exists, return error message
        echo json_encode(['success' => false, 'message' => 'You have already submitted a review for this booking.']);
    } else {
        // ReservationID does not exist, proceed with insertion
        $sql = "INSERT INTO Reviews (ReservationID, CustomerID, RestaurantID, ReviewDate, Ratings, Details)
                VALUES (?, ?, ?, NOW(), ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiiss", $ReservationID, $CustomerID, $RestaurantID, $Ratings, $Details);

        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => $conn->error]);
        }
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
