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

    <div class="mobile-bottom-navigation">
        <button class="action-btn" data-mobile-menu-open-btn id="mobilebar_btn">
            <ion-icon name="menu-outline"></ion-icon>
        </button>

        <button class="action-btn">
            <a href="cart_view.php"><ion-icon name="bag-handle-outline"></ion-icon></a>
            <span class="count2 cart_count"><?php echo $cartCount; ?></span>
        </button>

        <button class="action-btn">
            <a href="index.php"><ion-icon name="home-outline"></ion-icon></a>
        </button>

        <button class="action-btn">
            <a href="wishlist.php"><ion-icon name="heart-outline"></ion-icon></a>
            <span class="count"><?php echo $wishlistCount; ?></span>
        </button>

        <button class="action-btn notif-count">
            <a href="notifs.php"><ion-icon name="notifications-outline" id="notificationsIcon"></ion-icon></a>
            <span class="count"><?php echo $unreadNotificationCount; ?></span>
        </button>
    </div>

    <div class="mobile-navigation-overlay" id="mobilebar_overlay"></div>
    <!--- MOBILE HEADER NAVIGATION BAR-->
    <nav class="mobile-navigation-menu has-scrollbar" data-mobile-menu id="mobilebar_info">
        <div class="menu-top">
            <h2 class="menu-title">Menu</h2>
            <!-- Add the close button here -->
            <button class="menu-close-btn" data-mobile-menu-close-btn >
                <ion-icon name="close-outline"></ion-icon>
            </button>
        </div>

        <ul class="mobile-menu-category-list">
            <li class="menu-category">
                <button class="accordion-menu" data-accordion-btn>
                    <p class="menu-title"><?php echo isset($_SESSION['user']) ? $user['firstname'] : 'Guest User'; ?></p>
                    <div>
                        <ion-icon name="add-outline" class="add-icon"></ion-icon>
                        <ion-icon name="remove-outline" class="remove-icon"></ion-icon>
                    </div>
                </button>
                <ul class="submenu-category-list" data-accordion>
                    <?php
                    if (isset($_SESSION['user']) && isset($user['firstname']) && isset($user['lastname'])) {
                        echo '
                            <li class="user-header">
                                <p>
                                    '.$user['firstname'].' '.$user['lastname'].'
                                </p>
                            </li>

                            <li class="submenu-category">
                                <a class="submenu-title" href="profile.php">
                                    <i class="bi bi-person"></i>
                                    <span>My Profile</span>
                                </a>
                            </li>

                            <li class="submenu-category">
                                <a class="submenu-title" href="myorders.php">
                                    <i class="bi bi-bag-plus"></i>
                                    <span>My Orders</span>
                                </a>
                            </li>

                            <li class="submenu-category">
                                <a class="submenu-title" href="my_done_orders.php">
                                    <i class="bi bi-bag-check"></i>
                                    <span>My Done Orders</span>
                                </a>
                            </li>

                            <li class="submenu-category">
                                <a class="submenu-title" href="contactus.php">
                                    <span>Need Help<i class="bi bi-question-circle"></i> ContactUs</span>
                                </a>
                            </li>

                            <li class="submenu-category">
                                <a class="submenu-title" href="logout.php">
                                    <i class="bi bi-box-arrow-right"></i>
                                    <span>Sign Out</span>
                                </a>
                            </li>

                        ';
                    } else {
                        echo "

                            <li class='submenu-category'>
                                <a class='submenu-title' href='login.php'>
                                    <i class='bi bi-box-arrow-right'></i>
                                    <span>LOGIN</span>
                                </a>
                            </li>

                            <li class='submenu-category'>
                                <a class='submenu-title' href='signup.php'>
                                    <i class='bi bi-box-arrow-in-left'></i>
                                    <span>SIGNUP</span>
                                </a>
                            </li>
                        ";
                    }
                    ?>
                </ul>
            </li>

            <li class="menu-category">
                <button class="accordion-menu" data-accordion-btn>
                    <p class="menu-title">Categories</p>
                    <div>
                        <ion-icon name="add-outline" class="add-icon"></ion-icon>
                        <ion-icon name="remove-outline" class="remove-icon"></ion-icon>
                    </div>
                </button>
                <ul class="submenu-category-list" data-accordion>
                    <?php
                    $conn = $pdo->open();
                    try {
                        $stmt = $conn->prepare("SELECT * FROM category");
                        $stmt->execute();
                        foreach ($stmt as $row) {
                            echo "
                            <li class='submenu-category'><a class='submenu-title' href='category.php?category=" . $row['cat_slug'] . "'>" . $row['name'] . "</a></li>
                            ";
                        }
                    } catch (PDOException $e) {
                        echo "There is some problem in connection: " . $e->getMessage();
                    }

                    $pdo->close();
                    ?>
                </ul>
            </li>

            <li class="menu-category">
                <button class="accordion-menu" data-accordion-btn>
                    <a href="product.php" class="menu-title">Products</a>
                </button>
            </li>

            <li class="menu-category">
                <a href="about.php" class="menu-title">About</a>
            </li>
        </ul>

        <div class="menu-bottom">
            <ul class="menu-social-container">
                <li>
                    <a href="#" class="social-link">
                    <ion-icon name="logo-facebook"></ion-icon>
                    </a>
                </li>

                <li>
                    <a href="#" class="social-link">
                    <ion-icon name="logo-twitter"></ion-icon>
                    </a>
                </li>

                <li>
                    <a href="#" class="social-link">
                    <ion-icon name="logo-instagram"></ion-icon>
                    </a>
                </li>

                <li>
                    <a href="#" class="social-link">
                    <ion-icon name="logo-linkedin"></ion-icon>
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <!--- MOBILE HEADER NAVIGATION BAR-->
</header>

