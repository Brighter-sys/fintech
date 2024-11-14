<?php
session_start();
include 'db.php'; // Include your database connection

// Check if form is submitted
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query to check if the username exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);

    // Fetch the user data
    $user = $stmt->fetch();

    if ($user) {
        // If user found, check the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, start the session
            $_SESSION['username'] = $user['username']; // Store username in session
            header("Location: index.php"); // Redirect to the main page
            exit();
        } else {
            // Incorrect password
            echo "Incorrect password!";
        }
    } else {
        // No user found with that username
        echo "No user found with that username!";
    }
} else {
    // If the form is not submitted, show an error
    echo "Please provide both username and password!";
}
?>
