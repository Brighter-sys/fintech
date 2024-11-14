<?php
session_start();
include 'db.php';  // Include the database connection

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    // Fetch the transactions
    $stmt = $pdo->query("SELECT * FROM transactions ORDER BY created_at DESC");
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the transactions as a JSON response
    echo json_encode($transactions);
} else {
    // If not logged in, return an empty array or an error message
    echo json_encode([]);
}
?>

