<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database connection
include 'creds.php';

// Check if SpecialInstructions column exists
$checkColumnSql = "SHOW COLUMNS FROM `reservations` LIKE 'SpecialInstructions'";
$result = $conn->query($checkColumnSql);

if ($result->num_rows == 0) {
    // Column doesn't exist, add it
    $alterTableSql = "ALTER TABLE `reservations` ADD COLUMN `SpecialInstructions` TEXT NULL AFTER `ExtendedTime`";
    
    if ($conn->query($alterTableSql) === TRUE) {
        echo "SpecialInstructions column added to reservations table successfully.";
    } else {
        echo "Error adding column: " . $conn->error;
    }
} else {
    echo "SpecialInstructions column already exists in reservations table.";
}

$conn->close();
?> 