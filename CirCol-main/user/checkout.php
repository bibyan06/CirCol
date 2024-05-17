<?php include '../includes/session.php'; ?>

<?php
// Initialize $items as an empty array
$items = [];
$gcashNumber = "";
$gcashQr = "";

// Check if the 'items' parameter is set in the URL
if(isset($_GET['items'])) {
    // Decode the JSON data from the 'items' parameter and store it in $items
    $items = json_decode(urldecode($_GET['items']), true);

    // Retrieve gcashNumber and gcashQr from the query parameters
    $gcashNumber = isset($_GET['gcashNumber']) ? urldecode($_GET['gcashNumber']) : "";
    $gcashQr = isset($_GET['gcashQr']) ? urldecode($_GET['gcashQr']) : "";

    // Calculate the total value
    $totalValue = 0;
    foreach ($items as $item) {
        $totalValue += $item['subtotal'];
    }
}
?>

<!DOCTYPE html>
<html>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> - CHECKOUT</title>
  	<link rel="stylesheet" href="cart.css">
	<!--- favicon -->
    <link rel="shortcut icon" href="../customer_assets/images/logo/favicon.ico" type="image/x-icon">
    <!--- custom css link -->
    <link rel="stylesheet" href="../customer_assets/css/style-prefix.css">
    <!--- google font link-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
            
    <style>
        /* HEADER!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
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
            margin-right: -5px;
        }
        .rounded-circle{
            border-radius: 50%;
            max-width: 40px; 
            margin-right: -15px;
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

        /* MOBILE NAVIGATION BAR */
        .mobile-menu-category-list .menu-category {
            border-bottom: 1px solid var(--cultured);
            text-align: left;
        }
        /* Style for the overlay */
        .mobile-navigation-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0); /* Initially fully transparent */
            z-index: 15; /* Ensure it appears below the menu but above other content */
            opacity: 0; /* Initially hidden */
            pointer-events: none; /* Allow clicks to pass through the overlay */
            transition: opacity 0.3s ease-in-out, background-color 0.3s ease-in-out; /* Smooth transition for opacity and background color */
        }
        /* Apply the active class to show the overlay */
        .mobile-navigation-overlay.active {
            opacity: 0.5; /* Semi-transparent */
            pointer-events: auto; /* Enable clicks on the overlay */
            background-color: rgb(0 0 0 / 79%); /* Semi-transparent black background */
        }
        .submenu-category-list.active {
            max-height: 300px;
            visibility: visible;
        }
        /* Apply the active class to show the menu */
        .mobile-navigation-menu.active {
            left: 0; /* Slide the menu into view */
        }
        /* MOBILE NAVIGATION BAR SOCIAL MEDIA*/
        .menu-social-container ion-icon{
            color: black;
            margin-right: 0px;
        }
        .mobile-bottom-navigation {
            z-index: 1000;
        }
        .menu-category0{
            display: none;
        }
        .menu-category{
            cursor: pointer;
        }
        .desktop-menu-category-list {
            gap: 50px;
        }
        /* HEADER!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/

        /***CHECK OUT CSS*/
        h2 {
            margin-bottom:0px;
            margin-top:25px;
            text-align:center;
            font-weight:200;
            font-size:19px;
            font-size:1.2rem;
        }
        .main-container {
            height:100%;
            -webkit-box-pack:center;
            -webkit-justify-content:center;
                -ms-flex-pack:center;
                    justify-content:center;
            -webkit-box-align:center;
            -webkit-align-items:center;
                -ms-flex-align:center;
                    align-items:center;
            display:-webkit-box;
            display:-webkit-flex;
            display:-ms-flexbox;
            display:flex;
            padding: 0 15px 60px 15px;
        }
        .dropdown-select.visible {
            display:block;
        }
        .dropdown {
            position:relative;
        }
        ul {
            margin:0;
            padding:0;
        }
        ul li {
            list-style:none;
            padding-left:10px;
            cursor:pointer;
        }
        ul li:hover {
            background:rgba(255,255,255,0.1);
        }
        .dropdown-select {
            position:absolute;
            background:#77aaee;
            text-align:left;
            box-shadow:0px 3px 5px 0px rgba(0,0,0,0.1);
            border-bottom-right-radius:5px;
            border-bottom-left-radius:5px;
            width:90%;
            left:2px;
            line-height:2em;
            margin-top:2px;
            box-sizing:border-box;
        }
        .thin {
            font-weight:400;
        }
        .small {
            font-size:12px;
            font-size:.8rem;
        }
        .half-input-table {
            border-collapse:collapse;
            width:100%;
        }
        .half-input-table td:first-of-type {
            border-right:10px solid #4488dd;
            width:50%;
        }
        .window {
            height: 670px;
            width: 900px;
            background:#fff;
            display:-webkit-box;
            display:-webkit-flex;
            display:-ms-flexbox;
            display:flex;
            box-shadow: 0px 15px 50px 10px rgba(0, 0, 0, 0.2);
            border-radius:30px;
        }
        .order-info {
            height:100%;
            width:50%;
            padding-left:25px;
            padding-right:25px;
            box-sizing:border-box;
            display:-webkit-box;
            display:-webkit-flex;
            display:-ms-flexbox;
            display:flex;
            -webkit-box-pack:center;
            -webkit-justify-content:center;
                -ms-flex-pack:center;
                    justify-content:center;
            position:relative;
        }
        .price {
            bottom:0px;
            position:absolute;
            right:0px;
            color:#4488dd;
        }
        .order-table td:first-of-type {
            width:25%;
        }
        .order-table {
            position:relative;
        }
        .line {
            height:1px;
            width:100%;
            margin-top:10px;
            margin-bottom:10px;
            background:#ddd;
        }
        .order-table td:last-of-type {
            vertical-align:top;
            padding-left:25px;
        }
        .order-info-content {
            table-layout:fixed;
        }

        .full-width {
            width:100%;
        }
        .pay-btn {
            border:none;
            background:#22b877;
            line-height:2em;
            border-radius:10px;
            font-size:19px;
            font-size:1.2rem;
            color:#fff;
            cursor:pointer;
            position:absolute;
            bottom:25px;
            width:calc(100% - 50px);
            -webkit-transition:all .2s ease;
                    transition:all .2s ease;
        }
        .pay-btn:hover {
            background:#22a877;
                color:#eee;
            -webkit-transition:all .2s ease;
                    transition:all .2s ease;
        }

        .total {
            margin-top:25px;
            font-size:20px;
            font-size:1.3rem;
            position:absolute;
            bottom:30px;
            right:27px;
            left:35px;
        }
        .dense {
            line-height:1.2em;
            font-size:16px;
            font-size:1rem;
        }
        .input-field {
            background:rgba(255,255,255,0.1);
            margin-bottom:10px;
            margin-top:3px;
            line-height:1.5em;
            font-size: 0.8rem;
            border:none;
            padding:5px 10px 5px 10px;
            color:#fff;
            box-sizing:border-box;
            width:100%;
            margin-left:auto;
            margin-right:auto;
        }
        .credit-info {
            background:#4488dd;
            height:100%;
            width:50%;
            color:#eee;
            -webkit-box-pack:center;
            -webkit-justify-content:center;
                -ms-flex-pack:center;
                    justify-content:center;
            font-size:14px;
            font-size:.9rem;
            display:-webkit-box;
            display:-webkit-flex;
            display:-ms-flexbox;
            display:flex;
            box-sizing:border-box;
            padding-left:25px;
            padding-right:25px;
            border-top-right-radius:30px;
            border-bottom-right-radius:30px;
            position:relative;
        }
        .dropdown-btn {
            background:rgba(255,255,255,0.1);
            width:100%;
            border-radius:5px;
            text-align:center;
            line-height:1.5em;
            cursor:pointer;
            position:relative;
            -webkit-transition:background .2s ease;
                    transition:background .2s ease;
        }
        .dropdown-btn:after {
            content: '\25BE';
            right:8px;
            position:absolute;
        }
        .dropdown-btn:hover {
            background:rgba(255,255,255,0.2);
            -webkit-transition:background .2s ease;
                    transition:background .2s ease;
        }
        .dropdown-select {
            display:none;
        }
        .credit-card-image {
            display:block;
            max-height:80px;
            margin-left:auto;
            margin-right:auto;
            margin-top:35px;
            margin-bottom:15px;
        }
        @media (max-width: 600px) {
            .credit-card-image {
                width: 100%;
            }
        }
        
        .credit-info-content {
            margin-top:25px;
            -webkit-flex-flow:column;
                -ms-flex-flow:column;
                    flex-flow:column;
            display:-webkit-box;
            display:-webkit-flex;
            display:-ms-flexbox;
            display:flex;
            width:100%;
        }
        @media (max-width: 600px) {
            .window {
                width: 100%;
                height: 100%;
                display:block;
                border-radius:0px;
            }
            .order-info {
                width:100%;
                height:auto;
                padding-bottom:100px;
                border-radius:0px;
            }
            .credit-info {
                width:100%;
                height:auto;
                padding-bottom:100px;
                border-radius:0px;
            }
            .pay-btn {
                border-radius:0px;
            }
        }


        .gcash_qr{
            margin-left: auto;
            margin-right: auto;
            margin-bottom: 15px;
        }

        .hidden {
            display: none;
        }


        /** ALERT CSS */
        .alert {
            padding: 8px 16px;
            font-size: 25px;
            font-weight: 500;
            border-radius: 4px;
            border: none;
            outline: none;
            /* background: #e69100; */
            color: white;
            letter-spacing: 1px;
            position: fixed;
            z-index: 1000;
            right: -100%; /* Start from outside of the screen */
            top: 21px;
            animation: show_slide 1s ease forwards;
        }

        .hide {
            display: none;
        }

        .Warning {
            background: #ffdb9b;
        }

        @keyframes show_slide {
            0% {
                right: -100%; /* Start from outside of the screen */
            }
            40% {
                right: 10%; /* Move in slightly */
            }
            80% {
                right: 0; /* Arrive at final position */
            }
            100% {
                right: 10px; /* Slight bounce effect */
            }
        }

        @keyframes hide_slide {
            0% {
                right: 10px; /* Slight bounce effect */
            }
            40% {
                right: 0; /* Return to normal position */
            }
            80% {
                right: 10%; /* Move out slightly */
            }
            100% {
                right: -100%; /* Move outside of the screen */
            }
        }

        .alert .fa-exclamation-circle {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #ce8500;
            font-size: 30px;
        }

        .alert .msg {
            padding: 0 25px;
            font-size: 18px;
            display: inline-block;
        }

        .alert .close-btn {
            position: absolute;
            right: 0px;
            top: 50%;
            transform: translateY(-50%);
            padding: 8px 10px;
            cursor: pointer;
        }

        .alert .close-btn:hover {
            background: #ffc766;
        }

        .alert .close-btn .fas {
            color: #ce8500;
            font-size: 22px;
            line-height: 40px;
        }

        .scroll-table{
            overflow-y: scroll;
            height: 460px;
        }
    </style>

