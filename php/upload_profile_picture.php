<?php
include 'creds.php';
$userId = isset($_COOKIE['UserID']) ? $_COOKIE['UserID'] : 'Not set';

$uploadDir = 'AppUsers/uploads/';

if (!isset($_FILES['profilePicture'])) {
    echo json_encode(['status' => 'error', 'message' => 'No file uploaded']);
    exit;
}

$file = $_FILES['profilePicture'];
$allowed = ['jpg', 'jpeg', 'png', 'gif'];
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

if (!in_array($ext, $allowed)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid file type']);
    exit;
}

$filename = uniqid('profile_', true) . '.' . $ext;
$filepath = $uploadDir . $filename;

if (!move_uploaded_file($file['tmp_name'], $filepath)) {
    echo json_encode(['status' => 'error', 'message' => 'Failed to move file']);
    exit;
}


$stmt = $conn->prepare("UPDATE AppUsers SET ProfilePictureURL = ? WHERE UserId = ?");
$stmt->bind_param("si", $filename, $userId);
$stmt->execute();
$stmt->close();
$conn->close();
setcookie("ProfilePictureURL", $filename, time() + (86400 * 30), "/");
echo json_encode(['status' => 'success', 'filename' => $filename]);
exit;
?>
