<?php
	include '../includes/conn.php';
	session_start();
	$cartCount = 0; // Initialize cart count
    $cartProducts = array(); // Initialize array to store cart products
    $wishlistCount = 0; // Initialize wishlist count
	$notifications = array(); // Initialize array to store notifications
    $unreadNotificationCount = 0;

	if(isset($_SESSION['user'])){
		$conn = $pdo->open();

		try{
			// Fetch user information
			$stmt = $conn->prepare("SELECT * FROM users WHERE id=:id");
			$stmt->execute(['id'=>$_SESSION['user']]);
			$user = $stmt->fetch();

			// Count the number of products in the cart for the user
            $stmt = $conn->prepare("SELECT COUNT(*) as cart_count FROM cart WHERE user_id=:user_id");
            $stmt->execute(['user_id'=>$_SESSION['user']]);
            $cartCount = $stmt->fetch(PDO::FETCH_ASSOC)['cart_count'];
            
            // Fetch products in the cart for the user
            $stmt = $conn->prepare("SELECT product_id, quantity FROM cart WHERE user_id=:user_id");
            $stmt->execute(['user_id'=>$_SESSION['user']]);
            $cartProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Fetch wishlist count
            $stmt = $conn->prepare("SELECT COUNT(*) as wishlist_count FROM wishlist WHERE user_id=:user_id");
            $stmt->execute(['user_id'=>$_SESSION['user']]);
            $wishlistCount = $stmt->fetch(PDO::FETCH_ASSOC)['wishlist_count'];

			// Count the number of unread notifications for the user
            $stmt = $conn->prepare("SELECT COUNT(*) as unread_notification_count 
                                    FROM notification 
                                    INNER JOIN orders ON notification.order_id = orders.id
                                    WHERE orders.user_id = :user_id 
                                    AND (seen_date IS NULL OR seen_time IS NULL)");
            $stmt->execute(['user_id' => $_SESSION['user']]);
            $unreadNotificationCount = $stmt->fetch(PDO::FETCH_ASSOC)['unread_notification_count'];
		}
		catch(PDOException $e){
			echo "There is some problem in connection: " . $e->getMessage();
		}

		$pdo->close();
	}
?>