<body>

<!-- Define the hideAlertMessage() function globally -->
<script>
    function hideAlertMessage() {
        var alertContainer = document.getElementById('alertMessageContainer');
        alertContainer.classList.add('hide');
    }
</script>

<!-- Your HTML content -->
<div class="alert hide Warning" id="alertMessageContainer">
    <span class="" id="alertIcon"></span>
    <div class="msg" id="alertMessage"></div>
    <button class="close-btn"><span onclick="hideAlertMessage()">&times;</span></button>
</div>

<div class="overlay" data-overlay></div>
    <!--- MODAL-->
    <div data-modal>
        <div  data-modal-overlay></div>
            <div>
                <button data-modal-close>
                </button>
            </div>
        </div>
        <div data-toast>
            <button data-toast-close>
            </button>
        </div>
    </div>

<header>
    <div class="header-main">
        <div class="container">
            <a href="#" class="header-logo">
                <img src="../customer_assets/images/logo/ebuy_logo.svg" alt="Anon's logo" width="180" height="40">
            </a>

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

            <div class="header-user-actions">
                <button class="action-btn wish-heart">
                    <a href="notifs.php"><ion-icon name="notifications-outline" id="notificationsIcon"></ion-icon></a>
                    <span class="count"><?php echo $unreadNotificationCount; ?></span>
                </button>

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
                
                <button class="action-btn wish-heart">
                    <a href="wishlist.php"><ion-icon name="heart-outline"></ion-icon></a>
                    <span class="count"><?php echo $wishlistCount; ?></span>
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
                <a href="shop_filter.php" class="menu-title">Shops</a>
            </li>

            <li class="menu-category">
                <a href="about.php" class="menu-title">About</a>
            </li>
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
                    <a href="shop_filter.php" class="menu-title">Shops</a>
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

