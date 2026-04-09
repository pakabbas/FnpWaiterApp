<?php
include 'creds.php'; // Include your DB credentials

if (isset($_POST['query'])) {
  $query = $_POST['query'];
  $currentTime = date("H:i:s");

  // Fetch restaurants based on the search query
  $sql = "SELECT RestaurantID, Name FROM restaurants WHERE Name LIKE ? AND ? BETWEEN OpeningHours AND ClosingHours";
  $stmt = $conn->prepare($sql);
  $search = "%$query%";
  $stmt->bind_param("ss", $search, $currentTime);
  $stmt->execute();
  $result = $stmt->get_result();

  $restaurants = [];

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $restaurants[] = $row;
    }
  }

  // Return the list as a JSON response
  echo json_encode($restaurants);
}

$conn->close();
