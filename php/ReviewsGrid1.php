<?php
// Include the database connection file
include 'creds.php';

// Check if the variable $restaurantID is passed from the main file
if (!isset($restaurantID) || empty($restaurantID)) {
  echo "<p>No restaurant selected.</p>";
  exit();
}

$reviewsForJs = [];

// Fetch reviews for the selected restaurant
$query = "
      SELECT r.Details, r.Ratings, r.ReviewDate, u.FirstName, u.LastName, u.ProfilePictureURL
      FROM Reviews r
      INNER JOIN AppUsers u ON r.CustomerID = u.UserID
      WHERE r.RestaurantID = ?
      ORDER BY r.ReviewDate DESC
  ";

if ($stmt = $conn->prepare($query)) {
  $stmt->bind_param("i", $restaurantID);
  $stmt->execute();
  $result = $stmt->get_result();

  // Check if there are reviews
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reviewsForJs[] = ['rating' => (int)$row['Ratings']];
        // Check if the profile picture exists, otherwise use a default image
        $profileImage = "Resources/dp/" . $row['ProfilePictureURL'];
        if (!file_exists($profileImage)) {
            $profileImage = "Resources/dp/profile1.png"; // Default image
        }
?>
      <!-- Wrap each review card in a Bootstrap column -->
      <div class="col-md-12 col-sm-12 mb-4"> <!-- 6 columns (half-width) on medium and above, full-width on small screens -->
        <div class="review-card" style="background:white; border-radius: 12px; box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1); padding: 16px;">
          <div style="display: flex; align-items: center;">
            <img src="<?php echo htmlspecialchars($profileImage); ?>" alt="Profile Picture" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
            <div style="margin-left: 16px;">
              <h4 style="margin: 0;"><?php echo htmlspecialchars($row['FirstName'] . ' ' . $row['LastName']); ?></h4>
              <div style="display: flex; align-items: center;">
                <span style="color: #FFD700;"><?php echo str_repeat('★', $row['Ratings']); ?></span>
                <span style="margin-left: 8px; color: #888;"><?php echo date('F j, Y', strtotime($row['ReviewDate'])); ?></span>
              </div>
            </div>
          </div>
          <p style="margin-top: 12px;"><?php echo htmlspecialchars($row['Details']); ?></p>
        </div>
      </div>
<?php
    }
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const reviewsData = <?php echo json_encode($reviewsForJs); ?>;
    if (reviewsData.length > 0) {
        const reviewCount = reviewsData.length;
        const totalRating = reviewsData.reduce((sum, review) => sum + review.rating, 0);
        const averageRating = (totalRating / reviewCount).toFixed(1);

        // Update review text
        const ratingTextEl = document.getElementById('rating-text-container');
        if (ratingTextEl) {
            ratingTextEl.innerHTML = `&nbsp;${averageRating} (${reviewCount} Reviews)`;
        }

        // Update stars
        const starsContainerEl = document.getElementById('stars-container');
        if (starsContainerEl) {
            let starsHtml = '';
            const rating = parseFloat(averageRating);
            for (let i = 1; i <= 5; i++) {
                if (i <= rating) {
                    starsHtml += '<i class="fas fa-star" style="color: #FFD700;"></i>';
                } else if (i - 0.5 <= rating) {
                    starsHtml += '<i class="fas fa-star-half-alt" style="color: #FFD700;"></i>';
                } else {
                    starsHtml += '<i class="far fa-star" style="color: #FFD700;"></i>';
                }
            }
            starsContainerEl.innerHTML = starsHtml;
        }
    }
});
</script>
<?php
  } else {
    echo "<p>No reviews found for this restaurant.</p>";
  }
  $stmt->close();
} else {
  echo "<p>Error retrieving reviews. Please try again later.</p>";
}

$conn->close();
?>
