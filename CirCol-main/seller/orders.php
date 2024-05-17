<?php
    // Start the session
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['seller'])) {
        // Redirect to login page if not logged in
        header("Location: login.php");
        exit();
    }

    // Retrieve user information from session variable
    $user = $_SESSION['seller'];

    // Establish database connection
    $servername = "localhost"; // Change to your server name
    $username = "root"; // Change to your username
    $password = ""; // Change to your password
    $dbname = "circol"; // Change to your database name

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch notifications from admin_notifs table that don't have a value on seen_date
    $unseenNotificationCount = 0;
    $sql = "SELECT * FROM admin_notifs WHERE seen_date IS NULL";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Count the number of unseen notifications
        $unseenNotificationCount = $result->num_rows;
    }

    // Fetch notifications from admin_notifs table
    $notifications = array();
    $sql = "SELECT * FROM admin_notifs ORDER BY notif_date DESC, notif_time DESC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            // Add each notification to the array
            $notifications[] = $row;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Orders - CirCol</title>
    <link rel="shortcut icon" type="x-icon" href="../customer_assets/images/about.svg">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Include jsPDF library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script>
    

    <style>
        .modal-content{
            width: 100%;
        }

        /**My Orders Table CSS */
        .myh3{
            text-align: center;
            margin-top: -0.8rem;
            padding-bottom: 0.5rem;
            font-size: 24px;
            font-weight: 600;
        }
		.myorders {
            width: 100%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        .report{
            display: flex;
            margin-bottom: 1rem;
        }
        .form-select{
            width: 20%;
            margin-left: 5px;
        }
        .reportbtn button{
            margin-left: 5px;
            padding: 5.5px;
            font-size: 16px;
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
            padding: 0 15px;
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

        tr{
            text-align: center;
        }

        .order_img{
            display: inline;
        }


        #productPhotoModal{
            height: 200px;
            width: 200px;
        }
        .pinfo{
            text-align: center;
        }
        .ebuy_title{
            font-weight: 700;
            font-size: 14px;
        }
        .badge-number{
            margin-top: -5px;
        }

        @media print{
            #header {
                display: none !important;
                margin: 0;
                padding: 0 !important;
            }
            
            .pagetitle * {
                display: none;
            }
            .pagetitle  h1 * {
                display: none;
            }
            .myh3{
                font-size: 14px;
            }
            .report * {
                display: none;
            }

            .btn {
                background: none !important;
                color: black;
                border-color: none !important;
                font-size: 10px !important;
            }
            input[type="status"] * {
                display: none !important;
            }

            table {
                margin-top: -20px !important;
                border: 1px solid black;
                border-collapse: collapse;
                width: 100%;
                font-size: 12px !important;
            }

            .box{
                background: white !important;
                border: none !important;
                box-shadow: none !important;
            }

            th, td, tr{
                border: 1px solid gray;
                padding: 8px;
            }
            .track{
                display: none !important;
            }
            main{
                margin-top: -20px !important;
                height: 100%;
                background: white !important;
            }
            body{
                padding: 0 !important;
                background-color: white;
            }

            /* Modify margins */
            @page {
                margin: 10mm 2mm; /* Adjust the margin values as needed */
            }

            th {
                background-color: lightgray;
                font-size: 12px !important;
                border: 1px solid gray;
                padding: 8px;
            }

            td {
                border: 1px solid gray;
                padding: 8px;
            }

            /* Ensure table is visible and scrolls properly when printed */
            .box-body {
                display: block !important;
                height: auto !important; /* Reset height */
                overflow: visible !important; /* Allow content to overflow */
            }

            /* Ensure sticky header works properly when printed */
            .sticky th {
                position: relative !important;
                top: auto !important;
            }

            .sticky th::after {
                display: none; /* Hide sticky header border when printing */
            }
        }

        .notif-con{
            height: 100%;
            max-height: 400px;
            overflow: auto;
            padding: 10px;
        }

        .box-body{
            height: 650px; /* Set a fixed height for the tbody to enable scrolling */
            overflow: scroll; /* Enable vertical scrolling */
        }
        .sticky th{
            top: -2px;
            position: sticky;
        }
        .sticky th::after{
            content: '';
            width: 100%;
            height: 2px;
            position: absolute;
            bottom: 0;
            left: 0;
            background: black;
        }
    </style>
