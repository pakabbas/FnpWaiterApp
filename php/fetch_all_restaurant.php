<?php
include 'creds.php'; // Include your DB credentials

// Get current timer
$currentTime = date("H:i:s");

// Initialize the base SQL query
$sql = "
    SELECT 
        r.*, 
        ROUND(COALESCE(AVG(rev.Ratings), 5), 1) AS CalculatedAverageRating 
    FROM 
        restaurants r
    LEFT JOIN 
        Reviews rev ON r.RestaurantID = rev.RestaurantID
";

// Check if the search parameter is provided
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $conn->real_escape_string($_GET['search']);
    $sql .= " WHERE r.Name LIKE '%$search%' OR r.CuisineType LIKE '%$search%' OR r.FoodType LIKE '%$search%'";
}

$sql .= " GROUP BY r.RestaurantID";

// Execute the query
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Loop through each restaurant and display it
    while ($row = $result->fetch_assoc()) {
        // Variables
        $restaurantName = $row['Name'];
        $cuisineType = $row['CuisineType'];
        $rating = $row['CalculatedAverageRating'];

        $filename = (!empty($row['Thumbnail']) && file_exists("Resources/icons/" . $row['Thumbnail'])) ? $row['Thumbnail'] : 'R1.png';
        $filepath = "Resources/icons/" . $filename;
        $image = file_exists($filepath) ? $filepath : "Resources/R1.png"; // Assuming this is a URL or path
        $iconFilename = (!empty($row['RestaurantIcon']) && file_exists("Resources/icons/" . $row['RestaurantIcon'])) ? $row['RestaurantIcon'] : 'r2.png';
        $iconFilepath = "Resources/icons/" . $iconFilename;
        $iconImage = file_exists($iconFilepath) ? $iconFilepath : "Resources/r2.png"; // Default to "r2.png" if not found


        
        $location = $row['Location'];
        $openingTime = $row['OpeningHours'];
        $closingTime = $row['ClosingHours'];

        // Check if restaurant is open or closed
        $isClosed = ($currentTime < $openingTime || $currentTime > $closingTime);
        $closedText = $isClosed ? "<div class='closed-overlay'>Closed until $openingTime</div>" : "";

        // Display each restaurant with responsive grid
        echo '
     <div class="col-12 col-sm-6 col-lg-3 mb-4" style="padding-right:20px; position:relative;">

            <a href="Profile.php?ID=' . $row['RestaurantID'] . '" class="text-decoration-none ' . ($isClosed ? 'disabled-link' : '') . '">
                <div class="card shadow-sm h-100" style="' . ($isClosed ? 'opacity: 0.6;' : '') . '">
                    <div class="position-relative">
                        <img style="height:200px;width:100%;" src="' . $image . '" class="card-img-top" alt="Restaurant Image">
                        ' . (!$isClosed ? '<span style="position: absolute; top: 10px; left: 10px; padding: 5px 10px; border-radius: 5px; background-color: #4CBB17; color: white; font-size: 12px; font-weight: 500;">Open Now</span>' : '') . '
                        <span style="position: absolute; top: 10px; right: 10px; padding: 5px; border-radius: 10px; background-color: #FFB30E; color: white; white-space: nowrap;">
                            ' . $rating . ' <img src="Resources/star.png" alt="Star Icon" style="width: 16px; background: golden;">
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                        <img src="' . $iconImage . '" alt="Restaurant Icon" style="width: 48px;">

                            <h5 class="card-title mb-0 mx-auto">' . $restaurantName . '</h5>
                        </div>
                        <p class="card-text text-center">';
                            
        $cuisineArray = explode(',', $cuisineType);
        foreach($cuisineArray as $cuisine) {
            echo '<span class="cuisine-tag">' . trim($cuisine) . '</span> ';
        }
        
        echo '</p>
                        <p class="card-text text-center">
                            <i class="fa fa-map-marker" style="color: #4CBB17; font-size: 18px; margin-right: 5px;"></i> '. $location . '
                        </p>
                    </div>
                </div>
            </a>
            ' . $closedText . '
        </div>';
    }
} else {
    echo "<div class='alert alert-warning'>No restaurants found.</div>";
}

$conn->close();
?>

<style>
    .closed-overlay {
        position: absolute;
        top: 40%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: rgba(0, 0, 0, 0.75);
        color: white;
        padding: 10px 10px;
        border-radius: 5px;
        font-size: 14px;
        font-weight: bold;
        z-index: 10;
    }

    .disabled-link {
        pointer-events: none;
    }
    
    .cuisine-tag {
        display: inline-block;
        background-color: #4CBB17;
        color: white;
        padding: 3px 8px;
        margin: 2px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: 500;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
</style>
