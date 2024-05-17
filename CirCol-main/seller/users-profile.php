<?php
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['seller'])) {
        // Redirect to login page if not logged in
        header("Location: login.php");
        exit();
    }

    // Assuming you have a database connection, replace these values with your database credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "cirool"; // Change this to your actual database name

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

    // Fetch user details from the database based on the user ID stored in the session
    $user_id = $_SESSION['seller']['id']; // Assuming 'id' is the key for user ID in the session
    $sql = "SELECT * FROM users WHERE id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Close the database connection
        $conn->close();
    } else {
        // Redirect to the login page if the user is not found in the database
        header("Location: admin-login.php");
        exit();
    }

    // Handle Update form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];
        $email = $_POST['email'];
        $code = $_POST['twitter'];

        // Update user information in the database
        $sql = "UPDATE users SET firstname='$firstname', lastname='$lastname', address='$address', contact='$contact', email='$email', code='$code' WHERE id='$user_id'";
        $result = mysqli_query($conn, $sql);

        // Check if the update was successful
        if ($result) {
            echo "Profile updated successfully";
        } else {
            echo "Error updating profile: " . mysqli_error($conn);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>User Profile - EBUY</title>
  <link rel="shortcut icon" type="x-icon" href="../customer_assets/images/about.svg">
  <meta content="" name="description">
  <meta content="" name="keywords">
  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
    <style>
        .ebuy_title{
            font-weight: 700;
            font-size: 14px;
        }
        .badge-number{
            margin-top: -5px;
        }
        .search-bar{
            margin-top: 15px;
        }

        .col-md-8-2 img{
            width: 150px;
            height: 150px;
        }
        .pt-2 i{
            font-size: 16px;
            padding: 3px;
        }

        .qr-buttons{
            padding: 10px 0;
        }
        .col-md-4{
            font-weight: 600;
            color: rgba(1, 41, 112, 0.6);
        }

        .notif-con{
            height: 100%;
            max-height: 400px;
            overflow: auto;
            padding: 10px;
        }

        /** ALERT */
        .main-alert{
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .alert {
            display: flex;
            padding: 5px 20px;
            font-weight: 600;
            border-radius: 4px;
            border: none;
            outline: none;
            /* background: #e69100; */
            letter-spacing: 1px;
            position: fixed;
            z-index: 1000;
            top: -100%; /* Start from outside of the screen */
            text-align: center;
            animation: show_slide 1s ease forwards;
        }

        .hide {
            display: none;
        }

        .error_icon{
            padding: 0;
            font-size: 20px;
        }

        @keyframes show_slide {
            0% {
                top: -100%; /* Start from outside of the screen */
            }
            40% {
                top: 10%; /* Move in slightly */
            }
            80% {
                top: 0; /* Arrive at final position */
            }
            100% {
                top: 10px; /* Slight bounce effect */
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
            font-size: 18px;
            display: inline-block;
            padding: 2px 20px 0 10px;
        }

        .alert .close-btn {
            font-size: 20px;
            position: absolute;
            color: #155724;
            right: 0px;
            top: 50%;
            transform: translateY(-50%);
            padding: 0 5px;
            cursor: pointer;
            border: none;
            background-color: #d4edda !important;
        }

        .close-btn ion-icon{
            margin-top: 5px;
        }

        .alert .close-btn:hover {
            color: #ffc766;
        }

        .success {
            background: #d4edda; /* Green color for success alerts */
            color: #155724;
        }
        .success_icon ion-icon{
            color: #155724;
            margin-top: 2px;
            font-size: 25px;
        }
    </style>
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
                    <h4>eBUy ADMINS</h4>
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
                <a class="nav-link collapsed" data-bs-target="#components-nav" href="product_list.php">
                    <i class="bi bi-journal-text"></i>
                <span>Product List</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-heading">Pages</li>

            <li class="nav-item">
                <a class="nav-link" href="users-profile.php">
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
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                <img src="<?php echo (!empty($user['photo'])) ? '../images/'.$user['photo'] : '../images/profile.jpg'; ?>" alt="User Image" class="rounded-circle" style="max-width: 100px;">
                <span class="hidden-xs"><?php echo $user['firstname']; ?></span>

              <h3>Seller</h3>
              <div class="social-links mt-2">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-settings">Qr Code Update</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li>

              </ul>
              <div class="tab-content pt-2">

                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <h5 class="card-title">About</h5>
                  <p class="small fst-italic">
                  eBUy is an e-commerce platform established by four people, with the aim of bridging income generating projects in the form of 
                  merchandise selling of every organization in Bicol University, into a centralized avenue for e-commerce, for the students.
                  </p>

                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8"><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8"><?php echo $user['email']; ?></div>
                  </div>

                    <div class="row">
                        <div class="col-lg-3 col-md-4 label">Type</div>
                        <div class="col-lg-9 col-md-8">
                            <?php
                            $typeValue = $user['type'];
                            $typeText = '';

                            switch ($typeValue) {
                                case 0:
                                    $typeText = 'User';
                                    break;
                                case 1:
                                    $typeText = 'Admin';
                                    break;
                                case 2:
                                    $typeText = 'Seller';
                                    break;
                                default:
                                    $typeText = 'Unknown Type';
                                    break;
                            }

                            echo $typeText;
                            ?>
                        </div>
                    </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Address</div>
                    <div class="col-lg-9 col-md-8"><?php echo $user['address']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Phone</div>
                    <div class="col-lg-9 col-md-8"><?php echo $user['contact_info']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Shop Name</div>
                    <div class="col-lg-9 col-md-8"><?php echo $user['shop_name']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Gcash Number</div>
                    <div class="col-lg-9 col-md-8"><?php echo $user['gcash_number']; ?></div>
                  </div>
                </div>
                <!--- UPDATE FORM ---->
                <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                    <!--- PHOTO UPDATE FORM ---->
                    <form method="post" action="profile_image_update.php" enctype="multipart/form-data" id="updateForm" oninput="autoSubmit()">
                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

                        <div class="row mb-3">
                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                            <div class="col-md-8 col-lg-9">
                                <?php
                                    // Display the user's profile photo from the "images" folder
                                    $photoFilename = "../images/" . $user['photo'];

                                    if (file_exists($photoFilename)) {
                                        echo '<img src="' . $photoFilename . '" alt="Profile">';
                                    } else {
                                        // Display a default profile photo if the file doesn't exist
                                        echo '<img src="default-profile-photo.jpg" alt="Default Profile Photo" class="rounded-circle" style="max-width: 100px;">';
                                    }
                                ?>
                                <div class="pt-2">
                                    <label for="fileInput" class="btn btn-primary btn-sm" title="Upload new profile image">
                                        <i class="bi bi-upload"></i>
                                    </label>
                                    <input type="file" id="fileInput" name="fileInput" style="display: none" />
                                    
                                    <a href="#" class="btn btn-danger btn-sm" title="Remove my profile image"><i class="bi bi-trash"></i></a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <form method="post" action="userinfo_update.php" enctype="multipart/form-data" id="updateForm">
                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

                        <div class="row mb-3">
                            <label for="firstname" class="col-md-4 col-lg-3 col-form-label">First Name</label>
                            <div class="col-md-8 col-lg-9">
                                <input type="text" id="firstname" name="firstname" class="form-control" value="<?php echo $user['firstname']?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                        <label for="lastname" class="col-md-4 col-lg-3 col-form-label">Last Name</label>
                        <div class="col-md-8 col-lg-9">
                        <input type="text" id="lastname" name="lastname" class="form-control" value="<?php echo $user['lastname']?>">
                        </div>
                        </div>

                        <div class="row mb-3">
                        <label for="Address" class="col-md-4 col-lg-3 col-form-label">Address</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="address" type="text" class="form-control" id="address" value="<?php echo $user['address']?>">
                        </div>
                        </div>

                        <div class="row mb-3">
                        <label for="contact" class="col-md-4 col-lg-3 col-form-label">Phone</label>
                        <div class="col-md-8 col-lg-9">
                            <input name="contact" type="text" class="form-control" id="contact" value="<?php echo $user['contact_info']?>">
                        </div>
                        </div>

                        <div class="row mb-3">
                            <label for="Email" class="col-md-4 col-lg-3 col-form-label">Email</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="email" type="email" class="form-control" id="Email" value="<?php echo $user['email']?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="shop_name" class="col-md-4 col-lg-3 col-form-label">Shop Name</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="shop_name" type="text" class="form-control" id="shop_name" value="<?php echo $user['shop_name']?>">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="GcashNumber" class="col-md-4 col-lg-3 col-form-label">Gcash Number</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="gcash_number" type="text" class="form-control" id="GcashNumber" value="<?php echo $user['gcash_number']?>">
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" name="update" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form><!-- End Profile Edit Form -->
                </div>
                <!--- UPDATE FORM ---->

                <div class="tab-pane fade pt-3" id="profile-settings">
                    <!--- PHOTO GCASH QR UPDATE FORM ---->
                    <form method="post" action="gcash-qr-update.php" enctype="multipart/form-data" id="updateForm">
                        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

                        <div class="row mb-3">
                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Qr Code Gcash Image</label>
                            <div class="col-md-8-2 col-lg-9">
                                <?php
                                // Display the user's profile photo from the "images" folder
                                $photoFilename = "../images/Gcash_QR/" . $user['gcash_qr'];

                                if (file_exists($photoFilename)) {
                                    echo '<img src="' . $photoFilename . '" alt="Profile">';
                                } else {
                                    // Display a default profile photo if the file doesn't exist
                                    echo '<img src="default-profile-photo.jpg" alt="Default Profile Photo" class="rounded-circle" style="max-width: 100px;">';
                                }
                                ?>
                                <div class="pt-2">
                                    <input type="file" id="qr_fileInput" name="qr_fileInput"/>
                                    <div class="qr-buttons">
                                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                    <!-- Change Password Form -->
                    <form method="post" action="password_update.php">
                        <div class="row mb-3">
                            <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="password" type="password" class="form-control" id="currentPassword">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="newpassword" type="password" class="form-control" id="newPassword">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                            <div class="col-md-8 col-lg-9">
                                <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                            </div>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </div>
                    </form><!-- End Change Password Form -->
                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>

</main><!-- End #main -->

    <!-- Include jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">
        <div class="copyright">
        &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
        </div>
        <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Template Main JS File -->
    <script src="../assets/js/main.js"></script>

    <script>
        function submitForm() {
            document.getElementById('updateForm').submit();
        }

        // Function to automatically submit the form after 2000 milliseconds (2 seconds)
        function autoSubmit() {
            setTimeout(submitForm, 1000);
        }
    </script>
</body>

</html>