</head>


<body>
    <!-- Modal -->
    <div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
        <!-- Modal content -->
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="notificationModalLabel">Notification Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>CirCol ADMINS</h4>
                    <p id="notificationMessage"></p>
                    <p id="notificationDateTime"></p>
                </div>
            </div>
        </div>
    </div>

    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="index.html" class="logo d-flex align-items-center">
                <img src="../customer_assets/images/logo/ebuy_logo.svg" alt="">
                <!-- <span class="d-none d-lg-block">BUMM</span> -->
            </a>
            
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <div class="search-bar">
            <form class="search-form d-flex align-items-center" method="POST" action="#">
                <input type="text" id="searchInput" name="query" placeholder="Search" title="Enter search keyword">
                <button type="submit" title="Search"><i class="bi bi-search"></i></button>
            </form>
        </div><!-- End Search Bar -->

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
                </li><!-- End Search Icon-->

                <li class="nav-item dropdown">
                    <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span class="badge bg-primary badge-number"><?php echo $unseenNotificationCount; ?></span>
                    </a><!-- End Notification Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
                        <li class="dropdown-header">
                            You have <span><?php echo $unseenNotificationCount; ?></span> new notifications
                            <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>

                        <div class="notif-con">
                            <?php foreach ($notifications as $notification) : ?>
                                <li class="notification-item" onclick="openNotificationModal(
                                        '<?php echo $notification['message']; ?>',
                                        '<?php echo $notification['notif_date']; ?>',
                                        '<?php echo $notification['notif_time']; ?>',
                                        '<?php echo $notification['id']; ?>' // Add notificationId here
                                    )">

                                    <i class="bi bi-info-circle text-primary"></i>
                                    <?php if (isset($notification['status']) && $notification['status'] == 'warning') : ?>
                                        <i class="bi bi-exclamation-circle text-warning"></i>
                                    <?php elseif (isset($notification['status']) && $notification['status'] == 'danger') : ?>
                                        <i class="bi bi-x-circle text-danger"></i>
                                    <?php elseif (isset($notification['status']) && $notification['status'] == 'success') : ?>
                                        <i class="bi bi-check-circle text-success"></i>
                                    <?php elseif (isset($notification['status']) && $notification['status'] == 'info') : ?>
                                        <i class="bi bi-info-circle text-primary"></i>
                                    <?php endif; ?>
                                    <div>
                                        <?php if (isset($notification['title'])) : ?>
                                            <h4><?php echo $notification['title']; ?></h4>
                                        <?php else : ?>
                                            <h6 class="ebuy_title">CirCol ADMINS</h6>
                                        <?php endif; ?>
                                        <?php if (isset($notification['message'])) : ?>
                                            <p><?php echo $notification['message']; ?></p>
                                        <?php else : ?>
                                            <p>Message not available</p>
                                        <?php endif; ?>
                                        <?php if (isset($notification['notif_date']) && isset($notification['notif_time'])) : ?>
                                            <p><?php echo date("F j, Y", strtotime($notification['notif_date'])); ?> <?php echo date("h:i a", strtotime($notification['notif_time'])); ?></p>
                                        <?php endif; ?>
                                    </div>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                            <?php endforeach; ?>
                        </div>

                        <li class="dropdown-footer">
                            <a href="#">Show all notifications</a>
                        </li>
                    </ul><!-- End Notification Dropdown Items -->
                </li><!-- End Notification Nav -->

                <li class="nav-item dropdown pe-3">

                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                        <?php if (isset($user)): ?>
                            <?php
                            // Display the user's profile photo from the "images" folder
                            $photoFilename = "../images/" . $user['photo'];

                            if (file_exists($photoFilename)) {
                                echo '<img src="' . $photoFilename . '" alt="Profile Photo" class="rounded-circle" style="max-width: 100px;">';
                            } else {
                                // Display a default profile photo if the file doesn't exist
                                echo '<img src="default-profile-photo.jpg" alt="Default Profile Photo" class="rounded-circle" style="max-width: 100px;">';
                            }
                            ?>
                            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $user['firstname'] ?></span>
                        <?php else: ?>
                            <!-- Default values if the user is not logged in -->
                            <img src="../assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
                            <span class="d-none d-md-block dropdown-toggle ps-2">Guest User</span>
                        <?php endif; ?>
                    </a><!-- End Profile Iamge Icon -->

                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
                        <li class="dropdown-header">
                            <h6><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></h6>
                            <span>Designer</span>
                        </li>
                        <li>
                        <hr class="dropdown-divider">
                        </li>

                        <li>
                        <a class="dropdown-item d-flex align-items-center" href="users-profile.php">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                        </li>
                        <li>
                        <hr class="dropdown-divider">
                        </li>

                        <li>
                        <a class="dropdown-item d-flex align-items-center" href="users-profile.php">
                            <i class="bi bi-gear"></i>
                            <span>Account Settings</span>
                        </a>
                        </li>
                        <li>
                        <hr class="dropdown-divider">
                        </li>

                        <li>
                        <a class="dropdown-item d-flex align-items-center" href="contactus.php">
                            <i class="bi bi-question-circle"></i>
                            <span>Need Help? Contact Us</span>
                        </a>
                        </li>
                        <li>
                        <hr class="dropdown-divider">
                        </li>

                        <li>
                        <a href="logout.php" class="dropdown-item d-flex align-items-center">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                        </li>

                    </ul><!-- End Profile Dropdown Items -->
                </li><!-- End Profile Nav -->

            </ul>
        </nav><!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link collapsed" href="home.php">
                <i class="bi bi-houses"></i>
                <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
                <a class="nav-link" data-bs-target="#components-nav" href="orders.php">
                <i class="bi bi-menu-button-wide"></i><span>Orders</span>
                </a>
            </li><!-- End Components Nav -->
            
            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" href="done_orders.php">
                <i class="bi bi-cart-check"></i><span>Done Orders</span>
                </a>
            </li><!-- End Components Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" href="product_list.php">
                    <i class="bi bi-journal-text"></i>
                <span>Product List</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-heading">Pages</li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="users-profile.php">
                <i class="bi bi-person"></i>
                <span>Profile</span>
                </a>
            </li><!-- End Profile Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="contactus.php">
                <i class="bi bi-envelope"></i>
                <span>Contact</span>
                </a>
            </li><!-- End Contact Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="logout.php">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Logout</span>
                </a>
            </li><!-- End Login Page Nav -->
        </ul>
    </aside><!-- End Sidebar-->

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Orders</h1>
            <nav>
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Orders</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->
        
        <!-- Main content -->
        <div class="myorders">
            <h3 class="myh3">ORDERS</h3>
            <div class="report">
                <select id="filterByMonth" class="form-select" aria-label="Default select example">
                    <option selected>Filter By Month</option>
                    <option value="0">ALL</option>
                    <option value="1">JANUARY</option>
                    <option value="2">FEBRUARY</option>
                    <option value="3">MARCH</option>
                    <option value="4">APRIL</option>
                    <option value="5">MAY</option>
                    <option value="6">JUNE</option>
                    <option value="7">JULY</option>
                    <option value="8">AUGUST</option>
                    <option value="9">SEPTEMBER</option>
                    <option value="10">OCTOBER</option>
                    <option value="11">NOVEMBER</option>
                    <option value="12">DECEMBER</option>
                </select>
                <div class="reportbtn" id="export_pdf">
                    <button class='btn btn-primary btn-sm'>EXPORT REPORT</button>
                </div>
            </div>

            <div class="box box-solid">
                <div class="box-body" id="tableWrapper">
                    <table class="table table-bordered sticky">
                        <?php
                            // Include database connection details
                            include_once 'db.php'; // Assuming db.php contains the database connection

                            // Check if $conn is set and not null
                            if ($conn) {
                                $seller_id = $user['id']; // Get the seller's ID from the session user
                                
                                // Prepare and execute the SQL query to retrieve orders for the seller
                                $stmt = $conn->prepare("SELECT * FROM orders WHERE seller_id = ? ORDER BY order_date DESC"); // Add ORDER BY clause
                                $stmt->bind_param("i", $seller_id);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if ($result->num_rows > 0) {
                                    // Display table header
                                    echo '
                                    <table class="table table-bordered sticky" id="orderTable">
                                        <thead>
                                            <tr>
                                                <th>User ID</th>
                                                <th>Product ID</th>
                                                <th>Quantity</th>
                                                <th>Total Price</th>
                                                <th>Order Date</th>
                                                <th>Status</th>
                                                <th class="track">Order Track</th>
                                                <th>Gcash Acc Name</th>
                                                <th>Gcash Refno</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbody">
                                    ';

                                    // Function to convert status number to text and corresponding color
                                    function getStatusInfo($status) {
                                        switch ($status) {
                                            case 0:
                                                return array('text' => 'Pending', 'color' => 'lightblue');
                                                break;
                                            case 1:
                                                return array('text' => 'Processing', 'color' => 'green');
                                                break;
                                            case 2:
                                                return array('text' => 'To PickUP', 'color' => 'gray');
                                                break;
                                            case 3:
                                                return array('text' => 'Received', 'color' => 'purple');
                                                break;
                                            case 4:
                                                return array('text' => 'Cancel', 'color' => 'red');
                                                break;
                                            default:
                                                return array('text' => 'Unknown', 'color' => 'black');
                                                break;
                                        }
                                    }

                                    // Loop through the fetched orders and display them in the table
                                    while ($row = $result->fetch_assoc()) {
                                        // Check if status is between 0 and 2
                                        if(($row['status'] >= 0 && $row['status'] <= 2) || $row['status'] === 4):
                                            $statusInfo = getStatusInfo($row['status']);
                                            echo "<tr>";
                                            echo "<td><button type='button' class='btn btn-info btn-sm' onclick='showUserInfo(" . $row['user_id'] . ")'>" . $row['user_id'] . "</button></td>";
                                            echo "<td style='display: none;'>" . $row['seller_id'] . "</td>";
                                            echo "<td><button type='button' class='btn btn-success btn-sm' onclick='showProductInfo(" . $row['product_id'] . ")'>" . $row['product_id'] . "</button></td>";
                                            echo "<td>" . $row['quantity'] . "</td>";
                                            echo "<td>" . $row['total_price'] . "</td>";
                                            echo "<td>" . $row['order_date'] . "</td>";
                                            echo "<td><button type='button' class='btn btn-primary btn-sm' style='background-color:" . $statusInfo['color'] . "' onclick='showStatusForm(" . $row['id'] . ")'>" . $statusInfo['text'] . "</button></td>";
                                            echo "<td class='track'><input type='date' class='form-control' id='pickupDate_" . $row['id'] . "' value='" . $row['order_track'] . "' onchange='updatePickupDate(" . $row['id'] . ")'></td>";
                                            echo "<td>" . $row['gcash_acc_name'] . "</td>";
                                            echo "<td>" . $row['gcash_refno'] . "</td>";
                                            echo "</tr>";
                                        endif;
                                    }

                                    // Close the table
                                    echo "</tbody></table>";

                                } else {
                                    // No orders found for the seller
                                    echo '<p>No orders found.</p>';
                                }

                                // Close the statement and connection
                                $stmt->close();
                                $conn->close();

                            } else {
                                // Database connection not available
                                echo "Database connection not available.";
                            }
                        ?>
                    </table>
                </div>
                <script>
                    window.addEventListener('DOMContentLoaded', function() {
                        var tableWrapper = document.getElementById('tableWrapper');
                        
                        // Check if the content of the table overflows the container
                        function checkOverflow() {
                            if (tableWrapper.scrollHeight > tableWrapper.clientHeight) {
                            tableWrapper.style.overflow = 'scroll'; // Display scrollbar
                            } else {
                            tableWrapper.style.overflow = 'hidden'; // Hide scrollbar
                            }
                        }

                        // Check overflow initially and on window resize
                        checkOverflow();
                        window.addEventListener('resize', checkOverflow);
                    });
                </script>
            </div>
        </div>
        <!-- MODAL FORM FOR CUSTOMER INFORMATION -->
        <div class="modal fade" id="userInfoModal" tabindex="-1" role="dialog" aria-labelledby="userInfoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userInfoModalLabel">User Information</h5>
                        <button type="button" class="close" aria-label="Close" onclick="closeUserModal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p><strong>First Name:</strong> <span id="firstName"></span></p>
                        <p><strong>Last Name:</strong> <span id="lastName"></span></p>
                        <p><strong>Email:</strong> <span id="email"></span></p>
                        <p><strong>Address:</strong> <span id="address"></span></p>
                        <p><strong>Contact Info:</strong> <span id="contactInfo"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeUserModal()">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- MODAL FORM FOR PRODUCT INFORMATION -->
        <div class="modal fade" id="productInfoModal" tabindex="-1" role="dialog" aria-labelledby="productInfoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="productInfoModalLabel">Product Information</h5>
                        <button type="button" class="close" aria-label="Close" onclick="closeProductModal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pinfo">
                        <div class="text-center">
                            <img id="productPhotoModal" src="" alt="Product Photo" class="img-fluid">
                        </div>
                        <p><strong>Name:</strong> <span id="productNameModal"></span></p>
                        <p><strong>Description:</strong> <span id="productDescriptionModal"></span></p>
                        <p><strong>Price:</strong> <span id="productPriceModal"></span></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeProductModal()">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- MODAL FORM FOR STATUS -->
        <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="statusModalLabel">Update Status</h5>
                        <button type="button" class="close" aria-label="Close" onclick="closeEditModal()">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="statusForm">
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="0">Pending</option>
                                    <option value="1">Processing</option>
                                    <option value="2">To PickUP</option>
                                    <option value="4">Cancel</option>
                                </select>
                            </div>
                            <input type="hidden" id="orderId" name="orderId">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeEditModal()">Close</button>
                        <button type="submit" class="btn btn-primary" onclick="updateStatus()">Update</button>
                    </div>
                </div>
            </div>
        </div>

            
        <!-- Include jsPDF library -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
        <!-- TABLE PRINT -->
        <script>
            document.addEventListener("DOMContentLoaded", () => {
                // Add event listener to the export button
                document.getElementById('export_pdf').addEventListener('click', function () {
                    // Get the table element
                    const table = document.getElementById('orderTable');

                    // Open print dialog
                    window.print();
                });
            });
        </script>
    </main><!-- End #main -->

    <!-- SEARCH BAR -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById('searchInput');
            const tableRows = document.querySelectorAll('#orderTable tbody tr');

            searchInput.addEventListener('input', function () {
                const searchTerm = searchInput.value.toLowerCase();
                tableRows.forEach(function (row) {
                    const textContent = row.textContent.toLowerCase();
                    if (textContent.includes(searchTerm)) {
                        row.style.display = 'table-row';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // When the modal is hidden (closed), reload the page
            $('#notificationModal').on('hidden.bs.modal', function (e) {
                location.reload();
            });
        });

        function openNotificationModal(message, notifDate, notifTime, notificationId) {
            // Update modal content with notification details
            var modalContent = `
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="notificationModalLabel">eBUy ADMINS</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>${message}</p>
                            <p>${formatDate(notifDate)} ${formatTime(notifTime)}</p>
                        </div>
                    </div>
                </div>
            `;
            // Update the modal with the new content
            document.getElementById("notificationModal").innerHTML = modalContent;
            // Show the modal
            $('#notificationModal').modal('show');

            // Make an AJAX request to update seen_date and seen_time
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "update_notification_seen.php?notificationId=" + notificationId, true);
            xhr.send();
        }

        // Function to format date as "Month Day, Year"
        function formatDate(dateString) {
            var options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(dateString).toLocaleDateString('en-US', options);
        }

        // Function to format time as "hh:mm am/pm"
        function formatTime(timeString) {
            var options = { hour: 'numeric', minute: 'numeric', hour12: true };
            return new Date('1970-01-01T' + timeString).toLocaleTimeString('en-US', options);
        }
    </script>
    
    <!-- FILTERED BY MONTH -->
    <script>
        document.getElementById("filterByMonth").addEventListener("change", function() {
            var selectedMonth = parseInt(this.value);
            var tableRows = document.querySelectorAll("#tbody tr");

            tableRows.forEach(function(row) {
                var orderDate = new Date(row.querySelector("td:nth-child(6)").textContent);
                
                if (selectedMonth === 0 || orderDate.getMonth() + 1 === selectedMonth) {
                    row.style.display = "table-row";
                } else {
                    row.style.display = "none";
                }
            });
        });
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Fetch User Info-->
    <script>
        function showUserInfo(userId) {
            $.ajax({
                url: 'getUserInfo.php',
                type: 'POST',
                data: { userId: userId },
                success: function(response) {
                    // Parse JSON response
                    var userInfo = JSON.parse(response);
                    // Populate modal with user information
                    $('#firstName').text(userInfo.firstname);
                    $('#lastName').text(userInfo.lastname);
                    $('#email').text(userInfo.email);
                    $('#address').text(userInfo.address);
                    $('#contactInfo').text(userInfo.contact_info);
                    // Show the modal
                    $('#userInfoModal').modal('show');
                }
            });
        }

        function closeUserModal() {
            // Close the modal
            $('#userInfoModal').modal('hide');
        }
    </script>

    <!-- Fetch Product Info-->
    <script>
        function showProductInfo(productId) {
            $.ajax({
                url: 'getProductInfo.php',
                type: 'POST',
                data: { productId: productId },
                success: function(response) {
                    // Parse JSON response
                    var productInfo = JSON.parse(response);
                    // Populate modal with product information
                    $('#productNameModal').text(productInfo.name);
                    $('#productDescriptionModal').text(productInfo.description);
                    $('#productPriceModal').text(productInfo.price);
                    $('#productPhotoModal').attr('src', productInfo.photo); // Set photo source
                    // Show the modal
                    $('#productInfoModal').modal('show');
                }
            });
        }

        function closeProductModal() {
            // Close the modal
            $('#productInfoModal').modal('hide');
        }
    </script>

    <!-- Fetch Status-->
    <script>
        function showStatusForm(orderId) {
            $('#statusModal').modal('show');
            $('#orderId').val(orderId);
        }

        function updateStatus() {
            var orderId = $('#orderId').val();
            var status = $('#status').val();

            $.ajax({
                url: 'updateOrderStatus.php',
                type: 'POST',
                data: { orderId: orderId, status: status },
                success: function(response) {
                    // Handle success response
                    if (status === '2') { // If status is "To PickUP"
                        // Save notification
                        saveNotification(orderId);
                    }
                    // Close the modal regardless of the status
                    closeEditModal();
                    // Reload the page if needed
                    if (status !== '4') { // If status is not "Cancel"
                        location.reload();
                    } else {
                        console.log("Order canceled successfully");
                        location.reload();
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(error);
                }
            });
        }

        // STORED IN NOTIFICATION TABLE
        function saveNotification(orderId) {
            var message = "Your order from our shop is ready to pickup";
            var currentDate = new Date().toISOString().slice(0, 10); // Get current date in YYYY-MM-DD format
            var currentTime = new Date().toLocaleTimeString('en-US', { hour12: false }); // Get current time in 24-hour format

            $.ajax({
                url: 'saveNotification.php',
                type: 'POST',
                data: { orderId: orderId, message: message, notifDate: currentDate, notifTime: currentTime },
                success: function(response) {
                    // Handle success response
                    console.log("Notification saved successfully");
                    location.reload(); // Reload the page after saving notification
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(error);
                }
            });
        }

        function closeEditModal() {
            // Close the modal
            $('#statusModal').modal('hide');
        }
    </script>

    <!-- Fetch Order Track-->
    <script>
        function updatePickupDate(orderId) {
            var pickupDate = $('#pickupDate_' + orderId).val();

            $.ajax({
                url: 'updatePickupDate.php',
                type: 'POST',
                data: { orderId: orderId, pickupDate: pickupDate },
                success: function(response) {
                    // Handle success response
                    // For example, reload the page or update the date display
                    location.reload();
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(error);
                }
            });
        }
    </script>

    <?php include 'includes/scripts.php'; ?>
    
    <!-- Script for User Drop Down -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Template Main JS File for Sidebar-->
    <script>
        (function() {
            "use strict";

            /**
             * Easy selector helper function
             */
            const select = (el, all = false) => {
            el = el.trim()
            if (all) {
                return [...document.querySelectorAll(el)]
            } else {
                return document.querySelector(el)
            }
            }

            /**
             * Easy event listener function
             */
            const on = (type, el, listener, all = false) => {
            if (all) {
                select(el, all).forEach(e => e.addEventListener(type, listener))
            } else {
                select(el, all).addEventListener(type, listener)
            }
            }

            /**
             * Sidebar toggle
             */
            if (select('.toggle-sidebar-btn')) {
            on('click', '.toggle-sidebar-btn', function(e) {
                select('body').classList.toggle('toggle-sidebar')
            })
            }
            
        })();
    </script>

</body>

</html>