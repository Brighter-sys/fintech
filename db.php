<?php
$host = "localhost";  // or your database server address (e.g., '127.0.0.1')
$username = "root";   // your database username
$password = "Mclarenp16781$$";       // your database password
$dbname = "fintech_demo"; // the name of your database

try {
    // Create PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
