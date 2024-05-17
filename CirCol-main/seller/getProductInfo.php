<?php
include '../includes/conn.php';

if(isset($_POST['productId'])) {
    $productId = $_POST['productId'];

    // Fetch product details from the database
    $conn = $pdo->open();
    $stmt = $conn->prepare("SELECT name, description, price, CONCAT('../images/Products/', photo) AS photo FROM products WHERE id=:id");
    $stmt->execute(['id' => $productId]);
    $product = $stmt->fetch();
    $pdo->close();

    // Prepare the response as JSON
    $response = json_encode($product);

    // Send the response
    echo $response;
}
?>
