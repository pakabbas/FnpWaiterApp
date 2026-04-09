<?php
/**
 * Timezone utility functions for handling date/time conversion
 */

/**
 * Get restaurant timezone with fallback to default
 */
function getRestaurantTimezone($conn, $restaurant_id, $default_timezone = 'America/Detroit') {
    $stmt = $conn->prepare("SELECT Timezone FROM restaurants WHERE RestaurantID = ?");
    $stmt->bind_param("i", $restaurant_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $timezone = $row['Timezone'];
        // If timezone is null or empty, use default
        if (empty($timezone)) {
            return $default_timezone;
        }
        return $timezone;
    }
    
    $stmt->close();
    return $default_timezone;
}

/**
 * Convert UTC datetime to restaurant timezone
 */
function convertToRestaurantTimezone($utc_datetime, $restaurant_timezone) {
    if (empty($utc_datetime)) {
        return null;
    }
    
    try {
        // Create UTC datetime object
        $utc = new DateTime($utc_datetime, new DateTimeZone('UTC'));
        
        // Convert to restaurant timezone
        $utc->setTimezone(new DateTimeZone($restaurant_timezone));
        
        return $utc->format('Y-m-d H:i:s');
    } catch (Exception $e) {
        // If conversion fails, return original datetime
        error_log("Timezone conversion error: " . $e->getMessage());
        return $utc_datetime;
    }
}

/**
 * Convert restaurant timezone datetime to UTC
 */
function convertToUTC($restaurant_datetime, $restaurant_timezone) {
    if (empty($restaurant_datetime)) {
        return null;
    }
    
    try {
        // Create datetime object in restaurant timezone
        $restaurant_dt = new DateTime($restaurant_datetime, new DateTimeZone($restaurant_timezone));
        
        // Convert to UTC
        $restaurant_dt->setTimezone(new DateTimeZone('UTC'));
        
        return $restaurant_dt->format('Y-m-d H:i:s');
    } catch (Exception $e) {
        // If conversion fails, return original datetime
        error_log("Timezone conversion error: " . $e->getMessage());
        return $restaurant_datetime;
    }
}

/**
 * Format datetime for display in restaurant timezone
 */
function formatDateTimeForDisplay($utc_datetime, $restaurant_timezone, $format = 'Y-m-d H:i:s') {
    if (empty($utc_datetime)) {
        return '';
    }
    
    try {
        // Create UTC datetime object
        $utc = new DateTime($utc_datetime, new DateTimeZone('UTC'));
        
        // Convert to restaurant timezone
        $utc->setTimezone(new DateTimeZone($restaurant_timezone));
        
        return $utc->format($format);
    } catch (Exception $e) {
        error_log("DateTime formatting error: " . $e->getMessage());
        return $utc_datetime;
    }
}

/**
 * Get current time in restaurant timezone
 */
function getCurrentRestaurantTime($restaurant_timezone) {
    try {
        $now = new DateTime('now', new DateTimeZone($restaurant_timezone));
        return $now->format('Y-m-d H:i:s');
    } catch (Exception $e) {
        error_log("Current time error: " . $e->getMessage());
        return date('Y-m-d H:i:s'); // Fallback to server time
    }
}

/**
 * Get today's date in restaurant timezone
 */
function getTodayInRestaurantTimezone($restaurant_timezone) {
    try {
        $today = new DateTime('now', new DateTimeZone($restaurant_timezone));
        return $today->format('Y-m-d');
    } catch (Exception $e) {
        error_log("Today date error: " . $e->getMessage());
        return date('Y-m-d'); // Fallback to server date
    }
}

/**
 * Validate timezone string
 */
function isValidTimezone($timezone) {
    try {
        new DateTimeZone($timezone);
        return true;
    } catch (Exception $e) {
        return false;
    }
}

/**
 * Get list of common US timezones
 */
function getCommonUSTimezones() {
    return [
        'America/New_York' => 'Eastern Time (ET)',
        'America/Chicago' => 'Central Time (CT)', 
        'America/Denver' => 'Mountain Time (MT)',
        'America/Los_Angeles' => 'Pacific Time (PT)',
        'America/Detroit' => 'Detroit Time (ET)',
        'America/Phoenix' => 'Arizona Time (MST)',
        'America/Anchorage' => 'Alaska Time (AKST)',
        'Pacific/Honolulu' => 'Hawaii Time (HST)'
    ];
}
?>
