<?php include '../includes/session.php'; ?>

<!DOCTYPE html>
<html>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carts</title>
    <link rel="shortcut icon" type="x-icon" href="../customer_assets/images/about.svg">

    <!--CSS for Cart Icon-->
  	<link rel="stylesheet" href="cart.css">
    <!--- custom css link -->
    <link rel="stylesheet" href="../customer_assets/css/style-prefix.css">
    <!--- google font link-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
            
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
            margin-left: 400px;

        }

        @media (min-width: 768px) {
            .cat_list {
                margin-left: 400px;
            }
        }

        @media (min-width: 1024px) {
            .cat_list {
                margin-left: 320px;
            }
        }

        @media (min-width: 1200px) {
            .cat_list {
                margin-left: 400px;
            }
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

        .mobile-menu-category-list.active {
            margin-bottom: 30px;
        }

        /* Apply the active class to show the overlay */
        .mobile-navigation-overlay.active {
            opacity: 0.5; /* Semi-transparent */
            pointer-events: auto; /* Enable clicks on the overlay */
            background-color: rgb(0 0 0 / 79%); /* Semi-transparent black background */
        }

        /* Apply the active class to show the menu */
        .mobile-navigation-menu.active {
            left: 0; /* Slide the menu into view */
        }

        .submenu-category-list.active {
            max-height: 300px;
            visibility: visible;
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
        .desktop-menu-category-list {
            gap: 50px;
        }
        /* HEADER!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/

		/** For CART */
        /*
		.thumbnail {
			margin-left: 20px;
			margin-top: -5px;
		}
        */
		.menu{
			margin-top: 20px;
		}
		/* CSS for making img, h4, and p in the same line */
		.main_cart {
			list-style: none;
			margin: 10px 0;
		}
		.main_cart a {
			display: flex;
			align-items: center;
			text-decoration: none;
			color: #333; /* Adjust text color as needed */
		}
		.cart {
			margin-right: 10px; /* Adjust margin as needed */
		}

        /* Remove if not needed */
		.thumbnail {
			max-width: 80px; /* Adjust the maximum width of the image as needed */
			height: auto;
			border-radius: 4px; /* Optional: Add border-radius for rounded corners */
		}

		h4, p {
			margin: 0; /* Remove default margin for h4 and p */
		}
		/* Style for h4 and small within the anchor tag */
		h4 {
			font-size: 16px; /* Adjust font size as needed */
			margin-top: -10px;
		}
		h4:hover{
			color: pink;
		}
		small {
			font-size: 12px; /* Adjust font size as needed */
			color: #888; /* Adjust color as needed */
		}
		table {
			border-collapse: collapse !important;
    		border: none !important;
		}
		/* Optional: If you want to remove borders for table cells as well */
		table, th, td{
			border: none !important;
			padding: 10px;
		}
		.item{
			margin-top: 15px !important;
            text-align: center !important;
		}
		.cart_img{
			border: 1px solid #ddd;
			border-radius: 5px;
			padding: 10px;
		}
		.total_value{
			border-top: 1px solid gray;
		}
		.value{
			margin-top: 15px !important;
		}
		.subtotal{
			margin-left: 100px;
		}
        h1 {
            text-align: center;
            color: #343a40;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        .cart_items{
            padding: 15px;
            display: flex;
        }
        li {
            align-items: center;
        }
        img {
            /** max-width: 150px; */
            margin-right: 10px;
            border-radius: 4px;
        }
        .product-details {
            flex-grow: 1;
        }
        .product-name {
            font-size: 18px;
            color: #343a40;
            margin-bottom: 5px;
        }
        .product-price {
            font-size: 16px;
            color: #6c757d;
        }
        .quantity{
			max-width: 40%;
            height: 29px;
			border: 1px solid #dee2e6;
		}
		.input-group1{
			margin-top: 25px;
			justify-content: center;
			position: relative;
			display: flex;
			border-collapse: separate;
		}
        .heart-button,
        .delete-button {
            cursor: pointer;
            font-size: 20px;
            margin-left: auto;
            color: #6c757d;
            margin-right: 10px;
        }
        @media (max-width: 600px) {
            li {
                flex-direction: column;
                align-items: flex-start;
            }

            img {
                margin-bottom: 10px;
                max-width: 150px;
            }

            .product-name,
            .product-price {
                margin: 5px 0;
            }

            .heart-button,
            .delete-button {
                margin-left: 0;
                margin-top: 10px;
            }

            .item-checkbox{
                position: absolute;
                margin-top: 5px;
                transform: scale(1.3);
            }

            .mycart {
                width: 100% !important;
            }

            tr{
                font-size: 8px;
            }

            td .item-checkbox{
                width: 10px;
                font-size: 10px;
                height: 10px;
                margin-top: -10px;
            }

            td img{
                width: 40px;
                height: 40px;
            }

            .input-group1 {
                margin-top: 10px;
                display: flex;
            }

            .quantity {
                max-width: 30%;
                height: 15px;
                margin-top: 7px;
            }

            .total_value{
                font-size: 12px;
            }
            .total-value2{
                font-size: 15px;
                font-weight: 600;
            }

            td button ion-icon{
                width: 15px;
            }
        }
        .item-checkbox{
            width: 5%;
        }
        .heart_trash{
            margin-top: 10px;
        }
        .heart{
            font-size: 25px;
			margin-left: 20px;
        }
        .trash{
            font-size: 25px;
			margin-left: 20px;
        }
        .subtract{
            font-size: 20px;
			font-weight: 700px;
			margin-left: -20px;
			margin-top: 5px;

        }
        .add{
            font-size: 20px;
			margin-top: 3px;
        }
        .item-quantity{
            max-width: 20%;
        }
		.checkout{
			background-color: #8ecd8e;
			border-radius: 4px;
			padding: 5px 10px;
			font-weight: 600;
		}
		.checkout:hover{
			color: white;
		}
		.item-checkbox{
			width: 15px; /* Adjust the width as needed */
			font-size: 16px; /* Increase the font size for a bigger input */
			height: 15px; /* Adjust the height as needed */
			border-radius: 4px;
			border: 2px solid gray;
			margin: 0 5px; /* Add margin for spacing */
			text-align: center; /* Center the text within the input */
		}
		.total-value{
			font-weight: 600;
			font-size: 20px;
		}
		.total-value h4{
			font-size: 20px;
		}
        /** POP-UP CONTAINER FOR CHECK OUT */
        /* Keyframe animation for smooth scale-up */
        @keyframes scaleUp {
            from {
                transform: scale(0); /* Start from no scale (hidden) */
                opacity: 0; /* Start from fully transparent */
            }
            to {
                transform: scale(1); /* Scale up to normal size */
                opacity: 1; /* Fully opaque */
            }
        }

        /* Apply the animation to your pop-up */
        .popup {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            transform: translate(0, 0) scale(0); /* Set initial position to center and initial scale to 0 */
            background-color: white;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            width: 100%;
            max-width: 800px;
            animation: scaleUp 0.5s ease-in-out forwards; /* Apply the animation with ease-in-out timing */
            height: 60%;
            border-radius: 4px;
        }
        /**
        .popup.active {
            display: block; //Show the pop-up when active
        }
        **/
        /* Add a gray line after each item */
        .selected_item {
            border-bottom: 1px solid #ccc;
            padding-bottom: 10px; /* Adjust padding as needed */
            margin-bottom: 10px; /* Adjust margin as needed */
        }
        .popup-content {
            margin: 0 auto;
        }
        .close-popup {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 20px;
            cursor: pointer;
        }
        #popup-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }
        #select_img img {
            max-width: 100%; /* Ensure the image fits within the container */
        }
        #selected-items-table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        #selected-items-table th, #selected-items-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        #selected-items-table th {
            background-color: #f2f2f2;
        }
        #selected-items-table {
            height: 320px;
            overflow-y: auto;
            display: block; /* Ensure block display to trigger the overflow */
            background-color: #e0e1e629;
        }
        .selected-items-table {
            background-color: #eee;
            width: 200px;
            height: 100px;
            overflow-y: scroll; /* Add the ability to scroll */
            display: block; /* Ensure block display to trigger the overflow */
            background-color: #e0e1e629;
        }
        /* Hide scrollbar for Chrome, Safari and Opera */
        .selected-items-table::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        .selected-items-table {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        .checkout_logo {
            display: block;
            margin: 0 auto;
        }
        .total-container {
            text-align: center; /* Center the text */
            margin-top: 20px; /* Add some top margin for spacing */
        }
        #totalValue {
            display: inline-block; /* Ensure it's displayed as a block element */
            margin-left: 5px; /* Add some left margin for spacing */
            color: black; /* Set the color to black or a color that contrasts with the background */
            font-weight: bold; /* Make the text bold for better visibility */
        }
        .pay{
            margin: auto;
            margin-top: 2rem;
            background-color: #bbdeb0;
            padding: 6px 12px;
            border-radius: 4px;
            font-weight: 600;
        }
        #total-value{
            text-align: center;
        }

        /**View Cart CSS */
        .mycart {
            width: 65%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        /* Box styles */
        .box {
            border: solid 1px #ddd;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .box-solid {
            background-color: #fafafa;
        }
        .box-body {
            padding: 15px;
        }
        /* Table styles */
        .table {
            width: 100%;
            margin-bottom: 20px;
        }
        .table thead th {
            background-color: #f5f5f5;
            color: #333;
            padding: 5px;
        }
        .table tbody td {
            padding: 10px;
            border-bottom: solid 1px #ddd;
        }
        .cart_tr{
            text-align: center;
        }


        /** ALERT */
        .alert {
            display: flex;
            padding: 8px 16px;
            font-size: 25px;
            font-weight: 500;
            border-radius: 4px;
            border: none;
            outline: none;
            /* background: #e69100; */
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
            background: #f8d7da;
            color: #721c24;
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
            padding: 0 10px;
            font-size: 18px;
            display: inline-block;
            padding: 0 20px 0 10px;
        }

        .alert .close-btn {
            position: absolute;
            color: #721c24;
            right: 0px;
            top: 50%;
            transform: translateY(-50%);
            padding: 0 5px;
            cursor: pointer;
        }

        .alert .close-btn:hover {
            color: #ffc766;
        }

        .alert .close-btn .fas {
            color: #ce8500;
            font-size: 22px;
            line-height: 40px;
        }
        /* Define styles for different alert types */
        .error {
            background: #f8d7da; /* Red color for error alerts */
            color: #721c24;
        }
        .warning {
            background: #fff3cd; /* Yellow color for warning alerts */
            color: #d09404;
        }
        .success {
            background: #d4edda; /* Green color for success alerts */
            color: #155724;
        }
        .success_icon ion-icon{
            color: #155724;
        }
        .warning_icon ion-icon{
            color: #d09404;
        }
        .error_icon ion-icon{
            color: #721c24;
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
<?php
    // Check if an alert message is present in the URL parameter
    if(isset($_GET['alert'])) {
        // Display the alert message
        echo "<script>showAlertMessage('" . htmlspecialchars($_GET['alert']) . "', 'success');</script>";
    }
?>
<?php
    // Check if the order was successfully placed
    if (isset($_SESSION['order_placed']) && $_SESSION['order_placed']) {
        // Unset the session variable to avoid showing the message again on page refresh
        unset($_SESSION['order_placed']);

        // Set a variable to hold the message and type
        $message = "Order placed successfully.";
        $type = "success";
    }
?>
<!-- Your HTML content -->
<div class="alert hide" id="alertMessageContainer">
    <span class="icon"></span>
    <div class="msg" id="alertMessage"><?php echo isset($message) ? $message : ''; ?></div>
    <button class="close-btn"><span onclick="hideAlertMessage()">&times;</span></button>
</div>
<!--- ALERT SCRIPT --->
<script>
    // Define showAlertMessage functions for different types
    function showSuccessAlert(message) {
        showAlertMessage(message, 'success');
    }

    function showErrorAlert(message) {
        showAlertMessage(message, 'error');
    }

    function showWarningAlert(message) {
        showAlertMessage(message, 'warning');
    }

    // Define showAlertMessage function
    function showAlertMessage(message, type) {
        var alertContainer = document.getElementById('alertMessageContainer');
        var alertMessage = document.getElementById('alertMessage');
        var icon = alertContainer.querySelector('.icon');

        // Update alert message content
        alertMessage.textContent = message;

        // Set icon based on type
        if (type === 'success') {
            icon.innerHTML = '<div class="success_icon"><ion-icon name="checkmark-circle-outline"></ion-icon></div>';
        } else if (type === 'error') {
            icon.innerHTML = '<div class="error_icon"><ion-icon name="alert-circle-outline"></ion-icon></div>';
        } else if (type === 'warning') {
            icon.innerHTML = '<div class="warning_icon"><ion-icon name="alert-circle-outline"></ion-icon></div>';
        }

        // Remove existing alert types
        alertContainer.classList.remove('error', 'warning', 'success');

        // Add appropriate alert type
        if (type === 'error') {
            alertContainer.classList.add('error');
        } else if (type === 'warning') {
            alertContainer.classList.add('warning');
        } else if (type === 'success') {
            alertContainer.classList.add('success');
        }

        // Show the alert
        alertContainer.classList.remove('hide');

        // Hide the alert after 5 seconds
        setTimeout(hideAlertMessage, 5000);
    }

    // Call showAlertMessage function if message is set
    <?php echo isset($message) ? "showSuccessAlert('$message');" : ''; ?>
</script>

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

<main>
    <div class="mycart">
		<div class="box box-solid">
			<div class="box-body">
			<table class="table table-bordered">
				<thead>
					<tr>
                        <th>CheckBox</th>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Shop</th>
                        <th></th>
                        <th></th>
					</tr>
				</thead>
				<tbody id="tbody">
				</tbody>
			</table>
			</div>
		</div>
	</div>

	<?php $pdo->close(); ?>

	<!--- THIS IS THE EXCHANGE OF includes/scripts.php --->

	<!-- jQuery 3 -->
	<script src="../customer_assets/jquery/dist/jquery.min.js"></script>

	<script>
        $(function () {
            // Datatable
            $('#example1').DataTable()
            //CK Editor
            CKEDITOR.replace('editor1')
        });
	</script>

	<!--- THIS IS THE EXCHANGE OF includes/scripts.php --->

    <script>
        var total = 0;

        $(function () {
            $(document).on('click', '.cart_delete', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    type: 'POST',
                    url: 'cart_delete.php',
                    data: { id: id },
                    dataType: 'json',
                    success: function (response) {
                        if (!response.error) {
                            getDetails();
                            getTotal();
                            // Reload for Delete
                            location.reload();
                        }
                    }
                });
            });

            $(document).on('click', '.minus', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                var qty = $('#qty_' + id).val();
                if (qty > 1) {
                    qty--;
                }
                $('#qty_' + id).val(qty);
                updateCartItem(id, qty);
            });

            $(document).on('click', '.add', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                var qty = $('#qty_' + id).val();
                qty++;
                $('#qty_' + id).val(qty);
                updateCartItem(id, qty);
            });

            $(document).on('change', '.item-checkbox', function () {
                getTotal(); // Recalculate total when a checkbox is changed
            });

            getDetails();
            getTotal();
        });

        function updateCartItem(id, qty) {
            $.ajax({
                type: 'POST',
                url: 'cart_update.php',
                data: {
                    id: id,
                    qty: qty,
                },
                dataType: 'json',
                success: function (response) {
                    if (!response.error) {
                        getDetails();
                        getTotal();
                    }
                }
            });
        }

        function getDetails() {
            $.ajax({
                type: 'POST',
                url: 'cart_details.php',
                dataType: 'json',
                success: function (response) {
                    $('#tbody').html(response);
                }
            });
        }

        function getTotal() {
            var selectedItems = $('.item-checkbox:checked');
            total = 0;

            selectedItems.each(function () {
                var id = $(this).closest('.item').find('.cartid').data('id');
                var qty = parseInt($('#qty_' + id).val(), 10);
                var subtotal = parseFloat($('#subtotal_' + id).text().replace('₱ ', '').replace(',', ''));
                total += subtotal * qty;
            });

            // Update the total value in the HTML
            $('#total_value').text(total.toFixed(2));
        }
    </script>

    <script>
        function updateTotal(checkbox, subtotal) {
            // Display the dynamically updated total value
            var totalElement = document.getElementById('totalValue');
            var currentTotal = parseFloat(totalElement.innerText.replace('', '').replace(',', '')) || 0;

            if (checkbox.checked) {
                // Checkbox is checked, add the subtotal
                currentTotal += subtotal;
            } else {
                // Checkbox is unchecked, subtract the subtotal
                currentTotal -= subtotal;
            }

            // Ensure the total is not negative
            currentTotal = Math.max(currentTotal, 0);

            // Format the new total with two decimal places
            var formattedTotal = currentTotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');

            // Update the HTML content
            totalElement.innerHTML = '<b>' + formattedTotal + '</b>';
        }
        
        function closePopup() {
            // Hide the pop-up container and overlay
            var popupContainer = document.getElementById('popup-container');
            var overlay = document.getElementById('popup-overlay');

            popupContainer.style.display = 'none';
            overlay.style.display = 'none';
        }
    </script>

    <script>
        function redirectToCheckout() {
            var selectedItems = [];
            var checkboxes = document.querySelectorAll('.item-checkbox');

            checkboxes.forEach(function (checkbox) {
                if (checkbox.checked) {
                    var row = checkbox.closest('tr');
                    if (row) {
                        var imageElement = row.querySelector('img');
                        var imageSrc = imageElement ? imageElement.src : ''; // Get the src attribute of the img element
                        var name = row.querySelector('td:nth-child(3)').textContent;
                        var price = parseFloat(row.querySelector('td:nth-child(4)').textContent.replace('₱', '').replace(',', ''));
                        var quantity = parseInt(row.querySelector('.quantity').value);
                        var sellerId = row.dataset.sellerId; // Retrieve seller ID from data attribute
                        var gcashNumber = row.dataset.gcashNumber; // Retrieve gcash number from data attribute
                        var gcashQr = row.dataset.gcashQr; // Retrieve gcash qr from data attribute
                        var productId = row.querySelector('td:nth-child(8)').textContent; // Retrieve product_id

                        // Check if sellerId, gcashNumber, gcashQr, and productId are fetched correctly
                        if (!sellerId || !gcashNumber || !gcashQr || !productId) {
                            alert('Error: Seller ID, Gcash Number, Gcash QR, or Product ID not fetched correctly');
                            showAlertMessage('Error: Seller ID, Gcash Number, Gcash QR, or Product ID not fetched correctly', );
                            return;
                        }

                        // Calculate subtotal
                        var subtotal = price * quantity;

                        selectedItems.push({ name: name, price: price, quantity: quantity, subtotal: subtotal, image: imageSrc, sellerId: sellerId, gcashNumber: gcashNumber, gcashQr: gcashQr, productId: productId });

                        // Alert the product_id
                        //alert('Product ID: ' + productId);
                    }
                }
            });

            if (selectedItems.length > 0) {
                var sellerIds = selectedItems.map(item => item.sellerId);
                var uniqueSellers = [...new Set(sellerIds)];

                if (uniqueSellers.length > 1) {
                    showAlertMessage('This platform does not cater to cross-buying. You can check out from the same seller only', 'warning');
                } else {
                    // Calculate total value
                    var totalValue = selectedItems.reduce(function (total, item) {
                        return total + item.subtotal;
                    }, 0);

                    // Serialize selected items as JSON and encode for URL
                    var selectedItemsJSON = encodeURIComponent(JSON.stringify(selectedItems));

                    // Retrieve gcashNumber and gcashQr from the first selected item
                    var gcashNumber = selectedItems[0].gcashNumber;
                    var gcashQr = selectedItems[0].gcashQr;

                    // Redirect to checkout.php with selected items data and gcashNumber, gcashQr as query parameters
                    window.location.href = 'checkout.php?items=' + selectedItemsJSON + '&gcashNumber=' + encodeURIComponent(gcashNumber) + '&gcashQr=' + encodeURIComponent(gcashQr);
                }
            } else {
                showAlertMessage('No items selected for checkout.', 'error');
            }
        }
    </script>
