<?php
    include '../includes/session.php';

    $conn = $pdo->open();

    $output = array('error' => false);

    $id = $_POST['id'];
    $quantity = $_POST['quantity'];

    if (isset($_SESSION['user'])) {
        // Check if product exists and has stock
        $stmt = $conn->prepare("SELECT * FROM products WHERE id=:id AND stock > 0");
        $stmt->execute(['id' => $id]);
        $product = $stmt->fetch();

        if ($product) {
            // Check if the product is already in the cart
            $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM cart WHERE user_id=:user_id AND product_id=:product_id");
            $stmt->execute(['user_id' => $user['id'], 'product_id' => $id]);
            $row = $stmt->fetch();

            if ($row['numrows'] < 1) {
                try {
                    // Insert product into the cart
                    $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
                    $stmt->execute(['user_id' => $user['id'], 'product_id' => $id, 'quantity' => $quantity]);
                    $output['message'] = 'Item added to cart';
                } catch (PDOException $e) {
                    $output['error'] = true;
                    $output['message'] = $e->getMessage();
                }
            } else {
                $output['error'] = true;
                $output['message'] = 'Product already in cart';
            }
        } else {
            $output['error'] = true;
            $output['message'] = 'This product is out of stock';
        }
    } else {
        $output['error'] = true;
        $output['message'] = 'You must be logged in to add items to the cart';
    }

    $pdo->close();
    echo json_encode($output);
?>

