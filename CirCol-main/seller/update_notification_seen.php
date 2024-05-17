<?php
// Set the timezone to Manila
date_default_timezone_set('Asia/Manila');

// Connect to your database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "circol";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the notificationId from the AJAX request
if (isset($_GET["notificationId"])) {
    $notificationId = $_GET["notificationId"];

    // Get the current date and time in Manila timezone
    $currentDate = date("Y-m-d");
    $currentTime = date("H:i:s");

    // Update the admin_notifs table with the current date and time
    $sql = "UPDATE admin_notifs SET seen_date='$currentDate', seen_time='$currentTime' WHERE id=$notificationId";

    if ($conn->query($sql) === TRUE) {
        echo "Notification updated successfully";
    } else {
        echo "Error updating notification: " . $conn->error;
    }
} else {
    echo "Notification ID not provided";
}

$conn->close();
?>
