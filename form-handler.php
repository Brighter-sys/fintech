<?php
session_start();
include 'db.php';  // Include the database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $name = $_POST['name'];
    $amount = $_POST['amount'];
    $currency = $_POST['currency'];

    // Validate inputs (for simplicity, not comprehensive validation here)
    if (!empty($name) && $amount > 0 && !empty($currency)) {
        // Prepare the SQL query to insert the transaction
        $stmt = $pdo->prepare("INSERT INTO transactions (amount, currency) VALUES (?, ?)");
        $stmt->execute([$amount, $currency]);

        // Respond with a success message
        echo json_encode(['message' => 'Transaction successful!']);
    } else {
        echo json_encode(['message' => 'Please fill in all fields correctly.']);
    }
} else {
    echo json_encode(['message' => 'Invalid request method.']);
}
?>
