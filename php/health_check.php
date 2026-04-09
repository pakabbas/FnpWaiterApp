<?php
// Simple runtime diagnostics for VPS issues
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_errors.log');
error_reporting(E_ALL);

header('Content-Type: application/json');

$status = [
    'php' => [
        'version' => PHP_VERSION,
        'sapi' => PHP_SAPI,
    ],
    'extensions' => [],
    'composer' => [
        'vendor_autoload' => file_exists(__DIR__ . '/vendor/autoload.php'),
    ],
    'session' => [],
    'database' => [
        'connected' => false,
        'error' => null,
    ],
];

// Check required extensions
$requiredExtensions = ['curl', 'json', 'mbstring', 'openssl', 'mysqli'];
foreach ($requiredExtensions as $ext) {
    $status['extensions'][$ext] = extension_loaded($ext);
}

// Session check
$sessionPath = ini_get('session.save_path');
$status['session']['save_path'] = $sessionPath;
$status['session']['save_path_exists'] = $sessionPath ? is_dir($sessionPath) : null;
$status['session']['save_path_writable'] = $sessionPath ? is_writable($sessionPath) : null;
if (session_status() !== PHP_SESSION_ACTIVE) {
    @session_start();
}
$status['session']['status'] = session_status();
$_SESSION['health_check'] = 'ok';

// Database connectivity check using existing creds
$isJson = true;
include __DIR__ . '/creds.php';
if (isset($conn) && $conn instanceof mysqli && !$conn->connect_errno) {
    $status['database']['connected'] = true;
} else {
    $status['database']['connected'] = false;
    $status['database']['error'] = isset($conn) ? $conn->connect_error : 'no $conn';
}
if (isset($conn) && $conn instanceof mysqli) {
    $conn->close();
}

echo json_encode($status);
?>


