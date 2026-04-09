<?php
// Include the database connection file
include 'creds.php';

$customerID = isset($_COOKIE['UserID']) ? $_COOKIE['UserID'] : null;
if (!isset($customerID) || empty($customerID)) {
  // Use JavaScript to redirect since header() can't be used after content is sent
  echo "<script type='text/javascript'>window.location.href = 'Login.html';</script>";
  exit();
}
if ($customerID) {
  // Fetch reviews along with user details
  $query = "
        SELECT r.Details, r.Ratings, r.ReviewDate, rest.Name AS RestaurantName, rest.RestaurantID, u.FirstName, u.LastName, u.ProfilePictureURL
        FROM Reviews r
        INNER JOIN restaurants rest ON r.RestaurantID = rest.RestaurantID
        INNER JOIN AppUsers u ON r.CustomerID = u.UserID
        WHERE r.CustomerID = ?
        ORDER BY r.ReviewDate DESC
    ";

  // Prepare and execute the query
  if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $customerID);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are reviews
    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
?>
        <!-- Wrap each review card in a Bootstrap column -->
        <div class="col-md-5 col-sm-12 mb-4"> <!-- 6 columns (half-width) on medium and above, full-width on small screens -->
          <div class="review-card" style="background:white; border-radius: 12px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1); padding: 16px;">
            <div style="display: flex; align-items: center;">
              <?php 
              $profilePath = 'AppUsers/uploads/' . $row['ProfilePictureURL'];
              if (!empty($row['ProfilePictureURL']) && file_exists($profilePath)) {
                  echo '<img src="' . $profilePath . '" alt="Profile Picture" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">';
              } else {
                  echo '<i class="fas fa-user" style="font-size: 50px; color: #4cbb17;"></i>';
              }
              ?>
              <div style="margin-left: 16px;">
                <h4 style="margin: 0;"><?php echo htmlspecialchars($row['FirstName'] . ' ' . $row['LastName']); ?></h4>
                <div style="display: flex; align-items: center;">
                  <span style="color: #FFD700;"><?php echo str_repeat('★', $row['Ratings']); ?></span>
                  <span style="margin-left: 8px; color: #888;"><?php echo date('F j, Y', strtotime($row['ReviewDate'])); ?></span>
                </div>
              </div>
            </div>
            <p style="margin-top: 12px;"><?php echo htmlspecialchars($row['Details']); ?></p>
            <div style="display: flex; align-items: center; margin-top: 12px; color: #2ECC71; justify-content:left;">
              <i class="fas fa-utensils" style="margin-right: 8px;"></i>
              <!-- Make restaurant name clickable -->
              <a href="Profile.php?ID=<?php echo $row['RestaurantID']; ?>" style="color: #2ECC71; text-decoration: none;">
                <?php echo htmlspecialchars($row['RestaurantName']); ?>
              </a>
            </div>
          </div>
        </div>
<?php
      }
    } else {
      echo "<p>You haven't submitted any reviews yet.</p>";
    }
    $stmt->close();
  } else {
    echo "<p>Error retrieving reviews. Please try again later.</p>";
  }
} else {
  echo "<p>You must be logged in to view your reviews.</p>";
}

$conn->close();
?>