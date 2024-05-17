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

<?php
    // Include the file containing database connection details
    include_once 'db.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>ProductList</title>
    <link rel="shortcut icon" type="x-icon" href="../customer_assets/images/about.svg">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <style>
        .ebuy_title{
            font-weight: 700;
            font-size: 14px;
        }
        .badge-number{
            margin-top: -5px;
        }

        .modal-content{
            width: 100%;
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
        .box-header{
            padding-bottom: 10px;
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
                                            <h6 class="ebuy_title">eBUy ADMINS</h6>
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
                <a class="nav-link collapsed" data-bs-target="#components-nav" href="orders.php">
                <i class="bi bi-menu-button-wide"></i><span>Orders</span>
                </a>
            </li><!-- End Components Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" data-bs-target="#components-nav" href="done_orders.php">
                <i class="bi bi-cart-check"></i><span>Done Orders</span>
                </a>
            </li><!-- End Components Nav -->

            <li class="nav-item">
                <a class="nav-link" data-bs-target="#components-nav" href="product_list.php">
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
        <h1>Product List</h1>
        <nav>
            <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
            <li class="breadcrumb-item active">Product List</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <!-- Main content -->
    <section class="content">
        <?php
            if(isset($_SESSION['error'])){
            echo "
                <div class='alert alert-danger alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4><i class='icon fa fa-warning'></i> Error!</h4>
                ".$_SESSION['error']."
                </div>
            ";
            unset($_SESSION['error']);
            }
            if(isset($_SESSION['success'])){
            echo "
                <div class='alert alert-success alert-dismissible'>
                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                <h4><i class='icon fa fa-check'></i> Success!</h4>
                ".$_SESSION['success']."
                </div>
            ";
            unset($_SESSION['success']);
            }
        ?>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="#" data-toggle="modal" class="btn btn-primary btn-sm btn-flat" id="addproduct"><i class="fa fa-plus"></i> New</a>
                            </div>
                            <div class="col-md-6 text-right">
                                <form class="form-inline">
                                    <div class="form-group">
                                        <label>Category: </label>
                                        <!-- Add an id attribute to the select element for easy selection -->
                                        <select class="form-control input-sm" id="select_category">
                                            <option value="0">ALL</option>
                                            <?php
                                            // Fetch categories from the database
                                            if (isset($pdo)) {
                                                try {
                                                    $stmt = $pdo->prepare("SELECT * FROM category");
                                                    $stmt->execute();
                                                    foreach ($stmt as $crow) {
                                                        $selected = ($crow['id'] == $catid) ? 'selected' : '';
                                                        echo "<option value='" . $crow['id'] . "' $selected>" . $crow['name'] . "</option>";
                                                    }
                                                } catch (PDOException $e) {
                                                    echo "Database connection failed: " . $e->getMessage();
                                                }
                                            } else {
                                                echo "Database connection not available.";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- ADD FORM (Hidden by default) -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title"><b>Add New Product</b></h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="modalCloseBtn">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div class="modal-body">
                                    <form class="form-horizontal" method="POST" action="product-add.php" enctype="multipart/form-data">
                                        <div class="row">
                                            <label for="name" class="col-sm-1 control-label">Name</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" id="name" name="name" required>
                                            </div>

                                            <label for="category" class="col-sm-1 control-label">Category</label>
                                            <div class="col-sm-5">
                                                <select class="form-control" id="category" name="category" required>
                                                    <option value="" selected>- Select -</option>
                                                    <?php
                                                    // Check if $pdo is set and not null
                                                    if(isset($pdo)) {
                                                        try {
                                                            // Fetch categories from the database
                                                            $stmt = $pdo->prepare("SELECT * FROM category");
                                                            $stmt->execute();

                                                            // Loop through categories and display them in the dropdown
                                                            foreach ($stmt as $crow) {
                                                                $selected = ($crow['id'] == $catid) ? 'selected' : '';
                                                                echo "<option value='" . $crow['id'] . "' $selected>" . $crow['name'] . "</option>";
                                                            }
                                                        } catch (PDOException $e) {
                                                            // Handle database connection error
                                                            echo "<option value=''>Database connection failed: " . $e->getMessage() . "</option>";
                                                        }
                                                    } else {
                                                        echo "<option value=''>Database connection not available.</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <label for="price" class="col-sm-1 control-label">Price</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" id="price" name="price" required>
                                            </div>

                                            <label for="photo" class="col-sm-1 control-label">Photo</label>
                                            <div class="col-sm-5">
                                                <input type="file" id="photo" name="photo">
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <label for="name" class="col-sm-1 control-label">Stock</label>
                                            <div class="col-sm-5">
                                                <input type="text" class="form-control" id="stock" name="stock" required>
                                            </div>
                                        </div>

                                            <label for="description" class="col-sm-1 control-label">Description</label>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <textarea id="editor1" name="description" rows="10" cols="80" required></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary" name="submit">Save Changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Modal -->
                    <div class="modal fade" id="descriptionModal" tabindex="-1" role="dialog" aria-labelledby="descriptionModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="descriptionModalLabel">Product Description</h5>
                                    <button type="button" class="close" aria-label="Close" onclick="closeDescriptModal()">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body" id="descriptionModalBody">
                                    <!-- Description content will be inserted here -->
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeDescriptModal()">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Edit Product Modal -->
                    <div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                                    <button type="button" class="close" data-dismiss="modal" onclick="closeEditModal()">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="editProductForm">
                                    <div class="modal-body">
                                        <input type="hidden" id="editProductId" name="productId">
                                        <div class="form-group">
                                            <label for="editProductName">Name</label>
                                            <input type="text" class="form-control" id="editProductName" name="productName">
                                        </div>
                                        <div class="form-group">
                                            <label for="editProductStock">Stock</label>
                                            <input type="text" class="form-control" id="editProductStock" name="productStock">
                                        </div>
                                        <div class="form-group">
                                            <label for="editProductDescription">Description</label>
                                            <textarea class="form-control" id="editProductDescription" name="productDescription" rows="3"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="editProductSlug">Slug</label>
                                            <input type="text" class="form-control" id="editProductSlug" name="productSlug">
                                        </div>
                                        <div class="form-group">
                                            <label for="editProductPrice">Price</label>
                                            <input type="text" class="form-control" id="editProductPrice" name="productPrice">
                                        </div><br>
                                        <div class="form-group">
                                            <label for="editProductPhoto">Photo</label>
                                            <input type="file" class="form-control-file" id="editProductPhoto" name="productPhoto">
                                        </div>
                                        <!-- Add other fields as needed -->
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="closeEditModal()">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="box-body" id="tableWrapper">
                        <table id="example1" class="table table-bordered sticky">
                            <thead>
                            <th>Name</th>
                            <th>Photo</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Views Today</th>
                            <th style="display: none;">Category</th>
                            <th>Tools</th>
                            </thead>
                            <tbody>
                                <?php
                                    // Include the file containing database connection details
                                    include_once '../admin/db.php';

                                    // Check if $pdo is set and not null
                                    if (isset($pdo)) {
                                        try {
                                            // Fetch products data from the database for the logged-in user
                                            $stmt = $pdo->prepare("SELECT * FROM products WHERE seller_id = :seller_id");
                                            $stmt->execute(['seller_id' => $user['id']]);

                                            // Loop through the fetched data to display in the table
                                            foreach ($stmt as $row) {
                                                $image = (!empty($row['photo'])) ? '../images/Products/'.$row['photo'] : '../images/noimage.jpg';
                                                $counter = ($row['date_view'] == date('Y-m-d')) ? $row['counter'] : 0;

                                                echo "
                                                <tr>
                                                    <td>".$row['name']."</td>
                                                    <td>
                                                        <img src='".$image."' height='30px' width='30px'>
                                                        <span class='pull-right'><a href='#edit_photo' class='photo' data-toggle='modal' data-id='".$row['id']."'><i class='fa fa-edit'></i></a></span>
                                                    </td>
                                                    <td>
                                                        <button type='button' class='btn btn-info btn-sm btn-flat view-description' data-description='".htmlspecialchars($row['description'])."'>View</button>
                                                        <div style='display: none;' class='full-description'>".htmlspecialchars($row['description'])."</div>
                                                    </td>
                                                    <td>₱ ".number_format($row['price'], 2)."</td>
                                                    <td>".$counter."</td>
                                                    <td style='display: none;'>".$row['category_id']."</td>
                                                    <td>
                                                        <button class='btn btn-success btn-sm edit btn-flat' data-toggle='modal' data-target='#editProductModal' data-id='" . $row['id'] . "' data-name='" . $row['name'] . "' data-price='" . $row['price'] . "' data-stock='" . $row['stock'] . "'data-slug='" . $row['slug'] . "'data-description='" . $row['description'] . "'><i class='fa fa-edit'></i> Edit</button>
                                                        <button class='btn btn-danger btn-sm delete btn-flat' data-id='".$row['id']."' onclick='deleteProduct(" . $row['id'] . ")'><i class='fa fa-trash'></i> Delete</button>
                                                    </td>
                                                </tr>
                                                ";
                                            }
                                        } catch (PDOException $e) {
                                            echo $e->getMessage();
                                        }
                                    } else {
                                        echo "Database connection not available.";
                                    }
                                ?>
                            </tbody>
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
        </div>
    </section>
</main><!-- End #main -->

    <!-- SEARCH BAR -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const searchInput = document.getElementById('searchInput');
            const tableRows = document.querySelectorAll('#example1 tbody tr');

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

    <!------ <?php include 'includes/scripts.php'; ?> ------->

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

    <!-- For NEW button -->
    <script>
        // Trigger modal display when "New" button is clicked
        $(document).ready(function() {
        $('#addproduct').on('click', function() {
            $('#myModal').modal('show');
        });

        // Close the modal when "Close" button is clicked
        $('#modalCloseBtn, .btn-secondary').on('click', function() {
            $('#myModal').modal('hide');
            // Reset the form when the modal is closed
            $('#add')[0].reset();
        });
        });
    </script>

    <!-- For Filter Category -->
    <script>
        // Add event listener to select element
        document.getElementById('select_category').addEventListener('change', function() {
            var categoryId = this.value;
            filterProducts(categoryId);
        });

        // Function to filter products based on category ID
        function filterProducts(categoryId) {
            var rows = document.querySelectorAll('#example1 tbody tr');
            rows.forEach(function(row) {
                var categoryCell = row.querySelector('td:nth-child(6)'); // Assuming category ID is in the sixth column
                var category = categoryCell.textContent.trim();
                if (categoryId == 0 || category == categoryId) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>

    <!-- For product Description -->
    <script>
        $(document).ready(function(){
            $('.view-description').click(function(){
                var description = $(this).siblings('.full-description').text();
                $('#descriptionModalBody').text(description);
                $('#descriptionModal').modal('show');
            });
        });

        function closeDescriptModal() {
            $('#descriptionModal').modal('hide');
        }
    </script>

    <!-- For Edit/Update Product Information -->
    <!-- JavaScript to Fetch and Populate Product Details -->
    <script>
        $(document).ready(function() {
            $('.edit').on('click', function() {
                var productId = $(this).data('id');
                var productName = $(this).data('name');
                var productStock = $(this).data('stock');
                var productDescription = $(this).data('description');
                var productSlug = $(this).data('slug');
                var productPrice = $(this).data('price');
                // Populate modal form fields
                $('#editProductId').val(productId);
                $('#editProductName').val(productName);
                $('#editProductStock').val(productStock);
                $('#editProductDescription').val(productDescription);
                $('#editProductSlug').val(productSlug);
                $('#editProductPrice').val(productPrice);
                // Show the modal
                $('#editProductModal').modal('show');
            });
        });

        function closeEditModal() {
            // Hide the modal
            $('#editProductModal').modal('hide');
            // Reset form fields
            $('#editProductForm')[0].reset();
        }
    </script>

    <!-- JavaScript to Submit Edited Product Details -->
    <script>
        $(document).ready(function() {
            $('#editProductForm').submit(function(e) {
                e.preventDefault(); // Prevent the default form submission behavior
                var formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: 'edit_productInfo.php', // Ensure this URL is correct
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function(response) {
                        // Handle success
                        $('#editProductModal').modal('hide'); // Close the modal
                        // Optionally, you can reload the page to reflect the updated data
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        // Handle errors
                        console.error(xhr.responseText);
                    }
                });
            });
        });
    </script>

    <!-- JavaScript to Submit Dalete Product -->
    <script>
        function deleteProduct(productId) {
            if (confirm("Are you sure you want to delete this product?")) {
                $.ajax({
                    type: "POST",
                    url: "delete_product.php",
                    data: { product_id: productId },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            // Product deleted successfully, do something (e.g., reload the page)
                            location.reload();
                        } else {
                            // Handle error messages (e.g., display an alert)
                            alert(response.error);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Handle AJAX errors
                        console.error(xhr.responseText);
                    }
                });
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            if (!$.fn.DataTable.isDataTable('#example1')) {
                $('#example1').DataTable({
                    "lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]], // Define the options for number of entries to show
                    "searching": true // Enable searching
                });
            }
        });
    </script>
</body>
</html>