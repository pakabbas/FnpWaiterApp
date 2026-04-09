<?php
// Include database connection file
include 'creds.php'; // Adjust the filename as needed

// Check if 'ID' parameter exists in the URL
if (isset($_GET['ID'])) {
    // Fetch the RestaurantID from the URL
    $restaurantID = intval($_GET['ID']); // Sanitize and convert to integer

    // SQL query to fetch menu items for the specific restaurant
    $sql = "SELECT *
            FROM menu_items
            WHERE RestaurantID = ? AND Availability = 'Yes' and Type != 'Side'";

    // Prepare and execute the SQL statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the RestaurantID parameter to the query
        $stmt->bind_param("i", $restaurantID);

        // Execute the statement
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Check if any rows were returned
        if ($result->num_rows > 0) {
            echo '<div class="container" style="height: 100%; width: 100%; margin: 0; padding: 0;"><div style="margin:0px;" class="row">';
            // Fetch and display menu items
            while ($row = $result->fetch_assoc()) {
                $ItemID = $row['ItemID'];
                $restaurantID = $row['RestaurantID'];
                $Name = $row['Name'];
                $Price = $row['Price'];
                $Category = $row['Category'];
                $DisplayPicture = $row['DisplayPicture'];
                $Description = $row['Description'];
                // <div class="table-description">' . htmlspecialchars($Description) . '</div>
                // <button style="color:green; background:transparent; border:transparent;" class="btn btn-success mt-2" onclick="addToCart(' . htmlspecialchars($ItemID) . ',' . htmlspecialchars($restaurantID) . ')">Add</button>

                echo '
                <div class="col-6 mb-3">
                    <div class="d-flex flex-column border p-0" style="height: 100%; border-radius: 12px; overflow: hidden; cursor: pointer;" onclick="openMenuModal(\'' . htmlspecialchars($ItemID) . '\', \'' . addslashes(htmlspecialchars($Name)) . '\', \'' . addslashes(htmlspecialchars($DisplayPicture)) . '\', \'' . addslashes(htmlspecialchars($Description)) . '\', \'' . htmlspecialchars($Price) . '\', \'' . htmlspecialchars($restaurantID) . '\')">
                        <div style="width: 100%; height: 120px; overflow: hidden;">
                            <img src="images/' . htmlspecialchars($DisplayPicture) . '" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover; object-position: center;" alt="Menu Item Icon">
                        </div>
                        <div style="width: 100%; padding: 12px; background:rgb(240, 240, 240);">
                            <div class="table-title" style="font-size: 14px; font-weight: 600; color: #333; margin-bottom: 6px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . htmlspecialchars($Name) . '</div>
                            <div class="table-description" style="font-size: 12px; color: #666; margin-bottom: 8px;">$ ' . htmlspecialchars($Price) . '</div>
                            <button style="color: #4cbb17; background:transparent; border:transparent; font-size: 12px;" class="btn btn-success mt-1" data-toggle="modal" data-target="#menumodal" onclick="event.stopPropagation(); openMenuModal(\'' . htmlspecialchars($ItemID) . '\', \'' . addslashes(htmlspecialchars($Name)) . '\', \'' . addslashes(htmlspecialchars($DisplayPicture)) . '\', \'' . addslashes(htmlspecialchars($Description)) . '\', \'' . htmlspecialchars($Price) . '\', \'' . htmlspecialchars($restaurantID) . '\')">View Details</button>
                        </div>
                    </div>
                </div>';
            }
            echo '</div></div>';
        } else {
            echo "No menu items found for this restaurant.";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing the SQL statement.";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "No restaurant ID provided in the URL.";
}