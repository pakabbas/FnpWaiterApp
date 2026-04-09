<?php
// Include database connection file
include 'creds.php'; // Adjust the filename as needed

// Check if 'ID' parameter exists in the URL
if (isset($_GET['ID'])) {
    // Fetch the RestaurantID from the URL
    $restaurantID = intval($_GET['ID']); // Sanitize and convert to integer

    // SQL query to fetch dining tables for the specific restaurant
    $sql = "SELECT *
            FROM dining_tables
            WHERE RestaurantID = ?";

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
            echo '<div class="container" style=" height: 100%; width:100%; margin:0;padding:0"><div class="row">';
            // Fetch and display dining tables
            while ($row = $result->fetch_assoc()) {
                $tableID = $row['TableID'];
                $tableNumber = $row['TableNumber'];
                $capacity = $row['Capacity'];
                $tStatus = $row['Status'];
                $temp = '';
                $temp2 = '';
                $Description = '';
                if ($tStatus == 'Available') {
                    $temp = '';
                    $temp2 = '';
                    $Description = $row['Description'];
                } else {
                    $temp = 'x';
                    $temp2 = 'disabled';  // Changed from 'hidden' to 'disabled' for the select button only
                    $currentTime = new DateTime();
                    $reservedUntil = new DateTime($row['ReservedUntil']);
                    $interval = $currentTime->diff($reservedUntil);
                    if ($reservedUntil > $currentTime) {
                        $totalRemainingSeconds = ($interval->days * 24 * 60 * 60) + ($interval->h * 60 * 60) + ($interval->i * 60) + $interval->s;
                        $Description = '<span style="color:red;" class="countdown" data-timer="' . $totalRemainingSeconds . '">Table Booked <br><strong>' . sprintf('%02d:%02d', floor($totalRemainingSeconds / 60), $totalRemainingSeconds % 60) . '</strong> remaining</span>';
                    } else {
                        $Description = 'Booking expired.';
                    }
                    
                }
                $isLoggedIn = isset($userID) ? 'true' : 'false';
                echo '
                <div class="col-12 col-md-6 mb-4">
                    <div class="d-flex flex-row justify-content-between align-items-stretch border p-0" style="height: 100%;  ">
                        <div style="width: 65%; padding: 15px;">
                            <div class="table-title">Table #' . htmlspecialchars($tableNumber) . ' with ' . htmlspecialchars($capacity) . ' chairs</div>
                            <div class="table-description">' . ($Description) . '</div>
                            <button ' . $temp2 . ' style="color:' . ($tStatus == 'Available' ? 'green' : 'red') . '; background:transparent; border:transparent;" class="btn ' . ($tStatus == 'Available' ? 'btn-success' : 'btn-danger') . ' mt-2" onclick="scrollToCheckout(\'' . htmlspecialchars($tableNumber) . '\', \'' . htmlspecialchars($tableID) . '\', ' . $isLoggedIn . ')">' . ($tStatus == 'Available' ? 'Select' : 'Booked') . '</button>
                        </div>
                        <div style="width: 35%; height: 100%; background: #F9F9F9; display: flex; justify-content: center; align-items: center;  border-radius: 0px 0px 10px 10px; ">
                            <img src="Resources/tables/' . $temp . htmlspecialchars($capacity) . '.png" class="img-fluid" style="border-radius: 0; max-width: 90%; max-height: 150px; cursor:' . ($tStatus == 'Available' ? 'pointer' : 'not-allowed') . ';" alt="Table Icon" ' . ($tStatus == 'Available' ? 'onclick="scrollToCheckout(\'' . htmlspecialchars($tableNumber) . '\', \'' . htmlspecialchars($tableID) . '\', ' . $isLoggedIn . ')"' : '') . '>
                        </div>
                    </div>
                </div>';
            }
            echo '</div></div>';
        } else {
            echo "No dining tables found for this restaurant.";
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

?>


<script>
  function startCountdown() {
      document.querySelectorAll('.countdown').forEach(function(element) {
          let timeLeft = parseInt(element.getAttribute('data-timer'));

          function updateTimer() {
              if (timeLeft > 0) {
                  timeLeft--;
                  let minutes = Math.floor(timeLeft / 60);
                  let seconds = timeLeft % 60;
                  element.innerHTML = `Table Booked <br><strong> ${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')} </strong> remaining`;
              } else {
                  element.textContent = 'Booking expired';
                  clearInterval(interval);
              }
          }        

          updateTimer();
          let interval = setInterval(updateTimer, 1000);
      });
  }

  document.addEventListener("DOMContentLoaded", startCountdown);
</script>
