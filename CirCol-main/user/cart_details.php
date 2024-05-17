<?php
	include '../includes/session.php';
	$conn = $pdo->open();

	$output = '';

	if(isset($_SESSION['user'])){
		if(isset($_SESSION['cart'])){
			foreach($_SESSION['cart'] as $row){
				$stmt = $conn->prepare("SELECT *, COUNT(*) AS numrows FROM cart WHERE user_id=:user_id AND product_id=:product_id");
				$stmt->execute(['user_id'=>$user['id'], 'product_id'=>$row['productid']]);
				$crow = $stmt->fetch();
				if($crow['numrows'] < 1){
					$stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
					$stmt->execute(['user_id'=>$user['id'], 'product_id'=>$row['productid'], 'quantity'=>$row['quantity']]);
				}
				else{
					$stmt = $conn->prepare("UPDATE cart SET quantity=:quantity WHERE user_id=:user_id AND product_id=:product_id");
					$stmt->execute(['quantity'=>$row['quantity'], 'user_id'=>$user['id'], 'product_id'=>$row['productid']]);
				}
			}
			unset($_SESSION['cart']);
		}

		try {
            $total = 0;
            $stmt = $conn->prepare("SELECT *, cart.id AS cartid, users.shop_name AS shop_name, users.gcash_number AS gcash_number, users.gcash_qr AS gcash_qr, products.photo AS product_photo 
                                    FROM cart 
                                    LEFT JOIN products ON products.id=cart.product_id 
                                    LEFT JOIN users ON users.id=products.seller_id
                                    WHERE user_id=:user");
            $stmt->execute(['user' => $user['id']]);
            foreach($stmt as $row) {
                $image = (!empty($row['product_photo'])) ? '../images/Products/'.$row['product_photo'] : '../images/noimage.jpg';
                $subtotal = $row['price'] * $row['quantity'];
                // Construct the URL for the gcash_qr image
                $gcashQrImage = '../images/Gcash_QR/' . $row['gcash_qr'];
                $output .= "
                    <div class='item'>
                        <tr class='cart_tr' data-seller-id='".$row['seller_id']."' data-gcash-number='".$row['gcash_number']."' data-gcash-qr='".$row['gcash_qr']."'>
                            <td><input type='checkbox' class='item-checkbox' onclick='updateTotal(this, $subtotal)'></td>
                            <td><img src='".$image."' width='80px' height='80px' class='cart_img'></td>
                            <td>".$row['name']."</td>
                            <td>₱".number_format($row['price'], 2)."</td>
                            <td class='input-group1'>
                                <span class='input-group-btn'>
                                    <button type='button' id='minus' class='btn btn-default btn-flat minus' data-id='".$row['cartid']."'><ion-icon name='remove-outline' class='subtract'></ion-icon></button>
                                </span>
                                <input type='text' class='quantity' value='".$row['quantity']."' id='qty_".$row['cartid']."'>
                                <span class='input-group-btn'>
                                    <button type='button' id='add' class='btn btn-default btn-flat add' data-id='".$row['cartid']."'><ion-icon name='add-outline' class='add'></ion-icon></button>
                                </span>
                            </td>
                            <td>₱ ".number_format($subtotal, 2)."</td>
                            <td>".$row['shop_name']."</td> <!-- Hide shop_name here -->
							<td style='display: none;'>".$row['product_id']."</td>
                            <td style='display: none;'>".$row['gcash_number']."</td> <!-- Hide gcash_number here -->
                            <td style='display: none;'><img src='".$gcashQrImage."' width='80px' height='80px'></td> <!-- Hide gcash_qr image here -->
                            <td><button type='button' data-id='".$row['cartid']."' class=' cart_delete'><ion-icon name='trash-outline' class='trash'></ion-icon></button></td>
                        </tr>
                    </div>
                ";
            }
            $output .= "
					<div class='value'>
						<tr class='total_value'>
							<td colspan='5' align='left' class='total-value2' style='white-space: nowrap;'>Total ₱ <h4 id='totalValue' style='display: inline; margin: 0;'></h4></td>
							<td colspan='5' align='right'><button class='checkout' onclick='redirectToCheckout()'>Check Out</button></td>
						</tr>
					</div>
            ";
        } catch(PDOException $e) {
            $output .= $e->getMessage();
        }       	
	}
	//Not Needed!!!!
	else{
		if(count($_SESSION['cart']) != 0){
			$total = 0;
			foreach($_SESSION['cart'] as $row){
				$stmt = $conn->prepare("SELECT *, products.name AS prodname, category.name AS catname FROM products LEFT JOIN category ON category.id=products.category_id WHERE products.id=:id");
				$stmt->execute(['id'=>$row['productid']]);
				$product = $stmt->fetch();
				$image = (!empty($product['photo'])) ? '../images/Products/'.$product['photo'] : '../images/noimage.jpg';
				$subtotal = $product['price']*$row['quantity'];
				/** $total += $subtotal; */
				$output .= "
					<tr>
						<td><input type='checkbox' class='item-checkbox' onclick='updateTotal(this, $subtotal)'></td>

						<td><button type='button' data-id='".$row['productid']."' class='btn btn-danger btn-flat cart_delete'><i class='fa fa-remove'></i></button></td>
						<td><img src='".$image."' width='30px' height='30px'></td>
						<td>".$product['name']."</td>
						<td>&#36; ".number_format($product['price'], 2)."</td>
						<td class='input-group'>
							<span class='input-group-btn'>
            					<button type='button' id='minus' class='btn btn-default btn-flat minus' data-id='".$row['productid']."'><i class='fa fa-minus'></i></button>
            				</span>
            				<input type='text' class='form-control' value='".$row['quantity']."' id='qty_".$row['productid']."'>
				            <span class='input-group-btn'>
				                <button type='button' id='add' class='btn btn-default btn-flat add' data-id='".$row['productid']."'><i class='fa fa-plus'></i>
				                </button>
				            </span>
						</td>
						<td>&#36; ".number_format($subtotal, 2)."</td>
					</tr>
				";
				
			}

			$output .= "
				<tr>
					<td colspan='5' align='left' class='total-value' style='white-space: nowrap;'>Total ₱ <h4 id='totalValue' style='display: inline; margin: 0;'></h4></td>
					<td colspan='5' align='right'><button class='checkout' onclick='openCheckoutPopup()'>Check Out</button></td>
				<tr>
			";
		}

		else{
			$output .= "
				<tr>
					<td colspan='7' align='center'>Shopping cart empty</td>
				<tr>
			";
		}
		
	}
	//////
	$pdo->close();
	echo json_encode($output);

?>

