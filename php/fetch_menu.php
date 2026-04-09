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
                <div class="col-12 col-md-6 mb-4" style="padding:0px;">
                    <div class="d-flex flex-row justify-content-between align-items-stretch border p-0" style="height: 100%; border-radius: 20px; overflow: hidden;">
                        <div style="width: 60%; padding: 15px;">
                            <div class="table-title">' . htmlspecialchars($Name) . '</div>
                            <div class="table-description">' . htmlspecialchars($Description) . '</div>
                            <div class="table-title">$ ' . htmlspecialchars($Price) . '</div>
                            <button style="color:green; background:transparent; border:transparent;" class="btn btn-success mt-2" data-toggle="modal" data-target="#menumodal" onclick="openMenuModal(\'' . htmlspecialchars($ItemID) . '\', \'' . addslashes(htmlspecialchars($Name)) . '\', \'' . addslashes(htmlspecialchars($DisplayPicture)) . '\', \'' . addslashes(htmlspecialchars($Description)) . '\', \'' . htmlspecialchars($Price) . '\', \'' . htmlspecialchars($restaurantID) . '\')">View Details</button>

                        </div>
                        <div style="width: 40%; height: 100%; background: transparent; display: flex; justify-content: center; align-items: center; overflow: hidden; border-top-right-radius: 20px; border-bottom-right-radius: 20px;">
                            <img src="images/' . htmlspecialchars($DisplayPicture) . '" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover; object-position: center; border-top-right-radius: 20px; border-bottom-right-radius: 20px;" alt="Menu Item Icon">
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