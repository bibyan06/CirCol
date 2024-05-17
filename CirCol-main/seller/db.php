<?php
// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "circol";

// Create connection
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    // If connection fails, you can handle the error here
}
?>