</main>
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

    <!---------
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get the button that opens the mobile menu
            var openButton = document.getElementById("mobilebar_btn");
            // Get the mobile navigation menu
            var mobileMenu = document.getElementById("mobilebar_info");
            // Get the mobile navigation overlay
            var overlay = document.getElementById("mobilebar_overlay");
            // Get the button that closes the mobile menu
            var closeButton = mobileMenu.querySelector("[data-mobile-menu-close-btn]");

            // Add click event listener to the open button
            openButton.addEventListener("click", function(event) {
                event.stopPropagation(); // Prevent click event from propagating to the parent elements
                // Toggle the 'active' class on the mobile menu and overlay
                mobileMenu.classList.toggle("active");
                overlay.classList.toggle("active");
            });

            // Add click event listener to the close button
            closeButton.addEventListener("click", function(event) {
                event.stopPropagation(); // Prevent click event from propagating to the parent elements
                // Remove the 'active' class from the mobile menu and overlay
                mobileMenu.classList.remove("active");
                overlay.classList.remove("active");
            });

            // If you want to close the menu when clicking outside of it
            document.addEventListener("click", function(event) {
                // Check if the clicked element is not part of the mobile menu or the open button
                if (!mobileMenu.contains(event.target) && event.target !== openButton) {
                    // Close the menu by removing the 'active' class from the mobile menu and overlay
                    mobileMenu.classList.remove("active");
                    overlay.classList.remove("active");
                }
            });
        });
    </script>
    ------>
	<?php include '../includes/scripts.php'; ?>
	<!--- custom js link-->
    <script src="../customer_assets/js/script.js"></script>
    <!--- ionicon link-->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>