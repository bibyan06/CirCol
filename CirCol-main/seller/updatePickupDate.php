<?php
include '../includes/conn.php';

if(isset($_POST['orderId']) && isset($_POST['pickupDate'])) {
    $orderId = $_POST['orderId'];
    $pickupDate = $_POST['pickupDate'];

    // Update pickup date in the database
    $conn = $pdo->open();
    $stmt = $conn->prepare("UPDATE orders SET order_track = :pickupDate WHERE id = :id");
    $stmt->execute(['pickupDate' => $pickupDate, 'id' => $orderId]);
    $pdo->close();

    // Return success response
    echo 'Pickup date updated successfully';
}
?>
