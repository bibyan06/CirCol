<?php include '../includes/session.php'; ?>

<!DOCTYPE html>
<html>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="shortcut icon" type="x-icon" href="../customer_assets/images/about.svg">
    <link rel="stylesheet" href="cart.css">

    <link rel="stylesheet" href="../customer_assets/css/style-prefix.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <style>
        /* HEADER CONTAINER */
        .cart-dd-menu{
            overflow-y: scroll;
            height: 500px;
        }
        .nav-item {
            position: relative;
        }
        ion-icon{
            color: black;
        }
        .rounded-circle{
            border-radius: 50%;
            max-width: 40px; 
            margin-right: -10px;
        }
        .dropdown .dropdown-menu {
            left: -305px;
            min-width: 350px;
            padding: 10px;
            font-size: 14px;
            border-radius: 5px;
        }
        .dropdown-toggle ion-icon{
            font-size: 30px;
        }
        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            display: none;
            background-color: white;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.5);
            z-index: 1000; /* Increase z-index to bring the dropdown forward */
            margin-left: -5px;
            margin-top: 10px;
        }
        .dropdown-menu::before {
            content: '';
            position: absolute;
            top: -10px; /* Adjust as needed */
            right: 15px; /* Adjust as needed */
            border-width: 0 10px 10px 10px;
            border-style: solid;
            border-color: transparent transparent white transparent;
        }
        .dropdown-menu .profile {
            padding: 10px;
            margin-right: -12px;
            margin-top: 6px;
            border-radius: 5px;
            box-shadow: 0px 4px 20px rgba(0, 0, 0, 1);
            width: 250px;
        }
        .dropdown-header h6 {
            margin-bottom: 0;
            text-align: center;
            font-size: 18px;
        }
        .dropdown-header span {
            color: #6c757d;
            font-size: 15px;
        }
        .dropdown-divider {
            margin: 0.5rem 0;
            border-color: #e9ecef;
        }
        li{
            text-align: center;
        }
        .wish-heart ion-icon{
            font-size: 30px;
        }
        .cart_count {
            position: absolute;
            top: -6px;
            right: -7px;
            background: var(--bittersweet);
            color: var(--white);
            font-size: 12px;
            font-weight: var(--weight-500);
            line-height: 1;
            padding: 2px 4px;
            -webkit-border-radius: 20px;
                    border-radius: 20px;
        }
        .count2{
            top: 1px;
            right: -1px;
        }
        .count {
            position: absolute;
            top: -4px;
            right: -5px;
            background: var(--bittersweet);
            color: var(--white);
            font-size: 12px;
            font-weight: var(--weight-500);
            line-height: 1;
            padding: 2px 4px;
            -webkit-border-radius: 20px;
                    border-radius: 20px;
        }
        
        .count_notifs{
            position: absolute;
            top: -0px;
            right: -5px;
            background: var(--bittersweet);
            color: var(--white);
            font-size: 12px;
            font-weight: var(--weight-500);
            line-height: 1;
            padding: 2px 4px;
            -webkit-border-radius: 20px;
                    border-radius: 20px;
        }
        /* DROPDOWN CONTAINER CART*/
        .dropdown-item2 {
            display: flex;
            padding: 10px;
        }
        .product_data{
            padding: 0 10px;
        }
        .product_data a{
            color: #061E39;
        }
        .gotocart_btn{
            width: 100%;
            text-align: center;
            color: #061e39;
        }
        .gotocart_btn:hover{
            background-color: #ff7300a3;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            min-width: 120px;
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
            z-index: 1;
        }
        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }
        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }
        .dropdown:hover .dropdown-content {
            display: block;
        }


        /* NAVBAR HEADER */
        .cat_list{
            position: absolute;
            margin-left: -1px;

        }
        .category-list{
            font-size: 15px;
            color: hsl(0, 0%, 47%);
            
        }
        .dropdown-item {
            display: flex;
        }

        /* MOBILE NAVIGATION BAR */
        .mobile-menu-category-list .menu-category {
            border-bottom: 1px solid var(--cultured);
            text-align: left;
        }

        /* MOBILE NAVIGATION BAR SOCIAL MEDIA*/
        .menu-social-container ion-icon{
            color: black;
            margin-right: 0px;
        }
        .menu-category0{
            display: none;
        }
        .menu-category{
            cursor: pointer;
        }
        .submenu-category-list.active {
            max-height: 300px;
            visibility: visible;
        }
        .desktop-menu-category-list {
            gap: 50px;
        }
        /* HEADER!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/


        /* NEW CSS */
        .desktop-menu-category-list .menu-category > .menu-title:hover {
            color: #2670B8;
        }

        .banner-title {
            color: #061E39;
            font-weight: 800;
            font-size: 70px;
        }
        .banner-btn {
            background: #061E39; 
        }
        .banner-btn:hover {
            background: #F89F7B;
        }
        .grid-item {
            background-color: #f0f0f0;
            text-align: left;
            border-radius: 20px;
            font-weight: 600;
            font-size: 20px;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-gap: 10px;
            background-color: #E8E8E8;
            padding-right: 20px;
        }
        .grid-item:hover {
            transform: scale(1.1);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        .grid-item-inner p {
            padding: 20px; 
            font-size:25px;
            color: #061E39;
        }
        .grid-item-inner img {
            width: 150px; 
            height: 150px;
        }
        .grid-new-item {
            text-align: left;
            font-weight: 600;
            font-size: 20px;
            display: grid;
            grid-template-rows: repeat(2, 1fr);
            padding-right: 20px;
            height: 320px;
            padding-left: 20px;
            padding-top: 20px;
            border-radius: 20px;
        }
        .grid-inner1 img {
           border-style: solid; 
           border-color: #D9D9D9; 
           border-width: 10px; 
           border-radius: 10px; 
           width: 200px; 
           height: 200px;
        }
        .grid-new-item:hover {
            background-color: #E8E8E8;
        }
        .grid-inner2 {
            padding-left: 10px;
        }
        .prod-name {
            margin-top: 10px;
            font-size: 18px;
            font-weight: 600;
            color: black;
            
        }
        .prod-seller {
            font-size: 16px;
            font-weight: 500;
            font-style: italic;
            color: #061E39;
        }
        .prod-price {
            font-size: 18px;
            font-weight: 700;
        }
        .new-items-btn {
            margin-top: 150px;
            margin-left: 550px;
            margin-bottom: 100px;
            align-content: center;
            width: 200px;
            height: 50px;
            border-color: #061E39;
            border-radius: 20px;
            border-style: solid;
            border-width: 2px;
            text-align: center;
            color: black;
            font-weight: 400;
        }
        .new-items-btn:hover {
            background-color: #061E39;
            color: white;
        }
        .cat-btn {
            margin-top: 50px;
            margin-left: 550px;
            margin-bottom: 100px;
            align-content: center;
            width: 200px;
            height: 50px;
            background-color: #E8E8E8;
            border-color: #061E39;
            border-radius: 20px;
            border-style: solid;
            border-width: 2px;
            text-align: center;
            color: black;
            font-weight: 400;
        }
        .cat-btn:hover {
            background-color: #061E39;
            color: white;
        }
        @media (max-width: 600px) {
            .banner-title {
                font-size: 30px;
            }
        }

        .category-item {
            padding: 10px !important;
        }
        .category{
            margin-top: -20px !important;
        }

        /* Product */

        .product-container {
        padding: 50px 0;
        }
        .product-row {
            display: flex;
            flex-wrap: wrap;
            margin: -10px;
        }
        .product-box {
            background-color: #f0f0f0;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
            margin: 10px;
            flex: 0 0 calc(25% - 20px); /* Maintain 4 items per row, adjust if needed */
            box-sizing: border-box;
        }
        .product-box:hover {
            transform: scale(1.05);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        .product-image {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .product-info {
            margin-top: 15px;
        }
        .product-info h3 {
            font-size: 18px;
            font-weight: 600;
            color: #061E39;
        }
        .product-price {
            font-size: 16px;
            color: #333;
            margin: 10px 0;
        }
        .add-to-cart-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #061E39;
            color: #fff;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s;
        }
        .add-to-cart-btn:hover {
            background-color: #F89F7B;
        }
    </style>

<body>
<div class="overlay" data-overlay></div>

<header>
    <div class="header-main">
        <div class="container">
            <a href="#" class="header-logo">
                <img src="../customer_assets/images/logo/circol_logo.png" alt="Anon's logo" width="180" height="50">
            </a>

            <div class="header-user-actions">
                <button class="action-btn wish-heart">
                    <a href="notifs.php"><ion-icon name="notifications-outline" id="notificationsIcon"></ion-icon></a>
                    <span class="count"><?php echo $unreadNotificationCount; ?></span>
                </button>

                <!-- Cart Dropdown Menu -->
                <div class="container2">
                    <div class="row">
                        <div class="col-md-6 offset-md-3">
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" id="cartDropdown">
                                    <ion-icon name="bag-handle-outline"></ion-icon>
                                    <span class="label label-success cart_count"><?php echo $cartCount; ?></span>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="cartDropdown">
                                    <div class="cart-header">
                                        <h4 style="text-align: center;"><?php echo $cartCount; ?> Item(s) in Cart</h4>
                                    </div>
                                    <div class="cart-dd-menu">
                                        <?php foreach ($cartProducts as $cartProduct): ?>
                                            <?php
                                            // Fetch product information from the database
                                            $stmt = $conn->prepare("SELECT name, price, photo, slug FROM products WHERE id=:id");
                                            $stmt->execute(['id' => $cartProduct['product_id']]);
                                            $productInfo = $stmt->fetch(PDO::FETCH_ASSOC);

                                            // Concatenate the photo filename with the path
                                            $photoPath = "../images/Products/" . $productInfo['photo'];
                                            ?>
                                            <div class="dropdown-item2">
                                                <img src="<?php echo $photoPath; ?>" alt="<?php echo $productInfo['name']; ?>" style="max-width: 80px;"> <!-- Display product photo -->
                                                <div class="product_data">
                                                    <?php
                                                    echo "<h3><a href='product.php?product=".$productInfo['slug']."'>".$productInfo['name']."</a></h3>";
                                                    ?>
                                                    <p>Price: <?php echo $productInfo['price']; ?></p>
                                                    <p>Quantity: <?php echo $cartProduct['quantity']; ?></p> <!-- Fetch quantity from cartProduct -->
                                                </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="dropdown-divider"></div>
                                    <a class="gotocart_btn" href="cart_view.php">Go to Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <li class="nav-item dropdown pe-3">
                    <a href="#" class="dropdown-toggle person" data-toggle="dropdown">
                        <?php if (isset($user)): ?>
                            <?php
                            // Display the user's profile photo from the "images" folder
                            $photoFilename = "../images/" . $user['photo'];

                            if (file_exists($photoFilename)) {
                                echo '<img src="' . $photoFilename . '" alt="Profile Photo" class="rounded-circle">';
                                //echo '<span class="d-none d-sm-inline-block">'.$user['firstname'].' '.$user['lastname'].'</span>';
                            } else {
                                // Display a default profile photo if the file doesn't exist
                                echo '<img src="default-profile-photo.jpg" alt="Default Profile Photo" class="rounded-circle">';
                            }
                            ?>
                        <?php else: ?>
                            <!-- Default values if the user is not logged in -->
                            <ion-icon name="person-outline"></ion-icon>
                        <?php endif; ?>
                    </a><!-- End Profile Image Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <?php
                            if(isset($_SESSION['user'])){
                                echo '
                                    <li class="user-header">
                                        <p>
                                            '.$user['firstname'].' '.$user['lastname'].'
                                        </p>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li>
                                        <a class="dropdown-item d-flex align-items-center" href="profile.php">
                                            <i class="bi bi-person"></i>
                                            <span>My Profile</span>
                                        </a>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li>
                                        <a class="dropdown-item d-flex align-items-center" href="myorders.php">
                                            <i class="bi bi-bag-plus"></i>
                                            <span>My Orders</span>
                                        </a>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li>
                                        <a class="dropdown-item d-flex align-items-center" href="my_done_orders.php">
                                            <i class="bi bi-bag-check"></i>
                                            <span>My Done Orders</span>
                                        </a>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li>
                                        <a class="dropdown-item d-flex align-items-center" href="contactus.php">
                                            
                                            <span>Need Help<i class="bi bi-question-circle"></i> ContactUs</span>
                                        </a>
                                    </li>

                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>

                                    <li>
                                        <a class="dropdown-item d-flex align-items-center" href="logout.php">
                                            <i class="bi bi-box-arrow-right"></i>
                                            <span>Sign Out</span>
                                        </a>
                                    </li>
                                ';
                            } else {
                                echo "
                                    <li><a href='login.php'>LOGIN</a></li>
                                    <li><a href='signup.php'>SIGNUP</a></li>
                                ";
                            }
                            ?>
                        </li>
                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->
            </div>
        </div>
    </div>

    <nav class="desktop-navigation-menu">

      <div class="container">

        <ul class="desktop-menu-category-list">

			<li class="menu-category">
				<a href="index.php" class="menu-title">Home</a>
			</li>

			<li class="menu-category0">
				<a href="#category" class="menu-title">Categories</a>
			</li>
            
            <li class="menu-category">
                <a class="menu-title">Categories</a>

                <ul class="dropdown-list">

                    <?php
						
                        $conn = $pdo->open();
                        try{
                        $stmt = $conn->prepare("SELECT * FROM category");
                        $stmt->execute();
                        foreach($stmt as $row){
                            echo "
                            <li class='dropdown-item'><a href='category.php?category=".$row['cat_slug']."'>".$row['name']."</a></li>
                            ";                  
                        }
                        }
                        catch(PDOException $e){
                        echo "There is some problem in connection: " . $e->getMessage();
                        }

                        $pdo->close();

                    ?>

                </ul>
            </li>

            <li class="menu-category">
                <a href="product.php" class="menu-title">Product</a>
            </li>

            <li class="menu-category">
                <a href="about.php" class="menu-title">About</a>
            </li>

            <div class="header-search-container">

                <form method="POST" class="search_bar" action="search.php">
                    <div>
                        <input type="text" class="search-field" name="keyword" placeholder="Search for Product" required>
                        <span class="input-group-btn" id="searchBtn" style="display:none;">
                            <button type="submit" class="search-btn"><ion-icon name="search-outline"></ion-icon> </button>
                        </span>
                    </div>
                </form>

            </div>
        <!-- <li class="menu-category">
                <a href="shop_filter.php" class="menu-title">DBO</a>
    
                <ul class="dropdown-list">
                    <?php
                        $conn = $pdo->open();
                        try {
                            $stmt = $conn->prepare("SELECT * FROM users WHERE shop_name IS NOT NULL AND shop_name <> ''");
                            $stmt->execute();
                            foreach ($stmt as $row) {
                                echo "
                                <li class='dropdown-item'><a href='#'>".$row['shop_name']."</a></li>
                                ";
                            }
                        } catch (PDOException $e) {
                            echo "There is some problem in connection: " . $e->getMessage();
                        }
                        $pdo->close();
                    ?>
                </ul>
        </li> -->

        </ul>

      </div>

    </nav>

    <div class="product-container">
        <div class="container">
            <div class="product-row">
                <?php
                    $conn = $pdo->open();
                    try{
                        $stmt = $conn->prepare("SELECT * FROM products LIMIT 5");
                        $stmt->execute();
                        foreach($stmt as $row){
                            $photoPath = "../images/Products/" . $row['photo'];
                            echo "
                            <div>
                                <div class='product-box'>
                                    <img src='" . $photoPath . "' alt='" . $row['name'] . "' class='product-image'>
                                    <div class='product-info'>
                                        <h3>" . $row['name'] . "</h3>
                                        <p class='product-price'>Price: Php" . $row['price'] . "</p>
                                        <a href='add_to_cart.php?product=" . $row['slug'] . "' class='add-to-cart-btn'>Add to Cart</a>
                                    </div>
                                </div>
                            </div>
                            ";
                        }
                    }
                    catch(PDOException $e){
                        echo "There is some problem in connection: " . $e->getMessage();
                    }
                    $pdo->close();
                ?>
            </div>
        </div>
    </div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>