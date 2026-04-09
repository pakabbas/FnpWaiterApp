<?php
include 'creds.php'; // Include your database connection

if (isset($_GET['ID'])) {
    $restaurantID = intval($_GET['ID']); // Sanitize input

    // Query to fetch sides
    $sql = "SELECT ItemID, Name, Price FROM menu_items WHERE RestaurantID = ? AND Type = 'Side' AND Availability = 'Yes'";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $restaurantID);
        $stmt->execute();
        $result = $stmt->get_result();
        // echo $result->num_rows . '...';
        if ($result->num_rows > 0) {
            // Output checkboxes for each side item
            while ($row = $result->fetch_assoc()) {

                $ItemID = htmlspecialchars($row['ItemID']);
                $Name = htmlspecialchars($row['Name']);
                $Price = htmlspecialchars($row['Price']);
                echo '
                <div class="form-check mb-3" style="display: flex; align-items: center; padding: 8px 8px 8px 12px; border-radius: 8px; background-color: #f8f9fa; border: 1px solid #eee; transition: all 0.2s ease; position: relative;" onmouseover="this.style.backgroundColor=\'#e8f5e9\'; this.style.borderColor=\'#c8e6c9\';" onmouseout="this.style.backgroundColor=\'#f8f9fa\'; this.style.borderColor=\'#eee\';">
                    <input class="form-check-input" type="checkbox" value="' . $ItemID . '" id="side' . $ItemID . '" style="margin: 0 12px 0 0; position: relative; min-width: 18px; height: 18px; cursor: pointer;">
                    <label class="form-check-label d-flex justify-content-between align-items-center w-100" for="side' . $ItemID . '" style="margin-bottom: 0; cursor: pointer;">
                        <span style="font-size: 14px; font-weight: 500; color: #333;">' . $Name . '</span>
                        <span style="font-size: 14px; font-weight: 600; color: #4CBB17;">$' . $Price . '</span>
                    </label>
                </div>';
            }
        } else {
            echo '<p>No sides available.</p>';
        }
        $stmt->close();
    } else {
        echo "Error in the query.";
    }
    $conn->close();
}
