<?php
// Start the session
session_start();

// Include the file containing database connection details
include_once 'db.php';

// Check if the form is submitted via POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $productId = $_POST['productId'];
    $productName = $_POST['productName'];
    $productStock = $_POST['productStock'];
    $productDescription = $_POST['productDescription'];
    $productSlug = $_POST['productSlug'];
    $productPrice = $_POST['productPrice'];

    // Handle file upload for product photo
    if ($_FILES['productPhoto']['error'] == UPLOAD_ERR_OK) {
        // Temporary file name
        $tmpName = $_FILES['productPhoto']['tmp_name'];

        // Get file extension
        $fileExtension = pathinfo($_FILES['productPhoto']['name'], PATHINFO_EXTENSION);

        // Generate unique filename
        $photoFileName = uniqid('product_') . '.' . $fileExtension;

        // Destination directory (adjust as needed)
        $uploadDir = '../images/Products/';

        // Move uploaded file to destination directory
        if (move_uploaded_file($tmpName, $uploadDir . $photoFileName)) {
            // File upload successful, update product photo in database
            $stmt = $pdo->prepare("UPDATE products SET photo = ? WHERE id = ?");
            $stmt->execute([$photoFileName, $productId]);
        } else {
            // File upload failed
            $_SESSION['error'] = "Failed to upload product photo.";
            header("Location: product_list.php");
            exit();
        }
    }

    // Execute the database update query for other product information
    $stmt = $pdo->prepare("UPDATE products SET name = ?, stock = ?, description = ?, slug = ?, price = ? WHERE id = ?");
    $stmt->execute([$productName, $productStock, $productDescription, $productSlug, $productPrice, $productId]);

    // Check if the update was successful
    if ($stmt->rowCount() > 0) {
        // Product information updated successfully
        echo "<script>alert('Product information updated successfully.'); window.location.href = 'product_list.php';</script>";
        exit();
    } else {
        // Failed to update product information
        echo "<script>alert('Failed to update product information. Please try again.'); window.location.href = 'product_list.php';</script>";
        exit();
    }
} else {
    // If the form is not submitted via POST method, handle the error accordingly
    echo "<script>alert('Invalid request.'); window.location.href = 'product_list.php';</script>";
    exit();
}
?>