<br>
<div class='main-container'>
    <div class='window'>
        <div class='order-info'>
            <div class='order-info-content'>
                <h2>Order Summary</h2>
                <div class='line'></div>
                <div class="scroll-table" id="tableWrapper">
                    <table class='order-table'>
                        <tbody>
                            <?php foreach($items as $item): ?>
                                <tr>
                                    <td>
                                        <?php if(isset($item['image']) && isset($item['name'])): ?>
                                            <img src="<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" class="full-width">
                                        <?php else: ?>
                                            <span class='thin'>Image Not Available</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <br> <span class='thin'><?php echo $item['name']; ?></span>
                                        <br><?php echo $item['price']; ?>
                                        <br><?php echo '₱' . number_format($item['subtotal'], 2); ?><br> 
                                        <span class='thin small'><?php echo $item['quantity']; ?><br><br></span>
                                        <span class='thin small hidden'>Seller ID:<?php echo $item['sellerId']; ?></span><br>
                                        <span class='thin small hidden'>Product ID:<?php echo $item['productId']; ?></span><!-- Outputting productId -->
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class='price'></div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <script>
                    window.addEventListener('DOMContentLoaded', function() {
                        var tableWrapper = document.getElementById('tableWrapper');
                        
                        // Check if the content of the table overflows the container
                        function checkOverflow() {
                            if (tableWrapper.scrollHeight > tableWrapper.clientHeight) {
                            tableWrapper.style.overflowY = 'scroll'; // Display scrollbar
                            } else {
                            tableWrapper.style.overflowY = 'hidden'; // Hide scrollbar
                            }
                        }

                        // Check overflow initially and on window resize
                        checkOverflow();
                        window.addEventListener('resize', checkOverflow);
                    });
                </script>
                <div class='line'></div>
                <div class='total'>
                    <span style='float:left;'>
                        <div class='thin dense'>VAT 19%</div>
                        <div class='thin dense'>Discount</div>
                        TOTAL
                    </span>
                    <span style='float:right; text-align:right;'>
                        <div class='thin dense'>₱68.75</div>
                        <div class='thin dense'>0%</div>
                        <td>₱<?php echo number_format($totalValue, 2); ?></td>
                    </span>
                </div>
            </div>
        </div>

        <div class='credit-info'>
            <div class='credit-info-content'>
                <img src='https://prd-mktg-konghq-com.imgix.net/images/2023/11/6553cc4c-gcash-logo-svg.png?auto=format&fit=max&w=2560' height='80' class='credit-card-image' id='credit-card-image'></img>
                <div class='gcash_qr'>
                    <img height='200' src="../images/Gcash_QR/<?php echo $gcashQr; ?>" alt="Gcash QR Code"> <!-- Output the Gcash QR here -->
                </div>
                <div>
                    Gcash Account Number: <?php echo $gcashNumber; ?> <!-- Output the Gcash account number here -->
                </div>
                <br>
                <form action="pay.php" method="post">
                    <?php foreach($items as $item): ?>
                        <input type="hidden" name="seller_id[]" value="<?php echo $item['sellerId']; ?>">
                        <input type="hidden" name="product_id[]" value="<?php echo $item['productId']; ?>">
                        <input type="hidden" name="quantity[]" value="<?php echo $item['quantity']; ?>">
                    <?php endforeach; ?>

                    <input type="hidden" name="total_value" value="<?php echo number_format($subtotal, 2); ?>">
                    
                    <div>
                        Gcash Account Name
                        <input class='input-field' type="text" name="gcash_account_name" required>
                    </div>
                    <div>
                        Reference No.
                        <input class='input-field' type="text" name="reference_no" required>
                    </div>
                    <button type="submit" class='pay-btn'>Place Order</button>
                </form>
            </div>
        </div>
    </div>
</div>
    <!--- ALERT SCRIPT --->
    <script>
        // Define showAlertMessage and hideAlertMessage functions
        function showAlertMessage(message, type) {
            var alertContainer = document.getElementById('alertMessageContainer');
            var alertMessage = document.getElementById('alertMessage');
            
            // Update alert message content
            alertMessage.textContent = message;

            // Show the alert
            alertContainer.classList.remove('hide');

            // Hide the alert after 5 seconds
            setTimeout(hideAlertMessage, 5000);
        }
    </script>

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