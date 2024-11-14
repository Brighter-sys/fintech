<?php
// register-handler.php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];

    // Insert the user with the email and full_name
    $stmt = $pdo->prepare("INSERT INTO users (username, password, email, full_name) VALUES (?, ?, ?, ?)");
    $stmt->execute([$username, $password, $email, $full_name]);

    echo "User registered successfully!";
}
?>
