<?php
// Set the timezone to your desired timezone
date_default_timezone_set('Asia/Manila');

// Include the connection file
include '../includes/conn.php';

if(isset($_POST['orderId']) && isset($_POST['message']) && isset($_POST['notifTime'])) {
    $orderId = $_POST['orderId'];
    $message = $_POST['message'];
    $currentDate = date('Y-m-d'); // Get current date
    $notifTime = date("H:i:s", strtotime($_POST['notifTime'])); // Format time as "11:37 pm"

    try {
        // Establish database connection
        $pdo = new Database();
        $conn = $pdo->open();

        // Prepare and execute SQL query to insert notification into the database
        $stmt = $conn->prepare("INSERT INTO notification (order_id, message, notif_date, notif_time) VALUES (:orderId, :message, :notifDate, :notifTime)");
        $stmt->execute(['orderId' => $orderId, 'message' => $message, 'notifDate' => $currentDate, 'notifTime' => $notifTime]);

        // Close the database connection
        $pdo->close();

        echo "Notification saved successfully";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

