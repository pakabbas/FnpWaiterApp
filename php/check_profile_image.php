<?php
function getProfileImageHtml($profilePictureURL) {
    $imagePath = "AppUsers/uploads/" . $profilePictureURL;
    
    // Check if the profile picture exists and is not empty
    if (!empty($profilePictureURL) && file_exists($imagePath)) {
        return '<img src="' . $imagePath . '" alt="Profile" style="width: 36px; height: 36px; border-radius: 50%; object-fit: cover;">';
    } else {
        // Return a user icon as fallback
        return '<i class="fas fa-user-circle" style="font-size: 36px; color: #4cbb17;"></i>';
    }
}
?>
