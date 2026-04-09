<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

require_once 'creds.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Only POST method allowed']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['reservation_id']) || !isset($input['customer_id'])) {
    echo json_encode(['success' => false, 'message' => 'Reservation ID and Customer ID required']);
    exit;
}

$reservation_id = intval($input['reservation_id']);
$customer_id = intval($input['customer_id']);
$penalty_amount = 25.00; // $25 penalty for no show

// For now, this is a dummy implementation
// TODO: Implement proper Stripe payment logic later

// Simulate some processing time
usleep(500000); // 0.5 seconds

// Randomly return success or failure for testing (90% success rate)
$is_successful = (rand(1, 10) <= 9);

if ($is_successful) {
    // TODO: Implement actual Stripe charge logic here
    // Example structure:
    // 1. Get customer's payment method from database
    // 2. Create Stripe charge for $25.00
    // 3. Handle charge response
    // 4. Update reservation status if charge successful
    // 5. Send notification to customer
    
    echo json_encode([
        'success' => true,
        'message' => 'No show penalty charged successfully',
        'data' => [
            'reservation_id' => $reservation_id,
            'customer_id' => $customer_id,
            'penalty_amount' => $penalty_amount,
            'charge_id' => 'ch_dummy_' . time(), // Dummy charge ID
            'status' => 'charged'
        ]
    ]);
} else {
    // TODO: Handle charge failure
    // Example structure:
    // 1. Log failed charge attempt
    // 2. Notify restaurant staff
    // 3. Maybe send reminder to customer to update payment method
    
    echo json_encode([
        'success' => false,
        'message' => 'Failed to charge no show penalty',
        'data' => [
            'reservation_id' => $reservation_id,
            'customer_id' => $customer_id,
            'penalty_amount' => $penalty_amount,
            'error' => 'Payment method declined or invalid',
            'status' => 'failed'
        ]
    ]);
}

$conn->close();
?>
