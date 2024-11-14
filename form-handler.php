<?php
// Capture the form data (amount)
$amount = $_POST['amount'];

// Here, you would normally save the data to a database.
// For simplicity, we are just returning a success message.

$response = [
    'status' => 'success',
    'message' => 'Transaction recorded successfully',
    'amount' => $amount
];

// Set the response header to JSON and return the response
header('Content-Type: application/json');
echo json_encode($response);
?>
