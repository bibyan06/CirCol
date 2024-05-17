<?php
session_start();

include 'includes/slugify.php';
include 'db.php';

// Check if the user is logged in
if (!isset($_SESSION['seller']['id'])) {
    // Redirect to login page if not logged in
    header("Location: login.php");
    exit();
}

if (isset($_POST['submit'])) {
    try {
        $name = $_POST['name'];
        $slug = slugify($name);
        $category = $_POST['category'];
        $price = $_POST['price'];
        $description = $_POST['description'];
        $stock = $_POST['stock'];
        $filename = $_FILES['photo']['name'];
        $file_tmp = $_FILES['photo']['tmp_name'];
        $file_type = $_FILES['photo']['type'];
        $file_ext = strtolower(end(explode('.', $_FILES['photo']['name'])));

        $extensions = array("jpeg", "jpg", "png");

        if (!in_array($file_ext, $extensions)) {
            throw new Exception("Extension not allowed, please choose a JPEG or PNG file.");
        }

        $new_filename = $slug . '.' . $file_ext;
        $upload_path = '../images/Products/';

        // If image already exists in the folder, use that image
        if (file_exists($upload_path . $new_filename)) {
            $new_filename = $slug . '.' . $file_ext;
        } else {
            // Upload new image
            move_uploaded_file($file_tmp, $upload_path . $new_filename);
        }

        // Open the PDO connection
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert the product
        $stmt = $conn->prepare("INSERT INTO products (category_id, seller_id, name, description, slug, price, photo, stock, date_view, counter) VALUES (:category, :seller_id, :name, :description, :slug, :price, :photo, :stock, NOW(), 0)");
        $stmt->execute(['category' => $category, 'seller_id' => $_SESSION['seller']['id'], 'name' => $name, 'description' => $description, 'slug' => $slug, 'price' => $price, 'photo' => $new_filename, 'stock' => $stock]);

        $_SESSION['success'] = 'Product added successfully';
        header('Location: product_list.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header('Location: product_list.php');
        exit();
    } finally {
        // Close the database connection
        $conn = null;
    }
} else {
    $_SESSION['error'] = 'Fill up the product form first';
    header('Location: product_list.php');
    exit();
}
?>
