<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

// Include the file containing database connection details
include_once 'db.php';

// Check if the product ID is provided and it's a valid integer
if(isset($_POST['product_id']) && filter_var($_POST['product_id'], FILTER_VALIDATE_INT)) {
    // Sanitize the input to prevent SQL injection
    $product_id = $_POST['product_id'];

    try {
        // Prepare and execute the delete query
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = :product_id AND seller_id = :seller_id");
        $stmt->execute(['product_id' => $product_id, 'seller_id' => $_SESSION['seller']['id']]);

        // Check if any row is affected
        if ($stmt->rowCount() > 0) {
            // Product deleted successfully
            echo json_encode(['success' => 'Product deleted successfully']);
        } else {
            // Product not found or unauthorized access
            echo json_encode(['error' => 'Product not found or unauthorized access']);
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    // Invalid or missing product ID
    echo json_encode(['error' => 'Invalid product ID']);
}
?>
