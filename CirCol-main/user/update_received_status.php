<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$dbHost = 'localhost'; // Change this to your database host
$dbUsername = 'root'; // Change this to your database username
$dbPassword = ''; // Change this to your database password
$dbName = 'circol'; // Change this to your database name

// Create connection
$connection = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Optional: Set charset to UTF-8
$connection->set_charset("utf8");


if(isset($_POST['orderId'])) {
    $orderId = $_POST['orderId'];
    
    // Update the status of the order to "Received" in the database
    $query = "UPDATE orders SET status = 3 WHERE id = $orderId"; // Assuming status code for "Received" is 3
    
    // Execute the query
    $result = mysqli_query($connection, $query); // Assuming $connection is your database connection
    
    if($result) {
        echo 'success'; // Output success message
    } else {
        echo 'error'; // Output error message
    }
} else {
    echo 'error: Order ID not provided';
}
?>
