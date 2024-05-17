<?php
include '../includes/conn.php';

if(isset($_POST['orderId']) && isset($_POST['status'])) {
   $orderId = $_POST['orderId'];
   $status = $_POST['status'];

   // Update status in the database
   $conn = $pdo->open();
   $stmt = $conn->prepare("UPDATE orders SET status = :status WHERE id = :id");
   $stmt->execute(['status' => $status, 'id' => $orderId]);
   $pdo->close();

   // Return success response
   echo 'Status updated successfully';
}
?>
