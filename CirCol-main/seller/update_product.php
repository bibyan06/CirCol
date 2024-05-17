<?php
// DELETE IF NOT NEEDED

include_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Update product in the database
    try {
        $stmt = $pdo->prepare("UPDATE products SET name = :name, description = :description, price = :price WHERE id = :id");
        $stmt->execute(['name' => $name, 'description' => $description, 'price' => $price, 'id' => $id]);
        // Redirect to the page where the product list is displayed
        header("Location: products.php");
        exit();
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>