<main>
    <!--- BANNER-->
    <div class="banner">
        <div class="container">
            <div class="slider-container has-scrollbar">

                <div class="slider-item" style="height: 550px; max-height: 100%;">

                    <img src="../customer_assets/images/feature_banner.svg" alt="Campus-Wide Merchandise Sales   " class="banner-img">

                    <div class="banner-content">

                        <h2 class="banner-title">Sir Kit's ITEMS</h2>

                        <h6 class="banner-subtitle" style="font-size: 15px; font-weight: 750; letter-spacing: 0.5px;">Sir Kit's IT Gear - Where style meets technology</h6>

                        <a href="#" class="banner-btn">Shop now</a>

                    </div>

                </div>
                </div>

            </div>
        </div>
    </div>
    <!--- CATEGORIES -->
    <div class="category">
        <div class="container">
            <div class="category-item-container has-scrollbar">
                <?php
                $conn = $pdo->open();
                try {
                    $stmt = $conn->prepare("SELECT * FROM category");
                    $stmt->execute();
                    foreach ($stmt as $row) {
                        echo "
                        <div class='category-item'>
                            <div class='category-content-box'>
                                <div class='category-content-flex'>
                                    <h3 class='category-item-title'>{$row['name']}</h3>
                                </div>
                                <a href='category.php?category={$row['cat_slug']}' class='category-btn'>Show all</a>
                            </div>
                        </div>
                        ";
                    }
                } catch (PDOException $e) {
                    echo "There is some problem in connection: " . $e->getMessage();
                }
                $pdo->close();
                ?>
            </div>
        </div>
    </div>

    
    <!---- WHAT'S NEW --->
    <div class="new" id="new">

      <div class="container" style="align-items: center; justify-content: center;"> 
        <div class="new-cont" style="width: 950; height: 764;align-items: center; justify-content: center;"> 

        <p class="new-title" style="font-size: 40px; font-weight: 700; text-align: center; color: #061E39; margin-top: 70px; margin-bottom: 50px;">What's New</p>
        
        <form method="POST" action="search.php">

            <div class="grid-new" style="display: grid; grid-template-columns: repeat(4, 1fr); grid-gap: 50px; width: 50px; height: 300px; padding-left: 100px;">
                <div class="grid-new-item">
                    <div class="grid-inner1">
                        <img src="../customer_assets/images/products/CircUITS/IT_lanyard.svg">
                    </div>
                    <div class="grid-inner2">
                        <p class="prod-name">IT Lanyard</p>
                        <p class="prod-seller">BUCS CircUITS</p>
                        <p class="prod-price">PHP 150.00</p>
                    </div>
                </div>
                <div class="grid-new-item">
                    <div class="grid-inner1">
                        <img src="../customer_assets/images/products/CircUITS/IT_shirt.svg">
                    </div>
                    <div class="grid-inner2">
                        <p class="prod-name">Code Blooded Shirt</p>
                        <p class="prod-seller">BUCS CircUITS</p>
                        <p class="prod-price">PHP 230.00</p>
                    </div>
                </div>
                <div class="grid-new-item">
                    <div class="grid-inner1">
                        <img src="../customer_assets/images/products/BUCS CSC/CS_lanyard.svg">
                    </div>
                    <div class="grid-inner2">
                        <p class="prod-name">BUCS Lanyard</p>
                        <p class="prod-seller">BUCS CSC</p>
                        <p class="prod-price">PHP 150.00</p>
                    </div>
                </div>
                <div class="grid-new-item">
                    <div class="grid-inner1">
                        <img src="../customer_assets/images/products/BU USC/USC_shirt.svg">
                    </div>
                    <div class="grid-inner2">
                        <p class="prod-name">Seasons Fall Shirt</p>
                        <p class="prod-seller">BU USC</p>
                        <p class="prod-price">PHP 250.00</p>
                    </div>
                </div>
            </div>
        </form>
            <a href="#" class="new-items-btn">View All</a>
        </div>

      </div>

    <!--CATEGORY -->
    <div class="category" id="category">

      <div class="container"> 

        <div class="cat-cont" style="background-color: #D9D9D9; border-radius: 20px; height: 625px;">
            <p class="category-title" style="font-size: 40px; font-weight: 700; text-align: center; color: #061E39; margin-top: 70px;margin-bottom: 35px; padding-top: 30px;">Browse by Category</p>
                <div class="grid-products" action="search.php" style="display: grid; grid-template-columns: repeat(3, 1fr); grid-gap: 30px; margin: 30px; padding-bottom: 30px;" role="menu">
                    <div class="grid-item" data-text="lanyard" href="category.php?category=lanyard">
                        <div class="grid-item-inner" >
                            <p>LANYARD</p>
                        </div>
                        <div class="grid-item-inner">
                            <img src="../customer_assets/images/products/lanyard2.png">
                        </div>
                    </div>
                    <div class="grid-item" data-text="shirt">
                        <div class="grid-item-inner">
                            <p data-text="shirt">T-SHIRT</p>
                        </div>
                        <div class="grid-item-inner">
                            <img src="../customer_assets/images/products/shirt.png">
                        </div>
                    </div>
                    <div class="grid-item" data-text="stickers">
                        <div class="grid-item-inner">
                            <p  data-text="stickers">STICKERS</p>
                        </div>
                        <div class="grid-item-inner">
                            <img src="../customer_assets/images/products/sticker.svg">
                        </div>
                    </div>
                    <div class="grid-item" data-text="tote bag">
                        <div class="grid-item-inner">
                            <p data-text="tote bag">TOTE BAG</p>
                        </div>
                        <div class="grid-item-inner">
                            <img src="../customer_assets/images/products/tote_bag.svg">
                        </div>
                    </div>
                    <div class="grid-item" data-text="pins">
                        <div class="grid-item-inner">
                            <p data-text="pins">PINS</p>
                        </div>
                        <div class="grid-item-inner">
                            <img src="../customer_assets/images/products/pins.svg">
                        </div>
                    </div>
                    <div class="grid-item" data-text="key strap">
                        <div class="grid-item-inner">
                            <p data-text="key strap">KEY STRAP</p>
                        </div>
                        <div class="grid-item-inner">
                            <img src="../customer_assets/images/products/key_strap.svg">
                        </div>
                    </div>
                </div>
            <a href="#" class="cat-btn">View All</a>
        </div>

      </div>

    </div>
    
</main>
    <?php include 'footer.php'; ?>
    <!-- Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Show/hide dropdown menu when button is clicked
        $(document).ready(function(){
            $("#cartDropdown").click(function(){
            $(".dropdown-menu").toggle();
            });
        });

        // Close the dropdown menu if the user clicks outside of it
        $(document).click(function(event) {
            var dropdown = $(".dropdown");
            if (!dropdown.is(event.target) && dropdown.has(event.target).length === 0) {
            $(".dropdown-menu").hide();
            }
        });
    </script>

    <?php include '../includes/scripts.php'; ?>
	<!--- custom js link-->
    <script src="../customer_assets/js/script.js"></script>
    <!--- ionicon link-->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>