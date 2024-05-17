<?php
include '../includes/session.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user ID from the session if the user is logged in
    if(isset($_SESSION['user'])) {
        $user_id = $user['id']; // Assuming $user['id'] contains the user's ID

        // Extract GCash account name and reference number from the form
        $gcash_account_name = $_POST['gcash_account_name'];
        $gcash_refno = $_POST['reference_no'];

        // Get the current date for order_date
        $order_date = date('Y-m-d');

        // Set status to 0 (Pending)
        $status = 0; 

        // Set order_track to the order date
        $order_track = '0000-00-00';

        // Connect to the database
        $conn = $pdo->open();

        // Begin transaction
        $conn->beginTransaction();

        try {
            // Loop through each product in the order
            for ($i = 0; $i < count($_POST['product_id']); $i++) {
                $seller_id = $_POST['seller_id'][$i];
                $product_id = $_POST['product_id'][$i];
                $quantity = $_POST['quantity'][$i];
                
                // Fetch the product price from the database
                $stmt_price = $conn->prepare("SELECT price FROM products WHERE id = :product_id");
                $stmt_price->bindParam(':product_id', $product_id);
                $stmt_price->execute();
                $product = $stmt_price->fetch(PDO::FETCH_ASSOC);
                $product_price = $product['price'];
                
                // Calculate the subtotal for this product
                $subtotal = $product_price * $quantity;

                // Prepare and execute SQL statement to insert order details into the database
                $stmt = $conn->prepare("INSERT INTO ebuy.orders (user_id, seller_id, product_id, quantity, total_price, order_date, status, order_track, gcash_acc_name, gcash_refno) VALUES (:user_id, :seller_id, :product_id, :quantity, :total_price, :order_date, :status, :order_track, :gcash_acc_name, :gcash_refno)");

                // Bind parameters
                $stmt->bindParam(':user_id', $user_id);
                $stmt->bindParam(':seller_id', $seller_id);
                $stmt->bindParam(':product_id', $product_id);
                $stmt->bindParam(':quantity', $quantity);
                $stmt->bindParam(':total_price', $subtotal); // Store subtotal instead of total value
                $stmt->bindParam(':order_date', $order_date);
                $stmt->bindParam(':status', $status);
                $stmt->bindParam(':order_track', $order_track);
                $stmt->bindParam(':gcash_acc_name', $gcash_account_name);
                $stmt->bindParam(':gcash_refno', $gcash_refno);

                // Execute the statement
                if (!$stmt->execute()) {
                    throw new Exception("Failed to place order.");
                }

                // Update product stock
                $stmt_update_stock = $conn->prepare("UPDATE products SET stock = stock - :quantity WHERE id = :product_id");
                $stmt_update_stock->bindParam(':quantity', $quantity);
                $stmt_update_stock->bindParam(':product_id', $product_id);
                
                if (!$stmt_update_stock->execute()) {
                    throw new Exception("Failed to update product stock.");
                }
            }

            // Delete all checked out products from the cart after successfully placing the order
            for ($i = 0; $i < count($_POST['product_id']); $i++) {
                $checked_out_product_id = $_POST['product_id'][$i];
                $stmt_delete = $conn->prepare("DELETE FROM cart WHERE user_id = :user_id AND product_id = :product_id");
                $stmt_delete->bindParam(':user_id', $user_id);
                $stmt_delete->bindParam(':product_id', $checked_out_product_id);
                
                if (!$stmt_delete->execute()) {
                    throw new Exception("Failed to delete product from cart.");
                }
            }

            // Commit transaction
            $conn->commit();

            // Set a session variable to indicate successful order placement
            $_SESSION['order_placed'] = true;

            // Redirect to cart_view.php
            header("Location: cart_view.php");
            exit(); // Ensure script stops here to prevent further execution
        } catch (Exception $e) {
            // Rollback transaction
            $conn->rollBack();
            echo "<script>alert('" . $e->getMessage() . "');</script>";
        }

        // Close the database connection
        $pdo->close();
    } else {
        // Handle case where user is not logged in
        echo "<script>alert('User not logged in.');</script>";
    }
} else {
    // Handle case where form is not submitted
    echo "<script>alert('Form not submitted.');</script>";
}
?>
